<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidato_experiencias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidato_profile_id')->constrained('candidato_profiles')->cascadeOnDelete();
            $table->string('cargo');
            $table->string('empresa');
            $table->date('fecha_inicio');
            $table->date('fecha_fin')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidato_experiencias');
    }
};
