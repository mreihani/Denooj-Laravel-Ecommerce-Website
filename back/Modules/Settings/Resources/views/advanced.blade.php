@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> پیشرفته
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card mb-4">
                <h5 class="card-header">تنظیمات پیشرفته</h5>
                <form action="{{route('settings.advanced_update',$settings)}}" method="post" enctype="multipart/form-data" id="mainForm">
                    @csrf
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="custom_css" class="form-label">css سفارشی</label>
                            <textarea class="form-control" dir="ltr" id="custom_css" rows="6" placeholder=".class { color: red; }" name="custom_css">{{old('custom_css',$settings->custom_css)}}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="custom_header_js" class="form-label">js سفارشی هدر</label>
                            <small class="d-block mt-1 mb-2 text-muted">قطعه کدهایی که در فیلد زیر وارد شود به هدر سایت قبل از بسته شدن تگ head اضافه خواهد شد.</small>
                            <textarea class="form-control" dir="ltr" id="custom_header_js" rows="6" placeholder="<script> your js here </script>" name="custom_header_js">{{old('custom_header_js',$settings->custom_header_js)}}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="custom_js" class="form-label">js سفارشی فوتر</label>
                            <small class="d-block mt-1 mb-2 text-muted">قطعه کدهایی که در فیلد زیر وارد شود به فوتر سایت قبل از بسته شدن تگ body اضافه خواهد شد.</small>
                            <textarea class="form-control" dir="ltr" id="custom_js" rows="6" placeholder="<script> your js here </script>" name="custom_js">{{old('custom_js',$settings->custom_js)}}</textarea>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                            <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
