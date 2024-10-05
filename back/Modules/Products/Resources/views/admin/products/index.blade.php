@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">محصولات /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('products.search')}}" method="get">
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..."
                               name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('products.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                @can('see-product-trash')
                    <a href="{{route('products.trash')}}" class="btn btn-label-secondary"><span><i
                                class="bx bx-trash me-sm-2"></i> <span class="d-none d-sm-inline-block">زباله‌دان</span></span></a>
                @endcan

                <a href="{{route('products.create')}}" class="btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span
                            class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
            </div>
        </div>

        <div class="">
            @if($products->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>عملیات</th>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>دسته‌ها</th>
                        <th>وضعیت</th>
                        <th>نوع</th>
                        <th>قیمت</th>
                        <th>موجودی</th>
                        <th>آمار</th>
                        <th>تاریخ ایجاد</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($products as $productItem)
                        <tr>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 px-2 dropdown-toggle hide-arrow"
                                            data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('product.show',$productItem)}}"><i
                                                class="bx bx-show me-1"></i> مشاهده</a>
                                        <a class="dropdown-item" href="{{route('products.edit',$productItem)}}"><i
                                                class="bx bx-edit-alt me-1"></i> ویرایش</a>
                                        <a class="dropdown-item duplicate-product" href="javascript:void(0);"><i
                                                class="bx bx-copy me-1"></i>
                                            <form action="{{route('products.duplicate',$productItem)}}" method="post"
                                                  class="d-inline-block">
                                                @csrf
                                                <span>دوبل کردن</span>
                                            </form>
                                        </a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);"
                                           data-alert-message="بعد از حذف به سطل زباله منتقل میشود."><i
                                                class="bx bx-trash me-1"></i>
                                            <form action="{{route('products.destroy',$productItem)}}" method="post"
                                                  class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <span>حذف</span>
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{$productItem->getImage('original')}}" target="_blank">
                                    <img src="{{$productItem->getImage('thumb')}}" alt="image" class="rounded"
                                         style="width: 50px">
                                </a>
                                {{--                                @if($product->images)--}}
                                {{--                                    @foreach($product->images as $img)--}}
                                {{--                                        <a href="{{'/storage' . $img['original']}}" target="_blank">--}}
                                {{--                                            <img src="{{'/storage' . $img['thumb']}}" alt="image" class="rounded" style="width: 50px;">--}}
                                {{--                                        </a>--}}
                                {{--                                    @endforeach--}}
                                {{--                                @endif--}}
                            </td>
                            <td>
                                <p style="font-size: 14px;max-width: 100px;white-space: normal;">{{$productItem->title}}</p>

                                @if($productItem->recommended)
                                    <span class="badge bg-label-warning"><i
                                            class="bx bxs-badge-check"></i> محصول ویژه</span>
                                @endif
                            </td>

                            <td style="max-width: 200px;white-space: normal">
                                @if($productItem->categories)
                                    @foreach($productItem->categories as $cat)
                                        <a href="{{route('category.show',$cat)}}"
                                           class="badge bg-label-primary">{{$cat->title}}</a>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @switch($productItem->status)
                                    @case('draft')
                                        <span class="badge bg-label-secondary">پیش نویس</span>
                                        @break
                                    @case('published')
                                        <span class="badge bg-label-success">منتشر شده</span>
                                        @break
                                @endswitch
                            </td>
                            <td>

                                @if($productItem->product_type == 'variation')
                                    @if($productItem->variation_type == 'color')
                                        رنگ متغیر
                                    @elseif($productItem->variation_type == 'size')
                                        سایز متغیر
                                    @elseif($productItem->variation_type == 'color_size')
                                        رنگ و سایز متغیر
                                    @else
                                        --
                                    @endif
                                @else
                                    محصول ساده
                                @endif
                            </td>
                            <td>
                                {!! $productItem->getPriceHtml('',true) !!}
                            </td>
                            <td>
                                @if($productItem->inStock())
                                    <span class="font-13 d-block">موجود در انبار</span>
                                    @if($productItem->product_type == 'simple' && $productItem->manage_stock)
                                        @php $quantity = $productItem->getStockQuantity(); $class = '';
                                        if($quantity < 4) {$class='text-danger';}
                                        @endphp
                                        <span class="font-13 {{$class}}">{{'تعداد موجودی: '.$quantity}}</span>
                                    @endif
                                @else
                                    <span class="badge bg-label-danger">ناموجود</span>
                                @endif
                            </td>
                            <td>
                                <span class="d-block font-13">{{'بازدید: ' . views($productItem)->count()}}</span>
                                <span class="d-block font-13">{{'فروش: ' . $productItem->sell_count}}</span>
                                <span
                                    class="font-13">{{'درآمد: ' . number_format($productItem->income()) . ' تومان'}}</span>
                            </td>
                            <td>{{verta($productItem->created_at)->format('Y-n-j ساعت H:i')}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$products->links()}}

        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
