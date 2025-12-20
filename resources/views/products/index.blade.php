@extends('layout')

@section('title', __('messages.products'))

@section('content')
<div class="container">
    <!-- العنوان ورز إضافة منتج -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="mb-1">
                <i class="fas fa-boxes me-2 text-primary"></i>
                {{ __('messages.products') }}
            </h1>
            <p class="text-muted mb-0">
                {{ __('messages.manage_products') }}
            </p>
        </div>

        <a href="{{ route('products.create', ['locale' => app()->getLocale()]) }}"
           class="btn btn-primary btn-lg shadow">
            <i class="fas fa-plus-circle me-2"></i>
            {{ __('messages.add_product') }}
        </a>
    </div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- بطاقة الإحصائيات -->
    @if($products->count() > 0)
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">{{ __('messages.total_products') }}</h6>
                            <h2 class="mb-0">{{ $products->count() }}</h2>
                        </div>
                        <i class="fas fa-box-open fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">{{ __('messages.with_images') }}</h6>
                            <h2 class="mb-0">{{ $products->where('image', '!=', null)->where('image', '!=', '')->count() }}</h2>
                        </div>
                        <i class="fas fa-image fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">{{ __('messages.today_added') }}</h6>
                            <h2 class="mb-0">{{ $products->filter(function($product) {
                                return $product->created_at && $product->created_at->isToday();
                            })->count() }}</h2>
                        </div>
                        <i class="fas fa-calendar-plus fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-dark shadow-sm">
                <div class="card-body py-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="card-title mb-0">{{ __('messages.this_week') }}</h6>
                            <h2 class="mb-0">{{ $products->filter(function($product) {
                                return $product->created_at && $product->created_at->isCurrentWeek();
                            })->count() }}</h2>
                        </div>
                        <i class="fas fa-chart-line fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- شريط البحث والتصفية -->
    <div class="card shadow-sm mb-4">
        <div class="card-body p-3">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" class="form-control"
                               placeholder="{{ __('messages.search_products') }}"
                               id="searchInput">
                    </div>
                </div>
                <div class="col-md-4 mt-2 mt-md-0">
                    <div class="d-flex justify-content-end">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-secondary active"
                                    id="gridViewBtn" title="{{ __('messages.grid_view') }}">
                                <i class="fas fa-th-large"></i>
                            </button>
                            <button type="button" class="btn btn-outline-secondary"
                                    id="listViewBtn" title="{{ __('messages.list_view') }}">
                                <i class="fas fa-list"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- قائمة المنتجات -->
    @if($products->count() > 0)
    <div id="productsContainer" class="row">
        @foreach($products as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4 product-card">
            <div class="card h-100 shadow-sm border-0 product-item">
                <!-- صورة المنتج -->
                <div class="position-relative" style="height: 200px; overflow: hidden;">
                    @if($product->image && file_exists(public_path('images/products/' . $product->image)))
                        <img src="{{ asset('images/products/' . $product->image) }}"
                             class="card-img-top"
                             alt="{{ $product->name }}"
                             style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light"
                             style="height: 100%;">
                            <i class="fas fa-image fa-3x text-secondary opacity-50"></i>
                        </div>
                    @endif

                    <!-- شارة المنتج الجديد (مع التحقق من null) -->
                    @if($product->created_at && $product->created_at->diffInDays(now()) <= 7)
                    <span class="position-absolute top-0 start-0 m-2 badge bg-success">
                        <i class="fas fa-star me-1"></i> {{ __('messages.new') }}
                    </span>
                    @endif

                    <!-- تاريخ الإضافة (مع التحقق من null) -->
                    @if($product->created_at)
                    <span class="position-absolute bottom-0 start-0 m-2">
                        <small class="text-white bg-dark bg-opacity-50 px-2 py-1 rounded">
                            {{ $product->created_at->format('Y-m-d') }}
                        </small>
                    </span>
                    @endif
                </div>

                <!-- جسم البطاقة -->
                <div class="card-body d-flex flex-column">
                    <!-- اسم المنتج -->
                    <h5 class="card-title mb-2 text-truncate" title="{{ $product->name }}">
                        {{ $product->name }}
                    </h5>

                    <!-- الوصف -->
                    <p class="card-text flex-grow-1 text-muted small mb-3">
                        {{ Str::limit($product->description, 80) }}
                    </p>

                    <!-- معلومات إضافية -->
                    <div class="mb-3">
                        <div class="d-flex justify-content-between small text-muted">
                            <div>
                                <i class="fas fa-id-card me-1"></i>
                                #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}
                            </div>
                            <div>
                                <i class="fas fa-clock me-1"></i>
                                <!-- التحقق من null لـ updated_at -->
                                @if($product->updated_at)
                                    {{ $product->updated_at->diffForHumans() }}
                                @elseif($product->created_at)
                                    {{ $product->created_at->diffForHumans() }}
                                @else
                                    {{ __('messages.unknown_time') }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- تذييل البطاقة مع أزرار الإجراءات -->
                <div class="card-footer bg-white border-top-0 pt-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <!-- زر العرض التفصيلي -->
                        <a href="{{ route('products.show', ['product' => $product, 'locale' => app()->getLocale()]) }}"
                           class="btn btn-sm btn-outline-info"
                           title="{{ __('messages.view_details') }}">
                            <i class="fas fa-eye me-1"></i>
                            <span class="d-none d-md-inline">{{ __('messages.view') }}</span>
                        </a>

                        <!-- زر التعديل -->
                        <a href="{{ route('products.edit', ['product' => $product, 'locale' => app()->getLocale()]) }}"
                           class="btn btn-sm btn-outline-primary"
                           title="{{ __('messages.edit') }}">
                            <i class="fas fa-edit me-1"></i>
                            <span class="d-none d-md-inline">{{ __('messages.edit') }}</span>
                        </a>

                        <!-- زر الحذف مع Modal -->
                        <button type="button" class="btn btn-sm btn-outline-danger"
                                data-bs-toggle="modal"
                                data-bs-target="#deleteModal{{ $product->id }}"
                                title="{{ __('messages.delete') }}">
                            <i class="fas fa-trash me-1"></i>
                            <span class="d-none d-md-inline">{{ __('messages.delete') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal تأكيد الحذف لكل منتج -->
        <div class="modal fade" id="deleteModal{{ $product->id }}" tabindex="-1"
             aria-labelledby="deleteModalLabel{{ $product->id }}" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel{{ $product->id }}">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            {{ __('messages.confirm_delete') }}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning mb-3">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ __('messages.delete_warning') }}
                        </div>

                        <div class="text-center mb-4">
                            @if($product->image && file_exists(public_path('images/products/' . $product->image)))
                                <img src="{{ asset('images/products/' . $product->image) }}"
                                     alt="{{ $product->name }}"
                                     class="img-thumbnail mb-3"
                                     style="max-height: 150px;">
                            @endif

                            <h5>{{ $product->name }}</h5>
                            <p class="text-muted small mb-0">
                                {{ __('messages.product_id') }}: #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}
                            </p>
                            @if($product->created_at)
                            <p class="text-muted small">
                                {{ __('messages.created') }}: {{ $product->created_at->format('Y-m-d') }}
                            </p>
                            @endif
                        </div>

                        <div class="alert alert-danger">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('messages.delete_irreversible') }}
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>
                            {{ __('messages.cancel') }}
                        </button>
                        <form action="{{ route('products.destroy', ['product' => $product, 'locale' => app()->getLocale()]) }}"
                              method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>
                                {{ __('messages.confirm_delete_btn') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- رسالة عدم وجود منتجات -->
    @else
    <div class="text-center py-5">
        <div class="mb-4">
            <i class="fas fa-box-open fa-5x text-secondary opacity-50"></i>
        </div>
        <h3 class="text-muted mb-3">{{ __('messages.no_products_found') }}</h3>
        <p class="text-muted mb-4">{{ __('messages.add_first_product_message') }}</p>
        <a href="{{ route('products.create', ['locale' => app()->getLocale()]) }}"
           class="btn btn-primary btn-lg px-4">
            <i class="fas fa-plus-circle me-2"></i>
            {{ __('messages.add_first_product') }}
        </a>
    </div>
    @endif
</div>

<!-- Button لتحميل المزيد -->
@if($products->count() >= 8)
<div class="text-center mt-4 mb-5">
    <button class="btn btn-outline-primary" id="loadMoreBtn">
        <i class="fas fa-spinner d-none me-2"></i>
        {{ __('messages.load_more') }}
    </button>
</div>
@endif
@endsection

@push('styles')
<link rel="stylesheet" href="{{ asset('css/index_pro.css') }}">
@endpush

@push('scripts')
<script src="{{ asset('js/index_pro.js') }}"></script>
@endpush
