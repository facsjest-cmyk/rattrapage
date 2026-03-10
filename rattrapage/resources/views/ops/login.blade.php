<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Ops - Login</title>

        <link rel="icon" href="{{ asset('favicon.ico') }}" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen text-[#1b1b18]">
        <div class="min-h-screen relative isolate flex items-center justify-center p-6">
            <div class="absolute inset-0 -z-10">
                <img src="{{ asset('assets/brand/login-bg.png') }}" alt="" class="h-full w-full object-cover" />
                <div class="absolute inset-0 opacity-35 mix-blend-multiply" style="background-image: url('{{ asset('assets/brand/bkgbkg.png') }}'); background-repeat: repeat; background-position: center; background-size: min(520px, 46vw) auto;"></div>
                <div class="absolute inset-0 bg-[#cfe9ff]/65"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-[#cfe9ff]/15 via-transparent to-[#cfe9ff]/30"></div>
            </div>

            <main class="relative w-full max-w-md bg-white/95 backdrop-blur shadow-lg ring-1 ring-black/10 rounded-2xl p-6 sm:p-8">
                <div class="flex items-center justify-center mb-5">
                    <img src="{{ asset('assets/brand/logo.png') }}" alt="" class="h-14 w-auto" />
                </div>

                <h1 class="text-xl font-semibold text-center mb-6">Accès administration</h1>

                <form method="POST" action="/ops/login" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium mb-1" for="email">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus class="w-full rounded border border-black/15 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25" />
                        @error('email')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium mb-1" for="password">Mot de passe</label>
                        <input id="password" name="password" type="password" required class="w-full rounded border border-black/15 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25" />
                        @error('password')
                            <div class="mt-1 text-xs text-red-600">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between gap-3">
                        <label class="inline-flex items-center gap-2 text-sm text-[#555]">
                            <input type="checkbox" name="remember" class="rounded border-black/20" />
                            Se souvenir de moi
                        </label>
                    </div>

                    <button type="submit" class="w-full inline-flex items-center justify-center rounded bg-[#1b02a4] text-white px-4 py-2.5 text-sm font-medium transition-all hover:bg-[#16028a] active:bg-[#120273] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35">
                        Se connecter
                    </button>
                </form>
            </main>
        </div>
    </body>
</html>
