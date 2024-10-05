@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">کاربر / نمایش /</span> حساب
    </h4>
    @include('admin.includes.alerts')
    <div class="row gy-4">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            @include('users::admin.show.sidebar')
        </div>

        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Pills -->
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('users.show',$user)}}"><i class="bx bx-file me-1"></i>سفارشات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_security',$user)}}"><i class="bx bx-lock-alt me-1"></i>امنیت</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.balance',$user)}}"><i class="bx bx-wallet-alt me-1"></i>کیف پول و موجودی</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_payments',$user)}}"><i class="bx bx-money me-1"></i>پرداخت ها</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_addresses',$user)}}"><i class="bx bx-map me-1"></i>آدرس ها</a>
                </li>
            </ul>

            <div class="card">
                <h5 class="card-header">سفارشات</h5>
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        @if($orders->count() > 0)
                            <table class="table table-striped table-hover " style="min-height: 200px">
                                <thead>
                                <tr>
                                    <th>عملیات</th>
                                    <th>کد سفارش</th>
                                    <th>خریدار</th>
                                    <th>اقلام سفارش</th>
                                    <th>مبلغ</th>
                                    <th>وضعیت پرداخت</th>
                                    <th>وضعیت سفارش</th>
                                    <th>تاریخ ثبت</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                @foreach($orders as $order)
                                    <tr>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('orders.edit',$order)}}"><i class="bx bx-edit-alt me-1"></i> مشاهده جزئیات</a>
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
                                        <td><span class="font-15 fw-bold">{{$order->order_number}}</span></td>
                                        <td>
                                            <a href="{{route('users.show',$order->user)}}" class="btn btn-sm btn-label-primary">{{$order->user->getFullName()}}</a>
                                        </td>
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
                                        <td><span>{{number_format($order->price) . ' تومان'}}</span></td>
                                        <td>
                                            @if($order->is_paid)
                                                <div class="d-flex flex-column justify-content-center align-items-center">
                                                    <span class="badge bg-label-success"><i class="bx bx-check"></i> پرداخت شده</span>
                                                    <span class="font-14 fw-bold mt-2 d-block">مبلغ پرداخت شده: {{number_format($order->paid_price)}}</span>
                                                </div>

                                            @else
                                                <span class="badge bg-label-secondary"><i class="bx bx-hourglass"></i> پرداخت نشده</span>
                                            @endif
                                        </td>
                                        <td>
                                            @switch($order->status)
                                                @case('pending_payment')
                                                    <span class="badge bg-label-secondary">در انتظار پرداخت مشتری</span>
                                                    @break
                                                @case('ongoing')
                                                    <span class="badge bg-label-warning">در حال پردازش</span>
                                                    @break
                                                @case('completed')
                                                    <span class="badge bg-label-success">تکمیل شده</span>
                                                    @break
                                                @case('cancel')
                                                    <span class="badge bg-label-secondary">لغو شده</span>
                                                    @break
                                            @endswitch
                                        </td>
                                        <td>
                                            {{verta($order->created_at)->format('%d %B، %Y ساعت H:i')}}
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
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-profile.css')}}">
@endsection
@section('scripts')
@endsection
