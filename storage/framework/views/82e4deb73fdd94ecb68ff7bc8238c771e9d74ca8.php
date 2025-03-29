<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Code</th>
            <th>Họ và tên</th>
            <th>Email</th>
            <th>Số điện thoại</th>
            <th>Địa chỉ</th>
            <th>Tổng tiền</th>
            <th>Sản phẩm</th>
            <th>Trạng thái</th>
            <th>Hình thức thanh toán</th>
            <th>Ngày tạo</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $cart = json_decode($item->cart, TRUE); ?>
        <tr>
            <td width="5"><?php echo e($key+1); ?></td>
            <td width="10"><?php echo e($item->code); ?></td>
            <td width="25"><?php echo e($item->fullname); ?></td>
            <td width="35"><?php echo e($item->email); ?></td>
            <td width="15"><?php echo e($item->phone); ?></td>
            <td width="70"><?php echo e($item->address); ?> - <?php echo e($item->ward_name->name); ?> - <?php echo e($item->district_name->name); ?> - <?php echo e($item->city_name->name); ?></td>
            <td width="15"><?php echo e(number_format($item->total_price - $item->total_price_coupon + $item->fee_ship)); ?></td>
            <td width="70">
                <?php $cart = json_decode($item->cart, TRUE); ?>
                <?php $total = 0 ?>
                <?php if($cart): ?>
                <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $options = !empty($v['options']['title_version']) ? '- ' . $v['options']['title_version'] : '';
                ?>
                <div>
                    <?php echo e($v['title']); ?> <?php echo e($options); ?>&nbsp;(<strong>Số lượng:</strong> <?php echo e($v['quantity']); ?>)
                </div><br>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </td>
            <td width="20"><?php echo e(config('cart.status')[$item->status]); ?></td>
            <td width="30"><?php echo e(config('cart.payment')[$item->payment]); ?></td>
            <td width="25"><?php echo e($item->created_at); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/order/backend/export.blade.php ENDPATH**/ ?>