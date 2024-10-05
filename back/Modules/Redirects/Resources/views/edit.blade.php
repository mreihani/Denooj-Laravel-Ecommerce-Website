@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('redirects.index')}}">ریدایرکت ها</a> /</span> ویرایش
        </h4>
        <div>
            <a href="{{route('redirects.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن ریدایرکت جدید</span></span></a>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card">
        <div class="card-body">
            <form action="{{route('redirects.update',$redirect)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
                @csrf
                @method('PATCH')

                <div class="col-lg-6 mb-4">
                    <label class="form-label" for="old_url">آدرس قدیمی</label>
                    <input id="old_url" dir="ltr" type="text" name="old_url" class="form-control" value="{{old('old_url',$redirect->old_url)}}">
                </div>
                <div class="col-lg-6 mb-4">
                    <label class="form-label" for="new_url">آدرس جدید</label>
                    <input id="new_url" dir="ltr" type="text" name="new_url" class="form-control" value="{{old('new_url',$redirect->new_url)}}">
                </div>

                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="type">نوع ریدایرکت</label>
                    <select name="type" id="type" class="form-select">
                        <option value="301" {{$redirect->type == '301' ? 'selected' : ''}}>301 - انتقال دائمی</option>
                        <option value="302" {{$redirect->type == '302' ? 'selected' : ''}}>302 - انتقال موقت</option>
                        <option value="307" {{$redirect->type == '307' ? 'selected' : ''}}>307 - ریدایرکت موقت</option>
                    </select>
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
