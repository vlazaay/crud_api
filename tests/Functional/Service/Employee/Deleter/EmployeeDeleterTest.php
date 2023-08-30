<?php

declare(strict_types=1);

namespace Tests\Functional\Service\Employee\Deleter;

use App\Entity\Employee;
use App\Repository\Employee\EmployeeRepositoryInterface;
use App\Service\Employee\Deleter\DeleteEmployeePayload;
use App\Service\Employee\Deleter\EmployeeDeleter;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class EmployeeDeleterTest extends KernelTestCase
{
    private EmployeeRepositoryInterface $employeeRepository;
    private EmployeeDeleter $employeeDeleter;

    /**
     * This method is called before each test.
     *
     * @return void
     *
     * @throws Exception
     */
    protected function setUp(): void
    {
        $this->employeeRepository = $this->createMock(EmployeeRepositoryInterface::class);
        $this->employeeDeleter = new EmployeeDeleter($this->employeeRepository);
    }

    /**
     * Test delete.
     *
     * @return void
     */
    public function testDeleteSuccessful(): void
    {
        $mockEmployee = $this->createMock(Employee::class);

        // Set up expectations
        $this->employeeRepository
            ->expects($this->once())
            ->method('findById')
            ->willReturn($mockEmployee);

        $this->employeeRepository
            ->expects($this->once())
            ->method('delete');

        $payload = new DeleteEmployeePayload(id: 1);

        $this->employeeDeleter->delete($payload);
    }
}
