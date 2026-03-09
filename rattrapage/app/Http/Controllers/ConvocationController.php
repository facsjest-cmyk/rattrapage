<?php

namespace App\Http\Controllers;

use App\Models\Planing;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ConvocationController extends Controller
{
    public function show(Request $request)
    {
        $codEtu = (string) $request->session()->get('cod_etu');

        if ($codEtu === '') {
            return redirect('/')->with('auth_message', __('messages.auth.session_expired'));
        }

        $etudiant = Planing::query()
            ->where('cod_etu', $codEtu)
            ->first();

        if ($etudiant === null) {
            $request->session()->forget('cod_etu');

            return redirect('/')->with('auth_message', __('messages.auth.session_expired'));
        }

        $examens = Planing::query()
            ->where('cod_etu', $codEtu)
            ->orderBy('date')
            ->orderBy('horaire')
            ->get();

        return view('convocation', [
            'etudiant' => $etudiant,
            'examens' => $examens,
        ]);
    }

    public function pdf(Request $request)
    {
        $codEtu = (string) $request->session()->get('cod_etu');

        if ($codEtu === '') {
            return redirect('/')->with('auth_message', __('messages.auth.session_expired'));
        }

        $etudiant = Planing::query()
            ->where('cod_etu', $codEtu)
            ->first();

        if ($etudiant === null) {
            $request->session()->forget('cod_etu');

            return redirect('/')->with('auth_message', __('messages.auth.session_expired'));
        }

        $examens = Planing::query()
            ->where('cod_etu', $codEtu)
            ->orderBy('date')
            ->orderBy('horaire')
            ->get();

        try {
            $qrSvg = null;

            if ((bool) config('convocation.qr_enabled')) {
                $qrData = rtrim(strtr(base64_encode(json_encode([
                    'v' => 1,
                    'apogee' => $etudiant->cod_etu,
                    'iat' => time(),
                ], JSON_UNESCAPED_UNICODE)), '+/', '-_'), '=');

                $qrSig = hash_hmac('sha256', $qrData, (string) config('app.key'));

                $verifyUrl = URL::to('/verify').'?d='.$qrData.'&s='.$qrSig;

                $qrSvg = QrCode::format('svg')->size(140)->margin(1)->generate($verifyUrl);
            }

            $pdf = Pdf::loadView('pdf.convocation', [
                'etudiant' => $etudiant,
                'examens' => $examens,
                'qr_svg' => $qrSvg,
            ]);
        } catch (\Throwable $e) {
            return redirect('/convocation')->with('pdf_error', __('messages.convocation.pdf.error'));
        }

        $filename = 'convocation_rattrapage_'.$etudiant->cod_etu.'.pdf';

        if ($request->boolean('download')) {
            return $pdf->download($filename);
        }

        return $pdf->stream($filename);
    }

    public function verify(Request $request)
    {
        $qrData = (string) $request->query('d', '');
        $qrSig = (string) $request->query('s', '');

        if ($qrData === '' || $qrSig === '') {
            abort(404);
        }

        $expectedSig = hash_hmac('sha256', $qrData, (string) config('app.key'));

        if (!hash_equals($expectedSig, $qrSig)) {
            abort(403);
        }

        $decoded = base64_decode(strtr($qrData, '-_', '+/'));

        if ($decoded === false) {
            abort(404);
        }

        $payload = json_decode($decoded, true);

        if (!is_array($payload) || !isset($payload['apogee'])) {
            abort(404);
        }

        $codEtu = trim((string) $payload['apogee']);

        if ($codEtu === '') {
            abort(404);
        }

        $etudiant = Planing::query()
            ->where('cod_etu', $codEtu)
            ->first();

        if ($etudiant === null) {
            abort(404);
        }

        $examens = Planing::query()
            ->where('cod_etu', $codEtu)
            ->orderBy('date')
            ->orderBy('horaire')
            ->get();

        return view('verify', [
            'etudiant' => $etudiant,
            'examens' => $examens,
        ]);
    }

    public function markPresence(Request $request)
    {
        $apiKey = (string) $request->header('X-Prof-Key', '');

        if ($apiKey === '' || !hash_equals((string) config('convocation.prof_api_key'), $apiKey)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $qrData = (string) $request->input('d', '');
        $qrSig = (string) $request->input('s', '');

        if ($qrData === '' || $qrSig === '') {
            return response()->json(['message' => 'Invalid QR'], 422);
        }

        $expectedSig = hash_hmac('sha256', $qrData, (string) config('app.key'));

        if (!hash_equals($expectedSig, $qrSig)) {
            return response()->json(['message' => 'Invalid QR'], 403);
        }

        $decoded = base64_decode(strtr($qrData, '-_', '+/'));

        if ($decoded === false) {
            return response()->json(['message' => 'Invalid QR'], 422);
        }

        $payload = json_decode($decoded, true);

        if (!is_array($payload) || !isset($payload['apogee'])) {
            return response()->json(['message' => 'Invalid QR'], 422);
        }

        $codEtu = trim((string) $payload['apogee']);

        if ($codEtu === '') {
            return response()->json(['message' => 'Invalid QR'], 422);
        }

        $now = Carbon::now();
        $today = $now->toDateString();

        $examensToday = Planing::query()
            ->where('cod_etu', $codEtu)
            ->whereDate('date', $today)
            ->get();

        if ($examensToday->count() === 0) {
            return response()->json(['message' => 'No exam today'], 404);
        }

        $requestedPlaningId = $request->input('planing_id');

        $matches = [];
        $best = null;
        $bestDiff = null;

        foreach ($examensToday as $examen) {
            if ($examen->date === null || $examen->horaire === null) {
                continue;
            }

            $examAt = Carbon::parse($examen->date->toDateString().' '.$examen->horaire);
            $windowStart = $examAt->copy()->subMinutes(10);
            $windowEnd = $examAt->copy()->addMinutes(40);

            if ($now->lt($windowStart) || $now->gt($windowEnd)) {
                continue;
            }

            $diff = abs($now->diffInMinutes($examAt, false));

            $matches[] = [
                'planing_id' => $examen->id,
                'module' => $examen->module,
                'professeur' => $examen->professeur,
                'semestre' => $examen->semestre,
                'groupe' => $examen->groupe,
                'date' => optional($examen->date_examen)->toDateString(),
                'horaire' => (string) $examen->horaire,
                'salle' => $examen->salle,
                'diff_minutes' => $diff,
            ];

            if ($bestDiff === null || $diff < $bestDiff) {
                $bestDiff = $diff;
                $best = $examen;
            }
        }

        if (count($matches) === 0) {
            return response()->json(['message' => 'No matching exam for current time window'], 422);
        }

        if ($requestedPlaningId !== null && $requestedPlaningId !== '') {
            $requestedPlaningId = (int) $requestedPlaningId;

            $inWindow = collect($matches)->firstWhere('planing_id', $requestedPlaningId);

            if ($inWindow === null) {
                return response()->json([
                    'message' => 'Selected exam is not in current time window',
                    'matches' => $matches,
                ], 422);
            }

            $selected = Planing::query()
                ->whereKey($requestedPlaningId)
                ->where('cod_etu', $codEtu)
                ->first();

            if ($selected === null) {
                return response()->json(['message' => 'Exam not found'], 404);
            }

            $selected->present = true;
            $selected->save();

            return response()->json([
                'message' => 'Presence marked',
                'cod_etu' => $codEtu,
                'planing_id' => $selected->id,
                'module' => $selected->module,
                'date' => optional($selected->date_examen)->toDateString(),
                'horaire' => (string) $selected->horaire,
            ], Response::HTTP_OK);
        }

        if (count($matches) > 1) {
            return response()->json([
                'message' => 'Multiple exams match current time window',
                'matches' => $matches,
            ], 409);
        }

        if ($best === null || $bestDiff === null) {
            return response()->json(['message' => 'No matching exam for current time window'], 422);
        }

        $best->present = true;
        $best->save();

        return response()->json([
            'message' => 'Presence marked',
            'cod_etu' => $codEtu,
            'planing_id' => $best->id,
            'module' => $best->module,
            'date' => optional($best->date_examen)->toDateString(),
            'horaire' => (string) $best->horaire,
        ], Response::HTTP_OK);
    }
}
