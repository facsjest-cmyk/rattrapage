<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <title>Rattrapage filière</title>
    <style>
        @page { margin: 72px 32px 58px 32px; }
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #111; }
        h1 { font-size: 15px; margin: 0; }
        .muted { color: #555; font-size: 11px; }

        header {
            position: fixed;
            top: -52px;
            left: 0;
            right: 0;
            height: 46px;
        }

        header .line1 { display: flex; justify-content: space-between; }
        header .line2 { margin-top: 2px; }

        footer {
            position: fixed;
            bottom: -40px;
            left: 0;
            right: 0;
            height: 30px;
        }

        table { width: 100%; border-collapse: collapse; margin-top: 8px; }
        thead { display: table-header-group; }
        tfoot { display: table-row-group; }
        tr { page-break-inside: avoid; }
        th, td { border-bottom: 1px solid #e9e9e9; padding: 8px 6px; text-align: left; vertical-align: top; }
        th { font-size: 11px; color: #444; background: #f6f6f6; }
        td { height: 22px; }
        .rtl th, .rtl td { text-align: right; }
    </style>
</head>
<body class="{{ app()->getLocale() === 'ar' ? 'rtl' : '' }}">
    <header>
        <div class="muted line1">
            <span>{{ __('messages.app_name') }}</span>
            <span>Rattrapage filière</span>
        </div>
        <div class="line2">
            <h1>Rattrapage – {{ $filiere }} / {{ $groupe }}</h1>
            <div class="muted">Généré le {{ date('Y-m-d H:i') }}</div>
        </div>
    </header>

    <footer>
        <script type="text/php">
            if (isset($pdf)) {
                $pdf->page_text(32, 810, "Page {PAGE_NUM} / {PAGE_COUNT}", null, 9, [0.35, 0.35, 0.35]);
            }
        </script>
    </footer>

    <table>
        <thead>
            <tr>
                <th>Module</th>
                <th>Prof</th>
                <th>Date d'examen</th>
                <th>Horaire</th>
                <th>Site</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($rows as $row)
                <tr>
                    <td>{{ $row->module }}</td>
                    <td>{{ $row->professeur ?? $row->prof }}</td>
                    <td>{{ optional($row->date_examen)->format('d/m/Y') }}</td>
                    <td>{{ $row->horaire }}</td>
                    <td>{{ $row->site }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
