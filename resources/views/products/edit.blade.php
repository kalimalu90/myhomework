@extends('layout')

@section('title', __('messages.edit_product'))

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            {{ __('messages.edit_product') }}
                        </h4>
                        <a href="{{ route('products.show', ['product' => $product, 'locale' => app()->getLocale()]) }}"
                           class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left"></i> {{ __('messages.back') }}
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('products.update', ['product' => $product, 'locale' => app()->getLocale()]) }}"
                          method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold">
                                <i class="fas fa-tag me-2 text-primary"></i>
                                {{ __('messages.product_name') }}
                            </label>
                            <input type="text" class="form-control form-control-lg @error('name') is-invalid @enderror"
                                   id="name" name="name"
                                   value="{{ old('name', $product->name) }}"
                                   placeholder="{{ __('messages.enter_product_name') }}"
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="fas fa-align-left me-2 text-primary"></i>
                                {{ __('messages.description') }}
                            </label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                      id="description" name="description"
                                      rows="6"
                                      placeholder="{{ __('messages.enter_description') }}"
                                      required>{{ old('description', $product->description) }}</textarea>
                            <div class="form-text">
                                {{ __('messages.min_chars') }}: 10
                            </div>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">
                                <i class="fas fa-image me-2 text-primary"></i>
                                {{ __('messages.current_image') }}
                            </label>
                            <div class="mb-3">
                                @if($product->image && file_exists(public_path('images/products/' . $product->image)))
                                    <div class="text-center">
                                        <img src="{{ asset('images/products/' . $product->image) }}"
                                             alt="{{ $product->name }}"
                                             class="img-thumbnail mb-2"
                                             style="max-height: 200px;">
                                        <p class="text-muted small">
                                            {{ __('messages.current_image_size') }}:
                                            @if(file_exists(public_path('images/products/' . $product->image)))
                                                {{ round(filesize(public_path('images/products/' . $product->image)) / 1024, 2) }} KB
                                            @else
                                                {{ __('messages.size_unknown') }}
                                            @endif
                                        </p>
                                    </div>
                                @else
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        {{ __('messages.no_image_available') }}
                                    </div>
                                @endif
                            </div>

                            <label for="image" class="form-label fw-bold">
                                <i class="fas fa-upload me-2 text-primary"></i>
                                {{ __('messages.change_image') }}
                            </label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror"
                                   id="image" name="image"
                                   accept="image/jpg,image/png">
                            <div class="form-text">
                                {{ __('messages.image_requirements') }}
                            </div>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- معلومات المنتج -->
                        <div class="card border-info mb-4">
                            <div class="card-header bg-info text-white py-2">
                                <i class="fas fa-info-circle me-2"></i>
                                {{ __('messages.product_info') }}
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="fas fa-calendar-alt text-info me-2"></i>
                                            <strong>{{ __('messages.created_at') }}:</strong>
                                            @if($product->created_at)
                                                {{ $product->created_at->format('Y-m-d H:i') }}
                                            @else
                                                {{ __('messages.not_available') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="fas fa-clock text-info me-2"></i>
                                            <strong>{{ __('messages.last_updated') }}:</strong>
                                            @if($product->updated_at)
                                                {{ $product->updated_at->diffForHumans() }}
                                            @else
                                                {{ __('messages.not_available') }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="fas fa-id-card text-info me-2"></i>
                                            <strong>{{ __('messages.product_id') }}:</strong>
                                            #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-2">
                                            <i class="fas fa-database text-info me-2"></i>
                                            <strong>{{ __('messages.status') }}:</strong>
                                            <span class="badge bg-success">{{ __('messages.active') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- أزرار الإجراءات -->
                        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
                            <div>
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="fas fa-save me-2"></i>
                                    {{ __('messages.update_product') }}
                                </button>

                                <a href="{{ route('products.show', ['product' => $product, 'locale' => app()->getLocale()]) }}"
                                   class="btn btn-outline-secondary ms-2">
                                    <i class="fas fa-times me-2"></i>
                                    {{ __('messages.cancel') }}
                                </a>
                            </div>

                            <!-- زر الحذف -->
                            <button type="button" class="btn btn-outline-danger"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="fas fa-trash me-2"></i>
                                {{ __('messages.delete_product') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تأكيد الحذف -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteModalLabel">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    {{ __('messages.confirm_delete') }}
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ __('messages.delete_warning') }}
                </div>

                <p class="mb-2"><strong>{{ __('messages.product_name') }}:</strong> {{ $product->name }}</p>
                <p class="mb-3"><strong>{{ __('messages.product_id') }}:</strong> #{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}</p>

                <p class="text-danger fw-bold">
                    <i class="fas fa-info-circle me-2"></i>
                    {{ __('messages.delete_irreversible') }}
                </p>
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
@endsection

@push('styles')
<style>
    .form-control:focus, .form-select:focus {
        border-color: #4361ee;
        box-shadow: 0 0 0 0.25rem rgba(67, 97, 238, 0.25);
    }

    .card {
        border-radius: 15px;
        overflow: hidden;
    }

    .card-header {
        border-radius: 15px 15px 0 0 !important;
    }

    .img-thumbnail {
        max-width: 100%;
        height: auto;
        border: 3px solid #dee2e6;
        border-radius: 10px;
    }

    .badge {
        font-size: 0.8em;
        padding: 5px 10px;
        border-radius: 20px;
    }
</style>
@endpush

@push('scripts')
<script>
    // عرض معاينة الصورة قبل التحميل
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.createElement('div');
                preview.className = 'text-center mt-3';
                preview.innerHTML = `
                    <p class="fw-bold">{{ __('messages.image_preview') }}:</p>
                    <img src="${e.target.result}" class="img-thumbnail" style="max-height: 150px;">
                    <p class="text-muted small mt-2">
                        ${file.name} (${(file.size / 1024).toFixed(2)} KB)
                    </p>
                `;

                // إزالة المعاينة السابقة إذا كانت موجودة
                const oldPreview = document.getElementById('image-preview');
                if (oldPreview) oldPreview.remove();

                preview.id = 'image-preview';
                document.querySelector('input[name="image"]').after(preview);
            }
            reader.readAsDataURL(file);
        }
    });

    // تأكيد قبل مغادرة الصفحة إذا كانت هناك تغييرات
    let formChanged = false;
    const form = document.querySelector('form');
    const formInputs = form.querySelectorAll('input, textarea, select');

    formInputs.forEach(input => {
        input.addEventListener('input', () => {
            formChanged = true;
        });
    });

    window.addEventListener('beforeunload', (e) => {
        if (formChanged) {
            e.preventDefault();
            e.returnValue = '';
        }
    });

    // إرسال الفورم عند الضغط على Ctrl+Enter
    document.addEventListener('keydown', function(e) {
        if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
            form.submit();
        }
    });
</script>
@endpush
