@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('comments.index')}}">دیدگاه‌ها</a> /</span> ویرایش
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card">
        <div class="card-body">
            <form action="{{route('comments.update',$comment)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
                @csrf
                @method('PATCH')
                <div class="col-12 mb-3">
                    <div class="d-flex align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md me-2">
                                <img src="{{$comment->getSenderAvatar()}}" alt="Avatar" class="rounded-circle">
                            </div>
                            <div class="d-flex flex-column">
                                <h6 class="m-0">{{$comment->getSenderName()}}</h6>
                                @if($comment->user_id != null)
                                    <span style="font-size: 12px;">{{$comment->user->mobile}}</span>
                                @else
                                    <span style="font-size: 12px;">{{$comment->admin->email}}</span>
                                @endif
                            </div>

                        </div>
                        <a href="{{route('users.edit',$comment->user)}}" class="btn btn-sm btn-label-primary ms-3"><i class="bx bx-edit"></i> ویرایش کاربر</a>
                    </div>
                </div>
                <div class="mb-3 col-12">
                    <label for="comment" class="form-label">متن دیدگاه</label>
                    <textarea name="comment" class="form-control" id="comment" rows="3">{{old('comment',$comment->comment)}}</textarea>
                </div>

                @if($comment->product)
                <div class="mb-3">
                    <label for="strengths" class="form-label">نکات مثبت</label>
                    <input id="strengths" class="form-control tagify-strengths" name="strengths" value="{{old('strengths',$comment->strengths != null ? implode(',',$comment->strengths) : '')}}">
                    <small class="d-block text-muted mt-1">متن را بنویسید و سپس اینتر بزنید</small>
                </div>

                <div class="mb-5">
                    <label for="weaknesses" class="form-label">نکات منفی</label>
                    <input id="weaknesses" class="form-control tagify-weaknesses" name="weaknesses" value="{{old('weaknesses',$comment->weaknesses != null ? implode(',',$comment->weaknesses) : '')}}">
                    <small class="d-block text-muted mt-1">متن را بنویسید و سپس اینتر بزنید</small>
                </div>
                @endif

                <div class="mb-3">
                    <label class="switch switch-square mb-4">
                        <input type="checkbox" class="switch-input" name="anonymous" {{$comment->anonymous ? 'checked' : ''}}>
                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                        <span class="switch-label">ارسال به صورت ناشناس</span>
                    </label>
                </div>

                @if($comment->product)
                <div class="mb-3 col-lg-4">
                    <label class="form-label" for="score">امتیاز</label>
                    <select class="form-select" name="score" id="score">
                        <option value="1" {{$comment->score == '1' ? 'selected' : ''}}>خیلی بد</option>
                        <option value="2" {{$comment->score == '2' ? 'selected' : ''}}>بد</option>
                        <option value="3" {{$comment->score == '3' ? 'selected' : ''}}>معمولی</option>
                        <option value="4" {{$comment->score == '4' ? 'selected' : ''}}>خوب</option>
                        <option value="5" {{$comment->score == '5' ? 'selected' : ''}}>عالی</option>
                    </select>
                </div>
                @endif

                <div class="mb-3 col-lg-4">
                    <label class="form-label" for="status">وضعیت</label>
                    <select class="form-select" name="status" id="status">
                        <option value="pending" {{$comment->status == 'pending' ? 'selected' : ''}}>در انتظار تایید</option>
                        <option value="published" {{$comment->status == 'published' ? 'selected' : ''}}>منتشر شده</option>
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
