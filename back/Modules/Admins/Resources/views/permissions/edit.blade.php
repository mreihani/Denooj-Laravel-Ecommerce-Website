@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('permissions.index')}}">مجوزها</a> /</span> ویرایش
        </h4>
        <a href="{{route('permissions.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">ایجاد مجوز جدید</span></span></a>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('permissions.update',$permission)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        @method('PATCH')
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- first name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="name">نام مجوز (لاتین)</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name',$permission->name)}}">
                        </div>

                        {{-- last name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="label">برچسپ فارسی</label>
                            <input type="text" class="form-control" id="label" name="label" value="{{old('label',$permission->label)}}">
                        </div>

                        {{-- module --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="module">ماژول (لاتین)</label>
                            <input type="text" class="form-control" id="module" name="module" value="{{old('module',$permission->module)}}">
                        </div>

                        {{-- submit--}}
                        <div class="col-lg-6">
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary submit-button">ذخیره اطلاعات</button>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </form>


@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
