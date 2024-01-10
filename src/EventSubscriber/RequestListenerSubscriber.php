<?php

namespace App\EventSubscriber;

use App\Service\SessionService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestListenerSubscriber implements EventSubscriberInterface
{
    private SessionService $service;

    public function __construct(SessionService $sessionService)
    {
        $this->service = $sessionService;
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if($event->getRequest()->getPathInfo() == '/login/' || $event->getRequest()->getPathInfo() == '/register/') return;
        $sessionId = $event->getRequest()->get("session");
        
        if(!$this->service->checkSession($sessionId)){
            $this->returnUnauthorized($event);
            return;
        }
    }

    private function returnUnauthorized(RequestEvent $event): void
    {
        $response = new JsonResponse('Unauthorized',401);
        $event->setResponse($response);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
        ];
    }
}
