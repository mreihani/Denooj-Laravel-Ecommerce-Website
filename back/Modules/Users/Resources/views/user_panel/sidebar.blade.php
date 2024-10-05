<div class="user-panel-sidebar">
    <div class="box" id="sidebar-box">
        <!-- toggle button -->
        <div class="user-panel-sidebar-toggle" id="openSidebar">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="scrollable-content">
            <div class="user-panel-sidebar-head">
                <div class="user-panel-sidebar-image">
                    <img src="{{auth()->user()->getAvatar()}}" alt="{{auth()->user()->getFullName()}}">
                    <a href="{{route('panel.edit')}}" class="edit-profile"><i class="icon-edit"></i></a>
                </div>
                <span class="fw-bold font-18 d-block mt-3">{{auth()->user()->getFullName()}}</span>
                <span class="fw-300 text-muted font-13 d-block mt-1">{{'عضویت از ' . auth()->user()->getCreationDate()}}</span>
            </div>
            <?php $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();?>
            <a href="{{route('panel.overview')}}" class="sidebar-link-item {{$currentRoute == "panel.overview" ? 'active' :''}}"><i class="icon-compass"></i><span>نگاه کلی</span></a>
            <a href="{{route('panel.wallet')}}" class="sidebar-link-item {{$currentRoute == "panel.wallet" ? 'active' :''}}"><i class="icon-credit-card"></i><span>کیف پول: <span class="font-11">({{number_format(auth()->user()->balance)}} تومان)</span></span></a>
            <a href="{{route('order.index')}}" class="sidebar-link-item {{$currentRoute == "order.index" ? 'active' :''}}"><i class="icon-file-text"></i><span>سفارشات من</span></a>
            <a href="{{route('panel.favorites')}}" class="sidebar-link-item {{$currentRoute == "panel.favorites" ? 'active' :''}}"><i class="icon-heart"></i><span>محصولات موردعلاقه</span></a>
            <a href="{{route('panel.favorites_post')}}" class="sidebar-link-item {{$currentRoute == "panel.favorites_post" ? 'active' :''}}"><i class="icon-bookmark"></i><span>مقالات نشان‌شده</span></a>
            <a href="{{route('panel.tickets')}}" class="sidebar-link-item {{$currentRoute == "panel.tickets" ? 'active' :''}}"><i class="icon-headphones"></i><span>تیکت‌های پشتیبانی</span></a>
            <a href="{{route('panel.edit')}}" class="sidebar-link-item {{$currentRoute == "panel.edit" ? 'active' :''}}"><i class="icon-edit-2"></i><span>ویرایش حساب کاربری</span></a>
            <a href="{{route('panel.addresses')}}" class="sidebar-link-item {{$currentRoute == "panel.addresses" ? 'active' :''}}"><i class="icon-map"></i><span>آدرس های من</span></a>
            <a href="{{route('logout')}}" class="sidebar-link-item"><i class="icon-log-out color-red"></i><span class="color-red">خروج از حساب کاربری</span></a>
        </div>
    </div>
</div>
