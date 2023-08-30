<?php

declare(strict_types=1);

namespace App\Request;

use App\Service\AbstractPayload;
use App\Service\Employee\Reader\ReadEmployeePayload;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;

final class ReadEmployeeRequest extends BaseRequest
{
    #[Type('integer')]
    #[NotBlank()]
    protected int $id;

    public function getPayload(): AbstractPayload
    {
        return new ReadEmployeePayload(
            $this->id
        );
    }
}
