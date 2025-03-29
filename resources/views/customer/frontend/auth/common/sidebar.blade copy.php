<div class="w-full md:w-[250px] lg:w-[376px] order-2 md:order-1 mt-10 md:mt-0">
    <div>
        <section class="flex items-center mb-1">
            <div class="border rounded-full h-[60px] w-[60px] overflow-hidden">
                <img src="https://ui-avatars.com/api/?name={{Auth::guard('customer')->user()->name}}" alt="{{Auth::guard('customer')->user()->name}}" class="blur-up h-full w-full t-img">
            </div>
            <div class="flex flex-col ml-3">
                <span class="font-extrabold text-[19px]">
                    {{Auth::guard('customer')->user()->name}}
                </span>
                <a href="javascript:void(0)" class="font-bold  text-blue-500">
                    <?php /*Số dư: {{number_format(Auth::guard('customer')->user()->phone,'0',',','.')}}₫*/ ?>
                    {{Auth::guard('customer')->user()->phone}}
                </a>
            </div>
        </section>
        <div class="h-px my-3"></div>
        <div class="flex flex-col gap-3">
            <a href="{{route('customer.dashboard')}}" class="menu_item_auth flex justify-between items-center p-3 rounded-xl ">
                <div class="flex space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-global" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span>{{trans('index.AccountInformation')}}</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <a href="{{route('quizzes.frontend.index')}}" class="menu_item_auth flex justify-between items-center p-3 rounded-xl ">
                <div class="flex space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-global">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    <span>Danh sách bài thi</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <a href="{{route('notification.frontend.index')}}" class="menu_item_auth flex justify-between items-center p-3 rounded-xl ">
                <div class="flex space-x-2 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="h-5 w-5 text-global">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0M3.124 7.5A8.969 8.969 0 015.292 3m13.416 0a8.969 8.969 0 012.168 4.5" />
                    </svg>

                    <span>Thông báo</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <?php /* <a href="{{route('customer.address')}}" class="menu_item_auth flex justify-between items-center p-3 rounded-xl ">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-global" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                    </svg>
                    <span>{{trans('index.ContactInformation')}}</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>
            <a href="{{route('customer.orders')}}" class="menu_item_auth flex justify-between items-center p-3 rounded-xl">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-global" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span>{{trans('index.PurchaseHistory')}}</span>
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                </svg>
            </a>*/ ?>
            <a href="tel:{{$fcSystem['contact_hotline']}}" class="flex justify-between items-center p-3 hover:bg-gray-100 hover:rounded-xl">
                <div class="flex space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-global" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span>{{trans('index.CallHotline')}} {{$fcSystem['contact_hotline']}}</span>
                </div>
            </a>
        </div>
        <div class="h-px my-3"></div>
        <a href="{{route('customer.logout')}}" class="flex justify-between items-center p-3 hover:bg-gray-100 hover:rounded-xl">
            <div class="flex space-x-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                </svg>
                <span>{{trans('index.Logout')}}</span>
            </div>
        </a>
    </div>

</div>
<script>
    var aurl = window.location.href; // Get the absolute url
    $('.menu_item_auth').filter(function() {
        return $(this).prop('href') === aurl;
    }).addClass('active');
</script>
<style>
    .menu_item_auth.active {
        background: #2c2e8130;
    }
</style>