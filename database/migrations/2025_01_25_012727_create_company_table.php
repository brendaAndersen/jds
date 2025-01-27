<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('trade_name');
            $table->string('federal_tax_number', 14);
            
            // Address
            $table->string('address_state');
            $table->string('address_city_name');
            $table->string('address_city_code');
            $table->string('address_district');
            $table->string('address_number');
            $table->string('address_street');
            $table->string('address_additional_information')->nullable();
            $table->string('address_postal_code', 10);
            $table->string('address_country');
            
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
