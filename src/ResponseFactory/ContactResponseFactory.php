<?php

namespace App\ResponseFactory;

use App\Entity\Car;
use App\Entity\Contact;
use App\Response\CarResponse;
use App\Response\ContactResponse;

class ContactResponseFactory
{
    public function fromEntityToContactResponse(Contact $contact): ContactResponse
    {
        return (new ContactResponse())->fillFromEntity($contact);
    }

    /**
     * @param Contact[] $contacts
     * @return ContactResponse[]
     */
    public function fromEntitiesToContactResponse(array $contacts): array
    {
        return array_map(fn (Contact $contact) => (new ContactResponse())->fillFromEntity($contact), $contacts);
    }
}
