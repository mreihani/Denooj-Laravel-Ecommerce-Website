@php $footerSettings = \Modules\Settings\Entities\FooterSetting::firstOrCreate(); @endphp
@php $headerSettings = \Modules\Settings\Entities\HeaderSetting::firstOrCreate(); @endphp
@php $generalSettings = \Modules\Settings\Entities\GeneralSetting::firstOrCreate(); @endphp
@php $appearanceSettings = \Modules\Settings\Entities\AppearanceSetting::firstOrCreate(); @endphp
@php $advancedSettings = \Modules\Settings\Entities\AdvancedSetting::firstOrCreate(); @endphp
@php $seoSettings = \Modules\Settings\Entities\SeoSetting::firstOrCreate(); @endphp
@php
    if (!isset($navTitle)){
        $navTitle = $generalSettings->home_nav_title;
    }
@endphp
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    {!! SEOMeta::generate() !!}
    {!! OpenGraph::generate() !!}
    {!! Twitter::generate() !!}
    @if(isset($schema))
        {!! $schema!!}
    @endif

    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{$appearanceSettings->getFavicon()}}">

    <meta name="robots" content="{{$seoSettings->site_index}}, max-snippet:-1, max-video-preview:-1, max-image-preview:large"/>


    {{-- CSS --}}
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.rtl.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/swiper-bundle.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/fancybox.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/main.css')}}">
    <style>
        :root {
            @if($appearanceSettings->main_color)
               --colorMain: {{$appearanceSettings->main_color}};
            --colorMainRGB: {{$appearanceSettings->main_color_rgb}};
            @endif
            @if($appearanceSettings->secondary_color)
  --colorSecondary: {{$appearanceSettings->secondary_color}};
            --colorSecondaryRGB: {{$appearanceSettings->secondary_color_rgb}};
            @endif
            @if($appearanceSettings->main_color)
  --colorLink: {{$appearanceSettings->link_color}};
            --colorLinkRGB: {{$appearanceSettings->link_color_rgb}};
            @endif
            @if($appearanceSettings->call_button_color)
  --colorCallBtn: {{$appearanceSettings->call_button_color}};
            @endif
            @if($appearanceSettings->whatsapp_button_color)
  --colorWhatsappBtn: {{$appearanceSettings->whatsapp_button_color}};
            @endif


            @if($appearanceSettings->featured_products_bg_color)
  --colorFeaturedProductsBg: {{$appearanceSettings->featured_products_bg_color}};
            @endif
            @if($appearanceSettings->featured_products_title_color)
  --colorFeaturedProductsTitle: {{$appearanceSettings->featured_products_title_color}};
            @endif
            @if($appearanceSettings->featured_products_title_icon_color)
  --colorFeaturedProductsTitleIcon: {{$appearanceSettings->featured_products_title_icon_color}};
            @endif
            @if($appearanceSettings->featured_products_title_icon_bg_color)
  --colorFeaturedProductsTitleIconBg: {{$appearanceSettings->featured_products_title_icon_bg_color}};
            @endif
            @if($appearanceSettings->featured_products_btn_color)
  --colorFeaturedProductsBtn: {{$appearanceSettings->featured_products_btn_color}};
            @endif
            @if($appearanceSettings->featured_products_arrows_color)
  --colorFeaturedProductsArrows: {{$appearanceSettings->featured_products_arrows_color}};
            @endif
            @if($appearanceSettings->featured_products_arrows_icon_color)
  --colorFeaturedProductsArrowsIcon: {{$appearanceSettings->featured_products_arrows_icon_color}};
            @endif

            @if($appearanceSettings->home_blog_bg_color)
  --colorBlogSectionBg: {{$appearanceSettings->home_blog_bg_color}};
            @endif
            @if($appearanceSettings->home_blog_title_color)
  --colorBlogSectionTitle: {{$appearanceSettings->home_blog_title_color}};
            @endif
            @if($appearanceSettings->home_blog_btn_color)
  --colorBlogSectionLink: {{$appearanceSettings->home_blog_btn_color}};
        @endif
        }

        {{-- site font --}}
        body {
            font-family: {{$appearanceSettings->site_font}}, sans-serif !important;
        }

        {{-- Custom Css --}}
        {!! $advancedSettings->custom_css !!}
    </style>

    <meta name="theme-color" content="{{$appearanceSettings->main_color}}" />


    @yield('styles')
    {{-- Custom Js --}}
    {!! $advancedSettings->custom_header_js !!}
</head>
<body class="{{isset($singleProduct) ? 'single-product-page' : ''}} {{auth()->guard('admin')->check() ? 'admin-logged' : ''}}">
<h1 class="d-none">{{$h1Title ?? $generalSettings->home_h1_hidden}}</h1>
<?php $currentRouteName = \Illuminate\Support\Facades\Route::currentRouteName();?>

@if(!isset($hideHeader))
    @include('front.includes.header')
@endif

<main>
    @yield('content')
</main>

@if(!isset($hideFooter))
    @include('front.includes.footer')
@endif

{{-- mini cart --}}
@include('front.includes.mini_cart')

{{-- admin navigation bar --}}
@include('front.includes.admin_navigation_bar')

<div class="screen-loader"></div>
<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/jquery.pjax.js')}}"></script>
<script src="{{asset('assets/js/swiper-bundle.min.js')}}"></script>
<script src="{{asset('assets/js/fancybox.umd.js')}}"></script>
<script src="{{asset('assets/js/core.js')}}"></script>
<script src="{{asset('assets/js/search.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.js')}}"></script>
@yield('scripts')
{{-- Custom Js --}}
{!! $advancedSettings->custom_js !!}
</body>
</html>
