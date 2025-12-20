// === حل مشكلة الفلاش (Flash of Unstyled Content) ===
// تطبيق الثيم واللغة فوراً قبل تحميل الصفحة
(function() {
    // قراءة التفضيل المحفوظ للثيم
    const savedTheme = localStorage.getItem('theme') || 'auto';
    
    // تحديد الثيم الحالي
    let currentTheme;
    if (savedTheme === 'auto') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        currentTheme = prefersDark ? 'dark' : 'light';
    } else {
        currentTheme = savedTheme;
    }
    
    // تطبيق الثيم فوراً على html وbody
    document.documentElement.setAttribute('data-theme', currentTheme);
    document.body.classList.add(currentTheme + '-theme');
    
    // قراءة التفضيل المحفوظ للغة
    const savedLang = localStorage.getItem('preferredLang') || 'ar';
    
    // تطبيق اللغة فوراً
    document.documentElement.setAttribute('lang', savedLang);
    document.body.classList.add('lang-' + savedLang);
    
    // تطبيق الاتجاه بناءً على اللغة
    if (savedLang === 'ar') {
        document.documentElement.setAttribute('dir', 'rtl');
        document.body.classList.add('rtl');
    } else {
        document.documentElement.setAttribute('dir', 'ltr');
        document.body.classList.remove('rtl');
    }
    
    // إضافة class للإشارة إلى أن الثيم قد تم تحميله
    document.body.classList.add('theme-loaded');
})();

// === الكود الرئيسي ===
document.addEventListener('DOMContentLoaded', function() {
    // === تهيئة العناصر ===
    const mobileMenuBtn = document.getElementById('mobileMenuBtn');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileOverlay = document.getElementById('mobileOverlay');
    const mobileCloseBtn = document.getElementById('mobileCloseBtn');
    const themeToggle = document.getElementById('themeToggle');
    const themeDropdown = document.getElementById('themeDropdown');
    const navbar = document.querySelector('.navbar.minimalist-nav');
    
    // === تهيئة المتغيرات ===
    let isChangingLanguage = false;
    let lastScroll = 0;
    let ticking = false;
    
    // === تهيئة الثيم ===
    function initTheme() {
        const savedTheme = localStorage.getItem('theme') || 'auto';
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        
        let themeToApply;
        if (savedTheme === 'auto') {
            themeToApply = prefersDark ? 'dark' : 'light';
        } else {
            themeToApply = savedTheme;
        }
        
        applyTheme(themeToApply, savedTheme);
    }
    
    function applyTheme(themeToApply, savedTheme) {
        document.documentElement.setAttribute('data-theme', themeToApply);
        document.body.classList.remove('light-theme', 'dark-theme');
        document.body.classList.add(themeToApply + '-theme');
        localStorage.setItem('theme', savedTheme);
        updateThemeButtons(savedTheme);
        updateThemeToggleIcon(themeToApply);
    }
    
    function updateThemeButtons(theme) {
        document.querySelectorAll('.theme-option').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.theme === theme) {
                btn.classList.add('active');
            }
        });
        
        document.querySelectorAll('.mobile-theme-option').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.theme === theme) {
                btn.classList.add('active');
            }
        });
    }
    
    function updateThemeToggleIcon(theme) {
        if (!themeToggle) return;
        const sunIcon = themeToggle.querySelector('.fa-sun');
        const moonIcon = themeToggle.querySelector('.fa-moon');
        if (sunIcon && moonIcon) {
            sunIcon.style.opacity = theme === 'dark' ? '0.5' : '1';
            moonIcon.style.opacity = theme === 'dark' ? '1' : '0.5';
        }
    }
    
    function setTheme(theme) {
        if (theme === 'auto') {
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            applyTheme(prefersDark ? 'dark' : 'light', theme);
        } else {
            applyTheme(theme, theme);
        }
        
        // إغلاق dropdown
        if (themeDropdown) {
            themeDropdown.classList.remove('show');
        }
    }
    
    // === إضافة مستمعي الأحداث لأزرار الثيم ===
    document.querySelectorAll('.theme-option, .mobile-theme-option').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const theme = btn.dataset.theme;
            setTheme(theme);
            
            // إغلاق القائمة المنسدلة إذا كان زر الجوال
            if (btn.classList.contains('mobile-theme-option')) {
                closeMobileMenu();
            }
        });
    });
    
    // === تهيئة اللغة ===
    function initLanguage() {
        const savedLang = localStorage.getItem('preferredLang') || 'ar';
        applyLanguage(savedLang, false);
    }
    
    function applyLanguage(lang, saveToStorage = true) {
        // تطبيق اللغة فوراً
        document.documentElement.setAttribute('lang', lang);
        document.body.classList.remove('lang-ar', 'lang-en', 'lang-applied');
        document.body.classList.add('lang-' + lang);
        
        // تطبيق الاتجاه
        if (lang === 'ar') {
            document.documentElement.setAttribute('dir', 'rtl');
            document.body.classList.add('rtl');
        } else {
            document.documentElement.setAttribute('dir', 'ltr');
            document.body.classList.remove('rtl');
        }
        
        if (saveToStorage) {
            localStorage.setItem('preferredLang', lang);
        }
        
        updateLanguageButtons(lang);
        
        // إضافة علامة أن اللغة قد طُبقت
        setTimeout(() => {
            document.body.classList.add('lang-applied');
        }, 50);
    }
    
    function updateLanguageButtons(lang) {
        document.querySelectorAll('.lang-switch, .mobile-lang-switch').forEach(btn => {
            btn.classList.remove('active');
            if (btn.dataset.lang === lang) {
                btn.classList.add('active');
            }
        });
    }
    
    async function changeLanguage(lang) {
        if (isChangingLanguage) return;
        isChangingLanguage = true;
        
        // تطبيق اللغة فوراً على localStorage
        localStorage.setItem('preferredLang', lang);
        
        // إغلاق القائمة المنسدلة
        if (mobileMenu && mobileMenu.classList.contains('active')) {
            closeMobileMenu();
        }
        
        // إضافة مؤشر تحميل
        const loader = document.createElement('div');
        loader.id = 'language-loader';
        loader.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, #007bff, #00bcd4);
            z-index: 9999;
            animation: languageLoader 1s infinite;
        `;
        document.body.appendChild(loader);
        
        // إضافة أنيميشن للـ loader
        const style = document.createElement('style');
        style.textContent = `
            @keyframes languageLoader {
                0% { transform: translateX(-100%); }
                100% { transform: translateX(100%); }
            }
        `;
        document.head.appendChild(style);
        
        try {
            // الانتقال إلى الصفحة الجديدة باللغة المطلوبة
            const currentPath = window.location.pathname;
            let cleanPath = currentPath;
            
            // إزالة اللغة الحالية من المسار
            if (currentPath.startsWith('/ar/') || currentPath.startsWith('/en/')) {
                cleanPath = currentPath.substring(3);
            } else if (currentPath === '/ar' || currentPath === '/en') {
                cleanPath = '/';
            }
            
            // بناء URL الجديد مع الحفاظ على query parameters
            const newUrl = `/${lang}${cleanPath}`;
            const fullUrl = newUrl + window.location.search;
            
            // إعادة التحميل الكامل للصفحة
            window.location.href = fullUrl;
            
        } catch (error) {
            console.error('Error changing language:', error);
            
            // إزالة مؤشر التحميل في حالة الخطأ
            if (loader.parentNode) loader.remove();
            if (style.parentNode) style.remove();
            
            isChangingLanguage = false;
        }
    }
    
    // === القائمة المنسدلة للجوال ===
    function openMobileMenu() {
        if (mobileMenu && mobileOverlay && mobileMenuBtn) {
            mobileMenu.classList.add('active');
            mobileOverlay.classList.add('active');
            mobileMenuBtn.setAttribute('aria-expanded', 'true');
            document.body.style.overflow = 'hidden';
        }
    }
    
    function closeMobileMenu() {
        if (mobileMenu && mobileOverlay && mobileMenuBtn) {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
            mobileMenuBtn.setAttribute('aria-expanded', 'false');
            document.body.style.overflow = '';
        }
    }
    
    // === Dropdown الثيم ===
    function toggleThemeDropdown() {
        if (themeDropdown) {
            themeDropdown.classList.toggle('show');
        }
    }
    
    // === تأثير التمرير ===
    function handleScroll() {
        if (!navbar) return;
        
        if (!ticking) {
            window.requestAnimationFrame(() => {
                const currentScroll = window.scrollY;
                
                if (currentScroll > 10) {
                    navbar.classList.add('scrolled');
                } else {
                    navbar.classList.remove('scrolled');
                }
                
                if (currentScroll > lastScroll && currentScroll > 100) {
                    navbar.style.transform = 'translateY(-100%)';
                } else {
                    navbar.style.transform = 'translateY(0)';
                }
                
                lastScroll = currentScroll;
                ticking = false;
            });
            ticking = true;
        }
    }
    
    // === إضافة المستمعين للأحداث ===
    
    // الثيم
    if (themeToggle) {
        themeToggle.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleThemeDropdown();
        });
    }
    
    // إغلاق dropdown
    document.addEventListener('click', (e) => {
        if (themeToggle && themeDropdown && 
            !themeToggle.contains(e.target) && 
            !themeDropdown.contains(e.target)) {
            themeDropdown.classList.remove('show');
        }
    });
    
    // اللغة
    document.querySelectorAll('.lang-switch, .mobile-lang-switch').forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            const lang = btn.dataset.lang;
            changeLanguage(lang);
        });
    });
    
    // القائمة المنسدلة
    if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openMobileMenu);
    if (mobileCloseBtn) mobileCloseBtn.addEventListener('click', closeMobileMenu);
    if (mobileOverlay) mobileOverlay.addEventListener('click', closeMobileMenu);
    
    // مفتاح Escape
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            if (mobileMenu && mobileMenu.classList.contains('active')) {
                closeMobileMenu();
            }
            if (themeDropdown && themeDropdown.classList.contains('show')) {
                themeDropdown.classList.remove('show');
            }
        }
    });
    
    // التمرير
    window.addEventListener('scroll', handleScroll, { passive: true });
    
    // اللوجو
    const brandLogo = document.querySelector('.brand-logo');
    if (brandLogo) {
        brandLogo.addEventListener('click', (e) => {
            e.preventDefault();
            const lang = localStorage.getItem('preferredLang') || 'ar';
            window.location.href = `/${lang}/`;
        });
        
        brandLogo.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                const lang = localStorage.getItem('preferredLang') || 'ar';
                window.location.href = `/${lang}/`;
            }
        });
    }
    
    // === التهيئة النهائية ===
    initTheme();
    initLanguage();
    
    // الاستماع لتغير تفضيلات النظام
    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'auto') {
            setTheme('auto');
        }
    });
    
    // تحسين تحميل Font Awesome
    if (!document.querySelector('link[href*="font-awesome"]')) {
        const faLink = document.createElement('link');
        faLink.rel = 'stylesheet';
        faLink.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
        faLink.media = 'print';
        faLink.onload = function() {
            faLink.media = 'all';
        };
        document.head.appendChild(faLink);
    }
});