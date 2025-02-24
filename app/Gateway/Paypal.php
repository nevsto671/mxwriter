<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

namespace Gateway;

class Paypal
{
    protected $clientId;
    protected $secret;
    protected $environment;
    public $orderId;
    public $captureId;
    public $refundId;
    public $referenceId;
    public $approveLink;
    public $recurring;

    public function __construct($credential)
    {
        $this->clientId = isset($credential['clientId']) ? $credential['clientId'] : null;
        $this->secret = isset($credential['secret']) ? $credential['secret'] : null;
        $this->environment = isset($credential['live']) && $credential['live'] ? '' : '.sandbox';
    }

    public function order($data)
    {
        $post = [
            "intent" => "CAPTURE",
            "purchase_units" => [[
                "reference_id" => $data['reference_id'],
                "description" => $data['name'] . ' - ' . $data['description'],
                "amount" => [
                    "value" => $data['amount'],
                    "currency_code" => $data['currency']
                ]
            ]],
            "application_context" => [
                "cancel_url" => $data['cancel_url'],
                "return_url" => $data['success_url']
            ]
        ];
        $url = "https://api$this->environment.paypal.com/v2/checkout/orders";
        $response = $this->request($url, $post);
        if (empty($response->id)) return null;
        $this->orderId = $response->id;
        if (isset($response->links)) {
            foreach ($response->links as $row) {
                if ($row->rel == 'approve') $this->approveLink = $row->href;
            }
        }
        $result['id'] = $this->orderId;
        $result['redirect'] = $this->approveLink;
        return $result;
    }

    public function capture($orderId)
    {
        if (empty($orderId)) return null;
        $url = "https://api$this->environment.paypal.com/v2/checkout/orders/$orderId/capture";
        $response = $this->request($url);
        if (empty($response->id)) return null;
        if ($response->status != 'COMPLETED') return null;
        $this->orderId = $response->id;
        foreach ($response->purchase_units as $purchase_unit) {
            $this->referenceId = $purchase_unit->reference_id;
        }
        foreach ($response->purchase_units as $purchase_unit) {
            foreach ($purchase_unit->payments->captures as $capture) {
                $this->captureId = $capture->id;
            }
        }
        $result['reference_id'] = $this->referenceId;
        $result['transaction_id'] = $this->captureId;
        return $result;
    }

    public function refund($data)
    {
        if (empty($data['captureId'])) return null;
        $url = "https://api$this->environment.paypal.com/v2/payments/captures/$data[captureId]/refund";
        if ($data['amount'] && $data['currency']) {
            $post = [
                "amount" => [
                    "value" => $data['amount'],
                    "currency_code" => $data['currency'],
                ]
            ];
        }
        $response = $this->request($url, isset($post) ? $post : []);
        if (empty($response->id)) return null;
        $this->refundId = $response->id;
        return $response;
    }

    protected function request($url, $post = [])
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_USERPWD, $this->clientId . ":" . $this->secret);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Content-Type: application/json"]);
        curl_setopt($ch, CURLOPT_POST, true);
        if ($post) curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post));
        $response = curl_exec($ch);
        if (curl_errno($ch)) return null;
        curl_close($ch);
        return !empty($response) ? json_decode($response) : null;
    }
}
