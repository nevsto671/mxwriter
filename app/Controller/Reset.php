<?php

namespace Controller;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Reset extends Controller
{
    public function index()
    {
        if ($this->uid) $this->redirect("my");
        $setting = $this->settings(['site_name', 'site_email', 'jwt_key', 'site_url']);
        if (!empty($_GET['token'])) {
            $token = is_string($_GET['token']) ? $_GET['token'] : null;
            $key = $setting['jwt_key'];
            $validToken = false;
            try {
                $jwt = JWT::decode($token, new Key($key, 'HS256'));
                $uid = isset($jwt->uid) && $jwt->uid ? $jwt->uid : null;
                if ($uid) $validToken = true;
            } catch (\Exception $e) {
                $validToken = false;
            }
        }
        $this->title('Reset password');
        require_once APP . '/View/Reset.php';
    }
}
