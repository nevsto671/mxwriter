<?php

namespace Controller\User;

use DB;
use Controller\UserController;

class Usage extends UserController
{

    public function index()
    {
        // get usage 
        $uid = $this->uid;
        $usages = DB::query("select words,date From usages WHERE user_id=$uid AND MONTH(date) = MONTH(now()) AND YEAR(date) = YEAR(now()) ORDER by date ASC");

        // total word usage calculate 
        $usage_words = 0;
        foreach ($usages as $val) {
            $usage_words += $val['words'];
        }

        $data_arr = [];
        // for each day in the month
        for ($i = 1; $i <=  date('t'); $i++) {
            $day = str_pad($i, 2, '0', STR_PAD_LEFT);
            $date = date('Y') . "-" . date('m') . "-" . $day;
            foreach ($usages as $val) {
                if ($date == $val['date']) {
                    $data_arr[$i]['x'] = $val['date'];
                    $data_arr[$i]['y'] = $val['words'];
                    break;
                } else {
                    $data_arr[$i]['x'] =  $date;
                    $data_arr[$i]['y'] = 0;
                }
            }
        }

        // calculate percentage
        $user = $this->userDetails(['id' => $uid], 'plan_id, words, expired, status');
        if (isset($user['status']) && $user['status'] == 0) $this->redirect('logout');
        $plan = DB::select('plans', '*', ['id' => $user['plan_id']], 'LIMIT 1');
        $plan_name = isset($plan[0]['name']) ? $plan[0]['name'] : 'No';
        $remaining_words = isset($user['words']) ? $user['words'] : null;
        $total_word = !is_null($remaining_words) ? $usage_words + $remaining_words : 0;
        $usage_percentage = 0;
        if ($total_word && $usage_words) {
            $usage_percentage = $total_word >= $usage_words ? round($usage_words / ($total_word / 100)) : 100;
        }

        $this->title('Usage');
        require_once APP . '/View/User/Usage.php';
    }
}
