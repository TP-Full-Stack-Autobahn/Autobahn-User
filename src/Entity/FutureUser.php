<?php

namespace App\Entity;

use App\Repository\FutureUserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FutureUserRepository::class)]
#[UniqueEntity('email')]
class FutureUser
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user', 'futureUser'])]
    private ?int $id = null;

    #[ORM\Column(length: 255, unique: true)]
    #[Assert\Email]
    #[Groups(['futureUser', 'onSignUp'])]
    #[Assert\NotNull]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user', 'onValid', 'futureUser'])]
    #[Assert\NotNull]
    private ?string $lastname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user', 'onValid', 'futureUser'])]
    #[Assert\NotNull]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user', 'onValid', 'futureUser'])]
    #[Assert\NotNull]
    private ?string $phone = null;

    #[ORM\Column(length: 255)]
    #[Groups(['user', 'onValid', 'futureUser'])]
    #[Assert\NotNull]
    private ?string $nationality = null;

    #[ORM\Column]
    #[Groups(['user', 'onValid', 'futureUser'])]
    private ?bool $validated = null;

    #[ORM\OneToOne(inversedBy: 'futureUser', cascade: ['persist', 'remove'])]
    private ?User $user = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(['company', 'individual'])]
    #[Assert\NotNull]
    private ?string $client = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }

    public function isValidated(): ?bool
    {
        return $this->validated;
    }

    public function setValidated(bool $validated): self
    {
        $this->validated = $validated;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getClient(): ?string
    {
        return $this->client;
    }

    public function setClient(string $client): self
    {
        $this->client = $client;

        return $this;
    }
}
