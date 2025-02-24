<?php

namespace Controller\User;

use DB;
use Controller\UserController;

class Billing extends UserController
{
    public function index()
    {
        $setting = $this->settings(['free_plan']);
        $user = $this->userDetails(['id' => $this->uid], 'plan_id, words_generated, images_generated, words, images, expired, subscription_status');
        // cancel subscription
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['cancelSubscription']) && $_POST['cancelSubscription'] == $this->token) {
            $this->cancelSubscription($this->uid, true);
            $this->redirect("my/billing", "Your subscription has been successfully cancelled.", "success");
        }

        $expired = !empty($user['expired']) ? date($this->setting['date_format'], strtotime($user['expired'])) : null;
        $plan_result = $this->planDetails($user['plan_id']);
        $plan_name = isset($plan_result['name']) ? $plan_result['name'] : 'No';
        $remaining_words = isset($user['words']) ? $user['words'] : null;
        $remaining_images = isset($user['images']) ? $user['images'] : null;
        $pending_subscriptions = DB::query("select subscriptions.*, plans.name as plan_name, transactions.amount From subscriptions LEFT JOIN plans ON subscriptions.plan_id=plans.id LEFT JOIN transactions ON subscriptions.transaction_id=transactions.id WHERE subscriptions.status=2 AND subscriptions.user_id=" . $this->uid . " ORDER BY subscriptions.id DESC LIMIT 20");

        $this->title('Billing overview');
        require_once APP . '/View/User/Billing.php';
    }

    public function planDetails($plan_id)
    {
        $plan = DB::select('plans', '*', ['id' => $plan_id], 'LIMIT 1');
        return isset($plan[0]) ? $plan[0] : null;
    }
}
