<?php

namespace App\Http\Controllers;

use App\Models\Planing;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class OpsController extends Controller
{
    public function listeEtudiants(Request $request)
    {
        $date = $request->query('date');
        $salle = $request->query('salle');

        $query = Planing::query();

        if (is_string($date) && $date !== '') {
            $query->whereDate('date', $date);
        }

        if (is_string($salle) && $salle !== '') {
            $query->where('salle', $salle);
        }

        $examens = $query
            ->orderBy('date')
            ->orderBy('salle')
            ->orderBy('horaire')
            ->orderBy('cod_etu')
            ->get();

        $availableDates = Planing::query()->select('date')->distinct()->orderBy('date')->pluck('date');
        $availableSalles = Planing::query()->select('salle')->whereNotNull('salle')->distinct()->orderBy('salle')->pluck('salle');

        return view('ops.liste-etudiants', [
            'examens' => $examens,
            'availableDates' => $availableDates,
            'availableSalles' => $availableSalles,
            'filters' => [
                'date' => $date,
                'salle' => $salle,
            ],
        ]);
    }

    public function exportPdfs(Request $request)
    {
        $date = $request->query('date');
        $salle = $request->query('salle');

        $query = Planing::query();

        if (is_string($date) && $date !== '') {
            $query->whereDate('date', $date);
        }

        if (is_string($salle) && $salle !== '') {
            $query->where('salle', $salle);
        }

        $groups = $query
            ->select(['date', 'horaire', 'salle'])
            ->whereNotNull('date')
            ->whereNotNull('horaire')
            ->whereNotNull('salle')
            ->distinct()
            ->orderBy('date')
            ->orderBy('salle')
            ->orderBy('horaire')
            ->get();

        return view('ops.export-pdfs', [
            'groups' => $groups,
            'filters' => [
                'date' => $date,
                'salle' => $salle,
            ],
        ]);
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
}
