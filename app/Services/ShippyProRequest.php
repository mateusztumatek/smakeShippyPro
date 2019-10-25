<?php

namespace App\Services;

use GuzzleHttp\Client;

class ShippyProRequest{
    protected $api_key, $headers;
    private $endpoint = 'https://www.shippypro.com/api';
    /*private $endpoint = 'http://127.0.0.1:8002/api/test';*/
    public function __construct($api_key)
    {
        $this->api_key = $api_key;
        $this->setHeaders();
    }

    public function call(array $fields, $method){
        $client = new Client();
        $response = $client->request('POST', $this->endpoint, array_merge($fields, [$method]), $this->headers->toArray());
        try{
            return json_decode($response->getBody()->getContents());
        }catch (\Exception $e){
            throw $e;
        }
    }
    protected function setHeaders(){
        $this->headers = collect();
        $this->headers->push(['Authorization' => 'Basic '.$this->api_key]);
    }
}
