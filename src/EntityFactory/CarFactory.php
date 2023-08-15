<?php

namespace App\EntityFactory;

use App\DTO\CarDTO;
use App\Entity\Car;
use App\Repository\ColourRepository;

class CarFactory
{
    public function __construct(
        private ColourRepository $colourRepository
    ) {
    }

    public function dtoToEntity(CarDTO $carDTO): Car
    {
        if ($carDTO->colours !== null) {
            $colours = $this->colourRepository->findByIds($carDTO->colours);
        }

        $car = new Car();
        $car->setBuildAt($carDTO->build_at);
        $car->setColours($colours ?? []);
        $car->setMake($carDTO->make);
        $car->setModel($carDTO->model);

        return $car;
    }
}
