@extends('layout')

@section('title', __('messages.products'))

@section('content')
    <h1>{{ __('messages.products_list') }}</h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary mb-3">{{ __('messages.add_product') }}</a>

    <div class="row">
        @foreach($products as $product)
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="{{ asset('images/products/' . $product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text">{{ Str::limit($product->description, 100) }}</p>
                    <a href="{{ route('products.show', $product) }}" class="btn btn-info">{{ __('messages.view_details') }}</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
