<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>{{ __('messages.convocation.title') }}</title>
    <style>
        @page { margin: 28px 32px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h1 { font-size: 16px; margin: 0 0 10px 0; }
        h2 { font-size: 12px; margin: 18px 0 8px 0; }
        .muted { color: #555; font-size: 11px; }
        .box { border: 1px solid #ddd; padding: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #eee; padding: 6px 4px; text-align: left; }
        th { font-size: 11px; color: #444; }
        .critical { font-weight: 700; }
        .row { display: table; width: 100%; }
        .col { display: table-cell; width: 50%; vertical-align: top; }
        .rtl th, .rtl td { text-align: right; }
    </style>
</head>
<body class="{{ app()->getLocale() === 'ar' ? 'rtl' : '' }}">
    <div style="margin-bottom: 8px;">
        <div class="row">
            <div class="col">
                <div class="muted">{{ __('messages.app_name') }}</div>
                <h1>{{ __('messages.convocation.heading') }}</h1>
            </div>
            <div class="col" style="text-align: {{ app()->getLocale() === 'ar' ? 'left' : 'right' }};">
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
                    <th>{{ __('messages.convocation.table.date') }}</th>
                    <th>{{ __('messages.convocation.table.horaire') }}</th>
                    <th>{{ __('messages.convocation.table.salle') }}</th>
                    <th>{{ __('messages.convocation.table.module') }}</th>
                    <th>{{ __('messages.convocation.table.site') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($examens as $examen)
                    <tr>
                        <td class="critical">{{ optional($examen->date_examen)->format('d/m/Y') }}</td>
                        <td class="critical">{{ $examen->horaire }}</td>
                        <td class="critical">{{ $examen->salle }}</td>
                        <td>{{ $examen->module }}</td>
                        <td>{{ $examen->site }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</body>
</html>
