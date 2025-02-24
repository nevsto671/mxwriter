<?php

namespace Controller;

use DB;
use Gateway;

class Controller
{
    public $uid;
    public $rid;
    public $user;
    public $plan;
    public $token;
    public $setting;

    function __construct()
    {
        $this->setting = $this->setting(['status' => 1]);
        if (!$this->setting) die('Error: database');
        date_default_timezone_set($this->setting['time_zone']);
        $this->token = md5(session_id());
        $this->logged();
    }

    public function title($title, $site_name = false, $separator = '-')
    {
        $this->setting['site_title'] = $site_name ? ($title . ' ' . $separator . ' ' . $this->setting['site_name']) : $title;
    }

    public function url($path)
    {
        return $this->setting['site_url'] . $path;
    }

    public function urls($path, $parameters, $currentParameter = false)
    {
        $parameter = $currentParameter ? array_merge($_GET, $parameters) : $parameters;
        return $this->setting['site_url'] . $path . '?' . http_build_query($parameter);
    }

    public function redirect($path, $message = null, $message_type = "success")
    {
        if ($message) $_SESSION['flash:notification'] = ['message' => $message, 'type' => $message_type];
        header("Location: " . $this->url($path));
        exit;
    }

    public function flash()
    {
        $message = null;
        if (isset($_SESSION['flash:notification'])) {
            $message = $_SESSION['flash:notification'];
            unset($_SESSION['flash:notification']);
        }
        return $message;
    }

    public function isValidToken($csrf_token = null)
    {
        $header_token = isset($_SERVER['HTTP_X_CSRF_TOKEN']) ? $_SERVER['HTTP_X_CSRF_TOKEN'] : null;
        $token = $csrf_token ? $csrf_token : $header_token;
        return $token && $token == $this->token ? true : false;
    }

    public function price($amount)
    {
        $amount = $this->setting['decimal_places'] ? number_format($amount, $this->setting['decimal_places']) : floatval($amount);
        return $this->setting['currency_position'] == 'right' ? $amount . $this->setting['currency_symbol'] : $this->setting['currency_symbol'] . $amount;
    }

    public function timeAgo($datetime)
    {
        $time = time() -  strtotime($datetime);
        $time = ($time < 1) ? 1 : $time;
        $tokens = [31536000 => 'year', 2592000 => 'month', 604800 => 'week', 86400 => 'day', 3600 => 'hour', 60 => 'minute', 1 => 'second'];
        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $number = floor($time / $unit);
            return $number . ' ' . $text . (($number > 1) ? 's' : '');
        }
    }

    public function setting($where)
    {
        $result = [];
        $results = DB::select('settings', 'name, description', $where);
        foreach ($results ?: [] as $val) {
            $result[$val['name']] = $val['description'];
        }
        return $result;
    }

    public function settings($name)
    {
        $result = [];
        $results = DB::selectIn('settings', 'name, description', ['name' => $name]);
        foreach ($results as $val) {
            $result[$val['name']] = $val['description'];
        }
        return $result;
    }

    public function userDetails($where, $column = '*')
    {
        $result = DB::select('users', $column, $where, "LIMIT 1");
        return isset($result[0]) ? $result[0] : null;
    }

    public function page($slug)
    {
        $where['slug'] = $slug;
        $where['status'] = 1;
        $result = DB::select('pages', '*', $where, "LIMIT 1");
        return isset($result[0]) ? $result[0] : [];
    }

    public function logged()
    {
        if (!isset($_SESSION['UID']) && isset($_COOKIE['UID'])) {
            $this->user = $this->userDetails(['id' => $_COOKIE['UID']], 'id, session');
            if (empty($this->user['session'])) return;
            $browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
            if (isset($_COOKIE['SID']) && $_COOKIE['SID'] == md5($browser . $this->user['session'])) {
                $_SESSION['UID'] = $this->user['id'];
                DB::update('users', ['logged' => date('Y-m-d H:i:s')], ['id' => $this->user['id']]);
            }
        }

        $userId = isset($_SESSION['UID']) ? $_SESSION['UID'] : 0;
        $this->user = $this->userDetails(['id' => $userId]);
        if (!$this->user) {
            unset($_SESSION['UID']);
            setcookie("UID", "", time() - 3600);
            setcookie("SID", "", time() - 3600);
            return;
        }

        $this->uid = $this->user['id'];
        $this->rid = $this->user['role'];

        $result = DB::select('plans', '*', ['id' => $this->user['plan_id']], 'LIMIT 1');
        $this->plan = isset($result[0]) ? $result[0] : null;
    }

    public function referrals($refId)
    {
        if (!isset($_COOKIE['REF'])) setcookie('REF', $refId, time() + 2592000, '/');
        $this->redirect(null);
    }

    public function logout()
    {
        DB::update('users', ['session' => null], ['id' => $this->uid]);
        unset($_SESSION['UID']);
        setcookie("UID", "", time() - 3600);
        setcookie("SID", "", time() - 3600);
        $this->redirect(null);
    }

    public function license()
    {
        $setting = $this->settings(['license_key', 'purchase_code']);
        $domain_name = isset($_SERVER['HTTP_HOST']) ? preg_replace('#^(?:www\.)+(.+\.)#i', '$1', $_SERVER['HTTP_HOST']) : null;
        return (!empty($setting['license_key']) && hash_equals($setting['license_key'], hash_hmac('sha256', $domain_name, $setting['purchase_code']))) ? true : false;
    }

    public function maintenance()
    {
        $setting = $this->setting(['name' => 'maintenance_message']);
        $message = isset($setting['maintenance_message']) ? $setting['maintenance_message'] : null;
        die(require_once APP . '/View/Offline.php');
    }

    public function error()
    {
        $this->redirect(null);
        //die(require_once APP . '/View/Error.php');
    }

    public function openai($url, $parameters = null, $function = null)
    {
        $header[] = "Content-Type: application/json";
        $header[] = "Authorization: Bearer " . $this->setting['openai_apikey'];
        $header[] = "OpenAI-Beta: assistants=v2";
        if ($this->setting['openai_organization_id']) $header[] = "OpenAI-Organization: " . $this->setting['openai_organization_id'];
        ini_set('max_execution_time', '300');
        if (session_status() === PHP_SESSION_ACTIVE) {
            session_write_close();
        }
        $raitor = curl_init("https://api.openai.com/v1/$url");
        curl_setopt($raitor, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($raitor, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($raitor, CURLOPT_HTTPHEADER, $header);
        if ($function) {
            header("Content-Type: text/event-stream");
            header('Cache-Control: no-cache');
            header('X-Accel-Buffering: no');
            curl_setopt($raitor, CURLOPT_WRITEFUNCTION, $function);
        }
        if (!is_null($parameters)) {
            curl_setopt($raitor, CURLOPT_POST, true);
            curl_setopt($raitor, CURLOPT_POSTFIELDS, json_encode($parameters));
        }
        $response = curl_exec($raitor);
        if (curl_errno($raitor)) return null;
        curl_close($raitor);
        return !empty($response) ? json_decode($response, true) : null;
    }

    public function openaiUpload($filePath, $fileName = null, $purpose = 'assistants')
    {
        if (empty($filePath)) return;
        $header[] = "Authorization: Bearer " . $this->setting['openai_apikey'];
        if ($this->setting['openai_organization_id']) $header[] = "OpenAI-Organization: " . $this->setting['openai_organization_id'];
        $fileData = [
            'file' => new \CURLFile($filePath, 'application/octet-stream', $fileName ?: basename($filePath)),
            'purpose' => $purpose
        ];
        ini_set('max_execution_time', '1500');
        $raitor = curl_init("https://api.openai.com/v1/files");
        curl_setopt($raitor, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($raitor, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($raitor, CURLOPT_POST, true);
        curl_setopt($raitor, CURLOPT_POSTFIELDS, $fileData);
        curl_setopt($raitor, CURLOPT_HTTPHEADER, $header);
        $response = curl_exec($raitor);
        if (curl_errno($raitor)) return null;
        curl_close($raitor);
        return !empty($response) ? json_decode($response, true) : null;
    }

    public function openaiDelete($url)
    {
        $header[] = "Content-Type: application/json";
        $header[] = "Authorization: Bearer " . $this->setting['openai_apikey'];
        $header[] = "OpenAI-Beta: assistants=v2";
        if ($this->setting['openai_organization_id']) $header[] = "OpenAI-Organization: " . $this->setting['openai_organization_id'];
        ini_set('max_execution_time', '300');
        $raitor = curl_init("https://api.openai.com/v1/$url");
        curl_setopt($raitor, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($raitor, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($raitor, CURLOPT_HTTPHEADER, $header);
        curl_setopt($raitor, CURLOPT_CUSTOMREQUEST, "DELETE");
        $response = curl_exec($raitor);
        if (curl_errno($raitor)) return null;
        curl_close($raitor);
        $data = !empty($response) ? json_decode($response) : null;
        return isset($data->deleted) && $data->deleted == true ? true : false;
    }

    public function update_subscription($user_id, $plan_id, $transaction_id = null, $subscription_update_id  = null, $plan_extended = false)
    {
        $plan_result = DB::select('plans', '*', ['id' => $plan_id], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;
        if (empty($plan)) return null;
        $user = $this->userDetails(['id' => $user_id], 'words, images, expired, plan_id');
        $setting = $this->settings(['credits_extended', 'free_plan', 'license_key', 'purchase_code']);
        $credits_extended = !empty($setting['credits_extended']) ? true : false;
        $domain_name = isset($_SERVER['HTTP_HOST']) ? preg_replace('#^(?:www\.)+(.+\.)#i', '$1', $_SERVER['HTTP_HOST']) : null;
        if ($domain_name && !hash_equals($setting['license_key'], hash_hmac('sha256', $domain_name, $setting['purchase_code']))) return false;

        // cancel inactive free plan
        if (empty($plan['status']) && $setting['free_plan'] == $user['plan_id']) {
            return $this->cancelSubscription($user_id);
        }

        // check free plan and not expiry 
        if ($setting['free_plan'] == $plan['id'] && !empty($user['expired']) && strtotime($user['expired']) > time()) {
            if ($plan['duration'] != 'prepaid') {
                $user_data['plan_id'] = $plan['id'];
            }
            $update = DB::update('users', $user_data, ['id' => $user_id]);
            return $update ? true : false;
        }

        // check prepaid plan
        if ($plan['duration'] == 'prepaid') {
            if (!empty($user['expired'])) {
                $data['end'] = $user['expired'];
            } else {
                $datetime = new \DateTime(date('Y-m-d H:i:s'));
                $data['end'] = $datetime->modify("+1 month")->format('Y-m-d H:i:s');
            }
        } else if ($plan['duration'] == 'lifetime') {
            $data['end'] = null;
        } else {
            $datetime = new \DateTime(date('Y-m-d H:i:s'));
            $data['end'] = $datetime->modify("+1 $plan[duration]")->format('Y-m-d H:i:s');
        }

        // update subscription history 
        $data['plan_id'] = $plan['id'];
        $data['user_id'] = $user_id;
        $data['transaction_id'] = $transaction_id;
        $data['start'] = date('Y-m-d H:i:s');
        $data['status'] = 1;
        if ($subscription_update_id) {
            DB::update('subscriptions', $data, ['id' => $subscription_update_id]);
            $subscription_id = $subscription_update_id;
        } else {
            $subscription_id = DB::insert('subscriptions', $data);
        }

        // check prepaid plan
        if ($plan['duration'] == 'prepaid' || $plan_extended) {
            $credits_extended = true;
        } else if ($setting['free_plan'] == $plan['id']) {
            $credits_extended = false;
        }

        // update user data
        $remaining_words = isset($user['words']) ? (int)$user['words'] : 0;
        $update_words = $credits_extended ? ($remaining_words + $plan['words']) : $plan['words'];
        $user_data['words'] = is_null($plan['words']) ? null :  $update_words;

        $remaining_images = isset($user['images']) ? (int)$user['images'] : 0;
        $update_images = $credits_extended ? ($remaining_images + $plan['images']) : $plan['images'];
        $user_data['images'] = is_null($plan['images']) ? null : $update_images;

        if ($plan['duration'] != 'prepaid') {
            $user_data['plan_id'] = $plan['id'];
            $user_data['expired'] = $data['end'];
        }

        $user_data['subscription_status'] = 1;
        $update = DB::update('users', $user_data, ['id' => $user_id]);
        return $update ? $subscription_id : false;
    }

    public function cancelSubscription($user_id, $cancellationrequest = false)
    {
        $setting = $this->settings(['free_plan', 'credits_reset']);
        $user = $this->userDetails(['id' => $user_id], 'id, plan_id, payment_method, customer_id, subscription_id, subscription_status');
        $subscriptionStatus = isset($user['subscription_status']) && $user['subscription_status'] ? $user['subscription_status'] : 0;

        if (!empty($user['payment_method'])) {
            $gateways = DB::select('gateways', 'provider', ['provider' => $user['payment_method'], 'status' => 1, 'type' => 'payment'], 'LIMIT 1');
            $provider = isset($gateways[0]['provider']) ? $gateways[0]['provider'] : null;
            if ($provider) {
                $payment = new Gateway($provider);
                if (method_exists($payment->gateway, 'cancelSubscription')) {
                    $payment->gateway->cancelSubscription($user['subscription_id']);
                }
                $data['payment_method'] = null;
                $data['customer_id'] = null;
                $data['subscription_id'] = null;
                DB::update('users', $data, ['id' => $user_id]);
            }
        }

        // check subscription cancellation request 
        if ($cancellationrequest) {
            DB::update('users', ['subscription_status' => 2], ['id' => $user_id]);
        } else {
            $result = DB::select('plans', '*', ['id' => $setting['free_plan'], 'status' => 1], 'LIMIT 1');
            $plan = isset($result[0]) ? $result[0] : null;
            // active free plan
            if ($plan && isset($plan['price']) && $plan['price'] == 0 && $user['plan_id'] != $setting['free_plan']) {
                $this->update_subscription($user_id, $setting['free_plan']);
            } else {
                // credits reset
                if ($setting['credits_reset']) {
                    $user_data['words'] = 0;
                    $user_data['images'] = 0;
                }
                $user_data['plan_id'] = 0;
                $user_data['subscription_status'] = 0;
                DB::update('users', $user_data, ['id' => $user_id]);
            }
        }
        return true;
    }

    public function refresh()
    {
        $setting = $this->settings(['site_name', 'site_email', 'site_url', 'remove_history', 'free_plan', 'credits_reset']);
        // update last action time
        DB::update('settings', ['description' => date('Y-m-d H:i:s')], ['name' => 'last_updated']);

        // free plan renew
        $free_plan_id = $setting['free_plan'];
        if (!empty($free_plan_id)) {
            $free_users = DB::query("select id, plan_id From users WHERE plan_id=$free_plan_id AND expired < now() ORDER BY expired ASC LIMIT 200");
            foreach ($free_users ?: [] as $user) {
                $this->update_subscription($user['id'], $user['plan_id']);
            }
        }

        // update admin plan
        $admin_users = DB::query("select id, plan_id From users WHERE subscription_status = 1 AND role=1 AND expired < now() ORDER BY expired ASC LIMIT 1");
        if (!empty($admin_users)) {
            foreach ($admin_users ?: [] as $user) {
                $this->update_subscription($user['id'], $user['plan_id']);
            }
        }

        // cancel user subscription for subscription cancel request when service period is over
        $cancel_users =  DB::query("SELECT id FROM users WHERE subscription_status = 2 AND expired < NOW() ORDER BY expired ASC LIMIT 100");
        foreach ($cancel_users ?: [] as $user) {
            $this->cancelSubscription($user['id']);
        }

        // cancel user subscription when service period is over
        $sub_users =  DB::query("SELECT id FROM users WHERE plan_id !=0 AND expired <= NOW() - INTERVAL 3 DAY ORDER BY expired ASC LIMIT 20");
        foreach ($sub_users ?: [] as $user) {
            $this->cancelSubscription($user['id']);
        }

        // cancel pending plan
        $pending_plans = DB::query("SELECT id,transaction_id FROM subscriptions WHERE status=2 AND start <= NOW() - INTERVAL 30 DAY LIMIT 200");
        foreach ($pending_plans ?: [] as $val) {
            DB::update('subscriptions', ['status' => 0], ['id' => $val['id']]);
            DB::update('transactions', ['payment_status' => 0, 'status' => 0], ['id' => $val['transaction_id']]);
        }

        // transactions status update pending to cancel for unpaid payment 
        $transaction_results = DB::select('transactions', 'id', ['status' => 0, 'payment_status' => 2, 'offline_payment' => 0], 'ORDER BY id ASC LIMIT 20');
        foreach ($transaction_results ?: [] as $val) {
            DB::update('transactions', ['payment_status' => 0], ['id' => $val['id']]);
        }

        // subscription status update active to expired at the end of service period
        $subscriptions = DB::query("select id From subscriptions WHERE status=1 AND end < now() ORDER BY id ASC LIMIT 20");
        foreach ($subscriptions ?: [] as $val) {
            DB::update('subscriptions', ['status' => 0], ['id' => $val['id']], 'LIMIT 1');
        }

        // update referrals commission
        $completed =  DB::query("SELECT * FROM referrals WHERE status = 2 AND created <= NOW() - INTERVAL 30 DAY ORDER BY created ASC LIMIT 50");
        foreach ($completed as $val) {
            $update =  DB::update('referrals', ['status' => 1], ['id' => $val['id']]);
            if ($update) {
                $referralUser = DB::select('users', 'balance', ['id' => $val['user_id']]);
                if (!empty($referralUser[0])) {
                    $balance = $referralUser[0]['balance'] + $val['earnings'];
                    DB::update('users', ['balance' => $balance], ['id' => $val['user_id']]);
                }
            }
        }

        // delete old history
        if ($setting['remove_history']) {
            $history =  DB::query("SELECT id FROM history WHERE created <= NOW() - INTERVAL 30 DAY ORDER BY created DESC LIMIT 100, 200");
            foreach ($history ?: [] as $val) {
                DB::delete('history', ['id' => $val['id']]);
            }

            // delete chat history
            $chats =  DB::query("SELECT id, user_id FROM chats WHERE created <= NOW() - INTERVAL 30 DAY ORDER BY created DESC LIMIT 30, 200");
            foreach ($chats ?: [] as $val) {
                DB::delete('chats', ['id' => $val['id']]);
                DB::delete('chat_history', ['chat_id' => $val['id']]);
            }

            // delete analyst history
            $analysis = DB::query("SELECT id FROM analysis WHERE created <= NOW() - INTERVAL 30 DAY ORDER BY created DESC LIMIT 30");
            foreach ($analysis ?: [] as $val) {
                foreach ($chats ?: [] as $val) {
                    $analysis = DB::select('analysis', '*', ['id' => $val['id'], 'user_id' => $val['user_id']], 'LIMIT 1');
                    if (empty($analysis)) return null;
                    $assistantId = isset($analysis[0]['assistant_id']) ? $analysis[0]['assistant_id'] : null;
                    $threadId = isset($analysis[0]['thread_id']) ? $analysis[0]['thread_id'] : null;
                    $assistants = DB::select('assistants', 'vector_store_id', ['id' => $assistantId, 'user_id' => $val['user_id']], 'LIMIT 1');
                    $vectorStoreId = isset($assistants[0]['vector_store_id']) ? $assistants[0]['vector_store_id'] : null;
                    $files = DB::select('files', 'id', ['assistant_id' => $assistantId, 'user_id' => $val['user_id']]);
                    $this->openaiDelete("assistants/$assistantId");
                    $this->openaiDelete("threads/$threadId");
                    $this->openaiDelete("vector_stores/$vectorStoreId");
                    DB::delete('assistants', ['id' => $assistantId]);
                    DB::delete('analysis', ['id' => $val['id']]);
                    DB::delete('chat_history', ['chat_id' => $val['id']]);
                    foreach ($files as $file) {
                        $this->openaiDelete("files/$file[id]");
                        DB::delete('files', ['id' => $file['id']]);
                    }
                }
            }
        }
    }
}
