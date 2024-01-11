<?php

namespace App\Service\Logic\Observer;

use App\Service\Interface\ServiceInterface;
use App\Service\SessionService;
use SplObserver;
use SplSubject;

class newUserObserver implements SplObserver
{
    private ServiceInterface $sessionService;

    public function __construct(SessionService $sessionService)
    {
        $this->sessionService = $sessionService;
    }

    public function update(SplSubject $user): void
    {
        //Some code goes here
    }
}