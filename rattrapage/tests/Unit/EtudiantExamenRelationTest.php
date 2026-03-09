<?php

namespace Tests\Unit;

use App\Models\Etudiant;
use App\Models\Examen;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EtudiantExamenRelationTest extends TestCase
{
    use RefreshDatabase;

    public function test_schema_has_expected_columns(): void
    {
        $this->assertTrue(Schema::hasTable('etudiants'));
        $this->assertTrue(Schema::hasColumns('etudiants', [
            'cod_etu',
            'nom',
            'prenom',
            'date_naissance',
            'filiere',
        ]));

        $this->assertTrue(Schema::hasTable('examens'));
        $this->assertTrue(Schema::hasColumns('examens', [
            'id',
            'cod_etu',
            'module',
            'professeur',
            'semestre',
            'groupe',
            'date_examen',
            'horaire',
            'salle',
            'site',
        ]));
    }

    public function test_etudiant_has_many_examens(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'E001',
            'nom' => 'Doe',
            'prenom' => 'John',
            'date_naissance' => '2000-01-01',
            'filiere' => 'INFO',
        ]);

        Examen::create([
            'cod_etu' => $etudiant->cod_etu,
            'module' => 'ALG',
            'professeur' => 'Prof A',
            'semestre' => 'S1',
            'groupe' => 'G1',
            'date_examen' => '2026-02-26',
            'horaire' => '08:00:00',
            'salle' => 'A1',
            'site' => 'Campus',
        ]);

        $this->assertCount(1, $etudiant->examens);
        $this->assertSame('ALG', $etudiant->examens->first()->module);
    }

    public function test_foreign_key_prevents_orphan_examen(): void
    {
        DB::statement('PRAGMA foreign_keys=ON');

        $this->expectException(QueryException::class);

        Examen::create([
            'cod_etu' => 'NOT_EXISTS',
            'module' => 'ALG',
            'professeur' => 'Prof A',
            'semestre' => 'S1',
            'groupe' => 'G1',
            'date_examen' => '2026-02-26',
            'horaire' => '08:00:00',
            'salle' => 'A1',
            'site' => 'Campus',
        ]);
    }

    public function test_cascade_delete_removes_examens_when_etudiant_deleted(): void
    {
        DB::statement('PRAGMA foreign_keys=ON');

        $etudiant = Etudiant::create([
            'cod_etu' => 'E003',
            'nom' => 'Doe',
            'prenom' => 'Jack',
            'date_naissance' => '1999-05-05',
            'filiere' => 'INFO',
        ]);

        Examen::create([
            'cod_etu' => $etudiant->cod_etu,
            'module' => 'SYS',
            'professeur' => 'Prof C',
            'semestre' => 'S1',
            'groupe' => 'G1',
            'date_examen' => '2026-04-01',
            'horaire' => '14:00:00',
            'salle' => 'C3',
            'site' => 'Campus',
        ]);

        $this->assertDatabaseCount('examens', 1);

        $etudiant->delete();

        $this->assertDatabaseCount('examens', 0);
    }

    public function test_examen_belongs_to_etudiant(): void
    {
        $etudiant = Etudiant::create([
            'cod_etu' => 'E002',
            'nom' => 'Doe',
            'prenom' => 'Jane',
            'date_naissance' => '2001-02-03',
            'filiere' => 'INFO',
        ]);

        $examen = Examen::create([
            'cod_etu' => $etudiant->cod_etu,
            'module' => 'BDD',
            'professeur' => 'Prof B',
            'semestre' => 'S2',
            'groupe' => 'G2',
            'date_examen' => '2026-03-01',
            'horaire' => '10:30:00',
            'salle' => 'B2',
            'site' => 'Campus',
        ]);

        $this->assertNotNull($examen->etudiant);
        $this->assertSame('E002', $examen->etudiant->cod_etu);
    }
}
