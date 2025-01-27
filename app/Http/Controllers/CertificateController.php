<?php

namespace App\Http\Controllers;

use Exception;
use App\Services\CertificateService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CertificateController extends Controller
{
    private CertificateService $certificateService;

    public function __construct(CertificateService $certificateService)
    {
        $this->certificateService = $certificateService;
    }

    public function getCertificatesByStatus(Request $request, $company_id): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Authorization header is required'], 400);
            }

            $status = $request->query('status');
            $certificates = $this->certificateService->listByStatus($company_id, $authHeader, $status);

            return response()->json($certificates, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar cetificados', 'message' => $e->getMessage()], 500);
        }
    }

    public function uploadCertificate(Request $request, $company_id): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Necessário adicionar header authorization'], 400);
            }

            $validatedData = $request->validate([
                'subject' => 'required|string|max:255',
                'valid_until' => 'required|date',
                'thumbprint' => 'required|string|unique:certificates,thumbprint',
                'federal_tax_number' => 'required|string',
                'status' => 'required|in:active,inactive',
            ]);

            $certificate = $this->certificateService->upload($company_id, $authHeader, $validatedData);

            return response()->json($certificate, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro fazendo upload de certificado', 'message' => $e->getMessage()], 500);
        }
    }

    public function getCertificateByThumbprint(Request $request, $company_id, $thumbprint): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Necessário adicionar header authorization'], 400);
            }

            $certificate = $this->certificateService->getByThumbprint($company_id, $authHeader, $thumbprint);

            return response()->json($certificate, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro buscando certificado', 'message' => $e->getMessage()], 500);
        }
    }

    public function deleteCertificate(Request $request, $company_id, $thumbprint): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');
            if (!$authHeader) {
                return response()->json(['error' => 'Necessário adicionar header authorization'], 400);
            }

            $this->certificateService->deleteByThumbprint($company_id, $authHeader, $thumbprint);

            return response()->json(['message' => 'Certificado deletado com sucesso.'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao deletar certificado', 'message' => $e->getMessage()], 500);
        }
    }
}
