<?php

namespace Tests\Unit;

use App\Entity\Car;
use App\ResponseFactory\CarResponseFactory;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * Class CarResponseFactoryTest.
 *
 * @covers \App\ResponseFactory\CarResponseFactory
 */
final class CarResponseFactoryTest extends TestCase
{
    private CarResponseFactory $carResponseFactory;

    /**
     * @return array<mixed>
     */
    public function createCarMock(): array
    {
        $car = Mockery::mock(Car::class);
        $car->shouldReceive('getId')->andReturn(1);
        $car->shouldReceive('getMake')->andReturn('make');
        $car->shouldReceive('getModel')->andReturn('model');
        $dateTimeImmutable = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2021-08-02 13:37:55");
        $car->shouldReceive('getBuildAt')->andReturn($dateTimeImmutable);
        $car->shouldReceive('getColours')->andReturn(new ArrayCollection());
        /**
         * @var Car $car
         */
        return [$car, $dateTimeImmutable];
    }

    /**
     * @param \App\Response\CarResponse $carResponse
     * @param mixed $dateTimeImmutable
     * @return void
     */
    public function assertCarResponse(\App\Response\CarResponse $carResponse, mixed $dateTimeImmutable): void
    {
        self::assertSame($carResponse->id, 1);
        self::assertSame($carResponse->make, 'make');
        self::assertSame($carResponse->model, 'model');
        self::assertSame($carResponse->build_at, $dateTimeImmutable);
        self::assertSame($carResponse->colours, []);
    }

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->carResponseFactory = new CarResponseFactory();
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->carResponseFactory);
    }

    public function testFromEntityToCarResponse(): void
    {
        [$car, $dateTimeImmutable] = $this->createCarMock();

        $carResponse = $this->carResponseFactory->fromEntityToCarResponse($car);

        $this->assertCarResponse($carResponse, $dateTimeImmutable);
    }

    public function testFromEntitiesToCarResponse(): void
    {
        [$car, $dateTimeImmutable] = $this->createCarMock();

        $carResponse = $this->carResponseFactory->fromEntitiesToCarResponse([$car]);

        $this->assertCarResponse($carResponse[0], $dateTimeImmutable);
    }
}
