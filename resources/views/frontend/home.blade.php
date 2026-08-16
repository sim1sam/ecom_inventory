@extends('frontend.layouts.app')

@if(isset($seoSetting))
@section('title', $seoSetting->seo_title)
@section('meta_description', $seoSetting->seo_description)
@endif

@push('styles')
<style>
/* Modern Jewelry Website Styles */

/* Slider Section Fixes */
.slider-section {
    width: 100%;
    overflow-x: hidden;
    position: relative;
    z-index: 1;
}

.carousel {
    width: 100%;
    overflow: hidden;
    position: relative;
    z-index: 1;
}

.carousel-inner {
    width: 100%;
    overflow: hidden;
}

.carousel-item {
    width: 100%;
    overflow: hidden;
}

.hero-section {
    background: linear-gradient(135deg, var(--bg-elegant, #f8f9fa) 0%, var(--bg-light, #ffffff) 50%, rgba(139, 123, 168, 0.1) 100%);
    min-height: 60vh;
    display: flex;
    align-items: center;
    padding: 80px 0;
    width: 100%;
    overflow: hidden;
}

.hero-content {
    padding: 0;
}

.hero-content h1 {
    font-family: 'Cormorant Garamond', serif;
    font-size: 4rem;
    font-weight: 400;
    color: #2c3e50;
    line-height: 1.2;
    margin-bottom: 2rem;
}

.hero-content p {
    font-size: 1.2rem;
    color: #6c757d;
    margin-bottom: 3rem;
    line-height: 1.6;
}

.hero-buttons .btn {
    padding: 15px 40px;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
    border-radius: 0;
    margin-right: 20px;
}

.hero-image img {
    width: 100%;
    height: auto;
    object-fit: cover;
}

/* Category Cards */
.category-card {
    position: relative;
    overflow: hidden;
    border-radius: 0;
    height: 400px;
    background: #f8f9fa;
}

.category-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-overlay {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0,0,0,0.7);
    color: white;
    padding: 30px;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.category-card:hover .category-image {
    transform: scale(1.05);
}

.category-card:hover .category-overlay {
    transform: translateY(0);
}

.category-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.5rem;
    margin-bottom: 10px;
}

/* Featured Category Cards */
.featured-category-card {
    position: relative;
    overflow: hidden;
    border-radius: 10px;
    transition: transform 0.3s ease;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
}

.featured-category-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.2);
}

.featured-category-card:hover .featured-category-image img {
    transform: scale(1.1);
}

.featured-category-card:hover .featured-category-overlay {
    opacity: 1 !important;
}

.featured-category-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.8rem;
    font-weight: 600;
    margin-bottom: 15px;
}

.featured-categories {
    background: linear-gradient(135deg, var(--bg-elegant, #f8f9fa) 0%, rgba(139, 123, 168, 0.05) 100%);
}

/* Product Cards */
.product-card {
    border: none;
    border-radius: 0;
    overflow: hidden;
    transition: transform 0.3s ease;
    background: white;
    box-shadow: 0 2px 20px rgba(0,0,0,0.1);
}

.product-card:hover {
    transform: translateY(-5px);
}

.product-image {
    position: relative;
    overflow: hidden;
    height: 300px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.7);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.product-card:hover .product-overlay {
    opacity: 1;
}

.product-info {
    padding: 25px;
    text-align: center;
}

.product-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.3rem;
    margin-bottom: 15px;
    color: #2c3e50;
}

.product-price {
    font-size: 1.2rem;
    font-weight: 600;
    color: #d4af37;
}

.original-price {
    text-decoration: line-through;
    color: #6c757d;
    font-size: 1rem;
    margin-left: 10px;
}

/* Section Styling */
.section-padding {
    padding: 100px 0;
}

.section-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 3rem;
    font-weight: 400;
    text-align: center;
    margin-bottom: 20px;
    color: #2c3e50;
}

.section-subtitle {
    text-align: center;
    font-size: 1.1rem;
    color: #6c757d;
    margin-bottom: 60px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
}

/* Services Section */
.service-card {
    padding: 40px 20px;
    text-align: center;
    background: white;
    border-radius: 0;
    height: 100%;
}

/* Services Section Positioning */
.py-5.bg-white {
    position: relative;
    z-index: 10;
    background: white !important;
}

.service-icon {
    margin-bottom: 25px;
    position: relative;
    z-index: 11;
}

/* Service Icon Styling */
.service-icon i {
    display: inline-block;
    transition: all 0.3s ease;
    color: var(--primary-color);
}

.service-icon:hover i {
    transform: scale(1.1);
    color: var(--primary-color) !important;
}

.service-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem;
    margin-bottom: 15px;
    color: #2c3e50;
}

.service-description {
    color: #6c757d;
    line-height: 1.6;
}

/* Stats Section */
.stats-section {
    background: var(--statistics-color, #2c3e50);
    color: white;
    padding: 80px 0;
}

.stat-item {
    text-align: center;
    padding: 2rem 1rem;
}

.stat-number {
    font-size: 3.5rem;
    font-weight: 700;
    color: var(--statistics-font-color, #ffffff);
    display: block;
    font-family: 'Cormorant Garamond', serif;
}

.stat-label {
    font-size: 1.1rem;
    margin-top: 10px;
    opacity: 0.9;
    color: var(--statistics-font-color, #ffffff);
}

/* Testimonials */
.testimonials-section {
    background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
    padding: 80px 0;
}

.testimonial-card-modern {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
}

.testimonial-card-modern::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-color);
}

.testimonial-card-modern:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 50px rgba(0,0,0,0.12);
}

.testimonial-header {
    display: flex;
    align-items: center;
    margin-bottom: 20px;
}

.testimonial-avatar-modern {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 15px;
    flex-shrink: 0;
}

.testimonial-avatar-modern img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-modern {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.testimonial-info-modern {
    flex: 1;
}

.testimonial-name-modern {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 5px 0;
}

.testimonial-designation-modern {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0;
}

.testimonial-rating-modern {
    margin-bottom: 15px;
}

.testimonial-rating-modern i {
    color: var(--primary-color);
    font-size: 1rem;
    margin-right: 2px;
}

.testimonial-text-modern {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
    margin: 0;
    font-style: italic;
}

/* Testimonial Carousel Styles */
.testimonial-card-slider {
    background: white;
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 8px 30px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: 1px solid rgba(0,0,0,0.05);
    position: relative;
    overflow: hidden;
    margin: 0 10px;
}

.testimonial-card-slider::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: var(--primary-color);
}

.testimonial-card-slider:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 50px rgba(0,0,0,0.12);
}

.testimonial-avatar-slider {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    overflow: hidden;
    margin-right: 15px;
    flex-shrink: 0;
}

.testimonial-avatar-slider img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.avatar-placeholder-slider {
    width: 60px;
    height: 60px;
    border-radius: 50%;
    background: var(--primary-color);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 20px;
}

.testimonial-info-slider {
    flex: 1;
}

.testimonial-name-slider {
    font-size: 1.1rem;
    font-weight: 600;
    color: #2c3e50;
    margin: 0 0 5px 0;
}

.testimonial-designation-slider {
    font-size: 0.9rem;
    color: #6c757d;
    margin: 0;
}

.testimonial-rating-slider {
    margin-bottom: 15px;
}

.testimonial-rating-slider i {
    color: var(--primary-color);
    font-size: 1rem;
    margin-right: 2px;
}

.testimonial-text-slider {
    font-size: 1rem;
    line-height: 1.6;
    color: #555;
    margin: 0;
    font-style: italic;
}

/* Carousel Controls */
.carousel-control-prev, .carousel-control-next {
    width: 50px;
    height: 50px;
    background: rgba(255, 255, 255, 0.9);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    border: 1px solid #e0e0e0;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    opacity: 0.8;
    z-index: 1051; /* ensure above other UI elements on mobile */
}

.carousel-control-prev {
    left: 15px;
}

.carousel-control-next {
    right: 15px;
}

.carousel-control-prev-icon, .carousel-control-next-icon {
    background-size: 20px 20px;
    filter: invert(0.5);
    width: 20px;
    height: 20px;
}

.carousel-control-prev:hover, .carousel-control-next:hover {
    background: #ffffff;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    opacity: 1;
}

/* Carousel Indicators */
.testimonial-indicators {
    bottom: -50px;
}

.testimonial-indicators button {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    background: #ddd;
    border: none;
    margin: 0 5px;
    transition: all 0.3s ease;
}

.testimonial-indicators button.active {
    background: var(--primary-color);
    transform: scale(1.2);
}

/* Responsive Design for Carousel */
@media (max-width: 768px) {
    .hero-section {
        min-height: 55vh;
        padding: 60px 0;
    }

    /* Size tweaks on mobile */
    .carousel-control-prev, .carousel-control-next {
        width: 40px;
        height: 40px;
    }
    /* Correct positions so next is on the right and prev on the left */
    .carousel-control-prev { left: 10px; }
    .carousel-control-next { right: 10px; }

    .carousel-control-prev-icon, .carousel-control-next-icon {
        background-size: 16px 16px;
        width: 16px;
        height: 16px;
    }

    .testimonial-card-slider {
        margin: 0 5px;
    }

    .testimonial-indicators {
        bottom: -30px;
    }
}

/* Newsletter Section */
.newsletter-section {
    background: linear-gradient(135deg, var(--primary-color, #8B7BA8) 0%, var(--accent-color, #A294C2) 100%);
    color: #fff;
    padding: 100px 0;
    margin-bottom: 40px;
}

.newsletter-form {
    max-width: 500px;
    margin: 0 auto;
}

.newsletter-form .form-control {
    border: none;
    border-radius: 0;
    padding: 18px 25px;
    font-size: 1rem;
}

.newsletter-form .btn {
    border-radius: 0;
    padding: 18px 35px;
    background: #2c3e50;
    border: none;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 1px;
}

/* Services Section spacing */
.services-section {
    margin-top: 40px;
    border-top: 1px solid rgba(0,0,0,0.06);
}

/* WhatsApp Chat Button */
.whatsapp-chat-btn {
    position: fixed;
    right: 20px;
    bottom: 20px;
    width: 56px;
    height: 56px;
    background: #25D366;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    box-shadow: 0 8px 20px rgba(37, 211, 102, 0.4);
    z-index: 1000;
    text-decoration: none;
}
.whatsapp-chat-btn:hover {
    background: #1ebe5d;
    color: #fff;
    transform: translateY(-1px);
}
.whatsapp-chat-btn i {
    font-size: 1.6rem;
}

/* Flash Sale Section */
.flash-sale-section {
    padding: 80px 0;
}

.countdown-timer {
    display: flex;
    justify-content: center;
    gap: 30px;
    margin-bottom: 50px;
}

.countdown-item {
    text-align: center;
    background: #ffffff;
    padding: 22px 24px;
    border-radius: 12px;
    min-width: 100px;
    border: 1px solid rgba(0, 0, 0, 0.08);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

.countdown-number {
    display: block;
    font-size: 2.5rem;
    font-weight: 700;
    font-family: 'Cormorant Garamond', serif;
    color: var(--primary-color) !important;
}

.countdown-label {
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: #6c757d !important;
}

.flash-sale-card .product-info {
    background: white;
    color: #2c3e50;
}

/* Responsive Design */
@media (max-width: 991px) {
    .hero-content {
        text-align: center !important;
        margin: 0 auto;
        padding: 50px 0;
    }
    
    .hero-content h1 {
        font-size: 3rem;
    }
    
    .section-title {
        font-size: 2.5rem;
    }
    
    .section-padding {
        padding: 60px 0;
    }
    
    .countdown-timer {
        gap: 15px;
    }
    
    .countdown-item {
        padding: 15px;
        min-width: 60px;
    }
    
    .countdown-number {
        font-size: 2rem;
    }
}

@media (max-width: 768px) {
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .hero-buttons .btn {
        display: block;
        margin: 10px 0;
        width: 100%;
    }
    
    .category-card {
        height: 300px;
    }
    
    .product-image {
        height: 250px;
    }
}

/* Animation Classes */
.fade-in {
    opacity: 0;
    transform: translateY(30px);
    transition: all 0.6s ease;
}

.fade-in.visible {
    opacity: 1;
    transform: translateY(0);
}

/* Banner Section Styles */
.banner-card {
    cursor: pointer;
    border-radius: 20px;
    overflow: hidden;
}

.banner-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 20px 40px rgba(0,0,0,0.2) !important;
}

.banner-card img {
    transition: transform 0.4s ease;
}

.banner-card:hover img {
    transform: scale(1.08);
}

.banner-card .btn {
    transition: all 0.3s ease;
    background: rgba(255,255,255,0.95);
    color: #333;
    border: none;
    font-weight: 600;
    letter-spacing: 0.5px;
}

.banner-card:hover .btn {
    background: #d4af37;
    color: white;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(212,175,55,0.4);
}

.banner-card h3 {
    font-family: 'Playfair Display', serif;
    font-weight: 700;
}

.banner-card p {
    font-family: 'Inter', sans-serif;
    font-weight: 400;
}

@media (max-width: 768px) {
    .banner-card {
        height: 280px !important;
    }
    
    .banner-card h3 {
        font-size: 1.8rem !important;
    }
    
    .banner-card p {
        font-size: 1rem !important;
    }
    
    .banner-card .btn {
        font-size: 0.9rem;
        padding: 8px 20px !important;
    }
}

@media (max-width: 576px) {
    .banner-card {
        height: 250px !important;
    }
    
    .banner-card h3 {
        font-size: 1.5rem !important;
        margin-bottom: 1rem !important;
    }
    
    .banner-card p {
        font-size: 0.9rem !important;
        margin-bottom: 1.5rem !important;
    }
    
    /* Services Section Mobile */
    .py-5.bg-white {
        padding: 2rem 0 !important;
        overflow: visible;
    }
    
    .service-icon i {
        font-size: 2rem !important;
    }
    
    .service-icon {
        margin-bottom: 15px;
    }
    
    .hero-section {
        min-height: 45vh;
        padding: 50px 0;
    }
    
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .hero-content p {
        font-size: 1rem;
    }
}

/* Latest Blog Section Styles */
.latest-blog-section {
    background: #f8f9fa;
    padding: 100px 0;
}

.blog-card-modern {
    background: white;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.08);
    transition: all 0.3s ease;
    height: 100%;
    border: none;
}

.blog-card-modern:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 40px rgba(0,0,0,0.15);
}

.blog-image-container {
    position: relative;
    height: 250px;
    overflow: hidden;
}

.blog-image-modern {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.blog-image-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #e9ecef 0%, #dee2e6 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 3rem;
}

.blog-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(44, 62, 80, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.blog-card-modern:hover .blog-overlay {
    opacity: 1;
}

.blog-card-modern:hover .blog-image-modern {
    transform: scale(1.1);
}

.blog-read-more {
    color: white;
    font-size: 1.5rem;
    text-decoration: none;
    background: rgba(255,255,255,0.2);
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.blog-read-more:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.1);
}

.blog-content-modern {
    padding: 30px;
}

.blog-meta-modern {
    display: flex;
    gap: 20px;
    margin-bottom: 15px;
    flex-wrap: wrap;
}

.blog-date-modern,
.blog-category-modern {
    font-size: 0.85rem;
    color: #6c757d;
    display: flex;
    align-items: center;
    gap: 5px;
}

.blog-category-modern {
    color: var(--primary-color);
    font-weight: 500;
}

.blog-title-modern {
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.4rem;
    font-weight: 600;
    margin-bottom: 15px;
    line-height: 1.3;
}

.blog-title-modern a {
    color: #2c3e50;
    text-decoration: none;
    transition: color 0.3s ease;
}

.blog-title-modern a:hover {
    color: var(--primary-color);
}

.blog-excerpt-modern {
    color: #6c757d;
    line-height: 1.6;
    margin-bottom: 20px;
    font-size: 0.95rem;
}

.blog-read-link {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 8px;
}

.blog-read-link:hover {
    color: #2c3e50;
    transform: translateX(5px);
}

.blog-read-link i {
    transition: transform 0.3s ease;
}

.blog-read-link:hover i {
    transform: translateX(3px);
}

/* Responsive Design for Blog Section */
@media (max-width: 768px) {
    .latest-blog-section {
        padding: 60px 0;
    }
    
    .blog-image-container {
        height: 200px;
    }
    
    .blog-content-modern {
        padding: 20px;
    }
    
    .blog-title-modern {
        font-size: 1.2rem;
    }
    
    .blog-meta-modern {
        gap: 15px;
    }
}

@media (max-width: 576px) {
    .hero-section {
        min-height: 35vh;
        padding: 30px 0;
    }
    
    .hero-content h1 {
        font-size: 2.5rem;
    }
    
    .hero-content p {
        font-size: 1rem;
    }
    
    .blog-meta-modern {
        flex-direction: column;
        gap: 8px;
    }
    
    .blog-title-modern {
        font-size: 1.1rem;
    }
    
    .blog-excerpt-modern {
        font-size: 0.9rem;
    }
}
</style>
@endpush

@section('content')
@if(isset($sliders) && $sliders->count() > 0)
<!-- Dynamic Slider Section -->
<section class="slider-section">
    <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            @foreach($sliders as $index => $slider)
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"></button>
            @endforeach
        </div>
        <div class="carousel-inner">
            @foreach($sliders as $index => $slider)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <div class="hero-section" style="background-image: url('{{ asset($slider->image) }}'); background-size: cover; background-position: center;">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 {{ $slider->text_position == 'right' ? 'order-lg-2' : '' }}">
                                <div class="hero-content fade-in text-{{ $slider->text_position == 'right' ? 'end' : 'start' }}">
                                    <h1>{{ $slider->title_one ?? 'Diamonds Jewellery Collection' }}</h1>
                                    <p>{{ $slider->title_two ?? 'Discover our exquisite collection of handcrafted diamond jewellery with unmatched elegance and sophistication.' }}</p>
                                    <div class="hero-buttons">
                                        @if($slider->product_slug)
                                        <a href="{{ route('product-detail', ['slug' => $slider->product_slug]) }}" class="btn btn-primary">Shop Now</a>
                                        @else
                                        <a href="{{ route('products') }}" class="btn btn-primary">Shop Now</a>
                                        @endif
                                        <a href="{{ route('about') }}" class="btn btn-outline-primary">Learn More</a>
                                    </div>
                                </div>
                            </div>
                            @if($slider->text_position == 'right')
                            <div class="col-lg-6 order-lg-1">
                                <!-- Image space when text is on right -->
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>
</section>
@else
<!-- Default Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="hero-content fade-in">
                    <h1>Diamonds Jewellery Collection</h1>
                    <p>Discover our exquisite collection of handcrafted diamond jewellery. Each piece is carefully selected and designed to celebrate life's most precious moments with unmatched elegance and sophistication.</p>
                    <div class="hero-buttons">
                        <a href="{{ route('products') }}" class="btn btn-primary">Shop Now</a>
                        <a href="{{ route('about') }}" class="btn btn-outline-primary">Learn More</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="hero-image fade-in">
                    <img src="{{ asset('frontend/images/hero-jewelry.jpg') }}" alt="Diamond Jewellery Collection" class="img-fluid">
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Services Section moved to bottom -->

<!-- Banner Section -->
@if(isset($bannerImages) && $bannerImages->count() > 0)
<section class="py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row g-4">
            @foreach($bannerImages->take(4) as $index => $banner)
            <div class="col-lg-6 col-md-6">
                <div class="banner-card position-relative overflow-hidden rounded-4" style="height: 350px; transition: all 0.3s ease;">
                    <img src="{{ asset($banner->image) }}" alt="{{ $banner->title_one ?? 'Banner' }}" class="w-100 h-100" style="object-fit: cover; object-position: center;">
                    @if($banner->product_slug)
                    <a href="{{ route('category', $banner->product_slug) }}" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-end text-decoration-none">
                        <div class="text-end px-4 me-4" style="color: #000;">
                            @if($banner->title_one)
                            <h3 class="fw-bold mb-3" style="font-size: 2.2rem; color: #000; line-height: 1.2;">{{ $banner->title_one }}</h3>
                            @endif
                            @if($banner->title_two)
                            <p class="mb-4" style="font-size: 1.1rem; color: #000;">{{ $banner->title_two }}</p>
                            @endif
                            <span class="btn btn-primary btn-lg px-4 py-2" style="font-weight: 600; border-radius: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">Shop Now</span>
                        </div>
                    </a>
                    @elseif($banner->link && !str_contains($banner->link, 'shopo-ecom.vercel.app'))
                    <a href="{{ url($banner->link) }}" class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-end text-decoration-none">
                        <div class="text-end px-4 me-4" style="color: #000;">
                            @if($banner->title_one)
                            <h3 class="fw-bold mb-3" style="font-size: 2.2rem; color: #000; line-height: 1.2;">{{ $banner->title_one }}</h3>
                            @endif
                            @if($banner->title_two)
                            <p class="mb-4" style="font-size: 1.1rem; color: #000;">{{ $banner->title_two }}</p>
                            @endif
                            <span class="btn btn-primary btn-lg px-4 py-2" style="font-weight: 600; border-radius: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.2);">View Product</span>
                        </div>
                    </a>
                    @else
                    <div class="position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-end">
                        <div class="text-end px-4 me-4" style="color: #000;">
                            @if($banner->title_one)
                            <h3 class="fw-bold mb-3" style="font-size: 2.2rem; color: #000; line-height: 1.2;">{{ $banner->title_one }}</h3>
                            @endif
                            @if($banner->title_two)
                            <p class="mb-0" style="font-size: 1.1rem; color: #000;">{{ $banner->title_two }}</p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@else
<section class="py-5 bg-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-6 col-md-6">
                <div class="banner-card h-100 overflow-hidden rounded-3 shadow-sm position-relative" style="height: 250px; background-image: url('{{ asset('frontend/images/banner-1.jpg') }}'); background-size: cover; background-position: center;">
                    <a href="{{ route('products') }}?filter=new" class="d-block w-100 h-100 position-relative text-decoration-none">
                        <div class="position-absolute top-50 end-0 translate-middle-y p-4" style="right: 20px !important;">
                            <h5 class="fw-bold mb-2 text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">New Arrivals</h5>
                            <p class="mb-0 text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Latest jewellery collection</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="banner-card h-100 overflow-hidden rounded-3 shadow-sm position-relative" style="height: 250px; background-image: url('{{ asset('frontend/images/banner-2.jpg') }}'); background-size: cover; background-position: center;">
                    <a href="{{ route('products') }}?filter=popular" class="d-block w-100 h-100 position-relative text-decoration-none">
                        <div class="position-absolute top-50 end-0 translate-middle-y p-4" style="right: 20px !important;">
                            <h5 class="fw-bold mb-2 text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">Best Sellers</h5>
                            <p class="mb-0 text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Most popular items</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="banner-card h-100 overflow-hidden rounded-3 shadow-sm position-relative" style="height: 250px; background-image: url('{{ asset('frontend/images/banner-3.jpg') }}'); background-size: cover; background-position: center;">
                    <a href="{{ route('products') }}?filter=sale" class="d-block w-100 h-100 position-relative text-decoration-none">
                        <div class="position-absolute top-50 end-0 translate-middle-y p-4" style="right: 20px !important;">
                            <h5 class="fw-bold mb-2 text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">Special Offers</h5>
                            <p class="mb-0 text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Up to 50% off</p>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="banner-card h-100 overflow-hidden rounded-3 shadow-sm position-relative" style="height: 250px; background-image: url('{{ asset('frontend/images/banner-4.jpg') }}'); background-size: cover; background-position: center;">
                    <a href="{{ route('products') }}?filter=premium" class="d-block w-100 h-100 position-relative text-decoration-none">
                        <div class="position-absolute top-50 end-0 translate-middle-y p-4" style="right: 20px !important;">
                            <h5 class="fw-bold mb-2 text-white" style="text-shadow: 2px 2px 4px rgba(0,0,0,0.7);">Premium Collection</h5>
                            <p class="mb-0 text-white" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.7);">Luxury Jewellery pieces</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endif

<!-- Our Products -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title fade-in"> Bestsellers</h2>
                <p class="section-subtitle fade-in">Discover our carefully selected top-rated jewellery pieces</p>
            </div>
        </div>
        <div class="row g-4">
            @if(isset($products) && $products->count() > 0)
                @foreach($products->take(4) as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="product-card fade-in" data-category="{{ $product->category->slug ?? '' }}" data-price="{{ $product->offer_price ?? $product->price }}" data-name="{{ $product->name }}">
                        <div class="product-image">
                            <a href="{{ route('product-detail', ['slug' => $product->slug]) }}">
                                <img src="{{ $product->thumb_image ? asset($product->thumb_image) : asset('frontend/images/default-product.svg') }}" alt="{{ $product->name }}" class="img-fluid" onerror="this.src='{{ asset('frontend/images/default-product.svg') }}'">
                            </a>
                        
                            <div class="product-overlay">
                                <a href="{{ route('product-detail', ['slug' => $product->slug]) }}" class="btn btn-primary me-2">View Details</a>
                            </div>
                            @if($product->offer_price && $product->offer_price < $product->price)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>
                            @endif
                            @if($product->is_featured)
                                <span class="badge bg-primary position-absolute top-0 end-0 m-2">Featured</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <div class="product-price">
                                @if($product->offer_price && $product->offer_price < $product->price)
                                    {{ $setting->currency_icon }}{{ number_format($product->offer_price, 2) }}
                                    <span class="original-price">{{ $setting->currency_icon }}{{ number_format($product->price, 2) }}</span>
                                @else
                                    {{ $setting->currency_icon }}{{ number_format($product->price, 2) }}
                                @endif
                            </div>
                            <div class="product-rating mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($product->averageRating ?? 5))
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-1 text-muted">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('products') }}?filter=top" class="btn btn-primary">View All Bestsellers</a>
            </div>
        </div>
    </div>
</section>

<!-- Our Collections (Categories) -->
<section class="section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title fade-in">Featured Collections</h2>
                <p class="section-subtitle fade-in">Explore our carefully curated jewellery collections</p>
            </div>
        </div>
        <div class="row g-4">
            @if(isset($featuredCategories) && $featuredCategories->count() > 0)
                @foreach($featuredCategories->take(8) as $featuredCategory)
                    @if($featuredCategory->category)
                    <div class="col-lg-3 col-md-6">
                        <div class="category-card fade-in">
                            <div class="category-image" style="height: 100%; overflow: hidden;">
                                <img src="{{ $featuredCategory->category->image ? asset($featuredCategory->category->image) : asset('frontend/images/category-placeholder.jpg') }}" alt="{{ $featuredCategory->category->name }}" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                                <div class="category-overlay">
                                    <h4 class="category-title">{{ $featuredCategory->category->name }}</h4>
                                    <a href="{{ route('category', $featuredCategory->category->slug) }}" class="btn btn-primary">Shop Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                @endforeach
            @else
                <!-- Default categories if no dynamic categories -->
                <div class="col-lg-3 col-md-6">
                    <div class="category-card fade-in">
                        <div class="category-image" style="height: 100%; overflow: hidden;">
                            <img src="{{ asset('frontend/images/rings.jpg') }}" alt="Rings" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="category-overlay">
                                <h4 class="category-title">Rings</h4>
                                <a href="{{ route('products') }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="category-card fade-in">
                        <div class="category-image" style="height: 100%; overflow: hidden;">
                            <img src="{{ asset('frontend/images/necklaces.jpg') }}" alt="Necklaces" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="category-overlay">
                                <h4 class="category-title">Necklaces</h4>
                                <a href="{{ route('products') }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="category-card fade-in">
                        <div class="category-image" style="height: 100%; overflow: hidden;">
                            <img src="{{ asset('frontend/images/earrings.jpg') }}" alt="Earrings" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="category-overlay">
                                <h4 class="category-title">Earrings</h4>
                                <a href="{{ route('products') }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="category-card fade-in">
                        <div class="category-image" style="height: 100%; overflow: hidden;">
                            <img src="{{ asset('frontend/images/bracelets.jpg') }}" alt="Bracelets" class="img-fluid" style="width: 100%; height: 100%; object-fit: cover;">
                            <div class="category-overlay">
                                <h4 class="category-title">Bracelets</h4>
                                <a href="{{ route('products') }}" class="btn btn-primary">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>



<!-- Featured Products -->
{{-- <section class="featured-products section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3" style="color: #333; font-weight: 600;">Featured Products</h2>
            <p class="section-subtitle text-muted" style="font-size: 1.1rem;">Discover our exquisite collection of handcrafted jewelry</p>
        </div>
        <div class="row g-4">
            @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                @foreach($featuredProducts->take(4) as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="product-card fade-in" data-category="{{ $product->category->slug ?? '' }}" data-price="{{ $product->offer_price ?? $product->price }}" data-name="{{ $product->name }}">
                        <div class="product-image">
                            <a href="{{ route('product-detail', ['slug' => $product->slug]) }}">
                                <img src="{{ $product->thumb_image ? asset($product->thumb_image) : asset('frontend/images/default-product.svg') }}" alt="{{ $product->name }}" class="img-fluid" onerror="this.src='{{ asset('frontend/images/default-product.svg') }}'">
                            </a>
                        
                            <div class="product-overlay">
                                <a href="{{ route('product-detail', ['slug' => $product->slug]) }}" class="btn btn-primary me-2">View Details</a>
                            </div>
                            @if($product->offer_price && $product->offer_price < $product->price)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>
                            @endif
                            @if($product->is_featured)
                                <span class="badge bg-primary position-absolute top-0 end-0 m-2">Featured</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <div class="product-price">
                                @if($product->offer_price && $product->offer_price < $product->price)
                                    {{ $setting->currency_icon }}{{ number_format($product->offer_price, 2) }}
                                    <span class="original-price">{{ $setting->currency_icon }}{{ number_format($product->price, 2) }}</span>
                                @else
                                    {{ $setting->currency_icon }}{{ number_format($product->price, 2) }}
                                @endif
                            </div>
                            <div class="product-rating mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($product->averageRating ?? 5))
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-1 text-muted">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('products') }}?filter=featured" class="btn btn-primary">View All Featured Products</a>
            </div>
        </div>
    </div>
</section> --}}

<!-- New Arrival Products -->
<section class="new-arrival-products section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title fade-in">New Arrivals</h2>
                <p class="section-subtitle fade-in">Discover our latest collection of stunning jewellery pieces</p>
            </div>
        </div>
        <div class="row g-4">
            @if(isset($newArrivalProducts) && $newArrivalProducts->count() > 0)
                @foreach($newArrivalProducts->take(4) as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="product-card fade-in" data-category="{{ $product->category->slug ?? '' }}" data-price="{{ $product->offer_price ?? $product->price }}" data-name="{{ $product->name }}">
                        <div class="product-image">
                            <img src="{{ $product->thumb_image ? asset($product->thumb_image) : asset('frontend/images/default-product.svg') }}" alt="{{ $product->name }}" class="img-fluid" onerror="this.src='{{ asset('frontend/images/default-product.svg') }}';">
                        
                            <div class="product-overlay">
                                <a href="{{ route('product-detail', ['slug' => $product->slug]) }}" class="btn btn-primary me-2">View Details</a>
                            </div>
                            @if($product->offer_price && $product->offer_price < $product->price)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>
                            @endif
                            <span class="badge bg-success position-absolute top-0 end-0 m-2">New</span>
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <div class="product-price">
                                @if($product->offer_price && $product->offer_price < $product->price)
                                    {{ $setting->currency_icon }}{{ number_format($product->offer_price, 2) }}
                                    <span class="original-price">{{ $setting->currency_icon }}{{ number_format($product->price, 2) }}</span>
                                @else
                                    {{ $setting->currency_icon }}{{ number_format($product->price, 2) }}
                                @endif
                            </div>
                            <div class="product-rating mt-2">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= ($product->averageRating ?? 5))
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-1 text-muted">({{ $product->reviews_count ?? 0 }})</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('products') }}?filter=new" class="btn btn-primary">View All New Arrivals</a>
            </div>
        </div>
    </div>
</section>

<!-- Best Products -->
{{-- <section class="best-products section-padding">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="section-title mb-3" style="color: #333; font-weight: 600;">Best Products</h2>
            <p class="section-subtitle text-muted" style="font-size: 1.1rem;">Discover our carefully selected best products that customers love most</p>
        </div>
        <div class="row g-4">
            @if(isset($bestProducts) && $bestProducts->count() > 0)
                @foreach($bestProducts->take(4) as $product)
                <div class="col-lg-3 col-md-6">
                    <div class="product-card fade-in" data-category="{{ $product->category->slug ?? '' }}" data-price="{{ $product->offer_price ?? $product->price }}" data-name="{{ $product->name }}">
                        <div class="product-image">
                            <img src="{{ $product->thumb_image ? asset($product->thumb_image) : asset('frontend/images/default-product.svg') }}" alt="{{ $product->name }}" class="img-fluid" onerror="this.src='{{ asset('frontend/images/default-product.svg') }}';">>
                        
                            <div class="product-overlay">
                                <a href="{{ route('product-detail', $product->slug) }}" class="btn btn-primary me-2">View Details</a>
                            </div>
                            @if($product->offer_price && $product->offer_price < $product->price)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">Sale</span>
                            @endif
                            @if($product->is_best)
                                <span class="badge bg-warning position-absolute top-0 end-0 m-2">Best</span>
                            @endif
                        </div>
                        <div class="product-info">
                            <h5 class="product-title">{{ $product->name }}</h5>
                            <div class="product-price">
                                @if($product->offer_price && $product->offer_price < $product->price)
                                    {{ $setting->currency_icon }}{{ number_format($product->offer_price, 2) }}
                                    <span class="original-price">{{ $setting->currency_icon }}{{ number_format($product->price, 2) }}</span>
                                @else
                                    {{ $setting->currency_icon }}{{ number_format($product->price, 2) }}
                                @endif
                            </div>
                            <div class="product-rating mt-2">
                                @php
                                    $avgRating = $product->averageRating ?? 5;
                                    $fullRating = round($avgRating);
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullRating)
                                        <i class="fas fa-star text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                                <span class="ms-1 text-muted">({{ $product->reviews_count ?? count($product->reviews) }})</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('products') }}?filter=best" class="btn btn-primary">View All Best Products</a>
            </div>
        </div>
    </div>
</section> --}}
<!--============================
    BEST PRODUCTS END
==============================-->

@if(isset($flashSale) && $flashSale && isset($flashSaleProducts) && $flashSaleProducts->count() > 0)
<!-- Flash Sale Section -->
<section class="flash-sale-section section-padding bg-light">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="section-title fade-in">Flash Sale</h2>
                <p class="section-subtitle fade-in">Limited time offer - Don't miss out!</p>
                @if($flashSale->end_time)
                <div class="countdown-timer mb-4" data-end-date="{{ $flashSale->end_time }}">
                    <div class="countdown-item">
                        <span class="countdown-number" id="days">00</span>
                        <span class="countdown-label">Days</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="hours">00</span>
                        <span class="countdown-label">Hours</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="minutes">00</span>
                        <span class="countdown-label">Minutes</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="seconds">00</span>
                        <span class="countdown-label">Seconds</span>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <div class="row g-4">
            @foreach($flashSaleProducts->take(4) as $product)
            <div class="col-lg-3 col-md-6">
                <div class="product-card flash-sale-card fade-in">
                    <div class="product-image">
                        <img src="{{ $product->product->thumb_image ? asset($product->product->thumb_image) : asset('frontend/images/default-product.svg') }}" alt="{{ $product->product->name }}" class="img-fluid" onerror="this.src='{{ asset('frontend/images/default-product.svg') }}';">
                    
                        <div class="product-overlay">
                            <a href="{{ route('product-detail', ['slug' => $product->product->slug]) }}" class="btn btn-light me-2">View Details</a>
                        </div>
                        @if($product->product->offer_price && $product->product->offer_price < $product->product->price)
                            @php
                                $discount = round((($product->product->price - $product->product->offer_price) / $product->product->price) * 100);
                            @endphp
                            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">-{{ $discount }}%</span>
                        @endif
                    </div>
                    <div class="product-info text-dark bg-white p-3">
                        <h5 class="product-title">{{ $product->product->name }}</h5>
                        <div class="product-price">
                            @if($product->product->offer_price && $product->product->offer_price < $product->product->price)
                                {{ $setting->currency_icon }}{{ number_format($product->product->offer_price, 2) }}
                                <span class="original-price text-muted">{{ $setting->currency_icon }}{{ number_format($product->product->price, 2) }}</span>
                            @else
                                {{ $setting->currency_icon }}{{ number_format($product->product->price, 2) }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <div class="row mt-5">
            <div class="col-12 text-center">
                <a href="{{ route('products') }}?filter=flash_sale" class="btn btn-primary btn-lg">
                    View All Flash Sale Products <i class="fas fa-fire ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section>
@endif



<!-- Statistics Section -->
{{-- <section class="stats-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="stat-item fade-in">
                    <span class="stat-number">10K+</span>
                    <div class="stat-label">Happy Customers</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item fade-in">
                    <span class="stat-number">500+</span>
                    <div class="stat-label">Jewellery Pieces</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item fade-in">
                    <span class="stat-number">25+</span>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="stat-item fade-in">
                    <span class="stat-number">99%</span>
                    <div class="stat-label">Satisfaction Rate</div>
                </div>
            </div>
        </div>
    </div>
</section> --}}

<!-- Testimonials Section -->
<section class="testimonials-section py-5" style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h2 class="section-title fade-in">Reviews</h2>
                <p class="section-subtitle fade-in">What our customers say about our jewellery collection</p>
            </div>
        </div>
        
        <!-- Testimonial Carousel (Manual only, no auto slide) -->
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div id="testimonialCarousel" class="carousel slide" data-bs-interval="false" data-bs-touch="true">
                    <div class="carousel-inner">
                        @if(isset($testimonials) && $testimonials->count() > 0)
                            @foreach($testimonials->chunk(3) as $chunkIndex => $testimonialChunk)
                                <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                                    <div class="row justify-content-center">
                                        @foreach($testimonialChunk as $testimonial)
                                            <div class="col-lg-4 col-md-6 mb-4">
                                                <div class="testimonial-card-slider fade-in">
                                                    <div class="testimonial-header">
                                                        <div class="testimonial-avatar-slider">
                                                            @if($testimonial->image)
                                                                <img src="{{ asset($testimonial->image) }}" alt="{{ $testimonial->name }}">
                                                            @else
                                                                <div class="avatar-placeholder-slider">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div class="testimonial-info-slider">
                                                            <h5 class="testimonial-name-slider">{{ $testimonial->name }}</h5>
                                                            <p class="testimonial-designation-slider">{{ $testimonial->designation }}</p>
                                                        </div>
                                                    </div>
                                                    <div class="testimonial-rating-slider mb-3">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= ($testimonial->rating ?? 5))
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                    <p class="testimonial-text-slider">"{{ $testimonial->review }}"</p>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <!-- Default testimonials when no data exists (2 slides of 3 cards) -->
                            <div class="carousel-item active">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="testimonial-card-slider fade-in">
                                            <div class="testimonial-header">
                                                <div class="testimonial-avatar-slider">
                                                    <div class="avatar-placeholder-slider">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="testimonial-info-slider">
                                                    <h5 class="testimonial-name-slider">Sarah Johnson</h5>
                                                    <p class="testimonial-designation-slider">Verified Customer</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-rating-slider mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <p class="testimonial-text-slider">"Absolutely stunning Jewellery! The quality exceeded my expectations and the customer service was exceptional."</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="testimonial-card-slider fade-in">
                                            <div class="testimonial-header">
                                                <div class="testimonial-avatar-slider">
                                                    <div class="avatar-placeholder-slider">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="testimonial-info-slider">
                                                    <h5 class="testimonial-name-slider">Michael Chen</h5>
                                                    <p class="testimonial-designation-slider">Happy Customer</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-rating-slider mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <p class="testimonial-text-slider">"Perfect engagement ring! The craftsmanship is incredible and it arrived exactly as described."</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="testimonial-card-slider fade-in">
                                            <div class="testimonial-header">
                                                <div class="testimonial-avatar-slider">
                                                    <div class="avatar-placeholder-slider">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="testimonial-info-slider">
                                                    <h5 class="testimonial-name-slider">Emma Davis</h5>
                                                    <p class="testimonial-designation-slider">Jewellery Enthusiast</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-rating-slider mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <p class="testimonial-text-slider">"Beautiful necklace collection! Fast shipping and excellent packaging. Highly recommended!"</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="carousel-item">
                                <div class="row justify-content-center">
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="testimonial-card-slider fade-in">
                                            <div class="testimonial-header">
                                                <div class="testimonial-avatar-slider">
                                                    <div class="avatar-placeholder-slider">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="testimonial-info-slider">
                                                    <h5 class="testimonial-name-slider">David Wilson</h5>
                                                    <p class="testimonial-designation-slider">Satisfied Customer</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-rating-slider mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <p class="testimonial-text-slider">"Outstanding quality and design. The attention to detail is remarkable and the delivery was prompt."</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="testimonial-card-slider fade-in">
                                            <div class="testimonial-header">
                                                <div class="testimonial-avatar-slider">
                                                    <div class="avatar-placeholder-slider">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="testimonial-info-slider">
                                                    <h5 class="testimonial-name-slider">Lisa Anderson</h5>
                                                    <p class="testimonial-designation-slider">Regular Customer</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-rating-slider mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <p class="testimonial-text-slider">"Exceptional service and beautiful jewellery pieces. I've been a customer for years and never disappointed."</p>
                                        </div>
                                    </div>
                                    
                                    <div class="col-lg-4 col-md-6 mb-4">
                                        <div class="testimonial-card-slider fade-in">
                                            <div class="testimonial-header">
                                                <div class="testimonial-avatar-slider">
                                                    <div class="avatar-placeholder-slider">
                                                        <i class="fas fa-user"></i>
                                                    </div>
                                                </div>
                                                <div class="testimonial-info-slider">
                                                    <h5 class="testimonial-name-slider">Robert Taylor</h5>
                                                    <p class="testimonial-designation-slider">Happy Buyer</p>
                                                </div>
                                            </div>
                                            <div class="testimonial-rating-slider mb-3">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                            </div>
                                            <p class="testimonial-text-slider">"Premium quality jewellery at reasonable prices. The customer support team is very helpful and responsive."</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Manual Controls only -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                    
                    <!-- Indicators -->
                    <div class="carousel-indicators testimonial-indicators">
                        @if(isset($testimonials) && $testimonials->count() > 0)
                            @foreach($testimonials->chunk(3) as $chunkIndex => $testimonialChunk)
                                <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="{{ $chunkIndex }}" class="{{ $chunkIndex == 0 ? 'active' : '' }}" aria-current="{{ $chunkIndex == 0 ? 'true' : 'false' }}" aria-label="Slide {{ $chunkIndex + 1 }}"></button>
                            @endforeach
                        @else
                            <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Latest Blog Section -->
{{-- <section class="latest-blog-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center mb-5">
                <h2 class="mb-4 fade-in" style="font-weight: 700; color: #2c3e50; font-size: 2.5rem;">Our Blog</h2>
                <p class="lead text-muted fade-in">Stay updated with our latest jewelry trends and insights</p>
            </div>
        </div>
        
        <div class="row">
            @if(isset($blogs) && $blogs->count() > 0)
                @foreach($blogs->take(3) as $blog)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <article class="blog-card-modern fade-in">
                            <div class="blog-image-container">
                                @if($blog->image)
                                    <img src="{{ asset($blog->image) }}" alt="{{ $blog->title }}" class="blog-image-modern">
                                @else
                                    <div class="blog-image-placeholder">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                                <div class="blog-overlay">
                                    <a href="{{ route('blog.detail', $blog->slug) }}" class="blog-read-more">
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                            
                            <div class="blog-content-modern">
                                <div class="blog-meta-modern">
                                    <span class="blog-date-modern">
                                        <i class="far fa-calendar-alt"></i>
                                        {{ $blog->created_at->format('M d, Y') }}
                                    </span>
                                    @if($blog->category)
                                        <span class="blog-category-modern">
                                            <i class="fas fa-tag"></i>
                                            {{ $blog->category->name }}
                                        </span>
                                    @endif
                                </div>
                                
                                <h3 class="blog-title-modern">
                                    <a href="{{ route('blog.detail', $blog->slug) }}">{{ Str::limit($blog->title, 60) }}</a>
                                </h3>
                                
                                @if($blog->short_description)
                                    <p class="blog-excerpt-modern">{{ Str::limit($blog->short_description, 100) }}</p>
                                @else
                                    <p class="blog-excerpt-modern">{{ Str::limit(strip_tags($blog->description), 100) }}</p>
                                @endif
                                
                                <a href="{{ route('blog.detail', $blog->slug) }}" class="blog-read-link">
                                    Read More <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                @endforeach
            @else
                <!-- Default blog posts when no data exists -->
                <div class="col-lg-4 col-md-6 mb-4">
                    <article class="blog-card-modern fade-in">
                        <div class="blog-image-container">
                            <div class="blog-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                            <div class="blog-overlay">
                                <a href="#" class="blog-read-more">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="blog-content-modern">
                            <div class="blog-meta-modern">
                                <span class="blog-date-modern">
                                    <i class="far fa-calendar-alt"></i>
                                    Dec 15, 2023
                                </span>
                                <span class="blog-category-modern">
                                    <i class="fas fa-tag"></i>
                                    Jewelry Care
                                </span>
                            </div>
                            
                            <h3 class="blog-title-modern">
                                <a href="#">How to Care for Your Diamond Jewelry</a>
                            </h3>
                            
                            <p class="blog-excerpt-modern">Learn the best practices for maintaining the brilliance and beauty of your precious diamond jewelry pieces.</p>
                            
                            <a href="#" class="blog-read-link">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <article class="blog-card-modern fade-in">
                        <div class="blog-image-container">
                            <div class="blog-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                            <div class="blog-overlay">
                                <a href="#" class="blog-read-more">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="blog-content-modern">
                            <div class="blog-meta-modern">
                                <span class="blog-date-modern">
                                    <i class="far fa-calendar-alt"></i>
                                    Dec 10, 2023
                                </span>
                                <span class="blog-category-modern">
                                    <i class="fas fa-tag"></i>
                                    Trends
                                </span>
                            </div>
                            
                            <h3 class="blog-title-modern">
                                <a href="#">2024 Jewelry Trends to Watch</a>
                            </h3>
                            
                            <p class="blog-excerpt-modern">Discover the upcoming jewelry trends that will define fashion in 2024 and beyond.</p>
                            
                            <a href="#" class="blog-read-link">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
                
                <div class="col-lg-4 col-md-6 mb-4">
                    <article class="blog-card-modern fade-in">
                        <div class="blog-image-container">
                            <div class="blog-image-placeholder">
                                <i class="fas fa-image"></i>
                            </div>
                            <div class="blog-overlay">
                                <a href="#" class="blog-read-more">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                        
                        <div class="blog-content-modern">
                            <div class="blog-meta-modern">
                                <span class="blog-date-modern">
                                    <i class="far fa-calendar-alt"></i>
                                    Dec 5, 2023
                                </span>
                                <span class="blog-category-modern">
                                    <i class="fas fa-tag"></i>
                                    Guide
                                </span>
                            </div>
                            
                            <h3 class="blog-title-modern">
                                <a href="#">Choosing the Perfect Engagement Ring</a>
                            </h3>
                            
                            <p class="blog-excerpt-modern">A comprehensive guide to selecting the ideal engagement ring for your special moment.</p>
                            
                            <a href="#" class="blog-read-link">
                                Read More <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </article>
                </div>
            @endif
        </div>
        
        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('blog') }}" class="btn btn-outline-primary btn-lg">
                    View All Blogs <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>
    </div>
</section> --}}

<!-- Newsletter Section -->
<section class="newsletter-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-8 mx-auto text-center">
                <h2 class="mb-4 fade-in">Stay Updated</h2>
                <p class="lead mb-4 fade-in">Be the first to know! Subscribe for exclusive updates on new collections & sales. Plus enjoy 10% off your first order.</p>
                <form class="newsletter-form fade-in">
                    <div class="input-group">
                        <input type="email" class="form-control" placeholder="Enter your email address" required>
                        <button class="btn btn-secondary" type="submit">Subscribe</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<!-- Services Section -->
<section class="py-5 bg-white services-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="mb-3">
                        <i class="fas fa-shipping-fast" style="font-size: 2.5rem; color: var(--primary-color);"></i>
                    </div>
                    <h6 class="fw-semibold mb-2" style="color: #333; font-size: 0.95rem;">Free UK Shipping</h6>
                    {{-- <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4;">Free shipping on all orders</p> --}}
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="mb-3">
                        <i class="fas fa-headset" style="font-size: 2.5rem; color: var(--primary-color);"></i>
                    </div>
                    <h6 class="fw-semibold mb-2" style="color: #333; font-size: 0.95rem;">24/7 Support</h6>
                    {{-- <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4;">Dedicated customer support</p> --}}
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="mb-3">
                        <i class="fas fa-undo-alt" style="font-size: 2.5rem; color: var(--primary-color);"></i>
                    </div>
                    <h6 class="fw-semibold mb-2" style="color: #333; font-size: 0.95rem;"> Return and Refunds</h6>
{{-- <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4;">30-day money back guarantee</p> --}}
                </div>
            </div>
            <div class="col-lg-3 col-md-6 mb-4">
                <div class="d-flex flex-column align-items-center">
                    <div class="mb-3">
                        <i class="fas fa-shield-alt" style="font-size: 2.5rem; color: var(--primary-color);"></i>
                    </div>
                    <h6 class="fw-semibold mb-2" style="color: #333; font-size: 0.95rem;">100% Payment Secure</h6>
                    {{-- <p class="text-muted mb-0" style="font-size: 0.85rem; line-height: 1.4;">Bank-level security protection</p> --}}
                </div>
            </div>
        </div>
    </div>
</section>

@php($footer = App\Models\Footer::first())
@if($footer && $footer->phone)
    @php($waPhone = preg_replace('/[^0-9]/', '', $footer->phone))
    <a href="https://wa.me/{{ $waPhone }}" class="whatsapp-chat-btn" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
        <i class="fab fa-whatsapp"></i>
    </a>
@endif
@endsection

@push('scripts')
<script>
// Flash Sale Countdown Timer
function initFlashSaleCountdown() {
    const countdownElement = document.querySelector('.countdown-timer[data-end-date]');
    if (!countdownElement) return;
    
    const endDate = new Date(countdownElement.getAttribute('data-end-date')).getTime();
    
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = endDate - now;
        
        if (distance < 0) {
            // Flash sale has ended
            document.getElementById('days').textContent = '00';
            document.getElementById('hours').textContent = '00';
            document.getElementById('minutes').textContent = '00';
            document.getElementById('seconds').textContent = '00';
            return;
        }
        
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        document.getElementById('days').textContent = days.toString().padStart(2, '0');
        document.getElementById('hours').textContent = hours.toString().padStart(2, '0');
        document.getElementById('minutes').textContent = minutes.toString().padStart(2, '0');
        document.getElementById('seconds').textContent = seconds.toString().padStart(2, '0');
    }
    
    // Update countdown immediately and then every second
    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// Newsletter form submission
document.querySelector('.newsletter-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = this.querySelector('input[type="email"]').value;
    
    if (email) {
        // Here you would typically send the email to your backend
        showNotification('Thank you for subscribing! Enjoy 10% off your first order.', 'success');
        this.reset();
    }
});

// Initialize fade-in animations and countdown
document.addEventListener('DOMContentLoaded', function() {
    // Initialize flash sale countdown
    initFlashSaleCountdown();
    
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.fade-in').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endpush