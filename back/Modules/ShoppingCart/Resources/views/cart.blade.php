@extends('front.layouts.master')
@section('content')
    <div class="container-fluid page-content mt-5">
        <div class="custom-container">

            @include('front.alerts')
            
            <div class="row">
                <div class="col-lg-8 mb-4">

                    @php $outOfStock = 0;@endphp
                    @foreach($items as $item)
                        @php $product = \Modules\Products\Entities\Product::find($item->associatedModel->id); @endphp
                        @if (!$product->inStock())
                            @php $outOfStock++;@endphp
                        @endif
                    @endforeach
                    @if ($outOfStock > 0)
                        <div class="alert alert-danger">
                            <span>وضعیت موجودی {{$outOfStock}} محصول سبد خرید شما تغییر کرده است</span>
                            <form action="{{route('cart.reload')}}" method="post" class="d-inline-block">
                                @csrf
                                <button class="btn btn-danger btn-sm ms-lg-3 mt-3 mt-lg-0">به روز رسانی سبد خرید</button>
                            </form>
                        </div>
                    @endif

                    @include('shoppingcart::cart.cart-controlpanel')
                </div>
               
                {{-- sidebar --}}
                <div class="col-lg-4">
                    <div class="box cart-sidebar">
                        
                        {{-- factor --}}
                        @include('shoppingcart::cart.cart-details')

                        @if($items->count() > 0)
                            <a href="{{route('cart.checkout')}}"
                               class="btn btn-success w-100 text-center mt-4 p-3 d-flex justify-content-between"
                               id="btnCartPage"><span>ادامه فرایند خرید</span><i class="icon-arrow-left"></i></a>

                            <!-- <ul class="list-group list-group-flush mt-2">
                                <li class="list-group-item pb-1 ps-1"><i
                                            class="icon-check-square font-16 me-2 text-success"></i><span
                                            class="font-14">تضمین بازگشت پول</span><span
                                            class="font-12 text-muted ms-1 d-inline-block">در صورت نارضایتی</span></li>

                                <li class="list-group-item pb-1 ps-1">
                                    <i class="icon-info font-16 me-2 text-warning"></i>
                                    <span class="font-14">کالاهای موجود در سبد شما ثبت و رزرو نشده‌اند، برای ثبت سفارش مراحل بعدی را تکمیل کنید.</span>
                                </li>
                            </ul> -->
                        @endif
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('assets/js/checkout.js')}}"></script>
@endsection