<?php

namespace App\Controller;

use App\Repository\FutureUserRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/user', name: 'user_api.')]
class UserApiController extends AbstractController
{
    #[Route(name: 'get_user', methods: "GET")]
    public function index(): JsonResponse
    {
        $user = $this->getUser();
        return $this->json([
            'email' => $user->getEmail(),
            'isAdmin' => in_array('ROLE_ADMIN', $user->getRoles()),
            'roles' => $user->getRoles()
        ]);
    }

    #[Route('/users', name: 'get_users', methods: "GET")]
    public function getUsers(UserRepository $userRepository): JsonResponse
    {
        $users = $userRepository->findAll();

        return $this->json(['users' => $users], Response::HTTP_OK, [], ['groups' => 'user']);
    }

    #[Route('/future-users', name: 'get_future_users', methods: "GET")]
    public function getFutureUsers(FutureUserRepository $futureUserRepository): JsonResponse
    {
        $futureUsers = $futureUserRepository->findAll();

        return $this->json(['users' => $futureUsers], Response::HTTP_OK, [], ['groups' => 'futureUser']);
    }


    #[Route('/checkrole', name: 'check_role', methods: 'POST')]
    public function checkRole(Request $request): JsonResponse
    {
        $user = $this->getUser();
        $data = json_decode($request->getContent(), true);

        if (!array_key_exists("role", $data)) {
            return $this->json(['message' => 'Key "role" is missing in request.'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json(in_array($data['role'], $user->getRoles()));
    }
}
