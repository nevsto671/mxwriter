<?php

namespace Controller\User;

use DB;
use Pagination;
use Controller\UserController;

class History extends UserController
{
    public function index()
    {
        $uid = $this->uid;
        if ($uid && !empty($_GET['del_id']) && is_string($_GET['del_id'])) {
            $delete = DB::delete('history', ['id' => $_GET['del_id'], 'user_id' => $uid]);
            $setting = $this->settings(['remove_history']);
            if ($setting['remove_history']) {
                $history =  DB::query("SELECT id FROM history WHERE created <= NOW() - INTERVAL 30 DAY ORDER BY created DESC LIMIT 40, 1000");
                foreach ($history as $val) {
                    DB::delete('history', ['id' => $val['id']]);
                }
            }
            exit;
        }

        $sql = '';
        if (!empty($_GET['search']) && is_string($_GET['search'])) {
            $q = preg_replace('/[\\/\\\"\'`~^*$:,;?&|.=@({<%>})\[\]]+/', '', $_GET['search']);
            $sql = ' AND (history.text REGEXP "(' .  $q . ')" OR history.data REGEXP "(' .  $q . ')")';
        }

        $limit = 20;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $history = DB::query("select history.*,templates.title,templates.color,templates.icon From history LEFT JOIN templates ON history.template_id=templates.id WHERE history.user_id=$uid $sql ORDER BY history.created DESC LIMIT $offset, $limit");
        $total = !empty($history) ? count(DB::query("select id From history WHERE history.user_id=$uid $sql")) : 0;
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);
        $this->title('My History');
        require_once APP . '/View/User/History.php';
    }
}
