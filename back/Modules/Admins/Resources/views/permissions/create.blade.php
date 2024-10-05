@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('permissions.index')}}">مجوزها</a> /</span> ایجاد مجوز جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('permissions.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- first name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="name">نام مجوز (لاتین)</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                        </div>

                        {{-- last name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="label">برچسپ فارسی</label>
                            <input type="text" class="form-control" id="label" name="label" value="{{old('label')}}">
                        </div>

                        {{-- submit--}}
                        <div class="col-lg-6">
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary submit-button">ایجاد مجوز</button>
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
