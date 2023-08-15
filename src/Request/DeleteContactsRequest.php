<?php

namespace App\Request;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\Uuid;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class DeleteContactsRequest extends BaseRequest
{
    /**
     * @var string[]
     */
    #[Type('array')]
    #[NotBlank]
    public ?array $uuids = null;

    /**
     * @return array<string, array<int, array<string, string>>|string>
     */
    public function validate(): array
    {
        $errors = parent::validate();
        if (!is_array($this->uuids)) {
            $errors['errors'][] = [
                'value' => $this->uuids,
                'message' => 'This is not array of uuids.'
            ];
        }
        foreach ($this->uuids as $uuid) {
            if (!Uuid::isValid($uuid)) {
                $errors['errors'][] = [
                    'value' => $uuid,
                    'message' => 'This is not valid uuid.'
                ];
            }
        }

        return $errors;
    }
}
