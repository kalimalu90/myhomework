<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// مجموعة المسارات مع دعم متعدد اللغات
Route::group([
    'prefix' => LaravelLocalization::setLocale(),
    'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']
], function () {
    
    // الصفحة الرئيسية
    Route::get('/h', function () {
        return view('home');
    })->name('home');
    // صفحة الاختبار ترد ملف test.php ليست test.blade.php
    Route::get('/', function () {
        return view('test');
    })->name('test');
    

    // موارد المنتجات
    Route::resource('products', ProductController::class);
    

});

// مسار تغيير اللغة (خارج المجموعة لتجنب التعارض)
Route::get('/change-locale/{locale}', function ($locale) {
    if (in_array($locale, ['ar', 'en'])) {
        session(['locale' => $locale]);
        app()->setLocale($locale);
    }
    return redirect()->back();
})->name('change.locale');