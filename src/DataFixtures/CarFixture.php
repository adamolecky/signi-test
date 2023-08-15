<?php

namespace App\DataFixtures;

use App\Entity\Car;
use App\Entity\Colour;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class CarFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $car = new Car();
        $car->setModel('audi');
        $car->setMake('a6');

        /**@var $colour Colour*/
        $colour = $this->getReference(ColourFixtures::RED_COLOUR_REFERENCE);
        $car->setColours([$colour]);
        $car->setBuildAt(new \DateTimeImmutable());

        $manager->persist($car);
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return  [
            ColourFixtures::class,
        ];
    }
}
