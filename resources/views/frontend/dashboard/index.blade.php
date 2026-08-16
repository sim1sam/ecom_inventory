@extends('frontend.layouts.app')

@section('title', 'Dashboard')

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
                        <a class="nav-link active" href="{{ route('dashboard') }}">
                            <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                        </a>
                        <a class="nav-link" href="{{ route('profile') }}">
                            <i class="fas fa-user me-2"></i> Profile
                        </a>
                        <a class="nav-link" href="{{ route('orders') }}">
                            <i class="fas fa-shopping-bag me-2"></i> Orders
                        </a>
                        <a class="nav-link" href="{{ route('wishlist') }}">
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
            <div class="row">
                <!-- Welcome Card -->
                <div class="col-12 mb-4">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <h4 class="card-title mb-2">Welcome back, {{ auth()->user()->name }}!</h4>
                            <p class="card-text mb-0">Manage your account and track your orders from your dashboard.</p>
                        </div>
                    </div>
                </div>

                <!-- Stats Cards -->
                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="text-primary mb-2">
                                <i class="fas fa-shopping-bag fa-2x"></i>
                            </div>
                            <h5 class="card-title">{{ $totalOrders ?? 0 }}</h5>
                            <p class="card-text text-muted">Total Orders</p>
                            <a href="{{ route('orders') }}" class="btn btn-outline-primary btn-sm">View Orders</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="text-success mb-2">
                                <i class="fas fa-check-circle fa-2x"></i>
                            </div>
                            <h5 class="card-title">{{ $completedOrders ?? 0 }}</h5>
                            <p class="card-text text-muted">Completed Orders</p>
                            <a href="{{ route('orders') }}?status=3" class="btn btn-outline-success btn-sm">View Completed</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="text-danger mb-2">
                                <i class="fas fa-heart fa-2x"></i>
                            </div>
                            <h5 class="card-title">{{ $wishlistCount ?? 0 }}</h5>
                            <p class="card-text text-muted">Wishlist Items</p>
                            <a href="{{ route('wishlist') }}" class="btn btn-outline-danger btn-sm">View Wishlist</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Orders</h5>
                            <a href="{{ route('orders') }}" class="btn btn-primary btn-sm">View All</a>
                        </div>
                        <div class="card-body">
                            @if(isset($recentOrders) && $recentOrders->count() > 0)
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Order #</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($recentOrders as $order)
                                            <tr>
                                                <td><strong>#{{ $order->order_id ?? $order->id }}</strong></td>
                                                <td>{{ $order->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    @php
                                                        $statusText = '';
                                                        $statusClass = '';
                                                        switch($order->order_status) {
                                                            case 0:
                                                                $statusText = 'Pending';
                                                                $statusClass = 'warning';
                                                                break;
                                                            case 1:
                                                                $statusText = 'In Progress';
                                                                $statusClass = 'info';
                                                                break;
                                                            case 2:
                                                                $statusText = 'Delivered';
                                                                $statusClass = 'primary';
                                                                break;
                                                            case 3:
                                                                $statusText = 'Completed';
                                                                $statusClass = 'success';
                                                                break;
                                                            case 4:
                                                                $statusText = 'Declined';
                                                                $statusClass = 'danger';
                                                                break;
                                                            default:
                                                                $statusText = 'Unknown';
                                                                $statusClass = 'secondary';
                                                        }
                                                    @endphp
                                                    <span class="badge bg-{{ $statusClass }}">
                                                        {{ $statusText }}
                                                    </span>
                                                </td>
                                                <td>${{ number_format($order->total_amount ?? 0, 2) }}</td>
                                                <td>
                                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">View</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="text-center py-4">
                                    <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                                    <h5 class="text-muted">No orders yet</h5>
                                    <p class="text-muted">Start shopping to see your orders here.</p>
                                    <a href="{{ route('products') }}" class="btn btn-primary">Start Shopping</a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
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
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    transition: box-shadow 0.15s ease-in-out;
}
</style>
@endpush