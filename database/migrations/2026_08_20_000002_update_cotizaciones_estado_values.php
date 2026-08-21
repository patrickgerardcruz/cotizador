<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('cotizaciones')
            ->whereIn('estado', ['aceptada', 'aprobada', 'aprobado'])
            ->update(['estado' => 'entregado']);

        DB::table('cotizaciones')
            ->whereIn('estado', ['rechazada', 'rechazado', 'vencida'])
            ->update(['estado' => 'pendiente']);

        DB::statement("ALTER TABLE cotizaciones MODIFY estado ENUM('pendiente', 'en proceso', 'entregado') NOT NULL DEFAULT 'pendiente'");
    }

    public function down(): void
    {
        DB::table('cotizaciones')
            ->where('estado', 'entregado')
            ->update(['estado' => 'aceptada']);

        DB::table('cotizaciones')
            ->where('estado', 'en proceso')
            ->update(['estado' => 'pendiente']);

        DB::statement("ALTER TABLE cotizaciones MODIFY estado ENUM('pendiente', 'aceptada', 'rechazada', 'vencida') NOT NULL DEFAULT 'pendiente'");
    }
};
