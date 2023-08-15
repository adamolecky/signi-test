<?php

namespace App\Response;

use App\Entity\Car;
use App\Entity\Colour;

class CarResponse
{
    public int $id;
    public string $make;
    public string $model;
    public \DateTimeImmutable $build_at;
    /**
     * @var int[]|null
     */
    public ?array $colours = null;

    public function fillFromEntity(Car $car): CarResponse
    {
        $this->id = $car->getId();
        $this->make = $car->getMake();
        $this->model = $car->getModel();
        $this->build_at = $car->getBuildAt();
        $this->colours = array_map(fn (Colour $colour) => $colour->getId(), $car->getColours()->toArray());

        return $this;
    }

}
