<?php

namespace App\Helper;

class EnvProvider
{
    public function __construct()
    {
        return;
    }

    public static function get($property): ?string
    {
        $env = include "../env.php";
        $key = strtoupper($property);

        return $env[$key] ?? null;
    }
}