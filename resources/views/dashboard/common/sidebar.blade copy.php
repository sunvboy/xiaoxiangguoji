<?php $dropdown = getFunctions();
?>
<aside class="w-[283px] bg-white overflow-hidden h-screen flex flex-col fixed top-0 left-0">
    <div class="bg-primary flex justify-center items-center z-[999] h-[70px]">
        <a href="{{route('admin.dashboard')}}">
            <img src="{{asset('backend/images/logo-doi.png')}}" class="max-w-[160px]" style="filter: contrast(0) brightness(200%);">
        </a>
    </div>
    <nav class="navigation flex-1 border-r" style="box-shadow: 0 0 35px rgb(0 0 0 / 10%);">
        <ul class="list-unstyled">
            @foreach (config('sidebar') as $key=>$item)
            @can(''.$key.'_index')
            @if (in_array($key, $dropdown) && !empty($module))
            @if(!empty($item['data']) && count($item['data']) > 0)
            <li class="has-submenu relative @if(in_array($module, array_keys($item['data']))) side-menu--active @endif">
                <a href="javascript:void(0)" class="side-menu font-semibold flex justify-start border-b-0 items-center px-[10px] py-3 mx-3">
                    <span class="svg-icon mr-2 service_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" class="w-[23px] h-[23px]">
                            <path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z" fill="black"></path>
                            <path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z" fill="black"></path>
                            <path opacity="0.3" d="M15 17H9V20H15V17Z" fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <span class="nav-label text-[#343a40] text-base">{{$item['title']}}</span>
                </a>
                <ul class="list-unstyled mx-3 px-[10px] @if(in_array($module, array_keys($item['data']))) side-menu__sub-open @endif">
                    @if(!empty($item['data']) && count($item['data']) > 0)
                    @foreach($item['data'] as $k=>$v)
                    @if(!empty($v['active']))
                    @if(!empty($v['dropdown']))
                    @can(''.$k.'_index')
                    @if (in_array($k, $dropdown))
                    <li>
                        <a href="{{ route($v['route']) }}" class="flex space-x-1.5 py-2 px-2 items-center @foreach($v['menu'] as $menu) {{activeMenu($menu)}} @endforeach">
                            <i class="fa-sharp fa-solid fa-angle-right text-[10px]"></i>
                            <span>
                                {{!empty($v['title'])?$v['title'] : config('permissions')['modules'][$k]}}
                            </span>
                        </a>
                    </li>
                    @endcan
                    @endif
                    @else
                    <li>
                        <a href="{{ route($v['route']) }}" class="flex space-x-1.5 py-2 px-2 items-center @foreach($v['menu'] as $menu) {{activeMenu($menu)}} @endforeach">
                            <i class="fa-sharp fa-solid fa-angle-right text-[10px]"></i>
                            <span>
                                {{!empty($v['title'])?$v['title'] : config('permissions')['modules'][$k]}}
                            </span>
                        </a>
                    </li>
                    @endif
                    @endif
                    @endforeach
                    @endif
                </ul>
            </li>
            @else
            <li class="relative">
                <a href="{{route($item['route'])}}" class="side-menu font-semibold flex justify-start border-b-0 items-center px-[10px] py-3 mx-3 <?php echo activeMenu($key); ?>">
                    <span class="svg-icon mr-2 service_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" class="w-[23px] h-[23px]">
                            <path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z" fill="black"></path>
                            <path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z" fill="black"></path>
                            <path opacity="0.3" d="M15 17H9V20H15V17Z" fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <span class="nav-label text-[#343a40] text-base">{{$item['title']}}</span>
                </a>

            </li>
            @endif
            @endif
            @endcan
            @endforeach
            <li class="relative hidden">
                <a href="{{route('permissions.index')}}" class="side-menu font-semibold flex justify-start border-b-0 items-center px-[10px] py-3 mx-3 {{ activeMenu('permissions') }}">
                    <span class="svg-icon mr-2 service_icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" class="w-[23px] h-[23px]">
                            <path d="M2 16C2 16.6 2.4 17 3 17H21C21.6 17 22 16.6 22 16V15H2V16Z" fill="black"></path>
                            <path opacity="0.3" d="M21 3H3C2.4 3 2 3.4 2 4V15H22V4C22 3.4 21.6 3 21 3Z" fill="black"></path>
                            <path opacity="0.3" d="M15 17H9V20H15V17Z" fill="black"></path>
                        </svg>
                    </span>
                    <!--end::Svg Icon-->
                    <span class="nav-label text-[#343a40] text-base">Quản lý phân quyền</span>
                </a>

            </li>
        </ul>
    </nav>
</aside>