@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">دیدگاه‌ها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('comments.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..."
                               name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('comments.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
        </div>


        <div class="table-responsive-sm">
            @if($comments->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>نویسنده</th>
                        <th>دیدگاه</th>
                        <th>نکات مثبت و منفی</th>
                        <th>امتیاز</th>
                        <th>محصول/مقاله</th>
                        <th>تاریخ ارسال</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($comments as $comment)
                        <tr class="{{$comment->status == 'pending' ? 'table-danger' : ''}}">
                            <td>
                                @if($comment->from_buyer)
                                    <span class="badge bg-label-warning font-12 mb-3">خریدار محصول</span>
                                @endif
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0">
                                        <img src="{{$comment->getSenderAvatar()}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div class="d-flex flex-column ms-2 w-100 flex-shrink-0">
                                        <b>{{$comment->getSenderName()}}</b>
                                        <span style="font-size: 12px;">{{$comment->user->mobile}}</span>
                                    </div>
                                </div>
                            </td>
                            <td style="max-width: 500px;font-size: 13px">
                                <div>{{$comment->comment}}</div>
                                <div>
                                    <button
                                        class="btn btn-sm btn-label-success mt-2 btn-comment-approved {{$comment->status == 'published' ? 'd-none' :''}}"
                                        data-comment-id="{{$comment->id}}">تایید کردن
                                    </button>
                                    <button
                                        class="btn btn-sm btn-label-warning mt-2 btn-comment-unapproved {{$comment->status == 'published' ? '' :'d-none'}}"
                                        data-comment-id="{{$comment->id}}">لغو تایید کردن
                                    </button>

                                    <a href="{{route('comments.edit',$comment)}}" class="btn btn-sm btn-primary mt-2"><i class="bx bx-edit"></i></a>

                                    <button
                                        class="btn btn-sm btn-danger mt-2 btn-comment-delete" data-comment-id="{{$comment->id}}"><i class="bx bx-trash"></i>
                                    </button>

                                </div>
                            </td>
                            <td>
                                @if($comment->product)
                                    @if($comment->strengths != null)
                                    @foreach($comment->strengths as $strength)
                                        <div class="mb-1 font-12"><i class="bx bx-plus text-success me-1"></i><span>{{$strength}}</span></div>
                                    @endforeach
                                    @endif

                                    @if($comment->weaknesses != null)
                                    @foreach($comment->weaknesses as $weakness)
                                        <div class="mb-1 font-12"><i class="bx bx-minus text-danger me-1"></i><span>{{$weakness}}</span></div>
                                    @endforeach
                                @endif
                                @else
                                    ---
                                @endif
                            </td>
                            <td>
                                @if($comment->product)
                                <div class="d-flex">
                                    @for ($i = 0; $i < $comment->score; $i++)
                                        <i class="bx bxs-star text-warning font-13"></i>
                                    @endfor
                                </div>
                                <span class="d-block mt-2">{{'امتیاز: ' . $comment->score}}</span>
                                @else
                                    ---
                                @endif
                            </td>
                            <td style="max-width: 250px;">
                                @if($comment->product)
                                <a href="{{route('products.edit',$comment->product)}}"
                                   style="font-weight: bold;font-size: 14px">{{$comment->product->title}}</a>
                                <div class="blockquote-footer mt-2">
                                    <a href="{{route('product.show',$comment->product)}}">نمایش محصول</a>
                                </div>
                                    <span class="badge bg-label-dark mt-2">
                                    <span>{{$comment->product->comments()->count()}}</span><i class="bx bxs-message ms-1"
                                                                                              style="font-size: 12px"></i>
                                </span>
                                @elseif($comment->post)
                                    <a href="{{route('posts.edit',$comment->post)}}"
                                       style="font-weight: bold;font-size: 14px">{{$comment->post->title}}</a>
                                    <div class="blockquote-footer mt-2">
                                        <a href="{{route('post.show',$comment->post)}}">نمایش مقاله</a>
                                    </div>
                                    <span class="badge bg-label-dark mt-2">
                                    <span>{{$comment->post->comments()->count()}}</span><i class="bx bxs-message ms-1"
                                                                                              style="font-size: 12px"></i>
                                </span>
                                @endif


                            </td>
                            <td style="max-width: 120px;">
                               <span class="font-13">{{verta($comment->created_at)->format('%d %B، %Y ساعت H:i')}}</span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$comments->links()}}

        </div>

    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
    <script>

        $(document).on('click', '.btn-comment-delete', function () {
            let btn = $(this);
            Swal.fire({
                title: 'آیا مطمئنید؟',
                text: "این دیدگاه برای همیشه حذف میشوند!",
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
                    let commentId = btn.attr('data-comment-id');
                    let row = btn.parents('tr');
                    btn.prop('disabled', true);
                    btn.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span>');

                    let data = new FormData();
                    data.append('comment_id', commentId);

                    $.ajax({
                        method: 'POST',
                        url: '/admin/comments/delete/',
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

        $(document).on('click', '.btn-comment-approved', function () {
            let btn = $(this);
            let commentId = btn.attr('data-comment-id');
            let unapprovedBtn = btn.next('.btn-comment-unapproved');
            let row = btn.parents('tr');

            btn.prop('disabled', true);
            btn.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span>');

            let data = new FormData();
            data.append('comment_id', commentId);

            $.ajax({
                method: 'POST',
                url: '/admin/comments/approved/',
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

        $(document).on('click', '.btn-comment-unapproved', function () {
            let btn = $(this);
            let commentId = btn.attr('data-comment-id');
            let approvedBtn = btn.prev('.btn-comment-approved');
            let row = btn.parents('tr');

            btn.prop('disabled', true);
            btn.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span>');

            let data = new FormData();
            data.append('comment_id', commentId);

            $.ajax({
                method: 'POST',
                url: '/admin/comments/unapproved/',
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
