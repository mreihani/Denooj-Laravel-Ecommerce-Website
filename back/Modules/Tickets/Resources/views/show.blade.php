@extends('front.layouts.user_panel')
@section('panel_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="font-18 fw-bold">تیکت</div>
        <a href="{{route('panel.tickets')}}" class="underline-link">بازگشت <i
                class="icon-arrow-left ms-2"></i></a>
    </div>

    @include('front.alerts')

    <div class="box p-3 p-lg-4">
        @if($ticket->status == 'close')
            <div class="alert alert-warning">این درخواست پشتیبانی بسته شده است، برای بازگشایی آن پاسخی ارسال
                کنید.
            </div>
        @endif

        <div class="row mb-5">
            {{-- ticket info --}}
            <div class="col-lg-4">

                <div class="">
                    @switch($ticket->status)
                        @case('pending')
                            <span class="badge bg-warning py-2 font-14">در انتظار بررسی</span>
                            @break

                        @case('support_response')
                            <span class="badge bg-dark py-2 font-14">پاسخ پشتیبان</span>
                            @break

                        @case('user_response')
                            <span class="badge bg-primary py-2 font-14">پاسخ شما</span>
                            @break

                        @case('close')
                            <span class="badge bg-secondary py-2 font-14">بسته شد</span>
                            @break
                    @endswitch
                    <h1 class="font-15 mt-3 mb-3">
                        {{$ticket->title}}
                        <span class="font-12 ms-3 text-gray">{{'#' . $ticket->code}}</span>
                    </h1>

                    <span class="text-gray d-flex align-items-center font-13 d-block mb-2">
                    <i class="icon-clock me-1"></i>
                    تاریخ ایجاد: {{verta($ticket->created_at)->format('Y/n/j H:i')}}
                </span>

                    <span class="text-gray d-flex align-items-center font-13">
                    <i class="icon-repeat me-1"></i>
                    آخرین بروزرسانی: {{verta($ticket->updated_at)->format('Y/n/j H:i')}}
                </span>
                </div>

            </div>

            <div class="col-lg-8">
                {{-- responses --}}
                @foreach($messages as $message)
                    <div class="ticket-response mt-4 {{$message->fromAdmin() ? 'left':''}}">
                        <div class="ticket-response-avatar">
                            @if ($message->fromAdmin())
                                <img src="{{$message->admin->getAvatar()}}" alt="avatar">
                                <div class="d-flex flex-column">
                                    <span class="title">{{$message->admin->name}}</span>
                                    <span class="text-gray font-12">پاسخ پشتیبان</span>
                                </div>
                            @else
                                <img src="{{$message->user->getAvatar(true)}}" alt="avatar">
                                <div class="d-flex flex-column">
                                    <span class="title">{{$message->user->getFullName()}}</span>
                                    <span class="text-gray font-12">پاسخ شما</span>
                                </div>
                            @endif
                        </div>

                        <div class="ticket-response-body">
                            <div class="body">{{$message->body}}</div>
                            <div class="d-flex align-items-end justify-content-between">
                                <span class="date">{{$message->getCreationDate()}}</span>
                                @if($message->file)
                                    <a href="{{$message->getFile()}}" data-bs-toggle="tooltip" data-bs-placement="top" title="دانلود فایل ارسال شده" target="_blank"><i class="icon-file {{$message->fromAdmin() ? 'text-white':'text-secondary'}}"></i></a>
                                @endif
                            </div>
                        </div>

                    </div>
                @endforeach

                {{-- add response form --}}
                <form action="{{route('panel.tickets.add_response',$ticket)}}" id="responseForm" method="post" class="mt-5" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <textarea aria-label="body" class="form-control mb-4" id="body" name="body"
                                  placeholder="پیام را اینجا بنویسید" rows="4"></textarea>

                        <div class="mb-4 user-image-upload file-upload-container">
                            <label for="body" class="form-label">ارسال فایل (اختیاری)</label>
                            <small class="d-block text-muted mb-2">فرمت های مجاز ارسال فایل: png,jpg,zip</small>
                            <small class="d-block text-muted mb-2">حداکثر حجم مجاز فایل: 10 مگابایت</small>
                            <div class="input-group custom-file-button">
                                <label class="input-group-text" for="file">انتخاب فایل</label>
                                <input type="file" class="form-control" id="file" name="file" accept="image/png,image/jpeg,.zip,.rar" >
                            </div>
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success px-4 form-submit mt-3" id="btnSubmit">
                        <span class="value">ارسال پاسخ</span>
                    </button>
                </form>

            </div>
        </div>


    </div>

@endsection


@section('after_panel_scripts')
    <script>
        $(document).ready(function () {
            $("#responseForm").validate({
                errorClass: "is-invalid",
                errorElement: "span",
                errorPlacement: function (error, element) {
                    error.appendTo(element.parent('.form-group'));
                },
                submitHandler: function(form) {
                    $('#btnSubmit').addClass('loading');
                    form.submit();
                },
                rules: {
                    body: {
                        required: true,
                    },
                },
                messages: {
                    body: {
                        required: "متن را وارد کنید.",
                    },
                }
            });

        });
    </script>

@endsection
