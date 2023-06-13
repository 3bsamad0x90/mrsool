<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class webLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        date_default_timezone_set('Africa/Cairo');
        if ($request->hasHeader("lang")) {
            App::setLocale($request->header("lang"));
        } else {
            $locale = $request->session()->get('Lang');
            if ($locale !== null && in_array($locale, config('app.locales'))) {
                App::setLocale($locale);
            }
            if ($locale === null) {
                $request->session()->put('Lang', config('app.locale'));
            }
        }
        return $next($request);
    }
}
