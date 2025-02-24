<?php

namespace Controller;

use DB;

class Signup extends Controller
{
    public function index()
    {
        if ($this->uid) $this->redirect("my");
        $setting = self::settings(['registration_status']);
        if (!$setting['registration_status']) $this->redirect('login');

        $provider_results = DB::select('providers', '*', ['status' => 1]);
        $provider = [];
        foreach ($provider_results as $val) {
            $provider[$val['name']] = $val;
        }

        if ($this->uid) $this->redirect("my");
        $this->title('Sign up for an account', true);
        require_once APP . '/View/Signup.php';
    }
}
