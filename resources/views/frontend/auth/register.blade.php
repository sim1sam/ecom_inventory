@extends('frontend.layouts.app')
@section('title', 'Register')
@section('meta')
<meta name="description" content="{{__('Register')}}">
@endsection

@section('content')
<!-- Register Section Start -->
<section class="register-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="register-card">
                    <div class="register-header text-center mb-4">
                        <h2 class="register-title">{{__('Create Account')}}</h2>
                        <p class="register-subtitle">{{__('Join us today and start shopping')}}</p>
                    </div>



                    <form id="registerForm" method="POST" action="{{route('register')}}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">{{__('Full Name')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" required>
                            @error('name')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{__('Email Address')}} <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required>
                            @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        @if($setting->phone_number_required == 1)
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">{{__('Phone Number')}} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}" required>
                            @error('phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @else
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label">{{__('Phone Number')}}</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{old('phone')}}">
                            @error('phone')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>
                        @endif

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">{{__('Password')}} <span class="text-danger">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password', 'passwordIcon')">
                                    <i class="fas fa-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password_confirmation" class="form-label">{{__('Confirm Password')}} <span class="text-danger">*</span></label>
                            <div class="password-input-wrapper">
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                                <button type="button" class="password-toggle" onclick="togglePassword('password_confirmation', 'confirmPasswordIcon')">
                                    <i class="fas fa-eye" id="confirmPasswordIcon"></i>
                                </button>
                            </div>
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
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="agree" name="agree" required>
                                <label class="form-check-label" for="agree">
                                    {{__('I agree to the')}} 
                                    <a href="{{route('terms.conditions')}}" target="_blank">{{__('Terms & Conditions')}}</a>
                                    {{__('and')}} 
                                    <a href="{{route('privacy.policy')}}" target="_blank">{{__('Privacy Policy')}}</a>
                                    <span class="text-danger">*</span>
                                </label>
                            </div>
                            @error('agree')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <button type="submit" class="btn btn-primary w-100 register-btn">
                                <span class="btn-text">{{__('Create Account')}}</span>
                                <span class="btn-loader d-none">
                                    <i class="fas fa-spinner fa-spin"></i> {{__('Creating Account...')}}
                                </span>
                            </button>
                        </div>

                        @if($setting->enable_google_login == 1 || $setting->enable_facebook_login == 1)
                        <div class="social-login-divider">
                            <span>{{__('Or sign up with')}}</span>
                        </div>

                        <div class="social-login-buttons">
                            @if($setting->enable_google_login == 1)
                            <a href="{{route('login-google')}}" class="btn btn-google">
                                <i class="fab fa-google"></i>
                                {{__('Google')}}
                            </a>
                            @endif

                            @if($setting->enable_facebook_login == 1)
                            <a href="{{route('login-facebook')}}" class="btn btn-facebook">
                                <i class="fab fa-facebook-f"></i>
                                {{__('Facebook')}}
                            </a>
                            @endif
                        </div>
                        @endif

                        <div class="text-center mt-4">
                            <p class="login-link">
                                {{__('Already have an account?')}} 
                                <a href="{{route('login')}}">{{__('Sign In')}}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Register Section End -->

<style>
:root {
    /* Purple-Gray Jewelry Theme with Gold Buttons */
    --primary-color: #8B7BA8;     /* Elegant purple */
    --accent-color: #A294C2;      /* Soft lavender */
    --light-purple: #C8BFD9;      /* Light purple */
    --dark-purple: #6B5B73;       /* Deep purple-gray */
    --diamond-white: #fafafa;     /* Pure white */
    --pearl-white: #f8f6f0;       /* Warm white */
    --elegant-gray: #2c2c2c;      /* Dark text */
    --soft-shadow: rgba(139, 123, 168, 0.2); /* Purple shadow */
    
    /* Gold Button Colors */
    --primary-gold: var(--primary-color);
    --light-gold: var(--accent-color);
    --dark-gold: var(--dark-purple);
    --gold-shadow: var(--soft-shadow);
}

.register-section {
    background: linear-gradient(135deg, var(--pearl-white) 0%, var(--light-purple) 50%, var(--primary-color) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.register-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-image: 
        radial-gradient(circle at 20% 80%, rgba(139, 123, 168, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 80% 20%, rgba(139, 123, 168, 0.1) 0%, transparent 50%),
        radial-gradient(circle at 40% 40%, rgba(255, 255, 255, 0.1) 0%, transparent 50%);
    pointer-events: none;
}

.register-card {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 25px;
    padding: 50px;
    box-shadow: 
        0 25px 50px rgba(0, 0, 0, 0.1),
        0 0 0 1px var(--soft-shadow),
        inset 0 1px 0 rgba(255, 255, 255, 0.6);
    backdrop-filter: blur(20px);
    border: 2px solid rgba(139, 123, 168, 0.2);
    position: relative;
    overflow: hidden;
}

.register-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-gold), var(--light-gold), var(--primary-gold));
}

.register-title {
    color: var(--elegant-gray);
    font-weight: 700;
    margin-bottom: 10px;
    font-size: 2.2rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
}

.register-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 50%;
    transform: translateX(-50%);
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, var(--primary-gold), var(--light-gold));
    border-radius: 2px;
}

.register-subtitle {
    color: #666;
    margin-bottom: 0;
    font-size: 1.1rem;
    margin-bottom: 30px;
}

.form-label {
    font-weight: 600;
    color: var(--elegant-gray);
    margin-bottom: 8px;
    font-size: 0.95rem;
}

.form-control {
    border: 2px solid rgba(139, 123, 168, 0.2);
    border-radius: 12px;
    padding: 15px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
    color: var(--elegant-gray);
}

.form-control:focus {
    border-color: var(--primary-color);
    box-shadow: 0 0 0 0.2rem var(--soft-shadow);
    background: white;
    outline: none;
}

.form-control::placeholder {
    color: #999;
    opacity: 0.8;
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

.register-btn {
    background: linear-gradient(135deg, var(--primary-gold) 0%, var(--dark-gold) 100%);
    border: none;
    border-radius: 12px;
    padding: 15px 40px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: white;
    position: relative;
    overflow: hidden;
}

.register-btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.register-btn:hover::before {
    left: 100%;
}

.register-btn:hover {
    background: linear-gradient(135deg, var(--dark-gold) 0%, var(--primary-gold) 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px var(--soft-shadow);
    color: white;
}

.form-check-label {
    font-size: 14px;
    line-height: 1.5;
}

.form-check-label a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.form-check-label a:hover {
    color: var(--dark-purple);
    text-decoration: underline;
}

.social-login-divider {
    text-align: center;
    margin: 20px 0;
    position: relative;
}

.social-login-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: #e1e5e9;
}

.social-login-divider span {
    background: white;
    padding: 0 20px;
    color: #666;
    font-size: 14px;
}

.social-login-buttons {
    display: flex;
    gap: 10px;
}

.btn-google, .btn-facebook {
    flex: 1;
    padding: 12px;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
}

.btn-google {
    background: #fff;
    border: 2px solid #db4437;
    color: #db4437;
}

.btn-google:hover {
    background: #db4437;
    color: white;
}

.btn-facebook {
    background: #fff;
    border: 2px solid #4267B2;
    color: #4267B2;
}

.btn-facebook:hover {
    background: #4267B2;
    color: white;
}

.login-link {
    color: #666;
    margin-bottom: 0;
}

.login-link a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    position: relative;
}

.login-link a::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -2px;
    left: 0;
    background: linear-gradient(90deg, var(--primary-color), var(--accent-color));
    transition: width 0.3s ease;
}

.login-link a:hover {
    color: var(--dark-purple);
    text-decoration: none;
}

.login-link a:hover::after {
    width: 100%;
}

@media (max-width: 768px) {
    .register-card {
        padding: 30px 20px;
        margin: 20px;
    }
    
    .social-login-buttons {
        flex-direction: column;
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
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('.register-btn');
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
        if (strengthIndicator) strengthIndicator.style.display = 'none';
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
    
    if (strengthIndicator) {
        strengthIndicator.style.display = 'block';
        strengthIndicator.textContent = 'Password Strength: ' + strengthTexts[strength - 1];
        strengthIndicator.style.color = strengthColors[strength - 1];
    }
});

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
</script>
@endsection