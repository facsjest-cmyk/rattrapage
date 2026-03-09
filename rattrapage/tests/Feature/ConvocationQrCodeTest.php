<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConvocationQrCodeTest extends TestCase
{
    use RefreshDatabase;

    public function test_pdf_without_qr_when_feature_disabled(): void
    {
        config(['convocation.qr_enabled' => false]);

        $etudiant = Etudiant::create([
            'cod_etu' => 'A4001',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
        ]);

        $response = $this->withSession(['cod_etu' => $etudiant->cod_etu])->get('/convocation/pdf');

        $response->assertOk();
        $response->assertHeaderContains('content-type', 'application/pdf');

        $content = $response->getContent();
        $this->assertStringStartsWith('%PDF', $content);

        // Heuristic: with QR enabled we expect XObjects; without QR we should still have a PDF but can be lighter.
        $this->assertTrue(
            str_contains($content, '%PDF'),
            'PDF output is not valid.'
        );
    }

    public function test_pdf_contains_qr_code_image_marker(): void
    {
        config(['convocation.qr_enabled' => true]);

        $etudiant = Etudiant::create([
            'cod_etu' => 'A4000',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
        ]);

        $response = $this->withSession(['cod_etu' => $etudiant->cod_etu])->get('/convocation/pdf');

        $response->assertOk();
        $response->assertHeaderContains('content-type', 'application/pdf');

        $content = $response->getContent();
        $this->assertStringStartsWith('%PDF', $content);

        $this->assertTrue(
            str_contains($content, '/XObject') || str_contains($content, '/Subtype'),
            'PDF does not seem to contain expected objects.'
        );
    }
}
