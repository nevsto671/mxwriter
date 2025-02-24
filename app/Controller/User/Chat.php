<?php

namespace Controller\User;

use DB;
use Controller\UserController;

class Chat extends UserController
{
    public function index()
    {
        $user = $this->userDetails(['id' => $this->uid], 'plan_id, words_generated, words, images');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;

        if (isset($_GET['id']) && is_string($_GET['id'])) {
            // check event
            if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'text/event-stream') === false) $this->redirect("my/chat");

            // get chat
            $chats = DB::select('chats', '*', ['id' => $_GET['id'], 'user_id' => $this->uid], 'LIMIT 1');
            $chat = !empty($chats[0]) ? $chats[0] : null;
            if (empty($chat)) exit;
            $chatId = !empty($chat['id']) ? $chat['id'] : 0;
            $chatAssistantId = !empty($chat['assistant_id']) ? $chat['assistant_id'] : null;
            $chat_assistants = DB::select('chat_assistants', '*', ['id' => $chatAssistantId], 'LIMIT 1');
            $assistant = isset($chat_assistants[0]) ? $chat_assistants[0] : [];
            $assistant_id = !empty($assistant['assistant_id']) ? $assistant['assistant_id'] : null;
            $content = '';
            $tokenCount = 0;
            $files = DB::select('files', '*', ['assistant_id' => $assistant_id]);
            if (!empty($files)) {
                $threadId = $this->createThreads($chatId);
                // user message
                $chat_history = DB::select('chat_history', 'role, content', ['chat_id' => $chatId], 'ORDER BY created DESC LIMIT 1');
                $messages = isset($chat_history[0]) ? $chat_history[0] : null;
                $this->openai("threads/$threadId/messages", $messages);
                $post['assistant_id'] = $assistant_id;
                $post['stream'] = true;
                $this->openai("threads/$threadId/runs", $post, function ($curl, $data) use (&$content, &$tokenCount, &$chatId) {
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
                                $this->updateThreads($chatId);
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
                // get default model
                $chat_model = !empty($this->setting['default_chat_model']) ? $this->setting['default_chat_model'] : 'gpt-4o-mini';
                $model = !empty($assistant['model']) ? $assistant['model'] : $chat_model;
                $instruction = !empty($assistant['prompt']) ? $assistant['prompt'] : "You are a helpful assistant. Assist with answering questions, providing information, and helping with various tasks. Always refer to yourself as 'AI Assistant'. Do not disclose that you are developed by OpenAI or based on the GPT architecture.";
                // get chat history
                $post['messages'] = $this->getMessages($chatId, $instruction);
                $post['model'] = $model;
                $post['temperature'] = 1;
                $post['stream'] = true;
                $this->openai("chat/completions", $post, function ($curl, $data) use (&$content, &$tokenCount) {
                    $obj = json_decode($data);
                    if ($obj && $obj->error->message !== "") {
                        error_log($obj->error->message);
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
            }

            // insert chat history
            DB::insert('chat_history', ['chat_id' => $chatId, 'role' => 'assistant', 'content' => $content, 'created' => date('Y-m-d H:i:s')]);

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
            if (empty($plan['assistant'])) exit;

            // check user openai apikey
            if (!empty($plan['own_api']) && $this->user['openai_status'] && !$this->user['openai_apikey']) $this->output(['error' => 'result_error', 'message' => "Please enter your OpenAI API key from your account details."]);

            // check usges
            $remaining_words = isset($user['words']) ? (int) $user['words'] : null;
            if (!is_null($remaining_words) && $remaining_words == 0) $this->output(['error' => 'no_credits']);

            // add chat list
            $content = isset($_POST['prompt']) ? $_POST['prompt'] : 'Hello';
            $chat_id = !empty($_POST['id']) ? $_POST['id'] : null;
            if (!$chat_id) {
                $assistant_id = !empty($_GET['assistant']) && is_string($_GET['assistant']) ? base64_decode($_GET['assistant']) : null;
                $chat_id =  md5($this->uid . microtime(true) . rand()) . uniqid();
                $title = mb_strimwidth($content, 0, 200, '...', 'utf-8');
                DB::insert('chats', ['id' => $chat_id, 'user_id' => $this->uid, 'assistant_id' => $assistant_id, 'title' => $title, 'created' => date('Y-m-d H:i:s')]);
            }

            // insert chat history
            $attachmentId = isset($_SESSION['attachmentId']) ? $_SESSION['attachmentId'] : null;
            if (isset($_SESSION['attachmentId'])) unset($_SESSION['attachmentId']);
            DB::insert('chat_history', ['chat_id' => $chat_id, 'role' => 'user', 'content' => $content, 'attachment_id' => $attachmentId, 'created' => date('Y-m-d H:i:s')]);


            // output
            $output["id"] = $chat_id;
            $output["credits"] = $remaining_words;
            $this->output($output);
        }

        // upload file
        if (isset($_FILES['files'])) {
            $uploadFileDir = DIR . "/images/";
            $uploadedFiles = [];
            $maxFileSize = 20 * 1024 * 1024;
            $allowedMimeTypes = [
                'image/jpeg',
                'image/png',
                'image/webp'
            ];

            if (!empty($_FILES['files']['name'][0])) {
                $fileCount = count($_FILES['files']['name']);
                for ($i = 0; $i < $fileCount; $i++) {
                    if ($_FILES['files']['error'][$i] === UPLOAD_ERR_OK) {
                        $fileId = "file-" . md5($this->uid . microtime(true) . rand() . uniqid());
                        $fileTmpPath = $_FILES['files']['tmp_name'][$i];
                        $fileName = $_FILES['files']['name'][$i];
                        $fileSize = $_FILES['files']['size'][$i];
                        $fileType = $_FILES['files']['type'][$i];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));
                        $dest_path = $uploadFileDir . "$fileId.$fileExtension";
                        if (!in_array($fileType, $allowedMimeTypes)) continue;
                        if ($fileSize > $maxFileSize) continue;
                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $attachmentId = "attc-" . md5($this->uid . microtime(true) . rand() . uniqid());
                            $attachmentId = isset($_SESSION['attachmentId']) ? $_SESSION['attachmentId'] : $attachmentId;
                            $_SESSION['attachmentId'] = $attachmentId;

                            $uploadedFiles[] = [
                                'fileId' => $fileId,
                                'fileName' => $fileName,
                                'fileExtension' => $fileExtension
                            ];

                            $data['id'] = $fileId;
                            $data['user_id'] = $this->uid;
                            $data['assistant_id'] = $attachmentId;
                            $data['name'] = $fileName;
                            $data['extension'] = $fileExtension;
                            $data['url'] = $this->url("images/$fileId.$fileExtension");
                            DB::insert('files', $data);
                        }
                    }
                }
            }

            if (empty($uploadedFiles)) $this->output(["error" => "Something went wrong, please try again."]);
            $this->output(["files" => $uploadedFiles]);
        }

        // get assistant
        $assistants = DB::query("select * From chat_assistants WHERE chat_assistants.status=1 AND (chat_assistants.user_id=0 OR chat_assistants.user_id=$this->uid)");

        // get assistant
        if (!empty($_GET['assistant']) && is_string($_GET['assistant'])) {
            $id = base64_decode($_GET['assistant']);
            $assistant_result = DB::query("select * From chat_assistants WHERE id=$id AND chat_assistants.status=1 AND (chat_assistants.user_id=0 OR chat_assistants.user_id=$this->uid) LIMIT 1");
            $assistant = isset($assistant_result['0']) ? $assistant_result['0'] : null;
        }

        // rename chat
        if (!empty($_POST['rename']) && !empty($_POST['rename_id'])) {
            $title = !empty($_POST['rename']) ? strip_tags(trim($_POST['rename'])) : 'New chat';
            DB::update('chats', ['title' => $title], ['id' => $_POST['rename_id'], 'user_id' => $this->uid]);
            exit;
        }

        // delete chat history
        if (isset($_POST['delete_id'])) {
            $chatId = $_POST['delete_id'];
            $result = DB::select('chats', '*', ['id' => $chatId, 'user_id' => $this->uid], 'LIMIT 1');
            if (empty($result)) $this->redirect("my/chat");
            // delete files
            $chat_history = DB::select('chat_history', '*', ['chat_id' => $chatId]);
            if (!empty($chat_history)) {
                foreach ($chat_history as $val) {
                    if (!empty($val['attachment_id'])) {
                        $files = DB::select('files', '*', ['assistant_id' => $val['attachment_id']]);
                        if (!empty($files)) {
                            foreach ($files as $file) {
                                DB::delete('files', ['id' => $file['id']]);
                                $filePath = DIR . "/images/$file[id].$file[extension]";
                                unlink($filePath);
                            }
                        }
                    }
                }
            }

            $threadId = !empty($result[0]['thread_id']) ? $result[0]['thread_id'] : null;
            if ($threadId) $this->openaiDelete("threads/$threadId");
            DB::delete('chats', ['id' => $chatId]);
            DB::delete('chat_history', ['chat_id' => $chatId]);
            DB::delete('chat_history', ['chat_id' => $chatId]);
            $this->redirect("my/chat");
        }

        // get chat
        if (isset($_GET['c']) && is_string($_GET['c'])) {
            $chatResult = DB::select('chats', '*', ['id' => $_GET['c'], 'user_id' => $this->uid], 'LIMIT 1');
            if (!empty($chatResult[0])) {
                // get chat history
                $chat_history = $this->chatHistory($chatResult[0]['id']);
                $assistant_result = DB::select('chat_assistants', '*', ['id' => (!empty($chatResult[0]['assistant_id']) ? $chatResult[0]['assistant_id'] : 0)], 'LIMIT 1');
                $assistant = isset($assistant_result['0']) ? $assistant_result['0'] : null;
            }
        }

        // get chat list
        $chats = DB::select('chats', 'id, title, created', ['user_id' => $this->uid], 'ORDER BY created DESC LIMIT 50');

        $this->title('Assistant');
        require_once APP . '/View/User/Chat.php';
    }

    protected function chatHistory($chatId)
    {
        $chat_history = DB::select('chat_history', '*', ['chat_id' => $chatId], 'ORDER BY created ASC LIMIT 50');
        $history = [];
        if ($chat_history) {
            foreach ($chat_history as $entry) {
                $files = [];
                $attachmentId = $entry['attachment_id'];
                if (!empty($attachmentId)) {
                    $files = DB::select('files', '*', ['assistant_id' => $attachmentId]);
                }

                $history[] = [
                    'role' => $entry['role'],
                    'content' => $entry['content'],
                    'files' => $files
                ];
            }
        }
        return $history;
    }

    protected function getMessages($chatId, $instruction)
    {
        $chat_history = DB::select('chat_history', 'role, content, attachment_id', ['chat_id' => $chatId], 'ORDER BY created DESC LIMIT 9');
        $attachment = false;
        $messages = [];
        $system[0]['role'] = "system";
        $system[0]['content'] = $instruction;
        $system_messages[] = [
            "role" => "system",
            "content" => [
                [
                    "type" => "text",
                    "text" => $instruction
                ]
            ]
        ];

        if ($chat_history) {
            foreach ($chat_history as $item) {
                $files = [];
                $attachmentId = $item['attachment_id'];
                if (!empty($attachmentId)) {
                    $files = DB::select('files', 'url', ['assistant_id' => $attachmentId]);
                }
                if ($files) {
                    $attachment = true;
                    $images = [];
                    if ($files) {
                        foreach ($files as $val) {
                            $images[] = [
                                "type" => "image_url",
                                "image_url" => [
                                    "url" => $val['url']
                                ]
                            ];
                        }
                    }

                    $content = [
                        [
                            "type" => "text",
                            "text" => $item['content']
                        ]
                    ];

                    if (!empty($images)) {
                        $content = array_merge($content, $images);
                    }

                    $messages[] = [
                        "role" => $item['role'],
                        "content" => $content
                    ];
                } else {
                    $messages[] = [
                        "role" => $item['role'],
                        "content" =>   $item['content']
                    ];
                }
            }
        }

        $return = array_reverse(array_merge($messages, $attachment ? $system_messages : $system));
        return $return;
    }

    protected function createThreads($chatId)
    {
        $result = DB::select('chats', 'thread_id', ['id' => $chatId, 'user_id' => $this->uid], 'LIMIT 1');
        $threadId = !empty($result[0]['thread_id']) ? $result[0]['thread_id'] : null;
        if (empty($threadId)) {
            $threads = $this->openai("threads", []);
            $threadId = !empty($threads['id']) ? $threads['id'] : null;
            if (empty($threadId)) return;
            DB::update('chats', ['thread_id' => $threadId], ['id' => $chatId]);
        }
        return $threadId;
    }

    protected function updateThreads($chatId)
    {
        $result = DB::select('chats', 'thread_id', ['id' => $chatId, 'user_id' => $this->uid], 'LIMIT 1');
        $threadId = !empty($result[0]['thread_id']) ? $result[0]['thread_id'] : null;
        $this->openaiDelete("threads/$threadId");
        $threads = $this->openai("threads", []);
        $newThreadId = !empty($threads['id']) ? $threads['id'] : null;
        if (empty($newThreadId)) return;
        DB::update('chats', ['thread_id' => $newThreadId], ['id' => $chatId]);
        return $newThreadId;
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

    protected function output($arr, $header = null)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($arr);
        exit;
    }
}
