<?php

namespace Controller\User;

use DB;
use Uploader;
use Pagination;
use Controller\UserController;

class ImageGenerator extends UserController
{
    public function index()
    {
        if (!$this->setting['image_status']) $this->redirect("my");
        $user = $this->userDetails(['id' => $this->uid], 'plan_id, images_generated, words, images');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = $plan_result[0] ?? null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['description'])) {
            // check user openai apikey
            if (!empty($plan['own_api']) && $this->user['openai_status'] && !$this->user['openai_apikey']) $this->output(['error' => 'result_error', 'message' => "Please enter your OpenAI API key from your account details."]);

            // check usges
            $remaining_images = (int) ($user['images'] ?? 0);
            if ($remaining_images === 0) $this->output(['error' => 'no_credits']);
            // get default model
            $model = !empty($this->setting['default_chat_model']) ? $this->setting['default_chat_model'] : 'gpt-4o';
            $imageModel = !empty($this->setting['default_image_model']) ? $this->setting['default_image_model'] : 'dall-e-3';
            // get post
            $description = !empty($_POST['description']) ? $_POST['description'] : null;
            $variant = !empty($_POST['variant']) ? $_POST['variant'] : 1;
            $style = !empty($_POST['style']) && $_POST['style'] != 'none' ? ", $_POST[style] style" : null;
            $lighting = !empty($_POST['lighting']) && $_POST['lighting'] != 'none' ? ", $_POST[lighting] lighting" : null;
            $medium = !empty($_POST['medium']) && $_POST['medium'] != 'none' ? ", $_POST[medium] type" : null;
            $mood = !empty($_POST['mood']) && $_POST['mood'] != 'none' ? ", $_POST[mood] mood" : null;
            // generate prompts
            if (empty($_POST['prompt'])) {
                $messages[0]['role'] = "system";
                $messages[0]['content'] = "Act you are a good prompt writer. I will give you my image description. Write a better image prompt following my description. Response with plain text format.";
                $messages[1]['role'] = "user";
                $messages[1]['content'] = "Write a best image description following my image description.\n\n" . $description;
                $posts['messages'] = $messages;
                $posts['model'] = $model;
                $posts['temperature'] = 0.5;
                $posts['max_tokens'] = 300;
                $results = $this->openai('chat/completions', $posts);
            }
            $prompt = !empty($results['choices'][0]['message']['content']) ? $results['choices'][0]['message']['content'] : $description;
            // post
            $post['model'] = $imageModel;
            $post['prompt'] = $prompt . $style . $lighting . $medium . $mood;
            $post['size'] = '1024x1024';
            $post['response_format'] = 'b64_json';
            if ($post['model'] == 'dall-e-3') {
                //$post['style'] = 'natural';
                //$post['quality'] = 'hd';
            }
            $results = $this->openai("images/generations", $post);
            if (empty($results)) $this->output(['error' => 'result_error']);
            if (isset($results['error'])) {
                $message = $this->rid == 1 ? $results['error']['message'] : null;
                $this->output(['error' => 'api_error', 'message' => $message]);
            }
            if (empty($results['data'])) $this->output(['error' => 'no_results']);
            foreach ($results['data'] as $key => $val) {
                if (!empty($val['b64_json'])) {
                    $fileId = md5(microtime(true) . rand()) . uniqid();
                    $config = [
                        'thumb' => [
                            'width' => 800,
                            'height' => 800,
                            'filename' => "$fileId-thumb",
                            'extension' => 'webp'
                        ]
                    ];
                    $imageData = base64_decode($val['b64_json']);
                    $fileName = "$fileId.png";
                    $savePath = DIR . "/images/$fileName";
                    if (file_put_contents($savePath, $imageData) === false) die("Failed to write image data to the file.");
                    $file['tmp_name'] = $savePath;
                    //$uploader = Uploader::image($file, $config);
                    $data['id'] = $fileId;
                    $data['user_id'] = $this->uid;
                    $data['description'] = $prompt;
                    //$data['thumb'] = $uploader['images']['thumb']['url'] ?? null;
                    $data['thumb'] = $this->url("images/$fileName");
                    DB::insert('images', $data);
                    $output["results"][$key] = $this->htmlOutput($data);
                }
            }
            // update usages
            $usage_images_result = DB::select('usages', 'id, images', ['user_id' => $this->uid, 'date' => date('Y-m-d')], 'LIMIT 1');
            if (!empty($usage_images_result[0])) {
                $usges_images = $usage_images_result[0]['images'] + $variant;
                DB::update('usages', ['images' => $usges_images], ['id' => $usage_images_result[0]['id']]);
            } else {
                DB::insert('usages', ['user_id' => $this->uid, 'images' => $variant, 'date' => date('Y-m-d')]);
            }
            // update user
            if (!is_null($remaining_images)) {
                $images_generated = $user['images_generated'] + $variant;
                $usges_images = $remaining_images >= $variant ? $remaining_images - $variant : 0;
                DB::update('users', ['images_generated' => $images_generated, 'images' => $usges_images], ['id' => $this->uid]);
            }

            $this->output($output ?? []);
        }

        // download image
        if (!empty($_GET['download'])) {
            $image = DB::select('images', '*', ['id' => $_GET['download'], 'user_id' => $this->uid], 'LIMIT 1');
            if (!$image) $this->redirect("my/image-generator", "Download unable! Image not found.", "error");
            $img = $image[0]['id'];
            $file = DIR . "/images/$img.png";
            $this->downloadFile($file);
        }

        // delete image
        if (!empty($_GET['del_id']) && is_string($_GET['del_id'])) {
            DB::delete('images', ['id' => $_GET['del_id']]);
            $img = $_GET['del_id'];
            $file = DIR . "/images/$img.png";
            $thumb_file = DIR . "/images/$img-thumb.webp";
            if (file_exists($file)) unlink($file);
            if (file_exists($thumb_file)) unlink($thumb_file);
            exit;
        }

        $limit = 48;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $images = DB::select('images', '*', ['user_id' => $this->uid], 'ORDER BY created DESC LIMIT ' . $offset . ',' . $limit);
        $total = DB::count('images', ['user_id' => $this->uid]);
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);
        $this->title('Image generator');
        require_once APP . '/View/User/ImageGenerator.php';
    }

    protected function output($arr)
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($arr);
        exit;
    }

    protected function htmlOutput($data)
    {
        return '<div class="col-6 col-xl-4 col-xxl-3 col-img">
        <div class="card lightbox-gallery">
        <img src="' . $data['thumb'] . '" class="card-img" data-toggle="lightbox"  data-src="' . $this->url($data['thumb']) . '" data-caption="' . htmlspecialchars($data['description']) . '">
        <div class="card-overlay">
        <div class="d-flex justify-content-center">
        <div>
        <a class="btn btn-sm btn-light" target="_blank" href="' . $this->url("my/image-generator?download=$data[id]") . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Download">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-download" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z" /><path d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z" /></svg>
        </a>
        </div>
        <div class="ms-2">
        <button type="button" class="btn btn-sm btn-light delete_img" data-id="' . $data['id'] . '" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Delete">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path></svg>
        </button>
        </div>
        </div>
        </div>
        </div>
        </div>';
    }

    public static function downloadFile($file)
    {
        if (file_exists($file)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($file) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));
            readfile($file);
            exit;
        }
    }
}
