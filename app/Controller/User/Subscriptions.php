<?php

namespace Controller\User;

use DB;
use Pagination;
use Controller\UserController;

class Subscriptions extends UserController
{
    public function index()
    {
        // print invoice
        if (!empty($_GET['print']) && is_string($_GET['print'])) {
            $subscription_result = DB::select('subscriptions', '*', ['id' => $_GET['print'], 'user_id' => $this->uid], 'LIMIT 1');
            $subscription = isset($subscription_result[0]) ? $subscription_result[0] : null;
            if (!$subscription) $this->redirect("my/billing/subscriptions");
            $transaction_result = DB::select('transactions', '*', ['id' => $subscription['transaction_id'], 'user_id' => $this->uid], 'LIMIT 1');
            $transaction = isset($transaction_result[0]) ? $transaction_result[0] : null;
            if (!$transaction) $this->redirect("my/billing/subscriptions");
            $plan = $this->planDetails($subscription['plan_id']);
            if (!$plan) $this->redirect("my/billing/subscriptions");
            $user_result = DB::select('users', '*', ['id' => $this->uid], "LIMIT 1");
            $user = isset($user_result[0]) ? $user_result[0] : null;
            $setting = $this->settings(['site_name', 'site_address', 'offline_payment_guidelines', 'offline_payment_recipient', 'offline_payment_title']);
            require_once APP . '/View/User/Print.php';
            exit;
        }

        // cancel plan
        if (!empty($_GET['cancel']) && is_numeric($_GET['cancel']) && isset($_GET['sign']) && $_GET['sign'] == md5($_GET['cancel'])) {
            $subscriptions_result = DB::select('subscriptions', '*', ['id' => $_GET['cancel'], 'status' => 2, 'user_id' => $this->uid], 'LIMIT 1');
            $subscription = isset($subscriptions_result[0]) ? $subscriptions_result[0] : null;
            if ($subscription) {
                DB::update('subscriptions', ['status' => 0], ['id' => $subscription['id']]);
                DB::update('transactions', ['payment_status' => 0, 'status' => 0], ['id' => $subscription['transaction_id']]);
            }
            $this->redirect("my/billing/subscriptions?id=$_GET[cancel]", "Plan has been cancelled successfully.");
        }

        // view subscription
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $id = isset($_GET['id']) ? $_GET['id'] : null;
            $uid = $this->uid;
            $subscription_result = DB::query("select subscriptions.*, plans.name as plan_name,transactions.method,transactions.amount,transactions.offline_payment,transactions.payment_status From subscriptions LEFT JOIN plans ON subscriptions.plan_id=plans.id LEFT JOIN transactions ON subscriptions.transaction_id=transactions.id WHERE subscriptions.id=$id AND subscriptions.user_id=$uid ORDER BY subscriptions.id DESC LIMIT 1");
            $subscription = isset($subscription_result[0]) ? $subscription_result[0] : null;
            if (empty($subscription)) $this->redirect("my/subscriptions");
            $setting = $this->settings(['site_name', 'site_address', 'offline_payment_guidelines', 'offline_payment_recipient', 'offline_payment_title']);
        } else {
            $uid = $this->uid;
            $limit = 20;
            $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page * $limit) - $limit;
            $subscriptions = DB::query("select subscriptions.*, plans.name as plan_name From subscriptions LEFT JOIN plans ON subscriptions.plan_id=plans.id WHERE subscriptions.user_id=$uid ORDER BY subscriptions.id DESC LIMIT $offset, $limit");
            $total = DB::count('subscriptions', ['user_id' => $uid]);
            $pager = new Pagination($page, $limit);
            $pager->total($total);
            $pagination = $pager->execute(true);
        }

        $this->title('Subscription history');
        require_once APP . '/View/User/Subscriptions.php';
    }

    public function planDetails($plan_id)
    {
        $plan = DB::select('plans', '*', ['id' => $plan_id, 'status' => 1], 'LIMIT 1');
        return isset($plan[0]) ? $plan[0] : null;
    }
}
