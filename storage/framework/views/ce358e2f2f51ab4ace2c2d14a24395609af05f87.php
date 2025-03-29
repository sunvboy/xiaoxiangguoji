<?php $__env->startSection('content'); ?>
<?php echo htmlBreadcrumb($page->title); ?>


<main class="pt-[40px] md:pt-16 pb-[80px] md:pb-[150px] main-cart">
    <div class="container px-4 md:px-0">
        <?php if(isset($cart['cart']) && is_array($cart['cart']) && count($cart['cart']) > 0 ): ?>
        <div class="grid grid-111 grid-cols-1 md:grid-cols-3 gap-8">
            <div class="space-y-3 col-span-2 bg-[#fff] p-[16px] rounded-2xl box-item-1">
                <h1 class="font-bold text-[22px] tracking-[0.7px] uppercase hidden"><?php echo e($page->title); ?></h1>
                <div class="cart_item flex gap-5 items-center border-b pb-3">
                    <div class="w-[390px] flex gap-5 items-center font-bold">
                        Sản phẩm
                    </div>
                    <div class="w-[200px] text-center flex flex-col font-bold">
                        Giá thành
                    </div>
                    <div class="flex items-center w-[110px] font-bold" style="width: 130px;">
                        Số lượng
                    </div>
                    <div class="flex-1 flex justify-end font-bold">
                    </div>
                </div>
                <?php $price_coupon = 0; ?>
                <input type="hidden" name="fee_ship" value="0">
                <?php $__currentLoopData = $cart['cart']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $stock = getStockProduct($item);
                $slug = !empty($item['slug']) ? $item['slug'] : '';
                $title_version = !empty($item['options']['title_version']) ? $item['options']['title_version'] : '';
                ?>
                <div class="cart_item cart-<?php echo e($k); ?> flex gap-5 items-center border-b pb-3">
                    <div class="w-[390px] flex gap-5 items-center">
                        <a href="<?php echo e($slug); ?>" class="flex w-[62px] border rounded-[7.2px] p-[4px]">
                            <img alt="<?php echo e($item['title']); ?>" src="<?php echo e(asset($item['image'])); ?>" class="w-full h-[52px] rounded-lg">
                        </a>
                        <div class="flex flex-col flex-1">
                            <span class="title-3"><?php echo e($item['title']); ?></span>
                            <span class="title-4"><?php echo e($title_version); ?></span>
                        </div>
                    </div>
                    <div class="w-[200px] text-center flex flex-col">
                        <span class="text-red-600 font-semibold"><?php echo e(number_format($item['price'])); ?>đ</span>
                        <?php if(!empty($item['price_old'])): ?>
                        <span class="line-through"><?php echo e(number_format($item['price_old'])); ?>đ</span>
                        <?php endif; ?>
                    </div>
                    <div class="flex items-center w-[130px]" style="width: 130px;">
                        <div class="flex items-center flex-1">
                            <button data-rowid="<?php echo e($k); ?>" class="tp_cart_minus flex justify-center items-center w-[25px] !h-[32px] border-t border-b border-l" style="border-radius: 34px 0px 0px 34px;">
                                <svg class="w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M20 12.5H4v-1h16v1Z" fill-rule="evenodd" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                            <input type="number" min="1" data-rowid="<?php echo e($k); ?>" max="<?php echo e($stock); ?>" step="1" value="<?php echo e($item['quantity']); ?>" class="flex-auto w-8 !h-[32px] text-center border focus:outline-none input-appearance-none tp_cardQuantity">
                            <button data-rowid="<?php echo e($k); ?>" class="tp_cart_plus flex justify-center items-center w-[25px] !h-[32px]  border-t border-b border-r" style="border-radius: 0 34px 34px 0;">
                                <svg class="w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M11.5 11.5V4h1v7.5H20v1h-7.5V20h-1v-7.5H4v-1h7.5Z" fill-rule="evenodd" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="dv">
                            / <?php echo e($item['unit']); ?>

                        </div>
                    </div>
                    <div class="flex-1 flex justify-end">
                        <a href="javascript:void(0)" data-rowid="<?php echo e($k); ?>" class="js-cart-remove flex items-center space-x-2 group hover:text-red-600">
                            <i class="fa fa-trash text-gray-400 !text-[18px]"></i>
                        </a>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            </div>
            <div>
                <div class="bg-[#fff] rounded-tl-2xl rounded-tr-2xl max-w-[384px] mx-auto box-ma">
                    <div class="p-[16px]">
                        <!-- START: mã giảm giá -->
                        <div class="flex justify-between items-center">
                            <h3 class="text-[16px] mb-0">Tạm tính</h3>
                            <div class="text-[16px] cart-total">
                                <?php echo number_format($cart['total'], '0', ',', '.') . '₫' ?>
                            </div>
                        </div>
                        <div class="cart-coupon-html">
                            <?php if(isset($coupon)): ?>
                            <?php $__currentLoopData = $coupon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $price_coupon += !empty($v['price']) ? $v['price'] : 0; ?>
                            <div class="flex justify-between items-center">
                                <h3 class="text-[16px] mb-0">
                                    <?php echo e(trans('index.DiscountCode')); ?> <span class="cart-coupon-name font-bold underline"><?php echo e($v['name']); ?></span>
                                    <a href="javascript:void(0)" data-id="<?php echo e($v['id']); ?>" class="remove-coupon text-red-600 font-bold">[<?php echo e(trans('index.Delete')); ?>]</a>
                                </h3>
                                <div class="text-[16px] cart-total">
                                    -<span class="amount cart-coupon-price"><?php echo number_format($v['price']) . '₫' ?>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <?php if (in_array('coupons', $dropdown)) { ?>
                            <div class="mt-3">
                                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative message-danger mb-2 hidden">
                                    <strong class="font-bold">ERROR!</strong>
                                    <span class="block sm:inline danger-title"></span>
                                </div>
                                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md message-success mb-2 hidden">
                                    <div class="flex">
                                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="font-bold success-title"></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="relative">
                                    <input id="coupon_code" class="border border-solid border-gray-300 w-full px-3 mb-5 placeholder-current text-dark h-[46px] focus:outline-none" placeholder="<?php echo e(trans('index.EnterDiscountCode')); ?>" type="text">
                                    <button type="button" id="apply_coupon" class="absolute top-0 right-0 h-[46px] inline-block bg-[#022da4] leading-none py-4 px-[8px]  text-white transition-all hover:bg-orange font-semibold hover:text-white tracking-[0.7px] "><?php echo e(trans('index.Apply')); ?></button>
                                </div>
                            </div>
                        <?php } ?>
                        <!-- END: mã giảm giá -->
                        <div class="pt-[20px] border-t">
                            <div class="flex justify-between pb-[20px]">
                                <h3 class="text-[18px] font-bold"><?php echo e(trans('index.TotalPrice')); ?></h3>
                                <div class="text-[18px] font-bold cart-total-final">
                                    <?php echo number_format($cart['total'] - $price_coupon, '0', ',', '.') . '₫' ?>
                                </div>
                            </div>
                            <a class="ps-btn ps-btn--warning" href="<?php echo e(route('cart.checkout')); ?>">Thanh toán</a>

                        </div>
                    </div>
                </div>
                <div class="ml-[auto] ml-hinden">
                    <svg width="400" height="24" viewBox="0 0 384 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M0 0H384V15.25C384 17.8112 384 19.0917 383.615 20.1135C383.007 21.7306 381.731 23.0068 380.113 23.6154C379.092 24 377.811 24 375.25 24C373.55 24 372.7 24 372.131 23.8888C370.435 23.5578 371.033 23.8255 369.656 22.7819C369.194 22.4314 367.279 20.2894 363.449 16.0053C361.252 13.5472 358.057 12 354.5 12C349.957 12 346.004 14.524 343.967 18.2462C342.376 21.1529 339.814 24 336.5 24C333.186 24 330.624 21.1529 329.033 18.2462C326.996 14.524 323.043 12 318.5 12C313.957 12 310.004 14.524 307.967 18.2462C306.376 21.1529 303.814 24 300.5 24C297.186 24 294.624 21.1529 293.033 18.2462C290.996 14.524 287.043 12 282.5 12C277.957 12 274.004 14.524 271.967 18.2462C270.376 21.1529 267.814 24 264.5 24C261.186 24 258.624 21.1529 257.033 18.2462C254.996 14.524 251.043 12 246.5 12C241.957 12 238.004 14.524 235.967 18.2462C234.376 21.1529 231.814 24 228.5 24C225.186 24 222.624 21.1529 221.033 18.2462C218.996 14.524 215.043 12 210.5 12C205.957 12 202.004 14.524 199.967 18.2462C198.376 21.1529 195.814 24 192.5 24C189.186 24 186.624 21.1529 185.033 18.2462C182.996 14.524 179.043 12 174.5 12C169.957 12 166.004 14.524 163.967 18.2462C162.376 21.1529 159.814 24 156.5 24C153.186 24 150.624 21.1529 149.033 18.2462C146.996 14.524 143.043 12 138.5 12C133.957 12 130.004 14.524 127.967 18.2462C126.376 21.1529 123.814 24 120.5 24C117.186 24 114.624 21.1529 113.033 18.2462C110.996 14.524 107.043 12 102.5 12C97.9574 12 94.0044 14.524 91.9668 18.2462C90.3757 21.1529 87.8137 24 84.5 24C81.1863 24 78.6243 21.1529 77.0332 18.2462C74.9956 14.524 71.0426 12 66.5 12C61.9574 12 58.0044 14.524 55.9668 18.2462C54.3757 21.1529 51.8137 24 48.5 24C45.1863 24 42.6243 21.1529 41.0332 18.2462C38.9956 14.524 35.0426 12 30.5 12C27.1233 12 24.0723 13.3947 21.8918 15.6395C17.3526 20.3123 15.083 22.6487 14.5384 23.008C13.3234 23.8097 13.9452 23.5469 12.5236 23.8598C11.8864 24 11.0076 24 9.25 24C6.21942 24 4.70412 24 3.52376 23.4652C2.19786 22.8644 1.13557 21.8021 0.534817 20.4762C0 19.2959 0 17.7806 0 14.75V0Z" fill="white"></path>
                    </svg>
                </div>
                <!--START: List mã giảm giá -->

            </div>
        </div>
        <?php else: ?>
        <div class="flex flex-col justify-center items-center space-y-5">
            <picture><img src="<?php echo e(asset('images/empty-cart.png')); ?>" alt="img"></picture>
            <div class="text-center">
                <h3 class="font-bold">Chưa có sản phẩm nào trong giỏ hàng</h3>
                <div>
                    Cùng mua sắm hàng ngàn sản phẩm tại nhà thuốc <?php echo e($fcSystem['homepage_brandname']); ?> nhé!
                </div>
            </div>
            <div>
                <a href="<?php echo e(url('/')); ?>" class="py-[10px] bg-blue-500 hover:bg-blue-700 text-white font-bold flex px-5 rounded-full">Mua hàng</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</main>

<style>
    input[type='number']::-webkit-inner-spin-button,
    input[type='number']::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    main {
        background: #edf0f3;
    }

    .breadcrumb {
        margin-bottom: 0px;
    }
</style>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
<link href="<?php echo e(asset('frontend/css/app.css')); ?>" rel="stylesheet" async>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('javascript'); ?>
<script src="<?php echo e(asset('frontend/library/js/products.js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/cart/index.blade.php ENDPATH**/ ?>