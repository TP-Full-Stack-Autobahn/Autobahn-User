<?php

namespace App\Controller;

use App\Entity\FutureUser;
use App\Entity\User;
use App\Repository\FutureUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/inscription', name: 'inscription.')]
class InscriptionApiController extends AbstractController
{
    #[Route(name: 'inscription', methods: 'POST')]
    public function inscription(Request $request, ValidatorInterface $validator,
                                EntityManagerInterface $entityManager, SerializerInterface $serializer): JsonResponse
    {
        $futureUser = $serializer->deserialize($request->getContent(), FutureUser::class, 'json');
        $futureUser->setValidated(false);

        $errors = $validator->validate($futureUser);

        if (count($errors)) {
            $violations = [];
            foreach ($errors as $error) {
                $violations[$error->getPropertyPath()] = $error->getMessage();
            }
            return $this->json(['message' => $violations], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $entityManager->persist($futureUser);
        $entityManager->flush();

        $futureUser = $serializer->serialize($futureUser, 'json', ['groups' => ['onSignUp']]);

        return $this->json($futureUser, Response::HTTP_OK);
    }

    #[Route('/valid-user/{id}', name: 'valid-user', methods: 'POST')]
    public function validUser(Request $request, int $id, FutureUserRepository $futureUserRepository,
                              EntityManagerInterface $entityManager, SerializerInterface $serializer,
                              UserPasswordHasherInterface $hasher): JsonResponse
    {
        $futureUser = $futureUserRepository->find($id);
        if ($futureUser) {
            if (!$futureUser->isValidated()) {
                $futureUser->setValidated(true);

                $user = new User();
                $user
                    ->setEmail($futureUser->getEmail())
                    ->setPassword($hasher->hashPassword($user, $futureUser->getEmail()))
                    ->setRoles(['ROLE_USER'])
                    ->setFutureUser($futureUser);

                $entityManager->persist($user);
                $entityManager->flush();

                $user = $serializer->serialize($user, 'json', ['groups' => ['onValid']]);

                return $this->json($user, Response::HTTP_OK);
            }
            return $this->json(['message' => 'User already validated'], Response::HTTP_CONFLICT);
        }
        return $this->json(['message' => 'User ['.$id.'] not found'], Response::HTTP_NOT_FOUND);
    }
}
