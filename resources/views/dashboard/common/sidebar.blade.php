<?php $dropdown = getFunctions(); ?>
<nav class="side-nav">
    <div class="pt-4 mb-4">
        <div class="side-nav__header flex items-center">
            <a href="{{route('admin.dashboard')}}" class=" flex items-center">
                <img alt="Rocketman Tailwind HTML Admin Template" class="side-nav__header__logo" src="{{asset('backend/images/logo.svg')}}">
                <span class="side-nav__header__text text-white pt-0.5 text-lg ml-2.5"> {{env('BE_TITLE_SEO')}} </span>
            </a>
            <a href="javascript:;" class="side-nav__header__toggler hidden xl:block ml-auto text-white text-opacity-70 hover:text-opacity-100 transition-all duration-300 ease-in-out pr-5">
                <i data-lucide="arrow-left-circle" class="w-5 h-5"></i>
            </a>
            <a href="javascript:;" class="mobile-menu-toggler xl:hidden ml-auto text-white text-opacity-70 hover:text-opacity-100 transition-all duration-300 ease-in-out pr-5">
                <i data-lucide="x-circle" class="w-5 h-5"></i>
            </a>
        </div>
    </div>
    <div class="scrollable">

        <ul class="scrollable__content">
            <li class="side-nav__devider mb-4">START MENU</li>
            <li>
                <a href="{{route('admin.dashboard')}}" class="side-menu {{ activeMenu('dashboard') }}">
                    <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="side-menu__title">
                        Dashboard
                    </div>
                </a>
            </li>
            @foreach (config('sidebar') as $key=>$item)
            @can(''.$key.'_index')
            @if (in_array($key, $dropdown) && !empty($module))
            @if(!empty($item['data']) && count($item['data']) > 0)
            <li>
                <a href="javascript:void(0)" class="side-menu @if(in_array($module, array_keys($item['data']))) side-menu--active @endif">
                    <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="side-menu__title">
                        {{$item['title']}}
                        <div class="side-menu__sub-icon @if(in_array($module, array_keys($item['data']))) transform rotate-180 @endif">
                            <i data-lucide="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class="@if(in_array($module, array_keys($item['data']))) side-menu__sub-open @endif">
                    @if(!empty($item['data']) && count($item['data']) > 0)
                    @foreach($item['data'] as $k=>$v)
                    @if(!empty($v['active']))
                    @if(!empty($v['dropdown']))
                    @can(''.$k.'_index')
                    @if (in_array($k, $dropdown))
                    <li>
                        <a href="{{ route($v['route']) }}" class="side-menu @foreach($v['menu'] as $menu) {{activeMenu($menu)}} @endforeach">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">{{!empty($v['title'])?$v['title'] : config('permissions')['modules'][$k]}}</div>
                        </a>
                    </li>
                    @endcan
                    @endif
                    @else
                    <li>
                        <a href="{{ route($v['route']) }}" class="side-menu @foreach($v['menu'] as $menu) {{activeMenu($menu)}} @endforeach">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">{{!empty($v['title'])?$v['title'] : config('permissions')['modules'][$k]}}</div>
                        </a>
                    </li>
                    @endif
                    @endif
                    @endforeach
                    @endif
                </ul>
            </li>
            @else
            <li>
                <a href="{{route($item['route'])}}" class="side-menu <?php echo activeMenu($key); ?>">
                    <div class="side-menu__icon">
                        <i data-lucide="box"></i>
                    </div>
                    <div class="side-menu__title"> {{$item['title']}}</div>
                </a>
            </li>
            @endif
            @endif
            @endcan
            @endforeach
            <!-- Start: Cấu hình hệ thống -->
            <li>
                <a href="{{route('generals.index')}}" class="side-menu {{ activeMenu('generals') }} {{ activeMenu('customer-socials') }} {{ activeMenu('orders-config') }} {{ activeMenu('taxes') }} {{ activeMenu('addresses') }} {{ activeMenu('config-emails') }} {{ activeMenu('ships') }} {{ activeMenu('config-images') }}">
                    <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="side-menu__title">
                        Cấu hình
                    </div>
                </a>
            </li>

            @if(env('APP_ENV') == "local" && !empty($module))
            <!-- END: Cấu hình hệ thống -->
            <li class="">
                <a href="{{route('sitemap')}}" class="side-menu" target="_blank">
                    <div class="side-menu__icon">
                        <i data-lucide="box"></i>
                    </div>
                    <div class="side-menu__title">Cập nhập sitemap</div>
                </a>
            </li>

            <li class="">
                <a href="{{route('product_tmps.index')}}" class="side-menu" target="_blank">
                    <div class="side-menu__icon">
                        <i data-lucide="box"></i>
                    </div>
                    <div class="side-menu__title">Crawler</div>
                </a>
            </li>
            <li>
                <a href="javascript:void(0)" class="side-menu <?php if ($module === 'order_logs' || $module === 'permissions' || $module === 'configis' || $module === 'config_colums') { ?>side-menu--active<?php } ?>">
                    <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="side-menu__title">
                        Development
                        <div class="side-menu__sub-icon <?php if ($module === 'order_logs' || $module === 'permissions' || $module === 'configis' || $module === 'config_colums') { ?>transform rotate-180<?php } ?>">
                            <i data-lucide="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class="<?php if ($module === 'order_logs' || $module === 'permissions' ||  $module === 'configis' || $module === 'config_colums') { ?>side-menu__sub-open<?php } ?>">
                    @can('users_index')
                    <li>
                        <a href="{{route('permissions.index')}}" class="side-menu {{ activeMenu('permissions') }}">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Quản lý phân quyền</div>
                        </a>
                    </li>
                    @endcan
                    <li>
                        <a href="{{route('configIs.index')}}" class="side-menu {{ activeMenu('config-is') }}">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Cấu hình hiển thị</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('config_colums.index')}}" class="side-menu {{ activeMenu('config-colums') }}">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Custom field</div>
                        </a>
                    </li>
                    @can('order_logs_index')
                    <li>
                        <a href="{{route('orderLogs.index')}}" class="side-menu {{ activeMenu('order-logs') }}">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Logs đơn hàng</div>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endif

        </ul>
    </div>
</nav>