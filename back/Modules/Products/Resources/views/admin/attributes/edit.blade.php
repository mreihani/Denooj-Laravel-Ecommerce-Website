@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('attributes.index')}}">ویژگی ها</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('attributes.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن ویژگی جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card">
        <div class="card-body">
            <form action="{{route('attributes.update',$attribute)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
                @csrf
                @method('PATCH')

                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="label">برچسپ</label>
                    <input id="label" type="text" name="label" class="form-control" value="{{old('label',$attribute->label)}}">
                </div>

                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="frontend_type">نوع فیلد</label>
                    <select name="frontend_type" id="frontend_type" class="form-select">
                        <option value="text" {{$attribute->frontend_type == 'text' ? 'selected' : ''}}>متن (text)</option>
                        <option value="textarea" {{$attribute->frontend_type == 'textarea' ? 'selected' : ''}}>متن چند خطی (textarea)</option>
                        <option value="number" {{$attribute->frontend_type == 'number' ? 'selected' : ''}}>عدد (number)</option>
                    </select>
                </div>

                <div class="col-lg-3 ps-lg-5 mb-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="filterable" name="filterable" {{$attribute->filterable ? 'checked' :''}}>
                        <label class="form-check-label" for="filterable">فیلترشدنی</label>
                    </div>
                </div>

                <div class="col-lg-3 mb-3">
                    <div class="form-check form-switch mb-2">
                        <input class="form-check-input" type="checkbox" id="required" name="required" {{$attribute->required ? 'checked' :''}}>
                        <label class="form-check-label" for="required">ضروری</label>
                    </div>
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
