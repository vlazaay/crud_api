<?php

declare(strict_types=1);

namespace Tests\Functional\Repository\Employee;

use App\Entity\Employee;
use App\Repository\Employee\EmployeeRepository;
use DateTime;
use Doctrine\ORM\NoResultException;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class EmployeeRepositoryTest extends KernelTestCase
{
    private EmployeeRepository $employeeRepository;

    /**
     * This method is called before each test.
     *
     * @return void
     *
     * @throws Exception
     */
    protected function setUp(): void
    {
        $employeeRepository = self::getContainer()->get(EmployeeRepository::class);

        if ($employeeRepository instanceof EmployeeRepository) {
            $this->employeeRepository = $employeeRepository;
        } else {
            throw new InvalidArgumentException('Invalid service dependency injection');
        }
    }

    /**
     * Test find by id.
     *
     * @return void
     */
    public function testFindByIdSuccessful(): void
    {
        $user = $this->employeeRepository->store($this->getMockEntity());

        try {
            $this->employeeRepository->findById((int) $user->getId());

            self::assertTrue(true);
        } catch (NoResultException $e) {
            self::fail();
        }
    }

    /**
     * Test find by email.
     *
     * @return void
     */
    public function testFindByEmailSuccessful(): void
    {
        $user = $this->employeeRepository->store($this->getMockEntity());

        try {
            $this->employeeRepository->findByEmail($user->getEmail());

            self::assertTrue(true);
        } catch (NoResultException $e) {
            self::fail();
        }
    }

    /**
     * Test employee existence by email.
     *
     * @return void
     */
    public function testExistsByEmailSuccessful(): void
    {
        $user = $this->employeeRepository->store($this->getMockEntity());

        $result = $this->employeeRepository->existsByEmail($user->getEmail());

        self::assertTrue($result);
    }

    /**
     * Test store.
     *
     * @return void
     */
    public function testStoreSuccessful(): void
    {
        $expected = $this->getMockEntity();
        $actual = $this->employeeRepository->store($expected);

        self::assertEquals($expected, $actual);
    }

    /**
     * Test update.
     *
     * @return void
     */
    public function testUpdateSuccessful(): void
    {
        $expected = $this->employeeRepository->store($this->getMockEntity());
        $actual = $this->employeeRepository->update($expected->setSalary(400));

        self::assertEquals($expected, $actual);
    }

    /**
     * Test delete.
     *
     * @return void
     */
    public function testDeleteSuccessful(): void
    {
        $employee = $this->getMockEntity();
        $id = $this->employeeRepository->store($employee)->getId();
        $this->employeeRepository->delete($employee);

        try {
            $this->employeeRepository->findById($id);
            self::fail('Expected NoResultException to be thrown.');
        } catch (NoResultException $e) {
            self::assertInstanceOf(NoResultException::class, $e);
        }
    }

    /**
     * Get mock entity.
     *
     * @return Employee
     */
    private function getMockEntity(): Employee
    {
        return (new Employee())
            ->setFirstname('TestFirstName')
            ->setLastname('TestLastName')
            ->setEmail('employee2@gmail.com')
            ->setHireDate(new DateTime('2024-12-31'))
            ->setSalary(150);
    }
}
