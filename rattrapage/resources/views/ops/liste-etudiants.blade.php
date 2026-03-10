@extends('ops.layout')

@section('title', __('messages.ops.list.title'))

@section('content')
            <header class="mb-6">
                <h1 class="text-xl font-semibold">{{ __('messages.ops.list.heading') }}</h1>
            </header>

            <section class="mb-6 bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                <form id="filtersForm" method="GET" action="{{ url('/ops/liste-etudiants') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
                    <div>
                        <label for="date" class="block text-xs text-[#706f6c] mb-1">{{ __('messages.ops.list.filters.date') }}</label>
                        <select id="date" name="date" class="w-full rounded-xl border border-[#1b02a4]/20 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25" onchange="document.getElementById('salle').value='';document.getElementById('filtersForm').requestSubmit();">
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
                        <label for="horaire" class="block text-xs text-[#706f6c] mb-1">Horaire</label>
                        <select id="horaire" name="horaire" class="w-full rounded-xl border border-[#1b02a4]/20 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25" onchange="document.getElementById('salle').value='';document.getElementById('filtersForm').requestSubmit();">
                            <option value="">{{ __('messages.ops.list.filters.all') }}</option>
                            @foreach ($availableHoraires as $h)
                                <option value="{{ $h }}" @selected(($filters['horaire'] ?? '') === (string) $h)>
                                    {{ $h }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="site" class="block text-xs text-[#706f6c] mb-1">Site</label>
                        <select id="site" name="site" class="w-full rounded-xl border border-[#1b02a4]/20 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25" onchange="document.getElementById('salle').value='';document.getElementById('filtersForm').requestSubmit();">
                            <option value="">{{ __('messages.ops.list.filters.all') }}</option>
                            @foreach ($availableSites as $st)
                                <option value="{{ $st }}" @selected(($filters['site'] ?? '') === (string) $st)>
                                    {{ $st }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="salle" class="block text-xs text-[#706f6c] mb-1">{{ __('messages.ops.list.filters.salle') }}</label>
                        <select id="salle" name="salle" class="w-full rounded-xl border border-[#1b02a4]/20 bg-white px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25" onchange="document.getElementById('filtersForm').requestSubmit();">
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
                            <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1b02a4] text-white px-4 py-2 text-sm font-medium transition-all hover:bg-[#16028a] active:bg-[#120273] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35 w-full">
                                {{ __('messages.ops.list.actions.apply') }}
                            </button>
                        </div>
                    </div>
                </form>
            </section>

            <section class="bg-white shadow-sm ring-1 ring-black/5 rounded-lg p-6">
                <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                    <h2 class="text-sm font-semibold uppercase tracking-wide text-[#706f6c]">{{ __('messages.ops.export.heading') }}</h2>

                    <form id="zipForm" method="POST" action="/ops/presence-pdfs-zip" class="flex items-center gap-3">
                        @csrf
                        <label class="inline-flex items-center gap-2 text-sm text-[#1b1b18] select-none">
                            <input id="selectAll" type="checkbox" class="h-4 w-4 rounded border-[#1b02a4]/30 text-[#1b02a4] focus:ring-[#1b02a4]/25" />
                            <span>Sélectionner tout</span>
                        </label>

                        <div id="zipGroups"></div>

                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-[#1b02a4] text-white px-4 py-2 text-sm font-medium transition-all hover:bg-[#16028a] active:bg-[#120273] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35">
                            Télécharger sélection
                        </button>
                    </form>
                </div>

                @if ($groups->count() === 0)
                    <div class="p-4 rounded bg-[#F5F5F3] text-sm text-[#1b1b18]">
                        {{ __('messages.ops.export.empty_state') }}
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach ($groups as $g)
                            @php($d = is_object($g->date_examen) ? $g->date_examen->format('Y-m-d') : (string) $g->date_examen)
                            <div class="flex items-stretch gap-2">
                                <label class="flex items-center px-3 rounded-xl border border-[#1b02a4]/20 bg-white">
                                    <input
                                        type="checkbox"
                                        class="groupCheckbox h-4 w-4 rounded border-[#1b02a4]/30 text-[#1b02a4] focus:ring-[#1b02a4]/25"
                                        data-date="{{ $d }}"
                                        data-horaire="{{ (string) $g->horaire }}"
                                        data-salle="{{ (string) $g->salle }}"
                                    />
                                </label>

                                <a class="flex-1 block rounded-xl border border-[#1b02a4]/20 bg-white px-4 py-3 text-sm font-medium text-[#1b02a4] transition-colors hover:bg-[#1b02a4]/5 active:bg-[#1b02a4]/10" href="{{ url('/ops/presence-pdf').'?'.http_build_query(['date' => $d, 'horaire' => (string) $g->horaire, 'salle' => (string) $g->salle]) }}">
                                    {{ __('messages.ops.export.link_label', ['date' => $d, 'horaire' => (string) $g->horaire, 'salle' => (string) $g->salle]) }}
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            <script>
                (function () {
                    const selectAll = document.getElementById('selectAll');
                    const zipForm = document.getElementById('zipForm');
                    const zipGroups = document.getElementById('zipGroups');

                    function getCheckboxes() {
                        return Array.from(document.querySelectorAll('.groupCheckbox'));
                    }

                    function syncSelectAllState() {
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
                        zipGroups.innerHTML = '';
                        const selected = getCheckboxes().filter((b) => b.checked);
                        if (selected.length === 0) {
                            e.preventDefault();
                            return;
                        }

                        selected.forEach((b, idx) => {
                            const date = b.getAttribute('data-date') || '';
                            const horaire = b.getAttribute('data-horaire') || '';
                            const salle = b.getAttribute('data-salle') || '';

                            const d = document.createElement('input');
                            d.type = 'hidden';
                            d.name = `groups[${idx}][date]`;
                            d.value = date;
                            zipGroups.appendChild(d);

                            const h = document.createElement('input');
                            h.type = 'hidden';
                            h.name = `groups[${idx}][horaire]`;
                            h.value = horaire;
                            zipGroups.appendChild(h);

                            const s = document.createElement('input');
                            s.type = 'hidden';
                            s.name = `groups[${idx}][salle]`;
                            s.value = salle;
                            zipGroups.appendChild(s);
                        });
                    });

                    syncSelectAllState();
                })();
            </script>

@endsection
