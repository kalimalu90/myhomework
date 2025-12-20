# دليل الإعداد التفصيلي - Detailed Setup Guide

هذا الملف يحتوي على تعليمات مفصلة لإعداد وتشغيل تطبيق منتجات Laravel على جهازك المحلي.

## المتطلبات الأساسية

### 1. Node.js و npm/pnpm

يجب تثبيت Node.js على جهازك. يمكنك التحقق من وجوده بتشغيل:

```bash
node --version
npm --version
```

إذا لم يكن مثبتاً، قم بتحميله من [nodejs.org](https://nodejs.org/).

### 2. قاعدة البيانات

يتطلب التطبيق قاعدة بيانات MySQL. يمكنك:

- تثبيت MySQL محلياً من [mysql.com](https://www.mysql.com/)
- أو استخدام خدمة سحابية مثل AWS RDS أو DigitalOcean Managed Databases

### 3. محرر نصوص

استخدم أي محرر نصوص تفضله مثل:

- Visual Studio Code (موصى به)
- Sublime Text
- WebStorm
- أو أي محرر آخر

## خطوات الإعداد

### الخطوة 1: استنساخ المشروع

```bash
# استنساخ المستودع
git clone https://github.com/yourusername/laravel-product-app.git

# الدخول إلى مجلد المشروع
cd laravel-product-app
```

### الخطوة 2: تثبيت المكتبات

استخدم pnpm (الموصى به):

```bash
pnpm install
```

أو استخدم npm:

```bash
npm install
```

### الخطوة 3: إنشاء ملف البيئة

أنشئ ملف `.env` في جذر المشروع:

```bash
# على Linux/Mac
touch .env

# على Windows
type nul > .env
```

أضف المحتوى التالي:

```env
# قاعدة البيانات
DATABASE_URL="mysql://root:password@localhost:3306/product_app"

# المفاتيح السرية
JWT_SECRET="your-super-secret-jwt-key-change-this"

# معرف التطبيق (احصل عليه من لوحة التحكم)
VITE_APP_ID="your-app-id-here"

# عناوين OAuth
OAUTH_SERVER_URL="https://api.manus.im"
VITE_OAUTH_PORTAL_URL="https://portal.manus.im"

# معلومات المالك
OWNER_NAME="Your Name"
OWNER_OPEN_ID="your-open-id"
```

### الخطوة 4: إعداد قاعدة البيانات

أولاً، تأكد من أن خادم MySQL يعمل:

```bash
# على Linux
sudo systemctl start mysql

# على Mac
brew services start mysql

# على Windows
# ابدأ MySQL من لوحة التحكم أو Command Prompt
```

ثم أنشئ قاعدة البيانات:

```bash
# الاتصال بـ MySQL
mysql -u root -p

# داخل MySQL shell
CREATE DATABASE product_app;
EXIT;
```

### الخطوة 5: تطبيق الهجرات

شغّل أمر الهجرات لإنشاء الجداول:

```bash
pnpm db:push
```

هذا الأمر سيقوم بـ:

1. توليد ملفات الهجرة من schema.ts
2. تطبيق الهجرات على قاعدة البيانات
3. إنشاء جداول `users` و `products`

### الخطوة 6: تشغيل التطبيق

ابدأ خادم التطوير:

```bash
pnpm dev
```

ستظهر رسالة مثل:

```
Server running on http://localhost:3000/
```

افتح المتصفح وانتقل إلى `http://localhost:3000`

## التحقق من التثبيت

للتأكد من أن كل شيء يعمل بشكل صحيح:

### 1. تحقق من الاتصال بقاعدة البيانات

```bash
# في الطرفية، تحقق من عدم وجود أخطاء في رسائل الخادم
# يجب أن ترى: "[Database] Connected successfully"
```

### 2. تحقق من الصفحات

- الصفحة الرئيسية: `http://localhost:3000/`
- قائمة المنتجات: `http://localhost:3000/products`
- إضافة منتج: `http://localhost:3000/create`

### 3. اختبر الترجمات

- انقر على قائمة اللغة في الـ Navbar
- تبديل بين العربية والإنجليزية
- تحقق من أن النصوص تتغير

### 4. اختبر إضافة منتج

1. انتقل إلى صفحة "إضافة منتج"
2. أدخل اسم منتج (3 أحرف على الأقل)
3. أدخل وصف (10 أحرف على الأقل)
4. اختر صورة (JPG أو PNG، أقل من 2MB)
5. انقر على "إضافة المنتج"
6. يجب أن تظهر رسالة نجاح وتنتقل إلى قائمة المنتجات

## استكشاف الأخطاء الشائعة

### خطأ: "Cannot find module 'mysql2'"

**الحل**: تأكد من تثبيت المكتبات:

```bash
pnpm install
```

### خطأ: "connect ECONNREFUSED 127.0.0.1:3306"

**الحل**: تأكد من أن MySQL يعمل:

```bash
# على Linux
sudo systemctl status mysql

# على Mac
brew services list
```

### خطأ: "Unknown database 'product_app'"

**الحل**: أنشئ قاعدة البيانات:

```bash
mysql -u root -p -e "CREATE DATABASE product_app;"
```

### خطأ: "Access denied for user 'root'@'localhost'"

**الحل**: تحقق من كلمة المرور في `.env`:

```env
DATABASE_URL="mysql://root:YOUR_PASSWORD@localhost:3306/product_app"
```

### الصور لا تظهر

**الحل**: تأكد من أن:

1. الصورة بصيغة JPG أو PNG
2. حجم الصورة أقل من 2MB
3. لا توجد أخطاء في الطرفية

## أوامر مفيدة

| الأمر | الوصف |
|------|-------|
| `pnpm dev` | تشغيل خادم التطوير |
| `pnpm build` | بناء المشروع للإنتاج |
| `pnpm start` | تشغيل المشروع المبني |
| `pnpm db:push` | تطبيق الهجرات |
| `pnpm test` | تشغيل الاختبارات |
| `pnpm check` | التحقق من TypeScript |
| `pnpm format` | تنسيق الكود |

## الخطوات التالية

بعد الإعداد الناجح:

1. **استكشف الكود**: تصفح ملفات المشروع لفهم البنية
2. **اقرأ التعليقات**: تحتوي الملفات على تعليقات مفيدة
3. **جرب الميزات**: اختبر جميع وظائف التطبيق
4. **أضف ميزات جديدة**: طور التطبيق حسب احتياجاتك

## الدعم

إذا واجهت مشاكل:

1. تحقق من رسائل الخطأ في الطرفية
2. ابحث عن الحل في قسم استكشاف الأخطاء أعلاه
3. تحقق من ملف README.md
4. تواصل مع فريق الدعم

---

**ملاحظة**: هذا الدليل مخصص لبيئة التطوير. للنشر في الإنتاج، اتبع إجراءات أمان إضافية.
