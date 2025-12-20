<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function changeLocale($locale)
    {
        if (set_app_locale($locale)) {
            return redirect()->back()->with('success',
                $locale == 'ar'
                    ? 'تم تغيير اللغة إلى العربية بنجاح'
                    : 'Language changed to English successfully'
            );
        }

        return redirect()->back()->with('error', 'اللغة غير مدعومة');
    }
}
