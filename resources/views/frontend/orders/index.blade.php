@extends('frontend.layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-0">My Orders</h2>
                <a href="{{ route('home') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                </a>
            </div>

            @if($orders && $orders->count() > 0)
                <div class="card shadow-sm">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th scope="col">Order ID</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Total</th>
                                        <th scope="col">Payment Status</th>
                                        <th scope="col">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <strong class="text-primary">#{{ $order->order_id ?? $order->id }}</strong>
                                        </td>
                                        <td>
                                            <small class="text-muted">{{ $order->created_at->format('M d, Y') }}</small><br>
                                            <small class="text-muted">{{ $order->created_at->format('h:i A') }}</small>
                                        </td>
                                        <td>
                                            @php
                                                $statusClass = 'secondary';
                                                $statusText = 'Unknown';
                                                
                                                if(isset($order->order_status)) {
                                                    switch($order->order_status) {
                                                        case 0:
                                                            $statusClass = 'warning';
                                                            $statusText = 'Pending';
                                                            break;
                                                        case 1:
                                                            $statusClass = 'info';
                                                            $statusText = 'In Progress';
                                                            break;
                                                        case 2:
                                                            $statusClass = 'primary';
                                                            $statusText = 'Delivered';
                                                            break;
                                                        case 3:
                                                            $statusClass = 'success';
                                                            $statusText = 'Completed';
                                                            break;
                                                        case 4:
                                                            $statusClass = 'danger';
                                                            $statusText = 'Declined';
                                                            break;
                                                    }
                                                } elseif(isset($order->status)) {
                                                    $statusText = ucfirst($order->status);
                                                    $statusClass = $order->status == 'completed' ? 'success' : ($order->status == 'pending' ? 'warning' : 'info');
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">{{ $statusText }}</span>
                                        </td>
                                        <td>
                                            <strong class="text-success">
                                                ${{ number_format($order->total_amount ?? $order->amount_real_currency ?? 0, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            @php
                                                $paymentStatusClass = 'secondary';
                                                $paymentStatusText = 'Unknown';
                                                
                                                if(isset($order->payment_status)) {
                                                    switch($order->payment_status) {
                                                        case 0:
                                                            $paymentStatusClass = 'warning';
                                                            $paymentStatusText = 'Pending';
                                                            break;
                                                        case 1:
                                                            $paymentStatusClass = 'success';
                                                            $paymentStatusText = 'Paid';
                                                            break;
                                                    }
                                                }
                                            @endphp
                                            <span class="badge bg-{{ $paymentStatusClass }}">{{ $paymentStatusText }}</span>
                                        </td>
                                        <td>
                                            <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>View Details
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                @if(method_exists($orders, 'links'))
                <div class="d-flex justify-content-center mt-4">
                    {{ $orders->links() }}
                </div>
                @endif
            @else
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-shopping-bag fa-4x text-muted"></i>
                    </div>
                    <h4 class="text-muted mb-3">No Orders Found</h4>
                    <p class="text-muted mb-4">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                    <a href="{{ route('home') }}" class="btn btn-primary">
                        <i class="fas fa-shopping-bag me-2"></i>Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
}

.table td {
    vertical-align: middle;
}

.badge {
    font-size: 0.75rem;
    padding: 0.375rem 0.75rem;
}

.btn-sm {
    padding: 0.25rem 0.75rem;
    font-size: 0.875rem;
}

.card {
    border: 1px solid #e3e6f0;
}

.table-hover tbody tr:hover {
    background-color: #f8f9fc;
}
</style>
@endpush