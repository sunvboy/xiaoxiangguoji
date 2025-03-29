<?php $__env->startSection('title'); ?>
<title>Chi tiết đơn hàng</title>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('breadcrumb'); ?>
<?php
$array = array(
    [
        "title" => "Danh sách đơn hàng",
        "src" => route('orders.index'),
    ],
    [
        "title" => "Cập nhập đơn hàng",
        "src" => 'javascript:void(0)',
    ]
);
echo breadcrumb_backend($array);
?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div class="content">
    <div class=" flex flex-col sm:flex-row items-center mt-8">
        <h2 class="flex items-center text-lg font-medium mr-auto">
            Đơn hàng <i class="w-4 h-4 mx-2 !stroke-2" data-lucide="arrow-right"></i> #<?php echo e($detail->code); ?>

        </h2>

    </div>
    <div class="grid grid-cols-12 gap-5 mt-5">
        <!-- BEGIN: Order Detail Side Menu -->
        <div class="col-span-12 md:col-span-4">
            <div class="box  p-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Chi tiết giao dịch</div>
                </div>
                <div class="flex items-center"> <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Mã đơn hàng: <button class="underline decoration-dotted ml-1"><?php echo e($detail->code); ?></button>
                </div>
                <div class="flex items-center mt-3"> <i data-lucide="calendar" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Ngày đặt: <?php echo e($detail->created_at); ?> </div>
                <div class="flex items-center mt-3 space-x-1 flex-wrap"> <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Trạng thái đơn hàng:
                    <?php
                    if ($detail->status == 'wait') {
                        $class = 'btn-secondary';
                    } else if ($detail->status == 'pending') {
                        $class = 'btn-pending';
                    } else if ($detail->status == 'transported') {
                        $class = 'btn-warning';
                    } else if ($detail->status == 'completed') {
                        $class = 'btn-success';
                    } else if ($detail->status == 'canceled') {
                        $class = 'btn-danger';
                    } else if ($detail->status == 'returns') {
                        $class = 'bg-primary text-white';
                    }
                    ?>
                    <span class="btn <?php echo e($class); ?> text-xs rounded-full px-2 py-1">
                        <?php echo config('cart')['status'][$detail->status]; ?>
                    </span>
                    <?php if($detail->order_returns): ?>
                    <?php if($detail->order_returns->status == 0): ?>
                    <span class="text-xs text-white bg-danger border  rounded-md border-warning/20 px-1.5 py-0.5 ml-1">Đang chờ duyệt</span>
                    <?php else: ?>
                    <span class="text-xs whitespace-nowrap text-white bg-success border border-warning/20 rounded-full px-2 py-1">Đã duyệt</span>
                    <?php endif; ?>
                    <?php endif; ?>

                </div>
                <?php if($detail->status != 'returns' && $detail->status != 'canceled'): ?>
                <div class="flex items-center mt-3"> <i data-lucide="edit" class="w-4 h-4 text-slate-500 mr-2"></i>
                    Cập nhập trạng thái đơn hàng:
                </div>
                <select class="form-control tom-select tom-select-custom mt-3" data-id="<?php echo e($detail->id); ?>">
                    <?php $__currentLoopData = config('cart')['status']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $l=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($l); ?>" <?php if ($detail->status == $l) { ?>selected<?php } ?>>
                        <?php echo e($val); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
                <?php endif; ?>

            </div>
            <div class="box  p-5 mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Thông tin người mua</div>
                </div>
                <div class="space-y-2">
                    <div class="flex items-center">
                        <b>Họ và tên:</b> <span class=" decoration-dotted ml-1"><?php echo e($detail->fullname); ?></span>
                    </div>
                    <div class="flex items-center">
                        <b>Số điện thoại:</b> <span class=" decoration-dotted ml-1"><?php echo e($detail->phone); ?></span>
                    </div>
                    <?php if($detail->email): ?>
                    <div class="flex items-center">
                        <b>Email:</b> <span class="decoration-dotted ml-1"><?php echo e($detail->email); ?></span>
                    </div>
                    <?php endif; ?>
                    <div class="flex items-center">
                        <b>Địa chỉ:</b> <span class=" decoration-dotted ml-1"><?php echo e($detail->address); ?></span>
                    </div>
                    <?php if(!empty($detail->ward_name->name)): ?>
                    <div class="flex items-center">
                        <b>Phường/Xã:</b> <span class=" decoration-dotted ml-1"><?php echo e($detail->ward_name->name); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($detail->district_name->name)): ?>
                    <div class="flex items-center">
                        <b>Quận/Huyện:</b> <span class=" decoration-dotted ml-1"><?php echo e($detail->district_name->name); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if(!empty($detail->city_name->name)): ?>
                    <div class="flex items-center">
                        <b>Tỉnh/Thành phố:</b> <span class=" decoration-dotted ml-1"><?php echo e($detail->city_name->name); ?></span>
                    </div>
                    <?php endif; ?>
                    <?php if($detail->note): ?>
                    <div class="">
                        <div>
                            <b>Ghi chú:</b>
                        </div>
                        <div>
                            <?php echo e($detail->note); ?>

                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
            <div class="box  p-5 mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Chi tiết thanh toán</div>
                </div>
                <div class="flex items-center">
                    <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Thanh toán:
                    <div class="ml-auto font-semibold"><?php echo config('cart')['payment'][$detail->payment]; ?></div>
                </div>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Tạm tính:
                    <div class="ml-auto font-semibold"><?php echo e(number_format($detail->total_price,0,',','.')); ?>₫</div>
                </div>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Đơn vị vận chuyện:
                    <div class="ml-auto font-semibold"><?php echo e($detail['title_ship']); ?></div>
                </div>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Phí vận chuyện:
                    <div class="ml-auto font-semibold"><?php echo e(number_format($detail['fee_ship'],0,',','.')); ?>₫</div>
                </div>
                <?php $coupon = json_decode($detail->coupon, TRUE); ?>
                <?php if(isset($coupon)): ?>
                <?php $__currentLoopData = $coupon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Mã giảm giá<span class="font-semibold text-danger">(<?php echo e($v['name']); ?>)</span>
                    <div class="ml-auto font-semibold">-<?php echo e(number_format($v['price'],0,',','.')); ?>₫</div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>

                <?php if($detail->payment == 'wallet'): ?>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Tổng tiền:
                    <div class="ml-auto font-semibold"><?php echo e(number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship,0,',','.')); ?>₫</div>
                </div>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Đã thanh toán:
                    <div class="ml-auto font-semibold"><?php echo e(number_format($detail->wallet,0,',','.')); ?> ₫</div>
                </div>
                <?php endif; ?>

                <div class="flex items-center border-t border-slate-200/60 dark:border-darkmode-400 pt-5 mt-5 font-medium">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i>Tổng tiền phải thanh toán:
                    <div class="ml-auto font-bold text-danger">
                        <?php echo e(number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship-$detail->wallet,0,',','.')); ?>₫
                    </div>
                </div>
            </div>
            <?php if($detail->order_returns): ?>
            <div class="box  p-5 mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Chi tiết hoàn/trả</div>
                </div>
                <div class="flex items-center">
                    <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Trạng thái:
                    <div class="ml-auto font-semibold">
                        <?php if($detail->order_returns->status == 0): ?>
                        <span class="text-xs text-white bg-danger border  rounded-md border-warning/20 px-1.5 py-0.5 ml-1">Đang chờ duyệt</span>
                        <?php else: ?>
                        <span class="text-xs whitespace-nowrap text-white bg-success border border-warning/20 rounded-full px-2 py-1">Đã duyệt</span>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex items-center mt-3">
                    <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Ngày:
                    <div class="ml-auto font-semibold"><?php echo $detail->order_returns->updated_at; ?></div>
                </div>
                <div class="flex items-center mt-3">
                    <i data-lucide="credit-card" class="w-4 h-4 text-slate-500 mr-2"></i> Số tiền hoàn lại:
                    <div class="ml-auto font-semibold"><?php echo e(number_format($detail->order_returns->price_return,0,',','.')); ?>₫</div>
                </div>

            </div>
            <?php endif; ?>
        </div>
        <!-- END: Order Detail Side Menu -->
        <!-- BEGIN: Order Detail Content -->
        <?php $cart = json_decode($detail->cart, TRUE); ?>
        <div class="col-span-12 md:col-span-8">
            <div class="box  p-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Sản phẩm</div>
                </div>
                <div>
                    <?php $total = 0 ?>
                    <?php if($cart): ?>
                    <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $total += $v['price'] * $v['quantity'];
                    $slug = !empty($v['slug']) ? $v['slug'] : '';
                    $unit = !empty($v['unit']) ? $v['unit'] : 'sản phẩm';
                    $options = !empty($v['options']['title_version']) ? $v['options']['title_version'] : '';
                    ?>
                    <div class="flex flex-col md:flex-row items-center py-4 first:pt-0 last:border-0 last:pb-0 border-b border-dashed border-slate-200 dark:border-darkmode-400">
                        <div class="flex items-center md:mr-auto flex-1">
                            <div class="image-fit w-16 h-16">
                                <img src="<?php echo e(url($v['image'])); ?>" class="rounded-lg border-2 border-white shadow-md" alt="<?php echo e($v['title']); ?>">
                            </div>
                            <div class="ml-5">
                                <div class="font-bold text-danger"><?php echo e($v['title']); ?></div>
                                <div>
                                    <?php echo e($options); ?>

                                </div>
                                <div class="text-slate-500 mt-1"><?php echo e($v['quantity']); ?> <?php echo e($unit); ?> x
                                    <?php echo e(number_format($v['price'],0,',','.')); ?>

                                </div>

                            </div>
                        </div>

                        <div class="py-4 md:pl-12 md:pr-10 md:border-l text-center md:text-left border-dashed border-slate-200 dark:border-darkmode-400" style="width:200px">
                            <div class="text-slate-500">Thành tiền</div>
                            <div class="font-medium mt-1"><?php echo e(number_format($v['price']*$v['quantity'],0,',','.')); ?>₫
                            </div>
                        </div>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php if($detail->order_returns): ?>
            <?php $cartReturn = json_decode($detail->order_returns->cart, TRUE); ?>
            <div class="box  p-5 mt-5">
                <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                    <div class="font-medium text-base truncate">Sản phẩm hoàn/trả</div>
                </div>
                <div>
                    <?php if($cartReturn): ?>
                    <?php $__currentLoopData = $cartReturn; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $slug = !empty($v['slug']) ? $v['slug'] : '';
                    $options = !empty($v['options']['title_version']) ? $v['options']['title_version'] : '';
                    $unit = !empty($v['unit']) ? $v['unit'] : 'sản phẩm';
                    ?>
                    <?php if(!empty($v['quantity_return'])): ?>
                    <div class="flex flex-col md:flex-row items-center py-4 first:pt-0 last:border-0 last:pb-0 border-b border-dashed border-slate-200 dark:border-darkmode-400">
                        <div class="flex items-center md:mr-auto flex-1">
                            <div class="image-fit w-16 h-16">
                                <img src="<?php echo e(url($v['image'])); ?>" class="rounded-lg border-2 border-white shadow-md" alt="<?php echo e($v['title']); ?>">
                            </div>
                            <div class="ml-5">
                                <div class="font-bold text-danger"><?php echo e($v['title']); ?></div>
                                <div>
                                    <?php echo e($options); ?>

                                </div>
                                <div class="text-slate-500 mt-1">Hoàn lại <?php echo e($v['quantity_return']); ?> <?php echo e($unit); ?> x
                                    <?php echo e(number_format($v['price'],0,',','.')); ?>

                                </div>
                            </div>
                        </div>
                        <div class="py-4 md:pl-12 md:pr-10 md:border-l text-center md:text-left border-dashed border-slate-200 dark:border-darkmode-400" style="width:200px">
                            <div class="text-slate-500">Thành tiền</div>
                            <div class="font-medium mt-1"><?php echo e(number_format($v['price']*$v['quantity_return'],0,',','.')); ?>₫
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
        <!-- END: Order Detail Content -->
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>
<script src="<?php echo e(asset('library/toastr/toastr.min.js')); ?>"></script>
<link href="<?php echo e(asset('library/toastr/toastr.min.css')); ?>" rel="stylesheet">
<script>
    $(document).on('change', '.tom-select-custom', function() {
        var id = $(this).attr('data-id');
        var status = $(this).val();
        $.ajax({
            type: 'POST',
            url: "<?php echo e(route('orders.ajaxUploadStatus')); ?>",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                id: id,
                status: status
            },
            success: function(data) {

                swal({
                    title: "Cập nhập trạng thái đơn hàng thành công!",
                    type: "success"
                }, function() {
                    location.reload();
                });
            },
            error: function(jqXhr, json, errorThrown) {
                toastr.error('Cập nhập đơn hàng không thành công', 'Error!')
            },
        });

    });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('dashboard.layout.dashboard', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/order/backend/edit.blade.php ENDPATH**/ ?>