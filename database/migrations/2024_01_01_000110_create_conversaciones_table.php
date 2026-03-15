<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('conversaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('candidato_user_id')->constrained('users')->cascadeOnDelete();
            $table->string('asunto', 255);
            $table->timestamps();

            $table->unique(['empresa_user_id', 'candidato_user_id', 'asunto']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conversaciones');
    }
};
