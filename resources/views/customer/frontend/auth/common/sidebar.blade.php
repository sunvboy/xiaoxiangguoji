   <div class="aside-information  bg-white">
       <div class="item">
           <div class="img">
               <img src="{{asset('frontend/img/avatar-profile.svg')}}" alt="">
           </div>
           <h3 class="title-name">{{Auth::guard('customer')->user()->name}}</h3>
           <p class="phone">{{Auth::guard('customer')->user()->phone}}</p>
       </div>
       <div class="list-information">
           <ul>
               <li>
                   <a href="{{route('customer.dashboard')}}" class="menu_item_auth"><i class="fa fa-user" aria-hidden="true"></i>Thông tin cá nhân<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
               <li>
                   <a href="{{route('customer.orders')}}" class="menu_item_auth"><i class="fa fa-cubes" aria-hidden="true"></i>Quản lý đơn hàng<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
               <li>
                   <a href="{{route('customer.coupons')}}" class="menu_item_auth"><i class="fa fa-ship" aria-hidden="true"></i>Mã khuyến mãi<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
               <li>
                   <a href="{{route('customer.orderOnline')}}" class="menu_item_auth"><i class="fa fa-cubes" aria-hidden="true"></i>Đặt thuốc online<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
               <li>
                   <a href="{{route('customer.logout')}}" class="menu_item_auth"><i class="fa fa-sign-out" aria-hidden="true"></i>Đăng xuất<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
           </ul>
       </div>
   </div>
   <script>
       var aurl = window.location.href; // Get the absolute url
       $('.menu_item_auth').filter(function() {
           return $(this).prop('href') === aurl;
       }).parent().addClass('active');
   </script>