@php
    $gtm = $gtm ?? \App\Models\GoogleTagManager::current();
@endphp
@if($gtm && $gtm->isActive())
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id={{ $gtm->container_id }}"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
@endif
