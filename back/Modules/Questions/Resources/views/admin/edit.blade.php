@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('questions.index')}}">پرسش ها</a> /</span> ویرایش
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card">
        <div class="card-body">
            <form action="{{route('questions.update',$question)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
                @csrf
                @method('PATCH')
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md me-2">
                                <img src="{{$question->getSenderAvatar()}}" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0">{{$question->getSenderName()}}</h6>
                                @if($question->user_id != null)
                                    <span style="font-size: 12px;">{{$question->user->mobile}}</span>
                                @else
                                    <span style="font-size: 12px;">{{$question->admin->email}}</span>
                                @endif
                            </div>

                        </div>
                        @if($question->user_id != null)
                        <a href="{{route('users.edit',$question->user)}}" class="btn btn-sm btn-label-primary ms-3"><i class="bx bx-edit"></i> ویرایش کاربر</a>
                        @endif
                    </div>
                </div>
                <div class="mb-3 col-12">
                    <label for="text" class="form-label">پرسش</label>
                    <textarea name="text" class="form-control" id="text" rows="3">{{old('text',$question->text)}}</textarea>
                </div>
                <div class="mb-3 col-lg-4">
                    <label class="form-label" for="status">وضعیت</label>
                    <select class="form-select" name="status" id="status">
                        <option value="pending" {{$question->status == 'pending' ? 'selected' : ''}}>در انتظار تایید</option>
                        <option value="published" {{$question->status == 'published' ? 'selected' : ''}}>منتشر شده</option>
                    </select>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary submit-button">ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
