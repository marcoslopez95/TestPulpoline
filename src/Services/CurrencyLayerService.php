<?php

namespace App\Services;
use GuzzleHttp\Client;
use Psr\Http\Message\StreamInterface;

class CurrencyLayerService{
    public $client;

    public $key = 'cf466af3a5f4821e2d569b9b5f642af3';
    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.currencylayer.com/'
        ]);
    }

    /**
     * get response of api
     *
     * @param string $from
     * @param string $to
     * @param float $amount
     * @return StreamInterface|array
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
            $response = $this->client->get('convert',['query'=> $query]);
            return $response->getBody();
        }catch(\Exception $e){
            return [
                'success' => false,
                'message' => $e->getMessage(),
            ];
        }
    }
}