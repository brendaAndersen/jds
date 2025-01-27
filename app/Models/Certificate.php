<?php

namespace App\Models;
use App\Models\Company;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'subject',
        'valid_until',
        'thumbprint',
        'federal_tax_number',
        'modified_on',
        'status',
    ];

    protected $casts = [
        'valid_until' => 'datetime',
        'modified_on' => 'datetime',
    ];

    
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }}
