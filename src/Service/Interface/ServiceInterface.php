<?php

namespace App\Service\Interface;

interface ServiceInterface
{

    public function get(array $data): ?array;
    public function save(array $data): ?array;
    public function remove(int $id): ?array;

}