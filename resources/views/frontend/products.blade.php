@extends('frontend.layouts.app')

@section('title', 'Products - Jewellery Collection')

@section('content')
<div class="container-fluid px-0">
    <!-- Page Header -->
    <div class="page-header bg-light py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="page-title mb-2">All Products</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6 text-md-end">
                    <!-- Removed duplicate product count -->
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <!-- Sidebar Filters -->
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="filters-sidebar">
                    <div class="filter-section mb-4">
                        <h5 class="filter-title">Categories</h5>
                        <div class="filter-options">
                            @foreach($categories as $category)
                            <div class="form-check">
                                <input class="form-check-input category-filter" type="checkbox" 
                                       value="{{ $category->id }}" id="cat{{ $category->id }}"
                                       {{ request('category') == $category->id ? 'checked' : '' }}>
                                <label class="form-check-label" for="cat{{ $category->id }}">
                                    {{ $category->name }}
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Brands filter removed per request -->
                    <div class="filter-section mb-4" style="display:none;"></div>

                    <div class="filter-section mb-4">
                        <h5 class="filter-title">Price Range</h5>
                        <div class="price-range">
                            <div class="row">
                                <div class="col-6">
                                    <input type="number" class="form-control" id="minPrice" 
                                           placeholder="Min" value="{{ request('min_price') }}">
                                </div>
                                <div class="col-6">
                                    <input type="number" class="form-control" id="maxPrice" 
                                           placeholder="Max" value="{{ request('max_price') }}">
                                </div>
                            </div>
                            <button class="btn btn-outline-primary btn-sm mt-2 w-100" id="applyPriceFilter">
                                Apply Price Filter
                            </button>
                        </div>
                    </div>

                    <div class="filter-section mb-4">
                        <h5 class="filter-title">Rating</h5>
                        <div class="filter-options">
                            @for($i = 5; $i >= 1; $i--)
                            <div class="form-check">
                                <input class="form-check-input rating-filter" type="radio" 
                                       name="rating" value="{{ $i }}" id="rating{{ $i }}"
                                       {{ request('rating') == $i ? 'checked' : '' }}>
                                <label class="form-check-label" for="rating{{ $i }}">
                                    @for($j = 1; $j <= $i; $j++)
                                        <i class="fas fa-star text-warning"></i>
                                    @endfor
                                    @for($j = $i + 1; $j <= 5; $j++)
                                        <i class="far fa-star text-muted"></i>
                                    @endfor
                                    & Up
                                </label>
                            </div>
                            @endfor
                        </div>
                    </div>

                    <button class="btn btn-outline-secondary w-100" id="clearFilters">
                        Clear All Filters
                    </button>
                </div>
            </div>

            <!-- Products Grid -->
            <div class="col-lg-9 col-md-8">
                <!-- Sort and View Options -->
                <div class="products-toolbar d-flex justify-content-between align-items-center mb-4">
                    <div class="view-options">
                        <button class="btn btn-outline-secondary btn-sm view-grid active" data-view="grid">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm view-list" data-view="list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    
                    <div class="sort-options">
                        <select class="form-select" id="sortProducts">
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name A-Z</option>
                            <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Name Z-A</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price High to Low</option>
                            <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                        </select>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="products-grid" id="productsContainer">
                    <div class="row" id="productsList">
                        @forelse($products as $product)
                        <div class="col-lg-4 col-md-6 col-sm-6 mb-4 product-item">
                            <div class="product-card h-100">
                                <div class="product-image-container position-relative">
                                    <a href="{{ route('product-detail', ['slug' => $product->slug]) }}">
                                        <img src="{{ $product->thumb_image ? asset($product->thumb_image) : asset('frontend/images/default-product.svg') }}" 
                                             alt="{{ $product->name }}" class="product-image">
                                    </a>
                                    
                                    @if($product->offer_price && $product->offer_price < $product->price)
                                    <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                        {{ round((($product->price - $product->offer_price) / $product->price) * 100) }}% OFF
                                    </span>
                                    @endif
                                    
                                    <div class="product-overlay">
                                        <div class="product-actions">
                                            <button class="btn btn-light btn-sm add-to-wishlist" 
                                                    data-product-id="{{ $product->id }}">
                                                <i class="far fa-heart"></i>
                                            </button>
                                            <a href="{{ route('product-detail', ['slug' => $product->slug]) }}" 
                                               class="btn btn-light btn-sm">
                                                <i class="fas fa-eye"></i>
                                            </a>

                                        </div>
                                    </div>
                                </div>
                                
                                <div class="product-info p-3">
                                    <div class="product-category text-muted small mb-1">
                                        {{ $product->category->name ?? 'Uncategorized' }}
                                    </div>
                                    <h6 class="product-title mb-2">
                                        <a href="{{ route('product-detail', ['slug' => $product->slug]) }}" 
                                           class="text-decoration-none text-dark">
                                            {{ $product->name }}
                                        </a>
                                    </h6>
                                    
                                    <div class="product-rating mb-2">
                                        @php
                                            $rating = $product->averageRating;
                                            $fullStars = floor($rating);
                                            $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                        @endphp
                                        
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fullStars)
                                                <i class="fas fa-star text-warning"></i>
                                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                <i class="fas fa-star-half-alt text-warning"></i>
                                            @else
                                                <i class="far fa-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="text-muted small ms-1">({{ number_format($rating, 1) }})</span>
                                    </div>
                                    
                                    <div class="product-price">
                                        @if($product->offer_price && $product->offer_price < $product->price)
                                    <span class="current-price fw-bold text-primary">
                                        {{ $setting->currency_icon }}{{ number_format($product->offer_price, 2) }}
                                    </span>
                                    <span class="original-price text-muted text-decoration-line-through ms-2">
                                        {{ $setting->currency_icon }}{{ number_format($product->price, 2) }}
                                    </span>
                                @else
                                    <span class="current-price fw-bold text-primary">
                                        {{ $setting->currency_icon }}{{ number_format($product->price, 2) }}
                                    </span>
                                @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="text-center py-5">
                                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                                <h4 class="text-muted">No products found</h4>
                                <p class="text-muted">Try adjusting your filters or search criteria.</p>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Pagination -->
                @if($products->hasPages())
                <div class="pagination-wrapper">
                    {{ $products->appends(request()->query())->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.filters-sidebar {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.filter-title {
    font-size: 16px;
    font-weight: 600;
    color: #333;
    margin-bottom: 15px;
    padding-bottom: 8px;
    border-bottom: 1px solid #e9ecef;
}

.filter-options {
    max-height: 200px;
    overflow-y: auto;
}

.form-check {
    margin-bottom: 8px;
}

.form-check-label {
    font-size: 14px;
    color: #666;
    cursor: pointer;
}

.products-toolbar {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.view-options .btn {
    margin-right: 5px;
}

.view-options .btn.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.product-card {
    border: 1px solid #e9ecef;
    border-radius: 8px;
    transition: all 0.3s ease;
    background: white;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}

.product-image-container {
    overflow: hidden;
    border-radius: 8px 8px 0 0;
    height: 250px;
}

.product-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image {
    transform: scale(1.05);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-actions {
    display: flex;
    gap: 10px;
}

.product-actions .btn {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.product-title a:hover {
    color: var(--primary-color) !important;
}

.current-price {
    font-size: 18px;
}

.original-price {
    font-size: 14px;
}

.pagination-wrapper {
    display: flex;
    justify-content: center;
    margin-top: 50px;
}

.pagination {
    display: flex;
    gap: 10px;
    align-items: center;
}

.pagination .page-link {
    padding: 10px 15px;
    border: 1px solid #dee2e6;
    color: #6c757d;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
}

.pagination .page-link:hover,
.pagination .page-item.active .page-link {
    background-color: var(--primary-color, #d4af37);
    border-color: var(--primary-color, #d4af37);
    color: white;
}

@media (max-width: 768px) {
    .filters-sidebar {
        margin-bottom: 20px;
    }
    
    .products-toolbar {
        flex-direction: column;
        gap: 15px;
    }
    
    .view-options {
        order: 2;
    }
    
    .sort-options {
        order: 1;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filter functionality
    const categoryFilters = document.querySelectorAll('.category-filter');
    // const brandFilters = document.querySelectorAll('.brand-filter'); // Removed
    const ratingFilters = document.querySelectorAll('.rating-filter');
    const sortSelect = document.getElementById('sortProducts');
    const clearFiltersBtn = document.getElementById('clearFilters');
    const applyPriceBtn = document.getElementById('applyPriceFilter');
    
    // Apply filters
    function applyFilters() {
        const url = new URL(window.location.href);
        const params = new URLSearchParams();
        
        // Category filters
        const selectedCategories = Array.from(categoryFilters)
            .filter(cb => cb.checked)
            .map(cb => cb.value);
        if (selectedCategories.length > 0) {
            params.set('category', selectedCategories.join(','));
        }
        
        // Brand filters removed
        // const selectedBrands = Array.from(brandFilters)
        //     .filter(cb => cb.checked)
        //     .map(cb => cb.value);
        // if (selectedBrands.length > 0) {
        //     params.set('brand', selectedBrands.join(','));
        // }
        
        // Rating filter
        const selectedRating = document.querySelector('.rating-filter:checked');
        if (selectedRating) {
            params.set('rating', selectedRating.value);
        }
        
        // Price range
        const minPrice = document.getElementById('minPrice').value;
        const maxPrice = document.getElementById('maxPrice').value;
        if (minPrice) params.set('min_price', minPrice);
        if (maxPrice) params.set('max_price', maxPrice);
        
        // Sort
        if (sortSelect.value) {
            params.set('sort', sortSelect.value);
        }
        
        // Redirect with filters
        url.search = params.toString();
        window.location.href = url.toString();
    }
    
    // Event listeners
    categoryFilters.forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
    
    // brandFilters.forEach(filter => {
    //     filter.addEventListener('change', applyFilters);
    // });
    
    ratingFilters.forEach(filter => {
        filter.addEventListener('change', applyFilters);
    });
    
    sortSelect.addEventListener('change', applyFilters);
    
    applyPriceBtn.addEventListener('click', applyFilters);
    
    clearFiltersBtn.addEventListener('click', function() {
        window.location.href = '{{ route("products") }}';
    });
    
    // View toggle
    const viewButtons = document.querySelectorAll('[data-view]');
    const productsList = document.getElementById('productsList');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            viewButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            if (this.dataset.view === 'list') {
                productsList.classList.remove('row');
                productsList.classList.add('list-view');
            } else {
                productsList.classList.add('row');
                productsList.classList.remove('list-view');
            }
        });
    });
});
</script>
@endsection