<?php

declare(strict_types=1);

namespace App\Service\Employee\Reader;

use App\Entity\Employee;
use App\Repository\Employee\EmployeeRepositoryInterface;

final class EmployeeReader
{
    public function __construct(
        private readonly EmployeeRepositoryInterface $employeeRepository,
    ) {
    }

    /**
     * Get an Employee.
     *
     * @param ReadEmployeePayload $payload
     *
     * @return Employee
     */
    public function read(ReadEmployeePayload $payload): Employee
    {
        return $this->employeeRepository->findById($payload->id);
    }
}
