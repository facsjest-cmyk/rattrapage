<?php

namespace Tests\Feature;

use App\Models\Etudiant;
use App\Models\Examen;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class OpsImportSqlCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_ops_import_sql_imports_data(): void
    {
        $etudiantsSql = "INSERT INTO etudiants (cod_etu, nom, prenom, date_naissance, filiere, created_at, updated_at) VALUES\n".
            "('IM1000', 'Doe', 'Jane', '2001-02-03', 'INFO', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $examensSql = "INSERT INTO examens (cod_etu, module, professeur, semestre, groupe, date_examen, horaire, salle, site, created_at, updated_at) VALUES\n".
            "('IM1000', 'Math', 'Prof X', 'S1', 'G1', '2026-03-01', '08:30:00', 'A1', 'Campus', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $etudiantsPath = tempnam(sys_get_temp_dir(), 'etu_');
        $examensPath = tempnam(sys_get_temp_dir(), 'exa_');

        file_put_contents($etudiantsPath, $etudiantsSql);
        file_put_contents($examensPath, $examensSql);

        $exitCode = Artisan::call('ops:import-sql', [
            '--etudiants' => $etudiantsPath,
            '--examens' => $examensPath,
        ]);

        @unlink($etudiantsPath);
        @unlink($examensPath);

        $this->assertSame(0, $exitCode);
        $this->assertDatabaseHas('etudiants', ['cod_etu' => 'IM1000']);
        $this->assertDatabaseHas('examens', ['cod_etu' => 'IM1000', 'module' => 'Math']);
    }

    public function test_ops_import_sql_fails_when_examens_fk_missing(): void
    {
        $etudiantsSql = "INSERT INTO etudiants (cod_etu, nom, prenom, date_naissance, filiere, created_at, updated_at) VALUES\n".
            "('IM2000', 'Doe', 'John', '2000-03-07', 'INFO', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $examensSql = "INSERT INTO examens (cod_etu, module, professeur, semestre, groupe, date_examen, horaire, salle, site, created_at, updated_at) VALUES\n".
            "('MISSING', 'Algo', 'Prof Y', 'S1', 'G1', '2026-03-01', '10:00:00', 'B2', 'Campus', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $etudiantsPath = tempnam(sys_get_temp_dir(), 'etu_');
        $examensPath = tempnam(sys_get_temp_dir(), 'exa_');

        file_put_contents($etudiantsPath, $etudiantsSql);
        file_put_contents($examensPath, $examensSql);

        $exitCode = Artisan::call('ops:import-sql', [
            '--etudiants' => $etudiantsPath,
            '--examens' => $examensPath,
        ]);

        @unlink($etudiantsPath);
        @unlink($examensPath);

        $this->assertNotSame(0, $exitCode);

        $this->assertSame(0, Etudiant::query()->count());
        $this->assertSame(0, Examen::query()->count());
    }

    public function test_ops_import_sql_fails_when_examens_cod_etu_empty(): void
    {
        $etudiantsSql = "INSERT INTO etudiants (cod_etu, nom, prenom, date_naissance, filiere, created_at, updated_at) VALUES\n".
            "('IM3000', 'Doe', 'Jane', '2001-02-03', 'INFO', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $examensSql = "INSERT INTO examens (cod_etu, module, professeur, semestre, groupe, date_examen, horaire, salle, site, created_at, updated_at) VALUES\n".
            "('', 'Math', 'Prof X', 'S1', 'G1', '2026-03-01', '08:30:00', 'A1', 'Campus', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $etudiantsPath = tempnam(sys_get_temp_dir(), 'etu_');
        $examensPath = tempnam(sys_get_temp_dir(), 'exa_');

        file_put_contents($etudiantsPath, $etudiantsSql);
        file_put_contents($examensPath, $examensSql);

        $exitCode = Artisan::call('ops:import-sql', [
            '--etudiants' => $etudiantsPath,
            '--examens' => $examensPath,
        ]);

        @unlink($etudiantsPath);
        @unlink($examensPath);

        $this->assertNotSame(0, $exitCode);
        $this->assertSame(0, Etudiant::query()->count());
        $this->assertSame(0, Examen::query()->count());
    }

    public function test_ops_import_sql_fails_on_duplicate_examens(): void
    {
        $etudiantsSql = "INSERT INTO etudiants (cod_etu, nom, prenom, date_naissance, filiere, created_at, updated_at) VALUES\n".
            "('IM4000', 'Doe', 'John', '2000-03-07', 'INFO', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $examensSql = "INSERT INTO examens (cod_etu, module, professeur, semestre, groupe, date_examen, horaire, salle, site, created_at, updated_at) VALUES\n".
            "('IM4000', 'Algo', 'Prof Y', 'S1', 'G1', '2026-03-01', '10:00:00', 'B2', 'Campus', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP),\n".
            "('IM4000', 'Algo', 'Prof Y', 'S1', 'G1', '2026-03-01', '10:00:00', 'B2', 'Campus', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP);";

        $etudiantsPath = tempnam(sys_get_temp_dir(), 'etu_');
        $examensPath = tempnam(sys_get_temp_dir(), 'exa_');

        file_put_contents($etudiantsPath, $etudiantsSql);
        file_put_contents($examensPath, $examensSql);

        $exitCode = Artisan::call('ops:import-sql', [
            '--etudiants' => $etudiantsPath,
            '--examens' => $examensPath,
        ]);

        @unlink($etudiantsPath);
        @unlink($examensPath);

        $this->assertNotSame(0, $exitCode);
        $this->assertSame(0, Etudiant::query()->count());
        $this->assertSame(0, Examen::query()->count());
    }
}
