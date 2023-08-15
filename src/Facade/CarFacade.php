<?php

namespace App\Facade;

use App\DTO\CarDTO;
use App\Entity\Car;
use App\EntityFactory\CarFactory;
use App\Exceptions\CarNotFoundException;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;

class CarFacade
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private CarFactory $carFactory,
        private CarRepository $carRepository
    ) {
    }

    public function save(CarDto $carDto): Car
    {
        $carEntity = $this->carFactory->dtoToEntity($carDto);
        $this->entityManager->persist($carEntity);
        $this->entityManager->flush();

        return $carEntity;
    }

    public function remove(int $id): void
    {
        $carEntity = $this->carRepository->find($id);
        if ($carEntity === null) {
            throw new CarNotFoundException();
        }

        $this->entityManager->remove($carEntity);
        $this->entityManager->flush();
    }
}
