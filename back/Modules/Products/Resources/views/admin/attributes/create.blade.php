@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('attributes.index')}}">ویژگی ها</a> /</span> جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{route('attributes.store')}}" method="post" enctype="multipart/form-data" class="row align-items-end" id="mainForm">
                @csrf
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="label">برچسپ</label>
                    <input id="label" type="text" name="label" class="form-control" value="{{old('label')}}">
                </div>

                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="frontend_type">نوع فیلد</label>
                    <select name="frontend_type" id="frontend_type" class="form-select">
                        <option value="text">متن (text)</option>
                        <option value="textarea">متن چند خطی (textarea)</option>
                        <option value="number">عدد (number)</option>
                    </select>
                </div>

                <div class="col-lg-3 ps-lg-5 mb-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="filterable" name="filterable" {{old('filterable') == 'on' ? 'checked' :''}}>
                        <label class="form-check-label" for="filterable">فیلترشدنی</label>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="required" name="required" {{old('required') == 'on' ? 'checked' :''}}>
                        <label class="form-check-label" for="required">ضروری</label>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">افزودن ویژگی</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
