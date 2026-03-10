<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('messages.convocation.title') }}</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen text-[#1b1b18]">
        <div class="min-h-screen relative isolate flex items-start justify-center p-6">
            <div class="absolute inset-0 -z-10">
                <img
                    src="{{ asset('assets/brand/login-bg.png') }}"
                    alt=""
                    class="h-full w-full object-cover"
                />
                <div
                    class="absolute inset-0 opacity-35 mix-blend-multiply"
                    style="background-image: url('{{ asset('assets/brand/bkgbkg.png') }}'); background-repeat: repeat; background-position: center; background-size: min(520px, 46vw) auto;"
                ></div>
                <div class="absolute inset-0 bg-[#cfe9ff]/65"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-[#cfe9ff]/15 via-transparent to-[#cfe9ff]/30"></div>
            </div>

            <main class="relative w-full max-w-8xl bg-white/95 backdrop-blur shadow-lg ring-1 ring-black/10 rounded-2xl p-6 sm:p-8">
            <header class="mb-6 flex items-center justify-between gap-4">
                <img src="{{ asset('assets/brand/logo.png') }}" alt="" class="h-14 sm:h-16 w-auto" />

                <form method="POST" action="/logout" class="shrink-0">
                    @csrf
                    <button type="submit" class="inline-flex items-center justify-center rounded border border-[#1b02a4]/20 bg-white px-4 py-2 text-sm font-medium text-[#1b02a4] transition-colors hover:bg-[#1b02a4]/5 active:bg-[#1b02a4]/10 focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25">
                        Logout
                    </button>
                </form>
            </header>

            @if (session('pdf_error'))
                <div class="mb-4 p-3 rounded bg-red-50 text-red-800 text-sm">
                    {{ session('pdf_error') }}
                </div>
            @endif

            <section class="mb-6 bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                <div class="w-full max-w-3xl">
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
                </div>
            </section>

            <section class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                <div class="text-sm font-semibold text-[#000000]">{{ __('messages.convocation.pdf.helper') }}</div>
                <div class="flex items-center gap-3">
                    <a href="/convocation/pdf" class="inline-flex items-center justify-center rounded bg-[#1b02a4] text-white px-4 py-2 text-sm font-medium transition-all hover:bg-[#16028a] active:bg-[#120273] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35">
                        {{ __('messages.convocation.pdf.open') }}
                    </a>
                </div>
            </section>

            <section class="bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
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
                                    <th scope="col" class="py-2 px-3 text-start font-medium">{{ __('messages.convocation.table.module') }}</th>
                                    <th scope="col" class="py-2 px-3 text-start font-medium">{{ __('messages.convocation.table.professeur') }}</th>
                                    <th scope="col" class="py-2 px-3 text-start font-medium whitespace-nowrap">{{ __('messages.convocation.table.semestre') }}</th>
                                    <th scope="col" class="py-2 px-3 text-start font-medium whitespace-nowrap">{{ __('messages.convocation.table.groupe') }}</th>
                                    <th scope="col" class="py-2 px-3 text-start font-medium whitespace-nowrap min-w-[120px]">{{ __('messages.convocation.table.date') }}</th>
                                    <th scope="col" class="py-2 px-3 text-start font-medium whitespace-nowrap min-w-[110px]">{{ __('messages.convocation.table.horaire') }}</th>
                                    <th scope="col" class="py-2 px-3 text-start font-medium whitespace-nowrap min-w-[160px]">Salle/Amphi</th>
                                    <th scope="col" class="py-2 px-3 text-start font-medium whitespace-nowrap min-w-[90px]">Place</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($examens as $examen)
                                    <tr class="border-b border-black/5">
                                        <td class="py-3 px-3">{{ $examen->module }}</td>
                                        <td class="py-3 px-3">{{ $examen->professeur }}</td>
                                        <td class="py-3 px-3 whitespace-nowrap">{{ $examen->semestre }}</td>
                                        <td class="py-3 px-3 whitespace-nowrap">{{ $examen->groupe }}</td>
                                        <td class="py-3 px-3 font-semibold whitespace-nowrap min-w-[120px]">
                                            {{ optional($examen->date_examen)->format('d/m/Y') }}
                                        </td>
                                        <td class="py-3 px-3 font-semibold whitespace-nowrap min-w-[110px]">
                                            {{ $examen->horaire }}
                                        </td>
                                        <td class="py-3 px-3 font-semibold whitespace-nowrap min-w-[160px]">
                                            {{ $examen->salle }}
                                        </td>
                                        <td class="py-3 px-3 font-semibold whitespace-nowrap min-w-[90px]">
                                            {{ $examen->num_exam }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </section>
            </main>
        </div>
    </body>
</html>
