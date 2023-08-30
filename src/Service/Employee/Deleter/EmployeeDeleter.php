<?php

declare(strict_types=1);

namespace App\Service\Employee\Deleter;

use App\Repository\Employee\EmployeeRepositoryInterface;

final class EmployeeDeleter
{
    public function __construct(
        private readonly EmployeeRepositoryInterface $employeeRepository,
    ) {
    }

    /**
     * Delete an Employee.
     *
     * @param DeleteEmployeePayload $payload
     *
     * @return void
     */
    public function delete(DeleteEmployeePayload $payload): void
    {
        $employee = $this->employeeRepository->findById($payload->id);

        $this->employeeRepository->delete($employee);
    }
}
