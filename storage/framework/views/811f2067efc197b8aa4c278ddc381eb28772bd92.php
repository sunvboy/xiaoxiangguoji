<?php $dropdown = getFunctions(); ?>
<nav class="side-nav">
    <div class="pt-4 mb-4">
        <div class="side-nav__header flex items-center">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class=" flex items-center">
                <img alt="Rocketman Tailwind HTML Admin Template" class="side-nav__header__logo" src="<?php echo e(asset('backend/images/logo.svg')); ?>">
                <span class="side-nav__header__text text-white pt-0.5 text-lg ml-2.5"> <?php echo e(env('BE_TITLE_SEO')); ?> </span>
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
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="side-menu <?php echo e(activeMenu('dashboard')); ?>">
                    <div class="side-menu__icon"> <i data-lucide="home"></i> </div>
                    <div class="side-menu__title">
                        Dashboard
                    </div>
                </a>
            </li>
            <?php $__currentLoopData = config('sidebar'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(''.$key.'_index')): ?>
            <?php if(in_array($key, $dropdown) && !empty($module)): ?>
            <?php if(!empty($item['data']) && count($item['data']) > 0): ?>
            <li>
                <a href="javascript:void(0)" class="side-menu <?php if(in_array($module, array_keys($item['data']))): ?> side-menu--active <?php endif; ?>">
                    <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="side-menu__title">
                        <?php echo e($item['title']); ?>

                        <div class="side-menu__sub-icon <?php if(in_array($module, array_keys($item['data']))): ?> transform rotate-180 <?php endif; ?>">
                            <i data-lucide="chevron-down"></i>
                        </div>
                    </div>
                </a>
                <ul class="<?php if(in_array($module, array_keys($item['data']))): ?> side-menu__sub-open <?php endif; ?>">
                    <?php if(!empty($item['data']) && count($item['data']) > 0): ?>
                    <?php $__currentLoopData = $item['data']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(!empty($v['active'])): ?>
                    <?php if(!empty($v['dropdown'])): ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check(''.$k.'_index')): ?>
                    <?php if(in_array($k, $dropdown)): ?>
                    <li>
                        <a href="<?php echo e(route($v['route'])); ?>" class="side-menu <?php $__currentLoopData = $v['menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e(activeMenu($menu)); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title"><?php echo e(!empty($v['title'])?$v['title'] : config('permissions')['modules'][$k]); ?></div>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php else: ?>
                    <li>
                        <a href="<?php echo e(route($v['route'])); ?>" class="side-menu <?php $__currentLoopData = $v['menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> <?php echo e(activeMenu($menu)); ?> <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title"><?php echo e(!empty($v['title'])?$v['title'] : config('permissions')['modules'][$k]); ?></div>
                        </a>
                    </li>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </ul>
            </li>
            <?php else: ?>
            <li>
                <a href="<?php echo e(route($item['route'])); ?>" class="side-menu <?php echo activeMenu($key); ?>">
                    <div class="side-menu__icon">
                        <i data-lucide="box"></i>
                    </div>
                    <div class="side-menu__title"> <?php echo e($item['title']); ?></div>
                </a>
            </li>
            <?php endif; ?>
            <?php endif; ?>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <!-- Start: Cấu hình hệ thống -->
            <li>
                <a href="<?php echo e(route('generals.index')); ?>" class="side-menu <?php echo e(activeMenu('generals')); ?> <?php echo e(activeMenu('customer-socials')); ?> <?php echo e(activeMenu('orders-config')); ?> <?php echo e(activeMenu('taxes')); ?> <?php echo e(activeMenu('addresses')); ?> <?php echo e(activeMenu('config-emails')); ?> <?php echo e(activeMenu('ships')); ?> <?php echo e(activeMenu('config-images')); ?>">
                    <div class="side-menu__icon"> <i data-lucide="box"></i> </div>
                    <div class="side-menu__title">
                        Cấu hình
                    </div>
                </a>
            </li>
            <!-- END: Cấu hình hệ thống -->
            <li class="">
                <a href="<?php echo e(route('sitemap')); ?>" class="side-menu" target="_blank">
                    <div class="side-menu__icon">
                        <i data-lucide="box"></i>
                    </div>
                    <div class="side-menu__title">Cập nhập sitemap</div>
                </a>
            </li>

            <?php if(env('APP_ENV') == "local" && !empty($module)): ?>
            <li class="">
                <a href="<?php echo e(route('product_tmps.index')); ?>" class="side-menu" target="_blank">
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
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('users_index')): ?>
                    <li>
                        <a href="<?php echo e(route('permissions.index')); ?>" class="side-menu <?php echo e(activeMenu('permissions')); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Quản lý phân quyền</div>
                        </a>
                    </li>
                    <?php endif; ?>
                    <li>
                        <a href="<?php echo e(route('configIs.index')); ?>" class="side-menu <?php echo e(activeMenu('config-is')); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Cấu hình hiển thị</div>
                        </a>
                    </li>
                    <li>
                        <a href="<?php echo e(route('config_colums.index')); ?>" class="side-menu <?php echo e(activeMenu('config-colums')); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Custom field</div>
                        </a>
                    </li>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('order_logs_index')): ?>
                    <li>
                        <a href="<?php echo e(route('orderLogs.index')); ?>" class="side-menu <?php echo e(activeMenu('order-logs')); ?>">
                            <div class="side-menu__icon"> <i data-lucide="aperture"></i> </div>
                            <div class="side-menu__title">Logs đơn hàng</div>
                        </a>
                    </li>
                    <?php endif; ?>
                </ul>
            </li>
            <?php endif; ?>

        </ul>
    </div>
</nav><?php /**PATH /home/ungbuou/domains/ungbuou.tamphat.edu.vn/public_html/resources/views/dashboard/common/sidebar.blade.php ENDPATH**/ ?>