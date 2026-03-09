<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->unique(
                ['cod_etu', 'module', 'date_examen', 'horaire', 'salle'],
                'examens_unique_cod_module_date_horaire_salle'
            );
        });
    }

    public function down(): void
    {
        Schema::table('examens', function (Blueprint $table) {
            $table->dropUnique('examens_unique_cod_module_date_horaire_salle');
        });
    }
};
