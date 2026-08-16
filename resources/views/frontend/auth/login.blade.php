@extends('frontend.layouts.app')
@section('title', 'Login')

@section('meta')
<meta name="description" content="{{__('Login')}}">
@endsection

@section('content')
<!-- Login Section Start -->
<section class="login-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="login-card">
                    <div class="login-header text-center mb-4">
                        <h2 class="login-title">{{__('Welcome Back')}}</h2>
                        <p class="login-subtitle">{{__('Sign in to your account')}}</p>
                    </div>



                    <form id="loginForm" method="POST" action="{{route('login')}}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{__('Email Address')}}</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" required>
                            @error('email')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <label for="password" class="form-label">{{__('Password')}}</label>
                            <div class="password-input-wrapper">
                                <input type="password" class="form-control" id="password" name="password" required>
                                <button type="button" class="password-toggle" onclick="togglePassword()">
                                    <i class="fas fa-eye" id="passwordIcon"></i>
                                </button>
                            </div>
                            @error('password')
                                <span class="text-danger">{{$message}}</span>
                            @enderror
                        </div>

                        <div class="form-group mb-3">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    {{__('Remember Me')}}
                                </label>
                            </div>
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
                            <button type="submit" class="btn btn-primary w-100 login-btn">
                                <span class="btn-text">{{__('Sign In')}}</span>
                                <span class="btn-loader d-none">
                                    <i class="fas fa-spinner fa-spin"></i> {{__('Signing In...')}}
                                </span>
                            </button>
                        </div>

                        <div class="text-center mb-3">
                            <a href="{{route('password.request')}}" class="forgot-password-link">
                                {{__('Forgot Your Password?')}}
                            </a>
                        </div>

                        @if($setting->enable_google_login == 1 || $setting->enable_facebook_login == 1)
                        <div class="social-login-divider">
                            <span>{{__('Or continue with')}}</span>
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
                            <p class="register-link">
                                {{__('Don\'t have an account?')}} 
                                <a href="{{route('register')}}">{{__('Sign Up')}}</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Login Section End -->

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

.login-section {
    background: linear-gradient(135deg, var(--pearl-white) 0%, var(--light-purple) 50%, var(--primary-color) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
    position: relative;
    overflow: hidden;
}

.login-section::before {
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

.login-card {
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

.login-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-gold), var(--light-gold), var(--primary-gold));
}

.login-title {
    color: var(--elegant-gray);
    font-weight: 700;
    margin-bottom: 10px;
    font-size: 2.2rem;
    text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    position: relative;
}

.login-title::after {
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

.login-subtitle {
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
    border: 2px solid rgba(212, 175, 55, 0.2);
    border-radius: 12px;
    padding: 15px 20px;
    font-size: 16px;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.8);
    color: var(--elegant-gray);
}

.form-control:focus {
    border-color: var(--primary-gold);
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

.btn-primary {
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

.btn-primary::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
    transition: left 0.5s;
}

.btn-primary:hover::before {
    left: 100%;
}

.btn-primary:hover {
    background: linear-gradient(135deg, var(--dark-gold) 0%, var(--primary-gold) 100%);
    transform: translateY(-2px);
    box-shadow: 0 10px 30px var(--soft-shadow);
    color: white;
}

.forgot-password-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.forgot-password-link::after {
    content: '';
    position: absolute;
    width: 0;
    height: 2px;
    bottom: -2px;
    left: 0;
    background: linear-gradient(90deg, var(--primary-gold), var(--light-gold));
    transition: width 0.3s ease;
}

.forgot-password-link:hover {
    color: var(--dark-gold);
    text-decoration: none;
}

.forgot-password-link:hover::after {
    width: 100%;
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
    padding: 15px;
    border-radius: 12px;
    font-weight: 600;
    text-decoration: none;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.btn-google::before, .btn-facebook::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, var(--light-gold), var(--primary-gold));
    opacity: 0;
    transition: opacity 0.3s ease;
}

.btn-google {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(219, 68, 55, 0.3);
    color: #db4437;
}

.btn-google:hover {
    background: #db4437;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(219, 68, 55, 0.3);
    text-decoration: none;
}

.btn-facebook {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid rgba(66, 103, 178, 0.3);
    color: #4267B2;
}

.btn-facebook:hover {
    background: #4267B2;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(66, 103, 178, 0.3);
    text-decoration: none;
}

.register-link {
    color: #666;
    margin-bottom: 0;
}

.register-link a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
}

.register-link a:hover {
    color: var(--dark-gold);
    text-decoration: none;
}

@media (max-width: 768px) {
    .login-card {
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
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const passwordIcon = document.getElementById('passwordIcon');
    
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
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const submitBtn = this.querySelector('.login-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    
    btnText.classList.add('d-none');
    btnLoader.classList.remove('d-none');
    submitBtn.disabled = true;
    
    // Clear previous error messages
    document.querySelectorAll('.text-danger').forEach(el => el.remove());
    
    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            window.location.href = data.redirect;
        } else if (data.error) {
            showError(data.error);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showError('An error occurred. Please try again.');
    })
    .finally(() => {
        btnText.classList.remove('d-none');
        btnLoader.classList.add('d-none');
        submitBtn.disabled = false;
    });
});

function showError(message) {
    const form = document.getElementById('loginForm');
    const errorDiv = document.createElement('div');
    errorDiv.className = 'alert alert-danger alert-dismissible fade show';
    errorDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    form.insertBefore(errorDiv, form.firstChild);
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
</script>
@endsection