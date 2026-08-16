@extends('frontend.layouts.app')

@section('title', 'Terms and Conditions - Our Terms of Service')
@section('meta_description', 'Read our terms and conditions to understand the rules and regulations for using our services.')
@section('meta_keywords', 'terms and conditions, terms of service, legal, policy')

@push('styles')
<style>
.terms-hero {
    background: linear-gradient(135deg, var(--bg-elegant, #f8f9fa) 0%, var(--bg-light, #ffffff) 50%, rgba(139, 123, 168, 0.1) 100%);
    padding: 80px 0;
    text-align: center;
}

/* Breadcrumb Styling */
.breadcrumb {
    background: transparent;
    padding: 0;
    margin: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "/";
    color: #6c757d;
}

.breadcrumb-item a {
    color: var(--primary-color, #d4af37);
    text-decoration: none;
}

.breadcrumb-item a:hover {
    color: var(--accent-color, #e8c547);
}

.breadcrumb-item.active {
    color: #6c757d;
}

nav[aria-label="breadcrumb"] {
    background: transparent;
    padding: 20px 0;
}

.terms-section {
    padding: 60px 0;
}

.terms-content {
    background: rgba(255, 255, 255, 0.9);
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    border: 1px solid rgba(139, 123, 168, 0.1);
    backdrop-filter: blur(10px);
    margin-bottom: 30px;
}

.terms-content h1, .terms-content h2, .terms-content h3 {
    color: var(--primary-color, #d4af37);
    margin-bottom: 20px;
}

.terms-content p {
    line-height: 1.8;
    margin-bottom: 15px;
    color: #555;
}

.terms-content ul, .terms-content ol {
    margin-bottom: 20px;
    padding-left: 30px;
}

.terms-content li {
    margin-bottom: 8px;
    line-height: 1.6;
}

.last-updated {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 30px;
    font-style: italic;
    color: #6c757d;
}
</style>
@endpush

@section('content')
<!-- Terms Hero Section -->
<section class="terms-hero">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 mb-3">{{__('Terms and Conditions')}}</h1>
                <p class="lead">{{__('Please read our terms and conditions carefully')}}</p>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('Home')}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{__('Terms and Conditions')}}</li>
        </ol>
    </nav>
</div>

<!-- Terms Content Section -->
<section class="terms-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if($termsCondition && $termsCondition->terms_and_condition)
                    <div class="last-updated">
                        <i class="fas fa-calendar-alt me-2"></i>
                        {{__('Last updated')}}: {{ $termsCondition->updated_at ? $termsCondition->updated_at->format('F d, Y') : __('Not specified') }}
                    </div>
                    
                    <div class="terms-content">
                        {!! clean($termsCondition->terms_and_condition) !!}
                    </div>
                @else
                    <div class="terms-content text-center">
                        <div class="mb-4">
                            <i class="fas fa-file-contract fa-4x text-muted mb-3"></i>
                            <h3>{{__('Terms and Conditions Not Available')}}</h3>
                            <p class="text-muted">{{__('Our terms and conditions are currently being updated. Please check back later or contact us for more information.')}}</p>
                        </div>
                        <a href="{{ route('contact') }}" class="btn btn-primary">
                            <i class="fas fa-envelope me-2"></i>{{__('Contact Us')}}
                        </a>
                    </div>
                @endif
                
                <!-- Back to Home Button -->
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>{{__('Back to Home')}}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Smooth scroll for any internal links
    $('a[href^="#"]').on('click', function(event) {
        var target = $(this.getAttribute('href'));
        if( target.length ) {
            event.preventDefault();
            $('html, body').stop().animate({
                scrollTop: target.offset().top - 100
            }, 1000);
        }
    });
});
</script>
@endpush