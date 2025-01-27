<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class StateTaxService
{
    private string $baseUrl = 'https://api.nfse.io/v2/companies';

    public function list($company_id, $authHeader)
    {
        $url = "{$this->baseUrl}/{$company_id}/statetaxes";

        $response = Http::withHeaders(['Authorization' => $authHeader])->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao listar: ' . $response->body(), $response->status());
    }

    public function getById($company_id, $authHeader, $state_tax_id)
    {
        $url = "{$this->baseUrl}/{$company_id}/statetaxes/{$state_tax_id}";

        $response = Http::withHeaders(['Authorization' => $authHeader])->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao buscar : ' . $response->body(), $response->status());
    }

    public function create($company_id, $authHeader, $data)
    {
        $url = "{$this->baseUrl}/{$company_id}/statetaxes";

        $response = Http::withHeaders(['Authorization' => $authHeader])
            ->post($url, $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao cadastrar : ' . $response->body(), $response->status());
    }

    public function update($company_id, $authHeader, $state_tax_id, $data)
    {
        $url = "{$this->baseUrl}/{$company_id}/statetaxes/{$state_tax_id}";

        $response = Http::withHeaders(['Authorization' => $authHeader])
            ->put($url, $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao atualizar : ' . $response->body(), $response->status());
    }

    public function delete($company_id, $authHeader, $state_tax_id)
    {
        $url = "{$this->baseUrl}/{$company_id}/statetaxes/{$state_tax_id}";

        $response = Http::withHeaders(['Authorization' => $authHeader])->delete($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao excluir : ' . $response->body(), $response->status());
    }
}
