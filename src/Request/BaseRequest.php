<?php

namespace App\Request;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

abstract class BaseRequest
{
    public function __construct(protected ValidatorInterface $validator)
    {
        $this->populate();
    }

    /**
     * @return array<string, array<int, array<string, string>>|string>
     */
    public function validate(): array
    {
        $errors = $this->validator->validate($this);

        $messages = ['message' => 'validation_failed', 'errors' => []];

        /** @var \Symfony\Component\Validator\ConstraintViolation $message */
        foreach ($errors as $message) {
            $messages['errors'][] = [
                'property' => (string)$message->getPropertyPath(),
                'value' => (string)$message->getInvalidValue(),
                'message' => (string)$message->getMessage(),
            ];
        }

        if (count($messages['errors']) > 0) {
            return $messages;
        }

        return [];
    }

    public function getRequest(): Request
    {
        return Request::createFromGlobals();
    }

    protected function populate(): void
    {
        foreach ($this->getRequest()->toArray() as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $value;
            }
        }
    }
}
