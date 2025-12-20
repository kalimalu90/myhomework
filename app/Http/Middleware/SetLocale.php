<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        // اللغة من الـ URL
        $locale = $request->route('locale');

        // اللغات المدعومة
        if (!in_array($locale, ['ar', 'en'])) {
            $locale = config('app.locale', 'ar');
        }

        // تطبيق اللغة
        App::setLocale($locale);
        Carbon::setLocale($locale);

        return $next($request);
    }
}
