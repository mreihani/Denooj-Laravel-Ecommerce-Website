@extends('admin.layouts.panel')
@section('content')
    <h4 class="py-3 breadcrumb-wrapper mb-4">
        <span class="text-muted fw-light">کاربر / نمایش /</span> کیف پول و موجودی
    </h4>
    @include('admin.includes.alerts')
    <div class="row gy-4">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            @include('users::admin.show.sidebar')
        </div>
        <!-- User Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- User Pills -->
            <ul class="nav nav-pills flex-column flex-md-row mb-3">
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show',$user)}}"><i class="bx bx-file me-1"></i>سفارشات</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_security',$user)}}"><i class="bx bx-lock-alt me-1"></i>امنیت</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="{{route('users.balance',$user)}}"><i class="bx bx-wallet-alt me-1"></i>کیف پول و موجودی</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_payments',$user)}}"><i class="bx bx-money me-1"></i>پرداخت ها</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('users.show_addresses',$user)}}"><i class="bx bx-map me-1"></i>آدرس ها</a>
                </li>
            </ul>

            <div class="card mb-4">
                <h5 class="card-header">واریز / برداشت موجودی کیف پول</h5>
                <div class="card-body">
                    <form action="{{route('users.balance_update',$user)}}" method="POST" id="mainForm">
                        @csrf
                        <div class="row">
                            {{-- amount --}}
                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="amount">مبلغ (تومان)</label>
                                <input type="number" class="form-control" id="amount" name="amount" value="{{old('amount')}}">
                            </div>

                            {{-- type --}}
                            <div class="mb-3 col-lg-6">
                                <label class="form-label" for="type">عملیات</label>
                                <select class="form-select" id="type" name="type">
                                    <option value="withdraw" {{old('type') == 'withdraw' ? 'selected' :''}}>برداشت از کیف پول</option>
                                    <option value="deposit" {{old('type') == 'deposit' ? 'selected' :''}}>واریز به کیف پول</option>
                                </select>
                            </div>

                            <div>
                                <button type="submit" class="btn btn-primary submit-button me-2">ویرایش موجودی</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="{{asset('admin/assets/vendor/css/pages/page-profile.css')}}">
@endsection
@section('scripts')
@endsection
