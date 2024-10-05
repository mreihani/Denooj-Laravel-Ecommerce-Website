@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('product-colors.index')}}">رنگ ها</a> /</span> جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{route('product-colors.store')}}" method="post" enctype="multipart/form-data" class="row align-items-end" id="mainForm">
                @csrf
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="label">برچسپ</label>
                    <input id="label" type="text" name="label" class="form-control" value="{{old('label')}}" placeholder="مثلا: مشکی">
                </div>
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="name">نام (لاتین)</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="مثلا: black">
                </div>

                <div class="mb-4 col-lg-3">
                    <label class="form-label" for="main_color">رنگ</label>
                    <input id="hex_code" type="hidden" name="hex_code" class="form-control" value="{{old('hex_code')}}">
                    <div class="color-picker-monolith" data-default-color="#000" data-input-id="#hex_code"></div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">افزودن رنگ</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
