<?php $__env->startSection('content'); ?>

<div class="ps-page--product ps-page--product1 page-infomation page-infomation-2 pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="url('/')">Trang chủ</a></li>
            <li class="ps-breadcrumb__item"><a href="javascript:void(0)">Đặt thuốc online</a></li>

        </ul>
        <div class="content-infomation">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?php echo $__env->make('customer/frontend/auth/common/sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="">
                        <div class="content-tab-information">
                            <table style="margin-top: 0px;">
                                <tbody>
                                    <tr>
                                        <td>STT</td>
                                        <td>Thông tin</td>
                                        <td>Sản phẩm</td>
                                        <td>Ngày đặt</td>
                                    </tr>
                                    <?php if(!empty($data)): ?>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $cart = json_decode($item->products, TRUE); ?>
                                    <tr>
                                        <td> <?php echo e($data->firstItem()+$loop->index); ?></td>
                                        <td>
                                            <p style="margin-bottom: 0px;">Họ và tên: <?php echo e($item->name); ?></p>
                                            <p style="margin-bottom: 0px;">Số điện thoại: <?php echo e($item->phone); ?></p>
                                            <p style="margin-bottom: 0px;">Ghi chú: <?php echo e(!empty($item->message)?$item->message:'-'); ?></p>
                                        </td>
                                        <td>
                                            <?php if($cart): ?>
                                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div>
                                                <span style="color:#333369;    text-decoration: underline;"><?php echo e($val['title']); ?></span> x <?php echo e($val['quantity']); ?>

                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                        </td>
                                        <td><?php echo e($item->created_at); ?></td>
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
<script type="text/javascript" src="<?php echo e(asset('library/daterangepicker/moment.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('library/daterangepicker/daterangepicker.min.js')); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo e(asset('library/daterangepicker/daterangepicker.css')); ?>">
<script type="text/javascript">
    $(function() {
        $('input[name="date"]').daterangepicker({
            locale: {
                format: 'YYYY-MM-DD',
                separator: " to "
            }
        });
    });
</script>
<link href="<?php echo e(asset('library/sweetalert/sweetalert.css')); ?>" rel="stylesheet" type="text/css" />
<script src="<?php echo e(asset('library/sweetalert/sweetalert.min.js')); ?>"></script>
<style>
    /* .menu_order.active {
        border-bottom: 1px solid red;
        color: red;
        font-weight: bold;
    } */
</style>
<script>
    var aurl = window.location.href; // Get the absolute url
    $('.menu_order').filter(function() {
        return $(this).prop('href') === aurl;
    }).parent().addClass('active');
    $(".menu_item_auth:eq(3)").addClass('active');
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/orderOnline/frontend/index.blade.php ENDPATH**/ ?>