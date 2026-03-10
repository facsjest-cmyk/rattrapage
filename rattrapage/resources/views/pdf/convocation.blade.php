<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.convocation.title') }}</title>
    <style>
        @page { margin: 22px 26px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h1 { font-size: 16px; margin: 0 0 10px 0; }
        h2 { font-size: 12px; margin: 18px 0 8px 0; }
        .muted { color: #555; font-size: 11px; }
        .box { border: 1px solid #ddd; padding: 10px; }
        table { width: 100%; border-collapse: collapse; border: 1px solid #111; }
        th, td { border: 1px solid #111; padding: 6px 6px; text-align: left; }
        th { font-size: 11px; color: #111; background: #f3f3f3; }
        .critical { font-weight: 700; }
        .row { display: table; width: 100%; }
        .col { display: table-cell; width: 50%; vertical-align: top; }
        .rtl th, .rtl td { text-align: right; }
        .header-right { text-align: right; }
        .rtl .header-right { text-align: left; }
    </style>
</head>
<body class="{{ app()->getLocale() === 'ar' ? 'rtl' : '' }}">
    <div style="margin-bottom: 8px;">
        <div class="row">
            <div class="col">
                <img src="{{ public_path('assets/brand/logo.png') }}" alt="" style="height: 52px; width: auto;" />
            </div>
            <div class="col header-right">
                <div class="critical" style="font-size: 14px; margin-bottom: 2px;">Convocation d'examen</div>
                <div class="muted" style="margin-bottom: 2px;">année universitaire : 2025/2026</div>
                <div class="critical" style="margin-bottom: 6px;">Session Rattrapage</div>
                @if (!empty($qr_svg))
                    <div style="display: inline-block; width: 90px; height: 90px;">
                        {!! $qr_svg !!}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="box">
        <div class="row">
            <div class="col">
                <div class="muted">{{ __('messages.convocation.fields.nom') }}</div>
                <div>{{ $etudiant->nom }}</div>
            </div>
            <div class="col">
                <div class="muted">{{ __('messages.convocation.fields.prenom') }}</div>
                <div>{{ $etudiant->prenom }}</div>
            </div>
        </div>
        <div class="row" style="margin-top: 10px;">
            <div class="col">
                <div class="muted">{{ __('messages.convocation.fields.code_apogee') }}</div>
                <div>{{ $etudiant->cod_etu }}</div>
            </div>
            <div class="col">
                <div class="muted">{{ __('messages.convocation.fields.filiere') }}</div>
                <div>{{ $etudiant->filiere }}</div>
            </div>
        </div>
    </div>

    <h2>{{ __('messages.convocation.sections.examens') }}</h2>

    @if ($examens->count() === 0)
        <div class="box">{{ __('messages.convocation.empty_state') }}</div>
    @else
        <table>
            <thead>
                <tr>
                    <th>{{ __('messages.convocation.table.module') }}</th>
                    <th>{{ __('messages.convocation.table.professeur') }}</th>
                    <th>{{ __('messages.convocation.table.semestre') }}</th>
                    <th>{{ __('messages.convocation.table.groupe') }}</th>
                    <th>{{ __('messages.convocation.table.date') }}</th>
                    <th>{{ __('messages.convocation.table.horaire') }}</th>
                    <th>Salle/Amphi</th>
                    <th>Place</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($examens as $examen)
                    <tr>
                        <td>{{ $examen->module }}</td>
                        <td>{{ $examen->professeur }}</td>
                        <td class="critical">{{ $examen->semestre }}</td>
                        <td class="critical">{{ $examen->groupe }}</td>
                        <td class="critical">{{ optional($examen->date_examen)->format('d/m/Y') }}</td>
                        <td class="critical">{{ $examen->horaire }}</td>
                        <td class="critical">{{ $examen->salle }}</td>
                        <td class="critical">{{ $examen->num_exam }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
