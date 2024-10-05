<!-- search box (add loading class to container) -->
<div class="header-up-left-content">
    @auth
        <div class="dropdown d-inline-block">
            <button class="btn btn-light dropdown-toggle btn-user-profile header-button" type="button" id="userButton"
                    data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icon-user me-lg-1"></i><span class="d-none d-lg-inline-block">{{auth()->user()->getFullName()}}</span>
            </button>
            <ul class="dropdown-menu" aria-labelledby="userButton">
                <li><a class="dropdown-item" href="{{route('panel.overview')}}"><i class="icon-eye"></i><span>مشاهده حساب کاربری</span></a></li>
                <li><a class="dropdown-item" href="{{route('panel.wallet')}}"><i class="icon-credit-card"></i><span>کیف پول <span class="font-12 text-muted">({{number_format(auth()->user()->wallet->balance)}} تومان)</span></span></a></li>
                <li><a class="dropdown-item" href="{{route('order.index')}}"><i class="icon-file-text"></i><span>سفارش‌های من</span></a></li>
                <li><a class="dropdown-item" href="{{route('panel.favorites')}}"><i class="icon-heart"></i><span>لیست علاقه‌مندی</span></a></li>
                <li><a class="dropdown-item" href="{{route('logout')}}"><i class="icon-log-out color-red"></i><span>خروج از حساب</span></a></li>
            </ul>
        </div>
    @else
        <a href="{{route('signin')}}" class="btn btn-primary shadow header-button"><i class="icon-user d-inline-block me-lg-2"></i><span class="d-none d-lg-inline-block">ورود / ثبت نام</span></a>
    @endauth
    <a href="#" class="btn btn-secondary ms-2 ms-sm-3 no-highlight no-transform @if(!str_contains($currentRouteName,'cart')) open-cart @endif cart-button header-button">
        <?php $cartCount = cart()->getContent()->count();?>
        @if($cartCount > 0)
            <span class="count">{{$cartCount}}</span>
        @endif
        <i class="icon-shopping-cart"></i>
    </a>
    <!-- small screen menu toggle -->
    <span class="btn btn-light d-lg-none ms-2" id="open-menu"><i class="icon-menu font-20"></i></span>
</div>
