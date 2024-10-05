<nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
    <div class="container-fluid">
        <div class="navbar-nav align-items-center">
            <a class="nav-link style-switcher-toggle hide-arrow" href="javascript:void(0);">
                <i class="bx bx-sm"></i>
            </a>
        </div>

        <a href="{{route('home')}}" class="btn btn-label-primary btn-sm flex-shrink-0 ms-3 rounded-3">
            <i class="bx bxs-home"></i>
            <span class="ms-1 d-none d-md-inline">مشاهده سایت</span>
        </a>

        <a href="{{route('stories.create')}}" class="btn btn-warning btn-sm flex-shrink-0 ms-3 rounded-3 me-4">
            <i class="bx bx-plus-circle"></i>
            <span class="ms-1 d-none d-md-inline">داستان جدید بسازید</span>
        </a>

        <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
                <i class="bx bx-menu bx-sm"></i>
            </a>
        </div>



        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <ul class="navbar-nav flex-row align-items-center ms-auto">

                <li class="nav-item me-3 d-none d-md-block">
                    <a href="{{route('admin.changelog')}}" class="btn btn-label-info btn-sm rounded-3">
                        <i class="bx bx-info-square font-13"></i>
                        <span class="ms-1">تغییرات نسخه</span>
                    </a>
                </li>

                <!-- User -->
                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                        <div class="avatar avatar-online">
                            <img src="{{auth()->guard('admin')->user()->getAvatar()}}" alt class="rounded-circle">
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="{{route('admin.profile')}}">
                                <div class="d-flex">
                                    <div class="flex-shrink-0 me-3">
                                        <div class="avatar avatar-online">
                                            <img src="{{auth()->guard('admin')->user()->getAvatar()}}" alt
                                                 class="rounded-circle">
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <span class="fw-semibold d-block lh-1">{{auth()->guard('admin')->user()->name}}</span>
                                        <small>{{auth()->guard('admin')->user()->email}}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('admin.profile')}}">
                                <i class="bx bx-user me-2"></i>
                                <span class="align-middle">پروفایل من</span>
                            </a>
                        </li>
                        @can('edit-setting-general')
                            <li>
                                <a class="dropdown-item" href="{{route('settings.general')}}">
                                    <i class="bx bx-cog me-2"></i>
                                    <span class="align-middle">تنظیمات</span>
                                </a>
                            </li>
                        @endcan
                        @can('see-orders')
                            @php $pendingOrders = \Modules\Orders\Entities\Order::where('status','ongoing')->get()->count(); @endphp
                            <li>
                                <a class="dropdown-item" href="#">
                          <span class="d-flex align-items-center align-middle">
                            <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                            <span class="flex-grow-1 align-middle">سفارشات</span>
                            <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">{{$pendingOrders}}</span>
                          </span>
                                </a>
                            </li>
                        @endcan

                        <li>
                            <a class="dropdown-item" href="{{route('admin.changelog')}}">
                                <i class="bx bx-info-square me-2"></i>
                                <span class="align-middle">تغییرات نسخه</span>
                            </a>
                        </li>
                        <li>
                            <div class="dropdown-divider"></div>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{route('admin.logout')}}">
                                <i class="bx bx-power-off me-2"></i>
                                <span class="align-middle">خروج</span>
                            </a>
                        </li>
                    </ul>
                </li>




            </ul>
        </div>
    </div>
</nav>
