<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;

class OpsAuthController extends Controller
{
    public function showLogin()
    {
        return view('ops.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (auth()->attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $intended = $request->session()->pull('ops.intended');

            return redirect()->to($intended ?: '/ops/liste-etudiants');
        }

        return back()
            ->withErrors(['email' => 'Identifiants invalides.'])
            ->onlyInput('email');
    }

    public function logout(Request $request)
    {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/ops/login');
    }
}
