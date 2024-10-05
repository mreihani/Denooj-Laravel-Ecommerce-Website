@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('admin.dashboard')}}">داشبورد</a> /</span> درون ریزی
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <form action="{{route('import_csv')}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
        @csrf
        <div class="col-lg-3"></div>
        <div class="col-lg-6">
            @if(session()->has('result'))
                <div class="alert alert-info">{!! session('result') !!}</div>
            @endif
            <div class="card mb-4">
                <div class="loading-gif-container d-none">
                    <img src="{{asset('admin/assets/img/loading.gif')}}" alt="loading">
                    <h4 class="mt-5">لطفا منتظر بمانید...</h4>
                </div>
                <div class="card-body">
                    <div class="row">

                        {{-- model --}}
                        <div class="mb-4 col-12">
                            <label class="form-label" for="type">انتخاب پست تایپ</label>
                            <select class="form-select" name="type" id="type">
                                <option value="" selected>انتخاب نشده</option>
                                <option value="page">برگه</option>
                                <option value="post">مقاله</option>
                                <option value="post_cat">دسته‌بندی مقاله</option>
                                <option value="post_tag">برچسب مقاله</option>
                                <option value="post_comment">دیدگاه مقاله</option>
                                <option value="user">کاربر/مشتری</option>
                                <option value="product">محصول</option>
                                <option value="product_cat">دسته‌بندی محصول</option>
                                <option value="product_tag">برچسب محصول</option>
                                <option value="product_comment">دیدگاه محصول</option>
                                <option value="order">سفارش</option>

                            </select>
                        </div>

                        {{-- file --}}
                        <div class="mb-4 col-12">
                            <label for="file" class="form-label">انتخاب فایل (csv)</label>
                            <input class="form-control" type="file" id="file" name="file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                        </div>


                        {{-- author --}}
                        <div class="col-12 mb-4 d-none" id="authorField">
                            <label class="form-label" for="author_id">انتخاب نویسنده</label>
                            <select class="form-select" name="author_id" id="author_id">
                                @foreach(\Modules\Admins\Entities\Admin::all() as $author)
                                    <option value="{{$author->id}}">{{$author->name . ' (' . $author->email . ')'}}</option>
                                @endforeach
                            </select>
                        </div>


                        {{-- image downlaod check --}}
                        <div class="col-12 d-none" id="imageDownloadField">
                            <label class="switch switch-square mb-4">
                                <input type="checkbox" class="switch-input" name="download_images">
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">تصاویر دانلود و منتقل شود</span>
                                <small class="d-block mt-2">با فعالسازی این گزینه درصورتی وجود تصاویر، به طور خودکار دانلود و در سرور شما آپلود میشود.</small>
                            </label>

                            {{-- base url --}}
                            <div class="col-12 mb-4 d-none" id="baseUrlField">
                                <label class="form-label" for="base_url">آدرس دامنه سایت مبدا</label>
                                <input class="form-control" dir="ltr" name="base_url" id="base_url" placeholder="مانند: https://google.com">
                            </div>
                        </div>


                        <div class="col-12">
                            <div class="alert alert-warning">
                                <b class="d-block mb-3">لطفا قبل از انجام درون ریزی حتما به نکات زیر توجه کنید:</b>
                                <ul class="m-0">
                                    <li>درون ریزی سفارشات نیاز به وجود کاربران دارد پس ابتدار کاربران را درون ریزی کنید.</li>
                                    <li>بعد از درون ریزی مقالات و محصولات، حتما باید دسته بندی ها را نیز درون ریزی کنید.</li>
                                    <li>درصورتی که از قبل دیتایی در سایت دارید حتما قبل از انجام درون ریزی از سایت خود بک آپ تهیه کنید.</li>
                                    <li>بهتر است برای درون ریزی کامل و بدون مشکل دسته بندی ها، از قبل دسته بندی در سایت وجود نداشته باشد.</li>
                                    <li>درون ریزی فایل های بزرگ، مخصوصا هنگامی که گزینه تصاویر نیز فعال است ممکن است مقداری زمانبر باشد. لطفا تا اتمام فرایند از این صفحه خارج نشوید!</li>
                                </ul>
                            </div>
                        </div>


                        <div class="mt-4">
                            <button type="submit" class="btn btn-success me-2 submit-button">شروع درون ریزی</button>
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
    <script>

        // post type change
        $('#type').change(function (){
            let type = $(this).val();
            let imageDlField = $('#imageDownloadField');
            let authorField = $('#authorField');
            let allowedImageDlTypes = ['product','product_cat','post'];
            let allowedAuthorTypes = ['product','post'];

            // image download field
            if(allowedImageDlTypes.includes(type)){
                imageDlField.removeClass('d-none');
            } else{
                imageDlField.addClass('d-none');
            }

            // author field
            if(allowedAuthorTypes.includes(type)){
                authorField.removeClass('d-none');
            } else{
                authorField.addClass('d-none');
            }
        });

        // show hide base_url field
        $('input[name=download_images]').change(function (){
            let checked = $(this).is(":checked");
            let baseUrlField = $('#baseUrlField');

            if(checked){
                baseUrlField.removeClass('d-none');
            }else{
                baseUrlField.addClass('d-none');
            }
        });


        // submit button click
        $(document).on('click','.submit-button',function (e){
            e.preventDefault();
            let button = $(this);

            Swal.fire({
                title: 'از درون ریزی مطمئن هستید؟',
                text: 'توصیه میشود قبل از انجام این کار از دیتابیس خود بک آپ تهیه کنید. فرایند درون ریزی ممکن است با توجه به حجم دیتای شما طولانی تر شود لطفا صبور باشید و از این صفحه خارج نشوید.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'شروع درون ریزی',
                cancelButtonText: 'انصراف',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function (result) {
                if (result.value) {
                    button.prop('disabled',true);
                    button.html('<span class="spinner-grow align-middle" role="status" aria-hidden="true"></span> چند لحظه صبر کنید');
                    button.parents('form').submit();
                    $('.loading-gif-container').removeClass('d-none');
                }
            });
        })


    </script>
@endsection
