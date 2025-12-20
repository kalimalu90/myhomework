document.addEventListener('DOMContentLoaded', function() {
        // البحث عن المنتجات
        const searchInput = document.getElementById('searchInput');
        const productCards = document.querySelectorAll('.product-card');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase().trim();
                let hasVisibleResults = false;

                productCards.forEach(card => {
                    const productName = card.querySelector('.card-title').textContent.toLowerCase();
                    const productDesc = card.querySelector('.card-text').textContent.toLowerCase();

                    if (productName.includes(searchTerm) || productDesc.includes(searchTerm)) {
                        card.style.display = 'block';
                        hasVisibleResults = true;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // إظهار رسالة إذا لم توجد نتائج
                if (!hasVisibleResults && searchTerm !== '') {
                    const noResults = document.createElement('div');
                    noResults.className = 'col-12 text-center py-5';
                    noResults.innerHTML = `
                        <i class="fas fa-search fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">{{ __('messages.no_results') }}</h4>
                        <p class="text-muted">{{ __('messages.try_different_keywords') }}</p>
                    `;

                    const container = document.getElementById('productsContainer');
                    const existingMessage = container.querySelector('.no-results-message');
                    if (existingMessage) {
                        existingMessage.remove();
                    }

                    noResults.classList.add('no-results-message');
                    container.appendChild(noResults);
                } else {
                    const existingMessage = document.querySelector('.no-results-message');
                    if (existingMessage) {
                        existingMessage.remove();
                    }
                }
            });
        }

        // تبديل بين العرض الشبكي والقائمة
        const gridViewBtn = document.getElementById('gridViewBtn');
        const listViewBtn = document.getElementById('listViewBtn');
        const productsContainer = document.getElementById('productsContainer');

        if (gridViewBtn && listViewBtn && productsContainer) {
            gridViewBtn.addEventListener('click', function() {
                this.classList.add('active');
                listViewBtn.classList.remove('active');
                productsContainer.classList.remove('list-view');
                productsContainer.classList.add('row');

                document.querySelectorAll('.product-card').forEach(card => {
                    card.className = 'col-xl-3 col-lg-4 col-md-6 mb-4 product-card';
                    card.querySelector('.product-item').classList.remove('flex-row');
                    card.querySelector('.product-item').style.height = '';

                    const imgDiv = card.querySelector('.position-relative');
                    if (imgDiv) {
                        imgDiv.style.width = '';
                        imgDiv.style.height = '200px';
                    }
                });
            });

            listViewBtn.addEventListener('click', function() {
                this.classList.add('active');
                gridViewBtn.classList.remove('active');
                productsContainer.classList.remove('row');
                productsContainer.classList.add('list-view');

                document.querySelectorAll('.product-card').forEach(card => {
                    card.className = 'col-12 mb-3 product-card';
                    card.querySelector('.product-item').classList.add('flex-row');
                    card.querySelector('.product-item').style.height = '150px';

                    const imgDiv = card.querySelector('.position-relative');
                    if (imgDiv) {
                        imgDiv.style.width = '150px';
                        imgDiv.style.height = '100%';
                    }
                });
            });
        }

        // تحميل المزيد
        const loadMoreBtn = document.getElementById('loadMoreBtn');
        if (loadMoreBtn) {
            loadMoreBtn.addEventListener('click', function() {
                const spinner = this.querySelector('.fas.fa-spinner');
                spinner.classList.remove('d-none');

                setTimeout(() => {
                    spinner.classList.add('d-none');
                    this.disabled = true;
                    this.innerHTML = '<i class="fas fa-check me-2"></i> {{ __("messages.all_products_loaded") }}';
                    this.classList.remove('btn-outline-primary');
                    this.classList.add('btn-success');
                }, 1000);
            });
        }
    });