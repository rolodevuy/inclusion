<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidato_profiles', function (Blueprint $table) {
            $table->string('certificado_path')->nullable()->after('visibilidad_discapacidad');
            $table->enum('certificado_estado', ['no_enviado', 'pendiente', 'verificado', 'rechazado'])->default('no_enviado')->after('certificado_path');
            $table->text('certificado_observaciones')->nullable()->after('certificado_estado');
        });
    }

    public function down(): void
    {
        Schema::table('candidato_profiles', function (Blueprint $table) {
            $table->dropColumn(['certificado_path', 'certificado_estado', 'certificado_observaciones']);
        });
    }
};
