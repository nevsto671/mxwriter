<?php

namespace Controller\Admin;

use DB;
use Pagination;
use Controller\AdminController;

class Transactions extends AdminController
{
    public function index()
    {
        // chart data current month
        $this_month_transactions = DB::query("select amount,tax,created From transactions WHERE payment_status=1 AND MONTH(created) = MONTH(now()) AND YEAR(created) = YEAR(now()) ORDER by created ASC");
        $trans = [];
        foreach ($this_month_transactions as $key => $val) {
            $date = date('Y-m-d', strtotime($val['created']));
            $trans[$date]['date'] = $date;
            if (isset($trans[$date]['amount'])) {
                $trans[$date]['amount'] += ($val['amount'] - $val['tax']);
            } else {
                $trans[$date]['amount'] = ($val['amount'] - $val['tax']);
            }
        }
        $data_arr = [];
        // for each day in the month
        for ($i = 1; $i <=  date('t'); $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $date = date('Y') . "-" . date('m') . "-" . $day;
            foreach ($trans as $val) {
                if ($date == $val['date']) {
                    $data_arr[$i]['x'] =  $val['date'];
                    $data_arr[$i]['y'] = number_format((float)$val['amount'], $this->setting['decimal_places'], '.', '');
                    break;
                } else {
                    $data_arr[$i]['x'] =  $date;
                    $data_arr[$i]['y'] = 0;
                }
            }
        }

        // current month total transactions calculate
        $current_month_total_earning = 0;
        $current_month_total_tax = 0;
        foreach ($this_month_transactions as $val) {
            $current_month_total_earning += $val['amount'] - $val['tax'];
            $current_month_total_tax += $val['tax'];
        }

        $limit = 50;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $transactions = DB::query("select transactions.*, users.name as user_name From transactions LEFT JOIN users ON transactions.user_id=users.id ORDER BY transactions.id DESC LIMIT $offset, $limit");
        $total = DB::count('transactions');
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);
        $this->title('Transactions');
        require_once APP . '/View/Admin/Transactions.php';
    }
}
