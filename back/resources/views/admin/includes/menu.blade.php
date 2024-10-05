@php $admin = auth()->guard('admin')->user(); @endphp
@php $appearanceSettings = \Modules\Settings\Entities\AppearanceSetting::first(); @endphp
<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{route('admin.dashboard')}}" class="app-brand-link">
            <img src="{{$appearanceSettings->getAdminLogo()}}" alt="logo" style="width: 140px;">
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="bx menu-toggle-icon d-none d-xl-block fs-4 align-middle"></i>
            <i class="bx bx-x d-block d-xl-none bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-divider mt-0"></div>

    <div class="menu-inner-shadow"></div>

    <?php $currentRoute = \Illuminate\Support\Facades\Route::currentRouteName();?>

    <ul class="menu-inner py-1">

        {{-- dashboard --}}
        @can('see-dashboard')
            <li class="menu-item {{$currentRoute == "admin.dashboard" ? 'active open' :''}}">
                <a href="{{route('admin.dashboard')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-home-circle"></i>
                    <div data-i18n="Page 1">داشبورد</div>
                </a>
            </li>
        @endcan

        {{-- profile --}}
        <li class="menu-item {{str_starts_with($currentRoute,'admin.profile') ? 'active open' :''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-user-account"></i>
                <div data-i18n="Invoice">حساب کاربری</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{$currentRoute == "admin.profile" ? 'active open' :''}}">
                    <a href="{{route('admin.profile')}}" class="menu-link">
                        <div data-i18n="List">ویرایش اطلاعات</div>
                    </a>
                </li>
                <li class="menu-item {{$currentRoute == "admin.profile.security" ? 'active open' :''}}">
                    <a href="{{route('admin.profile.security')}}" class="menu-link">
                        <div data-i18n="Preview">امنیت</div>
                    </a>
                </li>
            </ul>
        </li>

        {{-- products --}}
        @if($admin->can('see-products') || $admin->can('add-product') || $admin->can('see-product-trash'))
            <li class="menu-item {{str_starts_with($currentRoute,'products.') || str_starts_with($currentRoute,'categories.') || str_starts_with($currentRoute,'attributes.') || str_starts_with($currentRoute,'product-sizes.') || str_starts_with($currentRoute,'product-colors.') || str_starts_with($currentRoute,'tags.') ? 'active open' :''}}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-shopping-bag"></i>
                    <div data-i18n="Invoice">محصولات</div>
                </a>
                <ul class="menu-sub">
                    @can('see-products')
                        <li class="menu-item {{$currentRoute == "products.index" ? 'active open' :''}}">
                            <a href="{{route('products.index')}}" class="menu-link">
                                <div data-i18n="List">همه محصولات</div>
                            </a>
                        </li>
                    @endcan

                    @can('add-product')
                        <li class="menu-item {{$currentRoute == "products.create" ? 'active open' :''}}">
                            <a href="{{route('products.create')}}" class="menu-link">
                                <div data-i18n="Preview">افزودن محصول جدید</div>
                            </a>
                        </li>
                    @endcan

                    @can('see-product-trash')
                        <li class="menu-item {{$currentRoute == "products.trash" ? 'active open' :''}}">
                            <a href="{{route('products.trash')}}" class="menu-link">
                                <div data-i18n="Preview">زباله‌دان</div>
                            </a>
                        </li>
                    @endcan

                    {{-- categories --}}
                    @can('manage-categories')
                        <li class="menu-item {{str_starts_with($currentRoute,'categories.') ? 'active open' :''}}">
                            <a href="{{route('categories.index')}}" class="menu-link">
                                <div data-i18n="Invoice">دسته‌بندی‌ها</div>
                            </a>
                        </li>
                    @endcan

                    {{-- tags --}}
                    @can('manage-tags')
                        <li class="menu-item {{$currentRoute == "tags.index" ? 'active open' :''}}">
                            <a href="{{route('tags.index')}}" class="menu-link">
                                <div data-i18n="Page 1">برچسب‌ها</div>
                            </a>
                        </li>
                    @endcan

                        {{-- attributes --}}
                        @can('manage-attributes')
                            <li class="menu-item {{str_starts_with($currentRoute,'attributes.') ? 'active open' :''}}">
                                <a href="{{route('attributes.index')}}" class="menu-link">
                                    <div data-i18n="Invoice">ویژگی‌ها</div>
                                </a>
                            </li>
                        @endcan

                        {{-- colors --}}
                        @can('manage-product-colors')
                            <li class="menu-item {{str_starts_with($currentRoute,'product-colors.') ? 'active open' :''}}">
                                <a href="{{route('product-colors.index')}}" class="menu-link">
                                    <div data-i18n="Invoice">رنگ‌ها</div>
                                </a>
                            </li>
                        @endcan

                        {{-- sizes --}}
                        @can('manage-product-sizes')
                            <li class="menu-item {{str_starts_with($currentRoute,'product-sizes.') ? 'active open' :''}}">
                                <a href="{{route('product-sizes.index')}}" class="menu-link">
                                    <div data-i18n="Invoice">سایزها</div>
                                </a>
                            </li>
                        @endcan

                </ul>
            </li>
        @endif

        {{-- posts --}}
        @if(\Nwidart\Modules\Facades\Module::has('Blog') && \Nwidart\Modules\Facades\Module::isEnabled('Blog'))
            @if($admin->can('see-posts') || $admin->can('see-post-trash') || $admin->can('add-post') || $admin->can('manage-post-categories'))
                <li class="menu-item {{str_starts_with($currentRoute,'posts.') || str_starts_with($currentRoute,'post-categories.') || str_starts_with($currentRoute,'post-tags.') ? 'active open' :''}}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bxs-pencil"></i>
                        <div data-i18n="Users">مقالات</div>
                    </a>
                    <ul class="menu-sub">
                        @can('see-posts')
                            <li class="menu-item {{$currentRoute == "posts.index" ? 'active open' :''}}">
                                <a href="{{route('posts.index')}}" class="menu-link">
                                    <div data-i18n="List">مشاهده همه</div>
                                </a>
                            </li>
                        @endcan
                        @can('see-post-trash')
                            <li class="menu-item {{$currentRoute == "posts.trash" ? 'active open' :''}}">
                                <a href="{{route('posts.trash')}}" class="menu-link">
                                    <div data-i18n="List">زباله‌دان</div>
                                </a>
                            </li>
                        @endcan
                        @can('add-post')
                            <li class="menu-item {{$currentRoute == "posts.create" ? 'active open' :''}}">
                                <a href="{{route('posts.create')}}" class="menu-link">
                                    <div data-i18n="List">افزودن جدید</div>
                                </a>
                            </li>
                        @endcan
                        @can('manage-post-categories')
                            <li class="menu-item {{str_starts_with($currentRoute,"post-categories") ? 'active open' :''}}">
                                <a href="{{route('post-categories.index')}}" class="menu-link">
                                    <div data-i18n="View">دسته‌بندی‌ها</div>
                                </a>
                            </li>
                        @endcan
                        @can('manage-post-tags')
                            <li class="menu-item {{$currentRoute == "post-tags.index" ? 'active open' :''}}">
                                <a href="{{route('post-tags.index')}}" class="menu-link">
                                    <div data-i18n="Page 1">برچسب‌ها</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
        @endif

        {{-- stories --}}
        @if(\Nwidart\Modules\Facades\Module::has('Story') && \Nwidart\Modules\Facades\Module::isEnabled('Story'))
            @if($admin->can('manage-stories'))
                <li class="menu-item {{str_starts_with($currentRoute,'stories.') ? 'active open' :''}}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bx-play-circle text-warning"></i>
                        <div data-i18n="Users">داستان ها</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{$currentRoute == "stories.index" ? 'active open' :''}}">
                            <a href="{{route('stories.index')}}" class="menu-link">
                                <div data-i18n="List">مشاهده همه</div>
                            </a>
                        </li>
                        <li class="menu-item {{$currentRoute == "stories.create" ? 'active open' :''}}">
                            <a href="{{route('stories.create')}}" class="menu-link">
                                <div data-i18n="List">افزودن داستان جدید</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endif
        @endif

        {{-- pages --}}
        @if($admin->can('see-pages') || $admin->can('see-page-trash') || $admin->can('add-page'))
            <li class="menu-item {{str_starts_with($currentRoute,'pages.') ? 'active open' :''}}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-news"></i>
                    <div data-i18n="Invoice">برگه ها</div>
                </a>
                <ul class="menu-sub">
                    @can('see-page')
                        <li class="menu-item {{$currentRoute == "pages.index" ? 'active open' :''}}">
                            <a href="{{route('pages.index')}}" class="menu-link">
                                <div data-i18n="List">مشاهده همه</div>
                            </a>
                        </li>
                    @endcan
                    @can('see-page-trash')
                        <li class="menu-item {{$currentRoute == "pages.trash" ? 'active open' :''}}">
                            <a href="{{route('pages.trash')}}" class="menu-link">
                                <div data-i18n="List">زباله‌دان</div>
                            </a>
                        </li>
                    @endcan
                    @can('add-page')
                        <li class="menu-item {{$currentRoute == "pages.create" ? 'active open' :''}}">
                            <a href="{{route('pages.create')}}" class="menu-link">
                                <div data-i18n="Preview">افزودن مورد جدید</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

        {{-- files --}}
        @can('filemanager-access')
            <li class="menu-item {{str_starts_with($currentRoute,'files.') ? 'active open' :''}}">
                <a href="{{route('files.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-file text-primary"></i>
                    <div data-i18n="Invoice">مدیریت فایل ها</div>
                </a>
            </li>
        @endcan

        {{-- tickets --}}
        @can('manage-tickets')
            <li class="menu-item {{str_starts_with($currentRoute,'tickets.') ? 'active open' :''}}">
                <a href="{{route('tickets.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-support"></i>
                    <div data-i18n="Invoice">تیکت ها</div>
                    @php $pendingTickets = \Modules\Tickets\Entities\Ticket::where('status','pending')->orWhere('status','user_response')->get()->count(); @endphp
                    @if($pendingTickets > 0)
                        <span
                            class="badge rounded-pill bg-danger text-white badge-notifications badge-static ms-3">{{$pendingTickets}}</span>
                    @endif
                </a>
            </li>
        @endcan

        {{-- coupons --}}
        @if(\Nwidart\Modules\Facades\Module::has('Coupons') && \Nwidart\Modules\Facades\Module::isEnabled('Coupons'))
            @can('manage-coupons')
                <li class="menu-item {{str_starts_with($currentRoute,'coupons.') ? 'active open' :''}}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bxs-discount"></i>
                        <div data-i18n="Invoice">کد های تخفیف</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{$currentRoute == "coupons.index" ? 'active open' :''}}">
                            <a href="{{route('coupons.index')}}" class="menu-link">
                                <div data-i18n="List">لیست کدهای تخفیف</div>
                            </a>
                        </li>
                        <li class="menu-item {{$currentRoute == "coupons.create" ? 'active open' :''}}">
                            <a href="{{route('coupons.create')}}" class="menu-link">
                                <div data-i18n="Preview">افزودن مورد جدید</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        @endif

        {{-- orders --}}
        @can('see-orders')
            <li class="menu-item {{$currentRoute == "orders.index" ? 'active open' :''}}">
                <a href="{{route('orders.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bxs-shopping-bag-alt"></i>
                    <div data-i18n="Page 1">سفارشات</div>
                    @php $pendingOrders = \Modules\Orders\Entities\Order::where('status','ongoing')->get()->count(); @endphp
                    @if($pendingOrders > 0)
                        <span
                                class="badge rounded-pill bg-danger text-white badge-notifications badge-static ms-3">{{$pendingOrders}}</span>
                    @endif
                </a>
            </li>
        @endcan

        {{-- users --}}
        @if(\Nwidart\Modules\Facades\Module::has('Users') && \Nwidart\Modules\Facades\Module::isEnabled('Users'))
            @if($admin->can('see-users') || $admin->can('add-user'))
                <li class="menu-item {{str_starts_with($currentRoute,'users.') ? 'active open' :''}}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bxs-group"></i>
                        <div data-i18n="Invoice">مشتریان</div>
                    </a>
                    <ul class="menu-sub">
                        @can('see-users')
                            <li class="menu-item {{$currentRoute == "users.index" ? 'active open' :''}}">
                                <a href="{{route('users.index')}}" class="menu-link">
                                    <div data-i18n="List">لیست مشتریان</div>
                                </a>
                            </li>
                        @endcan
                        @can('add-user')
                            <li class="menu-item {{$currentRoute == "users.create" ? 'active open' :''}}">
                                <a href="{{route('users.create')}}" class="menu-link">
                                    <div data-i18n="Preview">ثبت نام مشتری جدید</div>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
        @endif


        {{-- admins --}}
        @can('manage-account')
            <li class="menu-item {{(str_starts_with($currentRoute,'admins.') || str_starts_with($currentRoute,'roles.')) || str_starts_with($currentRoute,'permissions.') ? 'active open' :''}}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-group"></i>
                    <div data-i18n="Invoice">مدیرها</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{$currentRoute == "admins.index" ? 'active open' :''}}">
                        <a href="{{route('admins.index')}}" class="menu-link">
                            <div data-i18n="List">لیست مدیران</div>
                        </a>
                    </li>
                    <li class="menu-item {{$currentRoute == "admins.create" ? 'active open' :''}}">
                        <a href="{{route('admins.create')}}" class="menu-link">
                            <div data-i18n="Preview">ثبت نام مدیر جدید</div>
                        </a>
                    </li>
                    <li class="menu-item {{$currentRoute == "roles.index" ? 'active open' :''}}">
                        <a href="{{route('roles.index')}}" class="menu-link">
                            <div data-i18n="Preview">نقش‌ها و مجوزهای دسترسی</div>
                        </a>
                    </li>
                    {{--                <li class="menu-item {{$currentRoute == "permissions.index" ? 'active open' :''}}">--}}
                    {{--                    <a href="{{route('permissions.index')}}" class="menu-link">--}}
                    {{--                        <div data-i18n="Preview">مجوزها</div>--}}
                    {{--                    </a>--}}
                    {{--                </li>--}}
                </ul>
            </li>
        @endcan

        {{-- comments --}}
        @if(\Nwidart\Modules\Facades\Module::has('Comments') && \Nwidart\Modules\Facades\Module::isEnabled('Comments'))
            @can('manage-comments')
                <li class="menu-item {{$currentRoute == "comments.index" ? 'active open' :''}}">
                    <a href="{{route('comments.index')}}" class="menu-link">
                        <i class="menu-icon tf-icons bx bxs-message-alt-detail"></i>
                        <div data-i18n="Page 1">دیدگاه‌ها</div>
                        @php $pendingComments = \Modules\Comments\Entities\Comment::where('status','pending')->get()->count(); @endphp
                        @if($pendingComments > 0)
                            <span
                                    class="badge rounded-pill bg-danger text-white badge-notifications badge-static ms-3">{{$pendingComments}}</span>
                        @endif
                    </a>
                </li>
            @endcan
        @endif

        {{-- questions --}}
        @can('manage-questions')
            <li class="menu-item {{$currentRoute == "questions.index" ? 'active open' :''}}">
                <a href="{{route('questions.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-question-mark"></i>
                    <div data-i18n="Page 1">پرسش‌وپاسخ‌ها</div>
                    @php $pendingQuestions = \Modules\Questions\Entities\Question::where('status','pending')->get()->count(); @endphp
                    @if($pendingQuestions > 0)
                        <span
                                class="badge rounded-pill bg-danger text-white badge-notifications badge-static ms-3">{{$pendingQuestions}}</span>
                    @endif
                </a>
            </li>
        @endcan

        {{-- page builder --}}
        @can('manage-menus')
            <li class="menu-item {{$currentRoute == "templates.index" ? 'active open' :''}}">
                <a href="{{route('templates.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-layout"></i>
                    <div data-i18n="Page 1">قالب ها</div>
                </a>
            </li>
        @endcan


        {{-- menus --}}
        @can('manage-menus')
            <li class="menu-item {{$currentRoute == "menus.index" ? 'active open' :''}}">
                <a href="{{route('menus.index')}}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-menu"></i>
                    <div data-i18n="Page 1">منوها</div>
                </a>
            </li>
        @endcan

        {{-- banners --}}
        @if(\Nwidart\Modules\Facades\Module::has('Banners') && \Nwidart\Modules\Facades\Module::isEnabled('Banners'))
            @can('manage-banners')
                <li class="menu-item {{str_starts_with($currentRoute,'banners.') ? 'active open' :''}}">
                    <a href="javascript:void(0);" class="menu-link menu-toggle">
                        <i class="menu-icon tf-icons bx bxs-image"></i>
                        <div data-i18n="Invoice">مدیریت بنرها</div>
                    </a>
                    <ul class="menu-sub">
                        <li class="menu-item {{$currentRoute == "banners.index" ? 'active open' :''}}">
                            <a href="{{route('banners.index')}}" class="menu-link">
                                <div data-i18n="List">لیست بنر ها</div>
                            </a>
                        </li>
                        <li class="menu-item {{$currentRoute == "banners.create" ? 'active open' :''}}">
                            <a href="{{route('banners.create')}}" class="menu-link">
                                <div data-i18n="Preview">آپلود بنر جدید</div>
                            </a>
                        </li>
                    </ul>
                </li>
            @endcan
        @endif

        {{-- tools --}}
        @if($admin->hasRole('super-admin'))
        <li class="menu-item {{str_starts_with($currentRoute,'tools.') ? 'active open' :''}}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-file-import"></i>
                <div data-i18n="Invoice">ابزار ها</div>
            </a>
            @can('import-data')
            <ul class="menu-sub">
                <li class="menu-item {{$currentRoute == "tools.import" ? 'active open' :''}}">
                    <a href="{{route('tools.import')}}" class="menu-link">
                        <div data-i18n="List">درون ریزی</div>
                    </a>
                </li>
            </ul>
            @endcan
            @can('manage-redirects')
            <ul class="menu-sub">
                <li class="menu-item {{$currentRoute == "redirects.import" ? 'active open' :''}}">
                    <a href="{{route('redirects.index')}}" class="menu-link">
                        <div data-i18n="List">ریدایرکت ها</div>
                    </a>
                </li>
            </ul>
            @endif
        </li>
        @endif

        {{-- settings --}}
        @if($admin->can('edit-setting-general') || $admin->can('edit-setting-header') || $admin->can('edit-setting-footer')
    || $admin->can('edit-setting-payment') || $admin->can('edit-setting-shipping') || $admin->can('edit-setting-sms') || $admin->can('edit-setting-signin') || $admin->can('edit-setting-appearance')
    || $admin->can('edit-setting-factor')|| $admin->can('edit-setting-config'))
            <li class="menu-item mb-5 {{str_starts_with($currentRoute,'settings.') ? 'active open' :''}}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons bx bxs-cog"></i>
                    <div data-i18n="Invoice">تنظیمات</div>
                </a>
                <ul class="menu-sub">
                    @can('edit-setting-general')
                        <li class="menu-item {{$currentRoute == "settings.general" ? 'active open' :''}}">
                            <a href="{{route('settings.general')}}" class="menu-link">
                                <div data-i18n="List">عمومی</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-appearance')
                        <li class="menu-item {{$currentRoute == "settings.appearance" ? 'active open' :''}}">
                            <a href="{{route('settings.appearance')}}" class="menu-link">
                                <div data-i18n="List">ظاهر سایت</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-header')
                        <li class="menu-item {{$currentRoute == "settings.header" ? 'active open' :''}}">
                            <a href="{{route('settings.header')}}" class="menu-link">
                                <div data-i18n="List">سربرگ</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-footer')
                        <li class="menu-item {{$currentRoute == "settings.footer" ? 'active open' :''}}">
                            <a href="{{route('settings.footer')}}" class="menu-link">
                                <div data-i18n="List">پابرگ</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-signin')
                        <li class="menu-item {{$currentRoute == "settings.signin" ? 'active open' :''}}">
                            <a href="{{route('settings.signin')}}" class="menu-link">
                                <div data-i18n="List">صفحه ورود</div>
                            </a>
                        </li>
                    @endcan
                    <!-- @can('edit-setting-shipping')
                        <li class="menu-item {{$currentRoute == "settings.shipping" ? 'active open' :''}}">
                            <a href="{{route('settings.shipping')}}" class="menu-link">
                                <div data-i18n="List">حمل و نقل</div>
                            </a>
                        </li>
                    @endcan -->
                    @can('edit-setting-payment')
                        <li class="menu-item {{$currentRoute == "settings.payment" ? 'active open' :''}}">
                            <a href="{{route('settings.payment')}}" class="menu-link">
                                <div data-i18n="Preview">درگاه پرداخت</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-sms')
                        <li class="menu-item {{$currentRoute == "settings.sms" ? 'active open' :''}}">
                            <a href="{{route('settings.sms')}}" class="menu-link">
                                <div data-i18n="Preview">پیامک</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-notifications')
                        <li class="menu-item {{$currentRoute == "settings.notifications" ? 'active open' :''}}">
                            <a href="{{route('settings.notifications')}}" class="menu-link">
                                <div data-i18n="Preview">اطلاع رسانی ها</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-factor')
                        <li class="menu-item {{$currentRoute == "settings.factor" ? 'active open' :''}}">
                            <a href="{{route('settings.factor')}}" class="menu-link">
                                <div data-i18n="Preview">فاکتور فروش</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-seo')
                        <li class="menu-item {{$currentRoute == "settings.seo" ? 'active open' :''}}">
                            <a href="{{route('settings.seo')}}" class="menu-link">
                                <div data-i18n="Preview">سئو</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-advanced')
                        <li class="menu-item {{$currentRoute == "settings.advanced" ? 'active open' :''}}">
                            <a href="{{route('settings.advanced')}}" class="menu-link">
                                <div data-i18n="Preview">پیشرفته</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-config')
                        <li class="menu-item {{$currentRoute == "settings.config" ? 'active open' :''}}">
                            <a href="{{route('settings.config')}}" class="menu-link">
                                <div data-i18n="Preview">کانفیگ</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-shipping')
                        <li class="menu-item {{$currentRoute == "settings.denooj-shipping" ? 'active open' :''}}">
                            <a href="{{route('settings.denooj-shipping')}}" class="menu-link">
                                <div data-i18n="List">حمل و نقل دنوج</div>
                            </a>
                        </li>
                    @endcan
                    @can('edit-setting-sms')
                        <li class="menu-item {{$currentRoute == "settings.denooj-sms" ? 'active open' :''}}">
                            <a href="{{route('settings.denooj-sms')}}" class="menu-link">
                                <div data-i18n="List">پیامک حمل و نقل دنوج</div>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
        @endif

    </ul>
</aside>
