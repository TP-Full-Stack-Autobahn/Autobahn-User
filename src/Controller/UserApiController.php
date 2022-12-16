<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'user_api')]
class UserApiController extends AbstractController
{
    #[Route('/', methods: "GET")]
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        return $this->json([
            'user' => $user->getUserIdentifier(),
            'roles' => $user->getRoles()
        ]);
    }

    #[Route('/checkrole', name: 'check_role', methods: 'POST')]
    public function checkRole(Request $request)
    {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists("role", $data)) {
            return $this->json(['message' => 'Key "role" is missing in request.'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(in_array($data['role'], $user->getRoles()));
    }
}
