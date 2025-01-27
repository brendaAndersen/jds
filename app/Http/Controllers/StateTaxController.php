<?php

namespace App\Http\Controllers;

use App\Services\StateTaxService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class StateTaxController extends Controller
{
    private StateTaxService $stateTaxService;

    public function __construct(StateTaxService $stateTaxService)
    {
        $this->stateTaxService = $stateTaxService;
    }

    public function index(Request $request, $company_id): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Authorization header is required'], 400);
            }

            $stateTaxes = $this->stateTaxService->list($company_id, $authHeader);

            return response()->json($stateTaxes, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar', 'message' => $e->getMessage()], 500);
        }
    }

    public function show(Request $request, $company_id, $state_tax_id): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Necessário adicionar uthorization header'], 400);
            }

            $stateTax = $this->stateTaxService->getById($company_id, $authHeader, $state_tax_id);

            return response()->json($stateTax, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar', 'message' => $e->getMessage()], 500);
        }
    }

    public function store(Request $request, $company_id): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Necessário authorization header'], 400);
            }

            $validatedData = $request->validate([
                'code' => 'required|string|max:255',
                'environmentType' => 'required|string',
                'taxNumber' => 'required|string',
                'specialTaxRegime' => 'required|string',
                'serie' => 'required|integer',
                'number' => 'required|integer',
                'securityCredential.id' => 'required|integer',
                'securityCredential.code' => 'required|string',
                'type' => 'required|string',
            ]);

            $stateTax = $this->stateTaxService->create($company_id, $authHeader, $validatedData);

            return response()->json($stateTax, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error creating state tax', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $company_id, $state_tax_id): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Necessário authorization header'], 400);
            }

            $validatedData = $request->validate([
                'code' => 'required|string|max:255',
                'environmentType' => 'required|string',
                'taxNumber' => 'required|string',
                'specialTaxRegime' => 'required|string',
                'serie' => 'required|integer',
                'number' => 'required|integer',
                'securityCredential.id' => 'required|integer',
                'securityCredential.code' => 'required|string',
                'type' => 'required|string',
            ]);

            $stateTax = $this->stateTaxService->update($company_id, $authHeader, $state_tax_id, $validatedData);

            return response()->json($stateTax, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy(Request $request, $company_id, $state_tax_id): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Authorization header is required'], 400);
            }

            $this->stateTaxService->delete($company_id, $authHeader, $state_tax_id);

            return response()->json(['message' => 'Deletado successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar', 'message' => $e->getMessage()], 500);
        }
    }
}
