@extends('frontend.layouts.app')

@section('title', $product->name . ' - Jewellery Collection')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products') }}">Products</a></li>
            @if($product->category)
            <li class="breadcrumb-item">
                <a href="{{ route('products', ['category' => $product->category->slug]) }}">
                    {{ $product->category->name }}
                </a>
            </li>
            @endif
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Product Images -->
        <div class="col-lg-6 mb-4">
            <div class="product-gallery">
                <!-- Main Image -->
                <div class="main-image-container mb-3">
                    <img src="{{ asset($product->thumb_image) }}" 
                         alt="{{ $product->name }}" 
                         class="main-product-image img-fluid" 
                         id="mainProductImage">
                    
                    @if($product->offer_price && $product->offer_price < $product->price)
                    <span class="badge bg-danger position-absolute top-0 start-0 m-3">
                        {{ round((($product->price - $product->offer_price) / $product->price) * 100) }}% OFF
                    </span>
                    @endif
                </div>
                
                <!-- Thumbnail Images -->
                <div class="thumbnail-images">
                    <div class="row g-2">
                        <div class="col-3">
                            <img src="{{ asset($product->thumb_image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="thumbnail-image img-fluid active" 
                                 data-image="{{ asset($product->thumb_image) }}">
                        </div>
                        @foreach($product->gallery as $gallery)
                        <div class="col-3">
                            <img src="{{ asset($gallery->image) }}" 
                                 alt="{{ $product->name }}" 
                                 class="thumbnail-image img-fluid" 
                                 data-image="{{ asset($gallery->image) }}">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <!-- Product Details -->
        <div class="col-lg-6">
            <div class="product-details">
                <div class="product-category text-muted mb-2">
                    {{ $product->category->name ?? 'Uncategorized' }}
                    @if($product->brand)
                    • {{ $product->brand->name }}
                    @endif
                </div>
                
                <h1 class="product-title mb-3">{{ $product->name }}</h1>
                
                <!-- Rating -->
                <div class="product-rating mb-3">
                    @php
                        $rating = $product->averageRating;
                        $fullStars = floor($rating);
                        $hasHalfStar = ($rating - $fullStars) >= 0.5;
                        $reviewCount = $product->reviews->count();
                    @endphp
                    
                    <div class="d-flex align-items-center">
                        <div class="stars me-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <i class="fas fa-star text-warning"></i>
                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                    <i class="fas fa-star-half-alt text-warning"></i>
                                @else
                                    <i class="far fa-star text-muted"></i>
                                @endif
                            @endfor
                        </div>
                        <span class="rating-text text-muted">
                            {{ number_format($rating, 1) }} ({{ $reviewCount }} {{ $reviewCount == 1 ? 'review' : 'reviews' }})
                        </span>
                    </div>
                </div>
                
                <!-- Price -->
                <div class="product-price mb-4">
                    @if($product->offer_price && $product->offer_price < $product->price)
                        <span class="current-price h3 fw-bold text-primary me-3">
                            {{ $setting->currency_icon }}{{ number_format($product->offer_price, 2) }}
                        </span>
                        <span class="original-price h5 text-muted text-decoration-line-through">
                            {{ $setting->currency_icon }}{{ number_format($product->price, 2) }}
                        </span>
                        <div class="savings text-success mt-1">
                            You save {{ $setting->currency_icon }}{{ number_format($product->price - $product->offer_price, 2) }}
                        </div>
                    @else
                        <span class="current-price h3 fw-bold text-primary">
                            {{ $setting->currency_icon }}{{ number_format($product->price, 2) }}
                        </span>
                    @endif
                </div>
                
                <!-- Short Description -->
                @if($product->short_description)
                <div class="product-description mb-4">
                    <p class="text-muted">{{ $product->short_description }}</p>
                </div>
                @endif
                
                <!-- Product Variants -->
                @if($product->variants->count() > 0)
                <div class="product-variants mb-4">
                    @foreach($product->variants as $variant)
                    <div class="variant-group mb-3">
                        <label class="form-label fw-semibold">{{ $variant->name }}:</label>
                        <div class="variant-options">
                            @foreach($variant->variantItems as $item)
                            <div class="form-check form-check-inline">
                                <input class="form-check-input variant-option" 
                                       type="radio" 
                                       name="variant_{{ $variant->id }}" 
                                       id="variant_{{ $item->id }}" 
                                       value="{{ $item->id }}" 
                                       data-price="{{ $item->price }}">
                                <label class="form-check-label" for="variant_{{ $item->id }}">
                                    {{ $item->name }}
                                    @if($item->price > 0)
                                        (+{{ $setting->currency_icon }}{{ number_format($item->price, 2) }})
                                    @endif
                                </label>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
                
                <!-- Quantity and Add to Cart -->
                <div class="product-actions mb-4">
                    <div class="row g-3">
                        @if($product->qty > 0)
                        <div class="col-md-4">
                            <label class="form-label">Quantity:</label>
                            <div class="quantity-controls d-flex">
                                <button type="button" class="btn btn-outline-secondary" id="decreaseQty">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" class="form-control text-center" 
                                       id="productQuantity" value="1" min="1" max="{{ $product->qty }}">
                                <button type="button" class="btn btn-outline-secondary" id="increaseQty">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                            <small class="text-muted">{{ $product->qty }} items available</small>
                        </div>
                        <div class="col-md-8">
                            <label class="form-label">&nbsp;</label>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" id="addToCart" 
                                        data-product-id="{{ $product->id }}">
                                    <i class="fas fa-shopping-bag me-2"></i>Add to Cart
                                </button>
                                <button class="btn btn-success" id="buyNow" 
                                        data-product-id="{{ $product->id }}">
                                    <i class="fas fa-bolt me-2"></i>Buy Now
                                </button>
                                <button class="btn btn-outline-danger" id="addToWishlist" 
                                        data-product-id="{{ $product->id }}">
                                    <i class="far fa-heart"></i>
                                </button>
                            </div>
                        </div>
                        @else
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                <h5 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Stock Out
                                </h5>
                                <p class="mb-0 mt-2">This product is currently out of stock.</p>
                            </div>
                            <div class="d-flex justify-content-center">
                                <button class="btn btn-outline-danger" id="addToWishlist" 
                                        data-product-id="{{ $product->id }}">
                                    <i class="far fa-heart me-2"></i>Add to Wishlist
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Product Meta -->
                <div class="product-meta">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}
                        </div>
                        <div class="col-md-6">
                            <strong>Weight:</strong> {{ $product->weight ?? 'N/A' }}g
                        </div>
                        @if($product->tags)
                        <div class="col-12">
                            <strong>Tags:</strong>
                            @php
                                $tags = [];
                                try {
                                    // Try to decode as JSON first
                                    $decodedTags = json_decode($product->tags, true);
                                    if (is_array($decodedTags)) {
                                        foreach ($decodedTags as $tag) {
                                            if (is_array($tag) && isset($tag['value'])) {
                                                $tags[] = $tag['value'];
                                            } elseif (is_string($tag)) {
                                                $tags[] = $tag;
                                            }
                                        }
                                    } else {
                                        // Fallback to comma-separated string
                                        $tags = array_map('trim', explode(',', $product->tags));
                                    }
                                } catch (Exception $e) {
                                    // If JSON decode fails, treat as comma-separated string
                                    $tags = array_map('trim', explode(',', $product->tags));
                                }
                            @endphp
                            @foreach($tags as $tag)
                                @if(!empty($tag))
                                    <span class="badge bg-light text-dark me-1">{{ $tag }}</span>
                                @endif
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Product Details Tabs -->
    <div class="row mt-5">
        <div class="col-12">
            <ul class="nav nav-tabs" id="productTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="description-tab" data-bs-toggle="tab" 
                            data-bs-target="#description" type="button" role="tab">
                        Description
                    </button>
                </li>
                @if($product->specifications->count() > 0)
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="specifications-tab" data-bs-toggle="tab" 
                            data-bs-target="#specifications" type="button" role="tab">
                        Specifications
                    </button>
                </li>
                @endif
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                            data-bs-target="#reviews" type="button" role="tab">
                        Reviews ({{ $product->reviews->count() }})
                    </button>
                </li>
            </ul>
            
            <div class="tab-content" id="productTabsContent">
                <!-- Description Tab -->
                <div class="tab-pane fade show active" id="description" role="tabpanel">
                    <div class="p-4">
                        @if($product->long_description)
                            {!! $product->long_description !!}
                        @else
                            <p>{{ $product->short_description ?? 'No description available.' }}</p>
                        @endif
                        
                        @if($product->video_link)
                        <div class="mt-4">
                            <h5>Product Video</h5>
                            <div class="ratio ratio-16x9">
                                <iframe src="{{ $product->video_link }}" allowfullscreen></iframe>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                
                <!-- Specifications Tab -->
                @if($product->specifications->count() > 0)
                <div class="tab-pane fade" id="specifications" role="tabpanel">
                    <div class="p-4">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <tbody>
                                    @foreach($product->specifications as $spec)
                                    <tr>
                                        <td class="fw-semibold">{{ $spec->key->key ?? 'N/A' }}</td>
                                        <td>{{ $spec->specification }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
                
                <!-- Reviews Tab -->
                <div class="tab-pane fade" id="reviews" role="tabpanel">
                    <div class="p-4">
                        @if($product->reviews->count() > 0)
                            @foreach($product->reviews->where('status', 1) as $review)
                            <div class="review-item mb-4 pb-4 border-bottom">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <div>
                                        <h6 class="mb-1">{{ $review->user->name ?? 'Anonymous' }}</h6>
                                        <div class="review-rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= $review->rating)
                                                    <i class="fas fa-star text-warning"></i>
                                                @else
                                                    <i class="far fa-star text-muted"></i>
                                                @endif
                                            @endfor
                                        </div>
                                    </div>
                                    <small class="text-muted">{{ $review->created_at->format('M d, Y') }}</small>
                                </div>
                                <p class="mb-0">{{ $review->review }}</p>
                            </div>
                            @endforeach
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-star fa-2x text-muted mb-3"></i>
                                <h5 class="text-muted">No reviews yet</h5>
                                <p class="text-muted">Be the first to review this product!</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Related Products</h3>
            <div class="row">
                @foreach($relatedProducts as $relatedProduct)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="product-card h-100">
                        <div class="product-image-container position-relative">
                            <a href="{{ route('product-detail', ['slug' => $relatedProduct->slug]) }}">
                                <img src="{{ $relatedProduct->thumb_image ? asset($relatedProduct->thumb_image) : asset('frontend/images/default-product.svg') }}" 
                                     alt="{{ $relatedProduct->name }}" class="product-image" 
                                     onerror="this.src='{{ asset('frontend/images/default-product.svg') }}';">
                            </a>
                            
                            @if($relatedProduct->offer_price && $relatedProduct->offer_price < $relatedProduct->price)
                            <span class="badge bg-danger position-absolute top-0 start-0 m-2">
                                {{ round((($relatedProduct->price - $relatedProduct->offer_price) / $relatedProduct->price) * 100) }}% OFF
                            </span>
                            @endif
                        </div>
                        
                        <div class="product-info p-3">
                            <h6 class="product-title mb-2">
                                <a href="{{ route('product-detail', ['slug' => $relatedProduct->slug]) }}" 
                                   class="text-decoration-none text-dark">
                                    {{ $relatedProduct->name }}
                                </a>
                            </h6>
                            
                            <div class="product-price">
                                @if($relatedProduct->offer_price && $relatedProduct->offer_price < $relatedProduct->price)
                                    <span class="current-price fw-bold text-primary">
                                        {{ $setting->currency_icon }}{{ number_format($relatedProduct->offer_price, 2) }}
                                    </span>
                                    <span class="original-price text-muted text-decoration-line-through ms-2">
                                        {{ $setting->currency_icon }}{{ number_format($relatedProduct->price, 2) }}
                                    </span>
                                @else
                                    <span class="current-price fw-bold text-primary">
                                        {{ $setting->currency_icon }}{{ number_format($relatedProduct->price, 2) }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.product-gallery {
    position: sticky;
    top: 20px;
}

.main-image-container {
    position: relative;
    border-radius: 8px;
    overflow: hidden;
    background: #f8f9fa;
}

.main-product-image {
    width: 100%;
    height: 500px;
    object-fit: cover;
    cursor: zoom-in;
}

.thumbnail-image {
    height: 80px;
    object-fit: cover;
    border-radius: 4px;
    cursor: pointer;
    border: 2px solid transparent;
    transition: all 0.3s ease;
}

.thumbnail-image:hover,
.thumbnail-image.active {
    border-color: var(--primary-color);
}

.product-details {
    padding-left: 20px;
}

.product-title {
    font-size: 2rem;
    font-weight: 600;
    color: #333;
}

.current-price {
    color: var(--primary-color) !important;
}

.quantity-controls {
    max-width: 150px;
}

.quantity-controls .form-control {
    border-left: none;
    border-right: none;
    border-radius: 0;
}

.quantity-controls .btn {
    border-radius: 0;
}

.quantity-controls .btn:first-child {
    border-top-left-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
}

.quantity-controls .btn:last-child {
    border-top-right-radius: 0.375rem;
    border-bottom-right-radius: 0.375rem;
}

.variant-options {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.nav-tabs .nav-link {
    color: #666;
    border: none;
    border-bottom: 2px solid transparent;
    background: none;
    padding: 15px 20px;
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    border-bottom-color: var(--primary-color);
    background: none;
}

.tab-content {
    border: 1px solid #e9ecef;
    border-top: none;
    border-radius: 0 0 8px 8px;
}

.review-item:last-child {
    border-bottom: none !important;
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
    height: 200px;
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

@media (max-width: 768px) {
    .product-details {
        padding-left: 0;
        margin-top: 20px;
    }
    
    .main-product-image {
        height: 300px;
    }
    
    .product-title {
        font-size: 1.5rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Image gallery functionality
    const thumbnails = document.querySelectorAll('.thumbnail-image');
    const mainImage = document.getElementById('mainProductImage');
    
    thumbnails.forEach(thumb => {
        thumb.addEventListener('click', function() {
            // Remove active class from all thumbnails
            thumbnails.forEach(t => t.classList.remove('active'));
            // Add active class to clicked thumbnail
            this.classList.add('active');
            // Update main image
            mainImage.src = this.dataset.image;
        });
    });
    
    // Quantity controls
    const decreaseBtn = document.getElementById('decreaseQty');
    const increaseBtn = document.getElementById('increaseQty');
    const quantityInput = document.getElementById('productQuantity');
    
    decreaseBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        if (currentValue > 1) {
            quantityInput.value = currentValue - 1;
        }
    });
    
    increaseBtn.addEventListener('click', function() {
        let currentValue = parseInt(quantityInput.value);
        let maxValue = parseInt(quantityInput.max);
        if (currentValue < maxValue) {
            quantityInput.value = currentValue + 1;
        }
    });
    
    // Variant price calculation
    const variantOptions = document.querySelectorAll('.variant-option');
    const basePrice = {{ $product->offer_price ?? $product->price }};
    
    variantOptions.forEach(option => {
        option.addEventListener('change', function() {
            updatePrice();
        });
    });
    
    function updatePrice() {
        let totalPrice = basePrice;
        const selectedVariants = document.querySelectorAll('.variant-option:checked');
        
        selectedVariants.forEach(variant => {
            totalPrice += parseFloat(variant.dataset.price || 0);
        });
        
        // Update displayed price (you can add this functionality)
        console.log('Updated price:', totalPrice);
    }
    
    // Validation function to check if all variants are selected
    function validateVariantSelection() {
        const variantGroups = document.querySelectorAll('.variant-group');
        const totalVariantGroups = variantGroups.length;
        
        if (totalVariantGroups === 0) {
            return true; // No variants to validate
        }
        
        const selectedVariants = document.querySelectorAll('.variant-option:checked');
        
        if (selectedVariants.length < totalVariantGroups) {
            showNotification('Please select all required product options before proceeding.', 'danger');
            return false;
        }
        
        return true;
    }
    
    // Add to cart functionality
    document.getElementById('addToCart').addEventListener('click', function() {
        // Validate variant selection first
        if (!validateVariantSelection()) {
            return;
        }
        
        const productId = this.dataset.productId;
        const quantity = quantityInput.value;
        const selectedVariants = [];
        
        document.querySelectorAll('.variant-option:checked').forEach(variant => {
            selectedVariants.push({
                variant_id: variant.name.replace('variant_', ''),
                variant_item_id: variant.value
            });
        });
        
        // Add to cart logic (integrate with your cart system)
        addToCart(productId, quantity, selectedVariants);
    });
    
    // Buy Now functionality
    document.getElementById('buyNow').addEventListener('click', function() {
        console.log('Buy Now button clicked!');
        // Validate variant selection first
        if (!validateVariantSelection()) {
            return;
        }
        
        const productId = this.dataset.productId;
        const quantity = quantityInput.value;
        const selectedVariants = [];
        
        document.querySelectorAll('.variant-option:checked').forEach(variant => {
            selectedVariants.push({
                variant_id: variant.name.replace('variant_', ''),
                variant_item_id: variant.value
            });
        });
        
        // Buy now logic - add to cart and redirect to checkout
        buyNow(productId, quantity, selectedVariants);
    });
    
    // Add to wishlist functionality
    document.getElementById('addToWishlist').addEventListener('click', function() {
        const productId = this.dataset.productId;
        addToWishlist(productId);
    });
    
    function addToCart(productId, quantity, variants) {
        // Show loading state
        const addToCartBtn = document.getElementById('addToCart');
        const originalText = addToCartBtn.innerHTML;
        addToCartBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Adding...';
        addToCartBtn.disabled = true;

        // Prepare data
        const formData = new FormData();
        formData.append('product_id', productId);
        formData.append('quantity', quantity);
        
        if (variants && variants.length > 0) {
            variants.forEach((variant, index) => {
                formData.append(`variants[${index}][variant_id]`, variant.variant_id);
                formData.append(`variants[${index}][variant_item_id]`, variant.variant_item_id);
            });
        }

        // Add CSRF token
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        // Make AJAX request
        fetch('{{ route("cart.add") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message, 'success');
                // Update cart count across all header badges
                const cartCountElements = document.querySelectorAll('.cart-count');
                if (data.cart_count !== undefined && cartCountElements.length) {
                    cartCountElements.forEach(el => {
                        el.textContent = data.cart_count;
                    });
                }
                // Re-sync via global updater if available
                if (typeof updateCartCount === 'function') {
                    try { updateCartCount(); } catch (e) { /* no-op */ }
                }
            } else {
                showNotification(data.message, 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'danger');
        })
        .finally(() => {
            // Restore button state
            addToCartBtn.innerHTML = originalText;
            addToCartBtn.disabled = false;
        });
    }
    
    function buyNow(productId, quantity, variants) {
        console.log('buyNow function called with:', { productId, quantity, variants });
        
        // Show loading state
        const buyNowBtn = document.getElementById('buyNow');
        const originalText = buyNowBtn.innerHTML;
        buyNowBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        buyNowBtn.disabled = true;

        // Build query parameters for price calculation
        let priceParams = new URLSearchParams();
        priceParams.append('product_id', productId);
        
        if (variants && variants.length > 0) {
            variants.forEach((variant, index) => {
                priceParams.append(`variants[${index}]`, variant.variant_id);
                priceParams.append(`items[${index}]`, variant.variant_item_id);
            });
        }
        
        // Calculate price first
        console.log('Making web call to:', `/cart/calculate-product-price?${priceParams.toString()}`);
                fetch(`/cart/calculate-product-price?${priceParams.toString()}`, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            console.log('API Response status:', response.status);
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(priceData => {
            console.log('Price API Response:', priceData);
            if (priceData.productPrice === undefined || priceData.productPrice === null) {
                console.error('Product price is undefined or null:', priceData);
                throw new Error('Product price not found in API response');
            }
            const totalPrice = (priceData.productPrice * quantity).toFixed(2);
            console.log('Calculated total price:', totalPrice);
            const currencyIcon = '{{ $setting->currency_icon }}';
            
            // Now add to cart
            const cartFormData = new FormData();
            cartFormData.append('product_id', productId);
            cartFormData.append('quantity', quantity);
            
            if (variants && variants.length > 0) {
                variants.forEach((variant, index) => {
                    cartFormData.append(`variants[${index}]`, variant.variant_id);
                    cartFormData.append(`items[${index}]`, variant.variant_item_id);
                });
            }
            
            cartFormData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            return fetch('/cart/add', {
                method: 'POST',
                body: cartFormData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => {
                if (response.ok) {
                    return response.json();
                } else {
                    throw new Error('Network response was not ok');
                }
            })
            .then(data => {
                if (data.message) {
                    showNotification(`Total: ${currencyIcon}${totalPrice} - ${data.message} - Redirecting to checkout...`, 'success');
                    // Redirect to checkout page after a brief delay
                    setTimeout(() => {
                        window.location.href = '/checkout';
                    }, 1500);
                } else {
                    showNotification(data.message || 'An error occurred', 'danger');
                    // Restore button state on error
                    buyNowBtn.innerHTML = originalText;
                    buyNowBtn.disabled = false;
                }
            });
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('An error occurred. Please try again.', 'danger');
            // Restore button state on error
            buyNowBtn.innerHTML = originalText;
            buyNowBtn.disabled = false;
        });
    }
    
    function addToWishlist(productId) {
        // Implement your add to wishlist logic here
        showNotification('Product added to wishlist!', 'success');
    }
    
    function showNotification(message, type) {
        if (typeof window.showNotification === 'function') {
            return window.showNotification(message, type);
        }
        alert(message);
    }
});
</script>
@endsection