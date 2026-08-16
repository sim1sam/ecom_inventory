@extends('frontend.layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="container my-5">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('cart') }}">Cart</a></li>
            <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
    </nav>


    <div class="row">
        <div class="col-lg-8">
            <form id="checkout-form" action="{{ route('checkout.place-order') }}" method="POST">
                @csrf
                
                <!-- Billing Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Billing Information</h5>
                    </div>
                    <div class="card-body">
                        @auth
                        <div class="mb-3">
                            <label for="saved_address" class="form-label">Select from Address Book</label>
                            <select class="form-select" id="saved_address" name="saved_address" onchange="populateAddress(this.value)">
                                <option value="">Choose a saved address or enter new one</option>
                                @forelse($addresses as $index => $address)
                                    <option value="{{ $index }}" 
                                            data-name="{{ $address->name ?? '' }}"
                                            data-email="{{ $address->email ?? '' }}"
                                            data-phone="{{ $address->phone ?? '' }}"
                                            data-address="{{ $address->address ?? '' }}"
                                            data-country="{{ $address->country_id ?? '' }}"
                                            data-state="{{ $address->state_id ?? '' }}"
                                            data-city="{{ $address->city_id ?? '' }}"
                                            data-zip="{{ $address->zip_code ?? '' }}">
                                        {{ $address->name ?? 'Address' }} - {{ $address->address ?? 'No address' }}@if(isset($address->city) && $address->city), {{ $address->city->name }}@endif
                                    </option>
                                @empty
                                    <option value="" disabled>No saved addresses found</option>
                                @endforelse
                            </select>
                            
                            
                        </div>
                        @endauth
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="first_name" name="billing_first_name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="last_name" name="billing_last_name" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="email" name="billing_email" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="phone" name="billing_phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Street Address *</label>
                            <input type="text" class="form-control" id="address" name="billing_address" placeholder="House number and street name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="address2" name="billing_address2" placeholder="Apartment, suite, unit etc. (optional)">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="country" class="form-label">Country *</label>
                                <select class="form-select" id="country" name="billing_country" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State *</label>
                                <select class="form-select" id="state" name="billing_state" required>
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City *</label>
                                <select class="form-select" id="city" name="billing_city" required>
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="zip" class="form-label">ZIP Code *</label>
                            <input type="text" class="form-control" id="zip" name="billing_zip" required>
                        </div>
                    </div>
                </div>

                <!-- Shipping Information -->
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Shipping Information</h5>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="same-as-billing" checked>
                                <label class="form-check-label" for="same-as-billing">
                                    Same as billing address
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="shipping-form" style="display: none;">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="ship_first_name" class="form-label">First Name *</label>
                                <input type="text" class="form-control" id="ship_first_name" name="shipping_first_name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="ship_last_name" class="form-label">Last Name *</label>
                                <input type="text" class="form-control" id="ship_last_name" name="shipping_last_name">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ship_email" class="form-label">Email Address *</label>
                            <input type="email" class="form-control" id="ship_email" name="shipping_email">
                        </div>
                        <div class="mb-3">
                            <label for="ship_phone" class="form-label">Phone Number *</label>
                            <input type="tel" class="form-control" id="ship_phone" name="shipping_phone">
                        </div>
                        <div class="mb-3">
                            <label for="ship_address" class="form-label">Street Address *</label>
                            <input type="text" class="form-control" id="ship_address" name="shipping_address" placeholder="House number and street name">
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" id="ship_address2" name="shipping_address2" placeholder="Apartment, suite, unit etc. (optional)">
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="ship_country" class="form-label">Country *</label>
                                <select class="form-select" id="ship_country" name="shipping_country">
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ship_state" class="form-label">State *</label>
                                <select class="form-select" id="ship_state" name="shipping_state">
                                    <option value="">Select State</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="ship_city" class="form-label">City *</label>
                                <select class="form-select" id="ship_city" name="shipping_city">
                                    <option value="">Select City</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="ship_zip" class="form-label">ZIP Code *</label>
                            <input type="text" class="form-control" id="ship_zip" name="shipping_zip">
                        </div>
                    </div>
                </div>

                <!-- Shipping Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Shipping Method</h5>
                    </div>
                    <div class="card-body shipping-methods">
                        @if($shippingMethods && $shippingMethods->count() > 0)
                            @foreach($shippingMethods as $index => $shipping)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="shipping_method" id="shipping_{{ $shipping->id }}" 
                                       value="{{ $shipping->id }}" {{ $index == 0 ? 'checked' : '' }}
                                       data-cost="{{ $shipping->shipping_fee }}">
                                <label class="form-check-label w-100" for="shipping_{{ $shipping->id }}">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $shipping->shipping_rule }}</strong>
                                            <small class="d-block text-muted">{{ $shipping->shipping_fee > 0 ? 'Delivery time: 3-5 business days' : 'Free shipping' }}</small>
                                        </div>
                                        <div class="text-end">
                                            <strong class="text-success">
                                                @if($shipping->shipping_fee > 0)
                                                    ${{ number_format($shipping->shipping_fee, 2) }}
                                                @else
                                                    Free
                                                @endif
                                            </strong>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                No shipping methods available. Please contact support.
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Payment Method -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Payment Method</h5>
                    </div>
                    <div class="card-body">
                        <div id="payment-methods-container">
                            {{-- Cash on Delivery --}}
                            @if($bank_payment_setting && $bank_payment_setting->cash_on_delivery_status == 1)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" value="cash_on_delivery" checked>
                                <label class="form-check-label w-100" for="cash_on_delivery">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-money-bill-wave me-3 text-success" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>Cash on Delivery</strong>
                                            <small class="d-block text-muted">Pay when you receive your order</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endif

                            {{-- Stripe --}}
                            @if(isset($stripe_setting) && $stripe_setting->status == 1)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="stripe" value="stripe">
                                <label class="form-check-label w-100" for="stripe">
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-stripe me-3 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>Credit/Debit Card (Stripe)</strong>
                                            <small class="d-block text-muted">Pay securely with your credit or debit card</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endif

                            {{-- PayPal --}}
                            @if(isset($paypal_setting) && $paypal_setting->status == 1)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal">
                                <label class="form-check-label w-100" for="paypal">
                                    <div class="d-flex align-items-center">
                                        <i class="fab fa-paypal me-3 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>PayPal</strong>
                                            <small class="d-block text-muted">Pay with your PayPal account</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endif

                            {{-- Bank Payment --}}
                            @if(isset($bank_payment_setting) && $bank_payment_setting->status == 1)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="bank_payment" value="bank_payment">
                                <label class="form-check-label w-100" for="bank_payment">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-university me-3 text-secondary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>Bank Transfer</strong>
                                            <small class="d-block text-muted">Transfer directly to our bank account</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endif

                            {{-- SSLCommerz --}}
                            @if(isset($sslcommerz_setting) && $sslcommerz_setting->status == 1)
                            <div class="form-check mb-3">
                                <input class="form-check-input" type="radio" name="payment_method" id="sslcommerz" value="sslcommerz">
                                <label class="form-check-label w-100" for="sslcommerz">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-credit-card me-3 text-primary" style="font-size: 1.5rem;"></i>
                                        <div>
                                            <strong>SSLCommerz</strong>
                                            <small class="d-block text-muted">Pay with cards, mobile banking & internet banking</small>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @endif
                        </div>
                        

                        
                        <!-- Bank Payment Info (hidden by default) -->
                        <div id="bank-payment-info" style="display: none;">
                            <div class="alert alert-info">
                                <h6>Bank Transfer Details:</h6>
                                <div id="bank-account-details">
                                    <!-- Bank account information will be loaded dynamically -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Notes -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Order Notes (Optional)</h5>
                    </div>
                    <div class="card-body">
                        <textarea class="form-control" id="order_notes" name="order_notes" rows="3" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                    </div>
                </div>
                
                <!-- Hidden field for same_as_billing -->
                <input type="hidden" name="same_as_billing" id="same_as_billing_hidden" value="1">
            </form>
        </div>

        <div class="col-lg-4">
            <!-- Order Summary -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Order Summary</h5>
                </div>
                <div class="card-body">
                    <div id="order-items">
                        <!-- Order items will be loaded here -->
                    </div>
                    
                    <hr>
                    
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotal">$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Shipping:</span>
                        <span id="shipping-cost">$10.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Tax:</span>
                        <span id="tax">$0.00</span>
                    </div>
                    
                    <!-- Coupon Section -->
                    <div class="mb-3">
                        <div class="input-group">
                            <input type="text" class="form-control" id="coupon-code" placeholder="Enter coupon code">
                            <button class="btn btn-outline-secondary" type="button" id="apply-coupon-btn">
                                Apply Coupon
                            </button>
                        </div>
                        <div id="coupon-info" class="mt-2" style="display: none;">
                            <div class="alert alert-success py-2 mb-0">
                                <small id="coupon-info-text"></small>
                                <button type="button" class="btn-close btn-sm float-end" id="remove-coupon" aria-label="Remove coupon"></button>
                            </div>
                        </div>
                    </div>
                    
                    <hr>
                    <div class="d-flex justify-content-between mb-2" id="coupon-discount" style="display: none;">
                        <span>Coupon Discount:</span>
                        <span id="coupon-discount-amount" class="text-success">-$0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <strong>Total:</strong>
                        <strong id="total">$0.00</strong>
                    </div>
                    
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg" id="place-order-btn" form="checkout-form">
                            <i class="fas fa-lock me-2"></i>Place Order
                        </button>
                    </div>
                    
                    <div class="text-center mt-3">
                        <small class="text-muted">
                            <i class="fas fa-shield-alt me-1"></i>
                            Your payment information is secure and encrypted
                        </small>
                    </div>
                </div>
            </div>

            <!-- Security Badges -->
            <div class="card">
                <div class="card-body text-center">
                    <h6 class="mb-3">Secure Checkout</h6>
                    <div class="d-flex justify-content-center gap-3">
                        <i class="fab fa-cc-visa fa-2x text-muted"></i>
                        <i class="fab fa-cc-mastercard fa-2x text-muted"></i>
                        <i class="fab fa-cc-amex fa-2x text-muted"></i>
                        <i class="fab fa-paypal fa-2x text-muted"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.order-item {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.order-item:last-child {
    border-bottom: none;
}

.order-item img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    border-radius: 4px;
}

.order-item-info {
    flex: 1;
}

.order-item-name {
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 2px;
}

.order-item-details {
    font-size: 12px;
    color: #666;
}

.order-item-price {
    font-weight: 600;
    color: #d4af37;
}

.form-check-label {
    width: 100%;
}

.payment-icons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.payment-icons i {
    font-size: 24px;
    color: #666;
}
</style>

<script>
// Address population function - defined first to ensure it's available
// Fast loaders without arbitrary delays
function loadStatesForCountry(countryId) {
    return new Promise(function(resolve, reject) {
        var stateSelect = $('#state');
        var citySelect = $('#city');
        stateSelect.html('<option value="">Select State</option>').prop('disabled', true);
        citySelect.html('<option value="">Select City</option>').prop('disabled', true);
        if (!countryId) { resolve(); return; }
        $.ajax({
            url: '{{ url("public/states") }}/' + countryId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (Array.isArray(data) && data.length > 0) {
                    $.each(data, function(_, value) {
                        stateSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    stateSelect.prop('disabled', false);
                }
                resolve();
            },
            error: function(err) { resolve(); }
        });
    });
}

function loadCitiesForState(stateId) {
    return new Promise(function(resolve, reject) {
        var citySelect = $('#city');
        citySelect.html('<option value="">Select City</option>').prop('disabled', true);
        if (!stateId) { resolve(); return; }
        $.ajax({
            url: '{{ url("public/cities") }}/' + stateId,
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                if (Array.isArray(data) && data.length > 0) {
                    $.each(data, function(_, value) {
                        citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                    });
                    citySelect.prop('disabled', false);
                }
                resolve();
            },
            error: function(err) { resolve(); }
        });
    });
}

function populateAddress(index) {
    console.log('populateAddress called with index:', index);
    
    // Check if the saved_address element exists (only for authenticated users)
    const savedAddressSelect = document.getElementById('saved_address');
    if (!savedAddressSelect) {
        console.log('saved_address element not found - user may not be authenticated');
        return;
    }
    
    if (index === '' || index === null || index === undefined) {
        console.log('Empty index, clearing form');
        clearAddressForm();
        return;
    }
    
    const option = document.querySelector('#saved_address option[value="' + index + '"]');
    if (!option) {
        console.log('Option not found for index:', index);
        console.log('Available options:', document.querySelectorAll('#saved_address option'));
        return;
    }
    
    console.log('Found option:', option);
    console.log('Option data:', {
        name: option.dataset.name,
        email: option.dataset.email,
        phone: option.dataset.phone,
        address: option.dataset.address,
        country: option.dataset.country,
        state: option.dataset.state,
        city: option.dataset.city,
        zip: option.dataset.zip
    });
    
    // Populate basic fields
    const name = option.dataset.name || '';
    const nameParts = name.split(' ');
    
    const firstNameField = document.getElementById('first_name');
    const lastNameField = document.getElementById('last_name');
    const emailField = document.getElementById('email');
    const phoneField = document.getElementById('phone');
    const addressField = document.getElementById('address');
    const zipField = document.getElementById('zip');
    
    console.log('Form fields found:', {
        firstName: !!firstNameField,
        lastName: !!lastNameField,
        email: !!emailField,
        phone: !!phoneField,
        address: !!addressField,
        zip: !!zipField
    });
    
    if (firstNameField) {
        firstNameField.value = nameParts[0] || '';
        console.log('Set first name:', nameParts[0] || '');
    }
    if (lastNameField) {
        lastNameField.value = nameParts.slice(1).join(' ') || '';
        console.log('Set last name:', nameParts.slice(1).join(' ') || '');
    }
    if (emailField) {
        emailField.value = option.dataset.email || '';
        console.log('Set email:', option.dataset.email || '');
    }
    if (phoneField) {
        phoneField.value = option.dataset.phone || '';
        console.log('Set phone:', option.dataset.phone || '');
    }
    if (addressField) {
        addressField.value = option.dataset.address || '';
        console.log('Set address:', option.dataset.address || '');
    }
    if (zipField) {
        zipField.value = option.dataset.zip || '';
        console.log('Set zip:', option.dataset.zip || '');
    }
    
    // Set country, state, city by awaiting AJAX completion (no timeouts)
    const countryField = document.getElementById('country');
    const stateField = document.getElementById('state');
    const cityField = document.getElementById('city');
    
    console.log('Location fields found:', {
        country: !!countryField,
        state: !!stateField,
        city: !!cityField
    });
    
    if (countryField && option.dataset.country) {
        console.log('Setting country:', option.dataset.country);
        countryField.value = option.dataset.country;
        // Load states, then set state and load cities, then set city
        loadStatesForCountry(option.dataset.country).then(function() {
            if (stateField && option.dataset.state) {
                console.log('Setting state:', option.dataset.state);
                stateField.value = option.dataset.state;
                return loadCitiesForState(option.dataset.state).then(function() {
                    if (cityField && option.dataset.city) {
                        console.log('Setting city:', option.dataset.city);
                        cityField.value = option.dataset.city;
                    }
                });
            }
        });
    }
    
    // Also populate shipping address if "Same as billing" is unchecked
    const sameAsBillingCheckbox = document.getElementById('same-as-billing');
    if (sameAsBillingCheckbox && !sameAsBillingCheckbox.checked) {
        populateShippingAddress(option);
    }
    
    console.log('Address populated successfully');
}

// Function to populate shipping address with selected address data
function populateShippingAddress(option) {
    const name = option.dataset.name || '';
    const nameParts = name.split(' ');
    
    const shipFirstNameField = document.getElementById('ship_first_name');
    const shipLastNameField = document.getElementById('ship_last_name');
    const shipEmailField = document.getElementById('ship_email');
    const shipPhoneField = document.getElementById('ship_phone');
    const shipAddressField = document.getElementById('ship_address');
    const shipZipField = document.getElementById('ship_zip');
    
    if (shipFirstNameField) shipFirstNameField.value = nameParts[0] || '';
    if (shipLastNameField) shipLastNameField.value = nameParts.slice(1).join(' ') || '';
    if (shipEmailField) shipEmailField.value = option.dataset.email || '';
    if (shipPhoneField) shipPhoneField.value = option.dataset.phone || '';
    if (shipAddressField) shipAddressField.value = option.dataset.address || '';
    if (shipZipField) shipZipField.value = option.dataset.zip || '';
    
    // Set shipping country, state, city with proper delays
    const shipCountryField = document.getElementById('ship_country');
    const shipStateField = document.getElementById('ship_state');
    const shipCityField = document.getElementById('ship_city');
    
    if (shipCountryField && option.dataset.country) {
        shipCountryField.value = option.dataset.country;
        shipCountryField.dispatchEvent(new Event('change'));
        
        setTimeout(() => {
            if (shipStateField && option.dataset.state) {
                shipStateField.value = option.dataset.state;
                shipStateField.dispatchEvent(new Event('change'));
                
                setTimeout(() => {
                    if (shipCityField && option.dataset.city) {
                        shipCityField.value = option.dataset.city;
                    }
                }, 1500);
            }
        }, 1500);
    }
}

// Function to clear address form
function clearAddressForm() {
    const fields = ['first_name', 'last_name', 'email', 'phone', 'address', 'zip'];
    fields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    });
    
    const selectFields = ['country', 'state', 'city'];
    selectFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    });
    
    // Also clear shipping form if it's visible
    const sameAsBillingCheckbox = document.getElementById('same-as-billing');
    if (sameAsBillingCheckbox && !sameAsBillingCheckbox.checked) {
        clearShippingForm();
    }
}

// Function to clear shipping address form
function clearShippingForm() {
    const shipFields = ['ship_first_name', 'ship_last_name', 'ship_email', 'ship_phone', 'ship_address', 'ship_zip'];
    shipFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    });
    
    const shipSelectFields = ['ship_country', 'ship_state', 'ship_city'];
    shipSelectFields.forEach(fieldId => {
        const field = document.getElementById(fieldId);
        if (field) field.value = '';
    });
}

class Checkout {
    constructor() {
        this.cart = [];
        this.shippingMethods = [];
        this.appliedCoupon = null;
        this.userData = null; // Store user data without auto-populating
        this.init();
    }

    async init() {
        await this.loadCheckoutData();
        this.bindEvents();
        this.formatCardInputs();
    }

    bindEvents() {
        // Address dropdown change
        const savedAddressSelect = document.getElementById('saved_address');
        if (savedAddressSelect) {
            savedAddressSelect.addEventListener('change', (e) => {
                populateAddress(e.target.value);
            });
        }

        // Same as billing checkbox
        document.getElementById('same-as-billing').addEventListener('change', (e) => {
            const shippingForm = document.getElementById('shipping-form');
            const hiddenField = document.getElementById('same_as_billing_hidden');
            
            shippingForm.style.display = e.target.checked ? 'none' : 'block';
            hiddenField.value = e.target.checked ? '1' : '0';
            
            // If unchecking "same as billing" and there's a selected address, auto-fill shipping
            if (!e.target.checked) {
                const savedAddressSelect = document.getElementById('saved_address');
                if (savedAddressSelect && savedAddressSelect.value !== '') {
                    const selectedOption = savedAddressSelect.options[savedAddressSelect.selectedIndex];
                    if (selectedOption) {
                        populateShippingAddress(selectedOption);
                    }
                }
            }
        });

        // Shipping method change events are now bound in loadShippingMethods()

        // Payment method change
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', () => {
                this.togglePaymentForms();
            });
        });

        // Place order button - now uses form submission instead of JavaScript
        
        // Coupon application (if coupon form exists)
        const applyCouponBtn = document.getElementById('apply-coupon-btn');
        if (applyCouponBtn) {
            applyCouponBtn.addEventListener('click', () => {
                this.applyCoupon();
            });
        }
        
        const removeCouponBtn = document.getElementById('remove-coupon');
        if (removeCouponBtn) {
            removeCouponBtn.addEventListener('click', () => {
                this.removeCoupon();
            });
        }
    }

    async loadCheckoutData() {
        try {
            const response = await fetch('{{ route("checkout.data") }}', {
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });
            
            const data = await response.json();
            console.log('Checkout data received:', data);
            
            if (data.success) {
                this.cart = data.cart_items;
                this.shippingMethods = data.shipping_methods;
                this.paymentGateways = {
                    cash_on_delivery: { status: (data.bankPaymentInfo && data.bankPaymentInfo.cash_on_delivery_status) || 0 },
                    stripe: data.stripePaymentInfo,
                    paypal: data.paypalPaymentInfo,
                    razorpay: data.razorpayPaymentInfo,
                    flutterwave: data.flutterwavePaymentInfo,
                    mollie: data.molliePaymentInfo,
                    instamojo: data.instamojo,
                    paystack: data.paystack,
                    sslcommerz: data.sslcommerz,
                    bank_payment: data.bankPaymentInfo
                };
                console.log('Payment gateways:', this.paymentGateways);
                this.loadOrderSummary();
                this.loadShippingMethods();
                this.loadPaymentMethods();
                this.loadBankAccountDetails(data.bankPaymentInfo);
                
                // Store user data for potential use but don't auto-populate
                if (data.user) {
                    this.userData = data.user;
                }
                
                // Populate address dropdown and pre-fill if available
                if (data.addresses && data.addresses.length > 0) {
                    this.populateAddressDropdown(data.addresses);
                    // Optionally pre-populate with first address
                    // this.populateAddressData(data.addresses[0]);
                }
            } else {
                this.showNotification('Failed to load checkout data', 'error');
            }
        } catch (error) {
            console.error('Error loading checkout data:', error);
            this.showNotification('Failed to load checkout data', 'error');
        }
    }
    
    populateUserData(user) {
        // Split name into first and last name if full name is provided
        if (user.name && !user.first_name && !user.last_name) {
            const nameParts = user.name.split(' ');
            user.first_name = nameParts[0] || '';
            user.last_name = nameParts.slice(1).join(' ') || '';
        }
        
        // Populate billing information
        if (user.first_name) document.getElementById('first_name').value = user.first_name;
        if (user.last_name) document.getElementById('last_name').value = user.last_name;
        if (user.email) document.getElementById('email').value = user.email;
        if (user.phone) document.getElementById('phone').value = user.phone;
    }
    
    populateAddressDropdown(addresses) {
        const savedAddressSelect = document.getElementById('saved_address');
        if (!savedAddressSelect) return;
        
        // Clear existing options except the first one
        savedAddressSelect.innerHTML = '<option value="">Choose a saved address or enter new one</option>';
        
        // Add addresses to dropdown
        addresses.forEach((address, index) => {
            const option = document.createElement('option');
            option.value = index;
            const cityName = address.city && address.city.name ? address.city.name : (address.city || '');
            const zipCode = address.zip_code ? ' ' + address.zip_code : '';
            option.textContent = (address.name || 'Address') + ' - ' + address.address + ', ' + cityName + zipCode;
            // Attach data attributes so populateAddress() can use them uniformly
            option.dataset.name = address.name || '';
            option.dataset.email = address.email || '';
            option.dataset.phone = address.phone || '';
            option.dataset.address = address.address || '';
            option.dataset.country = address.country_id || '';
            option.dataset.state = address.state_id || '';
            option.dataset.city = address.city_id || '';
            option.dataset.zip = address.zip_code || '';
            savedAddressSelect.appendChild(option);
        });
        
        // Store addresses for later use
        this.userAddresses = addresses;
        
        // Add event listener for address selection
        savedAddressSelect.addEventListener('change', (e) => {
            if (e.target.value !== '') {
                const selectedAddress = this.userAddresses[e.target.value];
                this.populateAddressData(selectedAddress);
            }
        });
    }
    
    populateAddressData(address) {
        // Populate billing address
        if (address.name) {
            const nameParts = address.name.split(' ');
            document.getElementById('first_name').value = nameParts[0] || '';
            document.getElementById('last_name').value = nameParts.slice(1).join(' ') || '';
        }
        if (address.email) document.getElementById('email').value = address.email;
        if (address.phone) document.getElementById('phone').value = address.phone;
        if (address.address) document.getElementById('address').value = address.address;
        if (address.country_id) document.getElementById('country').value = address.country_id;
        if (address.state_id) document.getElementById('state').value = address.state_id;
        if (address.city_id) document.getElementById('city').value = address.city_id;
        if (address.zip_code) document.getElementById('zip').value = address.zip_code;
        
        // Trigger change events to populate dependent dropdowns
        if (address.country_id) {
            document.getElementById('country').dispatchEvent(new Event('change'));
            setTimeout(() => {
                if (address.state_id) {
                    document.getElementById('state').value = address.state_id;
                    document.getElementById('state').dispatchEvent(new Event('change'));
                    setTimeout(() => {
                        if (address.city_id) {
                            document.getElementById('city').value = address.city_id;
                        }
                    }, 500);
                }
            }, 500);
        }
    }
    
    loadOrderSummary() {
        const orderItemsContainer = document.getElementById('order-items');
        
        if (this.cart.length === 0) {
            orderItemsContainer.innerHTML = '<p class="text-muted">No items in cart</p>';
            return;
        }

        orderItemsContainer.innerHTML = this.cart.map(item => {
            const itemPrice = parseFloat(item.product_price || (item.product && item.product.price) || 0);
            const variantPrice = item.variants ? item.variants.reduce((sum, variant) => {
                return sum + (parseFloat(variant.variant_price) || 0);
            }, 0) : 0;
            const totalItemPrice = (itemPrice + variantPrice) * item.quantity;
            
            return '<div class="order-item">' +
                    '<img src="' + (item.product_image || (item.product && item.product.thumb_image)) + '" alt="' + (item.product_name || (item.product && item.product.name)) + '">' +
                    '<div class="order-item-info">' +
                        '<div class="order-item-name">' + (item.product_name || (item.product && item.product.name)) + '</div>' +
                        '<div class="order-item-details">Qty: ' + item.quantity + '</div>' +
                        (item.variants && item.variants.length > 0 ? 
                            '<div class="order-item-variants">' + 
                            item.variants.map(function(v) { return v.variant_name + ': ' + v.variant_value; }).join(', ') + 
                            '</div>' : '') +
                    '</div>' +
                    '<div class="order-item-price">$' + totalItemPrice.toFixed(2) + '</div>' +
                '</div>';
        }).join('');

        this.updateOrderSummary();
    }
    
    loadShippingMethods() {
        const shippingContainer = document.querySelector('.shipping-methods');
        if (shippingContainer && this.shippingMethods.length > 0) {
            shippingContainer.innerHTML = this.shippingMethods.map(function(method, index) {
                return '<div class="form-check mb-2">' +
                    '<input class="form-check-input" type="radio" name="shipping_method" id="shipping_' + method.id + '" value="' + method.id + '" ' + (index === 0 ? 'checked' : '') + '>' +
                    '<label class="form-check-label d-flex justify-content-between" for="shipping_' + method.id + '">' +
                        '<span>' + method.shipping_rule + '</span>' +
                        '<span class="fw-bold">$' + parseFloat(method.shipping_fee || 0).toFixed(2) + '</span>' +
                    '</label>' +
                '</div>';
            }).join('');
            
            // Bind event listeners after shipping methods are loaded
            document.querySelectorAll('input[name="shipping_method"]').forEach(radio => {
                radio.addEventListener('change', () => {
                    this.updateShippingCost();
                });
            });
            
            // Update shipping cost for the initially selected method
            this.updateShippingCost();
        } else if (shippingContainer) {
            // Show message if no shipping methods available
            shippingContainer.innerHTML = `
                <div class="alert alert-warning" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    No shipping methods available. Please contact support.
                </div>
            `;
        }
    }
    
    loadPaymentMethods() {
        console.log('Loading payment methods...');
        const paymentContainer = document.getElementById('payment-methods-container');
        if (!paymentContainer) {
            console.error('Payment container not found!');
            return;
        }
        
        let paymentMethodsHtml = '';
        let firstActiveMethod = null;
        console.log('Checking payment gateways:', this.paymentGateways);
        
        // Cash on Delivery
        if (this.paymentGateways.cash_on_delivery && this.paymentGateways.cash_on_delivery.status == 1) {
            if (!firstActiveMethod) firstActiveMethod = 'cash_on_delivery';
            paymentMethodsHtml += '<div class="form-check mb-3">' +
                '<input class="form-check-input" type="radio" name="payment_method" id="cash_on_delivery" value="cash_on_delivery" ' + (!firstActiveMethod || firstActiveMethod === 'cash_on_delivery' ? 'checked' : '') + '>' +
                '<label class="form-check-label" for="cash_on_delivery">' +
                    '<i class="fas fa-money-bill-wave me-2"></i>Cash on Delivery' +
                    '<small class="d-block text-muted mt-1">Pay when you receive your order</small>' +
                '</label>' +
            '</div>';
        }
        
        // Stripe
        if (this.paymentGateways.stripe && this.paymentGateways.stripe.status == 1) {
            if (!firstActiveMethod) firstActiveMethod = 'stripe';
            paymentMethodsHtml += '<div class="form-check mb-3">' +
                '<input class="form-check-input" type="radio" name="payment_method" id="stripe" value="stripe" ' + (firstActiveMethod === 'stripe' ? 'checked' : '') + '>' +
                '<label class="form-check-label" for="stripe">' +
                    '<i class="fab fa-stripe me-2"></i>Credit/Debit Card (Stripe)' +
                    '<small class="d-block text-muted mt-1">Pay securely with your credit or debit card</small>' +
                '</label>' +
            '</div>';
        }
        
        // PayPal
        if (this.paymentGateways.paypal && this.paymentGateways.paypal.status == 1) {
            if (!firstActiveMethod) firstActiveMethod = 'paypal';
            paymentMethodsHtml += '<div class="form-check mb-3">' +
                '<input class="form-check-input" type="radio" name="payment_method" id="paypal" value="paypal" ' + (firstActiveMethod === 'paypal' ? 'checked' : '') + '>' +
                '<label class="form-check-label" for="paypal">' +
                    '<i class="fab fa-paypal me-2"></i>PayPal' +
                    '<small class="d-block text-muted mt-1">Pay with your PayPal account</small>' +
                '</label>' +
            '</div>';
        }
            
            // Razorpay
            if (this.paymentGateways.razorpay && this.paymentGateways.razorpay.status == 1) {
                if (!firstActiveMethod) firstActiveMethod = 'razorpay';
                paymentMethodsHtml += '<div class="form-check mb-3">' +
                    '<input class="form-check-input" type="radio" name="payment_method" id="razorpay" value="razorpay" ' + (firstActiveMethod === 'razorpay' ? 'checked' : '') + '>' +
                    '<label class="form-check-label" for="razorpay">' +
                        '<i class="fas fa-credit-card me-2"></i>Razorpay' +
                        '<small class="d-block text-muted mt-1">Pay with cards, UPI, wallets & more</small>' +
                    '</label>' +
                '</div>';
            }
            
            // Flutterwave
            if (this.paymentGateways.flutterwave && this.paymentGateways.flutterwave.status == 1) {
                if (!firstActiveMethod) firstActiveMethod = 'flutterwave';
                paymentMethodsHtml += '<div class="form-check mb-3">' +
                    '<input class="form-check-input" type="radio" name="payment_method" id="flutterwave" value="flutterwave" ' + (firstActiveMethod === 'flutterwave' ? 'checked' : '') + '>' +
                    '<label class="form-check-label" for="flutterwave">' +
                        '<i class="fas fa-credit-card me-2"></i>Flutterwave' +
                        '<small class="d-block text-muted mt-1">Pay with cards, mobile money & bank transfers</small>' +
                    '</label>' +
                '</div>';
            }
            
            // Mollie
            if (this.paymentGateways.mollie && this.paymentGateways.mollie.status == 1) {
                if (!firstActiveMethod) firstActiveMethod = 'mollie';
                paymentMethodsHtml += '<div class="form-check mb-3">' +
                    '<input class="form-check-input" type="radio" name="payment_method" id="mollie" value="mollie" ' + (firstActiveMethod === 'mollie' ? 'checked' : '') + '>' +
                    '<label class="form-check-label" for="mollie">' +
                        '<i class="fas fa-credit-card me-2"></i>Mollie' +
                        '<small class="d-block text-muted mt-1">Pay with iDEAL, Bancontact, and more</small>' +
                    '</label>' +
                '</div>';
            }
            
            // Instamojo
            if (this.paymentGateways.instamojo && this.paymentGateways.instamojo.status == 1) {
                if (!firstActiveMethod) firstActiveMethod = 'instamojo';
                paymentMethodsHtml += '<div class="form-check mb-3">' +
                    '<input class="form-check-input" type="radio" name="payment_method" id="instamojo" value="instamojo" ' + (firstActiveMethod === 'instamojo' ? 'checked' : '') + '>' +
                    '<label class="form-check-label" for="instamojo">' +
                        '<i class="fas fa-credit-card me-2"></i>Instamojo' +
                        '<small class="d-block text-muted mt-1">Pay with cards, net banking & wallets</small>' +
                    '</label>' +
                '</div>';
            }
            
            // Paystack
            if (this.paymentGateways.paystack_and_mollie && this.paymentGateways.paystack_and_mollie.paystack_status == 1) {
                if (!firstActiveMethod) firstActiveMethod = 'paystack';
                paymentMethodsHtml += '<div class="form-check mb-3">' +
                    '<input class="form-check-input" type="radio" name="payment_method" id="paystack" value="paystack" ' + (firstActiveMethod === 'paystack' ? 'checked' : '') + '>' +
                    '<label class="form-check-label" for="paystack">' +
                        '<i class="fas fa-credit-card me-2"></i>Paystack' +
                        '<small class="d-block text-muted mt-1">Pay with cards, bank transfers & USSD</small>' +
                    '</label>' +
                '</div>';
            }
            
            // SSLCommerz
            if (this.paymentGateways.sslcommerz && this.paymentGateways.sslcommerz.status == 1) {
                if (!firstActiveMethod) firstActiveMethod = 'sslcommerz';
                paymentMethodsHtml += '<div class="form-check mb-3">' +
                    '<input class="form-check-input" type="radio" name="payment_method" id="sslcommerz" value="sslcommerz" ' + (firstActiveMethod === 'sslcommerz' ? 'checked' : '') + '>' +
                    '<label class="form-check-label" for="sslcommerz">' +
                        '<i class="fas fa-credit-card me-2"></i>SSLCommerz' +
                        '<small class="d-block text-muted mt-1">Pay with cards, mobile banking & internet banking</small>' +
                    '</label>' +
                '</div>';
            }
            
            // Bank Payment
            if (this.paymentGateways.bank_payment && this.paymentGateways.bank_payment.status == 1) {
                if (!firstActiveMethod) firstActiveMethod = 'bank_payment';
                paymentMethodsHtml += '<div class="form-check mb-3">' +
                    '<input class="form-check-input" type="radio" name="payment_method" id="bank_payment" value="bank_payment" ' + (firstActiveMethod === 'bank_payment' ? 'checked' : '') + '>' +
                    '<label class="form-check-label" for="bank_payment">' +
                        '<i class="fas fa-university me-2"></i>Bank Transfer' +
                        '<small class="d-block text-muted mt-1">Transfer directly to our bank account</small>' +
                    '</label>' +
                '</div>';
            }
            
            paymentMethodsHtml += '</div>';
        
        paymentContainer.innerHTML = paymentMethodsHtml;
        
        // Add event listener for "Pay Now" button
        const showOtherPaymentsBtn = document.getElementById('show-other-payments');
        if (showOtherPaymentsBtn) {
            showOtherPaymentsBtn.addEventListener('click', () => {
                const otherPaymentMethods = document.getElementById('other-payment-methods');
                if (otherPaymentMethods.style.display === 'none') {
                    otherPaymentMethods.style.display = 'block';
                    showOtherPaymentsBtn.innerHTML = '<i class="fas fa-eye-slash me-2"></i>Hide Other Payment Methods';
                } else {
                    otherPaymentMethods.style.display = 'none';
                    showOtherPaymentsBtn.innerHTML = '<i class="fas fa-credit-card me-2"></i>Pay Now (Other Payment Methods)';
                    // Reset to Cash on Delivery when hiding other methods
                    const codRadio = document.getElementById('cash_on_delivery');
                    if (codRadio) {
                        codRadio.checked = true;
                        this.togglePaymentForms();
                    }
                }
            });
        }
        
        // Select Cash on Delivery by default if available
        if (firstActiveMethod) {
            const firstRadio = document.getElementById(firstActiveMethod);
            if (firstRadio) {
                firstRadio.checked = true;
                this.togglePaymentForms();
            }
        }
        
        // Re-bind payment method change events
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', () => {
                this.togglePaymentForms();
            });
        });
    }

    updateShippingCost() {
        const selectedShippingElement = document.querySelector('input[name="shipping_method"]:checked');
        const selectedShippingId = selectedShippingElement ? selectedShippingElement.value : null;
        if (selectedShippingId) {
            const selectedShipping = this.shippingMethods.find(function(method) { return method.id == selectedShippingId; });
            const shippingCost = selectedShipping ? parseFloat(selectedShipping.shipping_fee) : 0;
            
            document.getElementById('shipping-cost').textContent = '$' + shippingCost.toFixed(2);
            this.updateOrderSummary();
        }
    }

    updateOrderSummary() {
        // Handle empty cart scenario
        if (!this.cart || this.cart.length === 0) {
            document.getElementById('subtotal').textContent = '$0.00';
            document.getElementById('shipping-cost').textContent = '$0.00';
            document.getElementById('tax').textContent = '$0.00';
            document.getElementById('total').textContent = '$0.00';
            
            const couponDiscountElement = document.getElementById('coupon-discount-amount');
            if (couponDiscountElement) {
                couponDiscountElement.textContent = '-$0.00';
            }
            return;
        }
        
        const subtotal = this.cart.reduce(function(sum, item) {
            const itemPrice = parseFloat(item.product_price || (item.product && item.product.price) || 0);
            const variantPrice = item.variants ? item.variants.reduce(function(vSum, variant) {
                return vSum + (parseFloat(variant.variant_price) || 0);
            }, 0) : 0;
            const quantity = parseInt(item.quantity || 0);
            const itemTotal = (itemPrice + variantPrice) * quantity;
            return sum + (isNaN(itemTotal) ? 0 : itemTotal);
        }, 0);
        
        const selectedShippingElement = document.querySelector('input[name="shipping_method"]:checked');
        const selectedShippingId = selectedShippingElement ? selectedShippingElement.value : null;
        const selectedShipping = this.shippingMethods.find(method => method.id == selectedShippingId);
        const shipping = selectedShipping ? parseFloat(selectedShipping.shipping_fee) || 0 : 0;
        
        const couponDiscount = this.appliedCoupon ? this.calculateCouponDiscount(subtotal) : 0;
        const tax = 0; // No tax calculation
        const total = subtotal + shipping - couponDiscount;

        // Ensure all values are valid numbers before displaying
        const safeSubtotal = isNaN(subtotal) ? 0 : subtotal;
        const safeShipping = isNaN(shipping) ? 0 : shipping;
        const safeTax = isNaN(tax) ? 0 : tax;
        const safeTotal = isNaN(total) ? 0 : total;
        const safeCouponDiscount = isNaN(couponDiscount) ? 0 : couponDiscount;

        document.getElementById('subtotal').textContent = '$' + safeSubtotal.toFixed(2);
        document.getElementById('shipping-cost').textContent = '$' + safeShipping.toFixed(2);
        document.getElementById('tax').textContent = '$' + safeTax.toFixed(2);
        document.getElementById('total').textContent = '$' + safeTotal.toFixed(2);
        
        // Update coupon discount display if exists
        const couponDiscountElement = document.getElementById('coupon-discount-amount');
        if (couponDiscountElement) {
            couponDiscountElement.textContent = '-$' + safeCouponDiscount.toFixed(2);
        }
    }
    
    calculateCouponDiscount(subtotal) {
        if (!this.appliedCoupon) return 0;
        
        if (this.appliedCoupon.discount_type === 'percentage') {
            return (subtotal * this.appliedCoupon.discount) / 100;
        } else {
            return this.appliedCoupon.discount;
        }
    }
    
    async applyCoupon() {
        const couponInput = document.getElementById('coupon-code');
        if (!couponInput) return;
        
        const couponCode = couponInput.value.trim();
        if (!couponCode) {
            this.showNotification('Please enter a coupon code', 'error');
            return;
        }
        
        const applyCouponBtn = document.getElementById('apply-coupon-btn');
        const originalText = applyCouponBtn.innerHTML;
        applyCouponBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Applying...';
        applyCouponBtn.disabled = true;
        
        try {
            const response = await fetch('{{ route("checkout.apply-coupon") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    coupon_code: couponCode
                })
            });
            
            const data = await response.json();
            
            if (data.success) {
                this.appliedCoupon = data.coupon;
                this.showNotification(data.message, 'success');
                this.updateOrderSummary();
                
                // Show applied coupon info
                const couponInfo = document.getElementById('coupon-info');
                const couponInfoText = document.getElementById('coupon-info-text');
                if (couponInfo && couponInfoText) {
                    const discountText = data.coupon.discount_type === 'percentage' 
                    ? data.coupon.discount + '% off'
                    : '$' + data.coupon.discount + ' off';
                couponInfoText.textContent = 'Coupon "' + data.coupon.code + '" applied - ' + discountText;
                    couponInfo.style.display = 'block';
                }
                
                couponInput.disabled = true;
                applyCouponBtn.style.display = 'none';
                
                // Show coupon discount in order summary
                const couponDiscountRow = document.getElementById('coupon-discount');
                if (couponDiscountRow) {
                    couponDiscountRow.style.display = 'flex';
                }
            } else {
                this.showNotification(data.message, 'error');
            }
        } catch (error) {
            console.error('Error applying coupon:', error);
            this.showNotification('Failed to apply coupon', 'error');
        } finally {
            applyCouponBtn.innerHTML = originalText;
            applyCouponBtn.disabled = false;
        }
    }
    
    removeCoupon() {
        this.appliedCoupon = null;
        this.updateOrderSummary();
        
        const couponInput = document.getElementById('coupon-code');
        const applyCouponBtn = document.getElementById('apply-coupon-btn');
        const couponInfo = document.getElementById('coupon-info');
        const couponDiscountRow = document.getElementById('coupon-discount');
        
        if (couponInput) {
            couponInput.value = '';
            couponInput.disabled = false;
        }
        
        if (applyCouponBtn) {
            applyCouponBtn.style.display = 'inline-block';
        }
        
        if (couponInfo) {
            couponInfo.style.display = 'none';
        }
        
        if (couponDiscountRow) {
            couponDiscountRow.style.display = 'none';
        }
        
        this.showNotification('Coupon removed', 'info');
    }
    
    loadBankAccountDetails(bankPaymentInfo) {
         const bankAccountDetails = document.getElementById('bank-account-details');
         if (bankAccountDetails && bankPaymentInfo && bankPaymentInfo.status == 1) {
             // Parse the account_info which contains formatted bank details
             const accountInfo = bankPaymentInfo.account_info || '';
             const formattedInfo = accountInfo.replace(/\n/g, '<br>');
             
             bankAccountDetails.innerHTML = '<div class="bank-details">' +
                formattedInfo +
            '</div>' +
            '<p class="text-muted mt-3 mb-0"><small>Please use the order number as reference when making the transfer.</small></p>';
         }
     }

    togglePaymentForms() {
        const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
        const bankPaymentInfo = document.getElementById('bank-payment-info');
        
        // Hide all forms first
        if (bankPaymentInfo) bankPaymentInfo.style.display = 'none';
        
        // Show relevant form based on selected method
        if (selectedMethod === 'bank_payment') {
            if (bankPaymentInfo) bankPaymentInfo.style.display = 'block';
        }
        // Note: Stripe payment will redirect to Stripe's hosted payment page
    }

    formatCardInputs() {
        // Note: Stripe card input formatting is no longer needed 
        // as payment processing is handled by Stripe's hosted page
    }

    validateForm() {
        const form = document.getElementById('checkout-form');
        const requiredFields = form.querySelectorAll('[required]');
        let isValid = true;

        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });

        // Validate payment method specific fields
        const selectedPayment = document.querySelector('input[name="payment_method"]:checked').value;
        if (selectedPayment === 'credit_card') {
            const cardFields = ['card_number', 'expiry', 'cvv', 'card_name'];
            cardFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (!field.value.trim()) {
                    field.classList.add('is-invalid');
                    isValid = false;
                } else {
                    field.classList.remove('is-invalid');
                }
            });
        }

        return isValid;
    }

    // placeOrder function removed - now using traditional form submission

    showNotification(message, type = 'success') {
        // Use the existing notification system from app.js
        if (window.showNotification) {
            window.showNotification(message, type);
        } else {
            alert(message);
        }
    }
}

// Initialize checkout
const checkout = new Checkout();
</script>

@push('scripts')
<script>
$(document).ready(function() {
    // Handle billing country change
    $('#country').change(function() {
        var countryId = $(this).val();
        var stateSelect = $('#state');
        var citySelect = $('#city');
        
        // Reset state and city
        stateSelect.html('<option value="">Select State</option>').prop('disabled', true);
        citySelect.html('<option value="">Select City</option>').prop('disabled', true);
        
        if (countryId) {
            $.ajax({
                url: '{{ url("public/states") }}/' + countryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            stateSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        stateSelect.prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Error loading states. Please try again.');
                }
            });
        }
    });
    
    // Handle billing state change
    $('#state').change(function() {
        var stateId = $(this).val();
        var citySelect = $('#city');
        
        // Reset city
        citySelect.html('<option value="">Select City</option>').prop('disabled', true);
        
        if (stateId) {
            $.ajax({
                url: '{{ url("public/cities") }}/' + stateId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        citySelect.prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Error loading cities. Please try again.');
                }
            });
        }
    });

    // Handle shipping country change
    $('#ship_country').change(function() {
        var countryId = $(this).val();
        var stateSelect = $('#ship_state');
        var citySelect = $('#ship_city');
        
        // Reset state and city
        stateSelect.html('<option value="">Select State</option>').prop('disabled', true);
        citySelect.html('<option value="">Select City</option>').prop('disabled', true);
        
        if (countryId) {
            $.ajax({
                url: '{{ url("public/states") }}/' + countryId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            stateSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        stateSelect.prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Error loading states. Please try again.');
                }
            });
        }
    });
    
    // Handle shipping state change
    $('#ship_state').change(function() {
        var stateId = $(this).val();
        var citySelect = $('#ship_city');
        
        // Reset city
        citySelect.html('<option value="">Select City</option>').prop('disabled', true);
        
        if (stateId) {
            $.ajax({
                url: '{{ url("public/cities") }}/' + stateId,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.length > 0) {
                        $.each(data, function(key, value) {
                            citySelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                        });
                        citySelect.prop('disabled', false);
                    }
                },
                error: function() {
                    alert('Error loading cities. Please try again.');
                }
            });
        }
    });
});
</script>
@endpush

@endsection