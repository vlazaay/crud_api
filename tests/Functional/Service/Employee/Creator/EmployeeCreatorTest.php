<?php

declare(strict_types=1);

namespace Tests\Functional\Service\Employee\Creator;

use App\Repository\Employee\EmployeeRepository;
use App\Service\Employee\Creator\CreateEmployeePayload;
use App\Service\Employee\Creator\EmployeeCreator;
use DateTime;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class EmployeeCreatorTest extends KernelTestCase
{
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
        } else {
            throw new InvalidArgumentException('Invalid service dependency injection');
        }
    }

    /**
     * Test create.
     *
     * @return void
     */
    public function testStoreSuccessful(): void
    {
        $expected = new CreateEmployeePayload(
            firstname: 'firstname',
            lastname: 'lastname',
            email: 'employee22@gmail.com',
            hireDate: new DateTime('2024-12-31'),
            salary: 500
        );

        $actual = $this->employeeCreator->create($expected);

        self::assertIsInt($actual->getId());
        self::assertEquals($expected->firstname, $actual->getFirstname());
        self::assertEquals($expected->lastname, $actual->getLastname());
        self::assertEquals($expected->email, $actual->getEmail());
        self::assertEquals($expected->hireDate, $actual->getHireDate());
        self::assertEquals($expected->salary, $actual->getSalary());
    }
}
