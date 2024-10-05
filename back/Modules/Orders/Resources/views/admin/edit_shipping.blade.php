@extends('admin.layouts.panel')
@section('content')
    <div class="d-flex align-items-center justify-content-between py-3 mb-4">
        <h4 class="m-0 breadcrumb-wrapper">
            <span class="text-muted fw-light">آدرس سفارش /</span> ویرایش
        </h4>
    </div>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card">
        <div class="card-body">
            <form action="{{route('orders.update_shipping',$order)}}" method="post" enctype="multipart/form-data"
                  class="row" id="mainForm">
                @csrf

                {{-- province --}}
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="shipping_province">استان</label>
                    <select class="form-select select2" id="shipping_province" name="shipping_province">
                        <option value="" selected>انتخاب استان</option>
                        @foreach(\Modules\Users\Entities\Province::all() as $province)
                            <option value="{{$province->id}}" {{$province->id == $order->shipping_province ? 'selected':''}}>{{$province->name}}</option>
                        @endforeach
                    </select>
                </div>

                {{-- city --}}
                <div class="col-lg-3 mb-4">
                    <label class="form-label" for="shipping_city">شهر</label>
                    <select class="form-select select2" id="shipping_city" name="shipping_city">
                        <option value="" selected>انتخاب شهر</option>
                        @foreach(\Modules\Users\Entities\Province::find($order->shipping_province)->cities as $city)
                            <option value="{{$city->id}}" {{$city->id == $order->shipping_city ? 'selected':''}}>{{$city->name}}</option>
                        @endforeach
                    </select>
                </div>


                {{-- post code --}}
                <div class="col-lg-4 mb-4">
                    <label class="form-label" for="shipping_post_code">کد پستی</label>
                    <input type="text" class="form-control" id="shipping_post_code" name="shipping_post_code"
                           value="{{old('shipping_post_code',$order->shipping_post_code)}}">
                </div>

                {{-- phone --}}
                <div class="col-lg-4 mb-4">
                    <label class="form-label" for="shipping_phone">تلفن تماس</label>
                    <input type="text" class="form-control" id="shipping_phone" name="shipping_phone"
                           value="{{old('shipping_phone',$order->shipping_phone)}}">
                </div>

                {{-- full name --}}
                <div class="col-lg-4 mb-4">
                    <label class="form-label" for="shipping_full_name">نام تحویل گیرنده</label>
                    <input type="text" class="form-control" id="shipping_full_name" name="shipping_full_name"
                           value="{{old('shipping_full_name',$order->shipping_full_name)}}">
                </div>

                {{-- address --}}
                <div class="col-12 mb-4">
                    <label class="form-label" for="shipping_address">آدرس</label>
                    <textarea id="shipping_address" name="shipping_address" type="text"
                              class="form-control">{{old('shipping_address',$order->shipping_address)}}</textarea>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-success submit-button">ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
