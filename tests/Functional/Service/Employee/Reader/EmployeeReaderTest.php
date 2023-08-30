<?php

declare(strict_types=1);

namespace Tests\Functional\Service\Employee\Reader;

use App\Repository\Employee\EmployeeRepository;
use App\Service\Employee\Creator\CreateEmployeePayload;
use App\Service\Employee\Reader\EmployeeReader;
use App\Service\Employee\Reader\ReadEmployeePayload;
use App\Service\Employee\Creator\EmployeeCreator;
use DateTime;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class EmployeeReaderTest extends KernelTestCase
{
    private EmployeeReader $employeeReader;
    private EmployeeCreator $employeeCreator;

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
            $this->employeeCreator = new EmployeeCreator($employeeRepository);
            $this->employeeReader = new EmployeeReader($employeeRepository);
        } else {
            throw new InvalidArgumentException('Invalid service dependency injection');
        }
    }

    /**
     * Test read.
     *
     * @return void
     */
    public function testReadSuccessful(): void
    {
        $expectedCreate = new CreateEmployeePayload(
            firstname: 'firstname',
            lastname: 'lastname',
            email: 'employee22@gmail.com',
            hireDate: new DateTime('2024-12-31'),
            salary: 500
        );

        $actualCreate = $this->employeeCreator->create($expectedCreate);

        $expectedRead = new ReadEmployeePayload(
            id: $actualCreate->getId()
        );

        $actualRead = $this->employeeReader->read($expectedRead);

        self::assertIsInt($actualRead->getId());
        self::assertEquals($expectedCreate->firstname, $actualRead->getFirstname());
        self::assertEquals($expectedCreate->lastname, $actualRead->getLastname());
        self::assertEquals($expectedCreate->email, $actualRead->getEmail());
        self::assertEquals($expectedCreate->hireDate, $actualRead->getHireDate());
        self::assertEquals($expectedCreate->salary, $actualRead->getSalary());
    }
}
