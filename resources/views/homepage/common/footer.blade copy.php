<footer>
    <div class="footr-area theme-bg pt-65">
        <div class="tp-footer-eligible">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="tp-eligible-item text-center">
                            <div class="tp-section text-center fs-40">
                                <span><img src="{{asset('frontend/ncare/assets/img/shape/section-shape-1.svg')}}" alt="contact"></span>
                                <h5 class="tp-section-subtitle">Liên hệ ngay với chúng tôi - Hotline</h5>
                                <h3 class="tp-section-title pb-5">{{$fcSystem['contact_hotline']}}</h3>
                            </div>
                            <div class="tp-eligible-shape">
                                <div class="tp-eligible-shape-1">
                                    <img src="{{asset('frontend/ncare/assets/img/shape/footer-eligible-shape-1.png')}}" alt="shape">
                                </div>
                                <div class="tp-eligible-shape-2">
                                    <img src="{{asset('frontend/ncare/assets/img/shape/footer-eligible-shape-2.png')}}" alt="shape">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="tp-eligible-item tp-eligible-item-2 text-center mb-40">
                            <a href="{{route('pageF.order')}}" class="">
                                <div class="tp-section text-center fs-40">
                                    <span><img src="{{asset('frontend/ncare/assets/img/shape/section-shape-2.svg')}}" alt="shape"></span>
                                    <h5 class="tp-section-subtitle">{{$fcSystem['title_0']}}</h5>
                                    <h3 class="tp-section-title pb-5">{{$fcSystem['title_1']}}</h3>
                                </div>
                                <div class="tp-eligible-shape">
                                    <div class="tp-eligible-shape-1">
                                        <img src="{{asset('frontend/ncare/assets/img/shape/footer-eligible-shape-3.png')}}" alt="shape">
                                    </div>
                                    <div class="tp-eligible-shape-2">
                                        <img src="{{asset('frontend/ncare/assets/img/shape/footer-eligible-shape-4.png')}}" alt="shape">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-top mt-40">
            <div class="container">
                <div class="row row-1">
                    <div class="col-lg-3 col-md-6">
                        <div class="tp-footer-widget tp-footer-2-col-1 mb-65">
                            <div class="tp-footer-widget-logo mb-20">
                                <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo_footer'])}}" alt="fw-logo"></a>
                            </div>
                            <div class="tp-footer-widget-content">
                                <p>{{$fcSystem['homepage_company']}}</p>
                                <div class="tp-footer-widget-content-list">
                                    <div class="tp-footer-widget-content-list-item d-flex align-items-start mb-10">
                                        <i class="fa-solid fa-location-dot"></i> <a target="_blank" href="">{{$fcSystem['contact_address']}}</a>
                                    </div>
                                    <div class="tp-footer-widget-content-list-item d-flex align-items-start">
                                        <i class="fa-solid fa-envelope"></i> <a href="mailto:{{$fcSystem['contact_email']}}"><span class="__cf_email__">{{$fcSystem['contact_email']}}</span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9 col-sm-9 col-12">
                        <div class="row">
                            <?php
                            $menu_footer = getMenus('menu-footer');
                            ?>
                            @if(!empty($menu_footer->menu_items) && count($menu_footer->menu_items) > 0)
                            @foreach($menu_footer->menu_items as $item)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="tp-footer-widget tp-footer-2-col-2 mb-65">
                                    <h4 class="tp-footer-widget-title mb-30">{{$item->title}}</h4>
                                    <div class="tp-footer-widget-link">
                                        <ul>
                                            @if(!empty($item->children) && count($item->children) > 0)
                                            @foreach($item->children as $child)
                                            <li><a href="{{url($child->slug)}}">{{$child->title}}</a></li>
                                            @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif

                            <div class="row row-2">
                                <div class="col-lg-4 col-md-6">
                                    <div class="tp-footer-widget tp-footer-2-col-4 mb-65">
                                        <h4 class="tp-footer-widget-title mb-40">{{$fcSystem['title_2']}}</h4>
                                        <div class="tp-footer-widget-newsletter">

                                            <div class="tp-footer-widget-newsletter-content">
                                                <p>Giờ mở cửa</p>
                                                <span>{{$fcSystem['contact_time']}}</span>
                                                <span>{!!$fcSystem['contact_time_2']!!}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="tp-footer-widget tp-footer-2-col-4 mb-65">
                                        <h4 class="tp-footer-widget-title mb-40">Facebook</h4>
                                        <div class="tp-footer">
                                            <iframe src="https://www.facebook.com/plugins/page.php?href={{$fcSystem['social_facebook']}}&tabs=timeline&width=340&height=500&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId=343876996017079" width="340" height="500" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <div class="tp-footer-widget tp-footer-2-col-4 mb-65">
                                        <h4 class="tp-footer-widget-title mb-40">Map</h4>
                                        <div class="tp-footer">
                                            {!!$fcSystem['contact_map']!!}
                                        </div>

                                    </div>
                                </div>
                            </div>




                        </div>
                    </div>

                </div>
            </div>
            <div class="tp-footer-bottom">
                <div class="container">
                    <div class="tp-footer-bottom-wrap">
                        <div class="row align-items-center">
                            <div class="col-lg-4 col-md-4">
                                <div class="tp-footer-copyright text-center text-md-start">
                                    <p><span>© <?php echo date('Y') ?></span><a target="_blank" href="javascript:void(0)">Copyright.</a>{{$fcSystem['homepage_company']}} </p>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="tp-footer-social text-center">
                                    @if(!empty($fcSystem['social_facebook']))
                                    <a href="{{$fcSystem['social_facebook']}}" target="_blank"><i class="fa-brands fa-facebook-f"></i></a>
                                    @endif
                                    @if(!empty($fcSystem['social_youtube']))
                                    <a href="{{$fcSystem['social_youtube']}}" target="_blank"><i class="fa-brands fa-youtube"></i></a>
                                    @endif
                                    @if(!empty($fcSystem['social_twitter']))
                                    <a href="{{$fcSystem['social_twitter']}}" target="_blank"><i class="fa-brands fa-twitter"></i></a>
                                    @endif
                                    @if(!empty($fcSystem['social_vimeo']))
                                    <a href="{{$fcSystem['social_vimeo']}}" target="_blank"><i class="fa-brands fa-vimeo-v"></i></a>
                                    @endif
                                    @if(!empty($fcSystem['social_pinterest']))
                                    <a href="{{$fcSystem['social_pinterest']}}" target="_blank"><i class="fa-brands fa-pinterest-p"></i></a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4">
                                <div class="tp-footer-terms text-center text-md-end">
                                    <a href="javascript:void(0)">Điều khoản sử dụng</a>
                                    <a href="javascript:void(0)">Chính sách bảo mật</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</footer>
<script src="{{asset('frontend/ncare/assets/js/vendor/jquery.js')}}"></script>
{{--<script src="{{asset('frontend/ncare/assets/js/vendor/waypoints.js')}}"></script>--}}
<script src="{{asset('frontend/ncare/assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('frontend/ncare/assets/js/meanmenu.js')}}"></script>
<script src="{{asset('frontend/ncare/assets/js/swiper-bundle.js')}}"></script>
{{--<script src="{{asset('frontend/ncare/assets/js/slick.js')}}"></script>--}}
{{--<script src="{{asset('frontend/ncare/assets/js/range-slider.js')}}"></script>--}}
{{--<script src="{{asset('frontend/ncare/assets/js/magnific-popup.js')}}"></script>--}}
{{--<script src="{{asset('frontend/ncare/assets/js/nice-select.js')}}"></script>--}}
{{--<script src="{{asset('frontend/ncare/assets/js/countdown.js')}}"></script>--}}
<script src="{{asset('frontend/ncare/assets/js/wow.js')}}"></script>
{{--<script src="{{asset('frontend/ncare/assets/js/isotope-pkgd.js')}}"></script>--}}
{{--<script src="{{asset('frontend/ncare/assets/js/imagesloaded-pkgd.js')}}"></script>--}}
{{--<script src="{{asset('frontend/ncare/assets/js/ajax-form.js')}}"></script>--}}
<script src="{{asset('frontend/ncare/assets/js/main.js')}}"></script>
<style>

</style>
