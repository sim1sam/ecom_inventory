@extends('frontend.layouts.app')

@section('title', __('FAQ'))
@section('meta_description', __('Frequently Asked Questions'))
@section('meta_keywords', __('FAQ, Questions, Answers'))

@push('styles')
<style>
.faq-hero {
    background: linear-gradient(135deg, var(--bg-elegant, #f8f9fa) 0%, var(--bg-light, #ffffff) 50%, rgba(139, 123, 168, 0.1) 100%);
    padding: 80px 0;
    text-align: center;
}

.breadcrumb { background: transparent; padding: 0; margin: 0; }
.breadcrumb-item + .breadcrumb-item::before { content: "/"; color: #6c757d; }
.breadcrumb-item a { color: var(--primary-color, #d4af37); text-decoration: none; }
.breadcrumb-item a:hover { color: var(--accent-color, #e8c547); }
.breadcrumb-item.active { color: #6c757d; }
nav[aria-label="breadcrumb"] { background: transparent; padding: 20px 0; }

.faq-section { padding: 60px 0; }
.faq-card { border: 1px solid rgba(139, 123, 168, 0.15); border-radius: 8px; margin-bottom: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.06); }
.faq-card .card-header { background: rgba(255,255,255,0.9); }
.faq-card .card-header a { color: #333; font-weight: 600; display: block; }
.faq-card .card-body { background: rgba(255,255,255,0.95); line-height: 1.8; color: #555; }
</style>
@endpush

@section('content')
<!-- Hero -->
<section class="faq-hero">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <h1 class="display-4 mb-3">{{ __('Frequently Asked Questions') }}</h1>
                <p class="lead">{{ __('Find answers to common questions below') }}</p>
            </div>
        </div>
    </div>
</section>

<!-- Breadcrumb -->
<div class="container">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ __('FAQ') }}</li>
        </ol>
    </nav>
</div>

<!-- FAQ Content -->
<section class="faq-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if($faqs && $faqs->count() > 0)
                    <div id="faqAccordion" role="tablist" aria-multiselectable="true">
                        @foreach($faqs as $index => $faq)
                            @php $collapseId = 'collapse'.$index; $headingId = 'heading'.$index; @endphp
                            <div class="card faq-card">
                                <div class="card-header" role="tab" id="{{ $headingId }}">
                                    <h5 class="mb-0">
                                        <a data-bs-toggle="collapse" data-bs-target="#{{ $collapseId }}" href="#{{ $collapseId }}" aria-expanded="false" aria-controls="{{ $collapseId }}" class="collapsed">
                                            {{ $faq->question }}
                                        </a>
                                    </h5>
                                </div>
                                <div id="{{ $collapseId }}" class="collapse" role="tabpanel" aria-labelledby="{{ $headingId }}" data-bs-parent="#faqAccordion">
                                    <div class="card-body">
                                        {!! clean($faq->answer) !!}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-question-circle fa-4x text-muted mb-3"></i>
                        <h3 class="mb-3">{{ __('No FAQs available right now') }}</h3>
                        <p class="text-muted">{{ __('We are updating our Frequently Asked Questions. Please check back later or contact us for assistance.') }}</p>
                        <a href="{{ route('contact') }}" class="btn btn-primary">
                            <i class="fas fa-envelope me-2"></i>{{ __('Contact Us') }}
                        </a>
                    </div>
                @endif

                <!-- Back to Home Button -->
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
$(document).ready(function() {
    // Ensure only one panel open at a time (Bootstrap 4 behavior via data-parent already)
});
</script>
@endpush