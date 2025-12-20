@extends('layout')

@section('title', $product->name)

@section('content')
<div class="container">
    <!-- زر الرجوع -->
    <div class="mb-4">
        <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
           class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> {{ __('messages.back_to_products') }}
        </a>
    </div>

    <!-- بطاقة تفاصيل المنتج -->
    <div class="card shadow-lg">
        <div class="row g-0">
            <!-- قسم الصورة -->
            <div class="col-md-6">
                @if($product->image && file_exists(public_path('images/products/' . $product->image)))
                    <img src="{{ asset('images/products/' . $product->image) }}"
                         class="img-fluid rounded-start"
                         alt="{{ $product->name }}"
                         style="width: 100%; height: 500px; object-fit: cover;">
                @else
                    <div class="d-flex align-items-center justify-content-center bg-light"
                         style="height: 500px;">
                        <div class="text-center">
                            <i class="fas fa-image fa-5x text-secondary mb-3"></i>
                            <p class="text-muted">{{ __('messages.no_image_available') }}</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- قسم التفاصيل -->
            <div class="col-md-6">
                <div class="card-body p-5">
                    <!-- العنوان -->
                    <h1 class="card-title display-6 mb-4">{{ $product->name }}</h1>

                    <!-- الوصف -->
                    <div class="mb-4">
                        <h5 class="text-muted mb-3">
                            <i class="fas fa-align-left me-2"></i>
                            {{ __('messages.description') }}:
                        </h5>
                        <p class="card-text lead">{{ $product->description }}</p>
                    </div>

                    <!-- معلومات المنتج -->
                    <div class="mb-4">
                        <h5 class="text-muted mb-3">
                            <i class="fas fa-info-circle me-2"></i>
                            {{ __('messages.product_details') }}:
                        </h5>
                        <ul class="list-unstyled">
                            <li class="mb-2">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                <strong>{{ __('messages.created_at') }}:</strong>
                                @if($product->created_at)
                                    {{ $product->created_at->format('Y-m-d H:i') }}
                                @else
                                    {{ __('messages.not_available') }}
                                @endif
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-clock text-primary me-2"></i>
                                <strong>{{ __('messages.last_updated') }}:</strong>
                                @if($product->updated_at)
                                    {{ $product->updated_at->diffForHumans() }}
                                @else
                                    {{ __('messages.not_available') }}
                                @endif
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-id-card text-primary me-2"></i>
                                <strong>{{ __('messages.product_id') }}:</strong>
                                #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}
                            </li>
                            <li class="mb-2">
                                <i class="fas fa-database text-primary me-2"></i>
                                <strong>{{ __('messages.status') }}:</strong>
                                <span class="badge bg-success">{{ __('messages.active') }}</span>
                            </li>
                            @if($product->image)
                            <li class="mb-2">
                                <i class="fas fa-file-image text-primary me-2"></i>
                                <strong>{{ __('messages.has_image') }}:</strong>
                                <span class="badge bg-info">{{ __('messages.yes') }}</span>
                            </li>
                            @endif
                        </ul>
                    </div>

                    <!-- أزرار الإجراءات -->
                    <div class="mt-5 pt-4 border-top">
                        <div class="d-flex gap-2 flex-wrap">
                            <!-- زر عرض جميع المنتجات -->
                            <a href="{{ route('products.index', ['locale' => app()->getLocale()]) }}"
                               class="btn btn-outline-secondary">
                                <i class="fas fa-list me-2"></i> {{ __('messages.all_products') }}
                            </a>

                            <!-- زر التعديل -->
                            <a href="{{ route('products.edit', ['product' => $product, 'locale' => app()->getLocale()]) }}"
                               class="btn btn-primary">
                                <i class="fas fa-edit me-2"></i> {{ __('messages.edit_product') }}
                            </a>

                            <!-- زر الحذف مع Modal -->
                            <button type="button" class="btn btn-danger"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i> {{ __('messages.delete_product') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تأكيد الحذف -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- رأس الـ Modal -->
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ __('messages.confirm_delete') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <!-- جسم الـ Modal -->
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ __('messages.delete_warning') }}
                </div>

                <div class="mb-3">
                    <p class="mb-1"><strong>{{ __('messages.product_name') }}:</strong></p>
                    <p class="fs-5">{{ $product->name }}</p>

                    <p class="mb-1"><strong>{{ __('messages.product_id') }}:</strong></p>
                    <p class="text-muted">#{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</p>

                    @if($product->created_at)
                    <p class="mb-1"><strong>{{ __('messages.created_at') }}:</strong></p>
                    <p class="text-muted">{{ $product->created_at->format('Y-m-d') }}</p>
                    @endif
                </div>

                <div class="alert alert-danger">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('messages.delete_irreversible') }}
                </div>
            </div>

            <!-- تذييل الـ Modal -->
            <div class="modal-footer">
                <!-- زر الإلغاء -->
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>
                    {{ __('messages.cancel') }}
                </button>

                <!-- زر تأكيد الحذف -->
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
@endsection

@push('styles')
<style>
    .rounded-start {
        border-top-left-radius: 0.375rem !important;
        border-bottom-left-radius: 0.375rem !important;
    }

    @media (max-width: 767px) {
        .rounded-start {
            border-top-left-radius: 0.375rem !important;
            border-top-right-radius: 0.375rem !important;
            border-bottom-left-radius: 0 !important;
        }
    }

    .card {
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    }

    .card-body {
        background-color: #fff;
    }

    .badge {
        font-size: 0.85em;
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 500;
    }

    .bg-success {
        background-color: #28a745 !important;
    }

    .bg-info {
        background-color: #17a2b8 !important;
    }

    .lead {
        line-height: 1.8;
        color: #555;
    }

    .modal-content {
        border-radius: 15px;
        overflow: hidden;
        border: none;
    }

    .modal-header {
        border-bottom: 2px solid rgba(255, 255, 255, 0.1);
    }

    .modal-footer {
        border-top: 1px solid #dee2e6;
    }

    .btn {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-outline-secondary {
        border: 2px solid #6c757d;
        color: #6c757d;
    }

    .btn-outline-secondary:hover {
        background-color: #6c757d;
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, #4361ee, #3a56d4);
        border: none;
    }

    .btn-danger {
        background: linear-gradient(135deg, #dc3545, #c82333);
        border: none;
    }
</style>
@endpush

@push('scripts')
<script>
    // إضافة تأثيرات تفاعلية
    document.addEventListener('DOMContentLoaded', function() {
        // تحسين عرض الصورة عند النقر عليها
        const productImage = document.querySelector('.rounded-start');
        if (productImage) {
            productImage.addEventListener('click', function() {
                const modal = document.createElement('div');
                modal.className = 'modal fade';
                modal.id = 'imageModal';
                modal.innerHTML = `
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${this.alt}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body p-0">
                                <img src="${this.src}" class="img-fluid w-100">
                            </div>
                        </div>
                    </div>
                `;

                document.body.appendChild(modal);
                const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
                imageModal.show();

                // تنظيف الـ Modal بعد الإغلاق
                modal.addEventListener('hidden.bs.modal', function() {
                    document.body.removeChild(modal);
                });
            });

            // إضافة مؤشر يد عند التمرير فوق الصورة
            productImage.style.cursor = 'zoom-in';
        }

        // تأكيد الحذف مع إدخال اسم المنتج للتأكيد
        const deleteForm = document.querySelector('form[method="POST"][action*="destroy"]');
        if (deleteForm) {
            deleteForm.addEventListener('submit', function(e) {
                const productName = "{{ $product->name }}";
                const confirmation = prompt(
                    `{{ __('messages.type_to_confirm') }} "${productName}"`,
                    ''
                );

                if (confirmation !== productName) {
                    e.preventDefault();
                    alert('{{ __("messages.cancelled_deletion") }}');
                    return false;
                }
            });
        }

        // إضافة رسالة عند محاولة مغادرة الصفحة أثناء التعديل
        let isModified = false;
        const editLink = document.querySelector('a[href*="edit"]');
        if (editLink) {
            editLink.addEventListener('click', function() {
                isModified = true;
            });
        }

        window.addEventListener('beforeunload', function(e) {
            if (isModified) {
                e.preventDefault();
                e.returnValue = '';
                return '{{ __("messages.unsaved_changes") }}';
            }
        });
    });
</script>
@endpush
