@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('templates.index')}}">قالب ها</a> /</span> جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{route('templates.store')}}" method="post" enctype="multipart/form-data" class="row align-items-end" id="mainForm">
                @csrf
                <div class="col-lg-6 mb-4">
                    <label class="form-label" for="title">عنوان</label>
                    <input id="title" type="text" name="title" class="form-control" value="{{old('title')}}">
                </div>

                <div class="col-lg-6 mb-4">
                    <label class="form-label" for="type">نوع قالب</label>
                    <select name="type" id="type" class="form-select">
                        <option value="page" selected>صفحه</option>
{{--                        <option value="header">سربرگ</option>--}}
{{--                        <option value="footer">پابرگ</option>--}}
                    </select>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">ایجاد قالب</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
