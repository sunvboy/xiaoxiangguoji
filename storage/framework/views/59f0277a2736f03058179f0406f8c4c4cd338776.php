
<?php $__env->startSection('content'); ?>
<div class="ps-categogy main-category-product main-category-product-list pb-120 bg-gray" id="scrollTop">
    <div class="container">
        <?php if(!$breadcrumb->isEmpty()): ?>
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="<?php echo url('') ?>">Trang chủ</a></li>
            <?php $__currentLoopData = $breadcrumb; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="ps-breadcrumb__item active" aria-current="page"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <?php endif; ?>

        <div class="top-category-product">
            <h1 class="title-primary-1"><?php echo e($detail->title); ?></h1>
            <?php if(!empty($detail->children) && count($detail->children) > 0): ?>
            <div class="row">
                <?php $__currentLoopData = $detail->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="item">
                        <div class="img">
                            <a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><img src="<?php echo e(asset($item->image)); ?>" alt="<?php echo e($item->title); ?>"></a>
                        </div>
                        <div class="nav-img">
                            <h3 class="title-4"><a href="<?php echo e(route('routerURL',['slug' => $item->slug])); ?>"><?php echo e($item->title); ?></a></h3>
                            <p class="desc-2"><?php echo e($item->countProduct->count()); ?> sản phẩm</p>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php endif; ?>
        </div>



        <div class="ps-categogy__content">

            <div class="row row-reverse">
                <div class="col-12 col-md-9">
                    <h2 class="title-primary-1">Danh sách sản phẩm</h2>
                    <input id="choose_attr" class="w-full d-none" type="text" name="attr">
                    <?php if(svl_ismobile() == 'is mobile'): ?>
                    <!-- START : filter-mobile -->
                    <div class="filter-mobile">
                        <div class="row">
                            <?php if(!empty($attributes) && count($attributes) > 0): ?>
                            <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(count($item) > 0): ?>
                            <div class="col-6">
                                <select name="attr[]" class="js_select_attr filter">
                                    <option value=""><?php echo e($key); ?></option>
                                    <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($val['id']); ?>" data-title="<?php echo e($val['title']); ?>" data-keyword="<?php echo e($val['keyword']); ?>"><?php echo e($val['title']); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- END : filter-mobile -->
                    <?php endif; ?>
                    <div class="ps-categogy__wrapper">

                        <div class="ps-categogy__type">
                            <a class="js_typeHTML" href="javascript:void(0)" data-type="list"><img src="<?php echo e(asset('frontend/img/icon/bars.svg')); ?>" alt></a>
                            <a class="js_typeHTML active" href="javascript:void(0)" data-type="col"><img src="<?php echo e(asset('frontend/img/icon/gird2.svg')); ?>" alt></a>

                        </div>
                        <div class="ps-categogy__onsale">
                            <div class="custom-control custom-checkbox">
                                <label for="onSaleProduct"> <input type="checkbox" id="onSaleProduct" value="1"> Chỉ hiển thị các sản phẩm đang sale</label>
                            </div>
                        </div>
                        <div class="ps-categogy__sort d-flex">
                            <span>Sắp xếp theo</span>
                            <select class="form-select filter" name="sort">
                                <option selected value="id|desc">Mới nhất</option>
                                <option value="cart|desc">Bán chạy</option>
                                <option value="price|asc">Giá thấp</option>
                                <option value="price|desc">Giá cao</option>
                            </select>
                        </div>
                        <div class="ps-categogy__show">
                            <span>Hiển thị</span>
                            <select class="form-select filter" name="perpage">
                                <option selected value="20">20</option>
                                <option value="40">40</option>
                                <option value="60">60</option>
                                <option value="80">80</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>



                    <div class="ps-categogy--grid ps-categogy--detail">
                        <div class="row" id="js_data_product_filter">
                            <?php if($data): ?>
                            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-6 col-lg-3">
                                <?php echo htmlItemProduct2($key, $item); ?>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </div>
                        <?php echo $__env->make('homepage.common.loading', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <div class="ps-pagination js_pagination_filter">
                        <?php echo $__env->make('homepage.common.pagination', ['paginator' => $data, 'interval' => 2], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                </div>
                <?php if(svl_ismobile() != 'is mobile'): ?>
                <div class="col-12 col-md-3">
                    <div class="ps-widget ps-widget--product">

                        <?php if(!empty($attributes) && count($attributes) > 0): ?>
                        <?php $i = 0; ?>
                        <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $i++; ?>
                        <?php if(count($item) > 0): ?>
                        <?php if($i == 1): ?>
                        <div class="ps-widget__block">
                            <h4 class="ps-widget__title"><?php echo e($key); ?></h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                            <div class="ps-widget__content">
                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="ps-widget__item">
                                    <div class="custom-control custom-checkbox">
                                        <label class="js_attr" for="attr-<?php echo e($val['id']); ?>">
                                            <input id="attr-<?php echo e($val['id']); ?>" type="checkbox" value="<?php echo e($val['id']); ?>" data-title="<?php echo e($val['title']); ?>" data-keyword="<?php echo e($val['keyword']); ?>" class="js_input_attr filter hidden" name="attr[]">
                                            <span><?php echo e($val['title']); ?></span>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                        <div class="ps-widget__block">
                            <h4 class="ps-widget__title">Giá Bán</h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                            <input type="text" class="filter d-none" name="price_start" value="" id="slide-price-min-input" />
                            <input type="text" class="filter d-none" name="price_end" value="" id="slide-price-max-input" />
                            <div class="ps-widget__content">
                                <div class="ps-widget__price">
                                    <div id="slide-price"></div>
                                </div>
                                <div class="ps-widget__input">
                                    <span class="ps-price" id="slide-price-min">0</span>
                                    <span class="bridge">-</span>
                                    <span class="ps-price" id="slide-price-max"></span>
                                </div>
                                <button class="ps-widget__filter">Lọc</button>
                            </div>
                        </div>
                        <?php if(!empty($attributes) && count($attributes) > 0): ?>
                        <?php $i = 0; ?>
                        <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php $i++; ?>
                        <?php if(count($item) > 0): ?>
                        <?php if($i > 1): ?>
                        <div class="ps-widget__block">
                            <h4 class="ps-widget__title"><?php echo e($key); ?></h4><a class="ps-block-control" href="#"><i class="fa fa-angle-down"></i></a>
                            <div class="ps-widget__content">
                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="ps-widget__item">
                                    <div class="custom-control custom-checkbox">
                                        <label for="attr-<?php echo e($val['id']); ?>" class="js_attr">
                                            <input id="attr-<?php echo e($val['id']); ?>" type="checkbox" value="<?php echo e($val['id']); ?>" data-title="<?php echo e($val['title']); ?>" data-keyword="<?php echo e($val['keyword']); ?>" class="js_input_attr filter hidden" name="attr[]">
                                            <span><?php echo e($val['title']); ?></span>
                                        </label>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                        <?php endif; ?>
                        <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <?php echo $__env->make('homepage.common.recently', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<?php echo $__env->make('product.frontend.category.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/product/frontend/category/index.blade.php ENDPATH**/ ?>