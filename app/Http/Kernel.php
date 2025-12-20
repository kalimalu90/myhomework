protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // إضافة Laravel Localization Middleware هنا
        \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    ],

    'api' => [
        // ...
    ],
];
protected $routeMiddleware = [
    // ... middlewares أخرى موجودة

    'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
    'localizationRedirect' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
    'localeViewPath' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationViewPath::class,
    'locale' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
    'setlocale' => \App\Http\Middleware\SetLocale::class,
    'localeSessionRedirect' => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
    'localize' => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,

];
'web' => [
    \App\Http\Middleware\EncryptCookies::class,
    \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
    \Illuminate\Session\Middleware\StartSession::class, // ← يجب أن يكون قبل SetLocale
    \Illuminate\View\Middleware\ShareErrorsFromSession::class,
    \App\Http\Middleware\SetLocale::class, // ← يأتي بعد StartSession
    \App\Http\Middleware\VerifyCsrfToken::class,
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
],
protected $middlewareGroups = [
    'web' => [
        \App\Http\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\View\Middleware\ShareErrorsFromSession::class,
        \App\Http\Middleware\VerifyCsrfToken::class,
        \Illuminate\Routing\Middleware\SubstituteBindings::class,

        // أضف الـ Middleware هنا
        \App\Http\Middleware\SetLocale::class,
    ],

    'api' => [
        // ...
    ],
];
