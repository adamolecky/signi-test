<?php

namespace Tests\Unit\Response;

use App\Entity\Car;
use App\Response\CarResponse;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Mockery;
use Mockery\Mock;
use PHPUnit\Framework\TestCase;

/**
 * Class CarResponseTest.
 *
 * @covers \App\Response\CarResponse
 */
final class CarResponseTest extends TestCase
{
    private CarResponse $carResponse;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->carResponse = new CarResponse();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->carResponse);
    }

    public function testFillFromEntity(): void
    {
        $car = Mockery::mock(Car::class);
        $car->shouldReceive('getId')->andReturn(1);
        $car->shouldReceive('getMake')->andReturn('make');
        $car->shouldReceive('getModel')->andReturn('model');
        $dateTimeImmutable = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2021-08-02 13:37:55");
        $car->shouldReceive('getBuildAt')->andReturn($dateTimeImmutable);
        $car->shouldReceive('getColours')->andReturn(new ArrayCollection());

        /** @var Car $car */
        $carResponse = $this->carResponse->fillFromEntity($car);

        self::assertSame($carResponse->id, 1);
        self::assertSame($carResponse->make, 'make');
        self::assertSame($carResponse->model, 'model');
        self::assertSame($carResponse->build_at, $dateTimeImmutable);
        self::assertSame($carResponse->colours, []);
    }
}
