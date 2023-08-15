<?php

namespace Tests\Unit\EntityFactory;

use App\DTO\CarDTO;
use App\EntityFactory\CarFactory;
use App\Repository\ColourRepository;
use DateTimeImmutable;
use Mockery;
use Mockery\LegacyMockInterface;
use Mockery\Mock;
use Mockery\MockInterface;
use PHPUnit\Framework\TestCase;

/**
 * Class CarFactoryTest.
 *
 * @covers \App\EntityFactory\CarFactory
 */
final class CarFactoryTest extends TestCase
{
    private CarFactory $carFactory;

    private ColourRepository|Mock $colourRepository;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->colourRepository = Mockery::mock(ColourRepository::class);
        $this->carFactory = new CarFactory($this->colourRepository);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        unset($this->carFactory);
        unset($this->colourRepository);
    }

    public function testDtoToEntity(): void
    {
        $carDto = new CarDTO();
        $carDto->make = 'make';
        $carDto->build_at = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', "2021-08-02 13:37:55");
        $carDto->model = 'model';

        $car = $this->carFactory->dtoToEntity($carDto);

        self::assertSame('make', $car->getMake());
        self::assertSame('model', $car->getModel());
        self::assertSame($carDto->build_at, $car->getBuildAt());

    }
}
