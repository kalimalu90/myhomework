<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguageController extends Controller
{
    public function switchLang($lang)
    {
        if (!in_array($lang, ['ar', 'en'])) {
            $lang = 'en';
        }

        session()->put('locale', $lang);

        return redirect()->to(LaravelLocalization::getLocalizedURL($lang));
    }
}   
