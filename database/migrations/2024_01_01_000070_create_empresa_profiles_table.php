<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('empresa_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('rut', 20);
            $table->string('sector', 100);
            $table->text('descripcion')->nullable();
            $table->foreignId('departamento_id')->constrained('departamentos');
            $table->string('sitio_web')->nullable();
            $table->string('logo')->nullable();
            $table->text('politicas_inclusion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('empresa_profiles');
    }
};
