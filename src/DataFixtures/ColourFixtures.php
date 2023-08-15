<?php

namespace App\DataFixtures;

use App\Entity\Colour;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ColourFixtures extends Fixture
{
    public const COLOUR_DATASET = [
        'black',
        'blue',
        'white',
        'red'
    ];

    public const RED_COLOUR_REFERENCE = 'RED_COLOUR_REFERENCE';

    public function load(ObjectManager $manager): void
    {
        foreach (self::COLOUR_DATASET as $colourName) {
            $colour = new Colour();
            $colour->setName($colourName);
            $manager->persist($colour);
        }
        $manager->flush();
        $this->addReference(self::RED_COLOUR_REFERENCE, $colour);
    }

}
