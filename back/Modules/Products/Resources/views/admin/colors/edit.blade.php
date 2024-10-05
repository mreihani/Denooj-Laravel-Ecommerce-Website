@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('product-colors.index')}}">رنگ ها</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('product-colors.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رنگ جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card">
        <div class="card-body">
            <form action="{{route('product-colors.update',$productColor)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
                @csrf
                @method('PATCH')

                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="label">برچسپ</label>
                    <input id="label" type="text" name="label" class="form-control" value="{{old('label',$productColor->label)}}" placeholder="مثلا: مشکی">
                </div>
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="name">نام (لاتین)</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{old('name',$productColor->name)}}" placeholder="مثلا: black">
                </div>

                <div class="mb-4 col-lg-3">
                    <label class="form-label" for="main_color">رنگ</label>
                    <input id="hex_code" type="hidden" name="hex_code" class="form-control" value="{{old('hex_code',$productColor->hex_code)}}">
                    <div class="color-picker-monolith" data-default-color="{{$productColor->hex_code}}" data-input-id="#hex_code"></div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
