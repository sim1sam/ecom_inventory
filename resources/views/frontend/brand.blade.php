@extends('frontend.layouts.app')

@section('title', $brand->name . ' - Jewellery Brand Collection')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $brand->name }}</li>
        </ol>
    </nav>

    <!-- Brand Header -->
    <div class="brand-header text-center mb-5">
        @if($brand->logo)
        <div class="brand-logo mb-4">
            <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}" class="img-fluid">
        </div>
        @endif
        
        <h1 class="brand-title mb-3">{{ $brand->name }}</h1>
        
        @if($brand->description)
        <p class="brand-description text-muted lead">{{ $brand->description }}</p>
        @endif
        
        <div class="brand-stats">
            <span class="badge bg-primary fs-6">{{ $products->total() }} Products</span>
            @if($brand->founded_year)
            <span class="badge bg-secondary fs-6 ms-2">Est. {{ $brand->founded_year }}</span>
            @endif
        </div>
    </div>

    <!-- Brand Story Section -->
    @if($brand->story)
    <div class="brand-story mb-5">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto">
                <div class="story-content bg-light p-4 rounded">
                    <h3 class="mb-3">Our Story</h3>
                    <div class="story-text">
                        {!! $brand->story !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Featured Categories for this Brand -->
    @if($brandCategories->count() > 0)
    <div class="brand-categories mb-5">
        <h3 class="mb-4">Shop {{ $brand->name }} by Category</h3>
        <div class="row">
            @foreach($brandCategories as $category)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="category-card">
                    <a href="{{ route('products', ['brand' => $brand->id, 'category' => $category->slug]) }}" class="text-decoration-none">
                        <div class="category-image">
                            @if($category->image)
                                <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid">
                            @else
                                <div class="placeholder-image d-flex align-items-center justify-content-center">
                                    <i class="fas fa-gem fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="category-info text-center p-3">
                            <h5 class="category-name mb-2">{{ $category->name }}</h5>
                            <p class="text-muted small mb-0">{{ $category->products->where('brand_id', $brand->id)->count() }} items</p>
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Filters and Sorting -->
    <div class="products-toolbar mb-4">
        <div class="row align-items-center">
            <div class="col-md-6">
                <!-- Removed duplicate showing text -->
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-md-end gap-3">
                    <!-- Price Filter -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-filter me-2"></i>Price Range
                        </button>
                        <div class="dropdown-menu p-3" style="min-width: 250px;">
                            <form id="priceFilterForm">
                                <div class="mb-3">
                                    <label class="form-label small">Price Range</label>
                                    <div class="d-flex gap-2">
                                        <input type="number" class="form-control form-control-sm" 
                                               placeholder="Min" id="minPrice" name="min_price">
                                        <input type="number" class="form-control form-control-sm" 
                                               placeholder="Max" id="maxPrice" name="max_price">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary btn-sm w-100">Apply Filter</button>
                            </form>
                        </div>
                    </div>
                    
                    <!-- View Toggle -->
                    <div class="view-toggle">
                        <button class="btn btn-outline-secondary btn-sm view-btn active" data-view="grid">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm view-btn" data-view="list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    
                    <!-- Sort Dropdown -->
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-sort me-2"></i>Sort by
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item sort-option" href="#" data-sort="name_asc">Name (A-Z)</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="name_desc">Name (Z-A)</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="price_asc">Price (Low to High)</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="price_desc">Price (High to Low)</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="newest">Newest First</a></li>
                            <li><a class="dropdown-item sort-option" href="#" data-sort="rating">Highest Rated</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Grid -->
    <div class="products-container">
        @if($products->count() > 0)
            <div class="row" id="productsGrid">
                @foreach($products as $product)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4 product-item">
                    <div class="product-card h-100">
                        <div class="product-image-container position-relative">
                            <a href="{{ route('product-detail', ['slug' => $product->slug]) }}">
                                <img src="{{ $product->thumb_image ? asset($product->thumb_image) : asset('frontend/images/default-product.svg') }}" 
                                     alt="{{ $product->name }}" 
                                     class="product-image img-fluid">
                            </a>
                            
                            @if($product->offer_price && $product->offer_price < $product->price)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                {{ round((($product->price - $product->offer_price) / $product->price) * 100) }}% OFF
                            </span>
                            @endif
                            
                            <!-- Brand Badge -->
                            <span class="badge bg-dark position-absolute bottom-0 start-0 m-2">
                                {{ $brand->name }}
                            </span>
                            
                            <div class="product-actions position-absolute top-0 end-0 m-2">
                                <button class="btn btn-sm btn-light rounded-circle mb-2 wishlist-btn" 
                                        data-product-id="{{ $product->id }}" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <button class="btn btn-sm btn-light rounded-circle quick-view-btn" 
                                        data-product-id="{{ $product->id }}" title="Quick View">
                                    <i class="fas fa-eye"></i>
                                </button>
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
                            
                            <!-- Rating -->
                            <div class="product-rating mb-2">
                                @php
                                    $rating = $product->reviews->avg('rating') ?? 0;
                                    $fullStars = floor($rating);
                                    $hasHalfStar = ($rating - $fullStars) >= 0.5;
                                @endphp
                                
                                <div class="d-flex align-items-center">
                                    <div class="stars me-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $fullStars)
                                                <i class="fas fa-star text-warning small"></i>
                                            @elseif($i == $fullStars + 1 && $hasHalfStar)
                                                <i class="fas fa-star-half-alt text-warning small"></i>
                                            @else
                                                <i class="far fa-star text-muted small"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="rating-text text-muted small">
                                        ({{ $product->reviews->count() }})
                                    </span>
                                </div>
                            </div>
                            
                            <div class="product-price mb-3">
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
                @endforeach
            </div>
            
            <!-- Pagination -->
            @if($products->hasPages())
            <div class="pagination-wrapper">
                {{ $products->appends(request()->query())->links() }}
            </div>
            @endif
        @else
            <div class="text-center py-5">
                <i class="fas fa-gem fa-4x text-muted mb-4"></i>
                <h4 class="text-muted mb-3">No products found for {{ $brand->name }}</h4>
                <p class="text-muted mb-4">Check back later for new arrivals from this brand.</p>
                <a href="{{ route('products') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Browse All Products
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.brand-header {
    padding: 40px 0;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    border-radius: 12px;
    margin-bottom: 40px;
}

.brand-logo img {
    max-height: 120px;
    max-width: 300px;
    object-fit: contain;
}

.brand-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #333;
}

.brand-description {
    max-width: 600px;
    margin: 0 auto;
}

.brand-story {
    margin: 50px 0;
}

.story-content {
    border-left: 4px solid var(--primary-color);
}

.story-text {
    line-height: 1.8;
    color: #666;
}

.category-card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
    height: 100%;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: var(--primary-color);
}

.category-image {
    height: 180px;
    overflow: hidden;
}

.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-card:hover .category-image img {
    transform: scale(1.05);
}

.placeholder-image {
    height: 180px;
    background: #f8f9fa;
}

.category-name {
    color: #333;
    font-weight: 600;
}

.products-toolbar {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #e9ecef;
}

.view-toggle .view-btn {
    border-radius: 0;
}

.view-toggle .view-btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.view-toggle .view-btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
    border-left: none;
}

.view-toggle .view-btn.active {
    background-color: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
}

.product-card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    transition: all 0.3s ease;
    background: white;
    overflow: hidden;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    border-color: var(--primary-color);
}

.product-image-container {
    height: 250px;
    overflow: hidden;
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

.product-actions {
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-actions {
    opacity: 1;
}

.product-actions .btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.current-price {
    color: var(--primary-color) !important;
}

.add-to-cart-btn {
    transition: all 0.3s ease;
}

.add-to-cart-btn:hover {
    transform: translateY(-2px);
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

/* List View Styles */
.list-view .product-item {
    width: 100% !important;
    flex: 0 0 100%;
    max-width: 100%;
}

.list-view .product-card {
    display: flex;
    flex-direction: row;
    height: auto;
}

.list-view .product-image-container {
    width: 200px;
    height: 200px;
    flex-shrink: 0;
}

.list-view .product-info {
    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

@media (max-width: 768px) {
    .brand-title {
        font-size: 2rem;
    }
    
    .products-toolbar {
        padding: 15px;
    }
    
    .products-toolbar .row {
        flex-direction: column;
        gap: 15px;
    }
    
    .list-view .product-card {
        flex-direction: column;
    }
    
    .list-view .product-image-container {
        width: 100%;
        height: 250px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle functionality
    const viewButtons = document.querySelectorAll('.view-btn');
    const productsGrid = document.getElementById('productsGrid');
    
    viewButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            viewButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const view = this.dataset.view;
            if (view === 'list') {
                productsGrid.classList.add('list-view');
            } else {
                productsGrid.classList.remove('list-view');
            }
        });
    });
    
    // Price filter functionality
    document.getElementById('priceFilterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const minPrice = document.getElementById('minPrice').value;
        const maxPrice = document.getElementById('maxPrice').value;
        
        const url = new URL(window.location);
        if (minPrice) url.searchParams.set('min_price', minPrice);
        if (maxPrice) url.searchParams.set('max_price', maxPrice);
        
        window.location.href = url.toString();
    });
    
    // Sort functionality
    const sortOptions = document.querySelectorAll('.sort-option');
    
    sortOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const sortBy = this.dataset.sort;
            
            const url = new URL(window.location);
            url.searchParams.set('sort', sortBy);
            window.location.href = url.toString();
        });
    });
    
    // Add to cart functionality removed - only available on product details page
    
    // Add to wishlist functionality
    const wishlistButtons = document.querySelectorAll('.wishlist-btn');
    
    wishlistButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            const icon = this.querySelector('i');
            
            if (icon.classList.contains('far')) {
                icon.classList.remove('far');
                icon.classList.add('fas');
                this.classList.add('text-danger');
                showNotification('Added to wishlist!', 'success');
            } else {
                icon.classList.remove('fas');
                icon.classList.add('far');
                this.classList.remove('text-danger');
                showNotification('Removed from wishlist!', 'info');
            }
        });
    });
    
    function addToCart(productId) {
        // Implement your add to cart logic here
        showNotification('Product added to cart!', 'success');
    }
    
    function showNotification(message, type) {
        const notification = document.createElement('div');
        notification.className = `alert alert-${type} position-fixed`;
        notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
        notification.innerHTML = `
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                ${message}
            </div>
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.remove();
        }, 3000);
    }
});
</script>
@endsection