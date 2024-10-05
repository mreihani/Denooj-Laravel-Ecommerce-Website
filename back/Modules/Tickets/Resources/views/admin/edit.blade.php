@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light"><a href="{{route('tickets.index')}}">تیکت ها</a> /</span> ویرایش
        </h4>
        <div>
        </div>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="row">
        <div class="col-lg-4">
            {{-- ticket details --}}
            <div class="card mb-4">
                <div class="card-body">

                    @switch($ticket->status)
                        @case('pending')
                            <span class="badge bg-label-danger py-2 font-14">در انتظار بررسی</span>
                            @break

                        @case('support_response')
                            <span class="badge bg-dark py-2 font-14">پاسخ پشتیبان</span>
                            @break

                        @case('user_response')
                            <span class="badge bg-label-warning py-2 font-14">پاسخ کاربر</span>
                            @break

                        @case('close')
                            <span class="badge bg-secondary py-2 font-14">بسته شد</span>
                            @break
                    @endswitch

                    <h1 class="font-16 mt-3 mb-3 fw-bold">
                        {{$ticket->title}}
                        <span class="font-12 ms-3 fw-normal text-muted">{{'#' . $ticket->code}}</span>
                    </h1>

                    <span class="text-muted d-flex align-items-center font-13 d-block mb-2">
                    <i class="bx bx-time me-1"></i>
                    تاریخ ایجاد: {{verta($ticket->created_at)->format('Y/n/j H:i')}}
                </span>

                    <span class="text-muted d-flex align-items-center font-13">
                    <i class="bx bx-reply me-1"></i>
                    آخرین بروزرسانی: {{verta($ticket->updated_at)->format('Y/n/j H:i')}}
                </span>
                </div>
            </div>

            {{-- user --}}
            @include('users::admin.show.sidebar',['user' => $ticket->user, 'simpleView' => true,'hideWallet' => true])

        </div>

        {{-- responses --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    {{-- responses --}}
                    @foreach($ticket->responses as $message)
                        <div class="ticket-response mt-4 {{$message->fromAdmin() ? 'left':''}}">
                            <div class="ticket-response-avatar">
                                @if ($message->fromAdmin())
                                    <img src="{{$message->admin->getAvatar()}}" alt="avatar">
                                    <div class="d-flex flex-column">
                                        <span class="title">{{$message->admin->name}}</span>
                                    </div>
                                @else
                                    <img src="{{$message->user->getAvatar(true)}}" alt="avatar">
                                    <div class="d-flex flex-column">
                                        <span class="title">{{$message->user->getFullName()}}</span>
                                    </div>
                                @endif
                            </div>

                            <div class="ticket-response-body">
                                <div class="body">{{$message->body}}</div>
                                <div class="d-flex align-items-end justify-content-between">
                                    <span class="date">{{$message->getCreationDate()}}</span>
                                    @if($message->file)
                                        <a href="{{$message->getFile()}}" data-bs-toggle="tooltip" data-bs-placement="top" title="دانلود فایل ارسال شده" target="_blank"><i class="bx bxs-file {{$message->fromAdmin() ? 'text-white':'text-secondary'}}"></i></a>
                                    @endif
                                </div>
                            </div>

                        </div>
                    @endforeach

                    {{-- add response form --}}
                    <form action="{{route('tickets.add_response',$ticket)}}" method="post" class="mt-5"  enctype="multipart/form-data">
                        @csrf
                        <h5>ارسال پاسخ</h5>
                        <div class="input-group mb-4">
                                <textarea aria-label="body" placeholder="متن را وارد کنید"
                                          class="form-control" name="body">{{old('body')}}</textarea>
                        </div>

                        <div class="mb-4 user-image-upload file-upload-container mb-4">
                            <label for="body" class="form-label">ارسال فایل (اختیاری)</label>
                            <small class="d-block text-muted mb-2">فرمت های مجاز ارسال فایل: png,jpg,zip</small>
                            <small class="d-block text-muted mb-2">حداکثر حجم مجاز فایل: 10 مگابایت</small>
                            <div class="input-group">
                                <input type="file" class="form-control" id="file" name="file" accept="image/png,image/jpeg,.zip,.rar" >
                            </div>
                        </div>


                        <div class="row align-items-end">
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">ارسال پاسخ</button>
                                </div>
                            </div>
                            <div class="col-lg-6 mb-4">
                                <div class="form-group">
                                    <label for="status" class="form-label">تغییر وضعیت</label>
                                    <select class="form-select" name="status" id="status">
                                        <option value="" selected>پیشفرض</option>
                                        <option value="close">بستن تیکت</option>
                                    </select>
                                </div>
                            </div>
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
