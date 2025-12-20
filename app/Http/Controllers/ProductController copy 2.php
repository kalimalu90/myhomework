<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $currentLocale = LaravelLocalization::getCurrentLocale();

        return view('products.index', compact('products', 'currentLocale'));
    }

    public function create()
    {
        $currentLocale = LaravelLocalization::getCurrentLocale();

        return view('products.create', compact('currentLocale'));
    }

    public function store(ProductRequest $request)
    {
        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('images/products'), $imageName);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName,
        ]);

        return redirect()->route('products.index')
            ->with('success', trans('messages.product_created'));
    }

    public function show(Product $product)
    {
        $currentLocale = LaravelLocalization::getCurrentLocale();

        return view('products.show', compact('product', 'currentLocale'));
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // قواعد التحقق
        $rules = [
            'name' => 'required|min:3',
            'description' => 'required|min:10',
        ];

        // إذا رفع المستخدم صورة جديدة، أضف قواعد الصورة
        if ($request->hasFile('image')) {
            $rules['image'] = 'image|mimes:jpg,png|max:2048';
        }

        $validated = $request->validate($rules);

        // تحديث البيانات الأساسية
        $product->name = $request->name;
        $product->description = $request->description;

        // إذا تم رفع صورة جديدة
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة إذا كانت موجودة
            if ($product->image && file_exists(public_path('images/products/'.$product->image))) {
                unlink(public_path('images/products/'.$product->image));
            }

            // حفظ الصورة الجديدة
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('images/products'), $imageName);
            $product->image = $imageName;
        }

        // حفظ التغييرات
        $product->save();

        // رسالة النجاح بناءً على اللغة
        $message = app()->getLocale() == 'ar'
            ? 'تم تحديث المنتج بنجاح'
            : 'Product updated successfully';

        return redirect()->route('products.show', ['product' => $product, 'locale' => app()->getLocale()])
            ->with('success', $message);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // حذف الصورة من السيرفر إذا كانت موجودة
        if ($product->image && file_exists(public_path('images/products/'.$product->image))) {
            unlink(public_path('images/products/'.$product->image));
        }

        // حذف المنتج من قاعدة البيانات
        $product->delete();

        // رسالة النجاح بناءً على اللغة
        $message = app()->getLocale() == 'ar'
            ? 'تم حذف المنتج بنجاح'
            : 'Product deleted successfully';

        return redirect()->route('products.index', ['locale' => app()->getLocale()])
            ->with('success', $message);
    }

    public function changeLocale($locale)
    {
        // التحقق من اللغات المدعومة
        $supportedLocales = ['ar', 'en'];

        if (in_array($locale, $supportedLocales)) {
            // 1. حفظ اللغة في الجلسة
            session(['locale' => $locale]);

            // 2. تطبيق اللغة فوراً
            app()->setLocale($locale);

            // 3. تعيين Carbon locale للتواريخ
            \Carbon\Carbon::setLocale($locale);

            // 4. حفظ الاتجاه في الجلسة
            $direction = $locale == 'ar' ? 'rtl' : 'ltr';
            session(['dir' => $direction]);

            // 5. رسالة النجاح باللغة الجديدة
            $message = $locale == 'ar'
                ? 'تم تغيير اللغة إلى العربية بنجاح'
                : 'Language changed to English successfully';

            return redirect()->back()->with('success', $message);
        }

        return redirect()->back()->with('error', 'اللغة غير مدعومة / Language not supported');
    }
}
