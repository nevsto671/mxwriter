<?php

namespace Controller\Admin;

use DB;
use Helper;
use Pagination;
use Controller\AdminController;

class Pages extends AdminController
{
    public function index()
    {
        if (isset($_GET['add'])) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data['name'] = isset($_POST['name']) ? Helper::input($_POST['name']) : null;
                $data['title'] = !empty($_POST['title']) ? $_POST['title'] : null;
                $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
                $data['status'] =  isset($_POST['status']) ? 1 : 0;
                $slug = $data['name'] ? Helper::slug($data['name']) : null;
                // make unique slug
                $pages = DB::select('pages', 'id', ['slug' => $slug], 'LIMIT 1');
                if (!empty($pages)) {
                    $number = 1;
                    for ($i = 0; $i > $i++; $i++) {
                        $pages = DB::select('pages', 'id', ['slug' => $slug . '-' . $number], 'LIMIT 1');
                        if (empty($pages)) break;
                        $number++;
                    }
                    $slug = $slug . '-' . $number;
                }

                $data['slug'] = $slug;
                DB::insert('pages', $data);
                $this->redirect("admin/pages", "Page has been added successfully.");
            }
        } else if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
            $result = DB::select('pages', '*', ['id' => $_GET['edit']], 'LIMIT 1');
            $page = isset($result[0]) ? $result[0] : [];
            if (!$page) $this->redirect("admin/pages");
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $data['title'] = !empty($_POST['title']) ? $_POST['title'] : null;
                $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
                $data['status'] =  isset($_POST['status']) ? 1 : 0;
                DB::update('pages', $data, ['id' => $page['id']]);
                $this->redirect("admin/pages", "Your details were changed successfully.");
            }
        } else if (isset($_GET['delete']) && is_numeric($_GET['delete']) && isset($_GET['sign']) && $_GET['sign'] == md5($_GET['delete'])) {
            $page = DB::select('pages', 'deletable', ['id' => $_GET['delete']], 'LIMIT 1');
            if (isset($page[0]['deletable']) && $page[0]['deletable']) DB::delete('pages', ['id' => $_GET['delete']]);
            $this->redirect("admin/pages", "Page has been deleted successfully.");
        } else {
            $limit = 50;
            $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page * $limit) - $limit;
            $pages = DB::select('pages', 'id, name, title, slug, status', [], 'ORDER BY name ASC LIMIT ' . $offset . ',' . $limit);
            $pager = new Pagination($page, $limit);
            $total = DB::count('pages');
            $pager->total($total);
            $pagination = $pager->execute(true);
        }
        $this->title('Page setting');
        require_once APP . '/View/Admin/Pages.php';
    }
}
