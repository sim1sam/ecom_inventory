@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
        </ol>
    </nav>

    <!-- Notification Messages -->
    <div id="notification-area">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                {{ session('warning') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="fas fa-info-circle me-2"></i>
                {{ session('info') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Shopping Cart (<span id="cart-count">0</span> items)</h4>
                </div>
                <div class="card-body">
                    <div id="cart-items">
                        <!-- Cart items will be loaded here -->
                    </div>
                    <div id="empty-cart" class="text-center py-5" style="display: none;">
                        <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                        <h5>Your cart is empty</h5>
                        <p class="text-muted">Add some products to your cart to continue shopping.</p>
                        <a href="{{ route('products') }}" class="btn btn-primary">Continue Shopping</a>
                    </div>
                    <div id="login-prompt" class="text-center py-5" style="display: none;">
                        <i class="fas fa-user-lock fa-3x text-muted mb-3"></i>
                        <h5>Please log in to view your cart</h5>
                        <p class="text-muted">Log in to see your saved cart items and continue shopping.</p>
                        <a href="{{ route('login') }}" class="btn btn-primary me-2">Login</a>
                        <a href="{{ route('register') }}" class="btn btn-outline-primary">Register</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="total">$0.00</strong>
                    </div>
                    

                    
                    <div class="d-grid gap-2">
                        <button class="btn btn-primary btn-lg" id="checkout-btn" disabled>
                            <i class="fas fa-lock me-2"></i>Proceed to Checkout
                        </button>
                        <a href="{{ route('products') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                        </a>
                    </div>
                </div>
            </div>

            <!-- Recommended Products -->
            <div class="card mt-4">
                <div class="card-header">
                    <h6 class="mb-0">You might also like</h6>
                </div>
                <div class="card-body">
                    <div id="recommended-products">
                        <!-- Recommended products will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.cart-item {
    border-bottom: 1px solid #eee;
    padding: 20px 0;
}

.cart-item:last-child {
    border-bottom: none;
}

.cart-item img {
    width: 100%;
    max-width: 80px;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    border-radius: 8px;
}

.quantity-controls {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-controls button {
    width: 30px;
    height: 30px;
    border: 1px solid #ddd;
    background: white;
    border-radius: 4px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s ease;
}

.quantity-controls button:hover {
    background: #f8f9fa;
    border-color: #007bff;
    color: #007bff;
}

.quantity-controls input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    height: 30px;
}

.remove-item {
    color: #dc3545;
    cursor: pointer;
    font-size: 18px;
}

.remove-item:hover {
    color: #c82333;
}

.recommended-product {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.recommended-product:last-child {
    border-bottom: none;
}

.recommended-product img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

.recommended-product .product-info {
    flex: 1;
}

.recommended-product .product-name {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 2px;
}

.recommended-product .product-price {
    font-size: 13px;
    color: #d4af37;
    font-weight: 600;
}

/* Improve spacing inside cart item rows */
.cart-item .row {
    row-gap: 0.5rem;
}

/* Mobile tweaks */
@media (max-width: 576px) {
  .cart-item img {
    width: 100%;
    max-width: 100%;
    height: auto;
    aspect-ratio: auto;
  }
  .quantity-controls {
    gap: 8px;
    flex-direction: row;
    align-items: center;
  }
  .quantity-controls button {
    width: 30px;
    height: 30px;
  }
  .quantity-controls input {
    width: 56px;
  }
}
</style>

<script>
class ShoppingCart {
    constructor() {
        this.cart = [];
        this.init();
    }



    init() {
        this.loadCartItems();
        this.loadRecommendedProducts();
        


        // Checkout button
        document.getElementById('checkout-btn').addEventListener('click', () => {
            this.proceedToCheckout();
        });
    }

    async loadCartItems() {
        try {
            const response = await fetch('/cart/items', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.cart = data.cart_items;
                this.renderCart();
            } else {
                this.showNotification('Failed to load cart items', 'error');
            }
        } catch (error) {
            console.error('Error loading cart:', error);
            this.showNotification('Error loading cart', 'error');
        }
    }

    renderCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        const emptyCart = document.getElementById('empty-cart');
        const loginPrompt = document.getElementById('login-prompt');
        const cartCount = document.getElementById('cart-count');
        const checkoutBtn = document.getElementById('checkout-btn');

        if (this.cart.length === 0) {
            cartItemsContainer.style.display = 'none';
            emptyCart.style.display = 'block';
            loginPrompt.style.display = 'none';
            checkoutBtn.disabled = true;
            cartCount.textContent = '0';
            this.updateHeaderCartCount(0);
            this.updateSummary();
            return;
        }

        cartItemsContainer.style.display = 'block';
        emptyCart.style.display = 'none';
        loginPrompt.style.display = 'none';
        checkoutBtn.disabled = false;
        const totalQuantity = this.cart.reduce((sum, item) => {
            const quantity = item.qty || item.quantity || 1;
            return sum + parseInt(quantity);
        }, 0);
        cartCount.textContent = totalQuantity;
        this.updateHeaderCartCount(totalQuantity);

        cartItemsContainer.innerHTML = this.cart.map(item => {
            const product = item.product || item;
            const quantity = parseInt(item.qty || item.quantity || 1);
            const itemId = item.id || item.product_id;
            const productImage = product.thumb_image ? `{{ asset('') }}${product.thumb_image}` : '{{ asset('frontend/images/default-product.svg') }}';
            const productPrice = product.offer_price || product.price;
            
            return `
                <div class="cart-item" data-id="${itemId}">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-2">
                            <img src="${productImage}" alt="${product.name}" class="img-fluid">
                        </div>
                        <div class="col-12 col-md-4 mt-2 mt-md-0">
                            <h6 class="mb-1">${product.name}</h6>
                            <small class="text-muted">${product.category?.name || 'No Category'}</small>
                            ${item.variants && Array.isArray(item.variants) && item.variants.length > 0 ? `<br><small class="text-muted">Variants: ${item.variants.map(v => v.name).join(', ')}</small>` : ''}
                        </div>
                        <div class="col-12 col-md-2 mt-2 mt-md-0">
                            <span class="fw-bold text-primary">$${productPrice}</span>
                        </div>
                        <div class="col-12 col-md-3 mt-2 mt-md-0">
                            <div class="quantity-controls">
                                <button type="button" class="qty-btn minus-btn" data-item-id="${itemId}" data-action="decrease">
                                    <i class="fas fa-minus"></i>
                                </button>
                                <input type="number" value="${quantity}" min="1" class="qty-input" data-item-id="${itemId}">
                                <button type="button" class="qty-btn plus-btn" data-item-id="${itemId}" data-action="increase">
                                    <i class="fas fa-plus"></i>
                                </button>
                            </div>
                        </div>
                        <div class="col-12 col-md-1 text-end mt-2 mt-md-0">
                            <i class="fas fa-trash remove-item" onclick="cart.removeItem(${itemId})"></i>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        this.updateSummary();
        this.attachQuantityEventListeners();
    }

    attachQuantityEventListeners() {
        console.log('Attaching quantity event listeners');
        // Remove existing listeners to prevent duplicates
        document.querySelectorAll('.qty-btn').forEach(btn => {
            btn.replaceWith(btn.cloneNode(true));
        });
        
        // Add event listeners for quantity buttons
        document.querySelectorAll('.qty-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                console.log('Button clicked:', e.target);
                const itemId = e.target.closest('.qty-btn').dataset.itemId;
                const action = e.target.closest('.qty-btn').dataset.action;
                const input = document.querySelector(`.qty-input[data-item-id="${itemId}"]`);
                const currentQty = parseInt(input.value);
                
                console.log('Button click data:', { itemId, action, currentQty });
                
                if (action === 'increase') {
                    console.log('Increasing quantity from', currentQty, 'to', currentQty + 1);
                    this.updateQuantity(itemId, currentQty + 1);
                } else if (action === 'decrease') {
                    console.log('Decreasing quantity from', currentQty, 'to', currentQty - 1);
                    this.updateQuantity(itemId, currentQty - 1);
                }
            });
        });
        
        // Add event listeners for quantity inputs
        document.querySelectorAll('.qty-input').forEach(input => {
            input.addEventListener('change', (e) => {
                console.log('Input changed:', e.target.value);
                const itemId = e.target.dataset.itemId;
                const newQty = parseInt(e.target.value);
                console.log('Input change data:', { itemId, newQty });
                this.updateQuantity(itemId, newQty);
            });
        });
    }

    async updateQuantity(id, quantity) {
        console.log('updateQuantity called with:', { id, quantity, type: typeof quantity });
        quantity = parseInt(quantity);
        console.log('After parseInt:', { id, quantity, type: typeof quantity });
        
        if (quantity < 1) {
            console.log('Quantity < 1, removing item');
            this.removeItem(id);
            return;
        }

        try {
            console.log('Sending AJAX request:', { cart_item_id: id, quantity: quantity });
            const response = await fetch('/cart/update', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    cart_item_id: id,
                    quantity: quantity
                })
            });
            
            console.log('Response status:', response.status);
            const data = await response.json();
            console.log('Response data:', data);
            
            if (data.success) {
                this.loadCartItems();
                this.showNotification('Cart updated successfully!');
                this.updateHeaderCartCount(data.cart_count);
            } else {
                console.error('Update failed:', data.message);
                this.showNotification(data.message || 'Failed to update cart', 'error');
            }
        } catch (error) {
            console.error('Error updating cart:', error);
            this.showNotification('Error updating cart', 'error');
        }
    }

    async removeItem(id) {
        try {
            const response = await fetch('/cart/remove', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    cart_item_id: id
                })
            });
            
            const data = await response.json();
            if (data.success) {
                this.loadCartItems();
                this.showNotification('Item removed from cart!');
                this.updateHeaderCartCount(data.cart_count);
            } else {
                this.showNotification(data.message || 'Failed to remove item', 'error');
            }
        } catch (error) {
            console.error('Error removing item:', error);
            this.showNotification('Error removing item', 'error');
        }
    }

    updateSummary() {
        const subtotal = this.cart.reduce((sum, item) => {
            const product = item.product || item;
            const quantity = item.qty || item.quantity || 1;
            const price = product.offer_price || product.price;
            return sum + (price * quantity);
        }, 0);
        
        const total = subtotal;

        document.getElementById('subtotal').textContent = `$${subtotal.toFixed(2)}`;
        document.getElementById('total').textContent = `$${total.toFixed(2)}`;
    }



    proceedToCheckout() {
        if (this.cart.length === 0) {
            this.showNotification('Your cart is empty!', 'error');
            return;
        }

        // Redirect to checkout page
        window.location.href = '/checkout';
    }

    async loadRecommendedProducts() {
        try {
            const response = await fetch('/api/recommended-products');
            const data = await response.json();
            
            if (data.success && data.products) {
                const container = document.getElementById('recommended-products');
                container.innerHTML = data.products.map(product => {
                    const imageUrl = product.thumb_image ? 
                        `{{ asset('') }}${product.thumb_image}` : 
                        '{{ asset('frontend/images/default-product.svg') }}';
                    const price = product.offer_price || product.price;
                    const availableStock = (product.qty || 0) - (product.sold_qty || 0);
                    
                    return `
                        <div class="recommended-product">
                            <img src="${imageUrl}" alt="${product.name}" onerror="this.src='{{ asset('frontend/images/default-product.svg') }}'">
                            <div class="product-info">
                                <div class="product-name">${product.name}</div>
                                <div class="product-price">{{ $setting->currency_icon ?? '$' }}${price}</div>
                            </div>
                            ${availableStock > 0 ? 
                                `<button class="btn btn-sm btn-outline-primary" onclick="cart.addRecommendedToCart(${product.id})">
                                    <i class="fas fa-plus"></i>
                                </button>` : 
                                `<span class="badge bg-warning text-dark">
                                    <i class="fas fa-exclamation-triangle me-1"></i>Stock Out
                                </span>`
                            }
                        </div>
                    `;
                }).join('');
            } else {
                // Fallback to default message if no products found
                const container = document.getElementById('recommended-products');
                container.innerHTML = '<p class="text-center">No recommended products available.</p>';
            }
        } catch (error) {
            console.error('Error loading recommended products:', error);
            // Fallback to default message on error
            const container = document.getElementById('recommended-products');
            container.innerHTML = '<p class="text-center">Unable to load recommended products.</p>';
        }
    }

    async addRecommendedToCart(productId) {
        try {
            // Show loading state
            const button = event.target;
            const originalContent = button.innerHTML;
            button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
            button.disabled = true;

            // Prepare form data
            const formData = new FormData();
            formData.append('product_id', productId);
            formData.append('quantity', 1);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            // Make AJAX request to add to cart
            const response = await fetch('/cart/add', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const data = await response.json();

            if (data.success) {
                this.showNotification(data.message || 'Product added to cart!', 'success');
                // Update cart count if available
                if (data.cart_count !== undefined) {
                    this.updateHeaderCartCount(data.cart_count);
                }
                // Reload cart items to reflect changes
                this.loadCartItems();
            } else {
                this.showNotification(data.message || 'Failed to add product to cart', 'error');
            }
        } catch (error) {
            console.error('Error adding product to cart:', error);
            this.showNotification('An error occurred. Please try again.', 'error');
        } finally {
            // Restore button state
            if (event.target) {
                event.target.innerHTML = originalContent;
                event.target.disabled = false;
            }
        }
    }

    updateHeaderCartCount(count = null) {
        const cartCountElements = document.querySelectorAll('.cart-count');
        if (cartCountElements.length) {
            let value = 0;
            if (count !== null) {
                value = count;
            } else {
                value = this.cart.reduce((sum, item) => {
                    const quantity = item.qty || item.quantity || 1;
                    return sum + parseInt(quantity);
                }, 0);
            }
            cartCountElements.forEach(el => {
                el.textContent = value;
            });
        }
    }

    showNotification(message, type = 'success') {
        // Display notification in the notification area instead of corner popup
        const notificationArea = document.getElementById('notification-area');
        
        // Create alert element
        const alertDiv = document.createElement('div');
        alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
        alertDiv.setAttribute('role', 'alert');
        
        // Set icon based on type
        let icon = 'fas fa-info-circle';
        if (type === 'success') {
            icon = 'fas fa-check-circle';
        } else if (type === 'danger' || type === 'error') {
            icon = 'fas fa-exclamation-circle';
        } else if (type === 'warning') {
            icon = 'fas fa-exclamation-triangle';
        }
        
        alertDiv.innerHTML = `
            <i class="${icon} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        
        // Clear existing notifications and add new one
        notificationArea.innerHTML = '';
        notificationArea.appendChild(alertDiv);
        
        // Scroll to notification area
        notificationArea.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        
        // Auto-dismiss after 5 seconds
        setTimeout(() => {
            if (alertDiv.parentNode) {
                alertDiv.remove();
            }
        }, 5000);
    }
}

// Initialize cart
const cart = new ShoppingCart();
</script>
@endsection