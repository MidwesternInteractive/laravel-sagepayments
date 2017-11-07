<?php

namespace MidwesternInteractive\Laravel;

class SagePayments
{
    /**
     * The base URL for Sage Payments API
     * 
     * @var string
     */
    static $base_url = 'https://api-cert.sagepayments.com/';

    /**
     * The primary method for requesting a response from Sage Payments API
     * 
     * @param  array  $request  An array of data to generate the request
     * @return  object  An object containing the default response from Sage Payments API
     */
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

    /**
     * Method for retriving a list of charges
     * 
     * @param  array  $body  An array of data used to generate the request
     * @return  object  An object containing the response from self::request method
     */
    public static function charges($body = [])
    {
        $request = [
            'verb' => 'GET',
            'endpoint' => self::$base_url . 'bankcard/v1/charges',
            'body' => $body
        ];

        return self::request($request);
    }

    /**
     * Method for retriving details of charges
     * 
     * @param  string  $reference  A string containging the reference id of the charge to retreive
     * @return  object  An object containing the response from self::request method
     */
    public static function details($reference)
    {
        $request = [
            'verb' => 'GET',
            'endpoint' => self::$base_url . 'bankcard/v1/charges/' . $reference,
        ];

        return self::request($request);
    }

    /**
     * Method for creating a new charge
     * 
     * @param  array  $body  An array of data used to generate the request
     * @param  string  $type  The type of charge to create
     * @return  object  An object containing the response from self::request method
     */
    public static function create($body, $type = 'Sale')
    {
        $request = [
            'verb' => 'POST',
            'endpoint' => self::$base_url . 'bankcard/v1/charges?type=' . $type,
            'body' => $body
        ];

        return self::request($request);
    }
}
