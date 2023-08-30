<?php

declare(strict_types=1);

namespace App\Service\Employee\Reader;

use App\Service\AbstractPayload;

final class ReadEmployeePayload extends AbstractPayload
{
    public function __construct(
        public readonly int $id,
    ) {
    }
}
