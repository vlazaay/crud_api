<?php

declare(strict_types=1);

namespace App\Service\Employee\Updater;

use App\Entity\Employee;
use App\Repository\Employee\EmployeeRepositoryInterface;

final class EmployeeUpdater
{
    public function __construct(
        private readonly EmployeeRepositoryInterface $employeeRepository,
    ) {
    }

    /**
     * Update an Employee.
     *
     * @param UpdateEmployeePayload $payload
     *
     * @return Employee
     */
    public function update(UpdateEmployeePayload $payload): Employee
    {
        $employee = $this->employeeRepository->findByEmail($payload->email);
        $employee
            ->setFirstname($payload->firstname)
            ->setLastname($payload->lastname)
            ->setHireDate($payload->hireDate)
            ->setSalary($payload->salary);

        return $this->employeeRepository->update($employee);
    }
}
