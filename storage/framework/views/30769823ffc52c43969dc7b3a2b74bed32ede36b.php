<!-- BEGIN: Data List -->

<div class="">
    <table class="table table-report -mt-2">
        <thead>
            <tr>
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_destroy')): ?>
                <th style="width:40px;">
                    <input type="checkbox" id="checkbox-all">
                </th>
                <?php endif; ?>
                <th>STT</th>
                <th style="width:300px;">Tiêu đề</th>
                <th>Giá</th>
                <th>Vị trí</th>
                <th>Ngày tạo</th>
                <th>Người tạo</th>
                <th>Hiển thị</th>
                <?php echo $__env->make('components.table.is_thead', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <th class="whitespace-nowrap">#</th>
            </tr>
        </thead>
        <tbody id="table_data" role="alert" aria-live="polite" aria-relevant="all">
            <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php $getPrice = getPrice(array('price' => $v->price, 'price_sale' => $v->price_sale, 'price_contact' => $v->price_contact)); ?>
            <tr class="odd " id="post-<?php echo $v->id; ?>">
                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_destroy')): ?>
                <td>
                    <input type="checkbox" name="checkbox[]" value="<?php echo $v->id; ?>" class="checkbox-item">
                </td>
                <?php endif; ?>
                <td>
                    <?php echo e($data->firstItem()+$loop->index); ?>

                </td>
                <td>
                    <div class="flex">
                        <div class="w-10 h-10 image-fit zoom-in mr-2">
                            <img class="rounded-full" src="<?php echo e(asset($v->image)); ?>">
                        </div>
                        <div class="flex-1">
                            <a href="<?php echo e(route('routerURL',['slug' => $v->slug])); ?>" target="_blank" class=" text-primary font-medium"><?php echo $v->title; ?></a>
                            <div class="list-catalogue">
                                <?php $__currentLoopData = $v->relationships; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $kc=>$c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a class="text-danger" href="<?php echo e(route('products.index',['catalogue_id' => $c->id])); ?>"><?php echo !empty($kc == 0) ? '' : ',' ?><?php echo e($c->title); ?></a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </td>
                <td class="">
                    <?php if ($getPrice['price_old']) { ?>
                        <old style="text-decoration: line-through;"><?php echo $getPrice['price_old'] ?><br></old>
                    <?php } ?>
                    <?php echo $getPrice['price_final'] ?>
                </td>
                <?php echo $__env->make('components.order',['module' => 'products'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <td>
                    <?php if($v->created_at): ?>
                    <?php echo e(Carbon\Carbon::parse($v->created_at)->diffForHumans()); ?>

                    <?php endif; ?>
                </td>
                <td>
                    <?php echo e($v->user->name); ?>

                </td>
                <td class="w-40">
                    <?php echo $__env->make('components.publishTable',['module' => 'products','title' => 'publish','id' =>
                    $v->id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </td>
                <?php echo $__env->make('components.table.is_tbody', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <td class="table-report__action w-56 ">
                    <div class="flex justify-center items-center">
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_create')): ?>
                        <a class="flex items-center mr-3" href="<?php echo e(route('products.copy',['id'=>$v->id])); ?>">
                            <i data-lucide="file-minus" class="w-4 h-4 mr-1"></i> Copy
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_edit')): ?>
                        <a class="flex items-center mr-3" href="<?php echo e(route('products.edit',['id'=>$v->id])); ?>">
                            <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit
                        </a>
                        <?php endif; ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('products_destroy')): ?>
                        <a class="flex items-center text-danger ajax-delete-product" href="javascript:void(0);" data-id="<?php echo $v->id ?>" data-title="Lưu ý: Khi bạn xóa sản phẩm, sản phẩm sẽ bị xóa vĩnh viễn. Hãy chắc chắn rằng bạn muốn thực hiện hành động này!">
                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                        </a>
                        <?php endif; ?>
                    </div>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<!-- END: Data List -->
<!-- BEGIN: Pagination -->
<div class="col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center justify-center">
    <?php echo e($data->links()); ?>

</div>
<!-- END: Pagination --><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/product/backend/product/index/data.blade.php ENDPATH**/ ?>