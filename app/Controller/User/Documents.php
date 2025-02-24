<?php

namespace Controller\User;

use DB;
use Pagination;
use Controller\UserController;

class Documents extends UserController
{
    public function index()
    {
        if ($this->uid && isset($_GET['name']) && !empty($_GET['doc_id']) && is_string($_GET['doc_id'])) {
            $name = !empty($_GET['name']) && is_string($_GET['name']) && trim($_GET['name']) ? strip_tags(trim($_GET['name'])) : 'New Document';
            $name = mb_strimwidth($name, 0, 200, '...', 'utf-8');
            DB::update('documents', ['name' => $name], ['id' => $_GET['doc_id'], 'user_id' => $this->uid]);
            exit;
        }

        if ($this->uid && !empty($_GET['del_id']) && is_string($_GET['del_id'])) {
            DB::delete('documents', ['id' => $_GET['del_id'], 'user_id' => $this->uid]);
            exit;
        }

        $sql = '';
        if (!empty($_GET['search']) && is_string($_GET['search'])) {
            $q = preg_replace('/[\\/\\\"\'`~^*$:,;?&|.=@({<%>})\[\]]+/', '', $_GET['search']);
            $sql = ' AND (documents.name REGEXP "(' .  $q . ')" OR documents.text REGEXP "(' .  $q . ')")';
        }

        $uid = $this->uid;
        $limit = 20;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $documents = DB::select('documents', '*', ['user_id' => $uid], '' . $sql . ' ORDER BY modified DESC LIMIT ' . $offset . ',' . $limit);
        $total = !empty($documents) ? count(DB::query("select id From documents WHERE documents.user_id=$uid $sql")) : 0;
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);

        $total_doc = DB::count("documents", ['user_id' => $uid]);
        $user = $this->userDetails(['id' => $this->uid], 'plan_id');
        $plan = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $doc_allow = isset($plan[0]['documents']) ? $plan[0]['documents'] : 10;
        $doc_over = !is_null($doc_allow) && $total_doc >= $doc_allow ? true : false;

        $this->title('Documents');
        require_once APP . '/View/User/Documents.php';
    }
}
