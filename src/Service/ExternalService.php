<?php

namespace App\Service;

use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class ExternalService
{
    protected HttpClientInterface $client;

    public function __construct()
    {
        $this->client = new CurlHttpClient();
    }

    protected function postRequest(string $url,?array $data): ?array
    {
        try{
            $response = $this->client->request("POST",$url,[
                'body' => http_build_query($data),
            ]);

            return ['result'=>json_decode($response->getContent(),1)];
        }catch(\Exception $e){
            return ['error'=>'External service error','message'=>$e->getMessage()];
        }
    }
}