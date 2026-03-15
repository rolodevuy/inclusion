<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('habilidades', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->foreignId('categoria_laboral_id')->nullable()->constrained('categorias_laborales')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('habilidades');
    }
};
