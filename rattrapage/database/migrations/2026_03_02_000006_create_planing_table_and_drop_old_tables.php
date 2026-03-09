<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('planing', function (Blueprint $table) {
            $table->id();

            $table->string('cod_etu');

            $table->string('lib_nom_pat_ind')->nullable();
            $table->date('date_nai_ind')->nullable();
            $table->string('lib_pr1_ind')->nullable();

            $table->string('cod_elp')->nullable();
            $table->string('filiere')->nullable();
            $table->string('cod_tre')->nullable();

            $table->string('cod_ext_gpe')->nullable();
            $table->string('mod_groupe')->nullable();

            $table->string('prof')->nullable();
            $table->string('module')->nullable();

            $table->string('salle')->nullable();
            $table->string('site')->nullable();

            $table->date('date')->nullable();
            $table->time('horaire')->nullable();

            $table->timestamps();

            $table->index('cod_etu');
            $table->index('date');
            $table->index('salle');

            $table->unique(['cod_etu', 'mod_groupe', 'cod_tre'], 'planing_unique_cod_etu_mod_groupe_cod_tre');
        });

        if (Schema::hasTable('etudiants') && Schema::hasTable('examens')) {
            DB::table('planing')->insertUsing(
                [
                    'cod_etu',
                    'lib_nom_pat_ind',
                    'date_nai_ind',
                    'lib_pr1_ind',
                    'cod_elp',
                    'filiere',
                    'cod_tre',
                    'cod_ext_gpe',
                    'prof',
                    'module',
                    'mod_groupe',
                    'salle',
                    'site',
                    'date',
                    'horaire',
                    'created_at',
                    'updated_at',
                ],
                DB::table('examens')
                    ->join('etudiants', 'examens.cod_etu', '=', 'etudiants.cod_etu')
                    ->select([
                        'examens.cod_etu',
                        DB::raw('etudiants.nom as lib_nom_pat_ind'),
                        DB::raw('etudiants.date_naissance as date_nai_ind'),
                        DB::raw('etudiants.prenom as lib_pr1_ind'),
                        DB::raw('examens.semestre as cod_elp'),
                        DB::raw('etudiants.filiere as filiere'),
                        DB::raw("'RATT' as cod_tre"),
                        DB::raw('examens.groupe as cod_ext_gpe'),
                        DB::raw('examens.professeur as prof'),
                        DB::raw('examens.module as module'),
                        DB::raw("CONCAT(examens.module, '|', examens.groupe) as mod_groupe"),
                        DB::raw('examens.salle as salle'),
                        DB::raw('examens.site as site'),
                        DB::raw('examens.date_examen as date'),
                        DB::raw('examens.horaire as horaire'),
                        DB::raw('CURRENT_TIMESTAMP as created_at'),
                        DB::raw('CURRENT_TIMESTAMP as updated_at'),
                    ])
            );
        }

        if (Schema::hasTable('examens')) {
            Schema::drop('examens');
        }

        if (Schema::hasTable('etudiants')) {
            Schema::drop('etudiants');
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('planing')) {
            Schema::drop('planing');
        }

        Schema::create('etudiants', function (Blueprint $table) {
            $table->string('cod_etu')->primary();
            $table->string('nom');
            $table->string('prenom');
            $table->date('date_naissance');
            $table->string('filiere');
            $table->timestamps();
        });

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

            $table->unique(
                ['cod_etu', 'module', 'date_examen', 'horaire', 'salle'],
                'examens_unique_cod_module_date_horaire_salle'
            );
        });
    }
};
