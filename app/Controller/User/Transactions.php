<?php

namespace Controller\User;

use DB;
use Pagination;
use Controller\UserController;

class Transactions extends UserController
{
    public function index()
    {
        $limit = 20;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $transactions = DB::select('transactions', '*', ['user_id' => $this->uid], 'ORDER BY id DESC LIMIT ' . $offset . ',' . $limit);
        $total = DB::count('transactions', ['user_id' => $this->uid]);
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);
        $this->title('Transaction history');
        require_once APP . '/View/User/Transactions.php';
    }
}
