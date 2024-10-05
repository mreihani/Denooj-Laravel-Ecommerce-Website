@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">سفارشات /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card mb-3">
        <div class="card-header">
            <div class="row">
                <div class="row">                           
                    <div class="col-md-6 d-flex justify-content-start">
                        <a aria-controls="filters" aria-expanded="true" class="btn btn-outline-primary me-1 waves-effect waves-light" data-bs-toggle="collapse" href="#filters" role="button">
                            نمایش فیلتر ها
                        </a>
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <a href="{{route('orders.export-excel', request()->except('page'))}}" class="btn btn-outline-secondary me-1 waves-effect waves-light" role="button">
                            دریافت اکسل
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-spreadsheet"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M8 11h8v7h-8z" /><path d="M8 15h8" /><path d="M11 11v7" /></svg>
                        </a>
                    </div>
                </div>

                <div class="{{(Route::currentRouteName() == 'orders.filter' || Route::currentRouteName() == 'orders.change-order-status') ? '' : 'collapse'}} mt-3" id="filters" style="">
                    <!-- Filters -->
                    <form method="GET" action="{{route('orders.filter')}}">
                        <div class="d-grid p-3 border">
                            <div class="row g-0">
                                <div class="col-md-6 p-2">
                                    <a class="btn btn-secondary waves-effect" href="{{route('orders.index')}}">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-restore"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3.06 13a9 9 0 1 0 .49 -4.087" /><path d="M3 4.001v5h5" /><path d="M12 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                                        ریست فیلتر
                                    </a>
                                </div>
                                <div class="col-md-6 p-2 d-flex justify-content-end">
                                    <button class="btn btn-primary waves-effect" id="button-addon1" type="submit">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-filter"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z" /></svg>
                                        اعمال فیلتر
                                    </button>
                                </div>
                            </div>

                            <div class="row g-0">
                                <div class="col-md-4 p-2">
                                    <div>
                                        <label class="form-label" for="shipping_phone">
                                            شماره تلفن خریدار
                                        </label>
                                        <input aria-describedby="button-addon1" class="form-control" placeholder="09123456789" type="search" name="shipping_phone" @if(isset($inputs["shipping_phone"])) value="{{$inputs["shipping_phone"]}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-4 p-2">
                                    <div>
                                        <label class="form-label" for="order_number">
                                            شماره سفارش
                                        </label>
                                        <input aria-describedby="button-addon1" class="form-control" placeholder="شماره سفارش را وارد نمایید" type="search" name="order_number" @if(isset($inputs["order_number"])) value="{{$inputs["order_number"]}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label class="form-label" for="is_discount">وضعیت جشنواره دنوج</label>
                                    <select class="form-select" id="is_discount" name="is_discount">
                                        <option {{!isset($inputs["is_discount"]) || ($inputs["is_discount"] === 0) ? 'selected' : ''}} value="0" disabled>انتخاب کنید</option>
                                        <option {{isset($inputs["is_discount"]) && ($inputs["is_discount"] === 'normal') ? 'selected' : ''}} value="normal">عادی</option>
                                        <option {{isset($inputs["is_discount"]) && ($inputs["is_discount"] === 'coupon') ? 'selected' : ''}} value="coupon">جشنواره</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-4 p-2">
                                    <label class="form-label" for="status">وضعیت سفارش</label>
                                    <select class="form-select" id="status" name="status">
                                        <option {{!isset($inputs["status"]) || ($inputs["status"] === 0) ? 'selected' : ''}} value="0" disabled>انتخاب کنید</option>
                                        <option {{isset($inputs["status"]) && ($inputs["status"] === 'pending_payment') ? 'selected' : ''}} value="pending_payment">در انتظار پرداخت مشتری</option>
                                        <option {{isset($inputs["status"]) && ($inputs["status"] === 'ongoing') ? 'selected' : ''}} value="ongoing">در حال پردازش</option>
                                        <option {{isset($inputs["status"]) && ($inputs["status"] === 'sent') ? 'selected' : ''}} value="sent">تحویل به پست</option>
                                        <option {{isset($inputs["status"]) && ($inputs["status"] === 'completed') ? 'selected' : ''}} value="completed">تکمیل شده</option>
                                        <option {{isset($inputs["status"]) && ($inputs["status"] === 'cancel') ? 'selected' : ''}} value="cancel">لغو شده</option>
                                    </select>
                                </div>

                                <div class="col-md-4 p-2">
                                    <label class="form-label" for="is_paid">وضعیت پرداخت</label>
                                    <select class="form-select" id="is_paid" name="is_paid">
                                        <option {{!isset($inputs["is_paid"]) || ($inputs["is_paid"] === 0) ? 'selected' : ''}} value="0" disabled>انتخاب کنید</option>
                                        <option {{isset($inputs["is_paid"]) && ($inputs["is_paid"] === 'paid') ? 'selected' : ''}} value="paid">پرداخت شده</option>
                                        <option {{isset($inputs["is_paid"]) && ($inputs["is_paid"] === 'notpaid') ? 'selected' : ''}} value="notpaid">پرداخت نشده</option>
                                    </select>
                                </div>

                                <div class="col-md-4 p-2">
                                    <label class="form-label" for="shipping_method">روش حمل</label>
                                    <select class="form-select" id="shipping_method" name="shipping_method">
                                        <option {{!isset($inputs["shipping_method"]) || ($inputs["shipping_method"] === 0) ? 'selected' : ''}} value="0" disabled>انتخاب کنید</option>
                                        <option {{isset($inputs["shipping_method"]) && ($inputs["shipping_method"] === 'freightage') ? 'selected' : ''}} value="freightage">باربری</option>
                                        <option {{isset($inputs["shipping_method"]) && ($inputs["shipping_method"] === 'post') ? 'selected' : ''}} value="post">پست</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row g-0">
                                <div class="col-md-4 p-2">
                                    <div>
                                        <label class="form-label" for="filter-start-date">
                                            تاریخ شروع
                                        </label>
                                        <input class="form-control bdi flatpickr-input active" id="filter-start-date" placeholder="YYYY/MM/DD HH:MM" type="text" readonly="readonly" name="start_date" @if(isset($inputs["start_date"])) value="{{$inputs["start_date"]}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-4 p-2">
                                    <div>
                                        <label class="form-label" for="filter-end-date">
                                            تاریخ پایان
                                        </label>
                                        <input class="form-control bdi flatpickr-input active" id="filter-end-date" placeholder="YYYY/MM/DD HH:MM" type="text" readonly="readonly" name="end_date" @if(isset($inputs["end_date"])) value="{{$inputs["end_date"]}}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-4 p-2">
                                    <label class="form-label" for="date-order">ترتیب نمایش</label>
                                    <select class="form-select" id="date-order" name="date_order">
                                        <option {{isset($inputs["date_order"]) && ($inputs["date_order"] === 'desc') ? 'selected' : ''}} value="desc" selected="">جدید ترین</option>
                                        <option {{isset($inputs["date_order"]) && ($inputs["date_order"] === 'asc') ? 'selected' : ''}} value="asc">قدیمی ترین</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- ./Filters -->

                    <!-- Bulk Action -->
                    <form method="POST" action="{{route('orders.change-order-status', request()->except('page'))}}" class="mt-4">
                        @csrf
                        <div class="d-grid p-3 border">
                            
                            <div class="col-12 mb-3">
                                <div class="alert alert-info">
                                    <h4>راهنمایی</h4>
                                    <p>این ابزار برای تغییر وضعیت گروهی سفارشات کاربرد دارد:</p>
                                    <ul style="list-style: inside">
                                        <li>ابتدا حتما باید از طریق فیلتر بالا، سفارشات مورد نظر را فیلتر و فراخوانی نمایید</li>
                                        <li>سپس وضعیت سفارش را انتخاب و بر روی دکمه اعمال کلیک کنید</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="row p-2">
                                <div class="col-md-6">
                                    <label class="form-label" for="status-handler">وضعیت سفارش</label>
                                    <select class="form-select" id="status-handler" name="status_handler">
                                        <option value="0" disabled selected>انتخاب کنید</option>
                                        <option value="pending_payment">در انتظار پرداخت مشتری</option>
                                        <option value="ongoing">در حال پردازش</option>
                                        <option value="sent">تحویل به پست</option>
                                        <option value="completed">تکمیل شده</option>
                                        <option value="cancel">لغو شده</option>
                                    </select>
                                </div>
                                <div class="col-md-6 d-flex justify-content-end align-items-end">
                                    <button class="btn btn-sm btn-warning waves-effect orders-bulk-action" id="button-addon1" type="button" data-alert-message="وضعیت تمامی سفارشات به صورت گروهی تغییر خواهد کرد!">
                                        <svg class="me-1" xmlns="http://www.w3.org/2000/svg"  width="20"  height="20"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-replace"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 3m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M15 15m0 1a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v4a1 1 0 0 1 -1 1h-4a1 1 0 0 1 -1 -1z" /><path d="M21 11v-3a2 2 0 0 0 -2 -2h-6l3 3m0 -6l-3 3" /><path d="M3 13v3a2 2 0 0 0 2 2h6l-3 -3m0 6l3 -3" /></svg>
                                        اعمال
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!-- ./Bulk Action -->
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('orders.search')}}" method="post" style="width: 350px">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="نام یا موبایل کاربر، شماره سفارش ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('orders.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($orders->count() > 0)
                <table class="table table-striped table-bordered table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>عملیات</th>
                        <th>سفارش</th>
                        <th>تاریخ</th>
                        <th>اقلام</th>
                        <th>مجموع</th>
                        <th>وضعیت</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($orders as $order)
                        <tr>

                            {{-- actions --}}
                            <td style="white-space: nowrap">
                                <div class="d-flex flex-column">
                                    @if($order->is_paid)
                                    <a class="btn px-2 btn-dark btn-sm mb-2 flex-shrink-0" href="{{route('orders.label',$order)}}"><i class="bx bxs-user-badge me-1"></i> چاپ برچسب ارسال</a>
                                    @endif
                                    <a class="btn px-2 btn-primary btn-sm flex-shrink-0" href="{{route('orders.edit',$order)}}"><i class="bx bx-edit-alt me-1"></i> جزئیات / ویرایش</a>
                                </div>
                                <div class="dropdown mt-2">
                                    <button type="button" class="btn btn-sm btn-light px-3 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i> بیشتر
                                    </button>
                                    <div class="dropdown-menu">
                                        @if($order->is_paid)
                                            <a class="dropdown-item" href="{{route('orders.factor',$order)}}"><i class="bx bx-printer me-1"></i> مشاهده فاکتور</a>
                                        @endif
                                        <a class="dropdown-item delete-row" href="javascript:void(0);" data-alert-message="این سفارش برای همیشه حذف میشود و امکان بازگردانی وجود ندارد!"><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('orders.destroy',$order)}}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <span>حذف</span>
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </td>

                            {{-- order info --}}
                            <td style="white-space: normal">
                                <div class="d-flex flex-column justify-content-start align-items-start">
                                    <a href="{{route('users.show',$order->user)}}" data-bs-toggle="tooltip" data-bs-placement="left" title="خریدار"
                                       class="d-inline-flex align-items-center rounded-3 px-2 pe-3 card flex-row w-auto mb-2">
                                        <div class="avatar avatar-sm me-2">
                                            <img src="{{$order->user->getAvatar()}}" alt="" class="rounded-circle">
                                        </div>
                                        <div class="d-flex flex-column font-13">
                                            <span>{{$order->shipping_full_name}}</span>
                                            <span>{{$order->shipping_phone}}</span>
                                        </div>
                                    </a>

                                    <div class="d-inline-block border rounded-3 px-2 font-12 fw-bold" data-bs-toggle="tooltip" data-bs-placement="left" title="شماره سفارش">
                                        <i class="bx bx-hash"></i>
                                        <span>{{$order->order_number}}</span>
                                    </div>
                                </div>

                            </td>

                            {{-- date --}}
                            <td style="white-space: nowrap;">
                                <span class="font-12">{{verta($order->created_at)->format('%d %B، %Y')}}</span>
                            </td>

                            {{-- items --}}
                            <td>
                                <div class="d-flex align-items-center avatar-group my-3">
                                    @foreach($order->items()->limit(4)->get() as $product)
                                        <div class="avatar">
                                            <img src="{{$product->getImage('thumb')}}" alt="Avatar" class="rounded pull-up" data-bs-toggle="tooltip"
                                                 data-bs-placement="top" title="{{$product->title}}" data-bs-original-title="{{$product->title}}">
                                        </div>
                                    @endforeach
                                    @if($order->items->count() > 4)
                                    <div class="avatar">
                                        <span class="avatar-initial rounded pull-up bg-secondary" data-bs-toggle="tooltip" data-bs-placement="top" title="" data-bs-original-title="{{$order->items->count() - 4}} مورد بیشتر">+{{$order->items->count() - 4}}</span>
                                    </div>
                                    @endif
                                </div>
                            </td>

                            {{-- price --}}
                            <td>
                                <span>{{number_format($order->getTotalPrice()) . ' تومان'}}</span>

                                @if($order->is_paid)
                                    <div class="d-flex flex-column align-items-start">
                                        <span class="badge bg-label-success"><i class="bx bx-check"></i> پرداخت شده</span>
                                        @if($order->getTotalPrice() != $order->paid_price)
                                        <span class="font-14 fw-bold mt-2 d-block">مبلغ پرداخت شده: {{number_format($order->paid_price)}}</span>
                                        @endif
                                    </div>
                                @endif
                            </td>



                            {{-- status --}}
                            <td>
                                @switch($order->status)
                                    @case('pending_payment')
                                        <span class="badge bg-label-secondary">در انتظار پرداخت</span>
                                        @break
                                    @case('ongoing')
                                        <span class="badge bg-label-warning">در حال پردازش</span>
                                        @break
                                    @case('completed')
                                        <span class="badge bg-label-success">تکمیل شده</span>
                                        @break
                                    @case('sent')
                                        <span class="badge bg-dark">تحویل به پست</span>
                                        @break
                                    @case('cancel')
                                        <span class="badge bg-label-secondary">لغو شده</span>
                                        @break
                                @endswitch

                                @if($order->postal_code)
                                    <span class="d-block mt-2 font-12">{{'کد مرسوله: '. $order->postal_code}}</span>
                                @endif
                            </td>

                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$orders->links()}}
        </div>
    </div>
@endsection

@section('styles')
@endsection

@section('scripts')
    <script>
        const filterStartDate = document.querySelector('#filter-start-date');
        if (filterStartDate) {
            filterStartDate.flatpickr({
                enableTime: true,
                dateFormat: 'Y/m/d H:i',
                locale: 'fa',
            });
        }
        const filterEndDate = document.querySelector('#filter-end-date');
        if (filterEndDate) {
            filterEndDate.flatpickr({
                enableTime: true,
                dateFormat: 'Y/m/d H:i',
                locale: 'fa',
            });
        }
    </script>
@endsection
