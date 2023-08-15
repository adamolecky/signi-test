<?php

namespace App\DataFixtures;

use App\Entity\Colour;
use App\Entity\Contact;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ContactFixtures extends Fixture
{
    public const CONTACT_DATASET = [
        [
            'name' => 'Adam',
            'surname' => 'O',
            'phone' => '777173000'
        ],
        [
            'name' => 'Adam1',
            'surname' => 'O',
            'phone' => '777173001'
        ],
        [
            'name' => 'Adam2',
            'surname' => 'O',
            'phone' => '777173002'
        ],
        [
            'name' => 'Adam3',
            'surname' => 'O',
            'phone' => '777173003'
        ],
        [
            'name' => 'Adam4',
            'surname' => 'O',
            'phone' => '777173004'
        ],
        [
            'name' => 'Adam5',
            'surname' => 'O',
            'phone' => '777173005'
        ],
        [
            'name' => 'Adam6',
            'surname' => 'O',
            'phone' => '777173006'
        ],
    ];


    public function load(ObjectManager $manager): void
    {
        foreach ($this->generateValues() as $contactData) {
            $contact = new Contact();
            $contact->setName($contactData['name']);
            $contact->setSurname($contactData['surname']);
            $contact->setPhone($contactData['phone']);
            $manager->persist($contact);
        }
        $manager->flush();
    }

    /**
     * @return \Generator
     */
    private function generateValues(): \Generator
    {
        foreach (self::CONTACT_DATASET as $contactData) {
            yield $contactData;
        }
    }

}
