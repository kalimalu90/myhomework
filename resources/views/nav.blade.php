<nav class="navbar minimalist-nav" role="navigation" aria-label="القائمة الرئيسية">
    <div class="nav-container">
        <!-- اللوجو في الطرف -->
        <div class="brand-logo" aria-label="الصفحة الرئيسية" role="button" tabindex="0">
            <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <circle cx="16" cy="16" r="14" stroke="currentColor" stroke-width="2"/>
                <path d="M16 8L22 20H10L16 8Z" fill="currentColor"/>
            </svg>
            <span class="brand-name">MyApp</span>
        </div>

        <!-- الروابط في الوسط -->
        <div class="nav-center">
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/') }}" class="nav-link" title="الرئيسية">
                <i class="fas fa-home" aria-hidden="true"></i>
                <span class="link-text">{{ __('messages.home') }}</span>
            </a>
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/products') }}" class="nav-link" title="المنتجات">
                <i class="fas fa-box-open" aria-hidden="true"></i>
                <span class="link-text">{{ __('messages.products') }}</span>
            </a>
        </div>

        <!-- تغيير اللغات في الطرف الآخر -->
        <div class="nav-right">
            <!-- زر تبديل الثيم -->
            <div class="theme-toggle-container">
                <button class="theme-toggle" id="themeToggle" aria-label="تبديل الثيم">
                    <i class="fas fa-sun" aria-hidden="true"></i>
                    <i class="fas fa-moon" aria-hidden="true"></i>
                    <span class="theme-dot"></span>
                </button>
                <div class="theme-dropdown" id="themeDropdown">
                    <button class="theme-option" data-theme="light">
                        <i class="fas fa-sun" aria-hidden="true"></i>
                        <span>فاتح</span>
                        <i class="fas fa-check check-icon" aria-hidden="true"></i>
                    </button>
                    <button class="theme-option" data-theme="dark">
                        <i class="fas fa-moon" aria-hidden="true"></i>
                        <span>غامق</span>
                        <i class="fas fa-check check-icon" aria-hidden="true"></i>
                    </button>
                    <button class="theme-option" data-theme="auto">
                        <i class="fas fa-adjust" aria-hidden="true"></i>
                        <span>تلقائي</span>
                        <i class="fas fa-check check-icon" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
            
            <div class="language-switcher" role="region" aria-label="مبدل اللغة">
                @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <button class="lang-switch {{ $localeCode === app()->getLocale() ? 'active' : '' }}"
                       data-lang="{{ $localeCode }}"
                       aria-label="{{ __('messages.switch_to') ?? 'تغيير اللغة إلى' }} {{ $properties['native'] }}"
                       lang="{{ $localeCode }}">
                        <span class="lang-code">{{ strtoupper($localeCode) }}</span>
                        <span class="lang-check">
                            <i class="fas fa-check" aria-hidden="true"></i>
                        </span>
                    </button>
                @endforeach
            </div>
            
            <!-- زر القائمة المنسدلة للجوال -->
            <button class="mobile-menu-btn" id="mobileMenuBtn" aria-label="فتح القائمة" aria-expanded="false" aria-controls="mobileMenu">
                <span class="menu-icon">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </span>
            </button>
        </div>
    </div>
    
    <!-- القائمة المنسدلة للجوال -->
    <div class="mobile-menu" id="mobileMenu" aria-hidden="true" aria-label="قائمة الجوال">
        <div class="mobile-menu-header">
            <h3>القائمة</h3>
            <button class="mobile-close-btn" id="mobileCloseBtn" aria-label="إغلاق القائمة">
                <i class="fas fa-times" aria-hidden="true"></i>
            </button>
        </div>
        
        <div class="mobile-menu-body">
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/') }}" class="mobile-nav-link" title="الرئيسية">
                <div class="mobile-nav-icon">
                    <i class="fas fa-home" aria-hidden="true"></i>
                </div>
                <div class="mobile-nav-content">
                    <span class="mobile-nav-title">{{ __('messages.home') }}</span>
                    <span class="mobile-nav-desc">{{ __('messages.go_home') }}</span>
                </div>
                <i class="fas fa-chevron-left mobile-nav-arrow" aria-hidden="true"></i>
            </a>
            
            <a href="{{ LaravelLocalization::getLocalizedURL(app()->getLocale(), '/products') }}" class="mobile-nav-link" title="المنتجات">
                <div class="mobile-nav-icon">
                    <i class="fas fa-box-open" aria-hidden="true"></i>
                </div>
                <div class="mobile-nav-content">
                    <span class="mobile-nav-title">{{ __('messages.products') }}</span>
                    <span class="mobile-nav-desc">{{ __('messages.browse_products') }}</span>
                </div>
                <i class="fas fa-chevron-left mobile-nav-arrow" aria-hidden="true"></i>
            </a>
            
            <div class="mobile-menu-section">
                <h4>اللغة</h4>
                <div class="mobile-language-switcher" role="region" aria-label="مبدل اللغة للجوال">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <button class="mobile-lang-switch {{ $localeCode === app()->getLocale() ? 'active' : '' }}"
                           data-lang="{{ $localeCode }}"
                           lang="{{ $localeCode }}">
                            <span class="lang-code">{{ strtoupper($localeCode) }}</span>
                            <span class="lang-name">{{ $properties['native'] }}</span>
                            <span class="lang-check">
                                <i class="fas fa-check" aria-hidden="true"></i>
                            </span>
                        </button>
                    @endforeach
                </div>
            </div>
            
            <div class="mobile-menu-section">
                <h4>{{__('messages.theme')}}</h4>
                <div class="mobile-theme-switcher">
                    <button class="mobile-theme-option" data-theme="light">
                        <i class="fas fa-sun" aria-hidden="true"></i>
                        <span>{{ __('messages.light') }}</span>
                        <i class="fas fa-check check-icon" aria-hidden="true"></i>
                    </button>
                    <button class="mobile-theme-option" data-theme="dark">
                        <i class="fas fa-moon" aria-hidden="true"></i>
                        <span>{{ __('messages.dark') }}</span>
                        <i class="fas fa-check check-icon" aria-hidden="true"></i>
                    </button>
                    <button class="mobile-theme-option" data-theme="auto">
                        <i class="fas fa-adjust" aria-hidden="true"></i>
                        <span>{{ __('messages.auto') }}</span>
                        <i class="fas fa-check check-icon" aria-hidden="true"></i>
                    </button>
                </div>
            </div>
        </div>
        
        <div class="mobile-menu-footer">
            <div class="app-version">الإصدار 1.0.0</div>
        </div>
    </div>
    
    <!-- Overlay للقائمة المنسدلة -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
</nav>
<!-- ربط css حيث مسارة resources/css/nav.css -->
<link rel="stylesheet" href="{{ url('/css/nav.css') }}">
<script src="{{ url('/js/nav.js') }}" defer></script>