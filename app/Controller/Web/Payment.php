<?php

namespace Controller\Web;

use DB;
use Gateway;
use Controller\WebController;

class Payment extends WebController
{

    public function index()
    {
        if ($this->uid) $this->redirect("my");
        if (!$this->flash()) $this->redirect(null);
        $this->title('Payment');
        require_once APP . '/View/Web/Payment.php';
    }

    // payment succeeded
    public function success()
    {
        $transaction_id = isset($_GET['transactionId']) && is_string($_GET['transactionId']) ? $_GET['transactionId'] : null;
        if ($transaction_id) {
            $this->redirect("payment/$transaction_id");
        }
        if ($this->uid) $this->redirect("my/billing", "Your subscription plan has been successfully updated.", "success");
        $this->redirect("payment?success", "Your subscription plan has been successfully updated.", "success");
    }

    // payment cancelled
    public function cancel()
    {
        $transaction_id = isset($_GET['transactionId']) && is_string($_GET['transactionId']) ? $_GET['transactionId'] : null;
        if ($transaction_id) {
            // update payment status cancel
            $tran = DB::select('transactions', 'id', ['id' => $transaction_id, 'status' => 0, 'payment_status' => 2, 'offline_payment' => 0], 'LIMIT 1');
            if (!empty($tran[0]['id'])) {
                DB::update('transactions', ['payment_status' => 0], ['id' => $tran[0]['id']]);
            }
        }

        if ($this->uid) $this->redirect("my/plans");
        $this->redirect("payment?cancel", "Payment canceled!", "error");
    }

    // Transaction Listener
    public function transaction($transaction_id)
    {
        $completed = $this->completed($transaction_id);
        if ($completed) {
            $this->success();
        } else {
            $this->cancel();
        }
    }

    // Fulfill Orders
    public function completed($transaction_id)
    {
        $transaction_result = DB::select('transactions', '*', ['id' => $transaction_id], 'LIMIT 1');
        if (!$transaction_result) $transaction_result = DB::select('transactions', '*', ['payment_id' => $transaction_id], 'LIMIT 1');
        $transaction = isset($transaction_result[0]) ? $transaction_result[0] : null;
        // transaction not found
        if (empty($transaction)) return null;
        // check payment is already paid and subscription is already active
        if ($transaction['payment_status'] == 1 && $transaction['status'] == 1) return true;

        // get transaction released subscription plan information
        $plan_result = DB::select('plans', '*', ['id' => $transaction['plan_id']], 'LIMIT 1');
        $plan = isset($plan_result[0]) ? $plan_result[0] : null;
        $user = $this->userDetails(['id' => $transaction['user_id']], 'payment_method, subscription_id');

        // check payment is unpaid
        if ($transaction['payment_status'] != 1) {
            $provider = !empty($transaction['method']) ? $transaction['method'] : null;
            $payment_id = !empty($transaction['payment_id']) ? $transaction['payment_id'] : null;
            if ($provider && $payment_id) {
                // transaction verification
                $payment = new Gateway($provider);
                if (!empty($payment->gateway)) {
                    $response = $payment->gateway->capture($payment_id);
                    if ($response) {
                        // cancel existing subscription plan if user update current plan
                        if (!empty($user['subscription_id']) && $plan != 'prepaid') {
                            $payment = new Gateway($user['payment_method']);
                            if (!empty($payment->gateway)) {
                                if (method_exists($payment->gateway, 'cancelSubscription')) {
                                    $payment->gateway->cancelSubscription($user['subscription_id']);
                                    $plan_extended = true;
                                }
                            }
                        }
                        // update user subscription information 
                        if (!empty($response['subscription_id'])) {
                            DB::update('users', ['payment_method' => $provider, 'customer_id' => $response['customer_id'], 'subscription_id' => $response['subscription_id']], ['id' => $transaction['user_id']]);
                        }
                        // update payment status paid
                        if (isset($response['total_amount'])) $data['amount'] = $response['total_amount'];
                        $data['payment_status'] = 1;
                        $update = DB::update('transactions', $data, ['id' => $transaction['id']]);
                        if ($update) {
                            $transaction_result = DB::select('transactions', '*', ['id' => $transaction['id']], 'LIMIT 1');
                            $transaction = isset($transaction_result[0]) ? $transaction_result[0] : null;
                            // update referrals
                            $this->updateReferrals($transaction);
                        }
                    }
                }
            }
        }

        // check subscription is inactive
        if ($transaction['payment_status'] == 1 && $transaction['status'] == 0) {
            if (!empty($plan)) {
                // update user plan
                $plan_extended = isset($plan_extended) ? $plan_extended : false;
                $update =  $this->update_subscription($transaction['user_id'], $transaction['plan_id'], $transaction['id'], null, $plan_extended);
                if ($update) {
                    // update subscription pending to active
                    DB::update('transactions', ['status' => 1], ['id' => $transaction['id']]);
                    return true;
                }
            }
        }
        return null;
    }

    // Instant Payment Notification
    public function webhook($provider)
    {
        $gateways = DB::select('gateways', 'provider', ['provider' => $provider, 'status' => 1, 'type' => 'payment'], 'LIMIT 1');
        $provider = isset($gateways[0]['provider']) ? $gateways[0]['provider'] : null;
        if ($provider) {
            $payment = new Gateway($provider);
            if (!empty($payment->gateway)) {
                // check webhook exist 
                if (method_exists($payment->gateway, 'webhook')) {
                    $response = $payment->gateway->webhook();
                    if ($response) {
                        $transaction_result = DB::select('transactions', '*', ['payment_id' => $response['payment_id']], 'LIMIT 1');
                        $transaction_id = isset($transaction_result[0]['id']) ? $transaction_result[0]['id'] : null;
                        // check transaction for prevent double payment 
                        // if transaction not found then create transactions for subscription renewal type request
                        // empty reference_id means subscription renewal type request
                        if (empty($transaction_id) && !empty($response['subscription_id']) && empty($response['reference_id']) && !empty($response['payment_id'])) {
                            // for subscription payment 
                            $user = $this->userDetails(['customer_id' => $response['customer_id'], 'subscription_id' => $response['subscription_id']], 'id, plan_id');
                            if (!empty($user)) {
                                // user plan info
                                $plan_result = DB::select('plans', '*', ['id' => $user['plan_id'], 'status' => 1], 'LIMIT 1');
                                $plan = isset($plan_result[0]) ? $plan_result[0] : null;;
                                if (!empty($plan)) {
                                    $setting = $this->settings(['currency', 'tax']);
                                    $price = $plan['price'];
                                    $subtotal = $price;
                                    $tax = isset($setting['tax']) ? round((($setting['tax'] / 100) * $subtotal), 2)  : 0;
                                    $total_amount = isset($response['total_amount']) ? $response['total_amount'] : round($subtotal + $tax, 2);
                                    // create new transaction
                                    $data['payment_id'] = $response['payment_id'];
                                    $data['method'] = $provider;
                                    $data['currency'] = $setting['currency'];
                                    $data['amount'] = $total_amount;
                                    $data['tax'] = $tax;
                                    $data['user_id'] = $user['id'];
                                    $data['plan_id'] = $user['plan_id'];
                                    $data['payment_status'] = 1; // payment paid
                                    $data['status'] = 0; // order pending 
                                    $data['created'] = date('Y-m-d H:i:s');
                                    $transaction_id = DB::insert('transactions', $data);
                                }
                            }
                        }

                        // completed order
                        if ($transaction_id) {
                            $this->completed($transaction_id);
                        }
                    }
                }
            }
        }
        http_response_code(200);
        exit();
    }

    protected function updateReferrals($transaction)
    {
        $setting = $this->settings(['affiliate_status', 'minimum_payout', 'maximum_referral', 'commission_rate', 'tax']);
        if (empty($setting['affiliate_status'])) return;
        if (empty($transaction)) return;
        $referralId = isset($_COOKIE['REF']) ? $_COOKIE['REF'] : null;
        if (empty($referralId)) return;
        setcookie('REF', '', time() - 3600, '/');
        $user = DB::select('users', 'id', ['referral_id' => $referralId], 'LIMIT 1');
        if (empty($user[0])) return;
        if ($user[0]['id'] == $transaction['user_id']) return;

        // check total referrals
        $total_referred = DB::count('referrals', ['user_id' => $transaction['user_id']]);
        if ($total_referred > $setting['maximum_referral']) return;

        // check total transaction
        $total_transaction = DB::count('transactions', ['user_id' => $transaction['user_id'], 'payment_status' => 1]);
        if ($total_transaction != 1) return;
        $transaction_amount = !empty($transaction['amount']) ? $transaction['amount'] : 0;
        $transaction_tax = !empty($transaction['tax']) ? $transaction['tax'] : 0;
        $total_transaction_amount = $transaction_amount - $transaction_tax;

        // commission percentage
        $commission = ($total_transaction_amount / 100) * $setting['commission_rate'];
        $data['user_id'] = $user[0]['id'];
        $data['referred_id'] = $transaction['user_id'];
        $data['transaction_id'] = $transaction['id'];
        $data['transaction_amount'] = $total_transaction_amount;
        $data['earnings'] = $commission;
        $data['status'] = 2;
        DB::insert('referrals', $data);
    }
}
