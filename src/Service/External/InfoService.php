<?php

namespace App\Service\External;

use App\Helper\EnvProvider;
use App\Service\Interface\ServiceInterface;
use App\Service\Logic\AbstractExternalService;

class InfoService extends AbstractExternalService implements ServiceInterface
{

    public function __construct()
    {
        parent::__construct(EnvProvider::get("SERVICE_INFO_URL"));
        $this->disableCache();
    }

    public function get(array $data): ?array
    {
        if( (empty($data['user_id']) && empty($data['target_id'])) || empty($data['type'])) return ["result"=>["error"=>"Bad data passed in"]];

        $result = $this->postRequest("{$this->getServiceUrl()}/getInfo/",$data);

        return $result;
    }

    public function save(array $data): ?array
    {
        if(empty($data['user_id']) || empty($data['target_id'] || empty($data['type']))) return ["result"=>["error"=>"Bad data passed in"]];

        $result = $this->postRequest("{$this->getServiceUrl()}/process/",$data);

        return $result;
    }

    public function remove(int $id): ?array
    {
        return null;
    }
}