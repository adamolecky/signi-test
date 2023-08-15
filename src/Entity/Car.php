<?php

namespace App\Entity;

use App\Repository\CarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;

#[ORM\Entity(repositoryClass: CarRepository::class)]
class Car
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $make = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $build_at = null;

    /**
     * @var Collection<int, Colour>
     */
    #[ManyToMany(targetEntity: Colour::class, inversedBy: 'cars')]
    #[JoinTable(name: 'car_colours')]
    private Collection $colours;

    public function __construct()
    {
        $this->colours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMake(): ?string
    {
        return $this->make;
    }

    public function setMake(string $make): static
    {
        $this->make = $make;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getBuildAt(): ?\DateTimeImmutable
    {
        return $this->build_at;
    }

    public function setBuildAt(\DateTimeImmutable $build_at): static
    {
        $this->build_at = $build_at;

        return $this;
    }

    /**
     * @return Collection<int, Colour>
     */
    public function getColours(): Collection
    {
        return $this->colours;
    }

    /**
     * @param Colour[] $colours
     * @return void
     */
    public function setColours(array $colours): void
    {
        $this->colours = new ArrayCollection($colours);
    }

}
