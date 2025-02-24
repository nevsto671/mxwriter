<?php

namespace Controller\Admin;

use DB;
use Helper;
use Uploader;
use Pagination;
use Controller\AdminController;

class Blogs extends AdminController
{
    public function index()
    {
        if (isset($_GET['add'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data['title'] = isset($_POST['title']) ? Helper::input($_POST['title']) : null;
                $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
                $data['status'] =  isset($_POST['status']) ? 1 : 0;
                $data['user_id'] = $this->uid;
                $slug = $data['title'] ? Helper::slug($data['title']) : null;
                // make unique slug
                $pages = DB::select('blogs', 'id', ['slug' => $slug], 'LIMIT 1');
                if (!empty($pages)) {
                    $number = 1;
                    for ($i = 0; $i > $i++; $i++) {
                        $pages = DB::select('blogs', 'id', ['slug' => $slug . '-' . $number], 'LIMIT 1');
                        if (empty($pages)) break;
                        $number++;
                    }
                    $slug = $slug . '-' . $number;
                }
                $data['slug'] = $slug;

                $config = [
                    'thumbnail' => [
                        'width' => 800,
                        'height' => 600,
                    ]
                ];

                $file = !empty($_FILES['image']) ? $_FILES['image'] : null;
                if ($file) {
                    $uploader = Uploader::image($file, $config);
                    $thumbnail = isset($uploader['images']['thumbnail']['url']) ? $uploader['images']['thumbnail']['url'] : null;
                    $data['thumbnail'] = $thumbnail;
                }

                DB::insert('blogs', $data);
                $this->redirect("admin/blogs", "Blog has been added successfully.");
            }
        } else if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $result = DB::select('blogs', '*', ['id' => $_GET['edit']], 'LIMIT 1');
            $blog = isset($result[0]) ? $result[0] : [];
            if (!$blog) $this->redirect("admin/blogs");
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data['title'] = !empty($_POST['title']) ? $_POST['title'] : null;
                $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
                $data['status'] =  isset($_POST['status']) ? 1 : 0;

                $config = [
                    'thumbnail' => [
                        'width' => 800,
                        'height' => 600,
                    ]
                ];

                if (!empty($_FILES['image']['tmp_name'])) {
                    $file = !empty($_FILES['image']) ? $_FILES['image'] : null;
                    $uploader = Uploader::image($file, $config);
                    $thumbnail = isset($uploader['images']['thumbnail']['url']) ? $uploader['images']['thumbnail']['url'] : null;
                    $data['thumbnail'] = $thumbnail;
                }

                DB::update('blogs', $data, ['id' => $blog['id']]);
                $this->redirect("admin/blogs", "Your details were changed successfully.");
            }
        } else if (isset($_GET['delete']) && is_numeric($_GET['delete']) && isset($_GET['sign']) && $_GET['sign'] == md5($_GET['delete'])) {
            DB::delete('blogs', ['id' => $_GET['delete']]);
            $this->redirect("admin/blogs", "Blog has been deleted successfully.");
        } else {
            $limit = 50;
            $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page * $limit) - $limit;
            $blogs = DB::select('blogs', 'id, title, slug, thumbnail, status, created', [], 'ORDER BY id DESC LIMIT ' . $offset . ',' . $limit);
            $pager = new Pagination($page, $limit);
            $total = DB::count('blogs');
            $pager->total($total);
            $pagination = $pager->execute(true);
        }
        $this->title('Blog post');
        require_once APP . '/View/Admin/Blogs.php';
    }
}
