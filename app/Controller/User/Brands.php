<?php

namespace Controller\User;

use DB;
use Pagination;
use Controller\UserController;

class Brands extends UserController
{
    public function index()
    {
        $user = $this->userDetails(['id' => $this->uid], 'plan_id');
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;

        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $result = DB::select('brands', '*', ['id' => $_GET['id'], 'user_id' => $this->uid], 'LIMIT 1');
            $brand = isset($result[0]) ? $result[0] : null;
            if (!$brand) $this->redirect("my/brands");
            if (empty($plan['brand'])) $this->redirect("my/brands");

            if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['delete_brand']) && $_POST['delete_brand'] == md5($brand['id'])) {
                DB::delete('brands', ['id' => $brand['id'], 'user_id' => $this->uid]);
                $this->redirect("my/brands", "The brand was deleted successfully.");
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name']) && $plan['brand']) {
            $data['name'] = isset($_POST['name']) ? $_POST['name'] : null;
            $data['industry'] = !empty($_POST['industry']) ? $_POST['industry'] : null;
            $data['tagline'] = !empty($_POST['tagline']) ? $_POST['tagline'] : null;
            $data['website'] = !empty($_POST['website']) ? $_POST['website'] : null;
            $data['audience'] = !empty($_POST['audience']) ? $_POST['audience'] : null;
            $data['description'] = !empty($_POST['description']) ? $_POST['description'] : null;
            $data['status'] =  isset($_POST['status']) ? 1 : 0;

            if (!empty($brand)) {
                $id = $brand['id'];
                DB::update('brands', $data, ['id' => $id]);
            } else {
                $data['user_id'] =  $this->uid;
                $id = DB::insert('brands', $data);
            }

            $this->redirect("my/brands", "The brand has been saved successfully.");
        }

        $limit = 50;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $brands = DB::select('brands', '*', ['user_id' => $this->uid], 'ORDER BY name ASC LIMIT ' . $offset . ',' . $limit);
        $pager = new Pagination($page, $limit);
        $total = DB::count('brands');
        $pager->total($total);
        $pagination = $pager->execute(true);

        $this->title('Brand Voice');
        require_once APP . '/View/User/Brands.php';
    }
}
