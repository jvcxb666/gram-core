<?php

namespace App\Utils;

use App\Helper\EnvProvider;
use Predis\Client;
use Predis\ClientInterface;

class Cacher
{

    private static ?ClientInterface $client = null;

    public function __construct()
    {
        
    }

    public static function getInstance(): ?ClientInterface
    {
        if(empty(self::$client)) self::$client = new Client(EnvProvider::get("redis_connection"));
        return self::$client;
    }

    public static function getValue(string $key): mixed
    {
        return self::getInstance()->executeRaw(["GET",$key]);
    }
    
    public static function setValue(string $key, string $value): void
    {
        self::getInstance()->executeRaw(["SET",$key,$value]);
    }

    public static function dropValue(string $key): void
    {
        self::getInstance()->executeRaw(["DEL",$key]);
    }

    public static function push(string $qName, array $data, string $action, array $action_params): void
    {
        if(empty($qName) || empty($action)) return;

        $content = json_encode([
            'action' => $action,
            'params' => $action_params,
            'data' => $data
        ]);

        self::getInstance()->lpush($qName,$content);
    }

    public static function dropGroup(string $key): void
    {
        $client = self::getInstance();
        $keys = $client->keys("*$key*");
        foreach($keys as $key)
        {
            self::dropValue($key);
        }
    }
}