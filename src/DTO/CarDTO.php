<?php

namespace App\DTO;

use App\Request\CreateCarRequest;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class CarDTO
{
    public string $make;
    public string $model;
    public \DateTimeImmutable $build_at;
    /**
     * @var int[]|null
     */
    public ?array $colours = null;

    public function fillFromRequest(CreateCarRequest $request): void
    {
        $this->make = $request->make;
        $this->model = $request->model;
        $this->build_at = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $request->build_at);
        $this->colours = (array)array_filter($request->colours, fn (string $item) => (int)($item) !== 0);
    }

}
