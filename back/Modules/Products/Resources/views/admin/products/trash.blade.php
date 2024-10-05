@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light"><a href="{{route('products.index')}}">محصولات</a> /</span> زباله‌دان
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('products.search.trash')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('products.trash')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('products.index')}}" class="btn btn-primary"><span><i class="bx bx-arrow-from-left me-sm-2"></i> <span class="d-none d-sm-inline-block">بازگشت به محصولات</span></span></a>
                <form action="{{route('products.trash.empty')}}" method="post" class="d-inline-block">
                    @csrf
                    <span class="btn btn-warning" id="btn-empty-trash"><span><i class="bx bx-trash-alt me-sm-2"></i> <span class="d-none d-sm-inline-block">خالی کردن سطل زبانه</span></span></span>
                </form>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($products->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>عملیات</th>
                        <th>تصویر</th>
                        <th>عنوان</th>
                        <th>نامک</th>
                        <th>دسته بندی</th>
                        <th>وضعیت انتشار</th>
                        <th>قیمت</th>
                        <th>موجودی</th>
                        <th>تعداد فروش</th>
                        <th>مجموع درآمد</th>
                        <th>بازدید</th>
                        <th>تاریخ ایجاد</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <form action="{{route('products.delete.force')}}" method="post" class="d-inline-block">
                                    @csrf
                                    <input type="hidden" name="id" value="{{$product->id}}">
                                    <span class="btn btn-danger btn-sm btn-fore-delete" data-alert-message="این مقاله برای همیشه پاک خواهد شد!">حذف</span>
                                </form>
                                <form action="{{route('products.restore',$product->id)}}" method="post" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-label-success btn-sm">بازگردانی</button>
                                </form>
                            </td>
                            <td>
                                <a href="{{$product->getImage('original')}}" target="_blank">
                                    <img src="{{$product->getImage('thumb')}}" alt="image" class="rounded" style="width: 50px">
                                </a>
                                {{--                                @if($product->images)--}}
                                {{--                                    @foreach($product->images as $img)--}}
                                {{--                                        <a href="{{'/storage' . $img['original']}}" target="_blank">--}}
                                {{--                                            <img src="{{'/storage' . $img['thumb']}}" alt="image" class="rounded" style="width: 50px;">--}}
                                {{--                                        </a>--}}
                                {{--                                    @endforeach--}}
                                {{--                                @endif--}}
                            </td>
                            <td><p style="font-size: 14px;max-width: 100px;white-space: normal;">{{$product->title}}</p></td>
                            <td><p style="font-size: 14px;max-width: 100px;white-space: normal;">{{$product->slug}}</p></td>
                            <td style="max-width: 120px;white-space: normal">
                                @if($product->categories)
                                    @foreach($product->categories as $cat)
                                        <a href="{{route('categories.show',$cat)}}" class="badge bg-label-primary">{{$cat->title}}</a>
                                    @endforeach
                                @endif
                            </td>
                            <td>
                                @switch($product->status)
                                    @case('draft')
                                        <span class="badge bg-label-secondary">پیش نویس</span>
                                        @break
                                    @case('published')
                                        <span class="badge bg-label-success">منتشر شده</span>
                                        @break
                                @endswitch
                            </td>
                            <td>{{number_format($product->price)}}</td>
                            <td>
                                @if($product->getStockStatus() == 'in_stock')
                                    <span class="font-13">{{$product->getDisplayStock()}}</span>
                                @else
                                    <span class="badge bg-label-danger">{{$product->getDisplayStock()}}</span>
                                @endif
                            </td>
                            <td>{{$product->sell_count}}</td>
                            <td>0</td>
                            <td>{{views($product)->count()}}</td>
                            <td>{{verta($product->created_at)->format('Y-n-j ساعت H:i')}}</td>
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
