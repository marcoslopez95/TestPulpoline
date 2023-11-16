<?php

namespace App\Services;
use GuzzleHttp\Client;

class CurrencyLayerService{
    public $client;

    public $key = 'cf466af3a5f4821e2d569b9b5f642af3';
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'http://api.currencylayer.com/',
        ]);
    }

    /**
     * get response of api
     *
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return array
     */
    public function getExchange(string $from, string $to, float $amount)
    {
        $query = [
            'access_key' => $this->key,
            'from' => $from,
            'to' => $to,
            'amount' => $amount,
        ];
        try{
            $response = $this->client->get('convert',['query' => $query]);
            $body = $response->getBody();
            $stringBody = json_decode($body);
            return (array) $stringBody;
        }catch(\Exception $e){
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}