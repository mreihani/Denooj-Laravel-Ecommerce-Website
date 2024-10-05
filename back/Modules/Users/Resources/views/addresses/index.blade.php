@extends('front.layouts.user_panel')
@section('panel_content')

    <div class="box">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="font-18 fw-bold mb-0">آدرس های من</h1>
            <span class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addressModal"><i class="icon-plus ml-2"></i>افزودن آدرس</span>
        </div>

        @include('front.alerts')

        <div class="row">
            @if($addresses->count() > 0)
                @foreach($addresses as $address)
                    <div class="col-lg-6 mb-4">
                        <div class="border p-3 border-1 rounded">
                            <div class="dropup float-end">
                                <span class="btn btn-light" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="icon-more-vertical font-20"></i>
                                </span>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="{{route('address.edit',$address->id)}}">ویرایش آدرس</a>
                                    <form action="{{route('address.delete',$address->id)}}" method="post">
                                        @csrf
                                        <span type="submit" class="dropdown-item" onclick="deleteAddress(this)">حذف آدرس</span>
                                    </form>
                                </div>
                            </div>
                            <div class="d-flex font-16 font-weight-bold mb-3">
                                <i class="icon-map-pin color-main"></i>
                                <p class="ms-2 m-0">{{$address->address}}</p>
                            </div>
                            <p class="font-15 mb-2">کد پستی: {{$address->post_code}}</p>
                            <p class="font-15 mb-2">استان: {{$address->getProvince()->name}}</p>
                            <p class="font-15 mb-2">شهر: {{$address->getCity()->name}}</p>
                            <p class="font-15 mb-2">تلفن: {{$address->phone}}</p>
                            <p class="font-15 m-0">تحویل گیرنده: {{$address->full_name}}</p>
                            @if($address->default === 1)
                                <p class="font-14 badge badge-danger mt-3">آدرس پیشفرض</p>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="text-center">
                        <img src="{{asset('assets/images/user_address.png')}}" alt="no address" class="img-fluid mb-3">
                        <h5>شما هیچ آدرسی اضافه نکرده اید.</h5>
                    </div>
                </div>
            @endif
        </div>
    </div>

    @include('users::user_panel.add_address_modal')

@endsection
