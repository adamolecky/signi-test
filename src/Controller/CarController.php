<?php

namespace App\Controller;

use App\DTO\CarDTO;
use App\Entity\Car;
use App\Exceptions\CarNotFoundException;
use App\Facade\CarFacade;
use App\Repository\CarRepository;
use App\Request\CreateCarRequest;
use App\ResponseFactory\CarResponseFactory;
use JetBrains\PhpStorm\NoReturn;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class CarController extends AbstractController
{
    public function __construct(
        private CarRepository $carRepository,
        private CarResponseFactory $carResponseFactory,
        private CarFacade $carFacade
    ) {
    }

    #[Route('/cars', name: 'app_car_list', methods: ['GET'])]
    public function index(): Response
    {
        return new JsonResponse($this->carResponseFactory->fromEntitiesToCarResponse($this->carRepository->findAll()));
    }

    #[Route('/cars', name: 'app_car_new', methods: ['POST'])]
    public function new(CreateCarRequest $request): Response
    {
        try {
            $errors = $request->validate();
            if (count($errors)) {
                return new JsonResponse($errors, 400);
            }
            $carDto = new CarDto();
            $carDto->fillFromRequest($request);
            $carEntity = $this->carFacade->save($carDto);

        } catch (\Exception) {
            return new JsonResponse(['error' => 'Error occurred when saving car.'], 500);
        }
        return new JsonResponse($this->carResponseFactory->fromEntityToCarResponse($carEntity));
    }

    #[Route('/car/{carId}', name: 'app_car_show', methods: ['GET'])]
    public function show(?string $carId = null): Response
    {
        if ((int)$carId === 0) {
            return new JsonResponse(['error' => 'Not valid format of Id, use integer instead.'], 400);
        }
        $carEntity = $this->carRepository->find((int)$carId);
        if ($carEntity !== null) {
            return new JsonResponse($this->carResponseFactory->fromEntityToCarResponse($carEntity));
        }

        return new JsonResponse(['error' => 'Not found.'], 404);
    }

    #[Route('/cars/{carId}', name: 'app_car_delete', methods: ['DELETE'])]
    public function delete(?string $carId): Response
    {
        if ((int)$carId === 0) {
            return new JsonResponse(['error' => 'Not valid format of Id, use integer instead.'], 400);
        }

        try {
            $this->carFacade->remove((int)$carId);
        } catch (CarNotFoundException) {
            return new JsonResponse(['error' => 'Id was not found.'], 404);
        }

        return new JsonResponse(['message' => 'Removed.'], 200);
    }

}
