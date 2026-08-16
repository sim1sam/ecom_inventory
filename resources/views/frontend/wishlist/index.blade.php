@extends('frontend.layouts.app')

@section('title', 'My Wishlist')

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="avatar-lg mx-auto mb-3">
                            <div class="avatar-title bg-primary rounded-circle text-white">
                                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                            </div>
                        </div>
                        <h5 class="mb-1">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-0">{{ auth()->user()->email }}</p>
                    </div>
                    <hr>
                    <nav class="nav nav-pills flex-column">
                        <a class="nav-link" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('profile') }}">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                        <a class="nav-link" href="{{ route('orders') }}">
                            <i class="fas fa-shopping-bag me-2"></i> Orders
                        </a>
                        <a class="nav-link active" href="{{ route('wishlist') }}">
                            <i class="fas fa-heart me-2"></i> Wishlist
                        </a>
                        <a class="nav-link" href="{{ route('addresses.index') }}">
                            <i class="fas fa-map-marker-alt me-2"></i> Addresses
                        </a>
                        <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                        </a>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">My Wishlist</h2>
                <a href="{{ route('products') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>

            @if($wishlistItems && $wishlistItems->count() > 0)
                <div class="row">
                    @foreach($wishlistItems as $item)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100 shadow-sm">
                            <div class="position-relative">
                                @if(isset($item->product) && $item->product->thumb_image)
                                    <img src="{{ asset($item->product->thumb_image) }}" class="card-img-top" alt="{{ $item->product->name ?? 'Product' }}" style="height: 200px; object-fit: cover;">
                                @else
                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                        <i class="fas fa-image fa-3x text-muted"></i>
                                    </div>
                                @endif
                                <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-2" onclick="removeFromWishlist({{ $item->id }})">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title">{{ $item->product->name ?? 'Product Name' }}</h6>
                                <p class="card-text text-muted small flex-grow-1">{{ Str::limit($item->product->short_description ?? 'No description available', 80) }}</p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="h6 text-primary mb-0">${{ number_format($item->product->price ?? 0, 2) }}</span>
                                        @if(isset($item->product->offer_price) && $item->product->offer_price > 0)
                                            <small class="text-muted"><del>${{ number_format($item->product->offer_price, 2) }}</del></small>
                                        @endif
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        @if(isset($item->product))
                                            <a href="{{ route('product', $item->product->slug ?? '#') }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i> View Product
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if(method_exists($wishlistItems, 'links'))
                    <div class="d-flex justify-content-center mt-4">
                        {{ $wishlistItems->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-heart fa-5x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">Your wishlist is empty</h4>
                    <p class="text-muted mb-4">Save items you love to your wishlist and shop them later.</p>
                    <a href="{{ route('products') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Logout Form -->
<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>
@endsection

@push('styles')
<style>
.avatar-lg {
    width: 4rem;
    height: 4rem;
}

.avatar-title {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
    font-weight: 600;
}

.nav-pills .nav-link {
    border-radius: 0.375rem;
    margin-bottom: 0.25rem;
    color: #6c757d;
}

.nav-pills .nav-link:hover {
    background-color: #f8f9fa;
    color: #495057;
}

.nav-pills .nav-link.active {
    background-color: #0d6efd;
    color: white;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    transition: all 0.15s ease-in-out;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transform: translateY(-2px);
}
</style>
@endpush

@push('scripts')
<script>
function removeFromWishlist(itemId) {
    if (confirm('Are you sure you want to remove this item from your wishlist?')) {
        fetch(`/user/wishlist/${itemId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error removing item from wishlist');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error removing item from wishlist');
        });
    }
}


</script>
@endpush