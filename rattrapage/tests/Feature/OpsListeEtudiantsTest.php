<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use App\Models\Examen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpsListeEtudiantsTest extends TestCase
{
    use RefreshDatabase;

    public function test_ops_list_page_loads(): void
    {
        $response = $this->get('/ops/liste-etudiants');

        $response->assertOk();
        $response->assertSee(__('messages.ops.list.heading'), false);
    }

    public function test_ops_list_filters_by_date(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'O1000',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'date_naissance' => '2001-02-03',
            'filiere' => 'INFO',
        ]);

        Examen::create([
            'cod_etu' => $etudiant->cod_etu,
            'module' => 'Math',
            'professeur' => 'Prof X',
            'semestre' => 'S1',
            'groupe' => 'G1',
            'date_examen' => '2026-03-01',
            'horaire' => '08:30:00',
            'salle' => 'A1',
            'site' => 'Campus',
        ]);

        Examen::create([
            'cod_etu' => $etudiant->cod_etu,
            'module' => 'Algo',
            'professeur' => 'Prof Y',
            'semestre' => 'S1',
            'groupe' => 'G1',
            'date_examen' => '2026-03-02',
            'horaire' => '10:00:00',
            'salle' => 'A1',
            'site' => 'Campus',
        ]);

        $response = $this->get('/ops/liste-etudiants?date=2026-03-01');

        $response->assertOk();
        $response->assertSee('Math', false);
        $response->assertDontSee('Algo', false);
    }

    public function test_ops_list_filters_by_salle(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'O2000',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
        ]);

        Examen::create([
            'cod_etu' => $etudiant->cod_etu,
            'module' => 'Math',
            'professeur' => 'Prof X',
            'semestre' => 'S1',
            'groupe' => 'G1',
            'date_examen' => '2026-03-01',
            'horaire' => '08:30:00',
            'salle' => 'A1',
            'site' => 'Campus',
        ]);

        Examen::create([
            'cod_etu' => $etudiant->cod_etu,
            'module' => 'Algo',
            'professeur' => 'Prof Y',
            'semestre' => 'S1',
            'groupe' => 'G1',
            'date_examen' => '2026-03-01',
            'horaire' => '10:00:00',
            'salle' => 'B2',
            'site' => 'Campus',
        ]);

        $response = $this->get('/ops/liste-etudiants?salle=B2');

        $response->assertOk();
        $response->assertSee('Algo', false);
        $response->assertDontSee('Math', false);
    }
}
