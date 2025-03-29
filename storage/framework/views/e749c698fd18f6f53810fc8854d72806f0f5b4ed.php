<?php $__env->startSection('content'); ?>
<div class="ps-page--product ps-page--product1 page-infomation page-infomation-2 page-infomation-3 pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="url('/')">Trang chủ</a></li>
            <li class="ps-breadcrumb__item"><a href="javascript:void()">Danh sách mã khuyến mãi</a></li>

        </ul>
        <div class="content-infomation">

            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?php echo $__env->make('customer/frontend/auth/common/sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="content-information-2  bg-white">
                        <h3 class="title-3">Danh sách mã khuyến mãi</h3>
                        <div class="content-tab-information">
                            <table>
                                <tbody>
                                    <tr>
                                        <td style="text-align: left;">CODE</td>
                                        <td style="text-align: left;">Tên mã</td>
                                        <td style="text-align: left;">Loại ưu đãi</td>
                                        <td style="text-align: left;">Thời hạn sử dụng</td>
                                        <td style="text-align: left;">Chiết khấu</td>
                                    </tr>
                                    <?php if(!empty($data)): ?>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-left" style="font-weight: bold;">
                                            <?php echo $item->name; ?>
                                        </td>
                                        <td>
                                            <?php echo $item->title; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($item->type == 'fixed_cart_percent') {
                                                echo 'Giảm giá phần trăm giỏ hàng cố định';
                                            } elseif ($item->type == 'fixed_cart_money') {
                                                echo 'Giảm giá tiền giỏ hàng cố định';
                                            } elseif ($item->type == 'fixed_percent') {
                                                echo 'Giảm giá phần trăm sản phẩm có trong giỏ hàng';
                                            } elseif ($item->type == 'fixed_money') {
                                                echo 'Giảm giá tiền sản phẩm có trong giỏ hàng';
                                            }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo !empty($item->date_end) ? $item->date_end : '-'; ?>
                                        </td>
                                        <td>
                                            <?php
                                            if ($item->type == 'fixed_cart_percent') {
                                                echo $item->value . '%';
                                            } elseif ($item->type == 'fixed_cart_money') {
                                                echo number_format($item->value, '0', ',', '.') . ' đ';
                                            } elseif ($item->type == 'fixed_percent') {
                                                echo $item->value . ' %';
                                            } elseif ($item->type == 'fixed_money') {
                                                echo number_format($item->value, '0', ',', '.') . ' đ';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>


                                </tbody>
                            </table>
                            <div class="ps-pagination">
                                <?php echo $__env->make('homepage.common.pagination', ['paginator' => $data, 'interval' => 2], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        </div>


                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('javascript'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/customer/frontend/manager/coupons.blade.php ENDPATH**/ ?>