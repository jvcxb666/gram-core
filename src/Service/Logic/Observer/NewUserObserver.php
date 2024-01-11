<?php

namespace App\Service\Logic\Observer;

use App\Service\Interface\ServiceInterface;
use App\Service\SessionService;
use SplObserver;
use SplSubject;

class NewUserObserver implements SplObserver
{
    private ServiceInterface $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function update(SplSubject $serviceState): void
    {
        $data = $serviceState->data;

        if(!empty($data['preferences']));
        if(!empty($data['information']));
    }
}