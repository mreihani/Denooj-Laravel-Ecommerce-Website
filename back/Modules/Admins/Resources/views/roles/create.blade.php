@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('roles.index')}}">نقش ها</a> /</span> ایجاد مجوز جدید
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <form action="{{route('roles.store')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- first name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="name">نام نقش (لاتین)</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                        </div>

                        {{-- last name --}}
                        <div class="mb-3 col-lg-6">
                            <label class="form-label" for="label">برچسپ فارسی</label>
                            <input type="text" class="form-control" id="label" name="label" value="{{old('label')}}">
                        </div>

                        {{-- permissions --}}
                        <h4 class="card-title">انتخاب مجوزها</h4>
                        @php
                            $permissions = \Spatie\Permission\Models\Permission::orderByDesc('name')->get();
                            $half = ceil($permissions->count() / 2);
                            $chunks = $permissions->chunk($half);
                        @endphp
                        <div class="mb-3 col-lg-6">
                            @foreach($chunks[0] as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" aria-label="{{'check-' .$permission->id}}" name="permissions[]" type="checkbox" value="{{$permission->id}}" id="{{'check-' . $permission->id}}"
                                    @if(old("roles")) {{ (in_array(trim($permission->id), old("roles")) ? "checked":"") }}@endif>
                                    <label class="form-check-label" for="{{'check-' . $permission->id}}">{{$permission->label}}</label>
                                </div>
                            @endforeach
                        </div>
                        <div class="mb-3 col-lg-6">
                            @foreach($chunks[1] as $permission)
                                <div class="form-check">
                                    <input class="form-check-input" aria-label="{{'check-' .$permission->id}}" name="permissions[]" type="checkbox" value="{{$permission->id}}" id="{{'check-' . $permission->id}}"
                                    @if(old("roles")) {{ (in_array(trim($permission->id), old("roles")) ? "checked":"") }}@endif>
                                    <label class="form-check-label" for="{{'check-' . $permission->id}}">{{$permission->label}}</label>
                                </div>
                            @endforeach
                        </div>

                        {{-- submit--}}
                        <div class="col-lg-6">
                            <div class="mb-3 mt-4">
                                <button type="submit" class="btn btn-primary submit-button">ذخیره و ایجاد نقش</button>
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
