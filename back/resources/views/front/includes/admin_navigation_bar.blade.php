@if(auth()->guard('admin')->check())
    @php $admin = auth()->guard('admin')->user(); @endphp
    <div class="admin-navbar">
        <div class="admin-navbar-bg"></div>
        <div class="custom-container">
            <div class="admin-navbar-content">
                <div class="backdrop admin-nav-backdrop"></div>

                {{-- mobile nav toggle --}}
                <span class="admin-nav-toggle">
                    <i class="icon-menu"></i>
                </span>

                {{-- menu items --}}
                <ul class="admin-navbar-items">
                    {{-- products --}}
                    @if($admin->can('see-products') || $admin->can('add-product') || $admin->can('see-product-trash'))
                        <li class="has-children"><a href="#"><i class="icon-layers me-2"></i><span>محصولات</span></a>
                            <ul>
                                @if($admin->can('see-products'))
                                    <li><a href="{{route('products.index')}}"><i
                                                class="icon-list me-2"></i><span>لیست محصولات</span></a></li>
                                @endif
                                @if($admin->can('add-product'))
                                    <li><a href="{{route('products.create')}}"><i class="icon-plus me-2"></i><span>افزودن محصول جدید</span></a>
                                    </li>
                                @endif
                                @if($admin->can('see-product-trash'))
                                    <li><a href="{{route('products.trash')}}"><i
                                                class="icon-trash me-2"></i><span>زباله‌دان</span></a></li>
                                @endif
                                @if($admin->can('manage-categories'))
                                    <li><a href="{{route('categories.index')}}"><i
                                                class="icon-grid me-2"></i><span>دسته‌بندی‌ها</span></a></li>
                                @endif
                                @if($admin->can('manage-tags'))
                                    <li><a href="{{route('tags.index')}}"><i
                                                class="icon-tag me-2"></i><span>برچسب‌ها</span></a>
                                    </li>
                                @endif
                                @if($admin->can('manage-attributes'))
                                    <li><a href="{{route('attributes.index')}}"><i
                                                class="icon-circle me-2"></i><span>ویژگی‌ها</span></a></li>
                                @endif
                                @if($admin->can('manage-product-colors'))
                                    <li><a href="{{route('product-colors.index')}}"><i
                                                class="icon-circle me-2"></i><span>رنگ‌ها</span></a></li>
                                @endif
                                @if($admin->can('manage-product-sizes'))
                                    <li><a href="{{route('product-sizes.index')}}"><i
                                                class="icon-circle me-2"></i><span>سایزها</span></a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- posts --}}
                    @if($admin->can('see-posts') || $admin->can('see-post-trash') || $admin->can('add-post') || $admin->can('manage-post-categories'))
                        <li class="has-children"><a href="#"><i class="icon-book-open me-2"></i><span>مقالات</span></a>
                            <ul>
                                @if($admin->can('see-posts'))
                                    <li><a href="{{route('posts.index')}}"><i
                                                class="icon-list me-2"></i><span>لیست مقالات</span></a></li>
                                @endif
                                @if($admin->can('see-post-trash'))
                                    <li><a href="{{route('posts.trash')}}"><i class="icon-trash me-2"></i><span>زباله‌دان</span></a>
                                    </li>
                                @endif
                                @if($admin->can('add-post'))
                                    <li><a href="{{route('posts.create')}}"><i class="icon-plus me-2"></i><span>افزودن مقاله جدید</span></a>
                                    </li>
                                @endif
                                @if($admin->can('manage-post-categories'))
                                    <li><a href="{{route('post-categories.index')}}"><i
                                                class="icon-grid me-2"></i><span>دسته‌بندی‌ها</span></a>
                                    </li>
                                @endif
                                @if($admin->can('manage-post-tags'))
                                    <li><a href="{{route('post-tags.index')}}"><i
                                                class="icon-tag me-2"></i><span>برچسب‌ها</span></a></li>
                                @endif
                            </ul>
                        </li>
                    @endif

                    {{-- settings --}}
                    @if($admin->can('edit-setting-general') || $admin->can('edit-setting-header') || $admin->can('edit-setting-footer')
                    || $admin->can('edit-setting-payment') || $admin->can('edit-setting-shipping') || $admin->can('edit-setting-sms')
                    || $admin->can('edit-setting-signin') || $admin->can('edit-setting-appearance')
                    || $admin->can('edit-setting-factor')|| $admin->can('edit-setting-config'))
                        <li class="has-children"><a href="#"><i class="icon-settings me-2"></i><span>تنظیمات سایت</span></a>
                            <ul>
                                @if($admin->can('edit-setting-general'))
                                    <li><a href="{{route('settings.general')}}"><i
                                                class="icon-square me-2"></i><span>عمومی</span></a></li>
                                @endif

                                @if($admin->can('edit-setting-appearance'))
                                    <li><a href="{{route('settings.appearance')}}"><i
                                                class="icon-pen-tool me-2"></i><span>ظاهر سایت</span></a>
                                    </li>
                                @endif

                                @if($admin->can('edit-setting-header'))
                                    <li><a href="{{route('settings.header')}}"><i
                                                class="icon-layout me-2"></i><span>سربرگ</span></a></li>
                                @endif

                                @if($admin->can('edit-setting-footer'))
                                    <li><a href="{{route('settings.footer')}}"><i
                                                class="icon-layout me-2"></i><span>پابرگ</span></a></li>
                                @endif

                                @if($admin->can('edit-setting-signin'))
                                    <li><a href="{{route('settings.signin')}}"><i class="icon-log-in me-2"></i><span>صفحه ورود</span></a>
                                    </li>
                                @endif

                                @if($admin->can('edit-setting-shipping'))
                                    <li><a href="{{route('settings.shipping')}}"><i class="icon-truck me-2"></i><span>حمل و نقل</span></a>
                                    </li>
                                @endif

                                @if($admin->can('edit-setting-payment'))
                                    <li><a href="{{route('settings.payment')}}"><i class="icon-credit-card me-2"></i><span>درگاه پرداخت</span></a>
                                    </li>
                                @endif

                                @if($admin->can('edit-setting-sms'))
                                    <li><a href="{{route('settings.sms')}}"><i
                                                class="icon-message-square me-2"></i><span>پیامک</span></a></li>
                                @endif

                                @if($admin->can('edit-setting-notifications'))
                                    <li><a href="{{route('settings.notifications')}}"><i
                                                class="icon-bell me-2"></i><span>اطلاع رسانی ها</span></a>
                                    </li>
                                @endif

                                @if($admin->can('edit-setting-factor'))
                                    <li><a href="{{route('settings.factor')}}"><i class="icon-file-text me-2"></i><span>فاکتور فروش</span></a>
                                    </li>
                                @endif

                                @if($admin->can('edit-setting-seo'))
                                    <li><a href="{{route('settings.seo')}}"><i
                                                class="icon-bar-chart-2 me-2"></i><span>سئو</span></a>
                                    </li>
                                @endif

                                @if($admin->can('edit-setting-advanced'))
                                    <li><a href="{{route('settings.advanced')}}"><i class="icon-circle me-2"></i><span>پیشرفته</span></a>
                                    </li>
                                @endif

                                @if($admin->can('edit-setting-config'))
                                    <li><a href="{{route('settings.config')}}"><i
                                                class="icon-circle me-2"></i><span>کانفیگ</span></a></li>
                                @endif

                            </ul>
                        </li>
                    @endif

                    {{-- edit product --}}
                    @if($currentRouteName == 'product.show' && $admin->can('edit-product') && isset($product))
                        <li><a href="{{route('products.edit',$product)}}"><i class="icon-edit-2 me-2"></i><span>ویرایش محصول</span></a></li>
                    @endif

                    {{-- edit post --}}
                    @if($currentRouteName == 'post.show' && $admin->can('edit-post') && isset($post))
                        <li><a href="{{route('posts.edit',$post)}}"><i class="icon-edit-2 me-2"></i><span>ویرایش مقاله</span></a></li>
                    @endif

                    {{-- edit page --}}
                    @if($currentRouteName == 'page.show' && $admin->can('edit-page') && isset($page))
                        <li><a href="{{route('pages.edit',$page)}}"><i class="icon-edit-2 me-2"></i><span>ویرایش برگه</span></a></li>
                    @endif

                    {{-- edit home template --}}
                    @if($currentRouteName == 'home' && $admin->can('manage-templates') && isset($template))
                        <li><a href="{{route('templates.edit',$template)}}"><i class="icon-edit-2 me-2"></i><span>ویرایش قالب</span></a></li>
                    @endif
                </ul>

                {{-- user button --}}
                <div class="admin-navbar-user-button">
                    <img src="{{$admin->getAvatar()}}" alt="{{$admin->name}}">
                    <span class="name">{{$admin->name}}</span>
                    <div class="admin-navbar-user-dropdown">
                        <a href="{{route('admin.profile')}}"><i class="icon-user me-2"></i><span>ویرایش اطلاعات کاربری</span></a>
                        <a href="{{route('admin.logout')}}"><i class="icon-log-out me-2"></i><span>خارج شوید</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
