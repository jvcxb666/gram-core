<?php

namespace App\Service\External;

use App\Entity\User;
use App\Helper\EnvProvider;
use App\Service\Interface\ServiceInterface;
use App\Service\Logic\ExternalService;
use App\Service\SessionService;
use SplObjectStorage;
use SplObserver;
use SplSubject;

class UserService extends ExternalService implements ServiceInterface, SplSubject
{
    private string $url;
    private ServiceInterface $sessionService;
    private SplObjectStorage $observers;
    private array $data;

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

    public function get(array $data): ?array
    {
        return [];
    }

    public function save(array $data): ?array
    {
        $result = $this->postRequest("{$this->url}/create/",$data);
        if(!empty($result['result']['error'])) return $result;
        $data['user_id'] = $result['result']['user'];
        $session = $this->sessionService->save($data)['object'] ?? null;
        $result['sessid'] = $session->getSessId() ?? null;
        $this->data = $data;
        return $result;
    }

    public function remove(int $id): ?array
    {
        return [];
    }

    public function attach(SplObserver $observer): void
    {
        $this->observers->attach($observer);
    }

    public function detach(SplObserver $observer): void
    {
        $this->observers->detach($observer);
    }

    public function notify(): void
    {
        if(empty($this->data)) return;

        foreach($this->observers as $observer){
            $observer->update();
        }
        
        unset($this->data);
    }
}