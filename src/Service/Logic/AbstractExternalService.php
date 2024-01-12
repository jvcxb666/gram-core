<?php

namespace App\Service\Logic;

use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractExternalService
{
    protected HttpClientInterface $client;
    protected static string $baseUrl;

    public function __construct(string $url)
    {
        self::$baseUrl = $url;
        $this->client = new CurlHttpClient();
    }

    public static function getServiceUrl()
    {
        return self::$baseUrl;
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