@extends('front.layouts.user_panel')
@section('panel_content')

    <div class="section-title font-18 fw-bold">لیست محصولات مورد علاقه</div>

    <div class="row mt-4">
        @foreach($products as $product)
            <div class="col-xl-3 col-md-6 col-12 product-col mb-4">
                @include('products::includes.product_item',['product' => $product, 'favoritesPage' => true,'class' => 'mobile-horizontal'])
            </div>
        @endforeach

        <div class="col-12 mt-3">
            {{$products->links('front.vendor.pagination.bootstrap-4')}}
        </div>
    </div>
@endsection
