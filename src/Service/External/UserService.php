<?php

namespace App\Service\External;

use App\Helper\EnvProvider;
use App\Service\Interface\ServiceInterface;
use App\Service\Logic\AbstractExternalService;
use App\Service\SessionService;

class UserService extends AbstractExternalService implements ServiceInterface
{
    private ServiceInterface $sessionService;

    public function __construct(SessionService $sessionService)
    {
        parent::__construct(EnvProvider::get("SERVICE_USER_URL"));
        $this->sessionService = $sessionService;
    }

    public function login(?array $data): ?array
    {
        $result = $this->postRequest("{$this->getServiceUrl()}/login/",$data);
        if($result['result']['result'] != true) return ["result"=>["error"=>"Wrong username or password"]];
        $data['user_id'] = $result['result']['user'];
        $session = $this->sessionService->save($data)['object'] ?? null;
        $result['sessid'] = $session->getSessId() ?? null;
        return $result;
    }

    public function get(array $data): ?array
    {
        if(empty($data['id']) && empty($data['name']) && empty($data['email'])) return ["error"=>"User not found"];

        return $this->postRequest("{$this->getServiceUrl()}/getUser/",$data);
    }

    public function save(array $data): ?array
    {
        $result = $this->postRequest("{$this->getServiceUrl()}/create/",$data);
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
        if(empty($data['id'])) return ["error"=>"No user id"];

        return $this->postRequest("{$this->getServiceUrl()}/delete/",$data);
    }
}