<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CompanyService;
use App\Exceptions\BusinessException;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;
use Illuminate\Support\Facades\Http;

class CompaniesController extends Controller
{
    private $companyService;
    public function __construct(CompanyService $companyService)
    {
        $this->companyService = $companyService;
    }

  
    public function index(Request $request): JsonResponse
    {
        try {
            $this->verifyAuth($request);

            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'é necessário adicionar a key'], 400);
            }

            $companies = $this->companyService->getAllCompanies($authHeader);

            return response()->json($companies, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno: ' . $e->getMessage()], $e->getCode() ?: 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'É necessário adicionar a chave Authorization'], 400);
            }
    
            $validatedData = $this->validateRequestData($request);
    
            $company = $this->companyService->create($validatedData, $authHeader);
    
            return response()->json($company, 201);
    
        }  catch (BusinessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor: ' . $e->getMessage()], 500);
        }
    }
    

    public function show(Request $request, string $id): JsonResponse
    {
        try {
            $this->verifyAuth($request);

            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'é necessário adicionar a key'], 400);
            }

            $company = $this->companyService->findById($id);
            return response()->json($company);
        } catch (BusinessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro interno do servidor.' . $e->getMessage()], 500);
        }
    }
    
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $this->verifyAuth($request);

            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'é necessário adicionar a key'], 400);
            }

            $validatedData = $this->validateRequestData($request);
            $company = $this->companyService->updateCompany($id, $validatedData, $authHeader);
            return response()->json($company);
        } catch (BusinessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar dados da empresa.', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, string $id): JsonResponse
    {
        try {
            $this->verifyAuth($request);

            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'é necessário adicionar a key'], 400);
            }

            $this->companyService->deleteCompany($id, $authHeader);
            return response()->json(['message' => 'Empresa deletada com sucesso.'], 200);
        } catch (BusinessException $e) {
            return response()->json(['error' => $e->getMessage()], $e->getCode());
        } catch (Exception $e) {
            return response()->json(['error' => 'Erro ao deletar dados da empresa.', 'message' => $e->getMessage()], 500);
        }
    }
    private function validateRequestData(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'account_id' => 'required|string|max:255',
            'trade_name' => 'required|string|max:255',
            'federal_tax_number' => 'required|numeric',
            'tax_regime' => 'required|string|max:255',
    
            'address_state' => 'required|string|max:255',
            'address_city_code' => 'required|string|max:255',
            'address_city_name' => 'required|string|max:255',
            'address_district' => 'required|string|max:255',
            'address_additional_information' => 'nullable|string|max:255',
            'address_street' => 'required|string|max:255',
            'address_number' => 'required|string|max:255',
            'address_postal_code' => 'required|string|max:10',
            'address_country' => 'required|string|max:255',
    
        ]);
    }
    
    private function verifyAuth(Request $request): void
    {
        $authorizationHeader = $request->header('Authorization');
        if (!$authorizationHeader || !str_starts_with($authorizationHeader, 'Bearer ')) {
            throw new Exception('Unauthorized access.', 401);
        }
    }
}
