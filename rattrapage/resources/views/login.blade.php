<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ __('messages.login.title') }}</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen text-[#1b1b18]">
        <div class="min-h-screen relative isolate flex items-center justify-center p-6">
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
                <div class="absolute inset-0 bg-[#cfe9ff]/50"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-[#cfe9ff]/15 via-transparent to-[#cfe9ff]/30"></div>
            </div>

            <main class="relative w-full max-w-md bg-white/95 backdrop-blur shadow-lg ring-1 ring-black/10 rounded-2xl p-6 sm:p-8">
                <div class="mb-6 text-center">
                    <img
                        src="{{ asset('assets/brand/logo.png') }}"
                        alt=""
                        class="mx-auto h-20 sm:h-24 w-auto max-w-[370px] sm:max-w-[400px] object-contain"
                    />

                    <div class="relative mt-3 flex items-center justify-center">
                        <h1 class="text-xl font-semibold leading-tight">{{ __('messages.login.heading') }}</h1>

                        <form method="POST" action="/locale/{{ app()->getLocale() === 'ar' ? 'fr' : 'ar' }}" class="absolute inset-y-0 end-0 flex items-center">
                            @csrf
                            <button type="submit" class="text-xs font-medium rounded-full border border-[#1b02a4]/20 bg-white px-3 py-1 text-[#1b02a4] transition-colors hover:bg-[#1b02a4]/5 active:bg-[#1b02a4]/10 focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/25">
                                {{ app()->getLocale() === 'ar' ? __('messages.locale.fr') : __('messages.locale.ar') }}
                            </button>
                        </form>
                    </div>
                </div>

                @if (session('auth_message'))
                    <div class="mb-4 p-3 rounded-lg bg-amber-50 text-amber-900 text-sm ring-1 ring-amber-900/10">
                        {{ session('auth_message') }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="mb-4 p-3 rounded-lg bg-green-50 text-green-800 text-sm ring-1 ring-green-900/10">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="/login" novalidate>
                    @csrf

                    <div class="mb-4">
                        <label for="code_apogee" class="block text-sm font-medium mb-1">
                            {{ __('messages.login.fields.code') }}
                        </label>
                        <input
                            id="code_apogee"
                            name="code_apogee"
                            type="text"
                            value="{{ old('code_apogee') }}"
                            class="w-full rounded-lg border border-black/15 bg-white px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-black/10"
                            @if ($errors->has('code_apogee')) autofocus @endif
                            @if ($errors->has('code_apogee')) aria-describedby="code_apogee_error" @endif
                            aria-invalid="{{ $errors->has('code_apogee') ? 'true' : 'false' }}"
                        />
                        @error('code_apogee')
                            <p id="code_apogee_error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-5">
                        <label for="date_naissance" class="block text-sm font-medium mb-1">
                            {{ __('messages.login.fields.dob') }}
                        </label>
                        <input
                            id="date_naissance"
                            name="date_naissance"
                            type="date"
                            dir="ltr"
                            value="{{ old('date_naissance') }}"
                            class="w-full rounded-lg border border-black/15 bg-white px-3 py-2.5 focus:outline-none focus:ring-2 focus:ring-black/10"
                            @if (!$errors->has('code_apogee') && $errors->has('date_naissance')) autofocus @endif
                            @if ($errors->has('date_naissance')) aria-describedby="date_naissance_error" @endif
                            aria-invalid="{{ $errors->has('date_naissance') ? 'true' : 'false' }}"
                        />
                        @error('date_naissance')
                            <p id="date_naissance_error" class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="w-full rounded-lg bg-[#1b02a4] text-white py-2.5 font-medium transition-all hover:bg-[#16028a] active:bg-[#120273] active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#1b02a4]/35">
                        {{ __('messages.login.actions.submit') }}
                    </button>
                </form>
            </main>
        </div>
    </body>
</html>
