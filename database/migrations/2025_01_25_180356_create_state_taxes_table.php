<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('state_taxes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies')->onDelete('cascade');
            $table->string('code');
            $table->string('environment_type');
            $table->string('tax_number');
            $table->string('special_tax_regime');
            $table->integer('serie');
            $table->integer('number');
            $table->foreignId('security_credential_id')->constrained('security_credentials')->onDelete('cascade');
            $table->string('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('state_taxes');
    }
};
