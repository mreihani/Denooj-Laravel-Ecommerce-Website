@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">فایل ها /</span> مورد جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="row">
        <div class="col-lg-5">
            <div class="card mb-4">
                <div class="card-body">
                    <form action="{{route('files.store')}}" method="post" enctype="multipart/form-data" id="mainForm">
                        @csrf
                        <p>یک یا چند فایل را جهت آپلود انتخاب کنید.</p>
                        <div class="mb-3">
                            <label class="form-label" for="file">انتخاب فایل ها</label>
                            <input type="file" class="form-control" id="file" name="file[]" multiple>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary submit-button">آپلود</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
