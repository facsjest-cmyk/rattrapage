<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use App\Models\Examen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_search_form_loads(): void
    {
        $response = $this->get('/admin/recherche');

        $response->assertOk();
        $response->assertSee(__('messages.admin.search.heading'), false);
    }

    public function test_admin_search_requires_apogee(): void
    {
        $response = $this->from('/admin/recherche')->post('/admin/recherche', [
            'apogee' => '',
        ]);

        $response->assertRedirect('/admin/recherche');
        $response->assertSessionHasErrors(['apogee']);
    }

    public function test_admin_search_shows_student_and_examens(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A9000',
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

        $response = $this->post('/admin/recherche', [
            'apogee' => $etudiant->cod_etu,
        ]);

        $response->assertOk();
        $response->assertSee('Doe', false);
        $response->assertSee('Jane', false);
        $response->assertSee('A9000', false);
        $response->assertSee('INFO', false);
        $response->assertSee('Math', false);
        $response->assertSee('Campus', false);
    }

    public function test_admin_search_trims_apogee_input(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A9002',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'date_naissance' => '2001-02-03',
            'filiere' => 'INFO',
        ]);

        $response = $this->post('/admin/recherche', [
            'apogee' => '  '.$etudiant->cod_etu.'  ',
        ]);

        $response->assertOk();
        $response->assertSee('A9002', false);
    }

    public function test_admin_search_apogee_not_found_shows_message_and_keeps_value(): void
    {
        $response = $this->from('/admin/recherche')->post('/admin/recherche', [
            'apogee' => 'UNKNOWN',
        ]);

        $response->assertOk();
        $response->assertSee(__('messages.admin.search.not_found'), false);
        $response->assertSee('UNKNOWN', false);
    }

    public function test_admin_search_student_without_examens_shows_empty_state_and_keeps_student_info_visible(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A9001',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
        ]);

        $response = $this->post('/admin/recherche', [
            'apogee' => $etudiant->cod_etu,
        ]);

        $response->assertOk();
        $response->assertSee('Doe', false);
        $response->assertSee('John', false);
        $response->assertSee('A9001', false);
        $response->assertSee('INFO', false);
        $response->assertSee(__('messages.admin.search.no_examens'), false);
    }
}
