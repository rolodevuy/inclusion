<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ofertas_empleo', function (Blueprint $table) {
            $table->unsignedInteger('salario_min')->nullable()->after('adaptaciones_disponibles');
            $table->unsignedInteger('salario_max')->nullable()->after('salario_min');
            $table->enum('salario_moneda', ['UYU', 'USD'])->default('UYU')->after('salario_max');
            $table->boolean('salario_visible')->default(true)->after('salario_moneda');
        });
    }

    public function down(): void
    {
        Schema::table('ofertas_empleo', function (Blueprint $table) {
            $table->dropColumn(['salario_min', 'salario_max', 'salario_moneda', 'salario_visible']);
        });
    }
};
