<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use App\Models\Examen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OpsExportPdfsTest extends TestCase
{
    use RefreshDatabase;

    public function test_export_page_lists_groups_as_links(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'E7000',
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

        $response = $this->get('/ops/export-pdfs');

        $response->assertOk();
        $response->assertSee('/ops/presence-pdf', false);
        $response->assertSee('2026-03-01', false);
        $response->assertSee('08:30:00', false);
        $response->assertSee('A1', false);
    }

    public function test_presence_pdf_downloads_a_pdf_for_group(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'E7001',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-03-07',
            'filiere' => 'INFO',
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

        $response = $this->get('/ops/presence-pdf?date=2026-03-01&horaire=10:00:00&salle=B2');

        $response->assertOk();
        $response->assertHeaderContains('content-type', 'application/pdf');
        $response->assertHeaderContains('content-disposition', 'attachment');
        $this->assertStringStartsWith('%PDF', $response->getContent());
    }

    public function test_presence_pdf_with_many_rows_still_generates(): void
    {
        $date = '2026-03-03';
        $horaire = '14:00:00';
        $salle = 'C3';

        for ($i = 1; $i <= 90; $i++) {
            $cod = 'E8'.str_pad((string) $i, 3, '0', STR_PAD_LEFT);

            $etudiant = Etudiant::create([
                'cod_etu' => $cod,
                'nom' => 'Nom'.$i,
                'prenom' => 'Prenom'.$i,
                'date_naissance' => '2000-01-01',
                'filiere' => 'INFO',
            ]);

            Examen::create([
                'cod_etu' => $etudiant->cod_etu,
                'module' => 'Module'.$i,
                'professeur' => 'Prof',
                'semestre' => 'S1',
                'groupe' => 'G1',
                'date_examen' => $date,
                'horaire' => $horaire,
                'salle' => $salle,
                'site' => 'Campus',
            ]);
        }

        $response = $this->get('/ops/presence-pdf?date='.$date.'&horaire='.$horaire.'&salle='.$salle);

        $response->assertOk();
        $response->assertHeaderContains('content-type', 'application/pdf');
        $this->assertStringStartsWith('%PDF', $response->getContent());
        $this->assertGreaterThan(20000, strlen($response->getContent()));
    }
}
