@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('product-sizes.index')}}">سایز ها</a> /</span> جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{route('product-sizes.store')}}" method="post" enctype="multipart/form-data" class="row align-items-end" id="mainForm">
                @csrf
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="label">برچسپ</label>
                    <input id="label" type="text" name="label" class="form-control" value="{{old('label')}}" placeholder="مثلا: لارج یا بزرگ">
                </div>
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="name">نام (لاتین)</label>
                    <input id="name" type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="مثلا: large">
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">افزودن سایز</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
