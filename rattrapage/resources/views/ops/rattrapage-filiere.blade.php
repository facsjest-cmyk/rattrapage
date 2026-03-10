@extends('ops.layout')

@section('title', 'Rattrapage filière')

@section('content')
                <header class="mb-6">
                    <h1 class="text-xl font-semibold">Rattrapage filière (PDF)</h1>
                </header>

                <section class="bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                    <form id="filtersForm" method="GET" action="/ops/rattrapage-filiere" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
                        <div>
                            <label for="filiere" class="block text-xs text-[#706f6c] mb-1">Filière</label>
                            <select id="filiere" name="filiere" class="w-full rounded-xl border border-[#1b02a4]/20 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25" onchange="document.getElementById('filtersForm').requestSubmit();">
                                <option value="">Tous</option>
                                @foreach ($availableFilieres as $f)
                                    <option value="{{ $f }}" @selected(($filters['filiere'] ?? '') === (string) $f)>
                                        {{ $f }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="hidden lg:block"></div>
                    </form>
                </section>

                @if (($filters['filiere'] ?? '') !== '')
                    <section class="mt-6 bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                        <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                            <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c]">Groupes</h2>

                            <form id="zipForm" method="POST" action="/ops/rattrapage-filiere/pdfs-zip" class="flex items-center gap-3">
                                @csrf
                                <input type="hidden" name="filiere" value="{{ $filters['filiere'] ?? '' }}" />
                                <label class="inline-flex items-center gap-2 text-sm text-[#1b1b18] select-none">
                                    <input id="selectAll" type="checkbox" class="h-4 w-4 rounded border-[#1b02a4]/30 text-[#1b02a4] focus:ring-[#1b02a4]/25" />
                                    <span>Sélectionner tout</span>
                                </label>

                                <div id="zipGroupes"></div>

                                <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1b02a4] text-white px-4 py-2 text-sm font-medium transition-all hover:bg-[#16028a] active:bg-[#120273] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35">
                                    Télécharger sélection
                                </button>
                            </form>
                        </div>

                        @if (($availableGroupes?->count() ?? 0) === 0)
                            <div class="p-4 rounded bg-[#F5F5F3] text-sm text-[#1b1b18]">
                                Aucun groupe trouvé.
                            </div>
                        @else
                            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2">
                                @foreach ($availableGroupes as $g)
                                    <div class="flex items-stretch gap-2">
                                        <label class="flex items-center px-3 rounded-xl border border-[#1b02a4]/20 bg-white">
                                            <input
                                                type="checkbox"
                                                class="groupCheckbox h-4 w-4 rounded border-[#1b02a4]/30 text-[#1b02a4] focus:ring-[#1b02a4]/25"
                                                data-groupe="{{ (string) $g }}"
                                            />
                                        </label>

                                        <a href="{{ url('/ops/rattrapage-filiere/pdf').'?'.http_build_query(['filiere' => ($filters['filiere'] ?? ''), 'groupe' => (string) $g]) }}" class="flex-1 block rounded-xl border border-[#1b02a4]/20 bg-white px-4 py-3 text-sm font-medium text-[#1b02a4] transition-colors hover:bg-[#1b02a4]/5 active:bg-[#1b02a4]/10">
                                            {{ $g }}
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </section>
                @endif

                <script>
                    (function () {
                        const selectAll = document.getElementById('selectAll');
                        const zipForm = document.getElementById('zipForm');
                        const zipGroupes = document.getElementById('zipGroupes');

                        function getCheckboxes() {
                            return Array.from(document.querySelectorAll('.groupCheckbox'));
                        }

                        function syncSelectAllState() {
                            if (!selectAll) return;
                            const boxes = getCheckboxes();
                            const checked = boxes.filter((b) => b.checked);
                            if (boxes.length === 0) {
                                selectAll.checked = false;
                                selectAll.indeterminate = false;
                                return;
                            }
                            selectAll.checked = checked.length === boxes.length;
                            selectAll.indeterminate = checked.length > 0 && checked.length < boxes.length;
                        }

                        selectAll?.addEventListener('change', function () {
                            const boxes = getCheckboxes();
                            boxes.forEach((b) => {
                                b.checked = selectAll.checked;
                            });
                            syncSelectAllState();
                        });

                        document.addEventListener('change', function (e) {
                            if (e.target && e.target.classList && e.target.classList.contains('groupCheckbox')) {
                                syncSelectAllState();
                            }
                        });

                        zipForm?.addEventListener('submit', function (e) {
                            if (!zipGroupes) return;
                            zipGroupes.innerHTML = '';
                            const selected = getCheckboxes().filter((b) => b.checked);
                            if (selected.length === 0) {
                                e.preventDefault();
                                return;
                            }

                            selected.forEach((b, idx) => {
                                const groupe = b.getAttribute('data-groupe') || '';

                                const input = document.createElement('input');
                                input.type = 'hidden';
                                input.name = `groupes[${idx}]`;
                                input.value = groupe;
                                zipGroupes.appendChild(input);
                            });
                        });

                        syncSelectAllState();
                    })();
                </script>

@endsection
