<?php

if (!function_exists('set_app_locale')) {
    function set_app_locale(string $locale): bool
    {
        if (!in_array($locale, ['ar', 'en'])) {
            return false;
        }

        app()->setLocale($locale);
        session(['locale' => $locale]);
        \Carbon\Carbon::setLocale($locale);

        return true;
    }
}

if (!function_exists('get_app_locale')) {
    function get_app_locale(): string
    {
        // الأولوية للـ URL
        return request()->route('locale')
            ?? app()->getLocale()
            ?? 'ar';
    }
}
function locale_route($name, $params = [])
{
    return route($name, array_merge(
        ['locale' => app()->getLocale()],
        $params
    ));
}
