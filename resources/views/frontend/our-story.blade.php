@extends('frontend.layouts.app')

@section('title', 'Our Story')
@section('meta_description', 'Discover our story—heritage, craftsmanship, and culture reimagined for today.')
@section('meta_keywords', 'our story, heritage, craftsmanship, jewellery')

@push('styles')
<style>
.our-story-hero {
    background: linear-gradient(135deg, var(--bg-elegant, #f8f9fa) 0%, var(--bg-light, #ffffff) 50%, rgba(139, 123, 168, 0.12) 100%);
    padding: 80px 0;
    text-align: center;
}

.our-story-section { padding: 60px 0; }

/* Single large feature image */
.story-image {
    width: 100%;
    height: 420px;
    object-fit: cover;
    border-radius: 12px;
    box-shadow: 0 6px 18px rgba(0,0,0,0.08);
}
@media (min-width: 992px) {
    .story-image { height: 540px; }
}

.story-text {
    background: transparent;
    padding: 32px;
    border-radius: 10px;
    border: none;
    box-shadow: none;
}
.story-text p { line-height: 1.6; color: #555; margin-bottom: 0.9rem; text-align: left; word-spacing: normal; }
.story-text h2 { color: var(--primary-color, #d4af37); margin-bottom: 1rem; font-weight: 300; }

@media (max-width: 576px) {
    .story-text p { line-height: 1.55; }
}
.breadcrumb { background: transparent; padding: 0; margin: 0; }
.breadcrumb-item + .breadcrumb-item::before { content: "/"; color: #6c757d; }
.breadcrumb-item a { color: var(--primary-color, #d4af37); text-decoration: none; }
.breadcrumb-item a:hover { color: var(--accent-color, #e8c547); }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="our-story-hero">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 mb-3">Our Story</h1>
                {{-- <p class="lead">Honouring heritage with modern craftsmanship</p> --}}
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Our Story</li>
        </ol>
    </nav>
</div>

<!-- Two-column layout: single large image + text -->
<section class="our-story-section">
    <div class="container">
        <div class="row g-4 align-items-start">
            {{-- Image removed per request --}}

            <!-- Text Content -->
            <div class="col-lg-12">
                <div class="story-text">
                    <h2>Rooted in Heritage, Crafted for Today</h2>
                    <p>Our journey began with a heartfelt desire to reconnect with our roots and celebrate the timeless artistry of South Asian jewellery.</p>
                    <p>Growing up, jewellery was never just an accessory - it was part of our culture, our celebrations, and our everyday lives. Each piece carried meaning: a grandmother’s bangle, a mother’s necklace, a gift marking life’s milestones. These heirlooms reminded us of who we are and the stories woven into our traditions.</p>
                  
                    <p>With this inspiration, we created a brand that honours the beauty of our heritage while embracing the style of today. Every design in our collection is rooted in traditional craftsmanship, reimagined for the modern wearer who values both culture and convenience. From delicate details to bold statement pieces, our jewellery is made to be cherished every day, not just on special occasions.</p>
                    
                    <p>At its core, our mission is about more than jewellery. It’s about carrying forward the richness of tradition, sharing the beauty of our culture, and making it easy to embrace pieces that feel meaningful and personal. Each design is created with love, so you can wear it with pride and carry a little piece of your story wherever you go.</p>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 text-center">
                <a href="{{ route('home') }}" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Back to Home</a>
            </div>
        </div>
    </div>
</section>
@endsection