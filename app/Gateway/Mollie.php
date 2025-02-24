<?php

/**
 * Developed by Sohel Rana
 * https://github.com/sohelrn
 */

namespace Gateway;

class Mollie
{
    protected $apiKey;
    public $recurring;

    public function __construct($credential)
    {
        $this->apiKey = isset($credential['apiKey']) ? $credential['apiKey'] : null;
    }

    public function order($data)
    {
        $post = [
            "amount" => [
                "currency" => $data['currency'],
                "value" => number_format((float)$data['amount'], 2, '.', '')
            ],
            "description" => $data['name'],
            "redirectUrl" => $data['success_url'],
            "cancelUrl" => $data['cancel_url'],
            "metadata" => [
                "reference_id" => $data['reference_id'],
            ],
        ];
        $url = "https://api.mollie.com/v2/payments";
        $response = $this->request($url, $post);
        if (empty($response->id)) return null;
        $url = isset($response->_links->checkout->href) ? $response->_links->checkout->href : null;
        if (empty($url)) return null;
        $result['id'] = $response->id;
        $result['redirect'] = $url;
        return $result;
    }

    public function capture($id)
    {
        if (empty($id)) return null;
        $url = "https://api.mollie.com/v2/payments/$id";
        $response = $this->request($url);
        if (empty($response->id)) return null;
        if ($response->id != $id) return null;
        if ($response->status != 'paid') return null;
        $result['reference_id'] = $response->metadata->reference_id;
        $result['transaction_id'] = $id;
        return $result;
    }

    protected function request($url, $post = [])
    {
        $ch = curl_init();
        if ($post) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Bearer " . $this->apiKey]);
        $response = curl_exec($ch);
        if (curl_errno($ch)) return null;
        curl_close($ch);
        return !empty($response) ? json_decode($response) : null;
    }
}
