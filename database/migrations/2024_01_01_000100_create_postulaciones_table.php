<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('postulaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('oferta_empleo_id')->constrained('ofertas_empleo')->cascadeOnDelete();
            $table->foreignId('candidato_user_id')->constrained('users')->cascadeOnDelete();
            $table->text('mensaje')->nullable();
            $table->enum('estado', ['pendiente', 'vista', 'aceptada', 'rechazada'])->default('pendiente');
            $table->timestamps();

            $table->unique(['oferta_empleo_id', 'candidato_user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('postulaciones');
    }
};
