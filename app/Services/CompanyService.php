<?php

namespace App\Services;

use App\Repositories\CompanyRepository;
use App\Models\Company;
use App\Exceptions\BusinessException;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Http;

class CompanyService
{
    private $companyRepository;
    private $baseUrl;
    
    public function __construct(CompanyRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
        $this->baseUrl = 'https://api.nfse.io/v2/companies';
    }

    public function getAllCompanies(string $authHeader): array
    {
        $response = Http::withHeaders([
            'Authorization' => $authHeader,
        ])->get($this->baseUrl);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao listar empresas: ' . $response->body(), $response->status());
    }
    public function findById(string $id): Company
    {
        try {
            return Company::findOrFail($id);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new BusinessException("Empresa com ID '{$id}' não encontrada.", 404);
        }
    }
    
    public function create(array $data, string $authHeader): array
    {
        $companyFound = $this->companyRepository->findByField('federal_tax_number', $data['federal_tax_number']);
        if ($companyFound) {
            throw new \App\Exceptions\BusinessException(
                "Empresa com o número de registro fiscal '{$data['federal_tax_number']}' já existe no sistema.",
                409
            );
            throw new BusinessException("Empresa com o número de registro fiscal '{$data['federal_tax_number']}' já existe no sistema.", 409);

        }
    
        $response = Http::withHeaders([
            'Authorization' => $authHeader,
        ])->post($this->baseUrl, $data);
    
        if ($response->successful()) {
            return $response->json();
        }
    
        throw new \Exception('Erro ao criar empresa: ' . $response->body(), $response->status());
    }
    public function updateCompany(string $id, array $data, string $authHeader): array
    {
        $url = "{$this->baseUrl}/{$id}";
        $response = Http::withHeaders([
            'Authorization' => $authHeader,
        ])->put($url, $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao atualizar empresa: ' . $response->body(), $response->status());
    }

    public function deleteCompany(string $id, string $authHeader): void
    {
        $url = "{$this->baseUrl}/{$id}";
        $response = Http::withHeaders([
            'Authorization' => $authHeader,
        ])->delete($url);

        if (!$response->successful()) {
            throw new \Exception('Erro ao deletar empresa: ' . $response->body(), $response->status());
        }
    }
}
