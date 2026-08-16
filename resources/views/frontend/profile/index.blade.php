@extends('frontend.layouts.app')

@section('title', 'Profile')

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
                        <a class="nav-link active" href="{{ route('profile') }}">
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
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Profile Information</h5>
                </div>
                <div class="card-body">


                    <form action="{{ route('profile.update') }}" method="POST" id="profileForm">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control @error('phone') is-invalid @enderror" 
                                       id="phone" name="phone" value="{{ old('phone', auth()->user()->phone) }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date of Birth</label>
                                <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                       id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', auth()->user()->date_of_birth) }}">
                                @error('date_of_birth')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="gender" class="form-label">Gender</label>
                                <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', auth()->user()->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', auth()->user()->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', auth()->user()->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label for="address" class="form-label">Address</label>
                                <textarea class="form-control @error('address') is-invalid @enderror" 
                                          id="address" name="address" rows="3" placeholder="Enter your full address">{{ old('address', auth()->user()->address) }}</textarea>
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="city" class="form-label">City</label>
                                <input type="text" class="form-control @error('city') is-invalid @enderror" 
                                       id="city" name="city" value="{{ old('city', auth()->user()->city) }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="state" class="form-label">State</label>
                                <input type="text" class="form-control @error('state') is-invalid @enderror" 
                                       id="state" name="state" value="{{ old('state', auth()->user()->state) }}">
                                @error('state')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="zip_code" class="form-label">ZIP Code</label>
                                <input type="text" class="form-control @error('zip_code') is-invalid @enderror" 
                                       id="zip_code" name="zip_code" value="{{ old('zip_code', auth()->user()->zip_code) }}">
                                @error('zip_code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="country" class="form-label">Country</label>
                                <select class="form-select @error('country') is-invalid @enderror" id="country" name="country">
                                    <option value="">Select Country</option>
                                    <option value="US" {{ old('country', auth()->user()->country) == 'US' ? 'selected' : '' }}>United States</option>
                                    <option value="CA" {{ old('country', auth()->user()->country) == 'CA' ? 'selected' : '' }}>Canada</option>
                                    <option value="GB" {{ old('country', auth()->user()->country) == 'GB' ? 'selected' : '' }}>United Kingdom</option>
                                    <option value="AU" {{ old('country', auth()->user()->country) == 'AU' ? 'selected' : '' }}>Australia</option>
                                    <option value="IN" {{ old('country', auth()->user()->country) == 'IN' ? 'selected' : '' }}>India</option>
                                    <!-- Add more countries as needed -->
                                </select>
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3">Change Password</h6>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('current_password') is-invalid @enderror" 
                                           id="current_password" name="current_password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('current_password')">
                                        <i class="fas fa-eye" id="current_password_icon"></i>
                                    </button>
                                </div>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                           id="password" name="password">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                        <i class="fas fa-eye" id="password_icon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" 
                                           id="password_confirmation" name="password_confirmation">
                                    <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                        <i class="fas fa-eye" id="password_confirmation_icon"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                            </a>
                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                <span class="spinner-border spinner-border-sm me-2 d-none" id="loadingSpinner"></span>
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
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
</style>
@endpush

@push('scripts')
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '_icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}

document.getElementById('profileForm').addEventListener('submit', function() {
    const submitBtn = document.getElementById('submitBtn');
    const loadingSpinner = document.getElementById('loadingSpinner');
    
    submitBtn.disabled = true;
    loadingSpinner.classList.remove('d-none');
    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Updating...';
});
</script>
@endpush