<?php
namespace App\Models;
use App\Models\Certificate;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
     'name',
        'account_id',
        'trade_name',
        'federal_tax_number',
        'tax_regime',
        'address_state',
        'address_city_code',
        'address_city_name',
        'address_district',
        'address_additional_information',
        'address_street',
        'address_number',
        'address_postal_code',
        'address_country',
    ];
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function stateTaxes(): HasMany
    {
        return $this->hasMany(StateTax::class);
    }
    protected $casts = [
        'address' => 'array',
        'economicActivities' => 'array',
        'certificate' => 'array',
        'openningDate' => 'datetime',
        'createdOn' => 'datetime',
        'modifiedOn' => 'datetime',
    ];
}