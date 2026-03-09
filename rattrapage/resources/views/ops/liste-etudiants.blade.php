<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('messages.ops.list.title') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] flex items-start justify-center p-6">
        <main class="w-full max-w-6xl">
            <header class="mb-6">
                <div class="text-xs text-[#706f6c]">{{ __('messages.app_name') }}</div>
                <h1 class="text-xl font-semibold">{{ __('messages.ops.list.heading') }}</h1>
            </header>

            <section class="mb-6 bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                <form method="GET" action="{{ url('/ops/liste-etudiants') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div>
                        <label for="date" class="block text-xs text-[#706f6c] mb-1">{{ __('messages.ops.list.filters.date') }}</label>
                        <select id="date" name="date" class="w-full rounded border border-black/15 bg-white px-3 py-2 text-sm">
                            <option value="">{{ __('messages.ops.list.filters.all') }}</option>
                            @foreach ($availableDates as $d)
                                @php($val = is_object($d) ? $d->format('Y-m-d') : (string) $d)
                                <option value="{{ $val }}" @selected(($filters['date'] ?? '') === $val)>
                                    {{ $val }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="salle" class="block text-xs text-[#706f6c] mb-1">{{ __('messages.ops.list.filters.salle') }}</label>
                        <select id="salle" name="salle" class="w-full rounded border border-black/15 bg-white px-3 py-2 text-sm">
                            <option value="">{{ __('messages.ops.list.filters.all') }}</option>
                            @foreach ($availableSalles as $s)
                                <option value="{{ $s }}" @selected(($filters['salle'] ?? '') === (string) $s)>
                                    {{ $s }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex items-end">
                        <div class="grid grid-cols-1 gap-2 w-full">
                            <button type="submit" class="inline-flex items-center justify-center rounded bg-[#1b1b18] text-white px-4 py-2 text-sm font-medium w-full">
                                {{ __('messages.ops.list.actions.apply') }}
                            </button>
                            <a href="{{ url('/ops/export-pdfs').'?'.http_build_query(array_filter(['date' => ($filters['date'] ?? null), 'salle' => ($filters['salle'] ?? null)])) }}" class="inline-flex items-center justify-center rounded border border-black/15 bg-white px-4 py-2 text-sm font-medium w-full">
                                {{ __('messages.ops.list.actions.export_pdfs') }}
                            </a>
                        </div>
                    </div>
                </form>
            </section>

            <section class="bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c] mb-4">{{ __('messages.ops.list.table.title') }}</h2>

                @if ($examens->count() === 0)
                    <div class="p-4 rounded bg-[#F5F5F3] text-sm text-[#1b1b18]">
                        {{ __('messages.ops.list.empty_state') }}
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-xs text-[#706f6c]">
                                <tr class="border-b border-black/10">
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.ops.list.table.date') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.ops.list.table.salle') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.ops.list.table.horaire') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.ops.list.table.nom') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.ops.list.table.prenom') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.ops.list.table.apogee') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.ops.list.table.module') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.ops.list.table.site') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($examens as $examen)
                                    <tr class="border-b border-black/5">
                                        <td class="py-3 font-semibold whitespace-nowrap">{{ optional($examen->date_examen)->format('Y-m-d') }}</td>
                                        <td class="py-3 font-semibold whitespace-nowrap">{{ $examen->salle }}</td>
                                        <td class="py-3 font-semibold whitespace-nowrap">{{ $examen->horaire }}</td>
                                        <td class="py-3 whitespace-nowrap">{{ $examen->nom }}</td>
                                        <td class="py-3 whitespace-nowrap">{{ $examen->prenom }}</td>
                                        <td class="py-3 whitespace-nowrap">{{ $examen->cod_etu }}</td>
                                        <td class="py-3 whitespace-nowrap">{{ $examen->module }}</td>
                                        <td class="py-3 whitespace-nowrap">{{ $examen->site }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
        </main>
    </body>
</html>
