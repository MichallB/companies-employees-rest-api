<?php

namespace App\Controller;

use App\Entity\Employee;
use App\Repository\CompanyRepository;
use App\Repository\EmployeeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route("/api/employees", name: "app_employee_")]
class EmployeeController extends AbstractController
{
    public function __construct(
        private readonly EmployeeRepository $employeeRepository
    ) {}

    #[Route("", name: "show", methods: ["GET"])]
    public function showAll(): JsonResponse
    {
        $employees = $this->employeeRepository->findAll();

        return new JsonResponse($employees);
    }

    #[Route("/{id}", name: "show_by_id", methods: ["GET"])]
    public function showById(int $id): JsonResponse
    {
        $employee = $this->employeeRepository->find($id);

        if (!$employee) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($employee);
    }

    #[Route("", name: "create", methods: ["POST"])]
    public function create(Request $request, ValidatorInterface $validator, CompanyRepository $companyRepository): JsonResponse
    {
        $data = $request->getPayload();
        $employee = new Employee();
        if ($data->has("name")) {
            $employee->setName($data->getString("name"));
        }

        if ($data->has("surname")) {
            $employee->setSurname($data->getString("surname"));
        }

        if ($data->has("email")) {
            $employee->setEmail($data->getString("email"));
        }

        if ($data->has("phoneNumber")) {
            $employee->setPhoneNumber($data->get("phoneNumber"));
        }

        if ($data->has("companyId")) {
            $company = $companyRepository->find($data->getInt("companyId"));
            if (!$company) {
                return new JsonResponse(["errors" => "Company not found"], Response::HTTP_BAD_REQUEST);
            }
            $employee->setCompany($company);
        }

        $errors = $validator->validate($employee);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(["errors" => $errorsString], Response::HTTP_BAD_REQUEST);
        }

        $this->employeeRepository->save($employee, true);
        return new JsonResponse($employee, Response::HTTP_CREATED);
    }

    #[Route("/{id}", name: "update", methods: ["PUT"])]
    public function update(Request $request, ValidatorInterface $validator, CompanyRepository $companyRepository, int $id): JsonResponse
    {
        $employee = $this->employeeRepository->find($id);

        if (!$employee) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $data = $request->getPayload();

        if ($data->has("name")) {
            $employee->setName($data->getString("name"));
        }

        if ($data->has("surname")) {
            $employee->setSurname($data->getString("surname"));
        }

        if ($data->has("email")) {
            $employee->setEmail($data->getString("email"));
        }

        if ($data->has("phoneNumber")) {
            $employee->setPhoneNumber($data->get("phoneNumber"));
        }

        if ($data->has("companyId")) {
            $company = $companyRepository->find($data->getInt("companyId"));
            if (!$company) {
                return new JsonResponse(["errors" => "Company not found"], Response::HTTP_BAD_REQUEST);
            }
            $employee->setCompany($company);
        }

        $errors = $validator->validate($employee);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(["errors" => $errorsString], Response::HTTP_BAD_REQUEST);
        }

        $this->employeeRepository->save($employee, true);
        return new JsonResponse($employee);
    }

    #[Route("/{id}", name: "delete", methods: ["DELETE"])]
    public function delete(int $id): JsonResponse
    {
        $employee = $this->employeeRepository->find($id);

        if (!$employee) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $this->employeeRepository->remove($employee, true);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
