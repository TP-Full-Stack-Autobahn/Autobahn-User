<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api', name: 'home.')]
class HomeApiController extends AbstractController
{
    #[Route('/hello', name: 'hello')]
    public function index(): JsonResponse
    {
        return $this->json("Hello API !");
    }
}
