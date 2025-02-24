<?php

namespace Controller\Admin;

use DB;
use Pagination;
use Controller\AdminController;

class Affiliates extends AdminController
{
    public function index()
    {
        $user = $this->userDetails(['id' => $this->uid], 'balance, referral_id');
        $balance = isset($user['balance']) ? $user['balance'] : 0;
        $referral_id = isset($user['referral_id']) ? $user['referral_id'] : null;
        if (empty($referral_id)) {
            $referral_id = rand();
            $user = $this->userDetails(['id' => $this->uid], 'balance, referral_id');
            $userRef = DB::select('users', 'id', ['id' => $this->uid, 'referral_id' => $referral_id]);
            if ($userRef) $this->redirect("my/referrals");
            DB::update('users', ['referral_id' => $referral_id], ['id' => $this->uid]);
        }

        if (!empty($_GET['payout']) && is_numeric($_GET['payout'])) {
            $payoutResult = DB::query("select payouts.*, users.name From payouts LEFT JOIN users ON payouts.user_id=users.id WHERE payouts.id = '$_GET[payout]' LIMIT 1");
            $payout = isset($payoutResult[0]) ? $payoutResult[0] : null;
            if (empty($payout)) $this->redirect("admin/affiliates");
            if (isset($_GET['status']) && $_GET['status'] == 'approve') {
                DB::update('payouts', ['status' => 1], ['id' => $_GET['payout']]);
                $this->redirect("admin/affiliates", "Approved");
            }

            if (isset($_GET['status']) && $_GET['status'] == 'declined') {
                DB::update('payouts', ['status' => 0], ['id' => $_GET['payout']]);
                $balance += $payout['amount'];
                DB::update('users', ['balance' => $balance], ['id' => $payout['user_id']]);
                $this->redirect("admin/affiliates", "Declined", "error");
            }
        }

        if (!empty($_GET['referral']) && is_numeric($_GET['referral'])) {
            if (isset($_GET['status']) && $_GET['status'] == 'approve') {
                DB::update('referrals', ['status' => 2], ['id' => $_GET['referral']]);
                $this->redirect("admin/affiliates", "Approved");
            }

            if (isset($_GET['status']) && $_GET['status'] == 'declined') {
                DB::update('referrals', ['status' => 0], ['id' => $_GET['referral']]);
                $this->redirect("admin/affiliates", "Declined", "error");
            }
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

        $limit = 50;
        $page = !empty($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
        $offset = ($page * $limit) - $limit;
        $referrals = DB::query("select referrals.*, users.name From referrals LEFT JOIN users ON referrals.referred_id=users.id ORDER BY referrals.created DESC LIMIT $offset, $limit");
        $total = DB::count('referrals');
        $pager = new Pagination($page, $limit);
        $pager->total($total);
        $pagination = $pager->execute(true);

        $payout_limit = 50;
        $payout_page = !empty($_GET['payout_page']) && is_numeric($_GET['payout_page']) ? $_GET['payout_page'] : 1;
        $payout_offset = ($payout_page * $payout_limit) - $payout_limit;
        $payouts = DB::query("select payouts.*, users.name From payouts LEFT JOIN users ON payouts.user_id=users.id ORDER BY payouts.created DESC LIMIT $payout_offset, $payout_limit");
        $payout_total = DB::count('payouts');
        $payout_pager = new Pagination($payout_page, $limit, 'payout_page');
        $payout_pager->total($payout_total);
        $payout_pagination = $payout_pager->execute(true);

        // total referral
        $total_referral = DB::count('referrals');

        // total success referral transaction amount
        $transaction = DB::query("SELECT SUM(transaction_amount) AS total_transaction_amount FROM referrals WHERE status = 1;");
        $total_transaction_amount = !empty($transaction[0]['total_transaction_amount']) ? $transaction[0]['total_transaction_amount'] : 0;

        // total payout
        $paid_transaction = DB::query("SELECT SUM(amount) AS total_payout_amount FROM payouts WHERE status = 1;");
        $total_payout_amount = !empty($paid_transaction[0]['total_payout_amount']) ? $paid_transaction[0]['total_payout_amount'] : 0;

        // total payout pending
        $payout_transaction = DB::query("SELECT SUM(amount) AS total_payout_pending FROM payouts WHERE status = 2;");
        $total_payout_pending  = !empty($payout_transaction[0]['total_payout_pending']) ? $payout_transaction[0]['total_payout_pending'] : 0;

        $this->title('Affiliates');
        require_once APP . '/View/Admin/Affiliates.php';
    }
}
