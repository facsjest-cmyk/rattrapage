<?php

namespace App\Http\Controllers;

use App\Models\Planing;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function showRecherche(Request $request)
    {
        return view('admin.recherche');
    }

    public function search(Request $request)
    {
        $validated = $request->validate([
            'apogee' => ['required', 'string', 'max:50'],
        ]);

        $apogee = trim((string) $validated['apogee']);

        $etudiant = Planing::query()
            ->where('cod_etu', $apogee)
            ->first();

        $examens = Planing::query()
            ->where('cod_etu', $apogee)
            ->orderBy('date')
            ->orderBy('horaire')
            ->get();

        return view('admin.recherche', [
            'apogee' => $apogee,
            'etudiant' => $etudiant,
            'examens' => $etudiant === null ? null : $examens,
        ]);
    }
}
