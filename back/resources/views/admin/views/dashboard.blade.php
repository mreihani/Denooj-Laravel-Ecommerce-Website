@extends('admin.layouts.panel')
@section('content')
    @include('admin.includes.alerts')

    <div class="row">
        <!-- Weekly Order Summary -->
        <div class="col-lg-8 col-12 mb-4">
            <div class="card h-100">
                <div class="row row-bordered m-0">
                    <!-- Order Summary -->
                    <div class="col-12 pe-0">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">آمار فروش</h5>
                        </div>
                        <div class="card-body p-0">
                            <input type="hidden" id="chartData" value="{{$chartData}}">
                            <div id="orderSummaryChart"></div>
                        </div>
                    </div>

                    <!-- total sale -->
                    <div class="col-12">
                        <div class="p-3">
                            <div class="row align-items-center">
                                <div class="col-md-4 mt-2">
                                    <div class="d-flex align-items-center justify-content-md-center mb-2">
                                        <div class="avatar avatar-md flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-dollar"></i></span>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted text-nowrap">فروش هفته گذشته</p>
                                            <small class="fw-semibold text-nowrap font-17">{{number_format($totalWeekSale) . ' تومان'}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">
                                    <div class="d-flex align-items-center justify-content-md-center mb-2">
                                        <div class="avatar avatar-md flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-primary"><i class="bx bx-dollar"></i></span>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted text-nowrap">فروش یکماه گذشته</p>
                                            <small class="fw-semibold text-nowrap font-17">{{number_format($totalMonthSale) . ' تومان'}}</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2 mb-3">
                                    <div class="d-flex align-items-center justify-content-md-center mb-2">
                                        <div class="avatar avatar-md flex-shrink-0 me-3">
                                            <span class="avatar-initial rounded bg-label-success"><i class="bx bx-trending-up"></i></span>
                                        </div>
                                        <div>
                                            <p class="mb-0 text-muted text-nowrap">فروش کل</p>
                                            <small class="fw-semibold text-nowrap font-17">{{number_format($totalSale) . ' تومان'}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--/ Weekly Order Summary -->

        <!-- Statistics cards & Revenue Growth Chart -->
        <div class="col-lg-4 col-12">
            <div class="row">
                <!-- Statistics Cards -->
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-success"><i class="bx bx-purchase-tag fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap pt-1">خرید</span>
                            <h2 class="mb-n3">{{$saleCount}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-danger"><i class="bx bx-cart fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap pt-1">سفارش</span>
                            <h2 class="mb-n3">{{$ordersCount}}</h2>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body text-center">
                            <div class="avatar mx-auto mb-2">
                                <span class="avatar-initial rounded-circle bg-label-primary"><i class="bx bx-group fs-4"></i></span>
                            </div>
                            <span class="d-block text-nowrap pt-1">مشتری</span>
                            <h2 class="mb-n3">{{$usersCount}}</h2>
                        </div>
                    </div>
                </div>
                <!-- Multi Radial Chart -->
                <div class="col-12 mb-4">
                    <div class="card h-100">
                        <div class="card-header">
                            <h5 class="card-title mb-0 text-center">تعداد بازدید یک ماه اخیر</h5>
                        </div>
                        <div class="card-body pb-5">
                            <input type="hidden" id="productVisitCount" value="{{$productVisitCount}}">
                            <input type="hidden" id="postVisitCount" value="{{$postVisitCount}}">
                            <input type="hidden" id="categoryVisitCount" value="{{$categoryVisitCount}}">
                            <div id="impressionDonutChart" class="mt-2"></div>
                        </div>
                    </div>
                </div>
                <!--/ Multi Radial Chart -->
            </div>
        </div>
        <!--/ Statistics cards & Revenue Growth Chart -->

        {{-- latest orders | comments | questions --}}
        <div class="col-lg-8">

            {{-- orders --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">آخرین سفارشات</h5>
                    <a href="{{route('orders.index')}}" class="btn btn-sm btn-label-primary"><span>مشاهده همه</span><i class="bx bx-left-arrow-alt ms-2"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        @if($latestOrders->count() > 0)
                            <table class="table table-striped table-hover" style="min-height: 200px">
                                <thead>
                                <tr>
                                    <th>عملیات</th>
                                    <th>اقلام سفارش</th>
                                    <th>مبلغ</th>
                                    <th>وضعیت پرداخت</th>
                                    <th>وضعیت سفارش</th>
                                    <th>تاریخ ثبت</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                @foreach($latestOrders as $order)
                                    <tr>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    @if($order->is_paid)
                                                        <a class="dropdown-item" href="{{route('orders.factor',$order)}}"><i class="bx bx-printer me-1"></i> مشاهده فاکتور</a>
                                                    @endif
                                                    <a class="dropdown-item" href="{{route('orders.label',$order)}}"><i class="bx bxs-user-badge me-1"></i> چاپ برچسب ارسال</a>

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
                    </div>
                </div>
            </div>

            {{-- mostt visited products (month) --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">پربازدیدترین محصولات ماه</h5>
                    <a href="{{route('products.index')}}" class="btn btn-sm btn-label-primary"><span>مشاهده همه</span><i class="bx bx-left-arrow-alt ms-2"></i></a>
                </div>
                <div class="card-body">
                    <div class="table-responsive-sm">
                        @if($mostVisitedProducts->count() > 0)
                            <table class="table table-striped table-hover" style="min-height: 200px">
                                <thead>
                                <tr>
                                    <th>عملیات</th>
                                    <th>تصویر</th>
                                    <th>عنوان</th>
                                    <th>قیمت</th>
                                    <th>موجودی</th>
                                    <th>بازدید</th>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                @foreach($mostVisitedProducts as $product)
                                    <tr>
                                        <td>
                                            <div class="dropdown">
                                                <button type="button" class="btn p-0 px-2 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                                    <i class="bx bx-dots-vertical-rounded"></i>
                                                </button>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{route('product.show',$product)}}"><i class="bx bx-show me-1"></i> مشاهده</a>
                                                    <a class="dropdown-item" href="{{route('products.edit',$product)}}"><i class="bx bx-edit-alt me-1"></i> ویرایش</a>
                                                    <a class="dropdown-item duplicate-product" href="javascript:void(0);"><i class="bx bx-copy me-1"></i>
                                                        <form action="{{route('products.duplicate',$product)}}" method="post" class="d-inline-block">
                                                            @csrf
                                                            <span>دوبل کردن</span>
                                                        </form>
                                                    </a>
                                                    <a class="dropdown-item delete-row" href="javascript:void(0);" data-alert-message="بعد از حذف به سطل زباله منتقل میشود."><i class="bx bx-trash me-1"></i>
                                                        <form action="{{route('products.destroy',$product)}}" method="post" class="d-inline-block">
                                                            @csrf
                                                            @method('DELETE')
                                                            <span>حذف</span>
                                                        </form>
                                                    </a>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="{{$product->getImage('original')}}" target="_blank">
                                                <img src="{{$product->getImage('thumb')}}" alt="image" class="rounded" style="width: 50px">
                                            </a>
                                        </td>
                                        <td><p style="font-size: 14px;max-width: 100px;white-space: normal;">{{$product->title}}</p></td>
                                        <td>{{number_format($product->price)}}</td>
                                        <td>
                                            @if($product->getStockStatus() == 'in_stock')
                                                <span class="font-13">{{$product->getDisplayStock()}}</span>
                                            @else
                                                <span class="badge bg-label-danger">{{$product->getDisplayStock()}}</span>
                                            @endif
                                        </td>
                                        <td>{{views($product)->count()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        {{-- last active users | comments | questions --}}
        <div class="col-lg-4">
            {{-- comments --}}
            @if(\Nwidart\Modules\Facades\Module::has('Comments') && \Nwidart\Modules\Facades\Module::isEnabled('Comments'))
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">آخرین دیدگاه ها</h5>
                    <a href="{{route('comments.index')}}" class="btn btn-sm btn-label-primary"><span>مدیریت کنید</span><i class="bx bx-left-arrow-alt ms-2"></i></a>
                </div>
                <div class="card-body">
                    @if($comments->count() > 0)
                        <ul class="list-group">
                            @foreach($comments as $comment)
                                <li class="list-group-item">
                                    <div class="d-flex align-items-start flex-wrap">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <img src="{{$comment->getSenderAvatar()}}" alt="Avatar" class="rounded-circle">
                                            </div>
                                            <div class="me-2">
                                                <h6 class="mb-0">{{$comment->getSenderName()}}</h6>
                                                <small class="text-muted">{{verta($comment->created_at)->format('%d %B، %Y ساعت H:i')}}</small>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            @if($comment->status == 'pending')
                                                <span class="badge bg-label-danger">در انتظار تایید</span>
                                            @else
                                                <span class="badge bg-label-secondary">منتشر شده</span>
                                            @endif
                                        </div>
                                        <div class="w-100 font-13 mt-2">
                                            {{$comment->comment}}
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>هیچ دیدگاهی وجود ندارد.</p>
                    @endif
                </div>
            </div>
            @endif

            {{-- questions --}}
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">آخرین پرسش ها</h5>
                    <a href="{{route('questions.index')}}" class="btn btn-sm btn-label-primary"><span>مدیریت کنید</span><i class="bx bx-left-arrow-alt ms-2"></i></a>
                </div>
                <div class="card-body">
                    @if($questions->count() > 0)
                        <ul class="list-group">
                            @foreach($questions as $question)
                                <li class="list-group-item">
                                    <div class="d-flex align-items-start flex-wrap">
                                        <div class="d-flex align-items-center">
                                            <div class="avatar flex-shrink-0 me-3">
                                                <img src="{{$question->getSenderAvatar()}}" alt="Avatar" class="rounded-circle">
                                            </div>
                                            <div class="me-2">
                                                <h6 class="mb-0">{{$question->getSenderName()}}</h6>
                                                <small class="text-muted">{{verta($question->created_at)->format('%d %B، %Y ساعت H:i')}}</small>
                                            </div>
                                        </div>
                                        <div class="ms-auto">
                                            @if($question->status == 'pending')
                                                <span class="badge bg-label-danger">در انتظار پاسخ</span>
                                            @else
                                                <span class="badge bg-label-secondary">منتشر شده</span>
                                            @endif
                                        </div>
                                        <div class="w-100 font-13 mt-2">
                                            {{$question->text}}
                                            <div class="blockquote-footer mt-2">
                                                <a href="{{route('product.show',$question->product)}}">نمایش محصول</a>
                                            </div>
                                        </div>

                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p>هیچ پرسشی وجود ندارد.</p>
                    @endif
                </div>
            </div>

            {{-- last active users --}}
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="card-title mb-0">آخرین مشتریان فعال</h5>
                    <a href="{{route('users.index')}}" class="btn btn-sm btn-label-primary"><span>مشاهده همه</span><i class="bx bx-left-arrow-alt ms-2"></i></a>
                </div>
                <div class="card-body">
                    @if($activeUsers->count() > 0)
                    <ul class="list-unstyled mb-0">
                        @foreach($activeUsers as $user)
                        <li class="mb-3">
                            <div class="d-flex align-items-start">
                                <div class="d-flex align-items-center">
                                    <div class="avatar flex-shrink-0 me-3">
                                        <img src="{{$user->getAvatar(true)}}" alt="Avatar" class="rounded-circle">
                                    </div>
                                    <div class="me-2">
                                        <h6 class="mb-0">{{$user->getFullName()}}</h6>
                                        <small class="text-muted">{{$user->getLastActiveAt()}}</small>
                                    </div>
                                </div>
                                <div class="ms-auto">
                                    <a href="{{route('users.show',$user)}}" class="mt-1 btn btn-label-primary p-1 btn-sm"><i class="bx bx-user"></i></a>
                                </div>
                            </div>
                        </li>
                        @endforeach
                    </ul>
                    @else
                        <p>هیچ موردی وجود ندارد.</p>
                    @endif
                </div>
            </div>
        </div>


    </div>
@endsection
@section('styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/libs/apex-charts/apex-charts.css')}}">
@endsection

@section('scripts')
    <script src="{{asset('admin/assets/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <script src="{{asset('admin/assets/js/dashboards-ecommerce.js')}}"></script>
    <script src="{{asset('admin/assets/js/dashboards-analytics.js')}}"></script>
@endsection
