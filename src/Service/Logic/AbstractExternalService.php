<?php

namespace App\Service\Logic;

use App\Utils\Cacher;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

abstract class AbstractExternalService
{
    protected HttpClientInterface $client;
    protected static string $baseUrl;
    protected bool $cache;

    public function __construct(string $url)
    {
        self::$baseUrl = $url;
        $this->client = new CurlHttpClient();
        $this->cache = true;
    }

    public static function getServiceUrl()
    {
        return self::$baseUrl;
    }

    protected function dropCache()
    {
        Cacher::dropGroup(self::$baseUrl);
    }

    protected function disableCache(): void
    {
        $this->cache = false;
    }

    protected function postRequest(string $url,?array $data,?bool $cache = null)
    {
        if($cache === null) $cache = $this->cache;
        try{
            $cache_key = $url.json_encode($data);
            if($cache && !empty(Cacher::getValue($cache_key))) return ['result'=>json_decode(Cacher::getValue($cache_key),1)];

            $response = $this->client->request("POST",$url,[
                'body' => http_build_query($data),
            ]);

            if($cache) Cacher::setValue($cache_key,$response->getContent());

            return ['result'=>json_decode($response->getContent(),1)];
        }catch(\Exception $e){
            return ['error'=>'External service error','message'=>$e->getMessage()];
        }
    }
}