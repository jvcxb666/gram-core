<?php

namespace App\Controller;

use App\Service\Interface\ServiceInterface;
use App\Service\External\UserService;
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

    #[Route('/getUser/', name: 'app_user_find', methods: "POST")]
    public function get(Request $request): JsonResponse
    {
        try{
            $result = $this->service->get($request->get('data') ?? []);
        }catch(\Exception $e){
            $result = ['error' => "Internal server error", 'message' => $e->getMessage()];
        }

        return $this->json($result);
    }

    #[Route('/login/', name: 'app_user_login', methods: "POST")]
    public function index(Request $request): JsonResponse
    {
        try{
            $result = $this->service->login($request->get('data') ?? []);
        }catch(\Exception $e){
            $result = ['error' => "Internal server error", 'message' => $e->getMessage()];
        }

        return $this->json($result);
    }

    #[Route('/register/', name: 'app_user_register', methods: "POST")]
    public function register(Request $request): JsonResponse
    {
        try{
            $result = $this->service->save($request->get('data') ?? []);
        }catch(\Exception $e){
            $result = ['error' => "Internal server error", 'message' => $e->getMessage()];
        }

        return $this->json($result);
    }

    #[Route('/deleteUser/', name: 'app_user_delete', methods: "POST")]
    public function delete(Request $request): JsonResponse
    {
        try{
            $result = $this->service->remove($request->get('data') ?? []);
        }catch(\Exception $e){
            $result = ['error' => "Internal server error", 'message' => $e->getMessage()];
        }

        return $this->json($result);
    }
}
