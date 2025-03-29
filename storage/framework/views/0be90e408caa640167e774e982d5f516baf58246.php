   <div class="aside-information  bg-white">
       <div class="item">
           <div class="img">
               <img src="<?php echo e(asset('frontend/img/avatar-profile.svg')); ?>" alt="">
           </div>
           <h3 class="title-name"><?php echo e(Auth::guard('customer')->user()->name); ?></h3>
           <p class="phone"><?php echo e(Auth::guard('customer')->user()->phone); ?></p>
       </div>
       <div class="list-information">
           <ul>
               <li>
                   <a href="<?php echo e(route('customer.dashboard')); ?>" class="menu_item_auth"><i class="fa fa-user" aria-hidden="true"></i>Thông tin cá nhân<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
               <li>
                   <a href="<?php echo e(route('customer.orders')); ?>" class="menu_item_auth"><i class="fa fa-cubes" aria-hidden="true"></i>Quản lý đơn hàng<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
               <li>
                   <a href="<?php echo e(route('customer.coupons')); ?>" class="menu_item_auth"><i class="fa fa-ship" aria-hidden="true"></i>Mã khuyến mãi<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
               <li>
                   <a href="<?php echo e(route('customer.logout')); ?>" class="menu_item_auth"><i class="fa fa-sign-out" aria-hidden="true"></i>Đăng xuất<i class="fa fa-angle-right" aria-hidden="true"></i></a>
               </li>
           </ul>
       </div>
   </div>
   <script>
       var aurl = window.location.href; // Get the absolute url
       $('.menu_item_auth').filter(function() {
           return $(this).prop('href') === aurl;
       }).parent().addClass('active');
   </script><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/customer/frontend/auth/common/sidebar.blade.php ENDPATH**/ ?>