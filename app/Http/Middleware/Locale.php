<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;

class Locale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        date_default_timezone_set('Asia/Dubai');
        if ($request->hasHeader("Accept-Language")) {
            App::setLocale($request->header("Accept-Language"));
        } else {
            $locale = $request->session()->get('Accept-Language');
            if ($locale !== null && in_array($locale, config('app.locales'))) {
                App::setLocale($locale);
            }
            if ($locale === null) {
                $request->session()->put('Accept-Language',config('app.locale'));
            }
        }
        return $next($request);
    }
}
