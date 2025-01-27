<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Company;

class StateTax extends Model
{
    protected $fillable = [
        'company_id',
        'code',
        'environment_type',
        'tax_number',
        'special_tax_regime',
        'serie',
        'number',
        'security_credential_id',
        'type',
    ];

    
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    } 
}
