<?php

namespace Controller\User;

use DB;
use Gateway;
use Controller\UserController;

class Plans extends UserController
{
    public function index()
    {
        $setting = $this->settings(['tax', 'offline_payment', 'offline_payment_title', 'offline_payment_guidelines', 'offline_payment_recipient', 'free_plan', 'extended_status', 'license_key', 'purchase_code']);
        $user = $this->userDetails(['id' => $this->uid], 'name, email, plan_id, words, images, expired, payment_method, subscription_status');
        $extended_credits = $setting['extended_status'] == 1 ? ($setting['free_plan'] == $user['plan_id'] || $user['plan_id'] == 0 ? false : true) : true;

        if (!empty($_GET['id']) && is_numeric($_GET['id'])) {
            // update subscriptions
            $get_plan_id = !empty($_GET['id']) && is_numeric($_GET['id']) ? $_GET['id'] : null;
            $plan_result = DB::select('plans', '*', ['id' => $get_plan_id, 'status' => 1], 'LIMIT 1');
            $plan = isset($plan_result[0]) ? $plan_result[0] : null;
            if (empty($plan)) $this->redirect("my/billing");
            if ($user['plan_id'] == $plan['id']) $this->redirect("my/billing", "You are already subscribed this plan!", "error");
            if (!$extended_credits && $plan['duration'] == 'prepaid') $this->redirect("my/billing", "Sorry! You're not eligible for prepaid plan. Prepaid plan for paid subscriber only.", "error");
            $price = $plan['price'];
            $subtotal = $price;
            $tax = isset($setting['tax']) ? round((($setting['tax'] / 100) * $subtotal), 2)  : 0;
            $total_amount = round($subtotal + $tax, 2);
            $payments = DB::select('gateways', 'id, name, provider, title, status', ['status' => 1, 'type' => 'payment'], 'ORDER BY name ASC');
            $provider = isset($payments[0]['provider']) ? $payments[0]['provider'] : null;
            $direct_checkout = !$tax && !$setting['offline_payment'] && count($payments) == 1 ? $provider : null;

            if ($direct_checkout || ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['payment_method']))) {
                $payment_method = $direct_checkout ? $provider : (isset($_POST['payment_method']) && is_string($_POST['payment_method']) ? $_POST['payment_method'] : null);
                if (empty($payment_method)) $this->redirect("my/billing", "Sorry, the payment method is currently not available.", "error");
                if ($plan['price'] == 0) {
                    // cancel existing subscription plan
                    $this->cancelSubscription($this->uid);
                    $this->update_subscription($this->uid, $plan['id']);
                    $this->redirect("my/billing", "Your subscription plan has been successfully updated.", "success");
                }

                // transaction data
                $data['currency'] = $this->setting['currency'];
                $data['amount'] = $total_amount;
                $data['tax'] = $tax;
                $data['user_id'] = $this->uid;
                $data['plan_id'] = $plan['id'];
                $data['payment_status'] = 2;
                $data['created'] = date('Y-m-d H:i:s');

                // offline payment
                if ($setting['offline_payment'] && $payment_method == 'offline_payment') {
                    // create transaction for offline payment
                    $data['method'] = $setting['offline_payment_title'];
                    $data['offline_payment'] = 1;
                    $transaction_id = DB::insert('transactions', $data);
                    // add subscription 
                    // check prepaid plan
                    if ($plan['duration'] == 'prepaid') {
                        if (!empty($user['expired'])) {
                            $sdata['end'] = $user['expired'];
                        } else {
                            $datetime = new \DateTime(date('Y-m-d H:i:s'));
                            $sdata['end'] = $datetime->modify("+1 month")->format('Y-m-d H:i:s');
                        }
                    } else {
                        $datetime = new \DateTime(date('Y-m-d H:i:s'));
                        $sdata['end'] = $datetime->modify("+1 $plan[duration]")->format('Y-m-d H:i:s');
                    }
                    $sdata['plan_id'] = $plan['id'];
                    $sdata['user_id'] = $this->uid;
                    $sdata['transaction_id'] = $transaction_id;
                    $sdata['start'] = date('Y-m-d H:i:s');
                    $sdata['status'] = 2;
                    $subscription_id = DB::insert('subscriptions', $sdata);
                    $this->redirect("my/billing/subscriptions?id=$subscription_id", "Your subscription plan has been created and pending for payment.", "warning");
                }

                // online payment, create transaction
                $gateway_result = DB::select('gateways', '*', ['provider' => $payment_method, 'status' => 1], 'LIMIT 1');
                $provider_name = isset($gateway_result[0]['provider']) ? $gateway_result[0]['provider'] : null;
                $data['method'] = $provider_name;
                $transaction_id = DB::insert('transactions', $data);
                if ($transaction_id && $provider_name) {
                    $order['subscription'] = $gateway_result[0]['recurring'] && ($plan['duration'] == 'month' || $plan['duration'] == 'year') ? true : false;
                    $order['user'] = $user['name'];
                    $order['email'] = $user['email'];
                    $order['name'] = "Plan: " . $plan['name'];
                    $order['description'] = isset($plan['title']) ? $plan['title'] : null;
                    $order['billing_cycle'] = $plan['duration'] != 'prepaid' && $plan['duration'] ? $plan['duration'] : null;
                    $order['amount'] = $data['amount'];
                    $order['currency'] = $data['currency'];
                    $order['reference_id'] = $transaction_id;
                    $order['success_url'] = $this->url("payment/transaction/$transaction_id");
                    $order['cancel_url'] = $this->url("payment/cancel?transactionId=$transaction_id");
                    $payment = new Gateway($provider_name);
                    if (!empty($payment->gateway)) {
                        $response = $payment->gateway->order($order);
                        if (empty($response)) DB::delete('transactions', ['id' => $transaction_id]);
                        if (isset($response['id'])) {
                            $update =  DB::update('transactions', ['payment_id' => $response['id']], ['id' => $transaction_id]);
                            if ($update) {
                                if (!empty($response['redirect'])) {
                                    header("Location: $response[redirect]");
                                    exit;
                                } else if (!empty($response['html'])) {
                                    echo $response['html'];
                                    exit;
                                }
                            }
                        }
                    }
                }
                $this->redirect("my/plans", "Temporarily unable to checkout at the moment, please try again later.", "error");
            }
        }

        // get all plan
        $plan_results = DB::select('plans', '*', ['status' => 1], 'ORDER BY images, price');
        $plans = [];
        foreach ($plan_results as $key => $val) {
            $plans[$val['duration']][$key] = $val;
        }

        $this->title('Plans & Pricing');
        require_once APP . '/View/User/Plans.php';
    }
}
