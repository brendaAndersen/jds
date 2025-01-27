<?php

namespace App\Repositories;
use App\Models\Company;

use Illuminate\Support\Facades\Http;
use App\Exceptions\BusinessException;

class CompanyRepository
{
    private $apiBaseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->apiBaseUrl = 'https://api.nfse.io/v1/companies';
        $this->apiKey = ''; // Substitua pela chave correta
    }

    public function getAll(): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->apiBaseUrl);

        $this->handleResponse($response);
        return $response->json();
    }

    public function create(array $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->apiBaseUrl, $data);

        $this->handleResponse($response);
        return $response->json();
    }

    public function update(string $id, array $data): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->put("$this->apiBaseUrl/$id", $data);

        $this->handleResponse($response);
        return $response->json();
    }

    public function delete(string $id): void
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->delete("$this->apiBaseUrl/$id");

        $this->handleResponse($response);
    }

    public function findById(string $id): array
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get("$this->apiBaseUrl/$id");

        $this->handleResponse($response);
        return $response->json();
    }

    public function findByName(string $name): ?Company
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->apiBaseUrl, ['name' => $name]);

        if ($response->status() === 404) {
            return null;
        }

        $this->handleResponse($response);
        return Company::where('name', $name)->first();
    }
    public function findByField(string $federal_tax_number): ?Company
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->get($this->apiBaseUrl, ['federal_tax_number' => $federal_tax_number]);

        if ($response->status() === 404) {
            return null;
        }

        $this->handleResponse($response);
        return Company::where('federal_tax_number', $federal_tax_number)->first();
    }
    private function handleResponse($response): void
    {
        if (!$response->successful()) {
            $status = $response->status();
            $errorMessage = $response->json('message') ?? 'Erro na comunicação com a API.';

            if ($status === 404) {
                throw new BusinessException($errorMessage, 404);
            }

            throw new BusinessException($errorMessage, $status);
        }
    }
}
