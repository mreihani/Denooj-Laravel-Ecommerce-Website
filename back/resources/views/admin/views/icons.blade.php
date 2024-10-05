@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">راهنمای تغییر آیکن‌های فرانت</span></h4>

    <p>
        جهت استفاده از آیکن ها کافی است نام آیکن را در فیلد مورد نظر در بخش تنظیمات کپی کنید.
        <br>
        برای مثال: <b>icon-coffee</b>
    </p>

    <!-- Icon container -->
    <div class="d-flex flex-wrap">
        <div class="card icon-card text-center mb-4 mx-2">
            <div class="card-body">
                <i class="icon-coffee mb-2 font-28"></i>
                <p class="mb-0">icon-coffee</p>
            </div>
        </div>
        <div class="card icon-card text-center mb-4 mx-2">
            <div class="card-body">
                <i class="icon-phone mb-2 font-28"></i>
                <p class="mb-0">icon-phone</p>
            </div>
        </div>
        <div class="card icon-card text-center mb-4 mx-2">
            <div class="card-body">
                <i class="icon-file mb-2 font-28"></i>
                <p class="mb-0">icon-file</p>
            </div>
        </div>
        <div class="card icon-card text-center mb-4 mx-2">
            <div class="card-body">
                <i class="icon-book mb-2 font-28"></i>
                <p class="mb-0">icon-book</p>
            </div>
        </div>
        <div class="card icon-card text-center mb-4 mx-2">
            <div class="card-body">
                <i class="icon-heart mb-2 font-28"></i>
                <p class="mb-0">icon-heart</p>
            </div>
        </div>
        <div class="card icon-card text-center mb-4 mx-2">
            <div class="card-body">
                <i class="icon-download-cloud mb-2 font-28"></i>
                <p class="mb-0">icon-download-cloud</p>
            </div>
        </div>
        <div class="card icon-card text-center mb-4 mx-2">
            <div class="card-body">
                <i class="icon-map mb-2 font-28"></i>
                <p class="mb-0">icon-map</p>
            </div>
        </div>
        <div class="card icon-card text-center mb-4 mx-2">
            <div class="card-body">
                <i class="icon-list mb-2 font-28"></i>
                <p class="mb-0">icon-list</p>
            </div>
        </div>
    </div>

    <p>
        لیست کامل آیکن ها را از طریق فایل css مربوطه میتوانید پیدا کنید. برای مثال:
        <br>
        <code>
            .icon-calendar:before {
            content: "\e92b";
            }
        </code>
        <br>
        در مثال بالا نام آیکن برابر با icon-calendar میباشد.
    </p>

    <!-- Buttons -->
    <div class="d-flex justify-content-center mx-auto gap-3">
        <a href="{{asset('assets/css/icons.css')}}" target="_blank" class="btn btn-primary">مشاهده لیست همه آیکن ها</a>
    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('assets/css/icons.css')}}">
@endsection

