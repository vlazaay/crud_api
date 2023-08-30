<?php

declare(strict_types=1);

namespace App\Request;

use App\Service\AbstractPayload;
use App\Service\Employee\Creator\CreateEmployeePayload;
use DateTime;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final class CreateEmployeeRequest extends BaseRequest
{
    #[Type('string')]
    #[NotBlank()]
    protected string $firstname;

    #[Type('string')]
    #[NotBlank()]
    protected string $lastname;

    #[Type('string')]
    #[NotBlank()]
    #[Email()]
    protected string $email;

    #[NotBlank()]
    #[GreaterThanOrEqual('today')]
    protected DateTime $hireDate;

    #[Type('integer')]
    #[NotBlank()]
    #[GreaterThan(100)]
    protected int $salary;

    public function getPayload(): AbstractPayload
    {
        return new CreateEmployeePayload(
            $this->firstname,
            $this->lastname,
            $this->email,
            $this->hireDate,
            $this->salary,
        );
    }
}
