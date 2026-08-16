@extends('frontend.layouts.app')

@section('title', 'Add New Address')

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            @include('frontend.layouts.sidebar')
        </div>
        <div class="col-md-9">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Add New Address</h4>
                    <a href="{{ route('addresses.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Addresses
                    </a>
                </div>
                <div class="card-body">
                    <form action="{{ route('addresses.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number <span class="text-danger">*</span></label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone') }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">Address Type <span class="text-danger">*</span></label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Select Address Type</option>
                                    <option value="home" {{ old('type') == 'home' ? 'selected' : '' }}>Home</option>
                                    <option value="office" {{ old('type') == 'office' ? 'selected' : '' }}>Office</option>
                                    <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="country" class="form-label">Country <span class="text-danger">*</span></label>
                                <select class="form-select @error('country') is-invalid @enderror" id="country" name="country" required>
                                    <option value="">Select Country</option>
                                    @foreach($countries as $country)
                                        <option value="{{ $country->id }}" {{ old('country') == $country->id ? 'selected' : '' }}>
                                            {{ $country->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State <span class="text-danger">*</span></label>
                                <select class="form-select @error('state') is-invalid @enderror" id="state" name="state" required disabled>
                                    <option value="">Select State</option>
                                </select>
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City <span class="text-danger">*</span></label>
                                <select class="form-select @error('city') is-invalid @enderror" id="city" name="city" required disabled>
                                    <option value="">Select City</option>
                                </select>
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="zip_code" class="form-label">Zip Code</label>
                                <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                                       id="zip_code" name="zip_code" value="{{ old('zip_code') }}" placeholder="Enter zip code">
                                @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Full Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address') }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('addresses.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Address
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Handle country change
    $('#country').change(function() {
        var countryId = $(this).val();
        var stateSelect = $('#state');
        var citySelect = $('#city');
        
        // Reset state and city
        stateSelect.html('<option value="">Select State</option>').prop('disabled', true);
        citySelect.html('<option value="">Select City</option>').prop('disabled', true);
        
        if (countryId) {
            $.ajax({
                url: '{{ url("addresses") }}/' + countryId + '/states',
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
    
    // Handle state change
    $('#state').change(function() {
        var stateId = $(this).val();
        var citySelect = $('#city');
        
        // Reset city
        citySelect.html('<option value="">Select City</option>').prop('disabled', true);
        
        if (stateId) {
            $.ajax({
                url: '{{ url("addresses") }}/' + stateId + '/cities',
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