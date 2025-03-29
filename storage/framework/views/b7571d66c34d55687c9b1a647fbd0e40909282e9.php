<?php $__env->startSection('content'); ?>

<div class="ps-page--product ps-page--product1 page-infomation page-infomation-2 pb-120 bg-gray">
    <div class="container">
        <ul class="ps-breadcrumb">
            <li class="ps-breadcrumb__item"><a href="url('/')">Trang chủ</a></li>
            <li class="ps-breadcrumb__item"><a href="javascript:void(0)"><?php echo e(trans('index.PurchaseHistory')); ?></a></li>

        </ul>
        <div class="content-infomation">
            <div class="row">
                <div class="col-md-3 col-sm-3 col-xs-12">
                    <?php echo $__env->make('customer/frontend/auth/common/sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-md-9 col-sm-9 col-xs-12">
                    <div class="content-information-2  bg-white">
                        <div class="tab-information">
                            <ul>
                                <li>
                                    <a href="<?php echo e(route('customer.orders')); ?>" class="menu_order">Tất cả</a>
                                </li>
                                <?php $__currentLoopData = config('cart.status'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li>
                                    <a href="<?php echo e(route('customer.orders',['status' => $key])); ?>" class="menu_order"><?php echo $val ?></a>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                        <div class="content-tab-information">
                            <table>
                                <tbody>
                                    <tr>
                                        <td>Mã đơn</td>
                                        <td>Sản phẩm</td>
                                        <td>Tổng tiền</td>
                                        <td>Ngày đặt</td>
                                        <td>Trạng thái</td>
                                    </tr>
                                    <?php if(!empty($data)): ?>
                                    <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $cart = json_decode($item->cart, TRUE); ?>

                                    <tr>
                                        <td style="font-weight: bold;">#<?php echo e($item->code); ?></td>

                                        <td>
                                            <?php if($cart): ?>
                                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$val): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $slug = !empty($val['slug']) ? $val['slug'] : '';
                                            $options = !empty($val['options']['title_version']) ?  $val['options']['title_version'] : '';
                                            $unit = !empty($val['unit']) ? $val['unit'] : '';
                                            ?>
                                            <div>
                                                <span style="font-weight: 500;"><?php echo e($val['title']); ?></span> x <?php echo e($val['quantity']); ?> <?php echo e($unit); ?>

                                            </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>

                                        </td>
                                        <td><?php echo number_format($item->total_price - $item->total_price_coupon + $item->fee_ship); ?>₫</td>
                                        <td><?php echo e($item->created_at); ?></td>
                                        <td><?php echo config('cart.status')[$item->status] ?></td>
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
    $(".menu_item_auth:eq(2)").addClass('active');
    $(document).on('click', '.js_delete_customer_cart', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        swal({
                title: "<?php echo trans('index.AreYouSure') ?>",
                text: '',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "<?php echo trans('index.Perform') ?>",
                cancelButtonText: "<?php echo trans('index.Cancel') ?>",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    let formURL = "<?php echo route('customer.deleteOrder') ?>";
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                        },
                        url: formURL,
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.status === 200) {
                                swal({
                                    title: "<?php echo trans('index.DeleteSuccessfully') ?>",
                                    text: "<?php echo trans('index.DeleteSuccessfullyInfo') ?>",
                                    type: "success"
                                }, function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: "<?php echo trans('index.DeleteSuccessfullyInfo2') ?>",
                                    text: "<?php echo trans('index.DeleteSuccessfullyInfo3') ?>",
                                    type: "error"
                                }, function() {
                                    location.reload();
                                });
                            }
                        },
                        error: function(jqXhr, json, errorThrown) {
                            var errors = jqXhr.responseJSON;
                            var errorsHtml = "";
                            $.each(errors["errors"], function(index, value) {
                                errorsHtml += value + "/ ";
                            });
                            console.log(errorsHtml)
                        },
                    });
                } else {
                    swal({
                        title: "<?php echo trans('index.Cancel') ?>",
                        text: "<?php echo trans('index.CancelInfo') ?>",
                        type: "error"
                    }, function() {
                        location.reload();
                    });
                }
            }
        );
    })
</script>
<?php echo $__env->make('customer.frontend.order.return', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('homepage.layout.home', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/catdailoc/domains/daicatloc.nhathuocdaicatloc.vn/public_html/resources/views/customer/frontend/order/index.blade.php ENDPATH**/ ?>