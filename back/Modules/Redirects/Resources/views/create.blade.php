@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('redirects.index')}}">ریدایرکت ها</a> /</span> جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{route('redirects.store')}}" method="post" enctype="multipart/form-data" class="row align-items-end" id="mainForm">
                @csrf
                <div class="col-lg-6 mb-4">
                    <label class="form-label" for="old_url">آدرس قدیمی</label>
                    <input id="old_url" dir="ltr" type="text" name="old_url" class="form-control" value="{{old('old_url')}}">
                </div>
                <div class="col-lg-6 mb-4">
                    <label class="form-label" for="new_url">آدرس جدید</label>
                    <input id="new_url" dir="ltr" type="text" name="new_url" class="form-control" value="{{old('new_url')}}">
                </div>

                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="type">نوع ریدایرکت</label>
                    <select name="type" id="type" class="form-select">
                        <option value="301" selected>301 - انتقال دائمی</option>
                        <option value="302">302 - انتقال موقت</option>
                        <option value="307">307 - ریدایرکت موقت</option>
                    </select>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">ایجاد ریدایرکت</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
