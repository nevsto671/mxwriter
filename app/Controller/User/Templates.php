<?php

namespace Controller\User;

use DB;
use Pagination;
use Controller\UserController;

class Templates extends UserController
{
    public function index($slug = null)
    {
        $user = $this->userDetails(['id' => $this->uid], 'plan_id, words_generated, words, images');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;

        if ($slug) {
            // delete history
            if (!empty($_GET['del_id']) && is_string($_GET['del_id'])) {
                DB::delete('history', ['id' => $_GET['del_id'], 'user_id' => $this->uid]);
                exit;
            }

            $templateId = array_slice(explode('-', $slug), -1)[0];
            $templateData['id'] = base64_decode($templateId);
            $result = DB::select('templates', '*', $templateData, 'LIMIT 1');
            $template = isset($result[0]) ? $result[0] : null;
            if (empty($template)) $this->redirect("my/templates");
            if ($template['status'] == 0 && $this->rid == 0 && $template['user_id'] != $this->uid) $this->redirect("my/templates");
            $template_id = isset($result[0]['id']) ? $result[0]['id'] : null;
            $brands = DB::select('brands', '*', ['user_id' => $this->uid]);
            // get model
            $models = DB::select('models', 'model', ['id' => $template['model']], 'LIMIT 1');
            $model =  isset($models[0]['model']) ? $models[0]['model'] : 'gpt-4o-mini';

            // redirect template
            if ($template_id == 1) $this->redirect("my/article-generator");
            if ($template_id == 63) $this->redirect("my/content-rewriter");

            // count prompt
            $prompt_results = DB::select('prompts', 'id', ['template_id' => $template_id], 'ORDER BY id ASC');
            $total_prompt = $prompt_results ? count($prompt_results) : 0;

            $limit = 10;
            $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page * $limit) - $limit;
            $histories = DB::select('history', '*', ['user_id' => $this->uid, 'template_id' => $template_id], 'ORDER BY created DESC LIMIT ' . $offset . ',' . $limit);
            $total = $histories ? count(DB::select('history', 'id', ['user_id' => $this->uid, 'template_id' => $template_id])) : 0;
            $pager = new Pagination($page, $limit);
            $pager->total($total);
            $pagination = $pager->execute(true);

            // get response
            if (isset($_GET['id']) && is_string($_GET['id'])) {
                // check event
                if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'text/event-stream') === false) $this->redirect("my/templates");

                // get history
                $history = DB::select('history', '*', ['id' => $_GET['id'], 'user_id' => $this->uid], 'LIMIT 1');
                $data = isset($history['0']) ? $history['0'] : null;
                if (empty($data)) exit;
                $brand_voice = $this->brandVoice($data['brand_id']);
                $voice_tone = !empty($data['tone']) ? "\nResponse with $data[tone] tone of voice." : null;
                $request_prompt = !empty($data['language']) ? "\nMust be response in $data[language] language. $voice_tone" : $voice_tone;
                $content = '';
                $tokenCount = 0;
                $files = DB::select('files', '*', ['assistant_id' => $template['assistant_id']]);
                if (!empty($files)) {
                    $refId = "tmp_" . md5($this->uid . $template_id);
                    $threadId = $this->createThreads($refId, $template['assistant_id']);
                    // user message
                    $messages['role'] = "user";
                    $messages['content'] = $data['prompt'];
                    $this->openai("threads/$threadId/messages", $messages);
                    $additional_messages[0]['role'] = "user";
                    $additional_messages[0]['content'] = $brand_voice . $request_prompt;
                    $post['additional_messages'] = $additional_messages;
                    $post['assistant_id'] = $template['assistant_id'];
                    $post['stream'] = true;
                    $this->openai("threads/$threadId/runs", $post, function ($curl, $data) use (&$content, &$tokenCount, &$threadId) {
                        $obj = json_decode($data);
                        if ($obj && isset($obj->error->message) && $obj->error->message !== "") {
                            //error_log($obj->error->message);
                            $errorMessage = $this->rid == 1 ? "Error: " . $obj->error->message : "Something went wrong, please try again.";
                            echo 'data: {"choices":[{"delta":{"content":"' . $errorMessage . '"}}]}' . PHP_EOL . PHP_EOL;
                            echo "data: [DONE]\n\n";
                            exit;
                        } else {
                            $responses = explode('data: ', $data);
                            foreach ($responses as $responsePart) {
                                $response = json_decode($responsePart);
                                if ($response && isset($response->object) && $response->object === 'thread.message.delta') {
                                    if (isset($response->delta->content) && is_array($response->delta->content)) {
                                        foreach ($response->delta->content as $content_item) {
                                            if (isset($content_item->text->value)) {
                                                $text = preg_replace('/\【.*?\】/', '', $content_item->text->value);
                                                $content .= $text;
                                                $text = str_replace("\n", "\\n", $text);
                                                echo 'data: {"choices":[{"delta":{"content":"' . $text . '"}}]}' . PHP_EOL . PHP_EOL;
                                                $tokenCount++;
                                            }
                                        }
                                    }
                                } else if ($response && isset($response->status) && $response->status === 'failed') {
                                    $errorMessage = $this->rid == 1 ? "Error: " . $response->last_error->message : "Something went wrong, please try again.";
                                    echo 'data: {"choices":[{"delta":{"content":"' . $errorMessage . '"}}]}' . PHP_EOL . PHP_EOL;
                                    echo "data: [DONE]\n\n";
                                    $this->updateThreads($threadId);
                                    exit;
                                } else if (is_string($responsePart) && trim($responsePart) === '[DONE]') {
                                    echo "data: [DONE]\n\n";
                                }
                            }
                        }
                        @ob_flush();
                        flush();
                        return strlen($data);
                    });
                } else {
                    $template_prompt = !empty($template['prompt']) ? $template['prompt'] : "You are a helpful assistant.";
                    // system message
                    $messages['system']['role'] = "system";
                    $messages['system']['content'] = $brand_voice . $template_prompt . $request_prompt;
                    // user message
                    $messages['user']['role'] = "user";
                    $messages['user']['content'] = $data['prompt'];
                    // request parameters
                    $post['messages'] = array_values($messages);
                    $post['model'] = $model;
                    $post['stream'] = true;
                    $post['temperature'] = (float) $data['temperature'];
                    if (!empty($template['max_tokens'])) $post['max_tokens'] = (int) $template['max_tokens'];
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
                                if (!empty($response)) {
                                    $response = json_decode($response);
                                    if ($data != "data: [DONE]\n\n" && isset($response->choices[0]->delta->content)) {
                                        $content .= $response->choices[0]->delta->content;
                                        $tokenCount++;
                                    }
                                }
                            }
                        }
                        @ob_flush();
                        flush();
                        return strlen($data);
                    });
                }

                // update history
                DB::update('history', ['text' => $content, 'prompt' => null], ['id' => $_GET['id']]);

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
                exit;
            }

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // check user openai apikey
                if (!empty($plan['own_api']) && $this->user['openai_status'] && !$this->user['openai_apikey']) $this->output(['error' => 'result_error', 'message' => "Please enter your OpenAI API key from your account details."]);

                // check premium template access permission
                if (!empty($template['premium']) && empty($plan['premium'])) $this->output(['error' => 'no_access']);

                // check usges
                $remaining_words = isset($user['words']) ? (int) $user['words'] : null;
                if (!is_null($remaining_words) && $remaining_words == 0) $this->output(['error' => 'no_credits']);

                // check prompt
                if (!$total_prompt) $this->output(['error' => 'result_error', 'message' => ($this->rid == 1 ? 'Prompt not found!' : null)]);

                // get user input
                $fields = isset($_POST['fields']) ? $_POST['fields'] : [];
                $brand_id = isset($_POST['brand']) && is_string($_POST['brand']) ? strip_tags($_POST['brand']) : 0;
                $creativity = isset($_POST['creativity']) && is_string($_POST['creativity']) ? strip_tags($_POST['creativity']) : null;
                $assistant = isset($_POST['assistant']) && is_string($_POST['assistant']) ? strip_tags($_POST['assistant']) : null;
                $language = isset($_POST['language']) && is_string($_POST['language']) && $this->languages(strip_tags($_POST['language'])) ? $_POST['language'] : null;
                $tone = isset($_POST['tone']) && is_string($_POST['tone']) && $this->tones(strip_tags($_POST['tone'])) ? $_POST['tone'] : null;
                $level = ['none' => '0', 'low' => '0.2', 'medium' => '0.6', 'high' => '0.8', 'max' => '1'];
                if (empty($template_id)) return null;
                $template = $this->templates($template_id);
                if (empty($template)) return null;
                if (!empty($template['fields'])) {
                    foreach (json_decode($template['fields'], true) as $key => $val) {
                        $data[$key]['type'] = $val['type'];
                        $data[$key]['key'] = $val['key'];
                        $data[$key]['label'] = $val['label'];
                        $data[$key]['data'] = isset($fields[$val['key']]) ? strip_tags($fields[$val['key']]) : '';
                    }
                }

                // make fields value
                $requestText = '';
                $trans = [];
                foreach ($fields as $key => $val) {
                    $trans["[$key]"] = $val;
                    $requestText .= "$val ";
                }

                // get prompt
                $offset = !empty($_POST['request']) && is_numeric($_POST['request']) ? $_POST['request'] - 1 : 0;
                $getPrompt = DB::select('prompts', 'command', ['template_id' => $template_id], "ORDER BY id ASC LIMIT $offset, 1");
                $prompt = !empty($getPrompt[0]['command']) ? strtr($getPrompt[0]['command'], $trans) : null;
                if (empty($prompt)) {
                    $getPrompt = DB::select('prompts', 'command', ['template_id' => $template_id], 'ORDER BY id ASC LIMIT 1');
                    $prompt = !empty($getPrompt[0]['command']) ? strtr($getPrompt[0]['command'], $trans) : null;
                    if (empty($prompt)) return null;
                }

                // check blacklist
                $blacklists = DB::select('blacklists', 'words', [], 'ORDER by words');
                if (!empty($blacklists)) {
                    $black_list = null;
                    foreach ($blacklists as $val) {
                        $black_list .= "$val[words]|";
                    }
                    if ($black_list) {
                        $blacklist = trim($black_list, '|');
                        $string = preg_replace('!\s+!', " ", $requestText);
                        if (preg_match_all("/\b($blacklist)\b/i", $string, $matches)) exit;
                    }
                }

                $temperature = $creativity == 'optimal' ? (isset($template['temperature']) ? $template['temperature'] : 1) : (isset($level[$creativity]) ? $level[$creativity] : 1);
                $brand = DB::select('brands', '*', ['id' => $brand_id, 'user_id' => $this->uid], 'LIMIT 1');
                if (empty($brand)) $brand_id = 0;

                // insert history
                $id = md5($this->uid . microtime(true) . rand()) . uniqid();
                $history['id'] = $id;
                $history['user_id'] = $this->uid;
                $history['template_id'] = $template_id;
                $history['brand_id'] = $brand_id;
                $history['prompt'] = $prompt;
                $history['data'] = isset($data) ? json_encode($data) : null;
                $history['language'] = $language;
                $history['tone'] = $tone;
                $history['temperature'] = $temperature;
                $history['assistant'] = $assistant;
                $history['created'] = date('Y-m-d H:i:s');
                DB::insert('history', $history);

                // add recent history
                DB::delete('recent_history', ['user_id' => $this->uid, 'template_id' => $template_id, 'type' => 'template']);
                DB::insert('recent_history', ['user_id' => $this->uid, 'template_id' => $template_id, 'type' => 'template']);

                // output
                $output["id"] = $id;
                $output["credits"] = $remaining_words;
                $this->output($output);
            }
        }

        $templates = $this->templates();
        $template_group = $this->template_group();
        $languages = $this->languages();
        $tones = $this->tones();
        $this->title('Templates');
        require_once APP . '/View/User/Templates.php';
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

    public function tones($tone = null)
    {
        if ($tone) {
            $result = DB::select('tones', '*', ['name' => $tone], 'LIMIT 1');
            return $result ? true : false;
        }
        $results = DB::select('tones', '*', ['status' => 1], 'ORDER by name ASC');
        return $results ? $results : [];
    }

    public function templates($id = null, $group = null)
    {
        if ($id) {
            $result = DB::query("select templates.*, models.model From templates LEFT JOIN models ON templates.model=models.id WHERE templates.id='$id' LIMIT 1");
            return isset($result[0]) ? $result[0] : [];
        }
        if ($group) $group = "GROUP BY group_name";
        $results = DB::query("select templates.*, models.model From templates LEFT JOIN models ON templates.model=models.id WHERE templates.status=1 AND (templates.user_id=0 OR templates.user_id=$this->uid) $group ORDER BY templates.title ASC");
        return isset($results) ? $results : [];
    }

    public function template_group()
    {
        $results = DB::query("select templates.*, models.model From templates LEFT JOIN models ON templates.model=models.id WHERE templates.status=1 AND (templates.user_id=0 OR templates.user_id=$this->uid) GROUP BY group_name ORDER BY templates.group_name ASC");
        return isset($results) ? $results : [];
    }

    protected function createThreads($refId, $assistantId)
    {
        $result = DB::select('threads', 'id', ['ref_id' => $refId, 'user_id' => $this->uid], 'LIMIT 1');
        $threadId = !empty($result[0]['id']) ? $result[0]['id'] : null;
        if (empty($threadId)) {
            $threads = $this->openai("threads", []);
            $threadId = !empty($threads['id']) ? $threads['id'] : null;
            if (empty($threadId)) return;
            DB::insert('threads', ['id' => $threadId, 'ref_id' => $refId, 'assistant_id' => $assistantId, 'user_id' => $this->uid]);
        }
        return $threadId;
    }

    protected function updateThreads($threadId)
    {
        $this->openaiDelete("threads/$threadId");
        $threads = $this->openai("threads", []);
        $newThreadId = !empty($threads['id']) ? $threads['id'] : null;
        if (empty($newThreadId)) return;
        DB::update('threads', ['id' => $newThreadId], ['id' => $threadId]);
        return $newThreadId;
    }

    protected function brandVoice($brandId)
    {
        $result = DB::select('brands', '*', ['id' => $brandId, 'user_id' => $this->uid], 'LIMIT 1');
        $brand = isset($result[0]) ? $result[0] : null;
        if (empty($brand)) return;
        $output = "Brand Overview:\n\n";
        $output .= "Name: $brand[name]\n";
        if (!empty($brand['industry'])) $output .= "Industry: $brand[industry]\n";
        if (!empty($brand['tagline'])) $output .= "Tagline: $brand[tagline]\n";
        if (!empty($brand['audience'])) $output .= "Target Audience: $brand[audience]\n";
        if (!empty($brand['website'])) $output .= "Website URL: $brand[website]\n";
        $output .= "Description: $brand[description]\n\n";
        $output .= "Your role is to engage users with responses that are consistent with the brand's identity, tone, and strategic goals. Ensure that all communications reflect the brand's core values and resonate with its target audience.\n\n";
        return $output;
    }

    protected function output($arr, $header = null)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($arr);
        exit;
    }
}
