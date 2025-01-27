<?php

namespace App\Services;

use App\Models\Certificate;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Http;

class CertificateService
{
    private string $baseUrl = 'https://api.nfe.io/v2/companies';

    public function listByStatus($company_id, $authHeader, $status)
    {
        $url = "{$this->baseUrl}/{$company_id}/certificates";

        $response = Http::withHeaders(['Authorization' => $authHeader])
            ->get($url, ['status' => $status]);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao listar certificados: ' . $response->body(), $response->status());
    }

    public function upload($company_id, $authHeader, $data)
    {   
        $url = "{$this->baseUrl}/{$company_id}/certificates";

        $response = Http::withHeaders(['Authorization' => $authHeader])
            ->post($url, $data);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao fazer upload do certificado: ' . $response->body(), $response->status());
    }

    public function getByThumbprint($company_id, $authHeader, $thumbprint)
    {
        $url = "{$this->baseUrl}/{$company_id}/certificates/{$thumbprint}";

        $response = Http::withHeaders(['Authorization' => $authHeader])->get($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao buscar o certificado: ' . $response->body(), $response->status());
    }
    public function deleteByThumbprint($company_id, $authHeader, $thumbprint)
    {
        $url = "{$this->baseUrl}/{$company_id}/certificates/{$thumbprint}";

        $response = Http::withHeaders(['Authorization' => $authHeader])->delete($url);

        if ($response->successful()) {
            return $response->json();
        }

        throw new \Exception('Erro ao deletar o certificado: ' . $response->body(), $response->status());
    }
}
