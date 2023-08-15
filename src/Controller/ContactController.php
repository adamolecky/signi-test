<?php

namespace App\Controller;

use App\DTO\CarDTO;
use App\Entity\Car;
use App\Exceptions\CarNotFoundException;
use App\Facade\CarFacade;
use App\Facade\ContactFacade;
use App\Repository\CarRepository;
use App\Repository\ContactRepository;
use App\Request\CreateCarRequest;
use App\Request\DeleteContactsRequest;
use App\ResponseFactory\CarResponseFactory;
use App\ResponseFactory\ContactResponseFactory;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/contact')]
class ContactController extends AbstractController
{
    public function __construct(
        private ContactRepository $contactRepository,
        private ContactResponseFactory $contactResponseFactory,
        private ContactFacade $contactFacade
    ) {
    }

    #[Route('/list', name: 'app_contacts_list', methods: ['GET'])]
    public function index(): Response
    {
        return new JsonResponse($this->contactResponseFactory->fromEntitiesToContactResponse($this->contactRepository->findAll()));
    }

    #[Route('/batch-delete', name: 'app_contacts_delete', methods: ['DELETE', 'POST'])]
    public function delete(DeleteContactsRequest $request): Response
    {
        try {
            $errors = $request->validate();
            if (count($errors)) {
                return new JsonResponse($errors, 400);
            }
            $errors = $this->contactFacade->bulkRemove($request->uuids);

            if (count($errors)) {
                return new JsonResponse($errors, 200);
            }
        } catch (\Exception) {
            return new JsonResponse(['error' => 'Error occurred when removing contacts.'], 500);
        }
        return new JsonResponse([], 204);
    }

}
