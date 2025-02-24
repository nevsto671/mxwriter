<?php

namespace Controller\User;

use DB;
use Pagination;
use Controller\UserController;

class Referrals extends UserController
{
    public function index()
    {
        $setting = $this->settings(['affiliate_status', 'minimum_payout', 'maximum_affiliate', 'commission_rate']);
        if (!$setting['affiliate_status']) $this->redirect("my");

        // check total affiliate
        $affiliate_users = DB::query('SELECT COUNT(*) AS affiliate_user FROM users WHERE referral_id IS NOT NULL');
        $total_affiliate = isset($affiliate_users[0]['affiliate_user']) ? $affiliate_users[0]['affiliate_user'] : 0;
        $affiliateAllow = $setting['maximum_affiliate'] > $total_affiliate ? true : false;

        $user = $this->userDetails(['id' => $this->uid], 'balance, referral_id');
        $balance = isset($user['balance']) ? $user['balance'] : 0;
        $referral_id = isset($user['referral_id']) ? $user['referral_id'] : null;
        if (empty($referral_id) && $affiliateAllow) {
            $referral_id = rand();
            $user = $this->userDetails(['id' => $this->uid], 'balance, referral_id');
            $userRef = DB::select('users', 'id', ['id' => $this->uid, 'referral_id' => $referral_id]);
            if ($userRef) $this->redirect("my/referrals");
            DB::update('users', ['referral_id' => $referral_id], ['id' => $this->uid]);
        }

        // update referrals commission
        $completed =  DB::query("SELECT * FROM referrals WHERE user_id = $this->uid AND status = 2 AND created <= NOW() - INTERVAL 30 DAY ORDER BY created ASC LIMIT 100");
        if (!empty($completed)) {
            foreach ($completed as $val) {
                $update =  DB::update('referrals', ['status' => 1], ['id' => $val['id']]);
                if ($update) $balance += $val['earnings'];
            }
            DB::update('users', ['balance' => $balance], ['id' => $this->uid]);
        }

        // Withdraw
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $balance >= $setting['minimum_payout']) {
            $data['user_id'] = $this->uid;
            $data['amount'] = $balance;
            $data['description'] = 'Payout';
            $data['address'] = !empty($_POST['address']) ? $_POST['address'] : null;
            $data['status'] = 2;
            $id = DB::insert('payouts', $data);
            if ($id) {
                DB::update('users', ['balance' => 0], ['id' => $this->uid]);
                $this->redirect("my/referrals", "Your withdrawal has been successfully processed. The funds will be available in your account shortly.");
            }
            $this->redirect("my/referrals", "Your withdrawal attempt has failed.");
        }

        $limit = 50;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $referrals = DB::query("select referrals.*, users.name From referrals LEFT JOIN users ON referrals.referred_id=users.id WHERE referrals.user_id=$this->uid ORDER BY referrals.created DESC LIMIT $offset, $limit");
        $total = DB::count('referrals', ['user_id' => $this->uid]);
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);

        $payout_limit = 50;
        $payout_page = !empty($_GET['payout_page']) && is_numeric($_GET['payout_page']) ? $_GET['payout_page'] : 1;
        $payout_offset = ($payout_page * $payout_limit) - $payout_limit;
        $payouts = DB::query("select payouts.*, users.name From payouts LEFT JOIN users ON payouts.user_id=users.id WHERE payouts.user_id=$this->uid ORDER BY payouts.created DESC LIMIT $payout_offset, $payout_limit");
        $payout_total = DB::count('payouts', ['user_id' => $this->uid]);
        $payout_pager = new Pagination($payout_page, $payout_limit, 'payout_page');
        $payout_pager->total($payout_total);
        $payout_pagination = $payout_pager->execute(true);

        // total payout
        $transaction = DB::query("SELECT SUM(amount) AS total_earning FROM payouts WHERE user_id = $this->uid AND status = 1;");
        $total_earning = !empty($transaction[0]['total_earning']) ? $transaction[0]['total_earning'] : 0;

        $this->title('Referrals');
        require_once APP . '/View/User/Referrals.php';
    }
}
