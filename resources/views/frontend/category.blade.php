@extends('frontend.layouts.app')

@section('title', $category->name . ' - Jewellery Collection')

@section('content')
<style>
/* Simple dropdown solution - Completely rewritten */
.sort-dropdown-container {
    position: relative;
    display: inline-block;
    z-index: 1000;
    isolation: isolate;
}

.sort-btn {
    position: relative;
    z-index: 1001;
    cursor: pointer;
    background: white;
    border: 1px solid #dee2e6;
}

.sort-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1002;
    min-width: 12rem;
    padding: 0.5rem 0;
    margin: 0;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.15);
    list-style: none;
    margin-top: 2px;
}

.sort-item {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    color: #212529;
    text-decoration: none;
    border: none;
    background: none;
    cursor: pointer;
    transition: background-color 0.15s ease-in-out;
}

.sort-item:hover {
    background-color: #f8f9fa;
    color: #212529;
    text-decoration: none;
}

.sort-dropdown .dropdown-item {
    display: block;
    width: 100%;
    padding: 0.375rem 1rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    text-decoration: none;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    cursor: pointer;
}

.sort-dropdown .dropdown-item:hover {
    background-color: #f8f9fa;
}

.custom-dropdown-menu .dropdown-item:hover,
.custom-dropdown-menu .dropdown-item:focus {
    background-color: #f8f9fa !important;
    color: #16181b !important;
}

/* Ensure all other elements stay below */
.product-grid, .product-item, .product-card, .card {
    z-index: 1 !important;
    position: relative !important;
}

.container, .container-fluid, main, section, .row, .col {
    z-index: 0 !important;
}
</style>

<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
            <li class="breadcrumb-item active">{{ $category->name }}</li>
        </ol>
    </nav>

    <!-- Category Header -->
    <div class="category-header text-center mb-5">
        @if($category->image)
        <div class="category-image mb-4">
            <img src="{{ asset($category->image) }}" alt="{{ $category->name }}" class="img-fluid rounded">
        </div>
        @endif
        
        <h1 class="category-title mb-3">{{ $category->name }}</h1>
        
        @if($category->description)
        <p class="category-description text-muted lead">{{ $category->description }}</p>
        @endif
        
        <div class="category-stats">
            <span class="badge bg-primary fs-6">{{ $products->total() }} Products</span>
        </div>
    </div>

    <!-- Sub-categories -->
    @if($category->subCategories->count() > 0)
    <div class="sub-categories mb-5">
        <h3 class="mb-4">Shop by Sub-Category</h3>
        <div class="row">
            @foreach($category->subCategories->where('status', 1) as $subCategory)
            <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                <div class="sub-category-card">
                    <a href="{{ route('products', ['category' => $subCategory->slug]) }}" class="text-decoration-none">
                        <div class="sub-category-image">
                            @if($subCategory->image)
                                <img src="{{ asset($subCategory->image) }}" alt="{{ $subCategory->name }}" class="img-fluid">
                            @else
                                <div class="placeholder-image d-flex align-items-center justify-content-center">
                                    <i class="fas fa-gem fa-3x text-muted"></i>
                                </div>
                            @endif
                        </div>
                        <div class="sub-category-info text-center p-3">
                            <h5 class="sub-category-name mb-2">{{ $subCategory->name }}</h5>
                            <p class="text-muted small mb-0">{{ \App\Models\Product::where('sub_category_id', $subCategory->id)->where('status', 1)->where('approve_by_admin', 1)->count() }} items</p>
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
                    <!-- View Toggle -->
                    <div class="view-toggle">
                        <button class="btn btn-outline-secondary btn-sm view-btn active" data-view="grid">
                            <i class="fas fa-th"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-sm view-btn" data-view="list">
                            <i class="fas fa-list"></i>
                        </button>
                    </div>
                    
                    <!-- Sort Dropdown - Simplified -->
                    <div class="sort-dropdown-container">
                        <button class="btn btn-outline-secondary sort-btn" type="button" onclick="toggleSortDropdown(event)">
                            <i class="fas fa-sort me-2"></i>Sort by <i class="fas fa-chevron-down ms-2"></i>
                        </button>
                        <div class="sort-menu" id="sortMenu" style="display: none;">
                            <a href="#" class="sort-item" onclick="sortProducts('name_asc', event); return false;">Name (A-Z)</a>
                            <a href="#" class="sort-item" onclick="sortProducts('name_desc', event); return false;">Name (Z-A)</a>
                            <a href="#" class="sort-item" onclick="sortProducts('price_asc', event); return false;">Price (Low to High)</a>
                            <a href="#" class="sort-item" onclick="sortProducts('price_desc', event); return false;">Price (High to Low)</a>
                            <a href="#" class="sort-item" onclick="sortProducts('newest', event); return false;">Newest First</a>
                            <a href="#" class="sort-item" onclick="sortProducts('rating', event); return false;">Highest Rated</a>
                        </div>
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
                            
                            <div class="product-actions position-absolute top-0 end-0 m-2">
                                <button class="btn btn-sm btn-light rounded-circle mb-2 wishlist-btn" 
                                        data-product-id="{{ $product->id }}" title="Add to Wishlist">
                                    <i class="far fa-heart"></i>
                                </button>
                                <a href="{{ route('product-detail', ['slug' => $product->slug]) }}" 
                                   class="btn btn-sm btn-light rounded-circle" 
                                   title="View Details">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="product-info p-3">
                            <div class="product-category text-muted small mb-1">
                                {{ $product->category->name ?? 'Uncategorized' }}
                                @if($product->brand)
                                • {{ $product->brand->name }}
                                @endif
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
                <h4 class="text-muted mb-3">No products found in this category</h4>
                <p class="text-muted mb-4">Try browsing other categories or check back later for new arrivals.</p>
                <a href="{{ route('products') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Browse All Products
                </a>
            </div>
        @endif
    </div>
</div>

<style>
.category-header {
    padding: 40px 0;
}

/* Sort Dropdown Styles */
.sort-dropdown {
    position: relative;
}

.sort-dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    display: none;
    min-width: 200px;
    padding: 0.5rem 0;
    margin: 0.125rem 0 0;
    background-color: #fff;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
}

.sort-dropdown-menu.show {
    display: block;
}

.sort-dropdown-menu .dropdown-item {
    display: block;
    width: 100%;
    padding: 0.5rem 1rem;
    clear: both;
    font-weight: 400;
    color: #212529;
    text-align: inherit;
    text-decoration: none;
    white-space: nowrap;
    background-color: transparent;
    border: 0;
    cursor: pointer;
}

.sort-dropdown-menu .dropdown-item:hover {
    background-color: #f8f9fa;
    color: #1e2125;
}

.sort-dropdown-menu .dropdown-item:active {
    background-color: #0d6efd;
    color: #fff;
}

#sortDropdownBtn .fa-chevron-down {
    transition: transform 0.2s ease;
}

#sortDropdownBtn[aria-expanded="true"] .fa-chevron-down {
    transform: rotate(180deg);
}

.category-image img {
    max-height: 300px;
    object-fit: cover;
    border-radius: 12px;
}

.category-title {
    font-size: 2.5rem;
    font-weight: 600;
    color: #333;
}

.category-description {
    max-width: 600px;
    margin: 0 auto;
}

.sub-category-card {
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
    transition: all 0.3s ease;
    background: white;
    height: 100%;
}

.sub-category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    border-color: var(--primary-color);
}

.sub-category-image {
    height: 200px;
    overflow: hidden;
}

.sub-category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.sub-category-card:hover .sub-category-image img {
    transform: scale(1.05);
}

.placeholder-image {
    height: 200px;
    background: #f8f9fa;
}

.sub-category-name {
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

/* add-to-cart-btn styles removed - buttons only available on product details page */

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
    .category-title {
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
// Immediately execute to avoid conflicts
(function() {
    'use strict';
    
    // Wait for DOM to be ready
    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }
    
    ready(function() {
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
    
    // Simple global functions for dropdown - no conflicts
    window.toggleSortDropdown = function(event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
        
        const menu = document.getElementById('sortMenu');
        if (menu) {
            if (menu.style.display === 'none' || menu.style.display === '') {
                menu.style.display = 'block';
            } else {
                menu.style.display = 'none';
            }
        }
    };
    
    window.sortProducts = function(sortBy, event) {
        if (event) {
            event.preventDefault();
            event.stopPropagation();
            event.stopImmediatePropagation();
        }
        
        // Close dropdown
        const menu = document.getElementById('sortMenu');
        if (menu) {
            menu.style.display = 'none';
        }
        
        // Update URL with sort parameter
        const url = new URL(window.location);
        url.searchParams.set('sort', sortBy);
        window.location.href = url.toString();
    };
    
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
    
    // addToCart function removed - only available on product details page
    
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
    
})(); // End IIFE
</script>
@endsection