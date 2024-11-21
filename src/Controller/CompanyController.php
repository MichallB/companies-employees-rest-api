<?php

namespace App\Controller;

use App\Entity\Company;
use App\Repository\CompanyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route("/api/companies", name: "app_company_")]
class CompanyController extends AbstractController
{
    public function __construct(
        private readonly CompanyRepository $companyRepository
    ) {}

    #[Route("", name: "show", methods: ["GET"])]
    public function showAll(): JsonResponse
    {
        $companies = $this->companyRepository->findAll();
        return new JsonResponse($companies);
    }

    #[Route("/{id}", name: "show_by_id", methods: ["GET"])]
    public function showById(int $id): JsonResponse
    {
        $company = $this->companyRepository->find($id);

        if (!$company) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        return new JsonResponse($company);
    }

    #[Route("", name: "create", methods: ["POST"])]
    public function create(Request $request, ValidatorInterface $validator): JsonResponse
    {
        $data = $request->getPayload();
        $company = new Company();
        if ($data->has("name"))
            $company->setName($data->getString("name"));
        if ($data->has("nip"))
            $company->setNip($data->getString("nip"));
        if ($data->has("address"))
            $company->setAddress($data->getString("address"));
        if ($data->has("city"))
            $company->setCity($data->getString("city"));
        if ($data->has("postCode"))
            $company->setPostCode($data->getString("postCode"));

        $errors = $validator->validate($company);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(["errors" => $errorsString], Response::HTTP_BAD_REQUEST);
        }

        $this->companyRepository->save($company, true);
        return new JsonResponse($company, Response::HTTP_CREATED);
    }

    #[Route("/{id}", name: "update", methods: ["PUT"])]
    public function update(Request $request, ValidatorInterface $validator, int $id): JsonResponse
    {
        $company = $this->companyRepository->find($id);

        if (!$company) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $data = $request->getPayload();

        if ($data->has("name"))
            $company->setName($data->getString("name"));
        if ($data->has("nip"))
            $company->setName($data->getString("nip"));
        if ($data->has("address"))
            $company->setAddress($data->getString("address"));
        if ($data->has("city"))
            $company->setCity($data->getString("city"));
        if ($data->has("postCode"))
            $company->setPostCode($data->getString("postCode"));

        $errors = $validator->validate($company);
        if (count($errors) > 0) {
            $errorsString = (string) $errors;
            return new JsonResponse(["errors" => $errorsString], Response::HTTP_BAD_REQUEST);
        }

        $this->companyRepository->save($company, true);
        return new JsonResponse($company);
    }

    #[Route("/{id}", name: "delete", methods: ["DELETE"])]
    public function delete(int $id): JsonResponse
    {
        $company = $this->companyRepository->find($id);

        if (!$company) {
            return new JsonResponse(null, Response::HTTP_NOT_FOUND);
        }

        $this->companyRepository->remove($company, true);
        return new JsonResponse(null, Response::HTTP_NO_CONTENT);
    }
}
