<?php
namespace AnonWallet;

class AnonWallet_micro {

    /**
     * 
     * @var string endpoint of api
     */
    private $url = 'https://anonwallet.net/micro/api/';
    /**
     * 
     * @var string api of version
     */
    private $version = 'v1';
    /**
     * 
     * @var string currency, BTC is default
     */
    private $default_currency = 'BTC';
    /**
     * 
     * @var string api key from anonwallet payment gateway
     */
    private $api_key;

    public function __construct($api_key) {

        if(isset($api_key)) {
            $this->api_key = $api_key;
        } else {
            throw new \Exception('Api key is required');
        }

        //PHP Curl must be installed in your system
        
    }

    /**
     * 
     * Get balance of specified coin from your wallet
     * Example string BTC, BCH, LTC, DOGE
     * @return json response with success or error message
     */
    public function balance($currency = '') {
        $url = $this->url.$this->version.'/balance';
    
        $payload = [
            'currency'=>(isset($currency)) ? $currency : $this->default_currency
        ];

        $res = $this->curl_call($url, $payload);
        return $res;
    }

    /**
     * 
     * Get currencies avaialable
     * @return json response with success or error message
     */
    public function currencies() {
        $url = $this->url.$this->version.'/currencies';
        $res = $this->curl_call($url);
        return $res;
    }

    /**
     * 
     * Check linked address, default is BTC
     * @return json response with success or error message
     */
    public function check_address($currency, $address) {
        $url = $this->url.$this->version.'/checkaddress';

        if(!isset($address)) {
            throw new \Exception('The linked address is required');
        }

        $payload = [
            'currency'=>(isset($currency)) ? $currency : $this->currency,
            'address'=>$address,
        ];

        $res = $this->curl_call($url, $payload);
        return $res;
    }

    /**
     * 
     * Send a payment from your faucet wallet
     * @return json response with success or error message
     */
    public function send($amount, $currency, $address) {
        $url = $this->url.$this->version.'/send';

        if($amount == 0) {
            throw new \Exception('The amount cannot be zero or negative number');
        }

        if(!is_numeric($amount)) {
            throw new \Exception('The amount should be numeric double');
        }

        if(!isset($address)) {
            throw new \Exception('The receiver address is required');
        }

        $payload = [
            'amount'=>$amount,
            'currency'=>(isset($currency)) ? $currency : $this->currency,
            'address'=>$address
        ];

        $res = $this->curl_call($url, $payload);
        return $res;
    }

    /**
     * 
     * @param string $url
     * @param array $payload parameters
     * @return json
     */
    public function curl_call($url, $payload = '') {

        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_HTTPHEADER => [
              "Content-Type: application/json",
              "Authorization: Bearer ".$this->api_key.""
            ],
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_URL => "".$url."",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
        ]);

        $response = curl_exec($curl);
        $error = curl_error($curl);

        curl_close($curl);

        if($error) {
            return json_decode($error);
        } else {
            return json_decode($response);
        }
    }

}
