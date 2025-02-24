<?php

namespace Controller\Admin;

use DB;
use Pagination;
use Controller\AdminController;

class Subscriptions extends AdminController
{
    public function index()
    {
        // chart data current month
        $this_month_subscriptions = DB::query("select plan_id,start From subscriptions WHERE MONTH(start) = MONTH(now()) AND YEAR(start) = YEAR(now()) ORDER by start ASC");
        $subscptins = [];
        foreach ($this_month_subscriptions as $key => $val) {
            $date = date('Y-m-d', strtotime($val['start']));
            $subscptins[$date]['date'] = $date;
            if (isset($subscptins[$date]['plan'])) {
                $subscptins[$date]['plan'] += 1;
            } else {
                $subscptins[$date]['plan'] = 1;
            }
        }
        $data_arr = [];
        // for each day in the month
        for ($i = 1; $i <=  date('t'); $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $date = date('Y') . "-" . date('m') . "-" . $day;
            foreach ($subscptins as $val) {
                if ($date == $val['date']) {
                    $data_arr[$i]['x'] =  $val['date'];
                    $data_arr[$i]['y'] = $val['plan'];
                    break;
                } else {
                    $data_arr[$i]['x'] =  $date;
                    $data_arr[$i]['y'] = 0;
                }
            }
        }

        $sql = '';
        $filter = [];
        if (!empty($_GET['search']) && is_string($_GET['search'])) {
            $q = preg_replace('/[\\/\\\"\'`~^*$:,;?&|=({<%>})\[\]]+/', '', $_GET['search']);
            $sql = "WHERE (users.id = '$q' OR users.name REGEXP '$q' OR users.email REGEXP '$q' OR users.email = '$q')";
        } else if (isset($_GET['plan']) && is_numeric($_GET['plan'])) {
            $filter = ['plan_id' => $_GET['plan']];
            $sql = "WHERE plans.id = $_GET[plan]";
        } else if (isset($_GET['status']) && is_numeric($_GET['status'])) {
            $filter = ['status' => $_GET['status']];
            $sql = "WHERE subscriptions.status = $_GET[status]";
        }

        $uid = $this->uid;
        $limit = 50;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $subscriptions = DB::query("select subscriptions.*, users.name as user_name, plans.name as plan_name From subscriptions LEFT JOIN users ON subscriptions.user_id=users.id LEFT JOIN plans ON subscriptions.plan_id=plans.id $sql ORDER BY subscriptions.id DESC LIMIT $offset, $limit");
        $total = DB::count('subscriptions', $filter);
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);
        $plans = DB::select('plans', '*', [], 'ORDER BY duration, images, price');

        $this->title('Subscriptions');
        require_once APP . '/View/Admin/Subscriptions.php';
    }
}
