<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen text-[#1b1b18]">
        @php($opsPath = request()->path())
        <div class="min-h-screen relative isolate flex">
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

            <div class="fixed inset-0 z-40 hidden" id="opsMobileSidebar" aria-hidden="true">
                <div class="absolute inset-0 bg-black/35" id="opsMobileSidebarBackdrop"></div>

                <div class="relative h-full w-64 bg-white/95 backdrop-blur shadow-lg ring-1 ring-black/10 rounded-tr-2xl px-4 py-6 flex flex-col">
                    <div class="flex items-center justify-between">
                        <img src="{{ asset('assets/brand/logo2.png') }}" alt="" class="h-14 w-auto" />
                        <button type="button" id="opsMobileSidebarClose" class="inline-flex items-center justify-center rounded-lg px-2 py-2 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-black/10">✕</button>
                    </div>

                    <div class="mt-4 h-px bg-black/10"></div>

                    <nav class="mt-10 space-y-2 px-1">
                        
                        <a href="/ops/liste-etudiants" class="block rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $opsPath === 'ops/liste-etudiants' ? 'bg-[#1b02a4] text-white' : 'text-[#1b1b18] hover:bg-black/5' }}">Listes des étudiants</a>
                        
                        <a href="/ops/recherche-etudiants" class="block rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $opsPath === 'ops/recherche-etudiants' ? 'bg-[#1b02a4] text-white' : 'text-[#1b1b18] hover:bg-black/5' }}">Recherche étudiants</a>
                        <a href="/ops/rattrapage-filiere" class="block rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ str_starts_with($opsPath, 'ops/rattrapage-filiere') ? 'bg-[#1b02a4] text-white' : 'text-[#1b1b18] hover:bg-black/5' }}">Rattrapage filière</a>
                    </nav>

                    <div class="mt-auto pt-6">
                        <div class="h-px bg-black/10 mb-4"></div>

                        <form method="POST" action="/ops/logout">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-black/10">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <aside class="relative w-60 shrink-0 hidden lg:flex">
                <div class="w-full bg-white/95 backdrop-blur shadow-lg ring-1 ring-black/10 rounded-tr-2xl px-4 py-6 flex flex-col">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('assets/brand/logo2.png') }}" alt="" class="h-20 w-auto" />
                    </div>
<br>
                    <div class="mt-4 h-px bg-black/10"></div>

                    <nav class="mt-12 space-y-2 px-1">
                        <br>
                        <a href="/ops/liste-etudiants" class="block rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $opsPath === 'ops/liste-etudiants' ? 'bg-[#1b02a4] text-white' : 'text-[#1b1b18] hover:bg-black/5' }}">Listes des étudiants</a>
                        <a href="/ops/recherche-etudiants" class="block rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ $opsPath === 'ops/recherche-etudiants' ? 'bg-[#1b02a4] text-white' : 'text-[#1b1b18] hover:bg-black/5' }}">Recherche étudiants</a>
                        <a href="/ops/rattrapage-filiere" class="block rounded-lg px-3 py-2 text-sm font-medium transition-colors {{ str_starts_with($opsPath, 'ops/rattrapage-filiere') ? 'bg-[#1b02a4] text-white' : 'text-[#1b1b18] hover:bg-black/5' }}">Rattrapage filière</a>
                    </nav>

                    <div class="mt-auto pt-6">
                        <div class="h-px bg-black/10 mb-4"></div>

                        <form method="POST" action="/ops/logout">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-black/10">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <div class="flex-1 p-6">
                <div class="lg:hidden mb-4">
                    <div class="bg-white/95 backdrop-blur shadow-lg ring-1 ring-black/10 rounded-2xl px-4 py-3 flex items-center justify-between">
                        <button type="button" id="opsMobileSidebarOpen" class="inline-flex items-center justify-center rounded-lg px-3 py-2 text-sm font-medium text-[#1b1b18] transition-colors hover:bg-black/5 focus:outline-none focus:ring-2 focus:ring-black/10">
                            Menu
                        </button>
                        <img src="{{ asset('assets/brand/logo2.png') }}" alt="" class="h-10 w-auto" />
                    </div>
                </div>
                <main class="relative w-full max-w-7xl mx-auto bg-white/95 backdrop-blur shadow-lg ring-1 ring-black/10 rounded-2xl p-6 sm:p-8">
                    @yield('content')
                </main>
            </div>
        </div>

        <script>
            (function () {
                const mobileSidebar = document.getElementById('opsMobileSidebar');
                const openBtn = document.getElementById('opsMobileSidebarOpen');
                const closeBtn = document.getElementById('opsMobileSidebarClose');
                const backdrop = document.getElementById('opsMobileSidebarBackdrop');

                function openSidebar() {
                    if (!mobileSidebar) return;
                    mobileSidebar.classList.remove('hidden');
                }

                function closeSidebar() {
                    if (!mobileSidebar) return;
                    mobileSidebar.classList.add('hidden');
                }

                openBtn?.addEventListener('click', openSidebar);
                closeBtn?.addEventListener('click', closeSidebar);
                backdrop?.addEventListener('click', closeSidebar);
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') closeSidebar();
                });
            })();
        </script>
    </body>
</html>
