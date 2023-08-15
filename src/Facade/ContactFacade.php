<?php

namespace App\Facade;

use App\DTO\CarDTO;
use App\Entity\Car;
use App\EntityFactory\CarFactory;
use App\Exceptions\CarNotFoundException;
use App\Repository\CarRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;

class ContactFacade
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private ContactRepository $contactRepository
    ) {
    }

    /**
     * @param string[] $uuids
     * @return array<string, array<int, array<string, string>>>|null
     */
    public function bulkRemove(array $uuids): ?array
    {
        $errors = [];
        foreach ($uuids as $uuid) {
            $contactEntity = $this->contactRepository->find($uuid);
            if ($contactEntity === null) {
                $errors['errors'][] = [
                    'value' => $uuid,
                    'message' => 'Uuid was not find.'
                ];
            } else {
                $this->entityManager->remove($contactEntity);
            }
            $this->entityManager->flush();
        }
        return $errors;
    }
}
