<?php

namespace Controller\User;

use DB;
use Uploader;
use Pagination;
use Controller\UserController;

class MyAssistants extends UserController
{
    public function index()
    {
        // get default model
        $chat_model = !empty($this->setting['default_chat_model']) ? $this->setting['default_chat_model'] : 'gpt-4o-mini';

        if (!empty($_FILES['thumbnail'])) {
            $uploader = Uploader::image($_FILES['thumbnail'], ['' => ['width' => 200, 'height' => 200]]);
            $url = isset($uploader['images']['']['url']) ? $uploader['images']['']['url'] : null;
            if (!empty($url)) echo json_encode(['url' => $url]);
            exit;
        }

        // allow to create assistants
        $totalMyAssistants = DB::count('chat_assistants', ['user_id' => $this->uid]);
        if (!empty($this->plan['my_assistant']) && (is_null($this->plan['total_assistants']) || $this->plan['total_assistants'] > $totalMyAssistants)) {
            $assistant_access = true;
        }

        if (isset($_GET['create']) && empty($assistant_access)) {
            $this->redirect("my/chat/assistants");
        }

        if (!empty($_GET['id']) && is_string($_GET['id'])) {
            $result = DB::select('chat_assistants', '*', ['id' => base64_decode($_GET['id']), 'user_id' => $this->uid]);
            $assistant = isset($result[0]) ? $result[0] : null;
            if (empty($assistant)) $this->redirect("my/chat/assistants");
            $files = DB::select('files', '*', ['assistant_id' => $assistant['assistant_id']], 'ORDER BY created ASC');

            if (isset($_POST['delete_assistant']) && $_POST['delete_assistant'] == md5($assistant['id'])) {
                $assistantId = !empty($assistant['assistant_id']) ? $assistant['assistant_id'] : null;
                if ($assistantId) {
                    $assistants = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
                    $vectorStoreId = isset($assistants[0]['vector_store_id']) ? $assistants[0]['vector_store_id'] : null;

                    $this->openaiDelete("assistants/$assistantId");
                    $this->openaiDelete("vector_stores/$vectorStoreId");

                    $files = DB::select('files', '*', ['assistant_id' => $assistantId]);
                    foreach ($files as $file) {
                        $this->openaiDelete("files/$file[id]");
                        DB::delete('files', ['id' => $file['id']]);
                    }

                    $chats = DB::select('chats', 'id, thread_id', ['assistant_id' => $assistant['id']]);
                    foreach ($chats as $chat) {
                        $this->openaiDelete("threads/$chat[thread_id]");
                    }
                }

                if (!empty($assistant['thumbnail'])) {
                    if (file_exists(DIR . "/" . $assistant['thumbnail'])) {
                        unlink(DIR . "/" . $assistant['thumbnail']);
                    }
                }

                DB::delete('chat_assistants', ['id' => $assistant['id']], 'LIMIT 1');
                $this->redirect("my/chat/assistants", "Assistant has been deleted successfully.");
            }
        }

        // delete file
        if (!empty($_POST['delete_file_id'])) {
            $fileId = isset($_POST['delete_file_id']) ? $_POST['delete_file_id'] : null;
            $assistantId = !empty($assistant['assistant_id']) ? $assistant['assistant_id'] : (isset($_SESSION['assistantId']) ? $_SESSION['assistantId'] : null);
            $assistant = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
            $vectorStoreId = isset($assistant[0]['vector_store_id']) ? $assistant[0]['vector_store_id'] : null;
            $this->openaiDelete("vector_stores/$vectorStoreId/files/$fileId");
            $this->openaiDelete("files/$fileId");
            DB::delete('files', ['id' => $fileId, 'assistant_id' => $assistantId]);
            $this->output(['status' => 'success']);
        }

        // upload file
        if (isset($_FILES['files'])) {
            $assistantId = !empty($assistant['assistant_id']) ? $assistant['assistant_id'] : (isset($_SESSION['assistantId']) ? $_SESSION['assistantId'] : null);
            $assistantResult = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
            $vectorStoreId = isset($assistantResult[0]['vector_store_id']) ? $assistantResult[0]['vector_store_id'] : null;
            if (empty($assistantResult[0])) {
                // get default model
                $model = !empty($this->setting['default_chat_model']) ? $this->setting['default_chat_model'] : 'gpt-4o-mini';
                // create assistants
                $assistantData = [
                    "name" => "Assistant - " . md5(time()),
                    "instructions" => "Your task is to analyze, summarize, and extract key insights from the provided documents.",
                    "model" => $model,
                    "temperature" => 0.5,
                    "tools" => [
                        ["type" => "file_search"]
                    ]
                ];
                $assistants = $this->openai("assistants", $assistantData);
                $assistantId = !empty($assistants['id']) ? $assistants['id'] : null;
                if (isset($assistants['error']['message'])) $this->output(['error' => $this->rid == 1 ? $assistants['error']['message'] : "Something went wrong, please try again."]);
                if (!$assistantId) $this->output(["error" => "Something went wrong, please try again."]);
                DB::insert('assistants', ['id' => $assistantId, 'user_id' => $this->uid]);
                // create vector stores
                $vectorStoresData = [
                    'name' => "Vector store for $assistantId"
                ];
                $vectorStores = $this->openai("vector_stores", $vectorStoresData);
                $vectorStoreId = !empty($vectorStores['id']) ? $vectorStores['id'] : null;

                // update assistants
                $updateAssistantData = [
                    'tool_resources' => [
                        'file_search' => [
                            'vector_store_ids' => [$vectorStoreId]
                        ]
                    ]
                ];
                $assistants = $this->openai("assistants/$assistantId", $updateAssistantData);
                DB::update('assistants', ['vector_store_id' => $vectorStoreId], ['id' => $assistantId]);
            }

            // upload 
            $files = $this->uploadFiles($_FILES['files'], $assistantId);
            foreach ($files as $file) {
                $vectorStores = $this->openai("vector_stores/$vectorStoreId/files", ['file_id' => $file['fileId']]);
            }

            if (session_status() == PHP_SESSION_NONE) session_start();
            $_SESSION['assistantId'] = $assistantId;
            if (!empty($template)) DB::update('templates', ['assistant_id' => $assistantId], ['id' => $template['id']]);

            $this->output(['files' => $files]);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data['name'] = !empty($_POST['name']) ? trim($_POST['name']) : null;
            $data['role'] = !empty($_POST['role']) ? trim($_POST['role']) : null;
            $data['group_name'] = !empty($_POST['group_name']) ? trim($_POST['group_name']) : null;
            $data['introduction'] = !empty($_POST['introduction']) ? $_POST['introduction'] : null;
            $data['prompt'] = !empty($_POST['prompt']) ? $_POST['prompt'] : null;
            $data['thumbnail'] = !empty($_POST['thumbnail']) ? $_POST['thumbnail'] : null;
            $data['model'] = !empty($_POST['model']) ? $_POST['model'] : $chat_model;
            $data['status'] =  isset($_POST['status']) ? 1 : 0;
            $data['user_id'] =  $this->uid;
            $data['assistant_id'] = !empty($assistant['assistant_id']) ? $assistant['assistant_id'] : (isset($_SESSION['assistantId']) ? $_SESSION['assistantId'] : null);
            if (isset($_SESSION['assistantId'])) unset($_SESSION['assistantId']);

            if (!empty($assistant['id'])) {
                $id = $assistant['id'];
                DB::update('chat_assistants', $data, ['id' => $id], 'LIMIT 1');
            } else {
                $id = DB::insert('chat_assistants', $data);
            }

            if (!empty($data['assistant_id'])) {
                if (!empty($data['model'])) $assistantData['model'] = $data['model'];
                $assistantData['instructions'] = !empty($data['prompt']) ? $data['prompt'] : "Your task is to analyze, summarize, and extract key insights from the provided documents.";
                $assistants = $this->openai("assistants/$data[assistant_id]", $assistantData);
            }

            $id = base64_encode($id);
            if (!empty($assistant['id'])) $this->redirect("my/chat/assistants?id=$id", "Your details were changed successfully.");
            $this->redirect("my/chat/assistants?id=$id", "Your details were added successfully.");
        }

        $limit = 50;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $assistants = DB::select('chat_assistants', '*', ['user_id' => $this->uid], 'ORDER BY name ASC LIMIT ' . $offset . ',' . $limit);
        $pager = new Pagination($page, $limit);
        $total = DB::count('chat_assistants', ['user_id' => $this->uid]);
        $pager->total($total);
        $pagination = $pager->execute(true);
        $models = DB::query("SELECT * FROM models WHERE type = 'GPT' AND (user_id = 0 OR user_id = $this->uid)");

        $this->title('My Assistants');
        require_once APP . '/View/User/MyAssistants.php';
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

    protected function output($arr)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($arr);
        exit;
    }
}
