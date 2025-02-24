<?php

namespace Controller;

use DB;

class UserController extends Controller
{
    public $usage_percentage_left;

    function __construct()
    {
        parent::__construct();
        if (!$this->uid) $this->redirect("login");
        if ($this->rid != 1 && $this->setting['maintenance_status']) $this->maintenance();
        $this->get_usages();
    }

    public function get_usages()
    {
        // get usage 
        $uid = $this->uid;
        $usages = DB::query("select words,date From usages WHERE user_id=$uid AND MONTH(date) = MONTH(now()) AND YEAR(date) = YEAR(now()) ORDER by date ASC");
        // total word usage calculate 
        $usage_words = 0;
        foreach ($usages as $val) {
            $usage_words += $val['words'];
        }
        // calculate percentage
        $remaining_words = isset($this->user['words']) ? $this->user['words'] : null;
        $total_word = !is_null($remaining_words) ? $usage_words + $remaining_words : 0;
        $usage_percentage = 0;
        if ($total_word && $usage_words) {
            $usage_percentage = $total_word >= $usage_words ? round($usage_words / ($total_word / 100)) : 100;
        }
        $this->usage_percentage_left = 100 - $usage_percentage;
    }
}
