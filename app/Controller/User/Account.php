<?php

namespace Controller\User;

use DB;
use Helper;
use Controller\UserController;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Account extends UserController
{
    public function index()
    {
        $result = DB::select('users', '*', ['id' => $this->uid], "LIMIT 1");
        $user = isset($result[0]) ? $result[0] : null;
        $plan_result = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;
        $setting = $this->settings(['site_name', 'site_email', 'site_url', 'jwt_key']);

        // email verification via link
        if (isset($_GET['token']) && is_string($_GET['token'])) {
            $setting = $this->settings(['jwt_key']);
            try {
                $key = $setting['jwt_key'];
                $jwt = JWT::decode($_GET['token'], new Key($key, 'HS256'));
                $uid = $jwt && isset($jwt->uid) ? $jwt->uid : null;
                if ($uid && $uid == $user['id']) {
                    $user = $this->userDetails(['id' => $uid], 'id, status');
                    if ($user) {
                        $update = DB::update('users', ['status' => 1], ['id' => $user['id']]);
                        if ($update) $this->redirect('my/account', "Your email address has been verified successfully.", "success");
                        $this->redirect("my");
                    }
                }
            } catch (\Exception $e) {
                //
            }
            $this->redirect("my/account", "Sorry, the link you clicked may have already expired.", "error");
        }

        // resend email verification link
        if (isset($_GET['verification']) && is_string($_GET['verification']) && $_GET['verification'] == md5(date('Ymd'))) {
            $setting = $this->settings(['site_name', 'site_email', 'site_url', 'jwt_key']);
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
                $subject = "$setting[site_name] account email verification.";
                $body  = "Hello $user[name]," . PHP_EOL . PHP_EOL;
                $body .= "Please click on the link below to verify your email address:" . PHP_EOL . $verify_link . PHP_EOL . PHP_EOL;
                $body .= "If you didn't request to email verification, please ignore this email and do not share this link with anyone." . PHP_EOL;
                $to = [$user['email'] => $user['name']];
                $from = [$setting['site_email'] => $setting['site_name']];
                $mail = Helper::sendMail($to, $subject, $body, $from);
                if ($mail) $this->redirect("my/account", "Verification email has been resent. Kindly click on the link provided in the email to complete the verification process.", "success");
            }
            $this->redirect("my/account", "Sorry, we were unable to resend the verification email. Please try again later.", "error");
        }

        // update email
        if (isset($_GET['email']) && is_string($_GET['email'])) {
            $current_password = !empty($_POST['password']) && is_string($_POST['password']) ? trim($_POST['password']) : null;
            $verification_code = !empty($_POST['code']) && is_string($_POST['code']) ? trim($_POST['code']) : null;
            if ($verification_code && $current_password) {
                $token = isset($_GET['email']) ? $_GET['email'] : null;
                $user = $this->userDetails(['id' => $this->uid], 'password');
                if ($user && password_verify($current_password, $user['password'])) {
                    $key = $setting['jwt_key'] . $this->uid . $verification_code;
                    try {
                        $jwt = JWT::decode($token, new Key($key, 'HS256'));
                        $email = isset($jwt->email) && $jwt->email ? $jwt->email : null;
                        if ($email) {
                            DB::update('users', ['email' => strtolower($email), 'status' => 1], ['id' => $this->uid]);
                            $this->redirect("my/account", "Your account details were changed successfully.", "success");
                        } else {
                            $this->redirect("my/account", "Something went wrong, Please try again.", "error");
                        }
                    } catch (\Exception $e) {
                        $this->redirect("my/account?email=$token", "Incorrect verification code provided.", "error");
                    }
                } else {
                    $this->redirect("my/account?email=$token", "The current password you entered did not match our records.", "error");
                }
            }
        }

        // change password
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['current_password']) && !empty($_POST['new_password'])) {
            $current_password = !empty($_POST['current_password']) ? $_POST['current_password'] : null;
            $new_password = !empty($_POST['new_password']) ? $_POST['new_password'] : null;
            $confirm_password = !empty($_POST['confirm_password']) ? $_POST['confirm_password'] : null;
            $user = $this->userDetails(['id' => $this->uid], 'id, password');
            if ($user) {
                if (!$current_password || !password_verify($current_password, $user['password'])) $this->redirect("my/account", "The current password you entered did not match our records.", "error");
                if (!$new_password || strlen($new_password) < 8) $this->redirect("my/account", "Password must be at least 8 characters.", "error");
                if ($confirm_password != $new_password) $this->redirect("my/account", "Confirm password don't match", "error");
                $password = password_hash($new_password, PASSWORD_DEFAULT);
                $update = DB::update('users', ['password' => $password, 'session' => null], ['id' => $user['id']]);
                if ($update) $this->redirect("my/account", "Your account password were changed successfully.", "success");
            }
            $this->redirect("my/account", "Something went wrong, Please try again.", "error");
        }

        // update profile
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['name'])) {
            $name = !empty($_POST['name']) && is_string($_POST['name']) ? Helper::input($_POST['name']) : null;
            $email = !empty($_POST['email']) && is_string($_POST['email']) ? trim(strtolower($_POST['email'])) : null;
            if (!$name || strlen($name) < 4) return $this->redirect("my/account", "Name must be at least 4 characters.", "error");
            $data['name'] = $name;
            $update = DB::update('users', $data, ['id' => $this->uid]);

            // update email address
            if ($email && $email != $user['email']) {
                $user = $this->userDetails(['email' => $email]);
                if (!$user) {
                    $verification_code = random_int(100000, 999999);
                    $subject = "$setting[site_name] account email verification";
                    $body  = "Hello $name," . PHP_EOL . PHP_EOL;
                    $body .= "We received a request to update $setting[site_name] account email address. To verify your email address, please use the following verification code." . PHP_EOL . PHP_EOL;
                    $body .= "Verification code: $verification_code" . PHP_EOL . PHP_EOL;
                    $body .= "If you didn't request to update email address, please ignore this email and do not share this verification code with anyone." . PHP_EOL;
                    $to = [$email  => $name];
                    $from = [$setting['site_email'] => $setting['site_name']];
                    $mail = Helper::sendMail($to, $subject, $body, $from);
                    if (!$mail) $this->redirect("my/account", "Our mail server not responding, Please try again later.", "error");

                    $payload["exp"] = time() + 600;
                    $payload["email"] = $email;
                    $key = $setting['jwt_key'] . $this->uid . $verification_code;
                    try {
                        $jwt = JWT::encode($payload, $key, 'HS256');
                        $this->redirect("my/account?email=$jwt", "Email address verification required.", "warning");
                    } catch (\Exception $e) {
                        //
                    }
                } else {
                    $this->redirect("my/account", "Email address already exist in another account.", "warning");
                }
            }

            $this->redirect("my/account", "Your account details were changed successfully.", "success");
        }

        $myModels = DB::query("SELECT * FROM models WHERE user_id = 0 OR user_id = $this->uid");
        $models = DB::select('models', '*', ['user_id' => $this->uid]);
        $this->title('My Account');
        require_once APP . '/View/User/Account.php';
    }
}
