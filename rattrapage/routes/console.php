<?php

use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('ops:import-sql {--planing=} {--etudiants=} {--examens=} {--report=}', function () {
    $planingPath = (string) ($this->option('planing') ?? '');
    $etudiantsPath = (string) ($this->option('etudiants') ?? '');
    $examensPath = (string) ($this->option('examens') ?? '');

    $reportPath = (string) ($this->option('report') ?? '');
    if ($reportPath === '') {
        $reportPath = storage_path('logs/import-report-'.now()->format('Ymd-His').'-'.Str::random(6).'.txt');
    }

    if ($planingPath === '') {
        $this->error('Missing required option: --planing');
        return 2;
    }

    if (!File::exists($planingPath)) {
        $this->error('Planing SQL file not found: '.$planingPath);
        return 2;
    }

    $planingSql = File::get($planingPath);

    try {
        DB::transaction(function () use ($planingSql, $reportPath): void {
            DB::unprepared($planingSql);

            $invalidCodEtuRows = DB::table('planing')
                ->select(['id', 'cod_etu', 'module', 'date', 'horaire', 'salle', 'mod_groupe', 'cod_tre'])
                ->whereNull('cod_etu')
                ->orWhere('cod_etu', '')
                ->limit(20)
                ->get();

            if ($invalidCodEtuRows->count() > 0) {
                $lines = [];
                $lines[] = 'Validation failed: examens.cod_etu is empty';
                $lines[] = 'Sample rows:';
                foreach ($invalidCodEtuRows as $r) {
                    $lines[] = json_encode($r, JSON_UNESCAPED_UNICODE);
                }
                File::put($reportPath, implode(PHP_EOL, $lines).PHP_EOL);
                throw new \RuntimeException('Validation failed: examens.cod_etu is empty');
            }

            $missingKeysRows = DB::table('planing')
                ->select(['id', 'cod_etu', 'module', 'date', 'horaire', 'salle', 'mod_groupe', 'cod_tre'])
                ->whereNull('mod_groupe')
                ->orWhere('mod_groupe', '')
                ->orWhereNull('cod_tre')
                ->orWhere('cod_tre', '')
                ->limit(20)
                ->get();

            if ($missingKeysRows->count() > 0) {
                $lines = [];
                $lines[] = 'Validation failed: planing.mod_groupe or planing.cod_tre is empty';
                $lines[] = 'Sample rows:';
                foreach ($missingKeysRows as $r) {
                    $lines[] = json_encode($r, JSON_UNESCAPED_UNICODE);
                }
                File::put($reportPath, implode(PHP_EOL, $lines).PHP_EOL);
                throw new \RuntimeException('Validation failed: planing.mod_groupe or planing.cod_tre is empty');
            }
        });
    } catch (QueryException $e) {
        File::put($reportPath, 'SQL import failed: '.$e->getMessage().PHP_EOL);
        $this->error('SQL import failed: '.$e->getMessage());
        $this->line('Report: '.$reportPath);
        return 1;
    } catch (\Throwable $e) {
        if (!File::exists($reportPath)) {
            File::put($reportPath, $e->getMessage().PHP_EOL);
        }
        $this->error($e->getMessage());
        $this->line('Report: '.$reportPath);
        return 1;
    }

    $this->info('Import OK');
    $this->line('planing: '.DB::table('planing')->count());
    $this->line('Report: '.$reportPath);

    return 0;
})->purpose('Import SQL file for planing with minimal validation');

Artisan::command('ops:import-csv {--planing=} {--report=} {--fresh}', function () {
    $planingPath = (string) ($this->option('planing') ?? '');

    $reportPath = (string) ($this->option('report') ?? '');
    if ($reportPath === '') {
        $reportPath = storage_path('logs/import-report-'.now()->format('Ymd-His').'-'.Str::random(6).'.txt');
    }

    $fresh = (bool) $this->option('fresh');

    if ($planingPath === '') {
        $this->error('Missing required option: --planing');
        return 2;
    }

    if (!File::exists($planingPath)) {
        $this->error('Planing CSV file not found: '.$planingPath);
        return 2;
    }

    $toUtf8 = static function ($value): ?string {
        if ($value === null) {
            return null;
        }

        $s = (string) $value;
        if ($s === '') {
            return '';
        }

        $s = str_replace("\0", '', $s);

        if (function_exists('mb_check_encoding') && mb_check_encoding($s, 'UTF-8')) {
            return $s;
        }

        if (function_exists('mb_convert_encoding')) {
            foreach (['Windows-1256', 'CP1256', 'Windows-1252', 'ISO-8859-1', 'UTF-16LE', 'UTF-16BE'] as $from) {
                $converted = @mb_convert_encoding($s, 'UTF-8', $from);
                if ($converted !== false && (!function_exists('mb_check_encoding') || mb_check_encoding($converted, 'UTF-8'))) {
                    return $converted;
                }
            }

            $converted = @mb_convert_encoding($s, 'UTF-8', 'Windows-1252');
            if ($converted !== false && (!function_exists('mb_check_encoding') || mb_check_encoding($converted, 'UTF-8'))) {
                return $converted;
            }

            $converted = @mb_convert_encoding($s, 'UTF-8', 'ISO-8859-1');
            if ($converted !== false && (!function_exists('mb_check_encoding') || mb_check_encoding($converted, 'UTF-8'))) {
                return $converted;
            }
        }

        return $s;
    };

    $excelSerialToDate = static function ($value): ?string {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        if (preg_match('/^\d{1,2}[\/\-]\d{1,2}[\/\-]\d{4}$/', $value) === 1) {
            $valueNorm = str_replace('-', '/', $value);

            try {
                return Carbon::createFromFormat('d/m/Y', $valueNorm)->toDateString();
            } catch (\Throwable) {
            }

            try {
                return Carbon::createFromFormat('m/d/Y', $valueNorm)->toDateString();
            } catch (\Throwable) {
            }
        }

        if (is_numeric($value)) {
            $days = (int) $value;
            if ($days <= 0) {
                return null;
            }
            return Carbon::create(1899, 12, 30)->addDays($days)->toDateString();
        }

        try {
            return Carbon::parse($value)->toDateString();
        } catch (\Throwable) {
            return null;
        }
    };

    $normalizeHoraire = static function ($value): ?string {
        if ($value === null) {
            return null;
        }

        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }

        $value = str_replace('H', 'h', $value);
        $value = str_replace('h', ':', $value);

        $firstPart = explode('-', $value)[0] ?? '';
        $firstPart = trim($firstPart);
        if ($firstPart === '') {
            return null;
        }

        if (preg_match('/^\d{1,2}:\d{2}(:\d{2})?$/', $firstPart) === 1) {
            if (str_contains($firstPart, ':') && substr_count($firstPart, ':') === 1) {
                return $firstPart.':00';
            }
            return $firstPart;
        }

        return $value;
    };

    $mapHeaderToColumn = static function (string $header): ?string {
        $header = trim($header);
        $header = preg_replace('/\xEF\xBB\xBF/', '', $header) ?? $header;

        return match ($header) {
            'COD_ETU' => 'cod_etu',
            'LIB_NOM_PAT_IND' => 'lib_nom_pat_ind',
            'DATE_NAI_IND' => 'date_nai_ind',
            'LIB_PR1_IND' => 'lib_pr1_ind',
            'COD_ELP' => 'cod_elp',
            'Filière', 'Filiere', 'FILIERE' => 'filiere',
            'COD_TRE' => 'cod_tre',
            'COD_EXT_GPE' => 'cod_ext_gpe',
            'mod_groupe', 'MOD_GROUPE' => 'mod_groupe',
            'prof', 'PROF' => 'prof',
            'module', 'MODULE' => 'module',
            'salle', 'SALLE' => 'salle',
            'NumExam', 'NUMEXAM', 'NUM_EXAM', 'num_exam' => 'num_exam',
            'site', 'SITE' => 'site',
            'date', 'DATE' => 'date',
            'horaire', 'HORAIRE' => 'horaire',
            default => null,
        };
    };

    $normalizeCodTre = static function ($value): ?string {
        if ($value === null) {
            return null;
        }
        $value = trim((string) $value);
        if ($value === '') {
            return null;
        }
        return match (strtoupper($value)) {
            'RAT' => 'RATT',
            default => strtoupper($value),
        };
    };

    $errors = [];
    $rowsProcessed = 0;
    $rowsUpserted = 0;

    try {
        if ($fresh) {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            DB::table('planing')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        DB::transaction(function () use ($planingPath, $reportPath, $excelSerialToDate, $normalizeHoraire, $mapHeaderToColumn, $normalizeCodTre, $toUtf8, &$errors, &$rowsProcessed, &$rowsUpserted): void {
            $handle = fopen($planingPath, 'r');
            if ($handle === false) {
                throw new \RuntimeException('Unable to open CSV file: '.$planingPath);
            }

            $header = fgetcsv($handle, 0, ';');
            if (!is_array($header) || count($header) === 0) {
                fclose($handle);
                throw new \RuntimeException('CSV header not found or invalid');
            }

            $columnIndexes = [];
            foreach ($header as $i => $h) {
                $col = $mapHeaderToColumn(trim((string) $toUtf8($h)));
                if ($col !== null) {
                    $columnIndexes[$col] = $i;
                }
            }

            foreach (['cod_etu', 'mod_groupe', 'cod_tre'] as $required) {
                if (!array_key_exists($required, $columnIndexes)) {
                    fclose($handle);
                    throw new \RuntimeException('Missing required CSV column: '.$required);
                }
            }

            $batch = [];
            $batchSize = 500;

            $line = 1;
            while (($data = fgetcsv($handle, 0, ';')) !== false) {
                $line++;
                if (!is_array($data) || (count($data) === 1 && trim((string) ($data[0] ?? '')) === '')) {
                    continue;
                }

                $row = [];
                foreach ($columnIndexes as $col => $idx) {
                    $row[$col] = $toUtf8($data[$idx] ?? null);
                }

                $codEtu = trim((string) ($row['cod_etu'] ?? ''));
                $modGroupe = trim((string) ($row['mod_groupe'] ?? ''));
                $codTre = $normalizeCodTre($row['cod_tre'] ?? null);

                if ($codEtu === '' || $modGroupe === '' || ($codTre === null || $codTre === '')) {
                    $errors[] = 'Line '.$line.': missing required key(s) cod_etu/mod_groupe/cod_tre';
                    continue;
                }

                $payload = [
                    'cod_etu' => $codEtu,
                    'lib_nom_pat_ind' => isset($row['lib_nom_pat_ind']) ? trim((string) $row['lib_nom_pat_ind']) : null,
                    'date_nai_ind' => isset($row['date_nai_ind']) ? $excelSerialToDate($row['date_nai_ind']) : null,
                    'lib_pr1_ind' => isset($row['lib_pr1_ind']) ? trim((string) $row['lib_pr1_ind']) : null,
                    'cod_elp' => isset($row['cod_elp']) ? trim((string) $row['cod_elp']) : null,
                    'filiere' => isset($row['filiere']) ? trim((string) $row['filiere']) : null,
                    'cod_tre' => $codTre,
                    'cod_ext_gpe' => isset($row['cod_ext_gpe']) ? trim((string) $row['cod_ext_gpe']) : null,
                    'mod_groupe' => $modGroupe,
                    'prof' => isset($row['prof']) ? trim((string) $row['prof']) : null,
                    'module' => isset($row['module']) ? trim((string) $row['module']) : null,
                    'salle' => isset($row['salle']) ? trim((string) $row['salle']) : null,
                    'num_exam' => isset($row['num_exam']) ? trim((string) $row['num_exam']) : null,
                    'site' => isset($row['site']) ? trim((string) $row['site']) : null,
                    'date' => isset($row['date']) ? $excelSerialToDate($row['date']) : null,
                    'horaire' => isset($row['horaire']) ? $normalizeHoraire($row['horaire']) : null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                $batch[] = $payload;
                $rowsProcessed++;

                if (count($batch) >= $batchSize) {
                    DB::table('planing')->upsert(
                        $batch,
                        ['cod_etu', 'mod_groupe', 'cod_tre'],
                        ['lib_nom_pat_ind', 'date_nai_ind', 'lib_pr1_ind', 'cod_elp', 'filiere', 'cod_ext_gpe', 'prof', 'module', 'salle', 'num_exam', 'site', 'date', 'horaire', 'updated_at']
                    );
                    $rowsUpserted += count($batch);
                    $batch = [];
                }
            }

            fclose($handle);

            if (count($batch) > 0) {
                DB::table('planing')->upsert(
                    $batch,
                    ['cod_etu', 'mod_groupe', 'cod_tre'],
                    ['lib_nom_pat_ind', 'date_nai_ind', 'lib_pr1_ind', 'cod_elp', 'filiere', 'cod_ext_gpe', 'prof', 'module', 'salle', 'num_exam', 'site', 'date', 'horaire', 'updated_at']
                );
                $rowsUpserted += count($batch);
            }

            if (count($errors) > 0) {
                File::put($reportPath, implode(PHP_EOL, $errors).PHP_EOL);
                throw new \RuntimeException('CSV import completed with errors');
            }

            $invalidCodEtuRows = DB::table('planing')
                ->select(['id', 'cod_etu', 'module', 'date', 'horaire', 'salle', 'mod_groupe', 'cod_tre'])
                ->whereNull('cod_etu')
                ->orWhere('cod_etu', '')
                ->limit(20)
                ->get();

            if ($invalidCodEtuRows->count() > 0) {
                $lines = [];
                $lines[] = 'Validation failed: planing.cod_etu is empty';
                $lines[] = 'Sample rows:';
                foreach ($invalidCodEtuRows as $r) {
                    $lines[] = json_encode($r, JSON_UNESCAPED_UNICODE);
                }
                File::put($reportPath, implode(PHP_EOL, $lines).PHP_EOL);
                throw new \RuntimeException('Validation failed: planing.cod_etu is empty');
            }

            $missingKeysRows = DB::table('planing')
                ->select(['id', 'cod_etu', 'module', 'date', 'horaire', 'salle', 'mod_groupe', 'cod_tre'])
                ->whereNull('mod_groupe')
                ->orWhere('mod_groupe', '')
                ->orWhereNull('cod_tre')
                ->orWhere('cod_tre', '')
                ->limit(20)
                ->get();

            if ($missingKeysRows->count() > 0) {
                $lines = [];
                $lines[] = 'Validation failed: planing.mod_groupe or planing.cod_tre is empty';
                $lines[] = 'Sample rows:';
                foreach ($missingKeysRows as $r) {
                    $lines[] = json_encode($r, JSON_UNESCAPED_UNICODE);
                }
                File::put($reportPath, implode(PHP_EOL, $lines).PHP_EOL);
                throw new \RuntimeException('Validation failed: planing.mod_groupe or planing.cod_tre is empty');
            }
        });
    } catch (QueryException $e) {
        File::put($reportPath, 'CSV import failed: '.$e->getMessage().PHP_EOL);
        $this->error('CSV import failed: '.$e->getMessage());
        $this->line('Report: '.$reportPath);
        return 1;
    } catch (\Throwable $e) {
        if (!File::exists($reportPath)) {
            File::put($reportPath, $e->getMessage().PHP_EOL);
        }
        $this->error($e->getMessage());
        $this->line('Report: '.$reportPath);
        return 1;
    }

    $this->info('Import OK');
    $this->line('Processed: '.$rowsProcessed);
    $this->line('Upserted: '.$rowsUpserted);
    $this->line('planing: '.DB::table('planing')->count());
    $this->line('Report: '.$reportPath);

    return 0;
})->purpose('Import CSV file (semicolon-separated) into planing with minimal validation');
