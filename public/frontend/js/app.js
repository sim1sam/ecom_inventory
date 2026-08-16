// Frontend JavaScript for Diamonds Jewelry Website

// DOM Content Loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all components
    initScrollAnimations();
    initProductFilters();
    initCartFunctionality();
    initWishlistFunctionality();
    initSearchFunctionality();
    initImageZoom();
    initQuantityControls();
    initSmoothScrolling();
});

// Scroll Animations
function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    // Observe all fade-in elements
    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
}

// Product Filters
function initProductFilters() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const sortSelect = document.getElementById('sortSelect');
    const priceRange = document.getElementById('priceRange');
    const priceDisplay = document.getElementById('priceDisplay');

    // Filter by category
    filterButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            filterProducts(category);
            
            // Update active state
            filterButtons.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
        });
    });

    // Sort products
    if (sortSelect) {
        sortSelect.addEventListener('change', function() {
            const sortBy = this.value;
            sortProducts(sortBy);
        });
    }

    // Price range filter
    if (priceRange) {
        priceRange.addEventListener('input', function() {
            const maxPrice = this.value;
            if (priceDisplay) {
                priceDisplay.textContent = `$0 - $${maxPrice}`;
            }
            filterByPrice(maxPrice);
        });
    }
}

// Filter products by category
function filterProducts(category) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        if (category === 'all' || product.dataset.category === category) {
            product.style.display = 'block';
            product.classList.add('fade-in');
        } else {
            product.style.display = 'none';
        }
    });
}

// Sort products
function sortProducts(sortBy) {
    const container = document.querySelector('.products-container');
    if (!container) return;
    
    const products = Array.from(container.querySelectorAll('.product-card'));
    
    products.sort((a, b) => {
        switch (sortBy) {
            case 'price-low':
                return parseFloat(a.dataset.price) - parseFloat(b.dataset.price);
            case 'price-high':
                return parseFloat(b.dataset.price) - parseFloat(a.dataset.price);
            case 'name':
                return a.dataset.name.localeCompare(b.dataset.name);
            case 'newest':
                return new Date(b.dataset.date) - new Date(a.dataset.date);
            default:
                return 0;
        }
    });
    
    // Re-append sorted products
    products.forEach(product => container.appendChild(product));
}

// Filter by price
function filterByPrice(maxPrice) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const price = parseFloat(product.dataset.price);
        if (price <= maxPrice) {
            product.style.display = 'block';
        } else {
            product.style.display = 'none';
        }
    });
}

// Cart Functionality
function initCartFunctionality() {
    const addToCartBtns = document.querySelectorAll('.add-to-cart');
    const cartCount = document.querySelector('.cart-count');
    
    addToCartBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const productName = this.dataset.productName;
            const productPrice = this.dataset.productPrice;
            const productImage = this.dataset.productImage;
            
            addToCart({
                id: productId,
                name: productName,
                price: productPrice,
                image: productImage,
                quantity: 1
            });
        });
    });
}

// Add item to cart
function addToCart(product) {
    // Show loading state
    const button = event.target.closest('.add-to-cart');
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    button.disabled = true;

    // Prepare data
    const formData = new FormData();
    formData.append('product_id', product.id);
    formData.append('quantity', product.quantity || 1);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

    // Make AJAX request
    fetch('/cart/add', {
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
            // Immediately update cart count using server response
            if (typeof data.cart_count !== 'undefined') {
                const cartCountElements = document.querySelectorAll('.cart-count');
                cartCountElements.forEach(el => {
                    const count = parseInt(data.cart_count, 10) || 0;
                    el.textContent = count;
                    if (count > 0) {
                        el.classList.remove('d-none');
                    } else {
                        el.classList.add('d-none');
                    }
                });
            }
            // Update cart count from server (resync)
            updateCartCount();
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
        button.innerHTML = originalText;
        button.disabled = false;
    });
}

// Update cart count from server
function updateCartCount() {
    fetch('/cart/count?ts=' + Date.now(), {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const cartCountElements = document.querySelectorAll('.cart-count');
            const count = parseInt(data.cart_count, 10) || 0;
            cartCountElements.forEach(element => {
                element.textContent = count;
                if (count > 0) {
                    element.classList.remove('d-none');
                } else {
                    element.classList.add('d-none');
                }
            });
        }
    })
    .catch(error => {
        console.error('Error fetching cart count:', error);
        // Fallback to 0 if there's an error
        const cartCountElements = document.querySelectorAll('.cart-count');
        cartCountElements.forEach(element => {
            element.textContent = '0';
            element.classList.add('d-none');
        });
    });
}

// Wishlist Functionality
function initWishlistFunctionality() {
    const wishlistBtns = document.querySelectorAll('.add-to-wishlist');
    
    wishlistBtns.forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            
            const productId = this.dataset.productId;
            const isWishlisted = this.classList.contains('wishlisted');
            
            if (isWishlisted) {
                removeFromWishlist(productId);
                this.classList.remove('wishlisted');
                this.innerHTML = '<i class="far fa-heart"></i>';
                showNotification('Removed from wishlist', 'info');
            } else {
                addToWishlist(productId);
                this.classList.add('wishlisted');
                this.innerHTML = '<i class="fas fa-heart"></i>';
                showNotification('Added to wishlist!', 'success');
            }
            
            updateWishlistCount();
        });
    });
}

// Add to wishlist
function addToWishlist(productId) {
    // Check if user is authenticated by looking for CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (csrfToken) {
        // User is authenticated, save to database
        fetch('/user/wishlist/add', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || 'Added to wishlist!', 'success');
            } else {
                showNotification(data.message || 'Failed to add to wishlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to add to wishlist', 'error');
        });
    } else {
        // User is not authenticated, use localStorage
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        
        if (!wishlist.includes(productId)) {
            wishlist.push(productId);
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
            showNotification('Added to wishlist!', 'success');
        } else {
            showNotification('Product already in wishlist', 'info');
        }
    }
}

// Remove from wishlist
function removeFromWishlist(productId) {
    // Check if user is authenticated by looking for CSRF token
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    
    if (csrfToken) {
        // User is authenticated, remove from database
        fetch(`/user/wishlist/${productId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken.getAttribute('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showNotification(data.message || 'Removed from wishlist', 'info');
            } else {
                showNotification(data.message || 'Failed to remove from wishlist', 'error');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showNotification('Failed to remove from wishlist', 'error');
        });
    } else {
        // User is not authenticated, use localStorage
        let wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        wishlist = wishlist.filter(id => id !== productId);
        localStorage.setItem('wishlist', JSON.stringify(wishlist));
        showNotification('Removed from wishlist', 'info');
    }
}

// Update wishlist count
function updateWishlistCount() {
    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    const wishlistCountElements = document.querySelectorAll('.wishlist-count');
    
    wishlistCountElements.forEach(element => {
        element.textContent = wishlist.length;
    });
}

// Search Functionality
function initSearchFunctionality() {
    const searchInput = document.querySelector('input[name="search"]');
    const searchSuggestions = document.querySelector('.search-suggestions');
    
    if (searchInput) {
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            
            if (query.length >= 2) {
                searchTimeout = setTimeout(() => {
                    fetchSearchSuggestions(query);
                }, 300);
            } else if (searchSuggestions) {
                searchSuggestions.style.display = 'none';
            }
        });
        
        // Hide suggestions when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && searchSuggestions) {
                searchSuggestions.style.display = 'none';
            }
        });
    }
}

// Fetch search suggestions
function fetchSearchSuggestions(query) {
    // This would typically make an AJAX request to your backend
    // For now, we'll simulate with local data
    const suggestions = [
        'Diamond Ring',
        'Gold Necklace',
        'Silver Earrings',
        'Pearl Bracelet',
        'Emerald Pendant'
    ].filter(item => item.toLowerCase().includes(query.toLowerCase()));
    
    displaySearchSuggestions(suggestions);
}

// Display search suggestions
function displaySearchSuggestions(suggestions) {
    const searchSuggestions = document.querySelector('.search-suggestions');
    
    if (!searchSuggestions) return;
    
    if (suggestions.length > 0) {
        const html = suggestions.map(suggestion => 
            `<div class="suggestion-item">${suggestion}</div>`
        ).join('');
        
        searchSuggestions.innerHTML = html;
        searchSuggestions.style.display = 'block';
        
        // Add click handlers to suggestions
        searchSuggestions.querySelectorAll('.suggestion-item').forEach(item => {
            item.addEventListener('click', function() {
                document.querySelector('input[name="search"]').value = this.textContent;
                searchSuggestions.style.display = 'none';
            });
        });
    } else {
        searchSuggestions.style.display = 'none';
    }
}

// Image Zoom
function initImageZoom() {
    const zoomImages = document.querySelectorAll('.zoom-image');
    
    zoomImages.forEach(img => {
        img.addEventListener('mouseenter', function() {
            this.style.transform = 'scale(1.2)';
        });
        
        img.addEventListener('mouseleave', function() {
            this.style.transform = 'scale(1)';
        });
    });
}

// Quantity Controls
function initQuantityControls() {
    const quantityControls = document.querySelectorAll('.quantity-control');
    
    quantityControls.forEach(control => {
        const minusBtn = control.querySelector('.quantity-minus');
        const plusBtn = control.querySelector('.quantity-plus');
        const input = control.querySelector('.quantity-input');
        
        if (minusBtn && plusBtn && input) {
            minusBtn.addEventListener('click', function() {
                const currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                }
            });
            
            plusBtn.addEventListener('click', function() {
                const currentValue = parseInt(input.value);
                const maxValue = parseInt(input.getAttribute('max')) || 999;
                if (currentValue < maxValue) {
                    input.value = currentValue + 1;
                }
            });
        }
    });
}

// Smooth Scrolling
function initSmoothScrolling() {
    const scrollLinks = document.querySelectorAll('a[href^="#"]');
    
    scrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// Show Notification
function showNotification(message, type = 'success') {
    // Create a temporary alert element
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type === 'error' ? 'danger' : type} alert-dismissible fade show`;
    alertDiv.setAttribute('role', 'alert');
    alertDiv.style.position = 'fixed';
    alertDiv.style.top = '20px';
    alertDiv.style.right = '20px';
    alertDiv.style.zIndex = '9999';
    alertDiv.style.minWidth = '300px';
    alertDiv.style.maxWidth = '400px';
    
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    `;
    
    document.body.appendChild(alertDiv);
    
    // Auto-remove after 5 seconds
    setTimeout(() => {
        if (alertDiv.parentNode) {
            alertDiv.parentNode.removeChild(alertDiv);
        }
    }, 5000);
    
    // Add click handler for close button
    const closeBtn = alertDiv.querySelector('.btn-close');
    if (closeBtn) {
        closeBtn.onclick = () => {
            if (alertDiv.parentNode) {
                alertDiv.parentNode.removeChild(alertDiv);
            }
        };
    }
}

// Hide Notification
function hideNotification() {
    // Remove all temporary notifications
    const alerts = document.querySelectorAll('.alert[style*="position: fixed"]');
    alerts.forEach(alert => {
        if (alert.parentNode) {
            alert.parentNode.removeChild(alert);
        }
    });
}

// Initialize cart and wishlist counts on page load
document.addEventListener('DOMContentLoaded', function() {
    updateCartCount();
    updateWishlistCount();
    
    // Mark wishlisted items
    const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
    document.querySelectorAll('.add-to-wishlist').forEach(btn => {
        const productId = btn.dataset.productId;
        if (wishlist.includes(productId)) {
            btn.classList.add('wishlisted');
            btn.innerHTML = '<i class="fas fa-heart"></i>';
        }
    });
});

// Utility Functions
function formatPrice(price) {
    return new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD'
    }).format(price);
}

function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}