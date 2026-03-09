<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('examens', function (Blueprint $table) {
            $table->id();

            $table->string('cod_etu');

            $table->string('module');
            $table->string('professeur');
            $table->string('semestre');
            $table->string('groupe');

            $table->date('date_examen');
            $table->time('horaire');

            $table->string('salle');
            $table->string('site');

            $table->timestamps();

            $table->foreign('cod_etu')
                ->references('cod_etu')
                ->on('etudiants')
                ->cascadeOnDelete();

            $table->index('cod_etu');
            $table->index('date_examen');
            $table->index('salle');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('examens');
    }
};
