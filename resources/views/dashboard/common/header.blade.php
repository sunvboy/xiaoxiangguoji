<?php
$websites = \App\Models\Website::get();
?>
<div class="top-bar">
    <!-- BEGIN: Breadcrumb -->
    @yield('breadcrumb')
    <!-- END: Breadcrumb -->
    <!-- BEGIN: Mobile Menu -->
    <div class="- xl:hidden mr-3 sm:mr-6">
        <div class="mobile-menu-toggler cursor-pointer"> <i data-lucide="bar-chart-2" class="mobile-menu-toggler__icon transform rotate-90 dark:text-slate-500"></i> </div>
    </div>
    <!-- END: Mobile Menu -->
    <!-- BEGIN: Search -->
    <div class=" relative ml-auto sm:mx-auto">
        <div class="search hidden sm:hidden">
            <input type="text" class="search__input form-control" placeholder="Quick Search... (Ctrl+k)">
            <i data-lucide="search" class="search__icon"></i>
        </div>
        <a class="notification sm:hidden" href=""> <i data-lucide="search" class="notification__icon dark:text-slate-500 mr-5"></i> </a>
    </div>
    <!-- END: Search -->
    <!-- BEGIN: Notifications -->
    <div class=" dropdown mr-5 sm:mr-6 hidden">
        <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="bell" class="notification__icon dark:text-slate-500"></i> </div>
        <div class="notification-content pt-2 dropdown-menu">
            <div class="notification-content__box dropdown-content">
                <div class="notification-content__title">Notifications</div>
                <div class="cursor-pointer relative flex ">
                    <div class="w-10 h-10 flex-none image-fit mr-1">
                        <img alt="Rocketman - HTML Admin Template" class="rounded-full" src="{{asset('backend/images/profile-5.jpg')}}">
                        <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600">
                        </div>
                    </div>
                    <div class="ml-2">
                        <a href="javascript:;" class="font-medium mr-1">Arnold Schwarzenegger</a> <span class="text-slate-500">It is a long established fact that a reader will be distracted by the
                            readable content of a page when looking at its layout. The point of using Lorem </span>
                        <div class="text-xs text-slate-400 mt-1">01:10 PM</div>
                    </div>
                </div>
                <div class="cursor-pointer relative flex mt-5">
                    <div class="w-10 h-10 flex-none image-fit mr-1">
                        <img alt="Rocketman - HTML Admin Template" class="rounded-full" src="{{asset('backend/images/profile-14.jpg')}}">
                        <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600">
                        </div>
                    </div>
                    <div class="ml-2">
                        <a href="javascript:;" class="font-medium mr-1">Robert De Niro</a> <span class="text-slate-500">It is a long established fact that a reader will be distracted by the
                            readable content of a page when looking at its layout. The point of using Lorem </span>
                        <div class="text-xs text-slate-400 mt-1">01:10 PM</div>
                    </div>
                </div>
                <div class="cursor-pointer relative flex mt-5">
                    <div class="w-10 h-10 flex-none image-fit mr-1">
                        <img alt="Rocketman - HTML Admin Template" class="rounded-full" src="{{asset('backend/images/profile-3.jpg')}}">
                        <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600">
                        </div>
                    </div>
                    <div class="ml-2">
                        <a href="javascript:;" class="font-medium mr-1">Leonardo DiCaprio</a> <span class="text-slate-500">There are many variations of passages of Lorem Ipsum available, but
                            the majority have suffered alteration in some form, by injected humour, or randomi</span>
                        <div class="text-xs text-slate-400 mt-1">05:09 AM</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Notifications -->
    <!-- BEGIN: Notifications -->

    <div class=" mr-auto sm:mr-6">
        <div class="notification cursor-pointer">
            <div class="dropdown">
                <button class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">
                    <?php echo !empty(config('language')[config('app.locale')]['title']) ? config('language')[config('app.locale')]['title'] : '' ?>
                </button>
                <div class="dropdown-menu w-40">
                    <ul class="dropdown-content">
                        @foreach(config('language') as $key=>$item)
                        <li><a class="dropdown-item" href="{{ route('components.language', [$key]) }}">{{$item['title']}}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Notifications -->
    <!-- BEGIN: Account Menu -->
    <div class=" dropdown text-slate-200 h-10">
        <div class="h-full dropdown-toggle flex items-center" role="button" aria-expanded="false" data-tw-toggle="dropdown">
            <div class="w-10 h-10 image-fit">
                <img alt="{{!empty(Auth::user())?Auth::user()->name:''}}" class="rounded-full border-2 border-white border-opacity-10 shadow-lg" src="{{asset('backend/images/profile-14.jpg')}}">
            </div>
            <div class="hidden md:block ml-3">
                <div class="max-w-[7rem] truncate font-medium">{{!empty(Auth::user())?Auth::user()->name:''}}</div>
                <div class="text-xs text-slate-400">
                    @foreach(Auth::user()->roles as $v1)
                    {{$v1->title}},
                    @endforeach
                </div>

            </div>
        </div>
        <div class="dropdown-menu w-56">
            <ul class="dropdown-content">
                <li>
                    <a href="{{route('admin.profile')}}" class="dropdown-item"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Hồ sơ cá nhân </a>
                </li>

                <li>
                    <a href="{{route('admin.profile-password')}}" class="dropdown-item"> <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Đổi mật khẩu
                    </a>
                </li>

                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <a href="{{route('admin.logout')}}" class="dropdown-item"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>