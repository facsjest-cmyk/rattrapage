<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Symfony\Component\HttpFoundation\Response;

class ThrottleLogin
{
    public function handle(Request $request, Closure $next): Response
    {
        $key = 'login:'.$request->ip();

        if (RateLimiter::tooManyAttempts($key, 5)) {
            return $this->buildLimitedResponse($request);
        }

        RateLimiter::hit($key, 60);

        return $next($request);
    }

    private function buildLimitedResponse(Request $request): RedirectResponse
    {
        return back()->withErrors([
            'code_apogee' => __('messages.login.errors.throttle'),
        ])->withInput();
    }
}
