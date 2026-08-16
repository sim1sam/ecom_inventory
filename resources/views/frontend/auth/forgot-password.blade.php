@extends('frontend.layouts.app')
@section('title', 'Forget Password?')

@section('meta')
<meta name="description" content="{{__('Forgot Password')}}">
@endsection

@section('content')
<!-- Forgot Password Section Start -->
<section class="forgot-password-section py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="forgot-password-card">
                    <div class="forgot-password-header text-center mb-4">
                        <div class="forgot-password-icon mb-3">
                            <i class="fas fa-lock"></i>
                        </div>
                        <h2 class="forgot-password-title">{{__('Forgot Password?')}}</h2>
                        <p class="forgot-password-subtitle">{{__('No worries, we\'ll send you reset instructions')}}</p>
                    </div>



                    <form id="forgotPasswordForm" method="POST" action="{{route('password.email')}}">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">{{__('Email Address')}}</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" placeholder="{{__('Enter your email address')}}" required>
                            @error('email')
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
                            <button type="submit" class="btn btn-primary w-100 forgot-password-btn">
                                <span class="btn-text">{{__('Send Reset Link')}}</span>
                                <span class="btn-loader d-none">
                                    <i class="fas fa-spinner fa-spin"></i> {{__('Sending...')}}
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

                    <div class="resend-section mt-4 text-center d-none" id="resendSection">
                        <p class="resend-text">{{__('Didn\'t receive the email?')}}</p>
                        <button type="button" class="btn btn-outline-primary btn-sm" id="resendBtn">
                            {{__('Resend Email')}}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Forgot Password Section End -->

<style>
.forgot-password-section {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-purple) 100%);
    min-height: 100vh;
    display: flex;
    align-items: center;
}

.forgot-password-card {
    background: white;
    border-radius: 20px;
    padding: 40px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    backdrop-filter: blur(10px);
}

.forgot-password-icon {
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

.forgot-password-title {
    color: #333;
    font-weight: 700;
    margin-bottom: 10px;
}

.forgot-password-subtitle {
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

.forgot-password-btn {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--dark-purple) 100%);
    border: none;
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    font-size: 16px;
    transition: all 0.3s ease;
    color: #fff; /* Ensure text is visible */
    display: inline-flex; /* Proper alignment of text/loader */
    align-items: center;
    justify-content: center;
    min-height: 48px; /* Keep a consistent button height */
}

.forgot-password-btn:disabled {
    opacity: 1; /* Avoid Bootstrap dimming the disabled button */
    cursor: not-allowed;
}

.forgot-password-btn .btn-loader {
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.forgot-password-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
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

.resend-section {
    border-top: 1px solid #e1e5e9;
    padding-top: 20px;
}

.resend-text {
    color: #666;
    margin-bottom: 10px;
    font-size: 14px;
}

.btn-outline-primary {
    border: 2px solid var(--primary-color);
    color: var(--primary-color);
    border-radius: 8px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: var(--primary-color);
    border-color: var(--primary-color);
    color: white;
    transform: translateY(-1px);
}

.success-message {
    background: #d4edda;
    border: 1px solid #c3e6cb;
    color: #155724;
    padding: 15px;
    border-radius: 10px;
    margin-bottom: 20px;
    text-align: center;
}

.success-message i {
    color: #28a745;
    font-size: 24px;
    margin-bottom: 10px;
    display: block;
}

@media (max-width: 768px) {
    .forgot-password-card {
        padding: 30px 20px;
        margin: 20px;
    }
    
    .forgot-password-icon {
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
// Handle form submission
document.getElementById('forgotPasswordForm').addEventListener('submit', function(e) {
    const submitBtn = this.querySelector('.forgot-password-btn');
    const btnText = submitBtn.querySelector('.btn-text');
    const btnLoader = submitBtn.querySelector('.btn-loader');
    
    btnText.classList.add('d-none');
    btnLoader.classList.remove('d-none');
    submitBtn.disabled = true;
    
    // Show resend section after form submission
    setTimeout(() => {
        document.getElementById('resendSection').classList.remove('d-none');
    }, 2000);
});

// Handle resend button
document.getElementById('resendBtn').addEventListener('click', function() {
    const email = document.getElementById('email').value;
    
    if (!email) {
        alert('{{__('Please enter your email address first')}}');
        return;
    }
    
    this.disabled = true;
    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> {{__('Sending...')}}';
    
    // Create form data
    const formData = new FormData();
    formData.append('email', email);
    formData.append('_token', '{{csrf_token()}}');
    
    // Send AJAX request
    fetch('{{route('password.email.ajax')}}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            this.innerHTML = '<i class="fas fa-check"></i> {{__('Email Sent!')}}';
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-success');
        } else {
            this.innerHTML = '{{__('Resend Email')}}';
            this.disabled = false;
            alert(data.error || '{{__('Something went wrong. Please try again.')}}');
        }
    })
    .catch(error => {
        this.innerHTML = '{{__('Resend Email')}}';
        this.disabled = false;
        alert('{{__('Something went wrong. Please try again.')}}');
    });
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

// Auto-focus email input
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('email').focus();
});
</script>
@endsection