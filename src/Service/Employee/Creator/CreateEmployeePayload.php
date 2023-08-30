<?php

declare(strict_types=1);

namespace App\Service\Employee\Creator;

use App\Service\AbstractPayload;
use DateTime;

final class CreateEmployeePayload extends AbstractPayload
{
    public function __construct(
        public readonly string $firstname,
        public readonly string $lastname,
        public readonly string $email,
        public readonly DateTime $hireDate,
        public readonly int $salary,
    ) {
    }
}
