@extends('front.layouts.master')
@section('content')


    <div class="page-content">

        @if(isset($template) && $template)
        {{-- display template --}}
        @include('front.includes.template_viewer',$template)
        @else
            <div class="custom-container mt-5">
                <div class="alert alert-warning">قالب صفحه اصلی انتخاب نشده است! از طریق پنل مدیریت، بخش قالب ها، قالب صفحه اصلی را طراحی کنید. سپس در بخش تنظیمات ظاهری آن را برای صفحه اصلی انتخاب کنید.</div>
            </div>
        @endif

        @include('front.includes.call_buttons')
    </div>



@endsection
@section('scripts')
    <script src="{{asset('assets/js/home.js')}}"></script>
@endsection
