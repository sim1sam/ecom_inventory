@php
    $sliderId = $sliderId ?? 'priceRangeSlider';
    $applyButtonId = $applyButtonId ?? 'applyPriceFilter';
    $title = $title ?? __('Price Range');
@endphp

<div class="filter-section">
    <h6 class="filter-title">{{ $title }}</h6>
    <div class="price-range-slider"
         id="{{ $sliderId }}"
         data-price-range-slider
         data-floor="{{ $priceFloor }}"
         data-ceil="{{ $priceCeil }}"
         data-step="{{ $priceStep }}"
         data-currency="{{ $setting->currency_icon }}">
        <div class="price-range-slider__values">
            <span class="price-range-slider__min-label">{{ $setting->currency_icon }}{{ number_format($selectedMinPrice) }}</span>
            <span class="price-range-slider__sep">—</span>
            <span class="price-range-slider__max-label">{{ $setting->currency_icon }}{{ number_format($selectedMaxPrice) }}</span>
        </div>
        <div class="price-range-slider__track">
            <div class="price-range-slider__fill"></div>
            <input type="range" class="price-range-slider__input price-range-slider__input--min"
                   min="{{ $priceFloor }}" max="{{ $priceCeil }}" step="{{ $priceStep }}"
                   value="{{ $selectedMinPrice }}" aria-label="{{ __('Minimum price') }}">
            <input type="range" class="price-range-slider__input price-range-slider__input--max"
                   min="{{ $priceFloor }}" max="{{ $priceCeil }}" step="{{ $priceStep }}"
                   value="{{ $selectedMaxPrice }}" aria-label="{{ __('Maximum price') }}">
        </div>
        <button type="button" class="btn btn-outline-primary btn-sm mt-3 w-100 price-range-slider__apply d-none d-lg-block" id="{{ $applyButtonId }}">
            {{ __('Apply Price Filter') }}
        </button>
    </div>
</div>
