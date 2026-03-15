<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidato_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->foreignId('categoria_laboral_id')->constrained('categorias_laborales');
            $table->enum('modalidad_trabajo', ['presencial', 'remoto', 'hibrido']);
            $table->string('nivel_educativo', 100)->nullable();
            $table->text('sobre_mi')->nullable();
            $table->string('tipo_discapacidad', 100)->nullable();
            $table->boolean('tiene_certificado')->nullable();
            $table->text('necesidades_adaptacion')->nullable();
            $table->enum('visibilidad_discapacidad', ['publica', 'bajo_solicitud', 'privada'])->default('privada');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidato_profiles');
    }
};
