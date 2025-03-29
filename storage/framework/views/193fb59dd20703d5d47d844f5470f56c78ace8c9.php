<div id="main" class="sitemap main-product">
    <div class="content-main-new pt-0 md:pt-[20px]" id="scrollTop">
        <h1 class="title-primary text-center text-f28 uppercase font-bold">
            <?php echo $title ?>
        </h1>
        <div class="filter mt-[30px]">
            <div class="">
                <div class="filter-title border-t border-b border-gray-200">
                    <div class="grid grid-cols-3 md:grid-cols-2 justify-between items-center">
                        <div class="col-span-1 md:col-span-1">
                            <div class="title-span">
                                <span class="text-xs"><span class="js_total_filter"><?php echo e($data->total()); ?></span> sản phẩm</span>
                            </div>
                        </div>
                        <div class="col-span-2 md:col-span-1">
                            <div class="flex flex-wrap justify-end">
                                <div class="border-r py-[10px] pr-1 md:pr-5">
                                    <select name="sortBy" id="" class="filter cursor-pointer border-0 uppercase tracking-wider outline-none focus:outline-none hover:outline-none">
                                        <option value=""><?php echo e(trans('index.SortedBy')); ?></option>
                                        <option value="id|desc"><?php echo e(trans('index.Latest')); ?></option>
                                        <option value="id|asc"><?php echo e(trans('index.Oldest')); ?></option>
                                        <option value="title|asc"><?php echo e(trans('index.NameAZ')); ?></option>
                                        <option value="title|desc"><?php echo e(trans('index.NameZA')); ?></option>
                                        <option value="price|asc"><?php echo e(trans('index.PricesGoUp')); ?></option>
                                        <option value="price|desc"><?php echo e(trans('index.PricesGoDown')); ?></option>
                                    </select>
                                </div>
                                <div class="click-filter pl-1 md:pl-5 text-f16 flex items-center flex-wrap cursor-pointer space-x-2">
                                    <span class="uppercase">
                                        Bộ lọc
                                    </span>
                                    <svg class="w-5" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M5.572 5.725v1.166h.784V3.333h-.784V4.5c0 .057-.022.11-.062.15a.207.207 0 0 1-.148.063H3.333v.8h2.029c.115 0 .21.095.21.213Zm4.601 10.942V13.11h-.785v1.165a.211.211 0 0 1-.208.213H3.333v.8H9.18c.055 0 .108.022.148.063.039.04.06.094.06.15v1.166h.785Zm6.493-2.179h-4.903v.8h4.903v-.8ZM13.584 9.6v.8h3.082v-.8h-3.082Zm-2.377-.213c0 .057-.022.11-.06.15a.207.207 0 0 1-.149.063H3.333v.8h7.665c.056 0 .109.022.148.062.04.04.061.095.061.151v1.166h.785V8.22h-.785v1.166Zm-3.26-4.675v.8h8.72v-.8h-8.72Z" fill-rule="evenodd" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main-menu-filter">
                <div class="p-[15px] md:p-[30px] border-b border-gray-200">
                    <div class="flex flex-wrap justify-between">
                        <div class="w-2/3">
                            <div class="logo-1">
                                <h3 class="text-f20 md:text-f25 font-bold uppercase">FILTER BY</h3>
                            </div>
                        </div>
                        <div class="w-1/3">
                            <div class="top-close-menu cursor-pointer">
                                <svg class="w-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M12.782 12 19 18.218l-.782.782L12 12.782 5.782 19 5 18.218 11.218 12 5 5.782 5.782 5 12 11.218 18.218 5l.782.782L12.782 12Z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="menu-siderbar p-[15px] md:p-[30px]">
                    <?php if(!empty($brandFilter) && count($brandFilter) > 0): ?>
                    <div class="flex flex-col border-b w-full py-5 acc__card hidden">
                        <div class="flex justify-between items-center cursor-pointer acc__title relative">
                            <h4 class="text-base font-medium uppercase"><?php echo e(trans('index.Brands')); ?></h4>
                        </div>
                        <div class="acc__panel pt-5 space-x-2">
                            <div class="flex flex-wrap">
                                <?php if($module == 'category'): ?>
                                <?php $__currentLoopData = $brandFilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label for="brand-<?php echo e($item->brands->id); ?>" class="js_brand float-left mb-2 mr-2 relative px-4 py-2 text-center bg-white hover:bg-red-100 hover:border-red-100 rounded-md cursor-pointer border">
                                    <input id="brand-<?php echo e($item->brands->id); ?>" type="checkbox" data-title="<?php echo e($item->brands->title); ?>" value="<?php echo e($item->brands->id); ?>" class="js_input_brand filter hidden" name="brands[]">
                                    <span class=""><?php echo e($item->brands->title); ?></span>
                                    <div class="product-filter-tick">
                                        <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="shopee-svg-icon icon-tick-bold">
                                            <g>
                                                <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <?php $__currentLoopData = $brandFilter; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label for="brand-<?php echo e($item->id); ?>" class="js_brand float-left mb-2 mr-2 relative px-4 py-2 text-center bg-white hover:bg-red-100 hover:border-red-100 rounded-md cursor-pointer border">
                                    <input id="brand-<?php echo e($item->id); ?>" type="checkbox" data-title="<?php echo e($item->title); ?>" value="<?php echo e($item->id); ?>" class="js_input_brand filter hidden" name="brands[]">
                                    <span class=""><?php echo e($item->title); ?></span>
                                    <div class="product-filter-tick">
                                        <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="shopee-svg-icon icon-tick-bold">
                                            <g>
                                                <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($attributes) && count($attributes) > 0): ?>
                    <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if(count($item) > 0): ?>
                    <div class="flex flex-col border-b w-full py-5 acc__card">
                        <div class="flex justify-between items-center cursor-pointer acc__title relative">
                            <h4 class="text-base uppercase font-medium"><?php echo e($key); ?></h4>
                        </div>
                        <div class="acc__panel pt-5 space-x-2">
                            <div class="flex flex-wrap">
                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <label for="attr-<?php echo e($val['id']); ?>" class="js_attr float-left mr-2 mb-2 relative px-4 py-2 text-center bg-white hover:bg-red-100 hover:border-red-100 rounded-md cursor-pointer border">
                                    <input id="attr-<?php echo e($val['id']); ?>" type="checkbox" value="<?php echo e($val['id']); ?>" data-title="<?php echo e($val['title']); ?>" data-keyword="<?php echo e($val['keyword']); ?>" class="js_input_attr filter hidden" name="attr[]">
                                    <span><?php echo e($val['title']); ?></span>
                                    <div class="product-filter-tick">
                                        <svg enable-background="new 0 0 12 12" viewBox="0 0 12 12" x="0" y="0" class="shopee-svg-icon icon-tick-bold">
                                            <g>
                                                <path d="m5.2 10.9c-.2 0-.5-.1-.7-.2l-4.2-3.7c-.4-.4-.5-1-.1-1.4s1-.5 1.4-.1l3.4 3 5.1-7c .3-.4 1-.5 1.4-.2s.5 1 .2 1.4l-5.7 7.9c-.2.2-.4.4-.7.4 0-.1 0-.1-.1-.1z"></path>
                                            </g>
                                        </svg>
                                    </div>
                                </label>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                    <input id="choose_attr" class="w-full hidden" type="text" name="attr">
                </div>
            </div>
            <div class="overlay-main"></div>
        </div>
        <div class="content-content-product pt-[30px]">
            <div class="">
                <div class="flex flex-wrap justify-start " id="js_data_product_filter">
                    <?php if(!empty($data) && count($data) > 0): ?>
                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="w-1/2 md:w-1/4 px-[5px] md:px-[2px]">
                        <?php echo htmlItemProduct($key, $item, 'item item-product mb-[15px] md:mb-[30px]') ?>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
                <div class="js_pagination_filter wow fadeInUp mt-[20px]">
                    <?php echo e($data->links()); ?>

                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('javascript'); ?>
<style>
    select {
        -webkit-appearance: none;
        -moz-appearance: none;
        text-indent: 1px;
        text-overflow: '';
    }
</style>
<?php echo $__env->make('product.frontend.category.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/product/frontend/category/data.blade.php ENDPATH**/ ?>