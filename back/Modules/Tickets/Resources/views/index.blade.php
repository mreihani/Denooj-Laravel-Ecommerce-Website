@extends('front.layouts.user_panel')
@section('panel_content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="font-18 fw-bold">تیکت‌های پشتیبانی</div>
        <span class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#ticketModal"><i class="icon-plus me-2"></i>ایجاد تیکت جدید</span>
    </div>

    @include('front.alerts')

    @if($tickets->count() > 0)
        <div class="card-box p-3">
            <div class="table-responsive">
                <table class="table align-middle table-bordered">
                    <thead>
                    <tr class="table-secondary">
                        <th class="font-sm-13">کد</th>
                        <th class="font-sm-13">عنوان</th>
                        <th class="font-sm-13">وضعیت</th>
                        <th class="font-sm-13">تاریخ ایجاد</th>
                        <th class="font-sm-13">آخرین به روزرسانی</th>
                        <th class="font-sm-13">گزینه ها</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($tickets as $ticket)
                        <tr>
                            <td>
                                {{$ticket->code}}
                            </td>
                            <td>
                                {{$ticket->title}}
                            </td>
                            <td>
                                @switch($ticket->status)
                                    @case('pending')
                                        <span class="badge bg-warning font-14">در انتظار بررسی</span>
                                        @break

                                    @case('support_response')
                                        <span class="badge bg-dark font-14">پاسخ داده شده</span>
                                        @break

                                    @case('user_response')
                                        <span class="badge bg-primary font-14">پاسخ کاربر</span>
                                        @break

                                    @case('close')
                                        <span class="badge bg-secondary font-14">بسته شد</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                <?php $v = new \Hekmatinasser\Verta\Verta($ticket->created_at);?>
                                <span class="text-nowrap">{{$v->format('Y/n/j')}}</span>
                            </td>
                            <td>
                                <?php $v = new \Hekmatinasser\Verta\Verta($ticket->updated_at);?>
                                <span class="text-nowrap">{{$v->format('Y/n/j')}}</span>
                            </td>
                            <td>
                                <a href="{{route('panel.tickets.show',$ticket)}}" class="btn btn-primary btn-sm">مشاهده</a>
                            </td>
                        </tr>

                    @endforeach
                    </tbody>
                </table>
                {{$tickets->links()}}
            </div>
        </div>
    @else
        <div class="alert alert-primary">تاکنون تیکتی ثبت نشده است.</div>
    @endif

    {{-- Ticket Modal --}}
    <div class="modal fade" id="ticketModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="form-title mb-0">ایجاد درخواست پشتیبانی جدید</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('panel.tickets.store')}}" id="ticketForm" method="post" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <div class="col-12 mb-3">
                                <div class="form-group">
                                    <label for="title" class="form-label">عنوان تیکت</label>
                                    <input type="text" aria-label="title" class="form-control" id="title" name="title" autofocus>
                                </div>
                            </div>

                            <div class="col-12 mb-4">
                                <div class="form-group">
                                    <label for="body" class="form-label">متن تیکت</label>
                                    <textarea aria-label="body" class="form-control" id="body" name="body"
                                          placeholder="متن تیکت خود را اینجا بنویسید" autofocus rows="5"></textarea>
                                </div>
                            </div>

                            <div class="mb-4 user-image-upload file-upload-container">
                                <label for="body" class="form-label">ارسال فایل (اختیاری)</label>
                                <small class="d-block text-muted mb-2">فرمت های مجاز ارسال فایل: png,jpg,zip</small>
                                <small class="d-block text-muted mb-2">حداکثر حجم مجاز فایل: 10 مگابایت</small>
                                <div class="input-group custom-file-button">
                                    <label class="input-group-text" for="file">انتخاب فایل</label>
                                    <input type="file" class="form-control" id="file" name="file" accept="image/png,image/jpeg,.zip,.rar" >
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary px-5 form-submit" id="btnSubmit">
                                        <i class="icon-send me-2"></i>
                                        <span class="value">ارسال</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection


@section('after_panel_scripts')
    <script src="{{asset('assets/js/jquery.validate.js')}}"></script>

    <script>
        $(document).ready(function () {
            $("#ticketForm").validate({
                errorClass: "is-invalid",
                errorElement: "span",
                errorPlacement: function(error, element) {
                    error.appendTo( element.parent('.form-group') );
                },
                submitHandler: function(form) {
                    $('#btnSubmit').addClass('loading');
                    form.submit();
                },
                rules: {
                    title: {
                        required: true,
                    },
                    body: {
                        required: true,
                    },
                },
                messages: {
                    title: {
                        required: "عنوان درخواست را وارد کنید.",
                    },
                    body: {
                        required: "متن درخواست خود را وارد کنید.",
                    },
                }
            });

        });
    </script>

@endsection
