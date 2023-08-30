<?php

declare(strict_types=1);

namespace Tests\Functional\Service\Employee\Updater;

use App\Repository\Employee\EmployeeRepository;
use App\Service\Employee\Creator\CreateEmployeePayload;
use App\Service\Employee\Creator\EmployeeCreator;
use App\Service\Employee\Updater\EmployeeUpdater;
use App\Service\Employee\Updater\UpdateEmployeePayload;
use DateTime;
use Exception;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class EmployeeUpdaterTest extends KernelTestCase
{
    private EmployeeUpdater $employeeUpdater;
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
            $this->employeeUpdater = new EmployeeUpdater($employeeRepository);
            $this->employeeCreator = new EmployeeCreator($employeeRepository);
        } else {
            throw new InvalidArgumentException('Invalid service dependency injection');
        }
    }

    /**
     * Test update.
     *
     * @return void
     */
    public function testUpdateSuccessful(): void
    {
        $email = 'employee22@gmail.com';
        $expectedCreate = new CreateEmployeePayload(
            firstname: 'firstname',
            lastname: 'lastname',
            email: $email,
            hireDate: new DateTime('2024-12-31'),
            salary: 500
        );

        $actualCreate = $this->employeeCreator->create($expectedCreate);

        $expectedUpdate = new UpdateEmployeePayload(
            firstname: 'firstnameUPDATED',
            lastname: 'lastnameUPDATED',
            email: $email,
            hireDate: new DateTime('2025-12-31'),
            salary: 600
        );
        $actualUpdate = $this->employeeUpdater->update($expectedUpdate);

        self::assertEquals($actualCreate->getEmail(), $actualUpdate->getEmail());
        self::assertEquals($expectedUpdate->firstname, $actualUpdate->getFirstname());
        self::assertEquals($expectedUpdate->lastname, $actualUpdate->getLastname());
        self::assertEquals($expectedUpdate->hireDate, $actualUpdate->getHireDate());
        self::assertEquals($expectedUpdate->salary, $actualUpdate->getSalary());
    }
}
