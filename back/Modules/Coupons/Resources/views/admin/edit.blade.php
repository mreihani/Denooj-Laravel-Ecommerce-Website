@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">کد تخفیف ها /</span> ویرایش
    </h4>

    @include('admin.includes.alerts',['class' => 'mb-3'])
    <div class="card">
        <div class="card-body">
            <form action="{{route('coupons.update',$coupon)}}" method="post" enctype="multipart/form-data" class="row" id="mainForm">
                @csrf
                @method('PATCH')
                {{-- code --}}
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="code">کد تخفیف (مانند: yalda)</label>
                        <input type="text" aria-label="code" aria-describedby="codeHelp" class="form-control text-left dirLtr" id="code" value="{{old('code',$coupon->code)}}" readonly>
                    </div>
                </div>

                {{-- expire day --}}
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="expire_after_day">انقضاء بعد از</label>
                        @php $v = new \Hekmatinasser\Verta\Verta($coupon->expire_at); @endphp
                        <input type="text" aria-label="expire_at" class="form-control" id="expire_at"  value="{{$v->format('Y/n/j ساعت H:i')}}" readonly>
                    </div>
                </div>

                {{-- type --}}
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="type">نوع تخفیف</label>
                        <select class="form-select" name="type" id="type">
                            <option value="percent" {{$coupon->type == 'percent' ? 'selected':''}}>درصد</option>
                            <option value="amount" {{$coupon->type == 'amount' ? 'selected':''}}>مبلغ</option>
                        </select>
                    </div>
                </div>

                {{-- percent --}}
                <div class="col-lg-4" id="percentContainer" style="display: {{$coupon->type == 'percent' ? 'block' : 'none'}}">
                    <div class="mb-3">
                        <label class="form-label" for="percent">درصد تخفیف</label>
                        <input type="number" aria-label="percent" class="form-control" id="percent" name="percent" value="{{old('percent',$coupon->percent)}}">
                    </div>
                </div>

                {{-- amount --}}
                <div class="col-lg-4" id="amountContainer" style="display: {{$coupon->type == 'percent' ? 'none' : 'block'}}">
                    <div class="mb-3">
                        <label class="form-label" for="amount">مبلغ تخفیف (تومان)</label>
                        <input type="number" aria-label="amount" class="form-control" id="amount" name="amount" value="{{old('amount',$coupon->amount)}}">
                    </div>
                </div>

                {{-- max usage --}}
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="max_usage">حداکثر تعداد استفاده</label>
                        <input type="number" aria-label="max_usage" class="form-control" id="max_usage" name="max_usage" value="{{old('max_usage',$coupon->max_usage)}}">
                    </div>
                </div>

                {{-- min price --}}
                <div class="col-lg-4">
                    <div class="mb-3">
                        <label class="form-label" for="min_price">حداقل مبلغ خرید (تومان)</label>
                        <input type="number" aria-label="min_price" class="form-control" id="min_price" name="min_price" value="{{old('min_price',$coupon->min_price)}}">
                    </div>
                </div>

                <div class="mb-3 mt-2">
                    <label class="switch switch-square">
                        <input type="checkbox" class="switch-input" name="infinite" {{old('infinite',$coupon->infinite) ? 'checked' : ''}}>
                        <span class="switch-toggle-slider">
                                        <span class="switch-on"><i class="bx bx-check"></i></span>
                                        <span class="switch-off"><i class="bx bx-x"></i></span>
                                    </span>
                        <span class="switch-label">
                            کد تخفیف بی نهایت
                        </span>
                    </label>
                </div>

                <div class="col-12 mt-3">
                    <div class="alert alert-primary">
                        <ul class="list-group-flush m-0 p-0">
                            <li class="list-group-item">در صورت ایجاد کد تخفیف درصدی، درصد تخفیف وارد شده بر روی مبلغ کل سفارش کاربر اعمال خواهد شد.</li>
                            <li class="list-group-item">برای انتخاب کدتخفیف فقط حروف لاتین (انگلیسی) ، نقطه(.) و زیرخط(_) مجاز است.</li>
                            <li class="list-group-item">توجه کنید که زمان انقضای کد تخفیف از الان تا مدت زمان انتخاب شده محاسبه میشود.</li>
                            <li class="list-group-item">هر کد تخفیف فقط یک بار برای هر فرد قابل استفاده است.</li>
                            <li class="list-group-item">مشتری می تواند این کد تخفیف را روی یک یا همزمان چند محصول شما استفاده کند.</li>
                            <li class="list-group-item">در صورت انتخاب گزینه کد تخفیف بی نهایت، این کد تخفیف می تواند بدون هیچ محدودیتی برای هر کاربر استفاده گردد.</li>
                        </ul>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary submit-button">ذخیره تغییرات</button>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('styles')
@endsection
@section('scripts')
    <script>
        $('select#type').on('change',function (){
            if ($(this).val() === 'amount'){
                $('#amountContainer').show();
                $('#percentContainer').hide();
            } else{
                $('#amountContainer').hide();
                $('#percentContainer').show();
            }
        });
    </script>
@endsection
