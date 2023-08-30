<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Employee;
use App\Request\CreateEmployeeRequest;
use App\Request\DeleteEmployeeRequest;
use App\Request\ReadEmployeeRequest;
use App\Request\UpdateEmployeeRequest;
use App\Service\Employee\Creator\EmployeeCreator;
use App\Service\Employee\Deleter\EmployeeDeleter;
use App\Service\Employee\Reader\EmployeeReader;
use App\Service\Employee\Updater\EmployeeUpdater;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Attributes\Delete;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Parameter;
use OpenApi\Attributes\Post;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Put;
use OpenApi\Attributes\RequestBody;
use OpenApi\Attributes\Response;
use Symfony\Component\HttpFoundation\Response as HttpResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class EmployeeController extends AbstractController
{
    #[Route('/api/employee', methods: ['POST'])]
    #[Post(
        path:"/api/employee",
        operationId:"storeEmployee",
        description:"Store a new employee",
        summary:"Store a new employee",
        requestBody: new RequestBody(
            content: new JsonContent(ref: new Model(type: Employee::class, groups: ["create"]))
        ),
        responses: [
            new Response(
                response: HttpResponse::HTTP_CREATED,
                description: 'code 201, success',
                content: new JsonContent(
                    properties: [
                        new Property(property: 'message', type: 'string'),
                    ],
                    type: 'object'
                )
            ),
            new Response(response: HttpResponse::HTTP_UNPROCESSABLE_ENTITY, description: 'code 422, validation error'),
        ]
    )]
    public function store(CreateEmployeeRequest $request, EmployeeCreator $service): JsonResponse
    {
        $payload = $request->getPayload();
        $service->create($payload);

        return new JsonResponse(['message' => 'Employee stored successfully'], HttpResponse::HTTP_CREATED);
    }

    #[Route('/api/employee', methods: ['PUT'])]
    #[Put(
        path:"/api/employee",
        operationId:"updateEmployee",
        description:"Update an employee",
        summary:"Update an employee",
        requestBody: new RequestBody(
            content: new JsonContent(ref: new Model(type: Employee::class, groups: ["update"]))
        ),
        responses: [
            new Response(
                response: HttpResponse::HTTP_OK,
                description: 'code 200, success',
                content: new JsonContent(
                    properties: [
                        new Property(property: 'message', type: 'string'),
                    ],
                    type: 'object'
                )
            ),
            new Response(response: HttpResponse::HTTP_UNPROCESSABLE_ENTITY, description: 'code 422, validation error'),
        ]
    )]
    public function update(UpdateEmployeeRequest $request, EmployeeUpdater $service): JsonResponse
    {
        $payload = $request->getPayload();
        $service->update($payload);

        return new JsonResponse(['message' => 'Employee updated successfully'], HttpResponse::HTTP_OK);
    }

    #[Route('/api/employee/{id}', methods: ['GET'])]
    #[Get(
        path:"/api/employee",
        operationId:"getEmployee",
        description:"Get an employee",
        summary:"Get an employee",
        parameters: [new Parameter(
            name:"id",
            description:"Enter employee internal id",
            in:"path",
            required:true,
        )],
        responses: [
            new Response(
                response: HttpResponse::HTTP_OK,
                description: 'code 200, success',
                content: new JsonContent(
                    properties: [
                        new Property(property: 'firstname', type: 'string'),
                        new Property(property: 'lastname', type: 'string'),
                        new Property(property: 'email', type: 'string'),
                        new Property(property: 'hireDate', type: 'string'),
                        new Property(property: 'salary', type: 'string'),
                    ],
                    type: 'object'
                )
            ),
            new Response(response: HttpResponse::HTTP_UNPROCESSABLE_ENTITY, description: 'code 422, validation error'),
        ]
    )]
    public function read(ReadEmployeeRequest $request, EmployeeReader $service): JsonResponse
    {
        $payload = $request->getPayload();
        $employee = $service->read($payload);

        return new JsonResponse($employee->toArray(), HttpResponse::HTTP_OK);
    }

    #[Route('/api/employee', methods: ['DELETE'])]
    #[Delete(
        path:"/api/employee",
        operationId:"deleteEmployee",
        description:"Delete an employee",
        summary:"Delete an employee",
        requestBody: new RequestBody(
            content: new JsonContent(ref: new Model(type: Employee::class, groups: ["delete"]))
        ),
        responses: [
            new Response(
                response: HttpResponse::HTTP_OK,
                description: 'code 200, success',
                content: new JsonContent(
                    properties: [
                        new Property(property: 'message', type: 'string'),
                    ],
                    type: 'object'
                )
            ),
            new Response(response: HttpResponse::HTTP_UNPROCESSABLE_ENTITY, description: 'code 422, validation error'),
        ]
    )]
    public function delete(DeleteEmployeeRequest $request, EmployeeDeleter $service): JsonResponse
    {
        $payload = $request->getPayload();
        $service->delete($payload);

        return new JsonResponse(['message' => 'Employee deleted successfully'], HttpResponse::HTTP_OK);
    }
}