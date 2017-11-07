<?php

namespace MidwesternInteractive\Laravel;

class SagePayments
{
    private $base_url = 'https://api-cert.sagepayments.com/';

    public static function request($request)
    {
        $nonce = uniqid();
        $timestamp = (string) time();
        $payload = !empty($request['body']) ? json_encode($request['body']) : '';

        $hmac = hash_hmac(
            "sha512",
            $request['verb'] . $request['endpoint'] . $payload . config('sagepayments.merchant.id') . $nonce . $timestamp,
            config('sagepayments.app.key'),
            true
        );
        $bearer = base64_encode($hmac);

        $config = [
            'http' => [
                'header' => [
                    'clientId: ' . config('sagepayments.app.id'),
                    'merchantId: ' . config('sagepayments.merchant.id'),
                    'merchantKey: ' . config('sagepayments.merchant.key'),
                    'nonce: ' . $nonce,
                    'timestamp: ' . $timestamp,
                    'authorization: ' . $bearer,
                    'content-type: application/json'
                ],
                'method' => $request['verb'],
                'content' => $payload,
                'ignore_errors' => true
            ]
        ];

        $context = stream_context_create($config);
        $result = file_get_contents($request['endpoint'], false, $context);
        $response = json_decode($result);

        return $response;
    }

    public static function charges($body = [])
    {
        $request = [
            'verb' => 'GET',
            'endpoint' => $this->base_url . 'bankcard/v1/charges',
            'body' => $body
        ];

        return self::request($request);
    }

    public static function details($reference)
    {
        $request = [
            'verb' => 'GET',
            'endpoint' => $this->base_url . 'bankcard/v1/charges/' . $reference,
        ];

        return self::request($request);
    }

    public static function create($body, $type = 'Sale')
    {
        $request = [
            'verb' => 'POST',
            'endpoint' => $this->base_url . 'bankcard/v1/charges?type=' . $type,
            'body' => $body
        ];

        return self::request($request);
    }
}
