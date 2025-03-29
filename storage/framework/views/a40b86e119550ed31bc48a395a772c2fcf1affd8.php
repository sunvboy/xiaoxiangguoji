<?php
$id = $data['id'];
$detail = \App\Models\Order::with('city_name')->with('district_name')->with('ward_name')->find($id);

use App\Components\System;

$system = new System();
$fcSystem = $system->fcSystem();
?>
<table width="100%" cellpadding="0" cellspacing="0" border="0" dir="ltr" align="center" style="background-color:#fff;font-size:16px">
    <tb>
        <tr>
            <td align="left" valign="top" style="margin:0;padding:0">
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="720" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td>
                                <div style="border:2px solid #2f5acf;padding:8px 16px;border-radius:16px;margin-top:16px">
                                    <p style="margin:10px 0 20px;font-weight:bold;font-size:20px">
                                        <?php echo e(trans('index.InformationLine')); ?>

                                        <a href="javascript:void(0)">
                                            #<?php echo e($detail->code); ?>

                                        </a>
                                        <span style="font-weight:normal">(<?php echo e($detail->created_at); ?>)</span>
                                    </p>
                                    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td valign="top">
                                                    <p style="margin:10px 0;font-weight:bold">
                                                        <b><?php echo e(trans('index.AccountInformation')); ?></b>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        <b><?php echo e(trans('index.Fullname')); ?>:</b> <?php echo e($detail->fullname); ?>

                                                    </p>
                                                    <?php if($detail->email): ?>
                                                    <p style="margin:10px 0">
                                                        <b>Email:</b> <a href="mailto:<?php echo e($detail->email); ?>" target="_blank"><?php echo e($detail->email); ?></a>
                                                    </p>
                                                    <?php endif; ?>
                                                    <p style="margin:10px 0">
                                                        <b><?php echo e(trans('index.Phone')); ?>:</b> <?php echo e($detail->phone); ?>

                                                    </p>
                                                </td>
                                                <td valign="top">
                                                    <p style="margin:10px 0;font-weight:bold">
                                                        <b><?php echo e(trans('index.DeliveryAddress2')); ?></b>
                                                    </p>
                                                    <p style="margin:10px 0">
                                                        <b><?php echo e(trans('index.Fullname')); ?>:</b> <?php echo e($detail->fullname); ?>

                                                    </p>
                                                    <?php if($detail->email): ?>
                                                    <p style="margin:10px 0">
                                                        <b>Email:</b> <a href="mailto:<?php echo e($detail->email); ?>" target="_blank"><?php echo e($detail->email); ?></a>
                                                    </p>
                                                    <?php endif; ?>
                                                    <p style="margin:10px 0">
                                                        <b><?php echo e(trans('index.Phone')); ?>:</b> <?php echo e($detail->phone); ?>

                                                    </p>
                                                    <p style="margin:10px 0">
                                                        <b><?php echo e(trans('index.Address')); ?>:</b> <?php echo e($detail->address); ?>

                                                    </p>
                                                    <?php if(!empty($detail->ward_name)): ?>
                                                    <p>
                                                        <b><?php echo e(trans('index.Ward')); ?>:</b>
                                                        <?php echo e(!empty($detail->ward_name)?$detail->ward_name->name:''); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                    <?php if(!empty($detail->district_name)): ?>
                                                    <p>
                                                        <b><?php echo e(trans('index.District')); ?>:</b>
                                                        <?php echo e(!empty($detail->district_name)?$detail->district_name->name:''); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                    <?php if(!empty($detail->city_name)): ?>
                                                    <p>
                                                        <b><?php echo e(trans('index.City')); ?>:</b>
                                                        <?php echo e(!empty($detail->city_name)?$detail->city_name->name:''); ?>

                                                    </p>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    <p style="margin:10px 0">
                                                        <b><?php echo e(trans('index.PaymentMethods')); ?>:</b>
                                                        <?php echo e(config('cart')['payment'][$detail->payment]); ?>

                                                    </p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                        <?php $cart = json_decode($detail->cart, TRUE); ?>
                        <?php $coupon = json_decode($detail->coupon, TRUE); ?>
                        <tr>
                            <td>
                                <div style="border:2px solid #2f5acf;padding:8px 16px;border-radius:16px;margin-top:16px">
                                    <p style="margin:10px 0 20px;font-weight:bold;font-size:20px">
                                        <?php echo e(trans('index.OrderDetails')); ?>

                                    </p>
                                    <table class="m_-8304563403915632023table" cellpadding="0" cellspacing="0" border="0" width="100%" style="font-size:14px">
                                        <thead>
                                            <tr>
                                                <th width="150px" style="text-align:left"><?php echo e(trans('index.TitleProduct')); ?></th>
                                                <th><?php echo e(trans('index.Amount')); ?></th>
                                                <th width="150px"><?php echo e(trans('index.Price')); ?></th>
                                                <th style="text-align:right"><?php echo e(trans('index.intomoney')); ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if($cart): ?>
                                            <?php $__currentLoopData = $cart; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                            $slug = !empty($v['slug']) ? route('routerURL', ['slug' => $v['slug']]) : 'javascript:void(0)';
                                            $unit = !empty($v['unit']) ? $v['unit'] : '';
                                            $options = !empty($v['options']) ? (!empty($v['options']['title_version']) ? $v['options']['title_version'] : '') : '';
                                            ?>
                                            <tr>
                                                <td style="text-align:left">
                                                    <p style="margin:5px 0 0">
                                                        <a href="<?php echo e($slug); ?>" target="_blank"><?php echo e($v['title']); ?></a>
                                                    </p>
                                                    <?php if(!empty($options)): ?>
                                                    <p style="margin-top:3px">
                                                        <span style="font-size:12px;display:block">
                                                            <?php echo e($options); ?>

                                                        </span>
                                                    </p>
                                                    <?php endif; ?>
                                                </td>
                                                <td style="text-align:center">
                                                    <?php echo e($v['quantity']); ?> <?php echo e($unit); ?>

                                                </td>
                                                <td style="text-align:center">
                                                    <b>
                                                        <?php echo e(number_format( $v['price'],0,'.',',')); ?>₫
                                                    </b>

                                                </td>
                                                <td style="text-align:right">
                                                    <?php echo e(number_format($v['quantity'] * $v['price'],0,'.',',')); ?>

                                                    ₫
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="3">
                                                    <b><?php echo e(trans('index.Provisional')); ?></b>
                                                </td>
                                                <td style="text-align:right">
                                                    <?php echo e(number_format($detail->total_price)); ?>₫
                                                </td>
                                            </tr>
                                            <?php if(isset($coupon)): ?>
                                            <?php $__currentLoopData = $coupon; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td colspan="3">
                                                    <b><?php echo e(trans('index.Discount')); ?></b>
                                                </td>
                                                <td style="text-align:right">
                                                    - <?php echo e(number_format($v['price'])); ?>₫
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                            <tr>
                                                <td colspan="3"><b><?php echo e(trans('index.ShippingUnit')); ?></b></td>
                                                <td style="text-align:right">
                                                    <?php echo e($detail->title_ship); ?>

                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3"><b><?php echo e(trans('index.TransportFee')); ?></b></td>
                                                <td style="text-align:right">
                                                    <?php echo e(number_format($detail->fee_ship)); ?>₫
                                                </td>
                                            </tr>
                                            <?php if($detail->payment == 'wallet'): ?>
                                            <tr class="total_payment">
                                                <td colspan="3">
                                                    <?php echo e(trans('index.TotalAmount')); ?>

                                                </td>
                                                <td colspan="2" class="text-right">
                                                    <?php echo e(number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship)); ?>₫
                                                </td>
                                            </tr>
                                            <tr class="total_payment">
                                                <td colspan="3">
                                                    <?php echo e(trans('index.Paid')); ?>

                                                </td>
                                                <td colspan="2" class="text-right">
                                                    <?php echo e(number_format($detail->wallet)); ?>₫
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                            <tr>
                                                <td colspan="3">
                                                    <b> <?php echo e(trans('index.TotalMoneyPayment')); ?></b>
                                                </td>
                                                <td style="text-align:right">
                                                    <b>
                                                        <?php echo e(number_format($detail->total_price-$detail->total_price_coupon+$detail->fee_ship-$detail->wallet)); ?>₫
                                                    </b>
                                                </td>
                                            </tr>

                                        </tfoot>
                                    </table>
                                    <table cellspacing="0" cellpadding="0" border="0" width="100%" style="margin-top:20px;font-size:14px;line-height:24px">
                                        <tbody>
                                            <tr>

                                                <td>
                                                    <p style="font-weight:bold;">
                                                        <?php echo e(trans('index.NeedImmediateAssistance')); ?>

                                                    </p>
                                                    <?php echo e(trans('index.JustFeedbackTo')); ?> <a href="mailto:<?php echo e($fcSystem['contact_email']); ?>" style="text-decoration:none;color:black" target="_blank">
                                                        <b>
                                                            <?php echo e($fcSystem['contact_email']); ?>

                                                        </b>
                                                    </a>
                                                    , <?php echo e(trans('index.OrCallThePhoneNumber')); ?> <a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>" style="text-decoration:none;color:black" target="_blank">
                                                        <b><?php echo e($fcSystem['contact_hotline']); ?></b>
                                                    </a> <?php echo e(trans('index.OrInbox')); ?>

                                                    <?php echo e($fcSystem['homepage_company']); ?> <a href="<?php echo e($fcSystem['social_facebook']); ?>" style="text-decoration:none;color:black" target="_blank">
                                                        <b>
                                                            <?php echo e(trans('index.here')); ?>

                                                        </b>
                                                    </a>
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>
                <table align="center" border="0" cellspacing="0" cellpadding="0" width="720" bgcolor="#ffffff">
                    <tbody>
                        <tr>
                            <td style="font-size:14px;text-align:center;padding:16px 0;line-height:20px">
                                Hotline: <a href="tel:<?php echo e($fcSystem['contact_hotline']); ?>" style="color:black;text-decoration:none" target="_blank"><?php echo e($fcSystem['contact_hotline']); ?></a> |
                                CSKH: <a href="mailto:<?php echo e($fcSystem['contact_email']); ?>" style="color:black;text-decoration:none" target="_blank"><?php echo e($fcSystem['contact_email']); ?></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tb ody>
</table><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/cart/sendmail.blade.php ENDPATH**/ ?>