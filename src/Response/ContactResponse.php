<?php

namespace App\Response;

use App\Entity\Car;
use App\Entity\Colour;
use App\Entity\Contact;

class ContactResponse
{
    public string $id;
    public string $name;
    public string $surname;
    public string $phone;
    public function fillFromEntity(Contact $contact): ContactResponse
    {
        $this->id = $contact->getId()->toString();
        $this->name = $contact->getName();
        $this->surname = $contact->getSurname();
        $this->phone = $contact->getPhone();

        return $this;
    }

}
