<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_acceso', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('candidato_profile_id')->constrained('candidato_profiles')->cascadeOnDelete();
            $table->enum('estado', ['pendiente', 'aprobada', 'rechazada'])->default('pendiente');
            $table->text('mensaje')->nullable();
            $table->timestamps();

            $table->unique(['empresa_user_id', 'candidato_profile_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_acceso');
    }
};
