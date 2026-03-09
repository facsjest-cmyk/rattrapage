<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use App\Models\Examen;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConvocationPdfTest extends TestCase
{
    use RefreshDatabase;

    public function test_pdf_endpoint_requires_authentication(): void
    {
        $response = $this->get('/convocation/pdf');

        $response->assertRedirect('/');
        $response->assertSessionHas('auth_message');
    }

    public function test_pdf_endpoint_returns_pdf_when_authenticated(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A3000',
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

        $response = $this->withSession(['cod_etu' => $etudiant->cod_etu])->get('/convocation/pdf');

        $response->assertOk();
        $response->assertHeaderContains('content-type', 'application/pdf');
        $response->assertHeaderContains('content-disposition', 'inline');
        $response->assertHeaderContains('content-disposition', 'convocation_rattrapage_'.$etudiant->cod_etu.'.pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_pdf_endpoint_in_arabic_still_returns_pdf(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A3001',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'date_naissance' => '2001-02-03',
            'filiere' => 'INFO',
        ]);

        $response = $this->withSession([
            'cod_etu' => $etudiant->cod_etu,
            'locale' => 'ar',
        ])->get('/convocation/pdf');

        $response->assertOk();
        $response->assertHeaderContains('content-type', 'application/pdf');
        $response->assertHeaderContains('content-disposition', 'inline');
        $response->assertHeaderContains('content-disposition', 'convocation_rattrapage_'.$etudiant->cod_etu.'.pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_pdf_download_sets_attachment_and_filename(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A3002',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
        ]);

        $response = $this->withSession(['cod_etu' => $etudiant->cod_etu])->get('/convocation/pdf?download=1');

        $response->assertOk();
        $response->assertHeaderContains('content-type', 'application/pdf');
        $response->assertHeaderContains('content-disposition', 'attachment');
        $response->assertHeaderContains('content-disposition', 'convocation_rattrapage_'.$etudiant->cod_etu.'.pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_pdf_generation_failure_sets_flash_message_and_redirects(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'A3003',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
        ]);

        Pdf::shouldReceive('loadView')->once()->andThrow(new \Exception('fail'));

        $response = $this->withSession(['cod_etu' => $etudiant->cod_etu])->get('/convocation/pdf');

        $response->assertRedirect('/convocation');
        $response->assertSessionHas('pdf_error', __('messages.convocation.pdf.error'));
    }
}
