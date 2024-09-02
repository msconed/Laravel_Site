<?php

namespace App\Http\Middleware;

use App\Http\Controllers\MiscController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class LocaleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $language = session('language');
        if (!isset($language))
        {
            session(['language' => 'ru']);
        }
        
        if (Auth::check())
        {
            $language = Auth::user()->locale;
            session(['language' => $language]);
        }

        app()->setLocale(session('language'));
        return $next($request);
    }
}
