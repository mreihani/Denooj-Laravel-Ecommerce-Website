<div class="user-order-row">
    <div class="content start-0 w-100">
        <span class="fw-300 font-15 flex-shrink-0 d-inline-block">شماره سفارش:<b class="fw-600 text-secondary-dark ms-1">{{$order->order_number}}</b></span>

        <span class="text-dark fw-700 font-15 mx-lg-4 my-lg-0 my-3 flex-shrink-0">مبلغ کل: {{number_format($order->price) . ' تومان'}}</span>

        @switch($order->status)
            @case('pending_payment')
                <span class="badge bg-danger">در انتظار پرداخت</span>
                @break
            @case('ongoing')
                <span class="badge bg-label-dark">درحال پردازش</span>
                @break
            @case('completed')
                <span class="badge bg-label-green">تکمیل شده</span>
                @break
            @case('sent')
                <span class="badge bg-primary">ارسال شده</span>
                @break
            @case('cancel')
                <span class="badge bg-secondary">لغو شده</span>
                @break
        @endswitch

        <div class="d-flex flex-column my-3 my-lg-0 mx-lg-3">
            <span class="text-muted fw-300 font-13">تاریخ ثبت:</span>
            <span class="fw-300 text-dark">{{verta($order->created_at)->format('Y/n/j')}}</span>
        </div>

        <div class="ms-auto flex-shrink-0 w-992-100">
            <a href="{{route('order.show',$order)}}" class="btn btn-primary no-transform w-100"><span>مشاهده جزئیات</span><i class="icon-eye ms-2"></i></a>
        </div>

        <div class="mt-3 d-flex flex-wrap gap-1 w-100 align-items-center">
            <span class="me-2">اقلام سفارش:</span>
            @foreach($order->items as $product)
                <a href="{{route('product.show',$product)}}" title="{{$product->title}}" data-bs-toggle="tooltip" data-bs-placement="top">
                    <img src="{{$product->getImage('thumb')}}" alt="product" class="rounded-1" width="40">
                </a>
            @endforeach
        </div>

    </div>
</div>
