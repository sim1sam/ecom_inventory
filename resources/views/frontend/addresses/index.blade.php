@extends('frontend.layouts.app')

@section('title', 'My Addresses')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            @include('frontend.layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">My Addresses</h4>
                    <a href="{{ route('addresses.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add New Address
                    </a>
                </div>
                <div class="card-body">

                    @if($addresses->count() > 0)
                        <div class="row">
                            @foreach($addresses as $address)
                                <div class="col-md-6 mb-4">
                                    <div class="card h-100 {{ $address->default_shipping || $address->default_billing ? 'border-primary' : '' }}">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="card-title mb-0">{{ $address->name }}</h6>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="{{ route('addresses.show', $address->id) }}"><i class="fas fa-eye"></i> View</a></li>
                                                        <li><a class="dropdown-item" href="{{ route('addresses.edit', $address->id) }}"><i class="fas fa-edit"></i> Edit</a></li>
                                                        @if(!$address->default_shipping)
                                                            <li>
                                                                <form action="{{ route('addresses.set-default-shipping', $address->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item"><i class="fas fa-shipping-fast"></i> Set as Default Shipping</button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        @if(!$address->default_billing)
                                                            <li>
                                                                <form action="{{ route('addresses.set-default-billing', $address->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <button type="submit" class="dropdown-item"><i class="fas fa-credit-card"></i> Set as Default Billing</button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                        @if(!($address->default_billing && $address->default_shipping))
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this address?')">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit" class="dropdown-item text-danger"><i class="fas fa-trash"></i> Delete</button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </div>
                                            
                                            @if($address->default_shipping || $address->default_billing)
                                                <div class="mb-2">
                                                    @if($address->default_shipping)
                                                        <span class="badge bg-primary me-1">Default Shipping</span>
                                                    @endif
                                                    @if($address->default_billing)
                                                        <span class="badge bg-success">Default Billing</span>
                                                    @endif
                                                </div>
                                            @endif

                                            <p class="card-text mb-1"><strong>Email:</strong> {{ $address->email }}</p>
                                            <p class="card-text mb-1"><strong>Phone:</strong> {{ $address->phone }}</p>
                                            <p class="card-text mb-1"><strong>Type:</strong> <span class="badge bg-secondary">{{ ucfirst($address->type) }}</span></p>
                                            <p class="card-text mb-2"><strong>Address:</strong> {{ $address->address }}</p>
                                            @if($address->zip_code)
                                            <p class="card-text mb-1"><strong>ZIP Code:</strong> {{ $address->zip_code }}</p>
                                            @endif
                                            <p class="card-text mb-0">
                                                <small class="text-muted">
                                                    {{ $address->city->name ?? 'N/A' }}, {{ $address->countryState->name ?? 'N/A' }}, {{ $address->country->name ?? 'N/A' }}
                                                </small>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-map-marker-alt fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No addresses found</h5>
                            <p class="text-muted">You haven't added any addresses yet.</p>
                            <a href="{{ route('addresses.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Your First Address
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Fix dropdown positioning and hover behavior for multiple addresses */
.dropdown {
    position: relative;
}

.dropdown-menu {
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1000;
    min-width: 160px;
    padding: 0.5rem 0;
    margin: 0;
    font-size: 0.875rem;
    color: #212529;
    text-align: left;
    list-style: none;
    background-color: #fff;
    background-clip: padding-box;
    border: 1px solid rgba(0,0,0,.15);
    border-radius: 0.375rem;
    box-shadow: 0 0.5rem 1rem rgba(0,0,0,.175);
}

.dropdown-toggle:focus {
    outline: 0;
    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
}

.dropdown-item {
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
    transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out;
}

.dropdown-item:hover,
.dropdown-item:focus {
    color: #1e2125;
    background-color: #e9ecef;
}

.dropdown-item.text-danger:hover,
.dropdown-item.text-danger:focus {
    color: #fff;
    background-color: #dc3545;
}

/* Ensure cards don't interfere with dropdown positioning */
.card {
    overflow: visible;
}

.card-body {
    overflow: visible;
}

/* Improve responsive behavior */
@media (max-width: 768px) {
    .dropdown-menu {
        right: 0;
        left: auto;
    }
}
</style>
@endpush

@push('scripts')
<script>
    // Auto-hide alerts after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
    
    // Ensure Bootstrap 5 dropdown functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Initialize all dropdowns
        var dropdownElementList = [].slice.call(document.querySelectorAll('.dropdown-toggle'));
        var dropdownList = dropdownElementList.map(function (dropdownToggleEl) {
            return new bootstrap.Dropdown(dropdownToggleEl);
        });
    });
</script>
@endpush