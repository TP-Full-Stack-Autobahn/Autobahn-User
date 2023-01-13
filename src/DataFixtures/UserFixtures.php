<?php

namespace App\DataFixtures;

use App\Entity\FutureUser;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user
            ->setEmail("admin@gmail.com")
            ->setPassword(
                $this->hasher->hashPassword(
                    $user,
                    "admin"
                )
            )
            ->setRoles(['ROLE_ADMIN']);

        $futureUser = new FutureUser();
        $futureUser
            ->setEmail("admin@gmail.com")
            ->setNationality("french")
            ->setPhone("0641221535")
            ->setLastname("HOCHET")
            ->setFirstname("Dylan")
            ->setClient("company")
            ->setValidated(true)
            ->setUser($user);

        $manager->persist($futureUser);
        $manager->persist($user);

        $manager->flush();
    }
}
