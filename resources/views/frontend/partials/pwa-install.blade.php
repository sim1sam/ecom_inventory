@php
    $pwaIcon = ($setting && $setting->logo)
        ? asset($setting->logo)
        : asset('frontend/pwa/icon-192.png');
@endphp

<div id="pwaInstallPopup" class="pwa-install" aria-hidden="true" role="dialog" aria-label="Install this app">
    <div class="pwa-install__card">
        <button type="button" id="pwaInstallDismiss" class="pwa-install__close" aria-label="Close">
            <i class="fas fa-times" aria-hidden="true"></i>
        </button>

        <div class="pwa-install__body">
            <img src="{{ $pwaIcon }}" alt="" class="pwa-install__icon" width="36" height="36">
            <span class="pwa-install__label">Install this app</span>
            <button type="button" id="pwaInstallBtn" class="pwa-install__btn">Install</button>
        </div>
    </div>
</div>
