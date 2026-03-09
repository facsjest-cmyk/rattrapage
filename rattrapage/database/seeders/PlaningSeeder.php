<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlaningSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        DB::table('planing')->insert([
            [
                'cod_etu' => 'IM1000',
                'lib_nom_pat_ind' => 'DOE',
                'date_nai_ind' => '2001-02-03',
                'lib_pr1_ind' => 'JANE',
                'cod_elp' => 'S1',
                'filiere' => 'INFO',
                'cod_tre' => 'RATT',
                'cod_ext_gpe' => 'G1',
                'mod_groupe' => 'ALG|G1',
                'prof' => 'Prof A',
                'module' => 'ALG',
                'salle' => 'A1',
                'site' => 'Campus',
                'date' => '2026-03-10',
                'horaire' => '08:30:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'cod_etu' => 'IM1000',
                'lib_nom_pat_ind' => 'DOE',
                'date_nai_ind' => '2001-02-03',
                'lib_pr1_ind' => 'JANE',
                'cod_elp' => 'S1',
                'filiere' => 'INFO',
                'cod_tre' => 'RATT',
                'cod_ext_gpe' => 'G2',
                'mod_groupe' => 'BDD|G2',
                'prof' => 'Prof B',
                'module' => 'BDD',
                'salle' => 'B2',
                'site' => 'Campus',
                'date' => '2026-03-11',
                'horaire' => '10:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'cod_etu' => 'IM2000',
                'lib_nom_pat_ind' => 'SMITH',
                'date_nai_ind' => '2000-03-07',
                'lib_pr1_ind' => 'JOHN',
                'cod_elp' => 'S2',
                'filiere' => 'INFO',
                'cod_tre' => 'RATT',
                'cod_ext_gpe' => 'G1',
                'mod_groupe' => 'SYS|G1',
                'prof' => 'Prof C',
                'module' => 'SYS',
                'salle' => 'C3',
                'site' => 'Campus',
                'date' => '2026-03-10',
                'horaire' => '14:00:00',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
