<?php

namespace App\Http\Controllers;

use App\Models\Planing;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OpsController extends Controller
{
    public function listeEtudiants(Request $request)
    {
        $date = $request->query('date');
        $salle = $request->query('salle');
        $horaire = $request->query('horaire');
        $site = $request->query('site');

        $hasAnyFilter = $request->hasAny(['date', 'horaire', 'site', 'salle']);
        if (!$hasAnyFilter) {
            $date = '2026-03-24';
            $horaire = '09:00:00';
            $site = 'siège';
        }

        $perPage = 20;

        $query = Planing::query();

        if (is_string($date) && $date !== '') {
            $query->whereDate('date', $date);
        }

        if (is_string($salle) && $salle !== '') {
            $query->where('salle', $salle);
        }

        if (is_string($horaire) && $horaire !== '') {
            $query->where('horaire', $horaire);
        }

        if (is_string($site) && $site !== '') {
            $query->where('site', $site);
        }

        $groups = $query
            ->select(['date', 'horaire', 'salle', 'site'])
            ->whereNotNull('date')
            ->whereNotNull('horaire')
            ->whereNotNull('salle')
            ->distinct()
            ->orderBy('date')
            ->orderBy('salle')
            ->orderBy('horaire')
            ->get();

        $availableDates = Planing::query()->select('date')->distinct()->orderBy('date')->pluck('date');

        $salleQuery = Planing::query();
        if (is_string($date) && $date !== '') {
            $salleQuery->whereDate('date', $date);
        }
        if (is_string($horaire) && $horaire !== '') {
            $salleQuery->where('horaire', $horaire);
        }
        if (is_string($site) && $site !== '') {
            $salleQuery->where('site', $site);
        }
        $availableSalles = $salleQuery
            ->select('salle')
            ->whereNotNull('salle')
            ->distinct()
            ->orderBy('salle')
            ->pluck('salle');

        $horaireQuery = Planing::query();
        if (is_string($date) && $date !== '') {
            $horaireQuery->whereDate('date', $date);
        }
        if (is_string($site) && $site !== '') {
            $horaireQuery->where('site', $site);
        }
        if (is_string($salle) && $salle !== '') {
            $horaireQuery->where('salle', $salle);
        }
        $availableHoraires = $horaireQuery
            ->select('horaire')
            ->whereNotNull('horaire')
            ->distinct()
            ->orderBy('horaire')
            ->pluck('horaire');

        $siteQuery = Planing::query();
        if (is_string($date) && $date !== '') {
            $siteQuery->whereDate('date', $date);
        }
        $availableSites = $siteQuery
            ->select('site')
            ->whereNotNull('site')
            ->distinct()
            ->orderBy('site')
            ->pluck('site');

        return view('ops.liste-etudiants', [
            'groups' => $groups,
            'availableDates' => $availableDates,
            'availableSalles' => $availableSalles,
            'availableHoraires' => $availableHoraires,
            'availableSites' => $availableSites,
            'filters' => [
                'date' => $date,
                'salle' => $salle,
                'horaire' => $horaire,
                'site' => $site,
            ],
            'perPage' => $perPage,
        ]);
    }

    public function rechercheEtudiants(Request $request)
    {
        $apogee = $request->query('apogee');
        if (!is_string($apogee)) {
            $apogee = '';
        }
        $apogee = trim($apogee);

        if ($apogee === '') {
            return view('ops.recherche-etudiants');
        }

        $validated = Validator::make(['apogee' => $apogee], [
            'apogee' => ['required', 'string', 'max:50'],
        ])->validate();

        $apogee = trim((string) $validated['apogee']);

        $etudiant = Planing::query()
            ->where('cod_etu', $apogee)
            ->first();

        $examens = Planing::query()
            ->where('cod_etu', $apogee)
            ->orderBy('date')
            ->orderBy('horaire')
            ->get();

        return view('ops.recherche-etudiants', [
            'apogee' => $apogee,
            'etudiant' => $etudiant,
            'examens' => $etudiant === null ? null : $examens,
        ]);
    }

    public function rattrapageFiliere(Request $request)
    {
        $filiere = $request->query('filiere');
        $groupe = $request->query('groupe');

        $filiereQuery = Planing::query();
        $availableFilieres = $filiereQuery
            ->select('filiere')
            ->whereNotNull('filiere')
            ->distinct()
            ->orderBy('filiere')
            ->pluck('filiere');

        $groupeQuery = Planing::query();
        if (is_string($filiere) && $filiere !== '') {
            $groupeQuery->where('filiere', $filiere);
        }
        $availableGroupes = $groupeQuery
            ->select('cod_ext_gpe')
            ->whereNotNull('cod_ext_gpe')
            ->distinct()
            ->orderBy('cod_ext_gpe')
            ->pluck('cod_ext_gpe');

        return view('ops.rattrapage-filiere', [
            'availableFilieres' => $availableFilieres,
            'availableGroupes' => $availableGroupes,
            'filters' => [
                'filiere' => is_string($filiere) ? $filiere : '',
                'groupe' => is_string($groupe) ? $groupe : '',
            ],
        ]);
    }

    public function rattrapageFilierePdf(Request $request)
    {
        $validated = $request->validate([
            'filiere' => ['required', 'string', 'max:50'],
            'groupe' => ['required', 'string', 'max:50'],
        ]);

        $filiere = trim((string) $validated['filiere']);
        $groupe = trim((string) $validated['groupe']);

        $rows = Planing::query()
            ->where('filiere', $filiere)
            ->where('cod_ext_gpe', $groupe)
            ->select(['module', 'prof', 'date', 'horaire', 'site'])
            ->whereNotNull('module')
            ->whereNotNull('prof')
            ->whereNotNull('date')
            ->whereNotNull('horaire')
            ->orderBy('module')
            ->orderBy('date')
            ->orderBy('horaire')
            ->get();

        abort_if($rows->count() === 0, 404);

        $pdf = Pdf::loadView('pdf.rattrapage-filiere', [
            'filiere' => $filiere,
            'groupe' => $groupe,
            'rows' => $rows,
        ])->setPaper('a4', 'portrait');

        $safeFiliere = preg_replace('/[^A-Za-z0-9._-]+/', '-', $filiere) ?? 'filiere';
        $safeGroupe = preg_replace('/[^A-Za-z0-9._-]+/', '-', $groupe) ?? 'groupe';
        $filename = 'rattrapage_'.$safeFiliere.'_'.$safeGroupe.'.pdf';

        return $pdf->download($filename);
    }

    public function rattrapageFilierePdfsZip(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'filiere' => ['required', 'string', 'max:50'],
            'groupes' => ['required', 'array', 'min:1', 'max:200'],
            'groupes.*' => ['required', 'string', 'max:50'],
        ])->validate();

        $filiere = trim((string) $validated['filiere']);
        $groupes = array_values(array_unique(array_map(fn ($g) => trim((string) $g), $validated['groupes'])));
        $groupes = array_values(array_filter($groupes, fn ($g) => $g !== ''));

        if (count($groupes) === 0) {
            abort(422);
        }

        $zip = new \ZipArchive();
        $tmpFile = tempnam(sys_get_temp_dir(), 'ratt_zip_');
        if ($tmpFile === false) {
            abort(500);
        }

        $opened = $zip->open($tmpFile, \ZipArchive::OVERWRITE);
        if ($opened !== true) {
            abort(500);
        }

        foreach ($groupes as $groupe) {
            $rows = Planing::query()
                ->where('filiere', $filiere)
                ->where('cod_ext_gpe', $groupe)
                ->select(['module', 'prof', 'date', 'horaire', 'site'])
                ->whereNotNull('module')
                ->whereNotNull('prof')
                ->whereNotNull('date')
                ->whereNotNull('horaire')
                ->orderBy('module')
                ->orderBy('date')
                ->orderBy('horaire')
                ->get();

            if ($rows->count() === 0) {
                continue;
            }

            $pdfContent = Pdf::loadView('pdf.rattrapage-filiere', [
                'filiere' => $filiere,
                'groupe' => $groupe,
                'rows' => $rows,
            ])->setPaper('a4', 'portrait')->output();

            $safeFiliere = preg_replace('/[^A-Za-z0-9._-]+/', '-', $filiere) ?? 'filiere';
            $safeGroupe = preg_replace('/[^A-Za-z0-9._-]+/', '-', $groupe) ?? 'groupe';
            $filename = 'rattrapage_'.$safeFiliere.'_'.$safeGroupe.'.pdf';

            $zip->addFromString($filename, $pdfContent);
        }

        $zip->close();

        $safeFiliere = preg_replace('/[^A-Za-z0-9._-]+/', '-', $filiere) ?? 'filiere';
        $downloadName = 'rattrapage_'.$safeFiliere.'_groupes.zip';

        return response()->download($tmpFile, $downloadName, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }

    public function presencePdf(Request $request)
    {
        $validated = $request->validate([
            'date' => ['required', 'date'],
            'horaire' => ['required', 'string', 'max:20'],
            'salle' => ['required', 'string', 'max:50'],
        ]);

        $date = (string) $validated['date'];
        $horaire = (string) $validated['horaire'];
        $salle = (string) $validated['salle'];

        $examens = Planing::query()
            ->whereDate('date', $date)
            ->where('horaire', $horaire)
            ->where('salle', $salle)
            ->orderBy('salle')
            ->orderBy('horaire')
            ->orderBy('cod_etu')
            ->get();

        abort_if($examens->count() === 0, 404);

        $pdf = Pdf::loadView('pdf.presence-list', [
            'date' => $date,
            'horaire' => $horaire,
            'salle' => $salle,
            'examens' => $examens,
        ]);

        $safeHoraire = preg_replace('/[^A-Za-z0-9._-]+/', '-', $horaire) ?? 'horaire';
        $safeSalle = preg_replace('/[^A-Za-z0-9._-]+/', '-', $salle) ?? 'salle';
        $filename = 'presence_'.$date.'_'.$safeHoraire.'_'.$safeSalle.'.pdf';

        return $pdf->download($filename);
    }

    public function presencePdfsZip(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'groups' => ['required', 'array', 'min:1', 'max:200'],
            'groups.*.date' => ['required', 'date'],
            'groups.*.horaire' => ['required', 'string', 'max:20'],
            'groups.*.salle' => ['required', 'string', 'max:50'],
        ])->validate();

        $dates = array_values(array_unique(array_map(fn ($g) => (string) $g['date'], $validated['groups'])));
        $horaires = array_values(array_unique(array_map(fn ($g) => (string) $g['horaire'], $validated['groups'])));

        $site = null;
        $siteCandidates = Planing::query()
            ->where(function ($q) use ($validated) {
                foreach ($validated['groups'] as $g) {
                    $q->orWhere(function ($q2) use ($g) {
                        $q2->whereDate('date', (string) $g['date'])
                            ->where('horaire', (string) $g['horaire'])
                            ->where('salle', (string) $g['salle']);
                    });
                }
            })
            ->whereNotNull('site')
            ->select('site')
            ->distinct()
            ->pluck('site')
            ->values()
            ->all();

        if (count($siteCandidates) === 1) {
            $site = (string) $siteCandidates[0];
        }

        $zip = new \ZipArchive();
        $tmpFile = tempnam(sys_get_temp_dir(), 'presence_zip_');
        if ($tmpFile === false) {
            abort(500);
        }

        $opened = $zip->open($tmpFile, \ZipArchive::OVERWRITE);
        if ($opened !== true) {
            abort(500);
        }

        foreach ($validated['groups'] as $g) {
            $date = (string) $g['date'];
            $horaire = (string) $g['horaire'];
            $salle = (string) $g['salle'];

            $examens = Planing::query()
                ->whereDate('date', $date)
                ->where('horaire', $horaire)
                ->where('salle', $salle)
                ->orderBy('salle')
                ->orderBy('horaire')
                ->orderBy('cod_etu')
                ->get();

            if ($examens->count() === 0) {
                continue;
            }

            $pdfContent = Pdf::loadView('pdf.presence-list', [
                'date' => $date,
                'horaire' => $horaire,
                'salle' => $salle,
                'examens' => $examens,
            ])->output();

            $safeHoraire = preg_replace('/[^A-Za-z0-9._-]+/', '-', $horaire) ?? 'horaire';
            $safeSalle = preg_replace('/[^A-Za-z0-9._-]+/', '-', $salle) ?? 'salle';
            $filename = 'presence_'.$date.'_'.$safeHoraire.'_'.$safeSalle.'.pdf';

            $zip->addFromString($filename, $pdfContent);
        }

        $zip->close();

        $mmdd = 'multi';
        if (count($dates) === 1) {
            try {
                $mmdd = (new \DateTimeImmutable($dates[0]))->format('m-d');
            } catch (\Exception $e) {
                $mmdd = 'multi';
            }
        }

        $hhmm = 'multi';
        if (count($horaires) === 1) {
            $hhmm = str_replace(':', '-', substr($horaires[0], 0, 5));
        }

        $siteSlug = null;
        if (is_string($site) && $site !== '') {
            $siteSlug = strtolower(trim($site));
            $siteSlug = str_replace(['é', 'è', 'ê', 'ë', 'à', 'â', 'ä', 'î', 'ï', 'ô', 'ö', 'ù', 'û', 'ü', 'ç'], ['e', 'e', 'e', 'e', 'a', 'a', 'a', 'i', 'i', 'o', 'o', 'u', 'u', 'u', 'c'], $siteSlug);
            $siteSlug = preg_replace('/[^a-z0-9]+/', '-', $siteSlug) ?? '';
            $siteSlug = trim($siteSlug, '-');
            if ($siteSlug === '') {
                $siteSlug = null;
            }
        }

        $downloadName = 'presence_'.$mmdd.'_'.$hhmm.($siteSlug ? '_'.$siteSlug : '').'.zip';

        return response()->download($tmpFile, $downloadName, [
            'Content-Type' => 'application/zip',
        ])->deleteFileAfterSend(true);
    }
}
