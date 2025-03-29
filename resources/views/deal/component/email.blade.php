<?php
// Create a DateTime object for the specified date
$date = new DateTime();
// Get the day of the week in Vietnamese
$dayOfWeek = $date->format('l');
$daysOfWeek = [
    'Monday' => 'Thứ Hai',
    'Tuesday' => 'Thứ Ba',
    'Wednesday' => 'Thứ Tư',
    'Thursday' => 'Thứ Năm',
    'Friday' => 'Thứ Sáu',
    'Saturday' => 'Thứ Bảy',
    'Sunday' => 'Chủ Nhật'
];
$dayOfWeekInVietnamese = $daysOfWeek[$dayOfWeek];
// Format the date as "Ngày d/m/Y"
$formattedDate = $date->format('d/m/Y');
// Combine the day of the week and the formatted date
$fullDate = $dayOfWeekInVietnamese . ', Ngày ' . $formattedDate;
// Output the result
$id = $data['id'];
$request = $data['request'];
$detail = App\Models\Deal::find($id);
$customer = App\Models\Customer::find($request->customer_id);
$deal_relationships = [];
$product_title =  $request->product_title;
$product_price =  $request->product_price;
$product_quantity =  $request->product_quantity;
$product_price_sale =  $request->product_price_sale;
$product_unit =  $request->product_unit;
$product_price_tax =  $request->product_price_tax;
$product_domain =  $request->product_domain;
$taxInputOfItem =  $request->taxInputOfItem;

if (!empty($product_title)) {
    foreach ($product_title as $key => $item) {
        $deal_relationships[] = [
            'title' => !empty($item) ? $item : '',
            'deal_id' => $id,
            'price' => !empty($product_price) ? $product_price[$key] : 0,
            'total' => $product_price[$key] * $product_quantity[$key],
            'quantity' => !empty($product_quantity) ? $product_quantity[$key] : 0,
            'unit' => !empty($product_unit) ? $product_unit[$key] : '',
            'sales' => !empty($product_price_sale) ? $product_price_sale[$key] : 0,
            'tax' => !empty($product_price_tax) ? $product_price_tax[$key] : 0,
            'tax_price' => !empty($taxInputOfItem) ? $taxInputOfItem[$key] : 0,
            'duy_tri' => !empty($duy_tri) ? $duy_tri[$key] : null,
            'domain' => !empty($product_domain) ? $product_domain[$key] : null,
            'phan_loai' => !empty($phan_loai) ? $phan_loai[$key] : null,
            'created_at' => \Carbon\Carbon::now(),
        ];
    }
}

use App\Components\System;

$system = new System();
$fcSystem = $system->fcSystem();

?>

<div style="background-color: red;">
    <table style="border-collapse:collapse;background-color: #F6F8FC;" border="0" cellpadding="0" cellspacing="0" width="100%">
        <tbody>
            <tr>
                <td style="border-collapse:collapse" align="center" valign="top">
                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="border-collapse:collapse" valign="top">
                                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse;padding-top:9px;padding-bottom:9px;background-color:#4abab9;padding-left:18px;padding-right:18px;border-radius:8px 8px 0 0" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse" valign="top">
                                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;text-align:left"><span style="color:#ffffff"><?php echo $fullDate ?></span></td>
                                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;text-align:right"><span style="color:#ffffff">Hotline: 0904 720 388</span></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="border-collapse:collapse" align="center" valign="top">
                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="border-collapse:collapse" valign="top"></td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="border-collapse:collapse;background-color: #F6F8FC;" align="center" valign="top">
                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="border-collapse:collapse" valign="top">
                                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse;padding-top:20px;padding-bottom:20px;padding-left:20px;padding-right:18px;background-color: #F6F8FC;" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse" valign="top">
                                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="220">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;line-height:150%;text-align:left;padding-top:5px" valign="top"><img src="https://tamphat.edu.vn/uploads/images/logo/logo-doi.png" style="border:0;height:51px;line-height:100%;outline:none;text-decoration:none;width:232px" class="CToWUd" data-bit="iit"></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <table style="border-collapse:collapse" align="right" border="0" cellpadding="0" cellspacing="0" width="409">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;line-height:150%;text-align:left;padding-top:12px" valign="top">
                                                                                    <p style="margin:0;padding-bottom:0;text-align:right"><span style="font-size:14px"><strong>CÔNG TY TNHH PHẦN MỀM <span class="il">TÂM</span> <span class="il">PHÁT</span></strong></span><br> TÊN MIỀN - HOSTING - THIẾT KẾ WEB - QUẢNG CÁO - ĐỒ HỌA</p>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style="border-collapse:collapse;background:#fff;width:95%;margin:0 auto" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;text-align:left;padding-top:10px;padding-bottom:10px;padding-left:19px;padding-right:18px;background-color: #F6F8FC;" valign="top">
                                                                    <div style="margin-bottom:10px">Chào khách hàng <?php echo $customer->name ?>,</div>
                                                                    <div style="margin-bottom:10px"><span class="il">TÂM</span> <span class="il">PHÁT</span> trân trọng cảm ơn quý khách hàng đã quan tâm và sử dụng dịch vụ trong thời gian qua.</div>
                                                                    <div><strong>Chúng tôi kính gửi thông báo về việc sắp hết hạn sử dụng dịch vụ.</strong></div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>


            <tr>
                <td style="border-collapse:collapse" align="center" valign="top">
                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="border-collapse:collapse;background-color: #F6F8FC;" valign="top">

                                    <table style="border-collapse:collapse;background:#fff;width:95%;margin:0 auto" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse;padding-top:0px;padding-bottom:20px;padding-left:18px;padding-right:18px;background-color: #F6F8FC;" valign="top">
                                                    <table width="100%" cellspacing="0" cellpadding="0" border="0" align="left" style="border-collapse:collapse;border-style:solid;border-color:#e5e5e5;border-width:1px">
                                                        <thead>
                                                            <tr>
                                                                <th valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;text-align:left;font-weight:normal;color:#ffffff;padding-bottom:10px;padding-right:15px;padding-left:15px;padding-top:10px;background-color:#36414b">Dịch vụ</th>
                                                                <th valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;text-align:left;font-weight:normal;color:#ffffff;padding-bottom:10px;padding-right:15px;padding-left:15px;padding-top:10px;background-color:#36414b">Tên miền</th>
                                                                <th valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;text-align:left;font-weight:normal;color:#ffffff;padding-bottom:10px;padding-right:15px;padding-left:15px;padding-top:10px;background-color:#36414b">Ngày hết hạn</th>

                                                                <th valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;text-align:left;font-weight:normal;color:#ffffff;padding-bottom:10px;padding-right:15px;padding-left:15px;padding-top:10px;background-color:#36414b">Đơn giá</th>

                                                                <th valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;text-align:left;font-weight:normal;color:#ffffff;padding-bottom:10px;padding-right:15px;padding-left:15px;padding-top:10px;background-color:#36414b">Thời gian</th>

                                                                <th valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;text-align:left;font-weight:normal;color:#ffffff;padding-bottom:10px;padding-right:15px;padding-left:15px;padding-top:10px;background-color:#36414b">Thành tiền</th>

                                                                <th valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;text-align:left;font-weight:normal;color:#ffffff;padding-bottom:10px;padding-right:15px;padding-left:15px;padding-top:10px;background-color:#36414b">VAT</th>

                                                                <th valign="top" style="color:#505050;font-family:Arial;font-size:12px;line-height:150%;text-align:left;text-align:left;font-weight:normal;color:#ffffff;padding-bottom:10px;padding-right:15px;padding-left:15px;padding-top:10px;background-color:#36414b">Tổng tiền</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php foreach ($deal_relationships as $item) {
                                                                $unit = '';
                                                                if ($item['unit'] == 'year') {
                                                                    $unit = 'Năm';
                                                                } else if ($item['unit'] == 'month') {
                                                                    $unit = 'Tháng';
                                                                } else if ($item['unit'] == 'vnd') {
                                                                    $unit = 'VNĐ';
                                                                } else if ($item['unit'] == 'cai') {
                                                                    $unit = 'Cái';
                                                                }
                                                            ?>
                                                                <tr>
                                                                    <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo $item['title'] ?></td>
                                                                    <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo $item['domain'] ?></td>
                                                                    <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo !empty($detail->source_date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->source_date_end)->format('d/m/Y') : '' ?></td>

                                                                    <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo number_format($item['price'], '0', ',', '.') ?> đ/<?php echo $unit ?></td>

                                                                    <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo $item['quantity'] ?> <?php echo $unit ?></td>

                                                                    <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo number_format($item['quantity'] * $item['price'], '0', ',', '.') ?> đ</td>
                                                                    <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo !empty($item['tax'] > 0) ? $item['tax'] . '% : ' : '' ?> <?php echo !empty($item['tax'] > 0) ? number_format(($item['total'] / 100) * $item['tax'], '0', ',', '.') . ' đ' : '' ?></td>


                                                                    <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo number_format($item['total'], '0', ',', '.') ?> đ</td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <td valign="top" colspan="7" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px;text-align: right;font-weight: bold;">Tổng thuế</td>
                                                                <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo number_format($request->price_4, '0', ',', '.') ?> đ</td>
                                                            </tr>
                                                            <tr>
                                                                <td valign="top" colspan="7" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px;text-align: right;font-weight: bold;">Tổng thanh toán</td>
                                                                <td valign="top" style="border-collapse:collapse;color:#505050;font-size:12px;line-height:150%;text-align:left;border-bottom:none;text-align:left;border-top-style:solid;padding-bottom:20px;padding-right:15px;padding-left:15px;padding-top:20px;border-top-color:#d9d9d9;border-top-width:1px"><?php echo number_format($request->price_5, '0', ',', '.') ?> đ</td>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style="border-collapse:collapse;background:#fff;width:95%;margin:0 auto" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse;background-color: #F6F8FC;" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;text-align:left;padding-top:10px;padding-left:19px;padding-right:18px" valign="top">
                                                                    <div><strong>Nếu quí khách hàng không lấy thuế VAT thì vui lòng thanh toán vào các tài khoản sau:</strong></div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style="border-collapse:collapse;background:#fff;width:95%;margin:0 auto" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse;padding-bottom:9px;padding-left:18px;padding-right:18px;background-color: #F6F8FC;" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;line-height:200%;text-align:left" valign="top">
                                                                    <p style="margin:0;padding-bottom:0">Tên tài khoản: <b><span>Trịnh Thị Thanh Tâm</span></b><br> Số TK VNĐ: <b><span>7229597</span></b><br> Ngân hàng thương mại cổ phần Á Châu – ACB<br> Chi nhánh Hoàng Cầu</p>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;line-height:200%;text-align:left" valign="top">
                                                                    <p style="margin:0;padding-bottom:0">Tên tài khoản: <b><span>Trịnh Thị Thanh Tâm</span></b><br> Số TK VNĐ: <b><span>0011004454339</span></b><br> Ngân hàng thương mại cổ phần Ngoại thương Việt Nam – Vietcombank<br> Chi nhánh Ngân hàng Cát Linh, HN </p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style="border-collapse:collapse;background:#fff;width:95%;margin:0 auto" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;text-align:left;padding-top:10px;padding-left:19px;padding-right:18px;background-color: #F6F8FC;" valign="top">
                                                                    <div><strong style="color:red;font-style: italic;">Sau thời gian hết hạn 1 tháng hệ thống sever sẽ update và xóa bộ code ra khỏi sever vì vậy quý khách hàng không gia hạn vui lòng backup lại dữ liệu trước thời gian hết hạn. Nếu sau khi bộ code đã bị xóa quý khách hàng muốn khôi phục lại website công ty Tâm Phát sẽ tính phí khôi phục dữ liệu tùy vào thời điểm khôi phục</strong></div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style="border-collapse:collapse;background:#fff;width:95%;margin:0 auto" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;text-align:left;padding-top:10px;padding-bottom: 20px;padding-left:19px;padding-right:18px;background-color: #F6F8FC;" valign="top">
                                                                    <div><strong>LIÊN HỆ BỘ PHẬN GIA HẠN</strong></div>
                                                                    <div><strong>- Nguyễn Quỳnh Trang</strong></div>
                                                                    <div><strong>- Email: <a href="mailto:ketoan@tamphat.edu.vn">ketoan@tamphat.edu.vn</a></strong></div>
                                                                    <div><strong>- Tel: <b style="color:red">024 7108 2525 - 024 3562 5755</b></strong></div>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse;padding:9px 18px;background-color: #F6F8FC;" align="center" valign="top">
                                                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse" align="center">
                                                                    <table style="border-collapse:collapse;font-family:Helvetica,Arial" border="0" cellpadding="0" cellspacing="0">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border-collapse:collapse" align="center" valign="top">
                                                                                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td style="border-collapse:collapse" valign="top">
                                                                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0">
                                                                                                        <tbody>
                                                                                                            <tr>
                                                                                                                <td style="border-collapse:collapse">
                                                                                                                    <table style="border-collapse:collapse;border-radius:0px;background-color:#f16725" align="left" border="0" cellpadding="0" cellspacing="0">
                                                                                                                        <tbody>
                                                                                                                            <tr>
                                                                                                                                <td style="border-collapse:collapse;color:#ffffff;font-family:Helvetica,Arial;font-size:14px;font-weight:normal" align="center" valign="middle"><a href="" style="text-decoration:none;color:#fff;padding:5px">TIẾN HÀNH GIA HẠN DỊCH VỤ</a></td>
                                                                                                                            </tr>
                                                                                                                        </tbody>
                                                                                                                    </table>
                                                                                                                </td>
                                                                                                            </tr>
                                                                                                        </tbody>
                                                                                                    </table>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>

            <tr>
                <td style="border-collapse:collapse" align="center" valign="top">
                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="border-collapse:collapse" valign="top">
                                    <table style="border-collapse:collapse;background:#fff;width:95%;margin:0 auto;background-color: #F6F8FC;" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse;color:#36414b;font-family:Helvetica,Arial;font-size:12px;line-height:200%;text-align:left;padding-top:30px;padding-bottom:9px;padding-left:18px;padding-right:18px" valign="top"><strong>Thời gian cho phép gia hạn dịch vụ như sau <strong>(kể từ ngày hết hạn trên đơn hàng)</strong>: </strong>
                                                                    <p style="margin:0;padding-bottom:1em">- <strong>Hosting: sau <span style="color:#ff0000"><strong><span>15 ngày</span></strong></span> sẽ bị xóa khỏi server.</strong><br>- <strong>Tên miền: sau <span style="color:#ff0000"><strong>20 ngày</strong></span> sẽ không thực hiện được lệnh gia hạn. (Áp dụng với tên miền .com/net/org/biz/info, các tên miền đuôi còn lại khách hàng chủ động gia hạn trước thời điểm hết hạn <span style="color:#ff0000"><strong>15 ngày</strong></span> để tránh tên miền bị xóa vào ngày hết hạn).<br>- Đối với server: Dịch vụ sẽ tạm ngưng ngay sau ngày hết hạn và sẽ bị xóa sau 3 ngày tạm ngưng.</strong></p>
                                                                    <p style="margin:0;padding-bottom:1em"><b>Lưu ý:</b> Khi gia hạn hosting, Quý khách được lựa chọn chính sách ưu đãi sau:</p>
                                                                    <p style="margin:0;padding-bottom:1em"><span style="color:#0066cc"><strong>Khách hàng đăng ký mới hoặc gia hạn hosting 2GB trở lên:</strong></span><br> - Thanh toán <span style="color:#ff8c00"><strong>02 năm</strong></span> được giảm <span style="color:#ff8c00"><strong>10%</strong></span><br> - Thanh toán <span style="color:#ff8c00"><strong>03 năm</strong></span> được giảm <strong><span style="color:#ff8c00">15%</span></strong><br> - Thanh toán <span style="color:#ff8c00"><strong>04 năm</strong></span> được giảm <span style="color:#ff8c00"><strong>20%</strong></span><br> - Thanh toán <span style="color:#ff8c00"><strong>05 năm</strong></span> được giảm <span style="color:#ff8c00"><strong>25%</strong></span></p>
                                                                    <p style="margin:0;padding-bottom:1em"><b>Lưu ý:</b><br>- Đối với tên miền quốc tế đăng ký mới khách hàng cần chủ động check email đăng ký dịch vụ để xác nhận thông tin sở hữu với hệ thống trong vòng 15 ngày. Trường hợp tên miền không được xác nhận trong thời gian quy định hệ thống sẽ tự động suspend tên miền.<br>- Quý khách vui lòng thanh toán trước ngày kết thúc để dịch vụ không bị gián đoạn.<br>- Vui lòng liên hệ với bộ phận kinh doanh TÂM PHÁT để xác nhận trước khi thanh toán.</p>
                                                                    <p style="margin:0;padding-bottom:1em"><b>Lưu ý:</b><br>- Xin ghi rõ trong thông tin chuyển tiền: Tên khách hàng và tên miền sử dụng cho gói hosting. Nếu quý khách không cung cấp đầy đủ thông tin dẫn đến việc không xác định được nộp phí cho gói dịch vụ nào thì coi như Quý khách chưa nộp phí.<br>- Quý khách yêu cầu viết hóa đơn GTGT: Vui lòng gửi cho chúng tôi theo địa chỉ email <a href="mailto:contact@tamphat.edu.vn">contact@tamphat.edu.vn</a> thông tin viết hóa đơn (tên đơn vị mua hàng, địa chỉ, mã số thuế) và địa chỉ nơi nhận hóa đơn (Tên người nhận, Tên công ty, địa chỉ, điện thoại).<br><strong>Trân Trọng Cảm ơn</strong></p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="border-collapse:collapse" align="center" valign="top">
                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="border-collapse:collapse" valign="top">
                                    <table style="border-collapse:collapse;background:#fff;width:95%;margin:0 auto" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse" valign="top">
                                                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse;padding:20px;background-color: #F6F8FC;" valign="top">

                                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                                        <tbody>
                                                                            <tr>
                                                                                <td style="border-collapse:collapse" valign="top">
                                                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="200">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;text-align:left;padding-top:28px"><img src="https://tamphat.edu.vn/uploads/images/logo/logo-doi.png" style="border:0;height:auto;line-height:100%;outline:none;text-decoration:none;width:200px" class="CToWUd" data-bit="iit"></td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                    <table style="border-collapse:collapse" align="right" border="0" cellpadding="0" cellspacing="0" width="440">
                                                                                        <tbody>
                                                                                            <tr>
                                                                                                <td style="border-collapse:collapse;color:#505050;font-family:Helvetica,Arial;font-size:12px;text-align:left;padding-left:20px;line-height:25px">
                                                                                                    <div><b>CÔNG TY TNHH PHẦN MỀM TÂM PHÁT</b></div>
                                                                                                    <div>Địa chỉ: Số 55/ 649 Kim Mã, Phường Ngọc Khánh, Quận Ba Đình, TP Hà Nội</div>
                                                                                                    <div>Tel: <strong>(024) 71082525 - (024) 35625755</strong> - Hotline: <strong>0904 720 388 / 0989 949 123</strong></div>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </tbody>
                                                                                    </table>
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
            <tr>
                <td style="border-collapse:collapse" align="center" valign="top">
                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                        <tbody>
                            <tr>
                                <td style="border-collapse:collapse" valign="top">
                                    <table style="border-collapse:collapse" border="0" cellpadding="0" cellspacing="0" width="100%">
                                        <tbody>
                                            <tr>
                                                <td style="border-collapse:collapse;background-color:#4abab9;border-radius:0 0 8px 8px" valign="top">
                                                    <table style="border-collapse:collapse" align="left" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tbody>
                                                            <tr>
                                                                <td style="border-collapse:collapse;color:#ffffff;font-family:Helvetica,Arial;font-size:12px;text-align:center;padding-top:10px;padding-bottom:10px;padding-left:18px;padding-right:18px" valign="top"><span><span style="color:#ffffff"><span style="font-size:12px">Copyright (c) 2005 – 2024 Tam Phat Software Company. All Rights Reserved</span></span></span></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</div>