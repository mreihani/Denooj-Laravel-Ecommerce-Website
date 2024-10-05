<header class="header-container" id="header-container">
    <div class="backdrop menu-backdrop"></div>
    <div class="backdrop search-backdrop"></div>
    <div class="custom-container">
        {{-- header up section --}}
        <div class="header-up">
            {{-- brand logo --}}
            <a href="{{url('')}}" class="header-logo"><img src="{{$headerSettings->getHeaderLogo()}}"
                                                           alt="{{config('app.app_name_fa')}}"></a>

            {{-- search box --}}
            @include('front.includes.header_search',['inputId' => 'headerSearchInput'])

            {{-- left content --}}
            @include('front.includes.header_left_content')
        </div>

        {{-- header down section --}}
        <div class="header-down">

            <div class="menu-items">
                <div class="menu-items-header">
                    {{-- logo --}}
                    <a href="{{url('')}}" class="logo"><img src="{{$headerSettings->getHeaderLogo()}}"
                                                            alt="{{config('app.app_name_fa')}}"></a>

                    {{-- close menu --}}
                    <span class="close" id="close-menu"><i class="icon-x"></i></span>

                    {{-- search form --}}
                    <div class="mobile-search-open">
                        <span>{{$headerSettings->header_search_placeholder}}</span>
                        <i class="icon-search"></i>
                    </div>
                    <div class="mobile-search-container">
                        <div class="d-flex justify-content-between align-items-center">
                            <span>جستجو</span>
                            <span class="close-search"><i class="icon-arrow-left"></i></span>
                        </div>
                        @include('front.includes.header_search',['inputId' => 'mobileSearchInput'])
                    </div>
                </div>

                @php $mainMenu = \Modules\MenuBuilder\Entities\Menu::Location('main_menu')->first(); @endphp

                <nav>
                    <h2 class="d-none">{{$navTitle}}</h2>
                    @if($mainMenu)
                        @foreach($mainMenu->items()->where('parent_id',null)->get() as $menuItem)
                            <div class="menu-item {{$menuItem->items->count() > 0 ? 'has-submenu' : ''}}">
                                <a href="{{ $menuItem->link }}"
                                   title="{{ $menuItem->title }}">{{ $menuItem->title }}</a>
                                @if( $menuItem->items->count() > 0 )
                                    <span class="menu-item-toggle"><i class="icon-plus"></i></span>
                                    <div class="submenu">
                                        <ul>
                                            @foreach( $menuItem->items as $subMenuItem )
                                                <li class="">
                                                    <a href="{{ $subMenuItem->link }}"
                                                       title="{{ $subMenuItem->title }}">{{ $subMenuItem->title }}</a>
                                                    @if( $subMenuItem->items->count() > 0 )
                                                        <!-- level3 menu items -->
                                                        <ul>
                                                            @foreach( $subMenuItem->items as $subSubMenuItem )
                                                                <li><a href="{{ $subSubMenuItem->link }}"
                                                                       title="{{$subSubMenuItem->title}}">{{ $subSubMenuItem->title}}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <span class="text-danger">منوی اصلی انتخاب نشده است!</span>
                    @endif
                </nav>
            </div>

            <!-- left content -->
            @if($headerSettings->display_header_support)
                <div class="header-down-left-content">
                    <div class="d-flex align-items-start"><span>{{$headerSettings->header_support_text}} <a
                                    href="{{$headerSettings->header_support_link}}"
                                    class="color-black text-decoration-none">{{$headerSettings->header_support_link_text}}</a></span><i
                                class="{{$headerSettings->header_support_icon}} ms-2 color-main d-inline-block"></i>
                    </div>
                </div>
            @endif
        </div>
    </div>
</header>
