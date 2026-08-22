@extends('frontend.layouts.app')

@section('title', $page->page_name)
@section('meta_description', Str::limit(strip_tags($page->description), 155))
@section('meta_keywords', $page->page_name)

@push('styles')
<style>
.custom-page-hero {
    background: linear-gradient(135deg, var(--bg-elegant, #f8f9fa) 0%, var(--bg-light, #ffffff) 50%, rgba(var(--primary-rgb), 0.1) 100%);
    padding: 80px 0;
    text-align: center;
}

.custom-page-section { padding: 60px 0; }
.custom-page-content {
    background: rgba(255, 255, 255, 0.95);
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    border: 1px solid rgba(var(--primary-rgb), 0.1);
    backdrop-filter: blur(6px);
}
.custom-page-content h1, .custom-page-content h2, .custom-page-content h3 {
    color: var(--primary-color, #d4af37);
    margin-bottom: 1rem;
}
.custom-page-content p { line-height: 1.8; color: #555; }
.custom-page-content ul, .custom-page-content ol { padding-left: 1.25rem; }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="custom-page-hero">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 mb-3">{{ $page->page_name }}</h1>
                <p class="lead">{{ __('Explore details below') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="custom-page-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="custom-page-content">
                    {!! clean($page->description) !!}
                </div>
                <div class="text-center mt-4">
                    <a href="{{ route('home') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Home') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
$(function(){
    $('a[href^="#"]').on('click', function(e){
        var target = $(this.getAttribute('href'));
        if(target.length){
            e.preventDefault();
            $('html, body').animate({ scrollTop: target.offset().top - 100 }, 800);
        }
    });
});
</script>
@endpush