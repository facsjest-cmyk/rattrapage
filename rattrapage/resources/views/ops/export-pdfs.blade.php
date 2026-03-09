<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('messages.ops.export.title') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] flex items-start justify-center p-6">
        <main class="w-full max-w-4xl">
            <header class="mb-6">
                <div class="text-xs text-[#706f6c]">{{ __('messages.app_name') }}</div>
                <h1 class="text-xl font-semibold">{{ __('messages.ops.export.heading') }}</h1>
                <div class="mt-2">
                    <a href="{{ url('/ops/liste-etudiants').'?'.http_build_query(array_filter(['date' => ($filters['date'] ?? null), 'salle' => ($filters['salle'] ?? null)])) }}" class="text-sm text-[#1b1b18] underline">
                        {{ __('messages.ops.export.back') }}
                    </a>
                </div>
            </header>

            <section class="bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                @if ($groups->count() === 0)
                    <div class="p-4 rounded bg-[#F5F5F3] text-sm text-[#1b1b18]">
                        {{ __('messages.ops.export.empty_state') }}
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach ($groups as $g)
                            @php($d = is_object($g->date_examen) ? $g->date_examen->format('Y-m-d') : (string) $g->date_examen)
                            <a class="block rounded border border-black/10 bg-white px-4 py-3 text-sm hover:bg-black/5" href="{{ url('/ops/presence-pdf').'?'.http_build_query(['date' => $d, 'horaire' => (string) $g->horaire, 'salle' => (string) $g->salle]) }}">
                                {{ __('messages.ops.export.link_label', ['date' => $d, 'horaire' => (string) $g->horaire, 'salle' => (string) $g->salle]) }}
                            </a>
                        @endforeach
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>
