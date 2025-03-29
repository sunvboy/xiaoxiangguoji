<header class="block lg:hidden py-2 px-4">
    <div class="relative flex justify-center">
        <div class="hamburger material-icons absolute left-0 top-1/2 -translate-y-1/2 block lg:hidden" id="ham">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-9 h-9  float-right text-gray-600">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </div>

        <a href="{{url('/')}}"><img src="{{asset($fcSystem['homepage_logo'])}}" alt="{{$fcSystem['homepage_company']}}" /></a>
        <div href="javascript:void(0)" class="absolute top-1/2 right-0 -translate-y-1/2">
            <a href="javascript:void(0)" class="text-f25 text-center relative tp-cart">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 10-7.5 0v4.5m11.356-1.993l1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 01-1.12-1.243l1.264-12A1.125 1.125 0 015.513 7.5h12.974c.576 0 1.059.435 1.119 1.007zM8.625 10.5a.375.375 0 11-.75 0 .375.375 0 01.75 0zm7.5 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                </svg>
                <span class="absolute w-5 h-5 leading-5 rounded-full bg-[#d61c1f] text-[10px] text-white -right-[6px] top-0 text-center cart-quantity">{{$cart['quantity']}}</span>
            </a>
        </div>
    </div>
    <?php echo getHtmlFormSearch(array(
        'action' => route('homepage.search'),
        'placeholder' => 'Tìm kiếm sản phẩm',
        'classForm' => '',
        'classInput' => '',
        'classButton' => '',
    )) ?>
    @include('homepage.common.menuMobile')
</header>