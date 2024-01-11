<?php

namespace App\Service\External;

use App\Helper\EnvProvider;
use App\Service\Interface\ServiceInterface;
use App\Service\Logic\ExternalService;
use App\Service\SessionService;

class UserService extends ExternalService implements ServiceInterface
{
    private string $url;
    private ServiceInterface $sessionService;

    public function __construct(SessionService $sessionService)
    {
        parent::__construct();
        $this->url = EnvProvider::get("SERVICE_USER_URL");
        $this->sessionService = $sessionService;
    }

    public function login(?array $data): ?array
    {
        $result = $this->postRequest("{$this->url}/login/",$data);
        if($result['result']['result'] != true) return ["result"=>["error"=>"Wrong username or password"]];
        $data['user_id'] = $result['result']['user'];
        $session = $this->sessionService->save($data)['object'] ?? null;
        $result['sessid'] = $session->getSessId() ?? null;
        return $result;
    }

    public function get(array $params): ?array
    {
        return [];
    }

    public function save(array $data): ?array
    {
        $result = $this->postRequest("{$this->url}/create/",$data);
        if(!empty($result['result']['error'])) return $result;
        $data['user_id'] = $result['result']['user'];
        if($result['result']['new'] == true){
            $session = $this->sessionService->save($data)['object'] ?? null;
            $result['sessid'] = $session->getSessId() ?? null;
        }
        return $result;
    }

    public function remove(int $id): ?array
    {
        return [];
    }
}