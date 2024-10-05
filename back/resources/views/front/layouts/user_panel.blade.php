@extends('front.layouts.master')
@section('content')
    <div class="container-fluid page-content mt-4">
        <div class="custom-container">
            <div class="backdrop sidebar-backdrop"></div>

            <div class="user-panel-wrapper">
                @include('users::user_panel.sidebar')

                <div class="user-panel-content">
                    @yield('panel_content')
                </div>
            </div>

        </div>
    </div>
@endsection
@section('styles')
    @yield('panel_styles')
@endsection
@section('scripts')
    @yield('before_panel_scripts')
    <script src="{{asset('assets/js/jquery.validate.js')}}"></script>
    <script src="{{asset('assets/js/panel.js')}}"></script>
    @yield('after_panel_scripts')
@endsection
