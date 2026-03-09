<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use App\Models\Examen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConvocationPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_convocation_shows_student_info_and_examens(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A1000',
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

        $response = $this->withSession(['cod_etu' => $etudiant->cod_etu])->get('/convocation');

        $response->assertOk();
        $response->assertSee('Doe', false);
        $response->assertSee('John', false);
        $response->assertSee('A1000', false);
        $response->assertSee('INFO', false);

        $response->assertSee('Math', false);
        $response->assertSee('Prof X', false);
        $response->assertSee('S1', false);
        $response->assertSee('G1', false);
        $response->assertSee('A1', false);
        $response->assertSee('Campus', false);

        $response->assertSee(__('messages.convocation.pdf.open'), false);
        $response->assertSee(__('messages.convocation.pdf.download'), false);
    }

    public function test_convocation_empty_state_when_no_examens(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A2000',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'date_naissance' => '2001-02-03',
            'filiere' => 'INFO',
        ]);

        $response = $this->withSession(['cod_etu' => $etudiant->cod_etu])->get('/convocation');

        $response->assertOk();
        $response->assertSee(__('messages.convocation.empty_state'), false);
    }

    public function test_convocation_with_invalid_session_student_redirects_to_login(): void
    {
        $response = $this->withSession(['cod_etu' => 'UNKNOWN'])->get('/convocation');

        $response->assertRedirect('/');
        $response->assertSessionHas('auth_message', __('messages.auth.session_expired'));
    }
}
