<?php

namespace App\Controller;

use App\Service\ExternalService;
use App\Service\ServiceInterface;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{

    private ServiceInterface $service;

    public function __construct(UserService $userService)
    {
        $this->service = $userService;
    }

    #[Route('/login/', name: 'app_login')]
    public function index(Request $request): JsonResponse
    {
        return $this->json($this->service->login($request->get('data')));
    }

    #[Route('/register/', name: 'app_register')]
    public function register(Request $request): JsonResponse
    {
        return $this->json($this->service->save($request->get('data') ?? []));
    }
}
