<?php

declare(strict_types=1);

namespace App\Service\Employee\Creator;

use App\Entity\Employee;
use App\Repository\Employee\EmployeeRepositoryInterface;
use Exception;

final class EmployeeCreator
{
    public function __construct(
        private readonly EmployeeRepositoryInterface $employeeRepository,
    ) {
    }

    /**
     * Create a new Employee.
     *
     * @param CreateEmployeePayload $payload
     *
     * @return Employee
     *
     * @throws Exception
     */
    public function create(CreateEmployeePayload $payload): Employee
    {
        if ($this->employeeRepository->existsByEmail($payload->email)) {
            throw new Exception('An employee with this email already exists.');
        }

        $employee = (new Employee())
            ->setFirstname($payload->firstname)
            ->setLastname($payload->lastname)
            ->setEmail($payload->email)
            ->setHireDate($payload->hireDate)
            ->setSalary($payload->salary);

        return $this->employeeRepository->store($employee);
    }
}
