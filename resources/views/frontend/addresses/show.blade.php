@extends('frontend.layouts.app')

@section('title', 'Address Details')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            @include('frontend.layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Address Details</h4>
                    <div>
                        <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-primary me-2">
                            <i class="fas fa-edit"></i> Edit Address
                        </a>
                        <a href="{{ route('addresses.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Addresses
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="address-details">
                                <div class="mb-4">
                                    <h5 class="text-primary mb-3">{{ $address->name }}</h5>
                                    
                                    @if($address->default_shipping || $address->default_billing)
                                        <div class="mb-3">
                                            @if($address->default_shipping)
                                                <span class="badge bg-primary me-2">Default Shipping Address</span>
                                            @endif
                                            @if($address->default_billing)
                                                <span class="badge bg-success">Default Billing Address</span>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Email:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $address->email }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Phone:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $address->phone }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Address Type:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        <span class="badge bg-secondary">{{ ucfirst($address->type) }}</span>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Full Address:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $address->address }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>City:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $address->city->name ?? 'N/A' }}
                                    </div>
                                </div>

                                @if($address->zip_code)
                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>ZIP Code:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $address->zip_code }}
                                    </div>
                                </div>
                                @endif

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>State:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $address->countryState->name ?? 'N/A' }}
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-4">
                                        <strong>Country:</strong>
                                    </div>
                                    <div class="col-sm-8">
                                        {{ $address->country->name ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4">
                            <div class="card bg-light">
                                <div class="card-header">
                                    <h6 class="mb-0">Quick Actions</h6>
                                </div>
                                <div class="card-body">
                                    @if(!$address->default_shipping)
                                        <form action="{{ route('addresses.set-default-shipping', $address->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-primary btn-sm w-100">
                                                <i class="fas fa-shipping-fast"></i> Set as Default Shipping
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(!$address->default_billing)
                                        <form action="{{ route('addresses.set-default-billing', $address->id) }}" method="POST" class="mb-2">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                                <i class="fas fa-credit-card"></i> Set as Default Billing
                                            </button>
                                        </form>
                                    @endif
                                    
                                    <a href="{{ route('addresses.edit', $address->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                                        <i class="fas fa-edit"></i> Edit Address
                                    </a>
                                    
                                    @if(!($address->default_billing && $address->default_shipping))
                                        <form action="{{ route('addresses.destroy', $address->id) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this address?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm w-100">
                                                <i class="fas fa-trash"></i> Delete Address
                                            </button>
                                        </form>
                                    @else
                                        <div class="alert alert-info alert-sm mb-0">
                                            <small><i class="fas fa-info-circle"></i> Default addresses cannot be deleted.</small>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.address-details .row {
    border-bottom: 1px solid #f0f0f0;
    padding: 10px 0;
}
.address-details .row:last-child {
    border-bottom: none;
}
.alert-sm {
    padding: 0.5rem;
    font-size: 0.875rem;
}
</style>
@endpush