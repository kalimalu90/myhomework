@extends('layout')

@section('title', __('messages.add_product'))

@section('content')
<div class="container">
    <h1 class="mb-4">{{ __('messages.add_product') }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store', ['locale' => app()->getLocale()]) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">{{ __('messages.product_name') }}</label>
            <input type="text" class="form-control" id="name" name="name"
                   value="{{ old('name') }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">{{ __('messages.description') }}</label>
            <textarea class="form-control" id="description" name="description"
                      rows="3" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="image" class="form-label">{{ __('messages.image') }}</label>
            <input type="file" class="form-control" id="image" name="image" required>
            @error('image')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">{{ __('messages.save') }}</button>
        <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
           class="btn btn-secondary">{{ __('messages.cancel') }}</a>
    </form>
</div>
@endsection
