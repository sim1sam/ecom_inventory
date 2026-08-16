@extends('frontend.layouts.app')

@section('title', 'About Us - Learn More About Our Company')
@section('meta_description', 'Learn more about our company, our mission, values, and the team behind our success.')
@section('meta_keywords', 'about us, company, mission, values, team')

@push('styles')
<style>
.about-hero {
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

.about-section {
    padding: 60px 0;
}

.feature-item {
    text-align: center;
    padding: 2rem;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    margin-bottom: 2rem;
    background: rgba(255, 255, 255, 0.9);
    border: 1px solid rgba(139, 123, 168, 0.1);
    backdrop-filter: blur(10px);
    transition: transform 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
}

.feature-icon {
    font-size: 3rem;
    color: var(--primary-color);
    margin-bottom: 1rem;
}

.feature-title {
    font-size: 1.5rem;
    font-weight: 600;
    margin-bottom: 1rem;
    color: var(--secondary-color);
}

.feature-description {
    color: #666;
    line-height: 1.6;
}

.about-image {
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    width: 100%;
    height: auto;
    max-width: 403px; /* default max width on larger screens */
}

/* Center images within their columns */
.about-section .col-lg-6, .about-section .col-md-6 {
    display: flex;
    justify-content: center;
}

/* On smaller screens, allow images to be full width */
@media (max-width: 576px) {
    .about-image {
        max-width: 333px; /* smaller on mobile */
    }
}
.video-section {
    background: var(--secondary-color);
    color: white;
    padding: 80px 0;
    position: relative;
    overflow: hidden;
}

.video-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    opacity: 0.3;
    z-index: 1;
}

.video-content {
    position: relative;
    z-index: 2;
    text-align: center;
}

.play-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 80px;
    height: 80px;
    background: var(--primary-color);
    border-radius: 50%;
    color: white;
    font-size: 2rem;
    text-decoration: none;
    transition: transform 0.3s ease;
    margin-top: 2rem;
}

.play-button:hover {
    transform: scale(1.1);
    color: white;
    text-decoration: none;
}

.about-content {
    background: #f8f9fa;
    padding: 60px 0;
}

.content-text {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #555;
}
</style>
@endpush

@section('content')
<!-- Breadcrumb -->
<nav aria-label="breadcrumb" class="mb-4">
    <div class="container">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">About</li>
        </ol>
    </div>
</nav>

<!-- Hero Section -->
<section class="about-hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <h1 class="display-4 font-weight-bold mb-4">About Us</h1>
                {{-- <p class="lead">Learn more about our company, our mission, and the values that drive us forward.</p> --}}
            </div>
        </div>
    </div>
</section>

@if($aboutUs)
<!-- Features Section -->
{{-- @if($aboutUs->icon_one || $aboutUs->icon_two || $aboutUs->icon_three)
<section class="about-section bg-light">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center mb-5">
                <h2 class="font-weight-bold">Why Choose Us</h2>
                <p class="lead">Discover what makes us different and why customers trust us.</p>
            </div>
        </div>
        <div class="row">
            @if($aboutUs->icon_one && $aboutUs->title_one)
            <div class="col-lg-4 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="{{ $aboutUs->icon_one }}"></i>
                    </div>
                    <h3 class="feature-title">{{ $aboutUs->title_one }}</h3>
                    <p class="feature-description">{{ $aboutUs->description_one }}</p>
                </div>
            </div>
            @endif
            
            @if($aboutUs->icon_two && $aboutUs->title_two)
            <div class="col-lg-4 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="{{ $aboutUs->icon_two }}"></i>
                    </div>
                    <h3 class="feature-title">{{ $aboutUs->title_two }}</h3>
                    <p class="feature-description">{{ $aboutUs->description_two }}</p>
                </div>
            </div>
            @endif
            
            @if($aboutUs->icon_three && $aboutUs->title_three)
            <div class="col-lg-4 col-md-6">
                <div class="feature-item">
                    <div class="feature-icon">
                        <i class="{{ $aboutUs->icon_three }}"></i>
                    </div>
                    <h3 class="feature-title">{{ $aboutUs->title_three }}</h3>
                    <p class="feature-description">{{ $aboutUs->description_three }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif --}}

<!-- Video Section -->
{{-- @if($aboutUs->video_id)
<section class="video-section">
    @if($aboutUs->video_background)
    <img src="{{ asset($aboutUs->video_background) }}" alt="Video Background" class="video-background">
    @endif
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto">
                <div class="video-content">
                    <h2 class="font-weight-bold mb-4">Watch Our Story</h2>
                    <p class="lead mb-4">Get to know us better through our company video.</p>
                    <a href="https://www.youtube.com/watch?v={{ $aboutUs->video_id }}" class="play-button" target="_blank">
                        <i class="fas fa-play"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif --}}

<!-- About Content Section -->
@if($aboutUs->about_us)
<section class="about-content">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 mx-auto">
                <div class="content-text">
                    {!! $aboutUs->about_us !!}
                </div>
            </div>
        </div>
    </div>
</section>
@endif

@else
<!-- No Content Available -->
<section class="about-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2>About Us</h2>
                <p class="lead">Content is being updated. Please check back soon.</p>
            </div>
        </div>
    </div>
</section>
@endif

@endsection

@push('scripts')
<script>
// Add any custom JavaScript for the about page here
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for any internal links
    const links = document.querySelectorAll('a[href^="#"]');
    links.forEach(function(link) {
        link.addEventListener('click', function(event) {
            const targetId = this.getAttribute('href');
            const target = document.querySelector(targetId);
            if (target) {
                event.preventDefault();
                const offsetTop = target.offsetTop - 100;
                window.scrollTo({
                    top: offsetTop,
                    behavior: 'smooth'
                });
            }
        });
    });
});
</script>
@endpush