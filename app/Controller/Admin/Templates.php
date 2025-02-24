<?php

namespace Controller\Admin;

use DB;
use Helper;
use Controller\AdminController;

class Templates extends AdminController
{
    public function index()
    {
        // get default model
        $setting = $this->setting(['name' => 'default_chat_model']);
        $chat_model = !empty($setting['default_chat_model']) ? $setting['default_chat_model'] : 'gpt-4o-mini';

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $template_result = DB::select('templates', '*', ['id' => $_GET['id'], 'user_id' => 0], 'LIMIT 1');
            $template = isset($template_result[0]) ? $template_result[0] : null;
            if (!$template) $this->redirect("admin/templates");
            $files = DB::select('files', '*', ['assistant_id' => $template['assistant_id']], 'ORDER BY created ASC');
            $prompts = DB::select('prompts', '*', ['template_id' => $template['id']]);
            $template_fields = !empty($template['fields']) ? json_decode($template['fields'], true) : [];
            $fields = [];
            foreach ($template_fields as $key => $val) {
                $fields[$val['key']] = $val;
            }

            if (!empty($_GET['duplicate']) && $_GET['duplicate'] == md5($template['id'])) {
                $results = DB::select('templates', '*', ['id' => $template['id']], 'LIMIT 1');
                if (!empty($results[0])) {
                    unset($results[0]['id']);
                    $id = DB::insert('templates', $results[0]);
                    DB::update('templates', ['status' => 0], ['id' => $id]);
                    // get prompt
                    $results = DB::select('prompts', '*', ['template_id' => $template['id']]);
                    foreach ($results as $val) {
                        DB::insert('prompts', ['command' => $val['command'], 'template_id' => $id]);
                    }
                    if ($id) $this->redirect("admin/templates?id=$id", "A new template has been successfully created. You can now modify it to meet your needs.");
                }
                $this->redirect("admin/templates", "The system failed to create a duplicate template.", "error");
            }

            if (!empty($_POST['delete_template']) && $_POST['delete_template'] == md5($template['id'])) {
                $assistantId = !empty($template['assistant_id']) ? $template['assistant_id'] : null;
                if ($assistantId) {
                    $assistants = DB::select('assistants', 'vector_store_id, thread_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
                    $vectorStoreId = isset($assistants[0]['vector_store_id']) ? $assistants[0]['vector_store_id'] : null;
                    $threadId = isset($assistants[0]['thread_id']) ? $assistants[0]['thread_id'] : null;

                    $this->openaiDelete("assistants/$assistantId");
                    $this->openaiDelete("vector_stores/$vectorStoreId");
                    if ($threadId) $this->openaiDelete("threads/$threadId");

                    $files = DB::select('files', '*', ['assistant_id' => $assistantId]);
                    foreach ($files as $file) {
                        $this->openaiDelete("files/$file[id]");
                        DB::delete('files', ['id' => $file['id']]);
                    }
                }

                DB::delete('history', ['template_id' => $template['id']]);
                DB::delete('prompts', ['template_id' => $template['id']]);
                DB::delete('templates', ['id' => $template['id']]);
                $this->redirect("admin/templates", "Templates has been deleted successfully.");
            }
        }

        // delete file
        if (!empty($_POST['delete_file_id'])) {
            $fileId = isset($_POST['delete_file_id']) ? $_POST['delete_file_id'] : null;
            $assistantId = !empty($template['assistant_id']) ? $template['assistant_id'] : (isset($_SESSION['assistantId']) ? $_SESSION['assistantId'] : null);
            $assistant = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
            $vectorStoreId = isset($assistant[0]['vector_store_id']) ? $assistant[0]['vector_store_id'] : null;
            $this->openaiDelete("vector_stores/$vectorStoreId/files/$fileId");
            $this->openaiDelete("files/$fileId");
            DB::delete('files', ['id' => $fileId, 'assistant_id' => $assistantId]);
            $this->output(['status' => 'success']);
        }

        // upload file
        if (isset($_FILES['files'])) {
            $assistantId = !empty($template['assistant_id']) ? $template['assistant_id'] : (isset($_SESSION['assistantId']) ? $_SESSION['assistantId'] : null);
            $assistantResult = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $this->uid], 'LIMIT 1');
            $vectorStoreId = isset($assistantResult[0]['vector_store_id']) ? $assistantResult[0]['vector_store_id'] : null;
            if (empty($assistantResult[0])) {
                // get default model
                $setting = $this->setting(['name' => 'default_analyst_model']);
                $model = !empty($setting['default_analyst_model']) ? $setting['default_analyst_model'] : 'gpt-4o';
                // create assistants
                $assistantData = [
                    "name" => "Template - " . md5(time()),
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

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['title'])) {
            $postfields = !empty($_POST['fields']) ? $_POST['fields'] : null;
            $fields = [];
            if (!empty($postfields)) {
                foreach ($postfields as $key => $values) {
                    foreach ($values as $index => $value) {
                        $fields[$index][$key] = Helper::input($value);
                    }
                }
            }
            foreach ($fields as $index => $subArray) {
                if (empty($subArray['label'])) {
                    unset($fields[$index]);
                }
            }

            $data['title'] = Helper::input($_POST['title']);
            $data['slug'] = Helper::slug($_POST['title']);
            $data['prompt'] = !empty($_POST['system_prompt']) ? $_POST['system_prompt'] : null;
            $data['description'] = Helper::input($_POST['description']);
            $data['group_name'] = !empty($_POST['group_name']) ? Helper::input($_POST['group_name']) : "Others";
            $data['temperature'] = isset($_POST['temperature']) && $_POST['temperature'] >= 0 && $_POST['temperature'] <= 2 ? $_POST['temperature'] : null;
            $data['max_tokens'] = !empty($_POST['max_tokens']) ? $_POST['max_tokens'] : null;
            $data['fields'] = !empty($fields) ? json_encode($fields) : null;
            $data['model'] = isset($_POST['model']) ? $_POST['model'] : 4;
            $data['color'] = !empty($_POST['color']) ? $_POST['color'] : null;
            $data['icon'] = !empty($_POST['icon']) ? $_POST['icon'] : null;
            $data['help_text'] = !empty($_POST['help_text']) ? $_POST['help_text'] : null;
            $data['button_label'] = !empty($_POST['button_label']) ? $_POST['button_label'] : null;
            $data['language_label'] = !empty($_POST['language_label']) ? $_POST['language_label'] : null;
            $data['creativity_label'] = !empty($_POST['creativity_label']) ? $_POST['creativity_label'] : null;
            $data['tone_label'] = !empty($_POST['tone_label']) ? $_POST['tone_label'] : null;
            $data['language'] = isset($_POST['language']) ? 1 : 0;
            $data['creativity'] = isset($_POST['creativity']) ? 1 : 0;
            $data['tone'] = isset($_POST['tone']) ? 1 : 0;
            $data['landing'] = isset($_POST['landing']) ? 1 : 0;
            $data['premium'] = isset($_POST['premium']) ? 1 : 0;
            $data['status'] = isset($_POST['status']) ? 1 : 0;
            $data['modified'] = date('Y-m-d H:i:s');
            $data['assistant_id'] = !empty($template['assistant_id']) ? $template['assistant_id'] : (isset($_SESSION['assistantId']) ? $_SESSION['assistantId'] : null);
            if (isset($_SESSION['assistantId'])) unset($_SESSION['assistantId']);

            if (!empty($template)) {
                $id = $template['id'];
                DB::update('templates', $data, ['id' => $id]);
            } else {
                $id = DB::insert('templates', $data);
            }

            if ($id && !empty($_POST['prompt'])) {
                DB::delete('prompts', ['template_id' => $id]);
                foreach ($_POST['prompt'] as $val) {
                    if (!empty($val)) DB::insert('prompts', ['template_id' => $id, 'command' => $val]);
                }
            }

            if (!empty($data['assistant_id'])) {
                // get model name
                $models = DB::select('models', 'model', ['id' => $data['model']], 'LIMIT 1');
                $modelName =  isset($models[0]['model']) ? $models[0]['model'] : null;
                if ($modelName) $assistantData['model'] = $modelName;
                $assistantData['instructions'] = !empty($data['prompt']) ? $data['prompt'] : "Your task is to analyze, summarize, and extract key insights from the provided documents.";
                $assistants = $this->openai("assistants/$data[assistant_id]", $assistantData);
            }

            if ($id) $this->redirect("admin/templates?id=$id", "Template has been created successfully.");
            $this->redirect("admin/templates", "Something went wrong, please try again.", "error");
        }

        $models = DB::select('models', '*', ['type' => 'GPT', 'user_id' => 0]);
        $total = DB::count('templates', ['user_id' => 0]);
        $result_templates = DB::query("select templates.*, models.name as model_name From templates LEFT JOIN models ON templates.model=models.id WHERE templates.user_id=0 ORDER BY templates.group_name ASC, templates.title ASC");
        $group_templates = [];
        foreach ($result_templates as $key => $val) {
            $group = !empty($val['group_name']) ? $val['group_name'] : 'Others';
            $group_templates[$group][$key] = $val;
        }

        $this->title('Templates');
        require_once APP . '/View/Admin/Templates.php';
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
