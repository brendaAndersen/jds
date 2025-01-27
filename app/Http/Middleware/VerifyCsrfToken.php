<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    protected $except = [
        'api/*',
        'companies/*', 
        'api/companies/*', 
        'https://api.nfse.io/v2/companies/*', 
    ];
}
