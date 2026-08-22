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
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Country</label>
                                <input type="text" class="form-control" value="Bangladesh" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label d-block">Delivery Area <span class="text-danger">*</span></label>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delivery_area" id="areaInside" value="inside" {{ old('delivery_area', 'inside') == 'inside' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="areaInside">Inside</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="delivery_area" id="areaOutside" value="outside" {{ old('delivery_area') == 'outside' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="areaOutside">Outside</label>
                                </div>
                                @error('delivery_area')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Full Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" placeholder="House, road, area, landmark" required>{{ old('address') }}</textarea>
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
