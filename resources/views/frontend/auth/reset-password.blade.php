@extends('frontend.layouts.app')
@section('title', 'Reset Password')
@section('meta')
<meta name="description" content="{{__('Reset Password')}}">
@endsection

@section('content')
<!-- Reset Password Section Start -->
<section class="reset-password-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="reset-password-card">
                    <div class="reset-password-header text-center mb-4">
                        <div class="reset-password-icon mb-3">
                            <i class="fas fa-key"></i>
                        </div>
                        <h2 class="reset-password-title">{{__('Reset Password')}}</h2>
                        <p class="reset-password-subtitle">{{__('Enter your new password below')}}</p>
                    </div>



                    <form id="resetPasswordForm" method="POST" action="{{route('password.update', request()->route('token'))}}">
                        @csrf
                        <input type="hidden" name="token" value="{{$token}}">
                        <input type="hidden" name="email" value="{{$email}}">

                        <div class="form-group mb-3">
                            <label for="email_display" class="form-label">{{__('Email Address')}}</label>
                            <input type="email" class="form-control" id="email_display" value="{{$email}}" disabled>
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">{{__('New Password')}}</label>
                            <div class="password-input-wrapper">
                                <input type="password" class="form-control" id="password" name="password" placeholder="{{__('Enter new password')}}" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password', 'passwordIcon')">
                                    <i class="fas fa-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                            <div class="password-strength" id="passwordStrength"></div>
                            @error('password')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">{{__('Confirm New Password')}}</label>
                            <div class="password-input-wrapper">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="{{__('Confirm new password')}}" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'confirmPasswordIcon')">
                                    <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                </button>
                            </div>
                            <div class="password-match" id="passwordMatch"></div>
                            @error('password_confirmation')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        @if($googleRecaptcha->status == 1)
                        <div class="form-group mb-3">
                            <div class="g-recaptcha" data-sitekey="{{$googleRecaptcha->site_key}}"></div>
                            @error('g-recaptcha-response')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @endif

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary w-100 reset-password-btn">
                                <span class="btn-text">{{__('Reset Password')}}</span>
                                <span class="btn-loader d-none">
                                    <i class="fas fa-spinner fa-spin"></i> {{__('Resetting...')}}
                                </span>
                            </button>
                        </div>

                        <div class="text-center">
                            <a href="{{route('login')}}" class="back-to-login-link">
                                <i class="fas fa-arrow-left"></i>
                                {{__('Back to Login')}}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Reset Password Section End -->

<style>
.reset-password-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-purple) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.reset-password-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
}

.reset-password-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-purple) 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    color: white;
    font-size: 32px;
}

.reset-password-title {
    color: #333;
    font-weight: 700;
    margin-bottom: 10px;
}

.reset-password-subtitle {
    color: #666;
    margin-bottom: 0;
    font-size: 16px;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
}

.form-control {
    border: 2px solid #e1e5e9;
    border-radius: 10px;
    padding: 12px 16px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
}

.form-control:disabled {
    background-color: #f8f9fa;
    opacity: 1;
}

.password-input-wrapper {
    position: relative;
}

.password-toggle {
    position: absolute;
    right: 12px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #666;
    cursor: pointer;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.password-toggle:hover {
    color: #333;
}

.password-strength {
    font-size: 12px;
    margin-top: 5px;
    font-weight: 500;
}

.password-match {
    font-size: 12px;
    margin-top: 5px;
    font-weight: 500;
}

.reset-password-btn {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-purple) 100%);
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
}

.reset-password-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

.reset-password-btn:disabled {
    opacity: 0.6;
    transform: none;
    box-shadow: none;
}

.back-to-login-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    display: inline-flex;
    align-items: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.back-to-login-link:hover {
    color: var(--dark-purple);
    text-decoration: none;
    transform: translateX(-3px);
}

.password-requirements {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 15px;
    margin-top: 10px;
    font-size: 14px;
}

.password-requirements h6 {
    color: #333;
    margin-bottom: 10px;
    font-weight: 600;
}

.password-requirements ul {
    margin: 0;
    padding-left: 20px;
}

.password-requirements li {
    color: #666;
    margin-bottom: 5px;
}

.password-requirements li.valid {
    color: #28a745;
}

.password-requirements li.invalid {
    color: #dc3545;
}

@media (max-width: 768px) {
    .reset-password-card {
        padding: 30px 20px;
        margin: 20px;
    }
    
    .reset-password-icon {
        width: 60px;
        height: 60px;
        font-size: 24px;
    }
}
</style>

@if($googleRecaptcha->status == 1)
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@endif

<script>
function togglePassword(inputId, iconId) {
    const passwordInput = document.getElementById(inputId);
    const passwordIcon = document.getElementById(iconId);
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        passwordIcon.classList.remove('fa-eye');
        passwordIcon.classList.add('fa-eye-slash');
    } else {
        passwordInput.type = 'password';
        passwordIcon.classList.remove('fa-eye-slash');
        passwordIcon.classList.add('fa-eye');
    }
}

// Handle form submission
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('.reset-password-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    
    btnText.classList.add('d-none');
    btnLoader.classList.remove('d-none');
    submitBtn.disabled = true;
});

// Password strength indicator
document.getElementById('password').addEventListener('input', function() {
    const password = this.value;
    const strengthIndicator = document.getElementById('passwordStrength');
    
    if (password.length === 0) {
        strengthIndicator.style.display = 'none';
        return;
    }
    
    let strength = 0;
    if (password.length >= 8) strength++;
    if (/[a-z]/.test(password)) strength++;
    if (/[A-Z]/.test(password)) strength++;
    if (/[0-9]/.test(password)) strength++;
    if (/[^A-Za-z0-9]/.test(password)) strength++;
    
    const strengthTexts = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
    const strengthColors = ['#ff4757', '#ff6b7a', '#ffa502', '#2ed573', '#5f27cd'];
    
    strengthIndicator.style.display = 'block';
    strengthIndicator.textContent = 'Password Strength: ' + strengthTexts[strength - 1];
    strengthIndicator.style.color = strengthColors[strength - 1];
    
    // Check password match
    checkPasswordMatch();
});

// Password match indicator
document.getElementById('password_confirmation').addEventListener('input', checkPasswordMatch);

function checkPasswordMatch() {
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('password_confirmation').value;
    const matchIndicator = document.getElementById('passwordMatch');
    
    if (confirmPassword.length === 0) {
        matchIndicator.style.display = 'none';
        return;
    }
    
    matchIndicator.style.display = 'block';
    
    if (password === confirmPassword) {
        matchIndicator.textContent = '✓ Passwords match';
        matchIndicator.style.color = '#28a745';
    } else {
        matchIndicator.textContent = '✗ Passwords do not match';
        matchIndicator.style.color = '#dc3545';
    }
}

// Show success/error messages
@if(session('messege'))
    setTimeout(function() {
        const alert = document.querySelector('.alert');
        if (alert) {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }
    }, 5000);
@endif

// Auto-focus password input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('password').focus();
});
</script>
@endsection