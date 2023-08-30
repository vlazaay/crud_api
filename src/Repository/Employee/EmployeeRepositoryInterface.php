<?php

declare(strict_types=1);

namespace App\Repository\Employee;

use App\Entity\Employee;

interface EmployeeRepositoryInterface
{
    /**
     * Find employee by identifier.
     *
     * @param int $id
     *
     * @return Employee
     */
    public function findById(int $id): Employee;

    /**
     * Find employee by email.
     *
     * @param string $email
     *
     * @return Employee
     */
    public function findByEmail(string $email): Employee;

    /**
     * Check employee existence by email.
     *
     * @param string $email
     *
     * @return bool
     */
    public function existsByEmail(string $email): bool;

    /**
     * Store a new employee.
     *
     * @param Employee $Eeployee
     *
     * @return Employee
     */

    public function store(Employee $employee): Employee;

    /**
     * Update employee.
     *
     * @param Employee $employee
     *
     * @return Employee
     */
    public function update(Employee $employee): Employee;

    /**
     * Delete employee.
     *
     * @param Employee $employee
     *
     * @return void
     */
    public function delete(Employee $employee): void;
}
