<?php

namespace Controller\User;

use DB;
use Controller\UserController;

class ContentRewriter extends UserController
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
            $requests = DB::select('requests', 'prompt', ['id' => $_GET['id'], 'user_id' => $this->uid], 'LIMIT 1');
            $request = isset($requests['0']) ? $requests['0'] : null;
            if (empty($request)) exit;
            // request content
            $messages[0]['role'] = "system";
            $messages[0]['content'] = "You are a helpful assistant. Rewrite the provide text.";
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['text'])) {
            // check user openai apikey
            if (!empty($plan['own_api']) && $this->user['openai_status'] && !$this->user['openai_apikey']) $this->output(['error' => 'result_error', 'message' => "Please enter your OpenAI API key from your account details."]);

            // check usges
            $remaining_words = isset($user['words']) ? (int) $user['words'] : null;
            if (!is_null($remaining_words) && $remaining_words == 0) $this->output(['error' => 'no_credits']);

            $text = isset($_POST['text']) && is_string($_POST['text']) ? strip_tags(trim($_POST['text'])) : null;
            $language = isset($_POST['language']) && is_string($_POST['language']) && $this->languages(strip_tags($_POST['language'])) ? strip_tags($_POST['language']) : 'English';
            $tone = isset($_POST['tone']) && is_string($_POST['tone']) && $this->tones(strip_tags($_POST['tone'])) ? $_POST['tone'] : null;
            $voice = !empty($tone) ? " with $tone tone of voice" : null;

            // check blacklist
            $blacklists = DB::select('blacklists', 'words', [], 'ORDER by words');
            if ($blacklists) {
                $black_list = null;
                foreach ($blacklists as $val) {
                    $black_list .= "$val[words]|";
                }
                if ($black_list) {
                    $blacklist = trim($black_list, '|');
                    $string = preg_replace('!\s+!', " ", $text);
                    if (preg_match_all("/\b($blacklist)\b/i", $string, $matches)) exit;
                }
            }

            // insert request
            $id = md5($this->uid . microtime(true) . rand()) . uniqid();
            $request['id'] = $id;
            $request['user_id'] = $this->uid;
            $request['prompt'] = "Rewrite the following content in $language language$tone.\n\n$text";
            $request['created'] = date('Y-m-d H:i:s');
            DB::insert('requests', $request);

            // output
            $output["id"] = $id;
            $output["credits"] = $remaining_words;
            $this->output($output);
        }

        $languages = $this->languages();
        $tones = $this->tones();
        $this->title('Content rewriter');
        require_once APP . '/View/User/ContentRewriter.php';
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

    protected function output($arr)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($arr);
        exit;
    }
}
