@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">تنظیمات /</span> نوتیفیکیشن
    </h4>
    @include('admin.includes.alerts')
    <div class="row">
        <div class="col-md-12">
            @include('settings::nav')
            <div class="card mb-4">
                <h5 class="card-header">تنظیمات نوتیفیکیشن ها</h5>
                <form action="{{route('settings.notifications_update',$settings)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">


                        <h4 class="card-title">نوتیف های مدیریت</h4>

                        <table class="table table-striped">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">نوتفیکیشن</th>
                                    <th scope="col">ایمیل</th>
                                    <th scope="col">پیامک</th>
                                </tr>
                            </thead>

                            {{-- new comment for product --}}
                            <tr>
                                <td>ثبت دیدگاه جدید برای محصول</td>
                                <td>
                                    <label class="switch switch-square">
                                        <input type="checkbox" class="switch-input" name="product_comment_email" {{$settings->product_comment_email ? 'checked' : ''}}>
                                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch switch-square">
                                        <input type="checkbox" class="switch-input" name="product_comment_sms" {{$settings->product_comment_sms ? 'checked' : ''}}>
                                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    </label>
                                </td>
                            </tr>
                            {{-- new comment for article --}}
                            <tr>
                                <td>ثبت دیدگاه جدید برای مقاله</td>
                                <td>
                                    <label class="switch switch-square">
                                        <input type="checkbox" class="switch-input" name="post_comment_email" {{$settings->post_comment_email ? 'checked' : ''}}>
                                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch switch-square">
                                        <input type="checkbox" class="switch-input" name="post_comment_sms" {{$settings->post_comment_sms ? 'checked' : ''}}>
                                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    </label>
                                </td>
                            </tr>
                            {{-- new question --}}
                            <tr>
                                <td>ثبت پرسش جدید</td>
                                <td>
                                    <label class="switch switch-square">
                                        <input type="checkbox" class="switch-input" name="question_email" {{$settings->question_email ? 'checked' : ''}}>
                                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch switch-square">
                                        <input type="checkbox" class="switch-input" name="question_sms" {{$settings->question_sms ? 'checked' : ''}}>
                                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    </label>
                                </td>
                            </tr>
                            {{-- new order --}}
                            <tr>
                                <td>دریافت سفارش جدید</td>
                                <td>
                                    <label class="switch switch-square">
                                        <input type="checkbox" class="switch-input" name="new_order_email" {{$settings->new_order_email ? 'checked' : ''}}>
                                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    </label>
                                </td>
                                <td>
                                    <label class="switch switch-square">
                                        <input type="checkbox" class="switch-input" name="new_order_sms" {{$settings->new_order_sms ? 'checked' : ''}}>
                                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                    </label>
                                </td>
                            </tr>
                        </table>


                        <h4 class="card-title mt-5">نوتیف های مشتری</h4>

                        <div class="mb-4">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input" name="user_order_submitted_sms" {{$settings->user_order_submitted_sms ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">پیامک ثبت سفارش</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input" name="user_order_completed_sms" {{$settings->user_order_completed_sms ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">پیامک تکمیل سفارش</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input" name="user_order_sent_sms" {{$settings->user_order_sent_sms ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">پیامک تحویل سفارش به پست</span>
                            </label>
                        </div>
                        <div class="mb-4">
                            <label class="switch switch-square">
                                <input type="checkbox" class="switch-input" name="user_question_answered_sms" {{$settings->user_question_answered_sms ? 'checked' : ''}}>
                                <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                                <span class="switch-label">پیامک پاسخ پرسش</span>
                            </label>
                        </div>

                        <div class="mt-5">
                            <button type="submit" class="btn btn-success me-2 submit-button">ذخیره تغییرات</button>
                            <a href="{{route('admin.dashboard')}}" class="btn btn-label-secondary">انصراف</a>
                        </div>


                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
