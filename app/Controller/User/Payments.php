<?php

namespace Controller\User;

use DB;
use Helper;
use Gateway;
use Controller\UserController;

class Payments extends UserController
{
    public function index()
    {
        if (isset($_GET['provider']) && $_GET['provider'] == 'stripe' && isset($_GET['token']) && $_GET['token'] == $this->token) {
            $user = DB::select('users', 'customer_id', ['id' => $this->uid], "LIMIT 1");
            $customerId = isset($user[0]['customer_id']) ? $user[0]['customer_id'] : null;
            $returnUrl = $this->url('my/billing');
            $payment = new Gateway('Stripe');
            if (empty($customerId)) $this->redirect('my/billing/payments');
            if (!empty($payment->gateway)) {
                $response = $payment->gateway->updateBilling($customerId, $returnUrl);
                if (!empty($response['redirect'])) {
                    $payment_method_url = $response['redirect'] . '/payment-methods';
                    header('Location: ' . $payment_method_url);
                    exit;
                }
            }
            $this->redirect('my/billing/payments', 'Not available');
        }

        // add billing address
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['billing-address'])) {
            $data['billing_address'] = Helper::input($_POST['billing-address']);
            $data['billing_city'] = Helper::input($_POST['billing-city']);
            $data['billing_state'] = Helper::input($_POST['billing-state']);
            $data['billing_country'] = Helper::input($_POST['billing-country']);
            $data['billing_postal'] = Helper::input($_POST['billing-postal-code']);
            DB::update('users', $data, ['id' => $this->uid]);
            $this->redirect("my/billing/payments", "Your billing address has been updated successfully.", "success");
        }

        $payments = DB::select('gateways', 'id, name, provider, title, status', ['status' => 1, 'type' => 'payment'], 'ORDER BY name ASC');
        $user_result = DB::select('users', '*', ['id' => $this->uid], "LIMIT 1");
        $user = isset($user_result[0]) ? $user_result[0] : null;
        $payment = null;
        if (!empty($user['payment_method'])) {
            $user_payment_method = DB::select('gateways', 'id, name, provider, title, status', ['provider' => $user['payment_method'], 'status' => 1], 'LIMIT 1');
            $payment = isset($user_payment_method[0]) ? $user_payment_method[0] : null;
        }

        $this->title('My profile');
        require_once APP . '/View/User/Payments.php';
    }
}
