<?php

namespace Controller\Web;

use DB;
use Controller\WebController;

class Home extends WebController
{
    public function index()
    {
        if ($this->uid) $this->redirect('my');
        if (!$this->setting['frontend_status']) $this->redirect('login');
        $templates = DB::select('templates', 'title, slug, description, color, icon', ['status' => 1, 'landing' => 1], 'ORDER by modified DESC');
        $plan_results = DB::select('plans', '*', ['status' => 1], 'ORDER BY images, price');
        $plans = [];
        foreach ($plan_results as $key => $val) {
            $plans[$val['duration']][$key] = $val;
        }
        $testimonials = DB::select('testimonials', '*', [], 'ORDER BY id DESC LIMIT 16');
        require_once APP . '/View/Web/Home.php';
    }
}
