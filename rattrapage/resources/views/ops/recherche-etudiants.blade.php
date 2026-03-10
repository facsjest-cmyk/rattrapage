@extends('ops.layout')

@section('title', 'Recherche étudiants')

@section('content')
                <header class="mb-6">
                    <h1 class="text-xl font-semibold">Recherche étudiants</h1>
                </header>

                <section class="mb-6 bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                    <form method="GET" action="/ops/recherche-etudiants" class="flex flex-col sm:flex-row sm:items-end gap-3">
                        <div class="flex-1">
                            <label for="apogee" class="block text-xs text-[#706f6c] mb-1">Apogée</label>
                            <input id="apogee" name="apogee" value="{{ old('apogee', $apogee ?? '') }}" class="w-full rounded-xl border border-[#1b02a4]/20 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25" autocomplete="off" />
                            @error('apogee')
                                <div class="mt-1 text-sm text-red-700">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1b02a4] text-white px-4 py-2 text-sm font-medium transition-all hover:bg-[#16028a] active:bg-[#120273] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35">
                            Rechercher
                        </button>
                    </form>
                </section>

                @isset($apogee)
                    @if (($etudiant ?? null) === null)
                        <div class="mb-6 p-3 rounded bg-red-50 text-red-800 text-sm">
                            Étudiant introuvable.
                        </div>
                    @else
                        <section class="mb-6 bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                            <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c] mb-4">Étudiant</h2>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <div class="text-xs text-[#706f6c]">Nom</div>
                                    <div class="font-medium">{{ $etudiant->nom }}</div>
                                </div>

                                <div>
                                    <div class="text-xs text-[#706f6c]">Prénom</div>
                                    <div class="font-medium">{{ $etudiant->prenom }}</div>
                                </div>

                                <div>
                                    <div class="text-xs text-[#706f6c]">Code apogée</div>
                                    <div class="font-medium">{{ $etudiant->cod_etu }}</div>
                                </div>

                                <div>
                                    <div class="text-xs text-[#706f6c]">Filière</div>
                                    <div class="font-medium">{{ $etudiant->filiere }}</div>
                                </div>
                            </div>
                        </section>

                        <section class="bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                            <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c] mb-4">Examens / rattrapage</h2>

                            @if (($examens?->count() ?? 0) === 0)
                                <div class="p-4 rounded bg-[#F5F5F3] text-sm text-[#1b1b18]">
                                    Aucun examen trouvé.
                                </div>
                            @else
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm">
                                        <thead class="text-xs text-[#706f6c]">
                                            <tr class="border-b border-black/10">
                                                <th scope="col" class="py-2 text-start font-medium">Date</th>
                                                <th scope="col" class="py-2 text-start font-medium">Horaire</th>
                                                <th scope="col" class="py-2 text-start font-medium">Salle</th>
                                                <th scope="col" class="py-2 text-start font-medium">Module</th>
                                                <th scope="col" class="py-2 text-start font-medium">Site</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($examens as $examen)
                                                <tr class="border-b border-black/5">
                                                    <td class="py-3 font-semibold whitespace-nowrap">
                                                        {{ optional($examen->date_examen)->format('d/m/Y') }}
                                                    </td>
                                                    <td class="py-3 font-semibold whitespace-nowrap">{{ $examen->horaire }}</td>
                                                    <td class="py-3 font-semibold whitespace-nowrap">{{ $examen->salle }}</td>
                                                    <td class="py-3 whitespace-nowrap">{{ $examen->module }}</td>
                                                    <td class="py-3 whitespace-nowrap">{{ $examen->site }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </section>
                    @endif
                @endisset

@endsection
