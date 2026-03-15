<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ofertas_empleo', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('titulo');
            $table->text('descripcion');
            $table->foreignId('categoria_laboral_id')->constrained('categorias_laborales');
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->enum('modalidad', ['presencial', 'remoto', 'hibrido']);
            $table->string('horario', 100)->nullable();
            $table->text('requisitos')->nullable();
            $table->text('beneficios')->nullable();
            $table->text('adaptaciones_disponibles')->nullable();
            $table->enum('estado', ['activa', 'pausada', 'cerrada'])->default('activa');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ofertas_empleo');
    }
};
