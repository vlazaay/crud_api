<?php

declare(strict_types=1);

namespace App\Service\Employee\Deleter;

use App\Service\AbstractPayload;

final class DeleteEmployeePayload extends AbstractPayload
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
