<?php
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\CertificateController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\VerifyAuthHeader;
use App\Http\Controllers\StateTaxController;

Route::middleware([VerifyAuthHeader::class])->group(function () {
    Route::get('/api/companies', [CompaniesController::class, 'index']);
    Route::post('/api/companies', [CompaniesController::class, 'store']);
    Route::get('/api/companies/{id}', [CompaniesController::class, 'show']);
    Route::put('/api/companies/{id}', [CompaniesController::class, 'update']);
    Route::delete('/api/companies/{id}', [CompaniesController::class, 'destroy']);
    
});
Route::prefix('/api/companies/{company_id}/certificates')->group(function () {
    Route::get('/', [CertificateController::class, 'getCertificatesByStatus']); 
    Route::post('/', [CertificateController::class, 'uploadCertificate']); 
    Route::get('/{thumbprint}', [CertificateController::class, 'getCertificateByThumbprint']); 
    Route::delete('/{thumbprint}', [CertificateController::class, 'deleteCertificate']); 
});


Route::prefix('/api/companies/{company_id}/statetaxes')->group(function () {
    Route::get('/', [StateTaxController::class, 'index']);
    Route::post('/', [StateTaxController::class, 'store']);
    Route::get('/{state_tax_id}', [StateTaxController::class, 'show']);
    Route::put('/{state_tax_id}', [StateTaxController::class, 'update']);
    Route::delete('/{state_tax_id}', [StateTaxController::class, 'destroy']);
});
