@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">پرسش ها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('questions.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..."
                               name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('questions.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
        </div>


        <div class="table-responsive-sm">
            @if($questions->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>نوع</th>
                        <th>نویسنده</th>
                        <th>پرسش و پاسخ</th>
                        <th>محصول</th>
                        <th>تاریخ ارسال</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($questions as $question)
                        <tr class="{{$question->status == 'pending' ? 'table-danger' : ''}}">
                            <td><span
                                    style="font-size: 13px;">{{$question->parent_id == null ? 'پرسش' : 'پاسخ دادن'}}</span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{$question->getSenderAvatar()}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div class="d-flex flex-column ms-2 w-100 flex-shrink-0">
                                        <b>{{$question->getSenderName()}}</b>
                                        @if($question->user_id != null)
                                            <span style="font-size: 12px;">{{$question->user->mobile}}</span>
                                        @else
                                            <span style="font-size: 12px;">{{$question->admin->email}}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td style="max-width: 500px;font-size: 13px">
                                @if($question->parent_id != null)
                                    <p class="mb-3">در پاسخ به <strong>{{$question->getResponseToName()}}</strong></p>
                                @endif
                                <div>{{$question->text}}</div>
                                <div>
                                    @if($question->getLevel() < 5)
                                    <button class="btn btn-sm btn-label-primary mt-2 btn-question-response"
                                            data-response-id="{{$question->id}}"
                                            data-product-id="{{$question->product->id}}">پاسخ دادن
                                    </button>
                                    @endif
                                    <button
                                        class="btn btn-sm btn-label-success mt-2 btn-question-approved {{$question->status == 'published' ? 'd-none' :''}}"
                                        data-question-id="{{$question->id}}">تایید کردن
                                    </button>
                                    <button
                                        class="btn btn-sm btn-label-warning mt-2 btn-question-unapproved {{$question->status == 'published' ? '' :'d-none'}}"
                                        data-question-id="{{$question->id}}">لغو تایید کردن
                                    </button>

                                        <a href="{{route('questions.edit',$question)}}" class="btn btn-sm btn-primary mt-2"><i class="bx bx-edit"></i></a>

                                    <button
                                        class="btn btn-sm btn-danger mt-2 btn-question-delete"
                                        data-question-id="{{$question->id}}"><i class="bx bx-trash"></i>
                                    </button>

                                </div>
                            </td>
                            <td style="max-width: 250px;">
                                <a href="{{route('products.edit',$question->product)}}"
                                   style="font-weight: bold;font-size: 14px">{{$question->product->title}}</a>
                                <div class="blockquote-footer mt-2">
                                    <a href="{{route('product.show',$question->product)}}">نمایش محصول</a>
                                </div>

                                <span class="badge bg-label-dark mt-2">
                                    <span>{{$question->getAllResponses()->count()}}</span><i class="bx bxs-message ms-1"
                                                                                             style="font-size: 12px"></i>
                                </span>

                            </td>
                            <td>
                                {{verta($question->created_at)->format('%d %B، %Y ساعت H:i')}}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$questions->links()}}

        </div>

    </div>


    <!-- Response Modal -->
    <div class="modal fade" id="responseModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title secondary-font" id="modalCenterTitle">پاسخ به پرسش</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('questions.add_response')}}" method="post" id="mainForm">
                        @csrf
                        <input type="hidden" id="product_id" name="product_id">
                        <input type="hidden" id="response_to" name="parent_id">
                        <div class="col mb-3">
                            <label for="text" class="form-label">متن پاسخ</label>
                            <textarea id="text" name="text" rows="3" class="form-control"
                                      placeholder="متن پاسخ را وارد کنید..." required></textarea>
                        </div>
                        <div class="mt-3">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                انصراف
                            </button>
                            <button type="submit" class="btn btn-primary submit-button">ارسال پاسخ</button>
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
    <script>
        // question response button
        $(document).on('click', '.btn-question-response', function () {
            let form = $('#mainForm');
            let btn = $(this);
            let parentId = btn.attr('data-response-id');
            let productId = btn.attr('data-product-id');
            form.find('#response_to').val(parentId);
            form.find('#product_id').val(productId);

            let modalEl = document.querySelector('#responseModal');
            let modal = bootstrap.Modal.getOrCreateInstance(modalEl);
            modal.show();
        });

        $(document).on('click', '.btn-question-delete', function () {
            let btn = $(this);
            Swal.fire({
                title: 'آیا مطمئنید؟',
                text: "این پرسش همراه با تمامی پاسخ های آن برای همیشه حذف میشوند!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'بله، حذف کن!',
                cancelButtonText: 'انصراف',
                customClass: {
                    confirmButton: 'btn btn-danger me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    let questionId = btn.attr('data-question-id');
                    let row = btn.parents('tr');
                    btn.prop('disabled', true);
                    btn.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span>');

                    let data = new FormData();
                    data.append('question_id', questionId);

                    $.ajax({
                        method: 'POST',
                        url: '/admin/questions/delete/',
                        data: data,
                        processData: false,
                        contentType: false,
                        headers: {'X-CSRF-TOKEN': _token},
                        error: function () {
                            btn.prop('disabled', false);
                            btn.html('<i class="bx bx-trash"></i>');
                        }
                    }).done(function (data) {
                        console.log(data);
                        if (data === 'success') {
                            btn.remove();
                            row.addClass('table-danger');
                            row.fadeOut(400, function() {
                                row.remove();
                            });
                        }
                    }).always(function () {
                        btn.prop('disabled', false);
                        btn.html('<i class="bx bx-trash"></i>');
                    });
                }
            });
        });

        $(document).on('click', '.btn-question-approved', function () {
            let btn = $(this);
            let questionId = btn.attr('data-question-id');
            let unapprovedBtn = btn.next('.btn-question-unapproved');
            let row = btn.parents('tr');

            btn.prop('disabled', true);
            btn.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span>');

            let data = new FormData();
            data.append('question_id', questionId);

            $.ajax({
                method: 'POST',
                url: '/admin/questions/approved/',
                data: data,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': _token},
                error: function () {
                    btn.prop('disabled', false);
                    btn.html('تایید کردن');
                }
            }).done(function (data) {
                console.log(data);
                if (data === 'success') {
                    btn.addClass('d-none');
                    unapprovedBtn.removeClass('d-none');
                    row.removeClass('table-danger');
                }
            }).always(function () {
                btn.prop('disabled', false);
                btn.html('تایید کردن');
            });
        });

        $(document).on('click', '.btn-question-unapproved', function () {
            let btn = $(this);
            let questionId = btn.attr('data-question-id');
            let approvedBtn = btn.prev('.btn-question-approved');
            let row = btn.parents('tr');

            btn.prop('disabled', true);
            btn.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span>');

            let data = new FormData();
            data.append('question_id', questionId);

            $.ajax({
                method: 'POST',
                url: '/admin/questions/unapproved/',
                data: data,
                processData: false,
                contentType: false,
                headers: {'X-CSRF-TOKEN': _token},
                error: function () {
                    btn.prop('disabled', false);
                    btn.html('لغو تایید کردن');
                }
            }).done(function (data) {
                console.log(data);
                if (data === 'success') {
                    btn.addClass('d-none');
                    approvedBtn.removeClass('d-none');
                    row.addClass('table-danger');
                }
            }).always(function () {
                btn.prop('disabled', false);
                btn.html('لغو تایید کردن');
            });
        });
    </script>
@endsection
