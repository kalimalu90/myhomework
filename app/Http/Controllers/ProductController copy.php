<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
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
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images/products'), $imageName);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imageName
        ]);

        return redirect()->route('products.index')
            ->with('success', trans('messages.product_created'));
    }

    public function show(Product $product)
    {
        $currentLocale = LaravelLocalization::getCurrentLocale();
        return view('products.show', compact('product', 'currentLocale'));
    }
}
