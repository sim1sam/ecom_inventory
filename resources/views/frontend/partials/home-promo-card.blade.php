@php
    $cardUrl = $url ?? '#';
    $cardImage = $image ?? asset('frontend/images/banner-1.jpg');
    $cardTitle = $title ?? '';
    $cardSubtitle = $subtitle ?? '';
    $cardCta = $cta ?? __('Shop Now');
@endphp

<a href="{{ $cardUrl }}" class="home-promo-card fade-in">
    <img src="{{ $cardImage }}" alt="{{ $cardTitle ?: __('Promo banner') }}" class="home-promo-card__img" loading="lazy">
    <div class="home-promo-card__overlay"></div>
    <div class="home-promo-card__content">
        @if($cardTitle)
            <h3 class="home-promo-card__title">{{ $cardTitle }}</h3>
        @endif
        @if($cardSubtitle)
            <p class="home-promo-card__subtitle">{{ $cardSubtitle }}</p>
        @endif
        <span class="home-promo-card__cta">{{ $cardCta }} <i class="fas fa-arrow-right ms-1"></i></span>
    </div>
</a>
