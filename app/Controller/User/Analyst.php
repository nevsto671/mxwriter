<?php

namespace Controller\User;

use DB;
use Controller\UserController;

class Analyst extends UserController
{
    public function index($analysisId = null)
    {
        $user = $this->userDetails(['id' => $this->uid], 'plan_id, words_generated, words, images');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;

        if ($analysisId) {
            $analysis = DB::select('analysis', '*', ['id' => $analysisId, 'user_id' => $this->uid], 'LIMIT 1');
            if (empty($analysis)) $this->redirect("my/analyst");
            $assistantId = isset($analysis[0]['assistant_id']) ? $analysis[0]['assistant_id'] : null;
            $threadId = isset($analysis[0]['thread_id']) ? $analysis[0]['thread_id'] : null;
            $chat_history = DB::select('chat_history', 'role, content', ['chat_id' => $analysisId], 'ORDER BY created ASC LIMIT 50');
            $file_history = DB::select('files', '*', ['assistant_id' => $assistantId], 'ORDER BY created DESC');

            // rename chat
            if (!empty($_POST['rename']) && !empty($_POST['rename_id'])) {
                $title = !empty($_POST['rename']) ? strip_tags(trim($_POST['rename'])) : 'New chat';
                DB::update('analysis', ['title' => $title], ['id' => $_POST['rename_id'], 'user_id' => $this->uid]);
                exit;
            }

            // delete chat history
            if (!empty($_POST['delete_id'])) {
                $this->delete($analysisId);
                $this->redirect("my/analyst");
            }

            // delete file
            if (!empty($_POST['delete_file_id'])) {
                $this->deleteFile($analysisId, $_POST['delete_file_id']);
                $this->redirect("my/analyst/$analysisId");
            }

            // upload file
            if (isset($_FILES['files'])) {
                $assistants = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
                $vectorStoreId = isset($assistants[0]['vector_store_id']) ? $assistants[0]['vector_store_id'] : null;
                $files = $this->uploadFiles($_FILES['files'], $assistantId);
                foreach ($files as $file) {
                    $vectorStores = $this->openai("vector_stores/$vectorStoreId/files", ['file_id' => $file['fileId']]);
                }
                sleep(3);
                $this->output(["id" => $analysisId, 'files' => $files]);
            }
        }

        if ($analysisId && isset($_GET['id']) && is_string($_GET['id'])) {
            $content = '';
            $tokenCount = 0;
            // // check event
            if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'text/event-stream') === false) $this->redirect("my");
            // get chat history
            $chat_history = DB::select('chat_history', 'role, content', ['chat_id' => $analysisId], 'ORDER BY created DESC LIMIT 1');
            $messages = !empty($chat_history[0]) ? $chat_history[0] : null;
            $this->openai("threads/$threadId/messages", $messages);
            $post['assistant_id'] = $assistantId;
            $post['stream'] = true;
            $this->openai("threads/$threadId/runs", $post, function ($curl, $data) use (&$content, &$tokenCount, &$analysisId) {
                $obj = json_decode($data);
                if ($obj && isset($obj->error->message) && $obj->error->message !== "") {
                    //error_log($obj->error->message);
                    $errorMessage = $this->rid == 1 ? "Error: " . $obj->error->message : "Something went wrong, please try again.";
                    echo "data: $errorMessage\n\n";
                    echo "data: [DONE]";
                    exit;
                } else {
                    $responses = explode('data: ', $data);
                    foreach ($responses as $responsePart) {
                        $response = json_decode($responsePart);
                        if ($response && isset($response->object) && $response->object === 'thread.message.delta') {
                            if (isset($response->delta->content) && is_array($response->delta->content)) {
                                foreach ($response->delta->content as $content_item) {
                                    if (isset($content_item->text->value)) {
                                        $tokenCount++;
                                        $text = preg_replace('/【\d+:\d†source】/', '', $content_item->text->value);
                                        $text = preg_replace('/【\d+:\d+†([^】]+)】/', ' [$1]', $text);
                                        $content .= $text;
                                        $text = str_replace("\n", "\\n", $text);
                                        echo "data: $text";
                                    }
                                }
                            }
                        } else if ($response && isset($response->status) && $response->status === 'failed') {
                            $errorMessage = $this->rid == 1 ? "Error: " . $response->last_error->message : "Something went wrong, please try again.";
                            echo 'data: {"choices":[{"delta":{"content":"' . $errorMessage . '"}}]}' . PHP_EOL . PHP_EOL;
                            echo "data: [DONE]";
                            $this->updateThreads($analysisId);
                            exit;
                        } else if (is_string($responsePart) && trim($responsePart) === '[DONE]') {
                            echo "data: [DONE]";
                        }
                    }
                }
                echo PHP_EOL . PHP_EOL;
                echo "Event:";
                echo PHP_EOL;
                @ob_flush();
                flush();
                return strlen($data);
            });

            // insert chat history
            DB::insert('chat_history', ['chat_id' => $analysisId, 'role' => 'assistant', 'content' => $content, 'created' => date('Y-m-d H:i:s')]);

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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['prompt'])) {
            // check assistant permission
            if (empty($plan['analyst'])) exit;

            // check user openai apikey
            if (!empty($plan['own_api']) && $this->user['openai_status'] && !$this->user['openai_apikey']) $this->output(['error' => 'result_error', 'message' => "Please enter your OpenAI API key from your account details."]);

            // check usges
            $remaining_words = isset($user['words']) ? (int) $user['words'] : null;
            if (!is_null($remaining_words) && $remaining_words == 0) $this->output(['error' => 'no_credits']);

            // insert chat history
            $content = isset($_POST['prompt']) ? $_POST['prompt'] : 'Hello';
            DB::insert('chat_history', ['chat_id' => $analysisId, 'role' => 'user', 'content' => $content, 'created' => date('Y-m-d H:i:s')]);

            // output
            $output["id"] = $analysisId;
            $output["credits"] = $remaining_words;
            $this->output($output);
        }

        // upload file
        if (isset($_FILES['files'])) {
            $analysisId = md5($this->uid . microtime(true) . rand()) . uniqid();
            // get default model
            $model = !empty($this->setting['default_analyst_model']) ? $this->setting['default_analyst_model'] : 'gpt-4o';
            // create assistants
            $assistantData = [
                "name" => "Analyst - $analysisId",
                "instructions" => "You are an expert data analyst. Your task is to analyze, summarize, and extract key insights from the provided documents. Always refer to yourself as 'Data Analyst'.",
                "model" => $model,
                "temperature" => 0.5,
                "tools" => [
                    ["type" => "file_search"]
                ]
            ];
            $assistants = $this->openai("assistants", $assistantData);
            $assistantId = !empty($assistants['id']) ? $assistants['id'] : null;
            if (isset($assistants['error']['message'])) {
                $errorMessage = $this->rid == 1 ? $assistants['error']['message'] : 'Something went wrong, please try again.';
                $this->output(['error' => $errorMessage]);
            }
            if (!$assistantId) $this->output(['error' => 'Something went wrong, please try again.']);
            DB::insert('assistants', ['id' => $assistantId, 'user_id' => $this->uid]);
            DB::insert('analysis', ['id' => $analysisId, 'user_id' => $this->uid, 'assistant_id' => $assistantId, 'title' => 'Untitle']);

            // create vector stores
            $vectorStoresData = [
                'name' => "Vector store for $assistantId",
                // 'expires_after' => [
                //     'anchor' => 'last_active_at',
                //     'days' => 30
                // ]
            ];
            $files = $this->uploadFiles($_FILES['files'], $assistantId);
            $vectorStores = $this->openai("vector_stores", $vectorStoresData);
            $vectorStoreId = !empty($vectorStores['id']) ? $vectorStores['id'] : null;
            foreach ($files as $file) {
                $vectorStores = $this->openai("vector_stores/$vectorStoreId/files", ['file_id' => $file['fileId']]);
            }

            // update assistants
            $updateAssistantData = [
                'tool_resources' => [
                    'file_search' => [
                        'vector_store_ids' => [$vectorStoreId]
                    ]
                ]
            ];
            $assistants = $this->openai("assistants/$assistantId", $updateAssistantData);
            $assistantId = !empty($assistants['id']) ? $assistants['id'] : null;
            DB::update('assistants', ['vector_store_id' => $vectorStoreId], ['id' => $assistantId]);

            // create thread
            $threads = $this->openai("threads", []);
            $threadId = !empty($threads['id']) ? $threads['id'] : null;
            DB::update('analysis', ['thread_id' => $threadId], ['id' => $analysisId]);
            sleep(3);
            $this->output(["id" => $analysisId, 'redirect' => $this->url("my/analyst/$analysisId")]);
        }

        // get chat list
        $chats = DB::select('analysis', 'id, title, created', ['user_id' => $this->uid], 'ORDER BY created DESC LIMIT 50');
        $this->title('Data Analyst');
        require_once APP . '/View/User/Analyst.php';
    }

    protected function output($arr)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($arr);
        exit;
    }

    protected function updateThreads($analysisId)
    {
        $analysis = DB::select('analysis', 'thread_id', ['id' => $analysisId, 'user_id' => $this->uid], 'LIMIT 1');
        if (empty($analysis)) return;
        $threadId = isset($analysis[0]['thread_id']) ? $analysis[0]['thread_id'] : null;
        $this->openaiDelete("threads/$threadId");
        $threads = $this->openai("threads", []);
        $threadId = !empty($threads['id']) ? $threads['id'] : null;
        DB::update('analysis', ['thread_id' => $threadId], ['id' => $analysisId]);
    }

    protected function uploadFiles($files, $assistantId = null)
    {
        $allowedMimeTypes = [
            'text/x-c',
            'text/x-csharp',
            'text/x-c++',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            'text/html',
            'text/x-java',
            'application/json',
            'text/markdown',
            'application/pdf',
            'text/x-php',
            'application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'text/x-python',
            'text/x-script.python',
            'text/x-ruby',
            'text/x-tex',
            'text/plain',
            'text/css',
            'text/javascript',
            'application/x-sh',
            'application/typescript'
        ];

        $results = [];
        foreach ($files['name'] as $index => $fileName) {
            $fileType = $files['type'][$index];
            if (!in_array($fileType, $allowedMimeTypes)) continue;
            $filePath = $files['tmp_name'][$index];
            $uploadFile = $this->openaiUpload($filePath, $fileName, 'assistants');
            $fileId = !empty($uploadFile['id']) ? $uploadFile['id'] : null;
            if ($fileId) {
                $results[$index]['fileId'] = $fileId;
                $results[$index]['fileName'] = $fileName;
                $results[$index]['fileExtension'] = pathinfo($fileName, PATHINFO_EXTENSION);
                DB::insert('files', ['id' => $fileId, 'name' => $fileName, 'user_id' => $this->uid, 'assistant_id' => $assistantId]);
            }
        }
        return $results;
    }

    protected function deleteFile($analysisId, $fileId)
    {
        $analysis = DB::select('analysis', '*', ['id' => $analysisId, 'user_id' => $this->uid], 'LIMIT 1');
        if (empty($analysis)) return null;
        $assistantId = isset($analysis[0]['assistant_id']) ? $analysis[0]['assistant_id'] : null;
        $assistants = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
        $vectorStoreId = isset($assistants[0]['vector_store_id']) ? $assistants[0]['vector_store_id'] : null;
        $this->openaiDelete("vector_stores/$vectorStoreId/files/$fileId");
        $this->openaiDelete("files/$fileId");
        DB::delete('files', ['id' => $fileId, 'assistant_id' => $assistantId]);
    }

    protected function delete($analysisId)
    {
        $analysis = DB::select('analysis', '*', ['id' => $analysisId, 'user_id' => $this->uid], 'LIMIT 1');
        if (empty($analysis)) return null;
        $assistantId = isset($analysis[0]['assistant_id']) ? $analysis[0]['assistant_id'] : null;
        $threadId = isset($analysis[0]['thread_id']) ? $analysis[0]['thread_id'] : null;
        $assistants = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
        $vectorStoreId = isset($assistants[0]['vector_store_id']) ? $assistants[0]['vector_store_id'] : null;
        $files = DB::select('files', 'id', ['assistant_id' => $assistantId, 'user_id' => $this->uid]);
        $this->openaiDelete("assistants/$assistantId");
        $this->openaiDelete("threads/$threadId");
        $this->openaiDelete("vector_stores/$vectorStoreId");
        DB::delete('assistants', ['id' => $assistantId]);
        DB::delete('analysis', ['id' => $analysisId]);
        DB::delete('chat_history', ['chat_id' => $analysisId]);
        foreach ($files as $file) {
            $this->openaiDelete("files/$file[id]");
            DB::delete('files', ['id' => $file['id']]);
        }
    }
}
