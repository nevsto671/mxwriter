<?php

namespace Controller\Admin;

use DB;
use Pagination;
use Controller\AdminController;

class Dashboard extends AdminController
{

    public function index()
    {
        $usages = DB::query("select * From usages WHERE MONTH(date) = MONTH(now()) AND YEAR(date) = YEAR(now()) ORDER by date ASC");
        // chart data current month
        $data_arr = [];
        // for each day in the month
        for ($i = 1; $i <=  date('t'); $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $date = date('Y') . "-" . date('m') . "-" . $day;
            foreach ($usages as $val) {
                if ($date == $val['date']) {
                    $data_arr[$i]['x'] =  $val['date'];
                    $data_arr[$i]['y'] = $val['words'];
                    break;
                } else {
                    $data_arr[$i]['x'] =  $date;
                    $data_arr[$i]['y'] = 0;
                }
            }
        }

        // total usage calculate monthly
        $current_month_usage_words = 0;
        foreach ($usages as $val) {
            $current_month_usage_words += $val['words'];
        }

        $current_month_usage_images = 0;
        foreach ($usages as $val) {
            $current_month_usage_images += $val['images'];
        }

        $current_month_usage_docs = 0;
        foreach ($usages as $val) {
            $current_month_usage_docs += $val['documents'];
        }

        $current_month_total_subscriptions = DB::count("subscriptions", [], "WHERE MONTH(start) = MONTH(now()) AND YEAR(start) = YEAR(now()) ORDER by start ASC");
        $current_month_total_users = DB::count("users", [], "WHERE MONTH(created) = MONTH(now()) AND YEAR(created) = YEAR(now()) ORDER by created ASC");
        $current_month_total_transactions = DB::query("select * From transactions WHERE MONTH(created) = MONTH(now()) AND YEAR(created) = YEAR(now()) ORDER by created ASC");
        $current_month_total_earning = 0;
        foreach ($current_month_total_transactions as $val) {
            $current_month_total_earning += $val['amount'] - $val['tax'];
        }

        // count words
        $total_words_generated_data = DB::query("SELECT SUM(words_generated) FROM users");
        $total_words_generated = isset($total_words_generated_data[0]["SUM(words_generated)"]) ? $total_words_generated_data[0]["SUM(words_generated)"] : 0;
        // count images
        $total_images_generated_data = DB::query("SELECT SUM(images_generated) FROM users");
        $total_images_generated = isset($total_images_generated_data[0]["SUM(images_generated)"]) ? $total_images_generated_data[0]["SUM(images_generated)"] : 0;
        // count images
        $total_earning_data = DB::query("SELECT SUM(amount) FROM transactions WHERE status=1");
        $total_earning = isset($total_earning_data[0]["SUM(amount)"]) ? round($total_earning_data[0]["SUM(amount)"]) : 0;
        // count users
        $total_subscriber = DB::count('users', ['status' => 1]);

        // approve pending subscriptions
        if (isset($_GET['subscriptions_pending']) && !empty($_GET['invoice']) && isset($_GET['sign']) && $_GET['sign'] == md5($_GET['invoice'])) {
            $subscription_id = isset($_GET['invoice']) && is_numeric($_GET['invoice']) ? $_GET['invoice'] : null;
            $subscriptions_result = DB::select('subscriptions', '*', ['id' => $subscription_id, 'status' => 2], 'LIMIT 1');
            $subscription = isset($subscriptions_result[0]) ? $subscriptions_result[0] : null;
            if ($subscription) {
                $plan_id = isset($subscription['plan_id']) ? $subscription['plan_id'] : null;
                $user_id = isset($subscription['user_id']) ? $subscription['user_id'] : null;
                $update = $this->update_subscription($user_id, $plan_id, $subscription['transaction_id'], $subscription['id']);
                if ($update) {
                    DB::update('transactions', ['payment_status' => 1, 'status' => 1], ['id' => $subscription['transaction_id']]);
                    $this->redirect("admin#pending");
                }
            }
            $this->redirect("admin#pending");
        }

        // pending subscriptions
        $limit = 20;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $search = !empty($_GET['pending']) && is_numeric($_GET['pending']) ? trim($_GET['pending']) : null;
        $sql = $search ? "AND subscriptions.id=$search" : null;
        $pending_subscriptions = DB::query("select subscriptions.*, users.name as user_name, plans.name as plan_name, transactions.amount, transactions.method From subscriptions LEFT JOIN users ON subscriptions.user_id=users.id LEFT JOIN plans ON subscriptions.plan_id=plans.id LEFT JOIN transactions ON subscriptions.transaction_id=transactions.id WHERE subscriptions.status=2 $sql ORDER BY subscriptions.id DESC LIMIT $offset, $limit");
        $total = DB::count('subscriptions', ['status' => 2]);
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);
        $recent_subscriptions = DB::query("select subscriptions.*, users.name as user_name, plans.name as plan_name, transactions.amount, transactions.method From subscriptions LEFT JOIN users ON subscriptions.user_id=users.id LEFT JOIN plans ON subscriptions.plan_id=plans.id LEFT JOIN transactions ON subscriptions.transaction_id=transactions.id ORDER BY subscriptions.id DESC LIMIT 10");

        // all update
        if ((time() - strtotime($this->setting['last_updated'])) > 360) $this->refresh();
        $this->title('Admin Dashboard');
        require_once APP . '/View/Admin/Dashboard.php';
    }
}
