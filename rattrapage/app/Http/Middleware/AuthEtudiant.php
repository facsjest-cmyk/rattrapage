<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthEtudiant
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->hasSession()) {
            return redirect('/')->with('auth_message', __('messages.auth.must_login'));
        }

        $codEtu = $request->session()->get('cod_etu');

        if (is_string($codEtu) && $codEtu !== '') {
            return $next($request);
        }

        $sessionCookieName = config('session.cookie');

        $messageKey = $request->hasCookie($sessionCookieName)
            ? 'messages.auth.session_expired'
            : 'messages.auth.must_login';

        return redirect('/')->with('auth_message', __($messageKey));
    }
}
