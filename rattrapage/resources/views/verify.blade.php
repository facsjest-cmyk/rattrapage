<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('messages.convocation.title') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-[#FDFDFC] text-[#1b1b18] flex items-start justify-center p-6">
        <main class="w-full max-w-4xl bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
            <header class="mb-6">
                <h1 class="text-xl font-semibold">{{ __('messages.convocation.heading') }}</h1>
            </header>

            <section class="mb-6 bg-white ring-1 ring-black/5 rounded-lg p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c] mb-4">{{ __('messages.convocation.sections.student') }}</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs text-[#706f6c]">{{ __('messages.convocation.fields.nom') }}</div>
                        <div class="font-medium">{{ $etudiant->nom }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-[#706f6c]">{{ __('messages.convocation.fields.prenom') }}</div>
                        <div class="font-medium">{{ $etudiant->prenom }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-[#706f6c]">{{ __('messages.convocation.fields.code_apogee') }}</div>
                        <div class="font-medium">{{ $etudiant->cod_etu }}</div>
                    </div>

                    <div>
                        <div class="text-xs text-[#706f6c]">{{ __('messages.convocation.fields.filiere') }}</div>
                        <div class="font-medium">{{ $etudiant->filiere }}</div>
                    </div>
                </div>
            </section>

            <section class="bg-white ring-1 ring-black/5 rounded-lg p-6">
                <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c] mb-4">{{ __('messages.convocation.sections.examens') }}</h2>

                @if ($examens->count() === 0)
                    <div class="p-4 rounded bg-[#F5F5F3] text-sm text-[#1b1b18]">
                        {{ __('messages.convocation.empty_state') }}
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <caption class="sr-only">{{ __('messages.convocation.sections.examens') }}</caption>
                            <thead class="text-xs text-[#706f6c]">
                                <tr class="border-b border-black/10">
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.convocation.table.date') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.convocation.table.horaire') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.convocation.table.salle') }}</th>
                                    <th scope="col" class="py-2 text-start font-medium">{{ __('messages.convocation.table.module') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($examens as $examen)
                                    <tr class="border-b border-black/5">
                                        <td class="py-3 font-semibold whitespace-nowrap">
                                            {{ optional($examen->date_examen)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 font-semibold whitespace-nowrap">
                                            {{ $examen->horaire }}
                                        </td>
                                        <td class="py-3 font-semibold whitespace-nowrap">
                                            {{ $examen->salle }}
                                        </td>
                                        <td class="py-3 whitespace-nowrap">{{ $examen->module }}</td>
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
