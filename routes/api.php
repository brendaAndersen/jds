<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompaniesController;

Route::middleware([\App\Http\Middleware\VerifyAuthHeader::class])->group(function () {
    Route::get('/companies', [CompaniesController::class, 'index']);
    Route::post('/companies', [CompaniesController::class, 'store']);
    Route::get('/companies/{id}', [CompaniesController::class, 'show']);
    Route::put('/companies/{id}', [CompaniesController::class, 'update']);
    Route::delete('/companies/{id}', [CompaniesController::class, 'delete']);
});
