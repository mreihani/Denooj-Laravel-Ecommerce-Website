@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">کد تخفیف ها /</span> لیست
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])

    <div class="card">
        <div class="card-header d-flex flex">
            <div class="d-flex align-items-center">
                <form action="{{route('coupons.search')}}" method="post">
                    @csrf
                    <div class="input-group input-group-merge">
                        <span class="input-group-text" id="basic-addon-search31"><i class="bx bx-search"></i></span>
                        <input type="text" class="form-control" placeholder="جستجو ..." aria-label="Search..." name="query" @if(isset($query)) value="{{$query}}" @endif>
                    </div>
                </form>
                @if(isset($query))
                    <a href="{{route('coupons.index')}}" class="btn btn-sm btn-secondary ms-3"><i class="bx bx-x"></i></a>
                @endif
            </div>
            <div class="ms-auto text-end primary-font pt-3 pt-md-0">
                <a href="{{route('coupons.create')}}" class="dt-button create-new btn btn-primary"><span><i class="bx bx-plus me-sm-2"></i> <span class="d-none d-sm-inline-block">افزودن رکورد جدید</span></span></a>
            </div>
        </div>

        <div class="table-responsive-sm">
            @if($coupons->count() > 0)
                <table class="table table-striped table-hover" style="min-height: 200px">
                    <thead>
                    <tr>
                        <th>کد تخفیف</th>
                        <th>نوع</th>
                        <th>درصد/مبلغ</th>
                        <th>زمان انقضاء</th>
                        <th>تعداد استفاده</th>
                        <th>تاریخ ایجاد</th>
                        <th>عملیات</th>
                    </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    @foreach($coupons as $coupon)
                        <tr>
                            <td>
                                <span class="badge fw-bold bg-label-primary font-18">{{$coupon->code}}</span>
                            </td>
                            <td>
                                @if ($coupon->type == 'percent')
                                    درصدی
                                @else
                                    مبلغ
                                @endif
                            </td>
                            <td>
                                @if ($coupon->type == 'percent')
                                    {{'%'.$coupon->percent}}
                                @else
                                    <span>{{number_format($coupon->amount) . ' تومان'}}</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->isExpired())
                                    <span class="badge bg-label-danger">منقضی شده است</span>
                                @else
                                    @php $v = new \Hekmatinasser\Verta\Verta($coupon->expire_at); @endphp
                                    <span class="text-nowrap">{{$v->format('Y/n/j ساعت H:i')}}</span>
                                @endif
                            </td>
                            <td>
                                @if($coupon->infinite)
                                    بی نهایت
                                @else
                                    {{$coupon->users->count()}}     
                                @endif
                            </td>
                            <td>
                                @php $v = new \Hekmatinasser\Verta\Verta($coupon->created_at); @endphp
                                <span class="text-nowrap">{{$v->format('Y/n/j ساعت H:i')}}</span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route('coupons.edit',$coupon)}}"><i class="bx bx-edit-alt me-1"></i> ویرایش</a>
                                        <a class="dropdown-item delete-row" href="javascript:void(0);"><i class="bx bx-trash me-1"></i>
                                            <form action="{{route('coupons.destroy',$coupon)}}" method="post" class="d-inline-block">
                                                @csrf
                                                @method('DELETE')
                                                <span>حذف</span>
                                            </form>
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <div class="alert alert-secondary m-3">هیچ موردی پیدا نشد.</div>
            @endif
            {{$coupons->links()}}

        </div>
    </div>
@endsection

@section('styles')
@endsection
@section('scripts')
@endsection
