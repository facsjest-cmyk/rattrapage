<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->hasSession()) {
            return $next($request);
        }

        $locale = $request->session()->get('locale');

        if (is_string($locale) && in_array($locale, ['fr', 'ar'], true)) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
