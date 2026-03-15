<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidato_habilidad', function (Blueprint $table) {
            $table->foreignId('candidato_profile_id')->constrained('candidato_profiles')->cascadeOnDelete();
            $table->foreignId('habilidad_id')->constrained('habilidades')->cascadeOnDelete();
            $table->primary(['candidato_profile_id', 'habilidad_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidato_habilidad');
    }
};
