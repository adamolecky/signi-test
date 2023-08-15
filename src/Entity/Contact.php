<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;
use Ramsey\Uuid\Doctrine\UuidGenerator;
use Ramsey\Uuid\UuidInterface;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:"CUSTOM")]
    #[ORM\Column(type:"uuid", unique:true)]
    #[ORM\CustomIdGenerator(class:UuidGenerator::class)]
    //@phpstan-ignore-next-line
    private UuidInterface $id;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $surname = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phone = null;

    public function getId(): UuidInterface
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function setSurname(?string $surname): static
    {
        $this->surname = $surname;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }
}
