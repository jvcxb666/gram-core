<?php

namespace App\Controller;

use App\Service\External\InfoService;
use App\Service\Interface\ServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class InfoController extends AbstractController
{

    private ServiceInterface $service;

    public function __construct(InfoService $infoService)
    {
        $this->service = $infoService;
    }

    #[Route('/getLikes/', name: 'app_getLikes')]
    public function getLikes(Request $request): JsonResponse
    {
        try{
            $data = $request->get('data') ?? [];
            $data['type'] = 'like';
            $result = $this->service->get($data);
        }catch(\Exception $e){
            $result = ['error' => "Internal server error", 'message' => $e->getMessage()];
        }

        return $this->json($result);
    }

    #[Route('/getSubscribes/', name: 'app_getSubscribes')]
    public function index(Request $request): JsonResponse
    {
        try{
            $data = $request->get('data') ?? [];
            $data['type'] = 'subscribe';
            $result = $this->service->get($data);
        }catch(\Exception $e){
            $result = ['error' => "Internal server error", 'message' => $e->getMessage()];
        }

        return $this->json($result);
    }

    #[Route('/processLikes/', name: 'app_processLikes')]
    public function processLikes(Request $request): JsonResponse
    {
        try{
            $data = $request->get('data') ?? [];
            $data['type'] = 'like';
            $result = $this->service->save($data);
        }catch(\Exception $e){
            $result = ['error' => "Internal server error", 'message' => $e->getMessage()];
        }

        return $this->json($result);
    }

    #[Route('/processSubscribes/', name: 'app_processSubscribes')]
    public function processSubscribes(Request $request): JsonResponse
    {
        try{
            $data = $request->get('data') ?? [];
            $data['type'] = 'subscribe';
            $result = $this->service->save($data);
        }catch(\Exception $e){
            $result = ['error' => "Internal server error", 'message' => $e->getMessage()];
        }

        return $this->json($result);
    }
}
