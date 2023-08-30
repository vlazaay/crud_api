<?php

declare(strict_types=1);

namespace App\Repository\Employee;

use App\Entity\Employee;
use DateTimeImmutable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Employee>
 */
final class EmployeeRepository extends ServiceEntityRepository implements EmployeeRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Employee::class);
    }

    /**
     * Find employee by identifier.
     *
     * @param int $id
     *
     * @return Employee
     *
     * @throws NoResultException
     */
    public function findById(int $id): Employee
    {
        $entity = $this->find($id);

        if (null !== $entity) {
            return $entity;
        }

        throw new NoResultException();
    }

    /**
     * Find employee by email.
     *
     * @param string $email
     *
     * @return Employee
     *
     * @throws NoResultException
     */
    public function findByEmail(string $email): Employee
    {
        $entity = $this->findOneBy(['email' => $email]);

        if ($entity !== null) {
            return $entity;
        }

        throw new NoResultException();
    }

    /**
     * Check employee existence by email.
     *
     * @param string $email
     *
     * @return bool
     */
    public function existsByEmail(string $email): bool
    {
        $entity = $this->findOneBy(['email' => $email]);

        if ($entity !== null) {
            return true;
        }

        return false;
    }

    /**
     * Store a new employee.
     *
     * @param Employee $employee
     *
     * @return Employee
     */
    public function store(Employee $employee): Employee
    {
        $datetime = new DateTimeImmutable();
        $employee->setCreatedAt($datetime);
        $employee->setUpdatedAt($datetime);

        $this->getEntityManager()->persist($employee);
        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * Update employee.
     *
     * @param Employee $employee
     *
     * @return Employee
     */
    public function update(Employee $employee): Employee
    {
        $employee->setUpdatedAt(new DateTimeImmutable());

        $this->getEntityManager()->flush();

        return $employee;
    }

    /**
     * Delete employee.
     *
     * @param Employee $employee
     *
     * @return void
     */
    public function delete(Employee $employee): void
    {
        $this->getEntityManager()->remove($employee);
        $this->getEntityManager()->flush();
    }
}
