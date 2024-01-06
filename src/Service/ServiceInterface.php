<?php

namespace App\Service;

interface ServiceInterface
{

    public function get(array $params): ?array;
    public function save(array $data): ?array;
    public function remove(int $id): ?array;

}