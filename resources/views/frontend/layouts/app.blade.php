@php
    $setting = App\Models\Setting::first();
    $footer = App\Models\Footer::first();
    $footerLinks1 = App\Models\FooterLink::where('column', 1)->get();
    $footerLinks2 = App\Models\FooterLink::where('column', 2)->get();
    $footerLinks3 = App\Models\FooterLink::where('column', 3)->get();
    $socialLinks = App\Models\FooterSocialLink::all();
    $categories = App\Models\Category::where('status', 1)->orderBy('name', 'asc')->get();
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes, maximum-scale=5.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#d4af37">
    <title>@yield('title', isset($seoSetting) ? $seoSetting->seo_title : 'Diamonds Jewellery Collection')</title>
    <meta name="description" content="@yield('meta_description', isset($seoSetting) ? $seoSetting->seo_description : 'Discover our exquisite collection of diamond jewellery, rings, necklaces, and more.')">
    <meta name="keywords" content="@yield('meta_keywords', isset($seoSetting) ? $seoSetting->seo_keywords : 'diamonds, jewellery, rings, necklaces, earrings, bracelets')">
    
    @if(isset($seoSetting))
        @if($seoSetting->facebook_app_id)
        <meta property="fb:app_id" content="{{ $seoSetting->facebook_app_id }}">
        @endif
        
        <!-- Open Graph Meta Tags -->
        <meta property="og:title" content="@yield('og_title', $seoSetting->seo_title)">
        <meta property="og:description" content="@yield('og_description', $seoSetting->seo_description)">
        <meta property="og:image" content="@yield('og_image', asset('frontend/images/og-image.jpg'))">
        <meta property="og:url" content="{{ url()->current() }}">
        <meta property="og:type" content="website">
        <meta property="og:site_name" content="{{ $seoSetting->seo_title }}">
        
        <!-- Twitter Card Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta name="twitter:title" content="@yield('twitter_title', $seoSetting->seo_title)">
        <meta name="twitter:description" content="@yield('twitter_description', $seoSetting->seo_description)">
        <meta name="twitter:image" content="@yield('twitter_image', asset('frontend/images/twitter-image.jpg'))">
        
        @if($seoSetting->google_analytics_id)
        <!-- Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seoSetting->google_analytics_id }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag(){dataLayer.push(arguments);}
            gtag('js', new Date());
            gtag('config', '{{ $seoSetting->google_analytics_id }}');
        </script>
        @endif
        
        @if($seoSetting->facebook_pixel_id)
        <!-- Facebook Pixel -->
        <script>
            !function(f,b,e,v,n,t,s)
            {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '{{ $seoSetting->facebook_pixel_id }}');
            fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id={{ $seoSetting->facebook_pixel_id }}&ev=PageView&noscript=1"/></noscript>
        @endif
    @endif
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ $setting && $setting->favicon ? asset($setting->favicon) : asset('frontend/images/favicon.ico') }}">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.cdnfonts.com/css/nexa" rel="stylesheet">

    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/style.css') }}">
    
    <!-- Dynamic Theme Colors - NOORAANI Elegant Theme -->
    <style>
        :root {
            --primary-color: {{ $setting->theme_one ?? '#8B7BA8' }}; /* Elegant purple from logo */
            --secondary-color: {{ $setting->theme_two ?? '#F7F6FA' }}; /* Light purple-tinted background */
            --statistics-color: {{ $setting->statistics_color ?? '#6B6B83' }}; /* Sophisticated gray-purple */
            --statistics-font-color: {{ $setting->statistics_font_color ?? '#ffffff' }};
            --accent-color: #A594C4; /* Light purple accent */
            --text-dark: #4A4A5C; /* Deep purple-gray */
            --bg-elegant: #F2F1F6; /* Elegant light background */
            --gradient-bg: linear-gradient(135deg, #F7F6FA 0%, #F2F1F6 50%, #EAE8F0 100%);
            /* Added theme support variables used by auth pages */
            --dark-purple: #6B4E9D; /* Deep complementary purple */
            --soft-shadow: rgba(139, 123, 168, 0.25); /* Soft purple shadow */
            --pearl-white: #ffffff; /* For light gradient accents */
            --light-purple: #EAE8F0; /* Light purple tint */
        }
        
        /* Enhanced Background Styling */
        body {
            background: var(--gradient-bg) !important;
            position: relative;
        }
        
        .main-wrapper {
            background: transparent;
        }
        
        /* Global Layout Fixes */
        html, body {
            overflow-x: hidden;
            width: 100%;
        }
        
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
            overflow-x: hidden;
        }
        
        /* Header Navbar Layout Styles - Always Fixed */
        .main-header {
            border-bottom: 1px solid var(--border-color, #E5E3EB);
            width: 100%;
            overflow: visible !important;
            position: fixed !important;
            top: 0;
            left: 0;
            right: 0;
            z-index: 9999 !important;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 15px rgba(139, 123, 168, 0.15);
        }
        
        /* Prevent mobile action buttons from moving during menu toggle */
        .mobile-actions-container {
            transition: none !important;
            animation: none !important;
        }
        
        .navbar {
            z-index: 9998 !important;
            position: relative;
            overflow: visible !important;
        }
        
        /* Add padding to body to prevent content being hidden behind fixed navbar */
        body {
            padding-top: 72px; /* reduced to match slimmer header */
        }
        
        /* Ensure container doesn't restrict dropdown visibility */
        .container {
            overflow: visible !important;
        }
        
        /* Prevent any scrollbars on dropdown parent elements */
        .nav-item.dropdown {
            overflow: visible !important;
        }
        
        .navbar-nav .dropdown {
            position: relative;
            z-index: 9998 !important;
            overflow: visible !important;
        }
        
        .navbar-collapse {
            overflow: visible !important;
        }
        
        .navbar-nav {
            overflow: visible !important;
        }
        
        /* Dropdown Menu Styling */
        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-radius: 8px;
            padding: 0.5rem 0;
            z-index: 10000 !important;
            position: absolute !important;
            display: none;
            background: #ffffff !important;
            min-width: 200px;
            overflow: visible !important;
            max-height: none !important;
        }
        

        
        /* Show dropdown when Bootstrap activates it */
        .dropdown.show .dropdown-menu {
            display: block !important;
        }
        
        /* Optional: Also show on hover for better UX */
        .dropdown:hover .dropdown-menu {
            display: block !important;
        }
        
        /* Dropdown items styling */
        .dropdown-item {
            padding: 0.75rem 1.5rem;
            font-weight: 400;
            color: #333333;
            transition: all 0.3s ease;
        }
        
        .dropdown-item:hover {
            background: rgba(212, 175, 55, 0.1);
            color: var(--primary-color);
        }
        
        /* Categories dropdown - appears above to avoid slider overlap */
        .navbar-nav .dropdown:first-of-type .dropdown-menu {
            top: auto !important;
            bottom: 100% !important;
            margin-bottom: 0.5rem !important;
            margin-top: 0 !important;
            transform: translateY(-10px) !important;
        }
        
        /* More dropdown - appears below normally */
        .navbar-nav .dropdown:last-of-type .dropdown-menu {
            top: 100% !important;
            bottom: auto !important;
            margin-top: 0.5rem !important;
            margin-bottom: 0 !important;
            transform: translateY(0) !important;
        }
        
        .navbar {
            padding: 1.5rem 0;
        }
        
        .navbar-brand {
            margin-right: 2rem;
        }
        
        .logo-img {
            width: 100%;
            height: auto;
            max-width: 150px;
            display: block;
        }
        
        .logo-text {
            font-size: 1.8rem;
            font-weight: bold;
        }
        
        .nav-link {
            color: #333 !important;
            font-weight: 500;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover,
        .nav-link.active {
            color: var(--primary-color) !important;
        }
        
        /* Default dropdown item active state */
        .dropdown-item.active {
            color: var(--primary-color) !important;
            background-color: transparent !important;
        }
        
        /* Blog dropdown item active state uses secondary color */
        .dropdown-item.active[href*="blog"] {
            color: var(--secondary-color) !important;
            background-color: transparent !important;
        }
        
        .search-section {
            max-width: 250px;
            min-width: 180px;
        }
        
        /* Main Content Spacing */
        .main-content {
            margin-top: -20px;
            padding-top: 10px;
        }
        
        /* Responsive Main Content Spacing */
        @media (max-width: 768px) {
            .main-content {
                margin-top: -15px;
                padding-top: 8px;
            }
        }
        
        @media (max-width: 576px) {
            .main-content {
                margin-top: -10px;
                padding-top: 5px;
            }
        }
        
        .search-section .form-control {
            width: 100%;
            border: 2px solid #e9ecef;
            transition: border-color 0.3s ease;
        }
        
        .search-section .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(212, 175, 55, 0.25);
        }
        
        .header-actions .btn-link {
            padding: 0.5rem;
            transition: color 0.3s ease;
            text-decoration: none;
        }
        
        .header-actions .btn-link:hover {
            color: var(--primary-color) !important;
        }

        /* Mobile Devices */
        @media (max-width: 767px) {
            .navbar {
                padding: 0.75rem 0; /* slightly tighter */
                justify-content: space-between;
                position: relative; /* allow absolute-positioned mobile actions */
                padding-right: 80px; /* reserve space for cart on right */
                padding-left: 80px;  /* reserve space for menu on left */
                min-height: 54px; /* slimmer header */
            }
            
            .navbar-brand {
                flex: 0 0 auto;
                margin-right: 1rem;
                display: flex !important;
                align-items: center;
                justify-content: center; /* center the logo */
                width: 100%;
                padding: 0 60px; /* add padding to prevent overlap with action buttons */
            }
            
            .logo-img {
                max-width: 120px; /* reduce logo size on mobile */
                height: auto;
                display: block !important;
            }
            
            .logo-text {
                font-size: 1.4rem;
                display: block !important;
                color: #2c3e50 !important;
                font-weight: 700;
            }
            
            .search-section {
                max-width: 180px;
                min-width: 120px;
                margin: 0.5rem 0;
                flex: 1 1 auto;
            }
            
            .header-actions {
                margin-top: 0.5rem;
                flex: 0 0 auto;
            }

            /* Mobile Actions Container - holds both menu and cart in same div */
            .mobile-actions-container {
                position: absolute !important;
                top: 50%;
                left: 0;
                right: 0;
                transform: translateY(-50%);
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 0.75rem;
                z-index: 1051; /* higher than navbar */
                pointer-events: none; /* allow clicks to pass through container */
                transition: none !important; /* prevent any transitions */
            }
            
            /* Mobile menu button - positioned on left */
            .mobile-menu-btn {
                pointer-events: auto; /* re-enable clicks on button */
                transition: none !important;
            }
            
            /* Mobile cart button - positioned on right */
            .mobile-cart-btn {
                pointer-events: auto; /* re-enable clicks on button */
                transition: none !important;
            }
            
            /* Icon button styling for mobile actions */
            .mobile-menu-btn,
            .mobile-cart-btn {
                width: 36px;
                height: 36px;
                display: inline-flex;
                align-items: center;
                justify-content: center;
                /* removed circle styles for menu button via override below */
                border-radius: 50%;
                border: 1px solid #dee2e6;
                background: #fff;
                color: #2c3e50;
                box-shadow: 0 2px 8px rgba(0,0,0,0.08);
                transition: all 0.3s ease;
            }
            
            .mobile-menu-btn i,
            .mobile-cart-btn i { color: var(--primary-color); }
            .mobile-menu-btn:hover,
            .mobile-cart-btn:hover {
                color: var(--primary-color);
                border-color: var(--primary-color);
                box-shadow: 0 4px 12px rgba(0,0,0,0.15);
                transform: scale(1.05);
            }

            /* Themed hamburger icon using CSS bars */
            .mobile-actions-container .navbar-toggler-icon {
                width: 24px;
                height: 16px;
                position: relative;
                background: none !important;
                background-image: none !important;
            }
            .mobile-actions-container .navbar-toggler-icon::before,
            .mobile-actions-container .navbar-toggler-icon::after,
            .mobile-actions-container .navbar-toggler-icon > span {
                content: "";
                position: absolute;
                left: 0;
                right: 0;
                height: 2px;
                background-color: var(--primary-color);
                border-radius: 2px;
            }
            .mobile-actions-container .navbar-toggler-icon::before { top: 0; }
            .mobile-actions-container .navbar-toggler-icon > span { top: 7px; }
            .mobile-actions-container .navbar-toggler-icon::after { bottom: 0; }

            /* Close icon color to match theme */
            .mobile-actions-container .close-icon i {
                color: var(--primary-color) !important;
            }
            
            .mobile-menu-btn {
                padding: 0;
                border: 0 !important;
                background: transparent !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                width: auto;
                height: auto;
            }
            .mobile-menu-btn:hover {
                border-color: transparent !important;
                box-shadow: none !important;
                transform: none !important;
            }

            /* Remove circle on mobile cart button */
            .mobile-cart-btn {
                padding: 0;
                border: 0 !important;
                background: transparent !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                width: auto;
                height: auto;
            }
            .mobile-cart-btn:hover {
                border-color: transparent !important;
                box-shadow: none !important;
                transform: none !important;
            }

            /* Show badge unless explicitly hidden with d-none */
            .mobile-cart-btn .cart-count.d-none {
                display: none !important;
            }
        }

        /* Tablet and Small Desktop */
        @media (min-width: 768px) and (max-width: 1399px) {
            .navbar {
                padding: 1rem 0;
            }
            
            .navbar-brand {
                margin-right: 1rem;
            }
            
            .logo-img {
                max-width: 120px;
            }
            
            .logo-text {
                font-size: 1.4rem;
            }
            
            .search-section {
                max-width: 220px;
                min-width: 140px;
            }
        }
        
        /* Medium Desktop */
        @media (min-width: 1200px) and (max-width: 1399px) {
            .navbar {
                padding: 0.5rem 0;
            }
            
            .logo-img {
                /* max-width removed */
            }
            
            .logo-text {
                font-size: 1.8rem;
            }
        }
        
         /* Desktop Layout */
         @media (min-width: 992px) {
             .navbar-collapse {
                 display: flex !important;
                 align-items: center;
                 justify-content: flex-start;
                 gap: 0;
             }
             
             /* Add extra space between logo and menu on desktop */
             .navbar-brand {
                 margin-right: 2.5rem;
             }

             .navbar-nav {
                 flex-direction: row;
                 /* Grow to fill space between logo and search, center items */
                 flex: 1 1 auto;
                 justify-content: center;
                 margin-left: 0;
                 margin-right: 0.75rem; /* small, consistent gap before search */
                 margin-top: 2px; /* lower menu items slightly */
             }
             
             .search-section {
                 flex: 0 0 320px;
                 max-width: 320px;
                 width: 320px;
                 margin-left: 0;
                 margin-right: 0;
             }
         }
         

           
           /* Large Desktop */
           @media (min-width: 1400px) and (max-width: 1659px) {
                .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
                    max-width: 1500px;
                }
                
                .navbar {
                    padding: 0.75rem 0;
                }
                
                .logo-img {
                    /* max-width removed */
                }
                
                .logo-text {
                    font-size: 2.5rem;
                }
            }
            
            /* Ultra Wide Desktop */
            @media (min-width: 1660px) {
                .container, .container-lg, .container-md, .container-sm, .container-xl, .container-xxl {
                    max-width: 1550px;
                }
                
                .navbar {
                    padding: 0.75rem 0;
                }
                
                .logo-img {
                    /* max-width removed */
                }
                
                .logo-text {
                    font-size: 3rem;
                }
            }
        
        /* Mobile Layout */
        @media (max-width: 991.98px) {
            .navbar-collapse {
                margin-top: 1rem;
                position: relative;
                z-index: 1000; /* below action buttons */
            }
            
            .navbar-nav {
                margin-bottom: 1rem;
            }
            
            .search-section {
                margin-bottom: 1rem;
                width: 100%;
                max-width: none;
            }
            
            .header-actions {
                justify-content: center;
            }
            
            /* Ensure mobile action buttons stay fixed during menu toggle */
            .mobile-actions-container {
                position: absolute !important;
                z-index: 1051 !important;
                transition: none !important;
            }
            
            /* Prevent navbar collapse from affecting action button positions */
            .navbar-collapse.show ~ .mobile-actions-container {
                position: absolute !important;
            }
            
            /* Ensure main header doesn't change height during menu toggle */
            .main-header {
                height: auto !important;
                min-height: 80px !important;
            }
            
            /* Mobile dropdown adjustments - Fix overlapping menus */
            .dropdown-menu {
                position: static !important;
                float: none !important;
                width: 100% !important;
                margin-top: 0 !important;
                margin-bottom: 0.5rem !important;
                border: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                background: transparent !important;
                display: none !important;
                transform: none !important;
                left: auto !important;
                right: auto !important;
                top: auto !important;
                bottom: auto !important;
                z-index: 1000 !important;
            }
            
            /* Show dropdown when toggled - ensure only the clicked dropdown shows */
            .dropdown.show .dropdown-menu {
                display: block !important;
            }
            
            /* Hide all other dropdowns when one is shown */
            .navbar-nav .dropdown:not(.show) .dropdown-menu {
                display: none !important;
            }
            
            /* Ensure proper spacing between mobile dropdown containers */
            .navbar-nav .dropdown {
                margin-bottom: 0.5rem !important;
                position: relative !important;
            }
            
            /* Ensure each dropdown is independent */
            .navbar-nav .dropdown .dropdown-menu {
                position: static !important;
                width: 100% !important;
                box-shadow: none !important;
                border: 0 !important;
                background: transparent !important;
            }
            
            /* Fix navbar collapse spacing on mobile */
            .navbar-collapse {
                margin-top: 1rem;
                overflow: visible !important;
            }
            
            /* Ensure dropdown items are properly styled */
            .dropdown-item {
                padding: 0.75rem 1rem !important;
                color: #333 !important;
                border-bottom: 1px solid #f8f9fa !important;
                display: block !important;
                width: 100% !important;
                text-align: left !important;
            }
            
            .dropdown-item:last-child {
                border-bottom: none !important;
            }
            
            .dropdown-item:hover {
                background-color: #f8f9fa !important;
                color: #007bff !important;
            }
            
            /* Ensure dropdown toggles work properly on mobile */
            .navbar-nav .nav-link.dropdown-toggle {
                position: relative !important;
                display: block !important;
                width: 100% !important;
                text-align: left !important;
                padding: 0.75rem 1rem !important;
                border: none !important;
                background: transparent !important;
            }
            
            .navbar-nav .nav-link.dropdown-toggle::after {
                float: right !important;
                margin-top: 0.375rem !important;
            }

            /* Keep menu + cart on the same line on tablet/mobile */
            .navbar {
                position: relative;
                padding-right: 80px; /* reserve space for cart on right */
                padding-left: 80px;  /* reserve space for menu on left */
                min-height: 54px; /* match slimmer mobile header */
            }
            
            .navbar-brand {
                justify-content: center;
                width: 100%;
                padding: 0 60px;
            }
            
            /* Mobile Actions Container - tablet/mobile */
            .mobile-actions-container {
                position: absolute !important;
                top: 50%;
                left: 0;
                right: 0;
                transform: translateY(-50%);
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0 1rem;
                z-index: 1051; /* higher than navbar */
                pointer-events: none; /* allow clicks to pass through container */
                transition: none !important; /* prevent any transitions */
            }
            
            .mobile-menu-btn,
            .mobile-cart-btn {
                width: auto;
                height: auto;
                border: 0 !important;
                background: transparent !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                transition: none !important;
            }
            .mobile-cart-btn:hover {
                border-color: transparent !important;
                box-shadow: none !important;
                transform: none !important;
            }

            /* Show badge unless explicitly hidden with d-none */
            .mobile-cart-btn .cart-count.d-none {
                display: none !important;
            }

            /* Flat mobile dropdown – remove box visuals */
            .navbar .dropdown-menu {
                border: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
            }
            .navbar .dropdown-menu.show { display: block !important; }
            .navbar .dropdown-menu .dropdown-item { padding: 0.5rem 0 !important; }

            /* Stronger override: ensure no box on any mobile dropdown */
            .main-header .dropdown-menu,
            .navbar .dropdown-menu,
            .nav-item .dropdown-menu,
            .dropdown-menu {
                border: 0 !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                background: transparent !important;
                padding: 0 !important;
            }
            .dropdown-menu.show { display: block !important; }
            .dropdown-menu .dropdown-item {
                padding: 0.5rem 0 !important;
                background: transparent !important;
            }

        }
        
        @media (max-width: 576px) {
            .navbar-brand h4 {
                font-size: 1.2rem;
            }
            
            .header-actions .btn-sm {
                font-size: 0.8rem;
                padding: 0.25rem 0.5rem;
            }
        }
        
        /* Hide top bar with email and social links on mobile and tablet */
        @media (max-width: 991.98px) {
            .top-bar.corano-topbar {
                display: none !important;
            }
        }

        /* Hide top bar globally as requested */
        .top-bar.corano-topbar {
            display: none !important;
        }
        
        /* Breadcrumbs (global) - set to primary color */
        nav[aria-label="breadcrumb"] .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
        }
        nav[aria-label="breadcrumb"] .breadcrumb-item a {
            color: var(--primary-color) !important;
            text-decoration: none;
        }
        nav[aria-label="breadcrumb"] .breadcrumb-item a:hover {
            color: var(--accent-color, #A594C4) !important;
        }
        nav[aria-label="breadcrumb"] .breadcrumb-item.active {
            color: var(--primary-color) !important;
        }
        nav[aria-label="breadcrumb"] .breadcrumb-item + .breadcrumb-item::before {
            content: "/";
            color: var(--primary-color) !important;
        }

    </style>
    
    @stack('styles')
    <style>
        /* WhatsApp Chat Button (global) */
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
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <!-- Top Bar -->
        @if(!request()->routeIs('contact'))
        <div class="top-bar corano-topbar py-2">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="contact-info">
                            <span class="me-3"><i class="fas fa-phone me-1"></i> +1 (555) 123-4567</span>
                            <span><i class="fas fa-envelope me-1"></i> info@diamondsjewelry.com</span>
                        </div>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="social-links">
                            <a href="#" class="topbar-social-link me-2"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" class="topbar-social-link me-2"><i class="fab fa-instagram"></i></a>
                            <a href="#" class="topbar-social-link me-2"><i class="fab fa-twitter"></i></a>
                            <a href="#" class="topbar-social-link"><i class="fab fa-pinterest"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <!-- Main Header with Navigation in One Line -->
        <div class="main-header bg-white shadow-sm">
            <div class="container">
                <nav class="navbar navbar-expand-lg navbar-light py-3">
                    <!-- Logo Section -->
                    <a class="navbar-brand" href="{{ route('home') }}">
                        @if($setting && $setting->logo)
                            <img src="{{ asset($setting->logo) }}" alt="Diamonds Jewellery" class="img-fluid logo-img">
                        @else
                            <h4 class="mb-0 text-dark fw-bold logo-text">Diamonds</h4>
                        @endif
                    </a>
                    
                    <!-- Mobile Actions Container - Menu (left) and Cart (right) in same div -->
                    <div class="d-lg-none mobile-actions-container">
                        <button class="navbar-toggler mobile-menu-btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"><span></span></span>
                    <span class="close-icon d-none"><i class="fas fa-times fs-4"></i></span>
                </button>
                        <a href="{{ route('cart') }}" class="btn-icon text-dark position-relative wsus__cart_icon mobile-cart-btn" aria-label="Cart">
                            <i class="fas fa-shopping-bag"></i>
                            <span class="cart-count badge bg-primary position-absolute top-0 start-100 translate-middle d-none">0</span>
                        </a>
                    </div>
                    
                    <!-- Collapsible Content -->
                    <div class="collapse navbar-collapse" id="navbarNav">
                        <!-- Navigation Menu -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Categories
                                </a>
                                <ul class="dropdown-menu">
                                    @foreach($categories as $category)
                                        <li><a class="dropdown-item" href="{{ route('category', $category->slug) }}">{{ $category->name }}</a></li>
                                    @endforeach
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}" href="{{ route('products') }}">Products</a>
                            </li>

                               <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('our-story') ? 'active' : '' }}" href="{{ route('our-story') }}">Our Story</a>
                            </li>

                     



                     
                        </ul>
                        
                        <!-- Search Bar -->
                        <div class="search-section">
                            <form action="{{ route('products') }}" method="GET" class="position-relative">
                                <input type="text" name="search" class="form-control pe-5" placeholder="Search" value="{{ request('search') }}" style="border-radius: 25px;">
                                <button type="submit" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        
                        <!-- Cart and User Actions -->
                        <div class="header-actions d-flex align-items-center">
                            <a href="{{ route('cart') }}" class="btn btn-link text-dark me-3 position-relative d-none d-lg-inline-flex wsus__cart_icon">
                                <i class="fas fa-shopping-bag fs-5"></i>
                                <span class="cart-count badge bg-primary position-absolute top-0 start-100 translate-middle rounded-pill d-none">0</span>
                            </a>
                            @auth
                                <div class="dropdown">
                                    <a href="#" class="btn btn-link text-dark dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fas fa-user fs-5 me-1"></i>
                                        {{ Str::limit(auth()->user()->name, 8) }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li><a class="dropdown-item" href="{{ route('dashboard') }}"><i class="fas fa-tachometer-alt me-2"></i>Dashboard</a></li>
                                        <li><a class="dropdown-item" href="{{ route('profile') }}"><i class="fas fa-user me-2"></i>Profile</a></li>
                                        <li><a class="dropdown-item" href="{{ route('orders') }}"><i class="fas fa-shopping-bag me-2"></i>Orders</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                                @csrf
                                                <button type="submit" class="dropdown-item text-danger"><i class="fas fa-sign-out-alt me-2"></i>Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
<a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
                            @endauth
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
    
    <!-- Messages -->
    <div class="container mt-3">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if(session('messege'))
            <div class="alert alert-{{ session('alert-type') }} alert-dismissible fade show" role="alert">
                {{ session('messege') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('content')
    </main>
    
    <!-- Footer -->
    <footer class="footer text-white mt-5" style="background-color: {{ $footer->footer_color ?? '#343a40' }};">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="footer-widget">
                        <a href="{{ route('home') }}" class="d-inline-block">
                            <img src="{{ asset($setting->logo) }}" alt="{{ $seoSetting->seo_title ?? 'Logo' }}" class="img-fluid" style="max-height: 48px;">
                        </a>
                        
                        <p class="text-muted">{{ $footer->description ?? 'Discover our exquisite collections of jewellery crafted with elegance. Each piece tells a story of timeless beauty.' }}</p>
                        <div class="social-links mt-3">
                            @if($socialLinks->count() > 0)
                                @foreach($socialLinks as $socialLink)
                                    <a href="{{ $socialLink->link }}" target="_blank" class="text-white me-3"><i class="{{ $socialLink->icon }}"></i></a>
                                @endforeach
                            @else
                                <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
                                <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
                                <a href="#" class="text-white"><i class="fab fa-pinterest"></i></a>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h6 class="mb-3">{{ $footer->column_two_title ?? 'Quick Links' }}</h6>
                        <ul class="list-unstyled">
                            @if($footerLinks1->count() > 0)
                                @foreach($footerLinks1 as $link)
                                    <li><a href="{{ $link->link }}" class="text-muted text-decoration-none">{{ $link->title }}</a></li>
                                @endforeach
                            @else
                                {{-- <li><a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a></li>
                                <li><a href="{{ route('products') }}" class="text-muted text-decoration-none">Products</a></li>
                                <li><a href="{{ route('about') }}" class="text-muted text-decoration-none">About Us</a></li>
                                <li><a href="{{ route('contact') }}" class="text-muted text-decoration-none">Contact</a></li> --}}
                               
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h6 class="mb-3">{{ $footer->column_three_title ?? 'Customer Service' }}</h6>
                        <ul class="list-unstyled">
                            @if($footerLinks2->count() > 0)
                                @foreach($footerLinks2 as $link)
                                    <li><a href="{{ $link->link }}" class="text-muted text-decoration-none">{{ $link->title }}</a></li>
                                @endforeach
                            @else
                                <li><a href="{{ route('faq') }}" class="text-muted text-decoration-none">FAQ</a></li>
                                <li><a href="#" class="text-muted text-decoration-none">Shipping Info</a></li>
                                <li><a href="#" class="text-muted text-decoration-none">Returns</a></li>
                                <li><a href="{{ route('terms.conditions') }}" class="text-muted text-decoration-none">Terms & Conditions</a></li>
                                <li><a href="{{ route('privacy.policy') }}" class="text-muted text-decoration-none">Privacy Policy</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4">
                    <div class="footer-widget">
                        <h6 class="mb-3">{{ $footer->column_four_title ?? 'Contact Info' }}</h6>
                        <div class="contact-info">
                            @if($footer && $footer->address)
                                <p class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i> {{ $footer->address }}</p>
                            @else
                                <p class="text-muted mb-2"><i class="fas fa-map-marker-alt me-2"></i> 123 Jewellery Street, Diamond City, DC 12345</p>
                            @endif
                            @if($footer && $footer->phone)
                                <p class="text-muted mb-2"><i class="fas fa-phone me-2"></i> {{ $footer->phone }}</p>
                            @else
                                <p class="text-muted mb-2"><i class="fas fa-phone me-2"></i> +1 (555) 123-4567</p>
                            @endif
                            @if($footer && $footer->email)
                                <p class="text-muted mb-2"><i class="fas fa-envelope me-2"></i> {{ $footer->email }}</p>
                            @else
                                <p class="text-muted mb-2"><i class="fas fa-envelope me-2"></i> info@diamondsjewelry.com</p>
                            @endif
                            @if($footer && $footer->working_hours)
                                <p class="text-muted"><i class="fas fa-clock me-2"></i> {{ $footer->working_hours }}</p>
                            @else
                                <p class="text-muted"><i class="fas fa-clock me-2"></i> Mon - Sat: 9:00 AM - 8:00 PM</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom border-top border-secondary py-3">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <p class="text-muted mb-0">&copy; {{ date('Y') }} {{ $footer->copyright ?? 'Diamonds Jewellery Collection. All rights reserved.' }}</p>
                    </div>
                    <div class="col-md-6 text-end">
                        <div class="payment-methods">
                            <i class="fab fa-cc-visa text-muted me-2"></i>
                            <i class="fab fa-cc-mastercard text-muted me-2"></i>
                            <i class="fab fa-cc-paypal text-muted me-2"></i>
                            <i class="fab fa-cc-stripe text-muted"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="{{ asset('frontend/js/app.js') }}"></script>
    
    <!-- Fix dropdown conflicts -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Mobile dropdown fallback: ensure navbar dropdowns open on tap
        // This helps in case Bootstrap's dropdown is blocked by other scripts/CSS on small screens
        const dropdownToggles = document.querySelectorAll('.navbar-nav .dropdown-toggle');
        dropdownToggles.forEach(function(toggle){
            toggle.addEventListener('click', function(e){
                // Only apply manual toggle on tablet/mobile widths
                if (window.innerWidth <= 992) {
                    e.preventDefault();
                    e.stopPropagation();

                    const parent = this.closest('.dropdown');
                    if (!parent) return;
                    const menu = parent.querySelector('.dropdown-menu');

                    const isShown = parent.classList.contains('show');

                    // Close other open dropdowns in the same nav
                    const siblings = parent.parentElement ? parent.parentElement.querySelectorAll('.dropdown.show') : [];
                    siblings.forEach(function(d){
                        if (d !== parent) {
                            d.classList.remove('show');
                            const dm = d.querySelector('.dropdown-menu');
                            if (dm) dm.classList.remove('show');
                        }
                    });

                    // Toggle current dropdown
                    parent.classList.toggle('show', !isShown);
                    if (menu) menu.classList.toggle('show', !isShown);
                }
            });
        });

        // Close any open sort dropdowns when clicking anywhere
        document.addEventListener('click', function(e) {
            // Close sort dropdown if clicking outside
            const sortMenu = document.getElementById('sortMenu');
            const sortContainer = document.querySelector('.sort-dropdown-container');
            
            if (sortMenu && sortContainer && !sortContainer.contains(e.target)) {
                sortMenu.style.display = 'none';
            }
            
            // Close navbar dropdowns when clicking outside
            const navbarDropdowns = document.querySelectorAll('.navbar-nav .dropdown');
            navbarDropdowns.forEach(function(dropdown) {
                if (!dropdown.contains(e.target)) {
                    dropdown.classList.remove('show');
                    const menu = dropdown.querySelector('.dropdown-menu');
                    if (menu) {
                        menu.classList.remove('show');
                    }
                }
            });
        });
        
        // Prevent sort dropdown from interfering with navbar dropdowns
        const sortContainer = document.querySelector('.sort-dropdown-container');
        if (sortContainer) {
            sortContainer.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });
    </script>
    
    @stack('scripts')
    @php($footer = App\Models\Footer::first())
      @if($footer && $footer->phone)
          @php($waPhone = preg_replace('/[^0-9]/', '', $footer->phone))
          @php($waText = urlencode('I am searching for'))
          <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}" class="whatsapp-chat-btn" target="_blank" rel="noopener" aria-label="Chat on WhatsApp">
              <i class="fab fa-whatsapp"></i>
          </a>
      @endif
</body>
</html>

<!-- Mobile Offcanvas Menu -->
<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="mobileMenuLabel">Menu</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
<div class="offcanvas-body mb-3">
        <!-- Mobile Search Bar -->
        <div class="mobile-search mb-6">
            <form action="{{ route('products') }}" method="GET" class="position-relative">
                <input type="text" name="search" class="form-control pe-5" placeholder="Search" value="{{ request('search') }}" style="border-radius: 25px;">
                <button type="submit" class="btn btn-link position-absolute end-0 top-50 translate-middle-y text-muted">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
                <button class="btn btn-link nav-link p-0" type="button" data-bs-toggle="collapse" data-bs-target="#mobileCategories" aria-expanded="false" aria-controls="mobileCategories">
                    Categories <i class="fas fa-chevron-down ms-1"></i>
                </button>
                <div class="collapse" id="mobileCategories">
                    <ul class="list-unstyled ps-3">
                        @foreach($categories as $category)
                            <li><a class="dropdown-item" href="{{ route('category', $category->slug) }}">{{ $category->name }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('products') ? 'active' : '' }}" href="{{ route('products') }}">Products</a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('our-story') ? 'active' : '' }}" href="{{ route('our-story') }}">Our Story</a>
            </li>
    
        </ul>

        <hr>

        <!-- Optional: Quick links for auth -->
        <div class="mt-3">
            @auth
                <a href="{{ route('dashboard') }}" class="d-block mb-2"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                <a href="{{ route('profile') }}" class="d-block mb-2"><i class="fas fa-user me-2"></i> Profile</a>
                <a href="{{ route('orders') }}" class="d-block mb-2"><i class="fas fa-shopping-bag me-2"></i> Orders</a>
            @else
                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm me-2">Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary btn-sm">Register</a>
            @endauth
        </div>
</div>
</div>
<style>
    .mobile-actions-container .navbar-toggler-icon { display: inline-block; }
    .mobile-actions-container .close-icon { display: inline-block; }
    .mobile-actions-container .close-icon.d-none { display: none !important; }
    /* Ensure mobile offcanvas menu items render clearly */
    #mobileMenu .offcanvas-body { padding-top: 0.75rem; }
    #mobileMenu .offcanvas-body .navbar-nav { margin-top: 1rem; display: flex; flex-direction: column; gap: 0.6rem; }
    #mobileMenu .offcanvas-body .navbar-nav .nav-link { display: block !important; padding: 0.75rem 1rem; }
    /* Mobile offcanvas search bar sticky at top */
    #mobileMenu .mobile-search { position: sticky; top: 0; background: #fff; margin-top: 2.5rem; padding-top: 0.25rem; padding-bottom: 0.5rem; z-index: 2; border-bottom: 1px solid #f1f1f1; }
    /* Add top spacing for auth buttons on mobile */
    #mobileMenu .offcanvas-body .mt-3 .btn { margin-top: 0.75rem; }
    @media (max-width: 576px) { #mobileMenu .offcanvas-body .mt-3 .btn { margin-top: 1rem; } }
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
  const offcanvasEl = document.getElementById('mobileMenu');
  const toggleBtn = document.querySelector('.mobile-menu-btn');
  if (offcanvasEl && toggleBtn) {
    const hamburger = toggleBtn.querySelector('.navbar-toggler-icon');
    const closeIcon = toggleBtn.querySelector('.close-icon');
    offcanvasEl.addEventListener('shown.bs.offcanvas', function () {
      toggleBtn.setAttribute('aria-expanded', 'true');
      if (hamburger) hamburger.classList.add('d-none');
      if (closeIcon) closeIcon.classList.remove('d-none');
    });
    offcanvasEl.addEventListener('hidden.bs.offcanvas', function () {
      toggleBtn.setAttribute('aria-expanded', 'false');
      if (hamburger) hamburger.classList.remove('d-none');
      if (closeIcon) closeIcon.classList.add('d-none');
    });
  }
});
</script>