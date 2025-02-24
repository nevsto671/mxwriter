<?php

namespace Controller;

use DB;
use Helper;
use Hybridauth\Hybridauth;

class Login extends Controller
{
    public function index()
    {
        if ($this->uid) $this->redirect("my");
        $setting = self::settings(['registration_status']);
        $provider_results = DB::select('providers', '*', ['status' => 1]);
        $provider = [];
        foreach ($provider_results as $val) {
            $provider[$val['name']] = $val;
        }

        $this->title('Log in to your account', true);
        require_once APP . '/View/Login.php';
    }

    public function social($provider_name)
    {
        if (!$provider_name || !is_string($provider_name)) $this->redirect("login", "We are unable to process within this provider.", "error");
        $result = DB::select('providers', '*', ['name' => $provider_name, 'status' => 1], 'LIMIT 1');
        $provider = isset($result[0]) ? $result[0] : null;
        if (empty($provider['name'])) $this->redirect("login", "We are unable to process.", "error");
        $setting = self::settings(['site_name', 'site_email', 'site_url', 'registration_status', 'mailchimp_status', 'zapier_webhook', 'pabbly_webhook']);
        $callback = isset($setting['site_url']) ? ($setting['site_url'] . "login/" . strtolower($provider['name'])) : null;
        $config['callback'] = $callback;
        $config['providers'][$provider['name']]['enabled'] = 1;
        $config['providers'][$provider['name']]['keys']['id'] = $provider['key_id'];
        $config['providers'][$provider['name']]['keys']['secret'] = $provider['key_secret'];
        require_once APP . '/Vendor/hybridauth/src/autoload.php';
        try {
            $hybridauth = new Hybridauth($config);
            $adapter = $hybridauth->authenticate($provider['name']);
            $userProfile = $adapter->getUserProfile();
            if (!empty($userProfile->email)) {
                $user = $this->userDetails(['email' => $userProfile->email]);
                // create user
                if (empty($user)) {
                    if (!$setting['registration_status']) $this->redirect("login", "New user registration deactivated", "error");

                    $userData = [
                        'name' => isset($userProfile->displayName) ? $userProfile->displayName : 'Unknown',
                        'email' => $userProfile->email,
                        'status' => 1, // 1 for active
                    ];
                    $uid = DB::insert('users', $userData);
                    if (empty($uid)) $this->redirect('login?status=failed');
                    $user = $this->userDetails(['id' => $uid], 'id, name, email, role, status');
                    // update subscription
                    $this->updateSubscription($uid);
                    // mail information
                    $subject = "$setting[site_name] account created.";
                    $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
                    $body .= "Your account has been created on $setting[site_name]." . PHP_EOL . PHP_EOL;
                    $body .= "If you didn't sign up for this account, or you are having trouble with your account, please contact us at $setting[site_email] and we will be happy to help you." . PHP_EOL;
                    $to = [$user['email'] => $user['name']];
                    $from = [$setting['site_email'] => $setting['site_name']];
                    $mail = Helper::sendMail($to, $subject, $body, $from);
                }

                if ($user['status'] == 0) $this->redirect("login", "This account is blocked.", "error");
                if ($this->update_user($user)) $this->redirect('my');
            }
            $adapter->disconnect();
        } catch (\Exception $e) {
            //echo $e->getMessage();
        }
        $this->redirect("login", "We are unable to process within $provider[name]", "error");
    }
}
