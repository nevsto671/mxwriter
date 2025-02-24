<?php

namespace Controller;

use DB;
use Helper;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Data extends Controller
{
    function __construct()
    {
        parent::__construct();
    }

    public function func($slug)
    {
        if (isset($_SERVER['REQUEST_METHOD']) && $_SERVER['REQUEST_METHOD'] !== 'POST') $this->redirect(null);
        if (!$this->isValidToken()) die();
        if (preg_match('/^[a-zA-Z_]+$/', $slug) && method_exists($this, $slug) && is_callable([$this, $slug])) {
            call_user_func([$this, $slug]);
        }
    }

    protected function login()
    {
        $username = !empty($_POST['user']) && is_string($_POST['user']) ? $_POST['user'] : null;
        $password = !empty($_POST['pass']) && is_string($_POST['pass']) ? $_POST['pass'] : null;
        if ($username && filter_var($username, FILTER_VALIDATE_EMAIL) && $password && strlen($password) >= 8) {
            $user = $this->userDetails(['email' => $username], 'id, name, email, password, role, status');
            if (empty($user['password'])) $this->reset($user['email'], true);
            if ($user && password_verify($password, $user['password'])) {
                if ($user['status'] == 0) $this->response("This account is deactivate or blocked.");
                $browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
                $setting = $this->settings(['jwt_key', 'device_verification']);
                $key = $setting['jwt_key'] . ($user['password'] ? substr($user['password'], 12, 6) : $user['id']);
                $dvh = hash_hmac('md5', $user['id'] . $browser, $key);
                $dvk = isset($_COOKIE['DVK']) ? $_COOKIE['DVK'] : null;
                $verification_required = $dvk && hash_equals($dvk, $dvh) ? false : true;
                if ($setting['device_verification'] && $verification_required) {
                    $verification_code = random_int(100000, 999999);
                    $setting = $this->settings(['site_name', 'site_email', 'jwt_key', 'site_url']);
                    $subject = "Your $setting[site_name] Verification Code";
                    $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
                    $body .= "We received a request to access your $setting[site_name] account from a new device. To verify your device, please use the following verification code." . PHP_EOL . PHP_EOL;
                    $body .= "Verification code: $verification_code" . PHP_EOL . PHP_EOL;
                    $body .= "If you did not attempt to log in to your $setting[site_name] account, please change your password to make sure your account is secure and do not share this verification code with anyone." . PHP_EOL;
                    $to = [$user['email'] => $user['name']];
                    $from = [$setting['site_email'] => $setting['site_name']];
                    $mail = Helper::sendMail($to, $subject, $body, $from);
                    if (!$mail) $this->response("Our mail server not responding, Please try again later.", false);
                    $key = $setting['jwt_key'] . $verification_code;
                    $payload["exp"] = time() + 3600;
                    $payload["uid"] = $user['id'];
                    try {
                        $jwt = JWT::encode($payload, $key, 'HS256');
                        $_SESSION['VT'] = $jwt;
                        $this->response('Verification required', false, ['verification' => true]);
                    } catch (\Exception $e) {
                        $this->response('Something went wrong. Please try again.', false);
                    }
                } else {
                    if (!$this->update_user($user)) return null;
                    $this->response(null, true);
                }
            }
        }
        $this->response("The email or password you entered did not match our records. Please check and try again.");
    }

    protected function login_verification()
    {
        $verification_code = !empty($_POST['code']) && is_numeric($_POST['code']) ? trim($_POST['code']) : null;
        $token = isset($_SESSION['VT']) ? $_SESSION['VT'] : null;
        if ($token) {
            try {
                $setting = $this->settings(['jwt_key']);
                $key = $setting['jwt_key'] . $verification_code;
                $jwt = JWT::decode($token, new Key($key, 'HS256'));
            } catch (\Exception $e) {
                $this->response("Incorrect verification code provided.");
            }
            $uid = isset($jwt->uid) && $jwt->uid ? $jwt->uid : null;
            $user = $this->userDetails(['id' => $uid], 'id, password, role');
            if ($user) {
                $browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
                $key = $setting['jwt_key'] . ($user['password'] ? substr($user['password'], 12, 6) : $user['id']);
                $dvh = hash_hmac('md5', $user['id'] . $browser, $key);
                setcookie('DVK', $dvh, time() + 31536000, '/');
                if (isset($_SESSION['VT'])) unset($_SESSION['VT']);
                if (!$this->update_user($user)) return null;
                $this->response("Verification successful", true);
            }
        }
        $this->response('Something went wrong. Please try again.');
    }

    protected function reset($email = null, $update_password = false)
    {
        if (!$email) {
            $email = isset($_POST['user']) && is_string($_POST['user']) ? $_POST['user'] : null;
            if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $this->response("Invalid email addresses provided.");
        }

        $user = $this->userDetails(['email' => $email], 'id, name, email, status');
        //if (!$user) $this->response("The email you entered did not match our records.");
        if ($user && $user['status'] != 0) {
            $payload["exp"] = time() + 3600;
            $payload["uid"] = $user['id'];
            $setting = $this->settings(['site_name', 'site_email', 'site_url', 'jwt_key']);
            try {
                $key = $setting['jwt_key'];
                $jwt = JWT::encode($payload, $key, 'HS256');
            } catch (\Exception $e) {
                $this->response("Something went wrong, Please try again.");
            }

            if ($update_password) {
                // mail information
                $subject = "Update your $setting[site_name] password";
                $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
                $body .= "Please update your $setting[site_name] account password to continue logging in with your password." . PHP_EOL . PHP_EOL;
                $body .= "To select a new password, click on the link below:" . PHP_EOL;
                $body .= $setting['site_url'] . "reset?token=$jwt" . PHP_EOL . PHP_EOL;
                $body .= "If you don't want to update your password, please ignore this email and do not share this link with anyone." . PHP_EOL;
                $to = [$user['email'] => $user['name']];
                $from = [$setting['site_email'] => $setting['site_name']];
                $mail = Helper::sendMail($to, $subject, $body, $from);
            } else {
                // mail information
                $subject = "How to reset your $setting[site_name] password";
                $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
                $body .= "We received a request to reset your $setting[site_name] password." . PHP_EOL . PHP_EOL;
                $body .= "To select a new password, click on the link below:" . PHP_EOL;
                $body .= $setting['site_url'] . "reset?token=$jwt" . PHP_EOL . PHP_EOL;
                $body .= "If you didn't request to change your password, please ignore this email and do not share this link with anyone." . PHP_EOL;
                $to = [$user['email'] => $user['name']];
                $from = [$setting['site_email'] => $setting['site_name']];
                $mail = Helper::sendMail($to, $subject, $body, $from);
            }
            if (!$mail) $this->response("Our mail server not responding, Please try again later.");
        }

        if ($update_password) $this->response("We have sent an email, please check your inbox and follow the instructions to update your password.");
        $this->response("We have sent an email, please check your inbox and follow the instructions to reset your password.", true);
    }

    protected function password_update()
    {
        $token = !empty($_POST['token']) && is_string($_POST['token']) ? $_POST['token'] : null;
        if (!$token) $this->response("Reset link is invalid or expired.");
        $setting = $this->settings(['site_name', 'site_email', 'site_url', 'jwt_key']);
        try {
            $key = $setting['jwt_key'];
            $jwt = JWT::decode($token, new Key($key, 'HS256'));
        } catch (\Exception $e) {
            $this->response("Reset link is invalid or expired.");
        }

        $uid = isset($jwt->uid) && $jwt->uid ? $jwt->uid : null;
        if (!$uid) $this->response("Reset link is invalid or expired.");
        $password = !empty($_POST['pass']) && is_string($_POST['pass']) ? $_POST['pass'] : null;
        if (!$password || strlen($password) < 8) $this->response("Password must be at least 8 characters.");

        $user = $this->userDetails(['id' => $uid], 'id, name, email, password, role, status');
        if (!$user) $this->response("Something went wrong, Please try again.");
        if ($user['status'] == 0) $this->response("This account is blocked.");
        $new_password = password_hash($password, PASSWORD_DEFAULT);
        $update = DB::update('users', ['password' => $new_password], ['id' => $user['id']]);
        if ($update) {
            $browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
            $key = $setting['jwt_key'] . ($user['password'] ? substr($user['password'], 12, 6) : $user['id']);
            $dvh = hash_hmac('md5', $user['id'] . $browser, $key);
            setcookie('DVK', $dvh, time() + 31536000, '/');
            if (!$this->update_user($user)) return null;

            // mail information
            $subject = "Your $setting[site_name] account password has been changed";
            $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
            $body .= "This message is to confirm that your $setting[site_name] account password has been changed successfully." . PHP_EOL;
            $body .= "If you didn't request to change your password, please contact us immediately at $setting[site_email]" . PHP_EOL;
            $to = [$user['email'] => $user['name']];
            $from = [$setting['site_email'] => $setting['site_name']];
            $mail = Helper::sendMail($to, $subject, $body, $from);
            $this->response("Your $setting[site_name] account password has been updated successfully.", true);
        }
        $this->response("Something went wrong, Please try again.");
    }

    protected function signup()
    {
        $name = !empty($_POST['name']) && is_string($_POST['name']) ? Helper::input($_POST['name']) : null;
        $company = !empty($_POST['company']) && is_string($_POST['company']) ? Helper::input($_POST['company']) : null;
        $email = !empty($_POST['email']) && is_string($_POST['email']) ? trim(strtolower($_POST['email'])) : null;
        $password = !empty($_POST['password']) && is_string($_POST['password']) ? $_POST['password'] : null;
        if (!$name || strlen($name) < 4) $this->response("Name must be at least 4 characters.");
        if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) $this->response("Invalid email address.");
        if (!$password || strlen($password) < 8) $this->response("Password must be at least 8 characters.");
        $result = $this->userDetails(['email' => $email], 'id');
        if ($result) $this->response("This email is already registered. Please log in.");
        $setting = $this->settings(['site_name', 'site_email', 'site_url', 'jwt_key', 'registration_status', 'email_verification', 'mailchimp_status', 'license_key', 'purchase_code']);
        if (!$setting['registration_status']) $this->response("New user registration deactivated", false);
        $domain_name = isset($_SERVER['HTTP_HOST']) ? preg_replace('#^(?:www\.)+(.+\.)#i', '$1', $_SERVER['HTTP_HOST']) : null;
        if (!hash_equals($setting['license_key'], hash_hmac('sha256', $domain_name, $setting['purchase_code']))) return null;
        if ($setting['email_verification']) {
            $verification_code = random_int(100000, 999999);
            $subject = "$setting[site_name] account email verification";
            $body  = "Hello $name," . PHP_EOL . PHP_EOL;
            $body .= "We received a request to create $setting[site_name] account. To verify your email address, please use the following verification code." . PHP_EOL . PHP_EOL;
            $body .= "Verification code: $verification_code" . PHP_EOL . PHP_EOL;
            $body .= "If you didn't request to create an account, please ignore this email and do not share this verification code with anyone." . PHP_EOL;
            $to = [$email  => $name];
            $from = [$setting['site_email'] => $setting['site_name']];
            $mail = Helper::sendMail($to, $subject, $body, $from);
            if (!$mail) $this->response("Our mail server not responding, Please try again later.", false);
            $_SESSION['EV'] = [
                'name' => $name,
                'company' => $company,
                'email' => $email,
                'password' => $password,
                'code' => $verification_code
            ];
            $this->response(null, false, ['verification' => true]);
        }

        $data = [
            'name' => $name,
            'company' => $company,
            'email' => strtolower($email),
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'status' => 2, // 2 = pending for email verification
        ];
        $uid = DB::insert('users', $data);
        if (!$uid) $this->response("Something went wrong, Please try again.");
        $user = $this->userDetails(['id' => $uid], 'id, name, email, password, role');
        if ($user) {
            $key = $setting['jwt_key'] . ($user['password'] ? substr($user['password'], 12, 6) : $user['id']);
            $browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
            $dvh = hash_hmac('md5', $user['id'] . $browser, $key);
            setcookie('DVK', $dvh, time() + 31536000, '/');
            if (!$this->update_user($user)) return null;

            // update subscription
            $this->updateSubscription($user['id']);
            // Generate verify link
            $payload["exp"] = time() + 259200;
            $payload["uid"] = $user['id'];
            $key = $setting['jwt_key'];
            try {
                $jwt = JWT::encode($payload, $key, 'HS256');
            } catch (\Exception $e) {
                //
            }
            // send email verification link
            if (!empty($jwt)) {
                // mail information
                $verify_link = rtrim($setting['site_url'], '/') . "/my/account?token=$jwt";
                $subject = "$setting[site_name] account created.";
                $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
                $body .= "Your account has been created on $setting[site_name]" . PHP_EOL . PHP_EOL;
                $body .= "Please click on the link below to verify your email address:" . PHP_EOL . $verify_link . PHP_EOL . PHP_EOL;
                $body .= "If you didn't sign up for this account, do not share this link with anyone or you are having trouble with your account, please contact us at $setting[site_email] and we will be happy to help you." . PHP_EOL;
                $to = [$user['email'] => $user['name']];
                $from = [$setting['site_email'] => $setting['site_name']];
                $mail = Helper::sendMail($to, $subject, $body, $from);
            }

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
            if (isset($_SESSION['EV'])) unset($_SESSION['EV']);
            $this->response("Congratulations! Your have successfully created your account on $setting[site_name].", true);
        }
        $this->response("Something went wrong, Please try again.");
    }

    protected function signup_verification()
    {
        $verification_code = !empty($_POST['code']) ? trim($_POST['code']) : null;
        $code = isset($_SESSION['EV']['code']) ? $_SESSION['EV']['code'] : null;
        $name = isset($_SESSION['EV']['name']) ? $_SESSION['EV']['name'] : null;
        $company = isset($_SESSION['EV']['company']) ? $_SESSION['EV']['company'] : null;
        $email = isset($_SESSION['EV']['email']) ? $_SESSION['EV']['email'] : null;
        $password = isset($_SESSION['EV']['password']) ? $_SESSION['EV']['password'] : null;
        $result = $this->userDetails(['email' => $email], 'id');
        if ($result) $this->response("This email is already registered. Please log in.");
        if ($email && $verification_code && $verification_code == $code) {
            $data = [
                'name' => $name,
                'company' => $company,
                'email' => strtolower($email),
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'status' => 1, // 1 = email verified
            ];
            $uid = DB::insert('users', $data);
            if (!$uid) $this->response("Something went wrong, Please try again.");
            $user = $this->userDetails(['id' => $uid], 'id, name, email, password, role');
            if ($user) {
                $setting = $this->settings(['site_name', 'site_email', 'site_url', 'jwt_key', 'mailchimp_status']);
                $key = $setting['jwt_key'] . ($user['password'] ? substr($user['password'], 12, 6) : $user['id']);
                $browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
                $dvh = hash_hmac('md5', $user['id'] . $browser, $key);
                setcookie('DVK', $dvh, time() + 31536000, '/');
                if (!$this->update_user($user)) return null;

                // update subscription
                $this->updateSubscription($user['id']);
                // mail information
                $subject = "$setting[site_name] account created.";
                $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
                $body .= "Your account has been created on $setting[site_name]." . PHP_EOL . PHP_EOL;
                $body .= "If you didn't sign up for this account, or you are having trouble with your account, please contact us at $setting[site_email] and we will be happy to help you." . PHP_EOL;
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
                if (isset($_SESSION['EV'])) unset($_SESSION['EV']);
                $this->response("Congratulations! You have successfully created your $setting[site_name] account.", true);
            }
        }
        $this->response("Incorrect verification code provided.");
    }

    public function updateSubscription($uid)
    {
        $setting = $this->settings(['free_plan', 'credits_words', 'credits_images']);
        DB::update('users', ['words' => $setting['credits_words'], 'images' => $setting['credits_images']], ['id' => $uid]);
        if (!empty($setting['free_plan'])) {
            $plan = DB::select('plans', '*', ['id' => $setting['free_plan']], 'LIMIT 1');
            if (!empty($plan[0])) {
                $user_data['plan_id'] = $plan[0]['id'];
                $user_data['words'] = $plan[0]['words'];
                $user_data['images'] = $plan[0]['images'];
                if ($plan[0]['duration'] != 'prepaid') {
                    $datetime = new \DateTime(date('Y-m-d H:i:s'));
                    $duration = $plan[0]['duration'];
                    $user_data['expired'] = $datetime->modify("+1 $duration")->format('Y-m-d H:i:s');
                }
                DB::update('users', $user_data, ['id' => $uid]);
            }
        }
    }

    public function update_user($user)
    {
        if (empty($user['id'])) return;
        $browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : null;
        $session = uniqid();
        $_SESSION['UID'] = $user['id'];
        setcookie('SID', md5($browser . $session), time() + 31556926, "/");
        setcookie('UID', $user['id'], time() + 31556926, "/");
        DB::update('users', ['logged' => date('Y-m-d H:i:s'), 'session' => $session], ['id' => $user['id']]);
        if (isset($_SESSION['UID'])) return true;
    }

    public function response($message, $status = false, $data = [])
    {
        $data['status'] = $status;
        $data['message'] = $message;
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($data);
        exit;
    }
}
