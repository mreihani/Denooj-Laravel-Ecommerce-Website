@php $signinSettings = \Modules\Settings\Entities\SigninSetting::first(); @endphp
@php $appearanceSettings = \Modules\Settings\Entities\AppearanceSetting::first(); @endphp
@php $advancedSettings = \Modules\Settings\Entities\AdvancedSetting::firstOrCreate(); @endphp

        <!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{'ورود به حساب' . ' | ' . config('app.app_name_fa')}}</title>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- icon --}}
    <link rel="icon" type="image/png" href="{{asset('assets/images/favicon_16.png')}}" sizes="16x16">
    <link rel="icon" href="{{asset('assets/images/favicon_192.png')}}" sizes="192x192">

    {{-- CSS --}}
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.rtl.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/sweetalert2.min.css')}}">
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
            @if($signinSettings->bg_color)
 --colorSigninBg: {{$signinSettings->bg_color}};
        @endif

        {{-- site font --}}
        body {
            font-family: {{$appearanceSettings->site_font}}, sans-serif !important;
        }

        {{-- Custom Css --}}
        {!! $advancedSettings->custom_css !!}
    </style>
</head>
<body class="signin-body">


<!-- ***********************************************************
************************* Begin Main Content *******************
************************************************************ -->
<div class="signin-page">
    <div class="signin-form">
        <a href="{{url('/')}}">
            <img src="{{$signinSettings->getLogo()}}" alt="logo" class="logo">
        </a>
        <div class="signin-form-box">
            @yield('form')
        </div>
    </div>
    <div class="signin-image" style="background-image: url('{{$signinSettings->getImage()}}')">
    </div>
</div>


<script src="{{asset('assets/js/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/js/sweetalert2.min.js')}}"></script>
<script src="{{asset('assets/js/core.js')}}"></script>
<script src="{{asset('assets/js/jquery.validate.js')}}"></script>
@yield('scripts')
</body>
</html>
