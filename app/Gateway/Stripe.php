<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

namespace Gateway;

class Stripe
{
    protected $secretKey;
    protected $trialDays;
    public $recurring = true;

    public function __construct($credential)
    {
        $this->secretKey = isset($credential['secretKey']) ? $credential['secretKey'] : null;
        $this->trialDays = !empty($credential['trialDays']) && (int) $credential['trialDays'] ? $credential['trialDays'] : null;
    }

    public function order($data)
    {
        $post = [
            'mode' => !empty($data['subscription']) ? 'subscription' : 'payment',
            'cancel_url' => $data['cancel_url'],
            'success_url' => $data['success_url'],
            'client_reference_id' => $data['reference_id'],
            "allow_promotion_codes" => 'true',
            'metadata' => [
                'user' => $data['user'],
                'email' => $data['email'],
            ],
            'line_items' => [[
                'quantity' => 1,
                'price_data' => [
                    'recurring' => !empty($data['subscription']) && !empty($data['billing_cycle']) && $data['billing_cycle'] != 'prepaid' ? ['interval' => $data['billing_cycle']] : [],
                    'currency' => strtolower($data['currency']),
                    'unit_amount' => $data['amount'] * 100,
                    'product_data' => [
                        'name' => $data['name'],
                        'description' => $data['description']
                    ],
                ],
            ]],
        ];
        if ($this->trialDays) {
            $post['subscription_data'] = [
                'trial_settings' => ['end_behavior' => ['missing_payment_method' => 'cancel']],
                'trial_period_days' => $this->trialDays,
            ];
        }
        $url = "https://api.stripe.com/v1/checkout/sessions";
        $response = $this->request($url, $post);
        if (empty($response->id)) return null;
        $result['id'] = $response->id;
        $result['redirect'] = $response->url;
        return $result;
    }

    public function capture($sessionId)
    {
        if (empty($sessionId)) return null;
        $url = "https://api.stripe.com/v1/checkout/sessions/$sessionId";
        $response = $this->request($url);
        if (empty($response->id)) return null;
        if ($response->payment_status != 'paid') return null;
        $result['payment_id'] = $response->id; // payment_id
        $result['customer_id'] = $response->customer;
        $result['subscription_id'] = $response->subscription;
        $result['reference_id'] = $response->client_reference_id;
        $result['total_amount'] = $response->amount_total / 100;
        return $result;
    }

    public function retrieveInvoice($invoiceId)
    {
        if (empty($invoiceId)) return null;
        $url = "https://api.stripe.com/v1/invoices/$invoiceId";
        $response = $this->request($url);
        if (empty($response->id)) return null;
        if ($response->status != 'paid') return null;
        $result['payment_id'] = $response->id;
        $result['customer_id'] = $response->customer;
        $result['subscription_id'] = $response->subscription;
        return $result;
    }

    public function cancelSubscription($subscriptionId)
    {
        if (empty($subscriptionId)) return null;
        $url = "https://api.stripe.com/v1/subscriptions/$subscriptionId";
        $response = $this->request($url, [], true);
        if (empty($response->id)) return null;
        if ($response->status != 'canceled') return null;
        $result['id'] = $response->id;
        $result['customer_id'] = $response->customer;
        return $result;
    }

    public function updateBilling($customerId, $returnUrl)
    {
        $post = [
            'customer' => $customerId,
            'return_url' => $returnUrl,
        ];
        $url = "https://api.stripe.com/v1/billing_portal/sessions";
        $response = $this->request($url, $post);
        if (empty($response->id)) return null;
        $result['id'] = $response->id;
        $result['redirect'] = $response->url;
        return $result;
    }

    public function changeMethod($data)
    {
        $post = [
            'payment_method_types' => ['card'],
            'mode' => 'setup',
            'customer' => $data['customer_id'],
            'setup_intent_data' => [
                'metadata' => [
                    'customer_id' => $data['customer_id'],
                    'subscription_id' => $data['subscription_id'],
                ],
            ],
            'success_url' => $data['success_url'],
            'cancel_url' => $data['cancel_url'],
        ];
        $url = "https://api.stripe.com/v1/checkout/sessions";
        $response = $this->request($url, $post);
        if (empty($response->id)) return null;
        $result['id'] = $response->id;
        $result['redirect'] = $response->url;
        return $result;
    }

    public function getMethod($sessionId)
    {
        if (empty($id)) return null;
        $url = "https://api.stripe.com/v1/checkout/sessions/$sessionId";
        $results = $this->request($url);
        if (empty($results->setup_intent)) return null;
        $setupIntentId = $results->setup_intent;
        $url = "https://api.stripe.com/v1/setup_intents/$setupIntentId";
        $response = $this->request($url);
        if (empty($response->payment_method)) return null;
        $result['payment_method'] = $response->payment_method;
        return $result;
    }

    public function updateMethod($customerId, $subscriptionId, $paymentMethodId)
    {
        $post = ['invoice_settings' => ['default_payment_method' => $paymentMethodId]];
        $url = "https://api.stripe.com/v1/customers/$customerId";
        $this->request($url, $post);

        $url = "https://api.stripe.com/v1/subscriptions/$subscriptionId";
        $response = $this->request($url, ['default_payment_method' => $paymentMethodId]);
        if (empty($response->id)) return null;
        return $response;
    }

    public function webhook($input = 'php://input')
    {
        $payload = @file_get_contents($input);
        if (empty($payload)) return null;
        $event = json_decode($payload);
        if (empty($event->id)) return null;
        switch ($event->type) {
            case 'checkout.session.completed':
                return $this->capture($event->data->object->id);
                break;
            case 'invoice.paid':
                if ($event->data->object->billing_reason == 'subscription_cycle') {
                    return $this->retrieveInvoice($event->data->object->id);
                }
                return null;
                break;
            default:
                return null;
        }
        return null;
    }

    protected function request($url, $post = [], $delete = false)
    {
        $ch = curl_init();
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        } else if ($delete) {
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $this->secretKey, "Content-Type: application/x-www-form-urlencoded"]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) return null;
        curl_close($ch);
        return !empty($response) ? json_decode($response) : null;
    }
}
