<?php

namespace App\ResponseFactory;

use App\Entity\Car;
use App\Response\CarResponse;

class CarResponseFactory
{
    public function fromEntityToCarResponse(Car $car): CarResponse
    {
        return (new CarResponse())->fillFromEntity($car);
    }

    /**
     * @param Car[] $cars
     * @return CarResponse[]
     */
    public function fromEntitiesToCarResponse(array $cars): array
    {
        return array_map(fn (Car $car) => (new CarResponse())->fillFromEntity($car), $cars);
    }
}
