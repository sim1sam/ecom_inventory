<div class="card">
    <div class="card-header">
        <h5 class="mb-0">My Account</h5>
    </div>
    <div class="list-group list-group-flush">
        <a href="{{ route('user.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
        </a>
        <a href="{{ route('user.profile') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.profile') ? 'active' : '' }}">
            <i class="fas fa-user me-2"></i> Profile
        </a>
        <a href="{{ route('user.orders') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.orders*') ? 'active' : '' }}">
            <i class="fas fa-shopping-bag me-2"></i> My Orders
        </a>
        <a href="{{ route('addresses.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('addresses*') ? 'active' : '' }}">
            <i class="fas fa-map-marker-alt me-2"></i> My Addresses
        </a>
        <a href="{{ route('user.wishlist') }}" class="list-group-item list-group-item-action {{ request()->routeIs('user.wishlist') ? 'active' : '' }}">
            <i class="fas fa-heart me-2"></i> Wishlist
        </a>
        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action text-danger"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt me-2"></i> Logout
        </a>
    </div>
</div>

<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
    @csrf
</form>