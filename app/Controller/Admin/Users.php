<?php

namespace Controller\Admin;

use DB;
use Helper;
use Pagination;
use Controller\AdminController;

class Users extends AdminController
{
    public function index()
    {
        // update Credits
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id']) && isset($_POST['words']) && isset($_POST['images'])) {
            $words =  isset($_POST['words']) && is_numeric($_POST['words']) ? $_POST['words'] : null;
            $images =  isset($_POST['images']) && is_numeric($_POST['images']) ? $_POST['images'] : null;
            $expiry_day = isset($_POST['expiry_day']) && is_numeric($_POST['expiry_day']) ? $_POST['expiry_day'] : null;
            $expiry_month = isset($_POST['expiry_month']) && is_string($_POST['expiry_month']) ? $_POST['expiry_month'] : null;
            $expiry_year = isset($_POST['expiry_year']) && is_numeric($_POST['expiry_year']) ? $_POST['expiry_year'] : null;
            $user = $this->userDetails(['id' => $_GET['id']], 'expired');
            $expiry_time = !empty($user['expired']) ? date('H:i:s', strtotime($user['expired'])) : null;
            $expired = $expiry_year . '-' . $expiry_month . '-' . $expiry_day . ' ' . $expiry_time;
            $setting = $this->settings(['license_key', 'purchase_code']);
            $domain_name = isset($_SERVER['HTTP_HOST']) ? preg_replace('#^(?:www\.)+(.+\.)#i', '$1', $_SERVER['HTTP_HOST']) : null;
            if (!hash_equals($setting['license_key'], hash_hmac('sha256', $domain_name, $setting['purchase_code']))) $this->redirect("admin/users?id=$_GET[id]");
            $data['words'] = $words;
            $data['images'] = $images;
            $data['expired'] = $expiry_year ? $expired : null;
            DB::update('users', $data, ['id' => $_GET['id']]);
            $this->redirect("admin/users?id=$_GET[id]", "Credits has been updated successfully.");
        }
        // add plan by plan id
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id']) && isset($_POST['plan_id'])) {
            $plan_id = isset($_POST['plan_id']) ? $_POST['plan_id'] : null;
            $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
            $update = $this->update_subscription($user_id, $plan_id);
            if ($update) $this->redirect("admin/users?id=$user_id", "Plan has been updated successfully.");
        }
        // change role
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['id']) && isset($_POST['role'])) {
            $user_id = isset($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
            if ($this->uid == $user_id) $this->redirect("admin/users?id=$user_id");
            $update = DB::update('users', ['role' => $_POST['role']], ['id' => $user_id]);
            if ($update) $this->redirect("admin/users?id=$user_id", "User role has been updated successfully.");
        }
        // active pending subscriptions
        if (isset($_GET['id']) && !empty($_GET['invoice'])) {
            $subscription_id = isset($_GET['invoice']) && is_numeric($_GET['invoice']) ? $_GET['invoice'] : null;
            if (isset($_GET['sign']) && $_GET['sign'] == md5($subscription_id)) {
                $subscriptions_result = DB::select('subscriptions', '*', ['id' => $subscription_id, 'user_id' => $_GET['id'], 'status' => 2], 'LIMIT 1');
                $subscription = isset($subscriptions_result[0]) ? $subscriptions_result[0] : null;
                if ($subscription) {
                    $plan_id = isset($subscription['plan_id']) ? $subscription['plan_id'] : null;
                    $user_id = isset($subscription['user_id']) ? $subscription['user_id'] : null;
                    $update = $this->update_subscription($user_id, $plan_id, $subscription['transaction_id'], $subscription['id']);
                    if ($update) {
                        DB::update('transactions', ['payment_status' => 1, 'status' => 1], ['id' => $subscription['transaction_id']]);
                        $this->redirect("admin/users?id=$user_id", "Subscription has been updated successfully.");
                    }
                }
            }
            $this->redirect("admin/users?id=$_GET[id]");
        }

        // delete user
        if (!empty($_GET['delete']) && is_numeric($_GET['delete']) && isset($_GET['sign']) && $_GET['sign'] == md5($_GET['delete'])) {
            $userID = $_GET['delete'];
            $chats = DB::select('chats', '*', ['user_id' => $userID], 'LIMIT 1');
            if ($chats) {
                DB::delete('chat_history', ['chat_id' => $chats[0]['id']]);
            }
            DB::delete('chats', ['user_id' => $userID]);
            DB::delete('chat_history', ['id' => $userID]);
            DB::delete('history', ['user_id' => $userID]);
            DB::delete('subscriptions', ['user_id' => $userID]);
            DB::delete('transactions', ['user_id' => $userID]);
            DB::delete('usages', ['user_id' => $userID]);
            DB::delete('images', ['user_id' => $userID]);
            DB::delete('users', ['id' => $userID]);
            $this->redirect("admin/users", "User has been deleted successfully.");
        }

        // deactive user
        if (!empty($_GET['deactivate']) && is_numeric($_GET['deactivate']) && isset($_GET['sign']) && $_GET['sign'] == md5($_GET['deactivate'])) {
            DB::update('users', ['status' => 0, 'session' => null], ['id' => $_GET['deactivate']]);
            $this->redirect("admin/users?id=$_GET[deactivate]", "This user has been deactivated successfully.");
        }

        // active user
        if (!empty($_GET['activate']) && is_numeric($_GET['activate']) && isset($_GET['sign']) && $_GET['sign'] == md5($_GET['activate'])) {
            DB::update('users', ['status' => 1], ['id' => $_GET['activate']]);
            $this->redirect("admin/users?id=$_GET[activate]", "This user has been activated successfully.");
        }

        // cancel subscription
        if (isset($_GET['id']) && !empty($_GET['cancel']) && is_string($_GET['cancel']) && $_GET['cancel'] == md5(date('H'))) {
            $this->cancelSubscription($_GET['id'], true);
            $this->redirect("admin/users?id=$_GET[id]", "User subscription has been cancelled.", "success");
        }

        // export user
        if (isset($_GET['export']) && $_GET['export'] == $this->token) {
            $users = DB::query("SELECT users.name, users.email, users.created, users.status, plans.name AS plan_name FROM users JOIN plans ON users.plan_id = plans.id");
            if (!$users) $this->redirect("admin/users");
            $date = date('Y-m-d');
            $path = APP . "/Data/users.csv";
            $dir = dirname($path);
            if (!is_dir($dir)) mkdir($dir, 0777, true);
            $file = fopen($path, 'w');
            if (!file_exists($path)) $this->redirect("admin/users?");
            fputcsv($file, ['Full Name', 'Email Address', 'Plan Name', 'Join Date', 'Status']);
            foreach ($users as $user) {
                if ($user['status'] == 0) {
                    $status = 'Deactivate';
                } else {
                    $status = 'Activate';
                }
                fputcsv($file, [$user['name'], $user['email'], $user['plan_name'], $user['created'], $status]);
            }
            fclose($file);
            header("Content-Type: text/csv");
            header("Content-Disposition: attachment; filename=Users-$date.csv");
            readfile($path);
            exit;
        }

        // add new user
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
            $name = !empty($_POST['name']) && is_string($_POST['name']) ? Helper::input($_POST['name']) : null;
            $email = !empty($_POST['email']) && is_string($_POST['email']) ? trim(strtolower($_POST['email'])) : null;
            $plan_id = isset($_POST['plan_id']) ? $_POST['plan_id'] : null;
            if (!$name || strlen($name) < 4) $this->redirect("admin/users");
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $this->redirect("admin/users");
            $result = $this->userDetails(['email' => $email], 'id');
            if ($result) $this->redirect("admin/users", "This '$email' address is already registered.", "error");
            $password = $random_password = $this->generateRandomPassword();
            $data = [
                'name' => $name,
                'email' => strtolower($email),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'status' => 1, // 1 = email verified
            ];
            $user_id = DB::insert('users', $data);

            // update plan
            $setting = $this->settings(['site_name', 'site_email', 'site_url', 'mailchimp_status', 'free_plan']);
            if ($plan_id != 0) {
                $plan_id = $plan_id ? $plan_id : $setting['free_plan'];
                if ($plan_id) $this->update_subscription($user_id, $plan_id);
            }

            // mail information
            $user = $this->userDetails(['id' => $user_id]);
            $subject = "$setting[site_name] account created.";
            $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
            $body .= "Your account has been created on $setting[site_name]." . PHP_EOL . PHP_EOL;
            $body .= "Username: $email" . PHP_EOL;
            $body .= "Password: $password" . PHP_EOL;
            $body .= "Login URL: " . $this->url('login') . PHP_EOL . PHP_EOL;
            $body .= "If you don't want to sign up for this account, please ignore this email. If you are having trouble with your account, please contact us at $setting[site_email] and we will be happy to help you." . PHP_EOL;
            $to = [$user['email'] => $user['name']];
            $from = [$setting['site_email'] => $setting['site_name']];
            $mail = Helper::sendMail($to, $subject, $body, $from);

            // mailchimp contact add
            if (!empty($setting['mailchimp_status'])) {
                $nm = Helper::splitName($user['name']);
                $data = [
                    'email_address' => $user['email'],
                    'status' => 'subscribed',
                    'merge_fields' => [
                        'FNAME' => $nm['firstname'],
                        'LNAME' => $nm['lastname'],
                    ],
                ];
                Helper::mailchimp($data);
            }

            $this->redirect("admin/users?id=$user_id", "User has been added successfully and will receive an email with login information.");
        }

        // view user
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $user = $this->userDetails(['id' => $_GET['id']], '*');
            if (!$user) $this->redirect("admin/users");
            $uid = $user['id'];
            $plans = DB::select('plans');
            $plan = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
            $plan_name = isset($plan[0]['name']) ? $plan[0]['name'] : 'No';
            $remaining_words = isset($user['words']) ? $user['words'] : null;
            $remaining_images = isset($user['images']) ? $user['images'] : null;
            $expired = !empty($user['expired']) ? date($this->setting['date_format'], strtotime($user['expired'])) : null;
            $expiry_day = !empty($user['expired']) ? date('d', strtotime($user['expired'])) : null;
            $expiry_month = !empty($user['expired']) ? date('m', strtotime($user['expired'])) : null;
            $expiry_year = !empty($user['expired']) ? date('Y', strtotime($user['expired'])) : null;
            $subscriptions = DB::query("select subscriptions.*, plans.name as plan_name From subscriptions LEFT JOIN plans ON subscriptions.plan_id=plans.id WHERE subscriptions.user_id=$uid ORDER BY subscriptions.id DESC LIMIT 5");
            $transactions = DB::select('transactions', '*', ['user_id' => $uid], 'ORDER BY id DESC LIMIT 5');
            $pending_subscriptions = DB::query("select subscriptions.*, plans.name as plan_name From subscriptions LEFT JOIN plans ON subscriptions.plan_id=plans.id WHERE subscriptions.user_id=$uid AND subscriptions.status=2 ORDER BY subscriptions.id DESC LIMIT 20");
        } else {

            $sql = '';
            $filter = [];
            if (!empty($_GET['search']) && is_string($_GET['search'])) {
                $q = preg_replace('/[\\/\\\"\'`~^*$:,;?&|=({<%>})\[\]]+/', '', $_GET['search']);
                $sql = "WHERE (users.id = '$q' OR users.name REGEXP '$q' OR users.email REGEXP '$q' OR users.email = '$q')";
            } else if (isset($_GET['plan']) && is_numeric($_GET['plan'])) {
                $filter = ['plan_id' => $_GET['plan']];
                $sql = "WHERE users.plan_id = $_GET[plan]";
            }

            $limit = 50;
            $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
            $offset = ($page * $limit) - $limit;
            $users = DB::query("select users.*, plans.name as plan_name From users LEFT JOIN plans ON users.plan_id=plans.id $sql ORDER BY users.id DESC LIMIT $offset, $limit");
            $total = DB::count('users', $filter);
            $pager = new Pagination($page, $limit);
            $pager->total($total);
            $pagination = $pager->execute(true);
        }

        $plans = DB::select('plans', '*', [], 'ORDER BY duration, images, price');
        $this->title('Users');
        require_once APP . '/View/Admin/Users.php';
    }

    protected function generateRandomPassword()
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $char_length = strlen($chars);
        $password = '';
        for ($i = 0; $i < 8; $i++) {
            $random_index = rand(0, $char_length - 1);
            $password .= $chars[$random_index];
        }
        return $password;
    }
}
