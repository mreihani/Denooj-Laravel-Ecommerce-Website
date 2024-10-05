<footer class="container-fluid footer-bg">
    <div class="custom-container">
        <!-- boxes -->
        <div class="footer-icon-boxes">
            <div class="box-icon">
                <a class="text-decoration-none" href="https://www.denooj.com/page/garanti/">
                    @if($footerSettings->footer_icon3)
                        <img src="{{ $footerSettings->footer_icon3}}" alt="{{$footerSettings->footer_icon3_title}}">
                    @endif
                    <span class="title">{{$footerSettings->footer_icon3_title}}</span>
                </a>
            </div>
            <div class="custom-separator"></div>
            <div class="box-icon">
                <a class="text-decoration-none" href="https://www.denooj.com/page/send/">
                    @if($footerSettings->footer_icon4)
                        <img src="{{ $footerSettings->footer_icon4}}" alt="{{$footerSettings->footer_icon4_title}}">
                    @endif
                    <span class="title">{{$footerSettings->footer_icon4_title}}</span>
                </a>
            </div>
        </div>

        <div class="row">
            
            <!-- @php $list1 = \Modules\MenuBuilder\Entities\Menu::Location('footer_list1')->first(); @endphp
            @php $list2 = \Modules\MenuBuilder\Entities\Menu::Location('footer_list2')->first(); @endphp
            @php $list3 = \Modules\MenuBuilder\Entities\Menu::Location('footer_list3')->first(); @endphp
             -->
            <div class="row">
                <!-- <div class="col-lg-3 col-md-6 ">
                    <div class="footer-box">
                        <div class="title">{{$footerSettings->footer_box1_title}}</div>
                        @if($list1)
                            <ul>
                                @foreach($list1->items()->where('parent_id',null)->get() as $item)
                                    <li><a href="{{ $item->link }}"
                                            title="{{ $item->title }}">{{ $item->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ">
                    <div class="footer-box">
                        <div class="title">{{$footerSettings->footer_box2_title}}</div>
                        @if($list2)
                            <ul>
                                @foreach($list2->items()->where('parent_id',null)->get() as $item)
                                    <li><a href="{{ $item->link }}"
                                            title="{{ $item->title }}">{{ $item->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 ">
                    <div class="footer-box">
                        <div class="title">{{$footerSettings->footer_box3_title}}</div>
                        @if($list3)
                            <ul>
                                @foreach($list3->items()->where('parent_id',null)->get() as $item)
                                    <li><a href="{{ $item->link }}"
                                            title="{{ $item->title }}">{{ $item->title }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div> -->
                
                <div class="col-12">
                    <div class="row d-flex justify-content-center">

                        <div class="d-flex col-lg-3">
                            <div class="">
                                <div class="footer-box latest">
                                    <!-- <div class="title mb-3">{{$footerSettings->footer_box4_title}}</div> -->
                                    <div class="footer-logos">
                                        {!! $footerSettings->footer_html !!}
                                    </div>
                                </div>
                            </div>

                            <div class="">
                                <div class="footer-box latest">
                                    <!-- <div class="title mb-3">نماد اتحادیه</div> -->
                                    <div class="footer-logos">
                                        <img style="width:100px;" src="{{asset('assets/images/logonama.png')}}" alt="">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-md-0 mb-4">
                            <span class="d-block mb-2 mt-3 me-3">{{$footerSettings->footer_social_title}}</span>
                            <div class="d-flex align-items-center flex-wrap">
                                @if($generalSettings->instagram)
                                    <a rel="nofollow" href="{{$generalSettings->instagram}}" class="custom-icon-btn me-2"
                                        title="اینستاگرام"><i class="icon-instagram"></i></a>
                                @endif
                                @if($generalSettings->telegram)
                                    <a rel="nofollow" href="{{$generalSettings->telegram}}" class="custom-icon-btn me-2"
                                        title="تلگرام"><i class="icon-telegram"></i></a>
                                @endif
                                <!-- @if($generalSettings->whatsapp)
                                    <a rel="nofollow" href="{{$generalSettings->whatsapp}}" class="custom-icon-btn me-2"
                                        title="واتساپ"><i class="icon-whatsapp"></i></a>
                                @endif -->
                                <a rel="nofollow" href="https://eitaa.com/denooj" class="custom-icon-btn me-2"
                                        title="ایتا">
                                    <i class="icon-eitaa-com"></i>
                                </a>
                                <a rel="nofollow" href="https://splus.ir/denooj" class="custom-icon-btn me-2"
                                        title="سروش">
                                    <i class="icon-Soroush-black"></i>
                                </a>
                                <a rel="nofollow" href="https://ble.ir/join/EiT2FWE2PG" class="custom-icon-btn me-2"
                                        title="بله">
                                    <i class="icon-bale-black"></i>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex align-items-center">
                                <i class="icon-phone-call font-30 me-3 color-main"></i>
                                <div class="d-flex flex-column">
                                    <span class="font-18 fw-800">
                                        <a class="text-decoration-none text-dark" href="tel:{{$footerSettings->footer_phone}}">
                                            {{$footerSettings->footer_phone}}
                                        </a>
                                    </span>
                                    <span class="font-18 fw-800">
                                        <a class="text-decoration-none text-dark" href="tel:01132191594">
                                            01132191594
                                        </a>
                                    </span>
                                    <span class="fw-300 text-muted font-13">{{$footerSettings->working_hours}}</span>
                                </div>
                            </div>

                            <span class="d-flex w-100 mb-2 mt-3">
                                <i class="icon-home me-2"></i>
                                <span
                                    class="d-inline-block font-13 fw-bold">{{$footerSettings->footer_address}}
                                </span>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
           

        </div>
        <div class="copyright d-flex justify-content-center">
            <div>
                {!! $footerSettings->footer_copyright !!}
            </div>
            <div>
                {!! $footerSettings->footer_designer !!}
            </div>
        </div>
    </div>
</footer>
