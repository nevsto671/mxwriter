<?php

namespace Controller\User;

use DB;
use Controller\UserController;

class ArticleGenerator extends UserController
{
    public function index()
    {
        $user = $this->userDetails(['id' => $this->uid], 'plan_id, words_generated, words, images');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;

        if (isset($_GET['id']) && is_string($_GET['id'])) {
            // check event
            if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'text/event-stream') === false) $this->redirect("my/templates");
            // get request
            $requests = DB::select('requests', '*', ['id' => $_GET['id'], 'user_id' => $this->uid], 'LIMIT 1');
            $request = isset($requests['0']) ? $requests['0'] : null;
            if (empty($request)) exit;
            // system message
            $messages[0]['role'] = "system";
            $messages[0]['content'] = $this->instruction();
            $messages[1]['role'] = "user";
            $messages[1]['content'] = $request['prompt'];
            // get default model
            $model = !empty($this->setting['default_article_model']) ? $this->setting['default_article_model'] : 'gpt-4o-mini';
            // request parameters
            $post['messages'] = $messages;
            $post['model'] = $model;
            $post['temperature'] = 1;
            $post['n'] = 1;
            $post['stream'] = true;
            $content = '';
            $tokenCount = 0;
            $this->openai("chat/completions", $post, function ($curl, $data) use (&$content, &$tokenCount) {
                $obj = json_decode($data);
                if ($obj && $obj->error->message !== "") {
                    //error_log($obj->error->message);
                    $errorMessage = $this->rid == 1 ? "Error: " . $obj->error->message : "Something went wrong, please try again.";
                    echo 'data: {"choices":[{"delta":{"content":"' . $errorMessage . '"}}]}' . PHP_EOL . PHP_EOL;
                    echo "data: [DONE]\n\n";
                    exit;
                } else {
                    echo $data;
                    $responses = explode('data: ', $data);
                    foreach ($responses as $response) {
                        $response = json_decode($response);
                        if ($data != "data: [DONE]\n\n" && isset($response->choices[0]->delta->content)) {
                            $content .= $response->choices[0]->delta->content;
                            $tokenCount++;
                        }
                    }
                }
                @ob_flush();
                flush();
                return strlen($data);
            });

            // token to word
            $wordCount = round($tokenCount * 0.75);

            // update user
            $remaining_words = isset($user['words']) ? (int) $user['words'] : null;
            if (!is_null($remaining_words)) {
                $words_generated = $user['words_generated'] + $wordCount;
                $remaining_words = $remaining_words >= $wordCount ? ($remaining_words - $wordCount) : 0;
                DB::update('users', ['words_generated' => $words_generated, 'words' => $remaining_words], ['id' => $this->uid]);
            }

            // update usages
            $usage_words_result = DB::select('usages', 'id, words', ['user_id' => $this->uid, 'date' => date('Y-m-d')], 'LIMIT 1');
            if (!empty($usage_words_result[0])) {
                $usges_words = $usage_words_result[0]['words'] + $wordCount;
                DB::update('usages', ['words' => $usges_words], ['id' => $usage_words_result[0]['id']]);
            } else {
                DB::insert('usages', ['user_id' => $this->uid, 'words' => $wordCount, 'date' => date('Y-m-d')]);
            }

            // delete request
            DB::delete('requests', ['id' => $_GET['id'], 'user_id' => $this->uid]);
            exit;
        }

        // save doc
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['text'])) {
            $total = DB::count('documents', ['user_id' => $this->uid]);
            $doc_allow = isset($plan['documents']) ? $plan['documents'] : 10;
            $doc_over = !is_null($doc_allow) && $total >= $doc_allow ? true : false;
            if ($doc_over) exit;

            $doc_id = !empty($_POST['doc']) && is_string($_POST['doc']) ? $_POST['doc'] : null;
            $text = isset($_POST['text']) && is_string($_POST['text']) ? $_POST['text'] : null;
            $name = !empty($_POST['name']) && is_string($_POST['name']) && trim($_POST['name']) ? strip_tags(trim($_POST['name'])) : 'New Document';
            $name = mb_strimwidth($name, 0, 200, '...', 'utf-8');
            $data['text'] = $text;
            $data['modified'] = date('Y-m-d H:i:s');
            if ($doc_id) {
                $document = DB::select('documents', '*', ['id' => $doc_id, 'user_id' => $this->uid], 'LIMIT 1');
                if ($document && $text) {
                    DB::update('documents', $data, ['id' => $doc_id]);
                    $this->output(['doc' => $doc_id]);
                    exit;
                }
            }

            $data['name'] = $name;
            $data['created'] = date('Y-m-d H:i:s');
            $data['user_id'] = $this->uid;
            $data['id'] =  md5($this->uid . microtime(true) . rand()) . uniqid();
            $docid = DB::insert('documents', $data);

            // update usages
            $usage_documents_result = DB::select('usages', 'id, documents', ['user_id' => $this->uid, 'date' => date('Y-m-d')], 'LIMIT 1');
            if (!empty($usage_documents_result[0])) {
                DB::update('usages', ['documents' => $usage_documents_result[0]['documents'] + 1], ['id' => $usage_documents_result[0]['id']]);
            } else {
                DB::insert('usages', ['user_id' => $this->uid, 'documents' => 1, 'date' => date('Y-m-d')]);
            }

            $this->output(['doc' => $data['id']]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title'])) {
            // check user openai apikey
            if (!empty($plan['own_api']) && $this->user['openai_status'] && !$this->user['openai_apikey']) $this->output(['error' => 'result_error', 'message' => "Please enter your OpenAI API key from your account details."]);

            // check usges
            $remaining_words = isset($user['words']) ? (int) $user['words'] : null;
            if (!is_null($remaining_words) && $remaining_words == 0) $this->output(['error' => 'no_credits']);

            $title = isset($_POST['title']) && is_string($_POST['title']) ? strip_tags(trim($_POST['title'])) : null;
            $keyword = !empty($_POST['keyword']) && is_string($_POST['keyword']) ? "\n\nPlease follow my keywords: " . strip_tags(trim($_POST['keyword'])) : null;
            $language = isset($_POST['language']) && is_string($_POST['language']) && $this->languages(strip_tags($_POST['language'])) ? $_POST['language'] : 'English';

            // check blacklist
            $blacklists = DB::select('blacklists', 'words', [], 'ORDER by words');
            if ($blacklists) {
                $black_list = null;
                foreach ($blacklists as $val) {
                    $black_list .= "$val[words]|";
                }
                if ($black_list) {
                    $blacklist = trim($black_list, '|');
                    $string = preg_replace('!\s+!', " ", $title);
                    if (preg_match_all("/\b($blacklist)\b/i", $string, $matches)) exit;
                }
            }

            // insert request
            $id = md5($this->uid . microtime(true) . rand()) . uniqid();
            $request['id'] = $id;
            $request['user_id'] = $this->uid;
            $request['prompt'] = "Must be write this article in $language language. Write an SEO-optimized long-form article with a minimum of 3000 words. Please use a minimum of 10 headings. The final paragraph should be a conclusion. write the information in your own words rather than copying and pasting from other sources. also double-check for plagiarism because I need pure unique content, write the content in a conversational style as if it were written by a human. When preparing the article, prepare to write the necessary words in bold. I want you to write content so that it can outrank other websites. Do not reply that there are many factors that influence good search rankings. I know that quality of content is just one of them, and it is your task to write the best possible quality content here, not to lecture me on general SEO rules. I give you the Title: $title $keyword";
            $request['created'] = date('Y-m-d H:i:s');
            DB::insert('requests', $request);

            // output
            $output["id"] = $id;
            $output["credits"] = $remaining_words;
            $this->output($output);
        }

        $languages = $this->languages();
        $this->title('Article generator');
        require_once APP . '/View/User/ArticleGenerator.php';
    }

    public function languages($language = null)
    {
        if ($language) {
            $result = DB::select('languages', '*', ['name' => $language], 'LIMIT 1');
            return $result ? true : false;
        }
        $results = DB::select('languages', '*', ['status' => 1], 'ORDER by name ASC');
        return $results ? $results : [];
    }

    protected function output($arr)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($arr);
        exit;
    }

    protected function instruction()
    {
        return "You are a professional content creator specializing in writing SEO-friendly long-form articles. Your task is to generate high-quality, engaging, and informative content that captivates readers and ranks well on search engines. Ensure that your responses are well-researched and structured with appropriate headings and subheadings. Seamlessly integrate relevant keywords and follow best practices in search engine optimization.
            **Requirements:**

            1. **Introduction:**
            - Craft a compelling introduction that captures the reader's attention.
            - Clearly state the purpose of the article and what the reader will learn.

            2. **Main Content:**
            - Divide the content into clear, logical sections with relevant headings and subheadings.
            - Ensure each section flows naturally into the next.
            - Include detailed information, statistics, examples, and quotes from reputable sources.
            - Use bullet points, numbered lists, and tables where appropriate for better readability.
            - Incorporate relevant keywords naturally throughout the content without keyword stuffing.

            3. **SEO Best Practices:**
            - Use keyword-rich headings and subheadings.
            - Optimize content for readability with short paragraphs and simple language.
            - Include internal and external links to authoritative sources.
            - Add alt text for any images mentioned in the content.
            - Use meta descriptions and tags effectively.

            4. **Conclusion:**
            - Summarize the key points discussed in the article.
            - Provide a clear and concise conclusion that reinforces the main takeaways.
            - Encourage reader engagement with a call-to-action (e.g., leave a comment, share the article).

            5. **Formatting:**
            - Ensure proper use of headings (H1, H2, H3, etc.), bold, italics, and other Markdown features.
            - Include any necessary code snippets or examples in appropriate code blocks.

            By following these guidelines, your content will be well-structured, informative, and optimized for search engines, ensuring a higher likelihood of ranking well and engaging readers.";
    }
}
