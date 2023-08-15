<?php

namespace App\Request;

use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

class CreateCarRequest extends BaseRequest
{
    #[Type('string')]
    #[NotBlank()]
    public string $make;

    #[Type('string')]
    #[NotBlank()]
    public string $model;

    #[NotBlank()]
    #[DateTime]
    public string $build_at;

    /**
     * @var string[]
     */
    #[Type('array')]
    public ?array $colours = null;

    /**
     * @return array<string, array<int, array<string, string>>|string>
     */
    public function validate(): array
    {
        $errors = parent::validate();

        $buildAt = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $this->build_at);
        $deadline = (new DateTimeImmutable())->modify('-4 years');
        $diff = $buildAt->diff($deadline);
        if ($diff->invert === 0) {
            $errors['errors'][] = [
                'property' => 'build_at',
                'value' => $this->build_at,
                'message' => 'Car must not be older than 4 years. (check build_at param)',
            ];
        }
        return $errors;
    }
}
