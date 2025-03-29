<?php
if ($errors->any()) {
    $catalogue  = old('attribute_catalogue');
    $checkbox  = old('checkbox_val');
    $attribute = old('attribute');
    /*version product */
    $title_version = old('title_version');
    $image_version = old('image_version');
    $code_version = old('code_version');
    $_stock_status = old('_stock_status');
    // $_stock = old('_stock');
    $_outstock_status =  old('_outstock_status');
    $price_version =  old('price_version');
    $price_sale_version =  old('price_sale_version');
    $price_import_version =  old('price_import_version');
    $status_version =  old('status_version');
    $_ships_weight =  old('_ships_weight');
    $_ships_length =  old('_ships_length');
    $_ships_width =  old('_ships_width');
    $_ships_height =  old('_ships_height');
    // $_stock_address =  old('_stock_address');
} else if ($action == 'update') {
    $version_json = json_decode(base64_decode($detail->version_json), true);
    $checkbox = $version_json[0];
    $catalogue  = $version_json[1];
    $attribute = $version_json[2];
    /*version product */
    if ($detail->product_versions) {
        foreach ($detail->product_versions as $key => $val) {
            $ids[] = $val['id'];
            $id_version[] = $val['id_version'];
            $title_version[] = $val['title_version'];
            $image_version[] = $val['image_version'];
            $code_version[] = $val['code_version'];
            $_stock_status[] = $val['_stock_status'];
            // $_stock[] = $val['_stock'];
            $_outstock_status[] = $val['_outstock_status'];
            $price_import_version[] =  number_format($val['price_import_version'], '0', ',', '.');
            $price_version[] =  number_format($val['price_version'], '0', ',', '.');
            $price_sale_version[] =  number_format($val['price_sale_version'], '0', ',', '.');
            $status_version[] = $val['status_version'];
            $_ships_weight[] =  $val['_ships_weight'];
            $_ships_length[] =  $val['_ships_length'];
            $_ships_width[] =  $val['_ships_width'];
            $_ships_height[] =  $val['_ships_height'];
        }
    }
    // echo "<pre>";
    // print_r($catalogue);
    // echo "<pre>";
    // print_r($attribute);
    // die;
}
if (isset($title_version)) {
    $version = count($title_version);
} else {
    $version = 0;
}
?>
<div class="box p-5 mt-3 space-y-3 <?php if (!in_array('attributes', $dropdown)) { ?>hidden<?php } ?>">
    <div>
        <label class="form-label text-base font-semibold">Bộ lọc sản phẩm</label>
    </div>
    <div class="ibox mb-5 block-version" data-countattribute_catalogue="<?php echo count($htmlAttribute) - 1 ?>">
        <div class="ibox-title">
            <div class="grid grid-cols-3 justify-between text-base  items-center">
                <div class="col-span-2">
                    <h5>Chọn bộ lọc thuộc tính cho sản phẩm</h5>
                    <small class="text-danger mt-3 ">Sản phẩm có các phiên bản dựa theo thuộc tính như kích thước hoặc màu sắc,...?(chọn tối đa 2 )</small>
                </div>
                <div class="text-right">
                    <a class="show-version btn btn-danger" href="javascript:void(0)" <?php echo (!empty($catalogue)) ? 'style="display:none"' : '' ?>>
                        <i data-lucide="plus" class="w-6 h-6 text-white"></i>
                    </a>
                    <a class="hide-version btn btn-danger" href="javascript:void(0)" <?php echo (!empty($catalogue)) ? '' : 'style="display:none"' ?>>Đóng</a>
                </div>
            </div>
        </div>
        <div class="ibox-content mt-5" style=" <?php echo (!empty($catalogue)) ? '' : 'display:none"' ?>">
            <div class="block-attribute">
                <div class="mb-3 overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <td class="s_tdVariable">Sản phẩm biến thể</td>
                                <td style="width: 30%;">Tên thuộc tính</td>
                                <td style="width: 50%;">Giá trị thuộc tính (Các giá trị cách nhau bởi dấu phẩy)</td>
                                <td style="width: 10%;"></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($catalogue)) { ?>
                                <?php foreach ($catalogue as $key => $value) {
                                    if (isset($attribute_json[$key])) { ?>
                                        <tr data-id="<?php echo $value ?>" <?php echo (isset($checkbox[$key]) && $checkbox[$key] == 1) ? 'class="bg-choose"' : '' ?>>
                                            <td class="s_tdVariable" data-index="<?php echo $key ?>">
                                                <?php if (isset($checkbox[$key]) && $checkbox[$key] == 1) { ?>
                                                    <input type="checkbox" checked name="checkbox[]" value="1" class="checkbox-item">
                                                    <input type="text" name="checkbox_val[]" value="1" class="hidden">
                                                    <div for="" class="label-checkboxitem checked"></div>
                                                <?php } else { ?>
                                                    <input type="checkbox" name="checkbox[]" value="1" class="checkbox-item">
                                                    <input type="text" name="checkbox_val[]" value="0" class="hidden">
                                                    <div for="" class="label-checkboxitem "></div>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <select class="form-control select3" name="attribute_catalogue[]" tabindex="-1" aria-hidden="true">
                                                    <?php $__currentLoopData = $htmlAttribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$v): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($k); ?>" <?php echo e($value == $k ? 'selected' : ''); ?>><?php echo e($v); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </td>
                                            <td>
                                                <?php if ($value == 0) { ?>
                                                    <input type="text" class="form-control" disabled="disabled">
                                                <?php } else { ?>
                                                    <select name="attribute[<?php echo $key ?>][]" data-stt="<?php echo e($key); ?>" data-json="<?php echo (isset($attribute_json[$key])) ? base64_encode(json_encode($attribute_json[$key])) : '' ?>" data-condition="<?php echo $value ?>" class="form-control selectMultipe" multiple="multiple" data-title="Nhập 2 kí tự để tìm kiếm.." data-module="attributes" style="width: 100%;">
                                                    </select>
                                                <?php } ?>
                                            </td>
                                            <td>
                                                <a type="button" class="text-danger delete-attribute" data-id="">
                                                    <svg viewBox="0 0 20 20" class="Polaris-Icon__Svg_375hu" focusable="false" aria-hidden="true" style="fill: red;width:20px;height20px">
                                                        <path d="M8 3.994c0-1.101.895-1.994 2-1.994s2 .893 2 1.994h4c.552 0 1 .446 1 .997a1 1 0 0 1-1 .997h-12c-.552 0-1-.447-1-.997s.448-.997 1-.997h4zm-3 10.514v-6.508h2v6.508a.5.5 0 0 0 .5.498h1.5v-7.006h2v7.006h1.5a.5.5 0 0 0 .5-.498v-6.508h2v6.508a2.496 2.496 0 0 1-2.5 2.492h-5c-1.38 0-2.5-1.116-2.5-2.492z"></path>
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="flex" style="padding: 0px 20px 10px 20px;">
                    <a href="javascript:void(0)" data-attribute="<?php echo base64_encode(json_encode($htmlAttribute)) ?>" class="add-attribute btn btn-danger" data-id=""><i class="fa fa-plus"></i> Thêm thuộc tính cho sản phẩm
                    </a>
                </div>
            </div>
            <!-- START: check all update image -->
            <div class="flex justify-between items-center bg-white" style="padding: 10px;">
                <label class="flex items-center cursor-pointer">
                    <input type="checkbox" name="" value="" class="mr-3 s_checkAll">
                    <span class="font-bold text-danger">Phiên bản sản phẩm</span>
                </label>
                <div class="dropdown s_updateImg hidden">
                    <a href="javascript:void(0)" class="dropdown-toggle btn btn-primary" aria-expanded="false" data-tw-toggle="dropdown">Thao tác</a>
                    <div class="dropdown-menu w-40">
                        <ul class="dropdown-content">
                            <li>
                                <a href="javascript:void(0)" data-tw-toggle="modal" data-tw-target="#superlarge-modal-size-preview" class="dropdown-item s_popupSelectImg">Cập nhập ảnh đại diện</a>
                            </li>
                            <li> <a href="javascript:void(0)" class="dropdown-item s_popupPriceAttr" data-title="Giá nhập" data-type="price_import" data-tw-toggle="modal" data-tw-target="#modalPriceAttr">Cập nhập giá nhập</a> </li>
                            <li> <a href="javascript:void(0)" class="dropdown-item s_popupPriceAttr" data-title="Giá bán" data-type="price" data-tw-toggle="modal" data-tw-target="#modalPriceAttr">Cập nhập giá</a> </li>
                            <li> <a href="javascript:void(0)" class="dropdown-item s_popupPriceAttr" data-title="Giá khuyến mại" data-type="price_sale" data-tw-toggle="modal" data-tw-target="#modalPriceAttr">Cập nhập ưu đãi</a> </li>
                            <li> <a href="javascript:void(0)" class="dropdown-item" data-tw-toggle="modal" data-tw-target="#modal_ships_weight">Cân nặng(gram) - Kích cỡ(DxRxC)</a> </li>
                            <li> <a href="javascript:void(0)" class="dropdown-item" data-tw-toggle="modal" data-tw-target="#modal_stock">Quản lý tồn kho</a> </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- END: check all update image -->
            <div class="overflow-x-auto s_boxVariable">
                <div class="sortable" id="table_version">
                    <?php if ($version > 0) { ?>
                        <?php foreach ($title_version as $key => $value) { ?>
                            <div class="mb-2 dd3-content">
                                <div class="relative flex items-center">
                                    <input type="checkbox" name="" value="" class="mr-3 cursor-pointer s_checkboxItem">
                                    <img src="<?php echo e(!empty($image_version[$key]) ? $image_version[$key] : url('images/404.png')); ?>" class="mr-3 s_imgAvatar" style="width: 45px;height: 45px;object-fit: cover;">
                                    <a href="javascript:void(0)" class="form-label mb-0 accordion w-full js_add_option ">
                                        <?php
                                        if ($errors->any()) {
                                            $title_v = explode('&&&&', $value);
                                        } else if ($action == 'update') {
                                            $title_v = json_decode($title_version[$key], TRUE);
                                        }
                                        ?>
                                        <?php if (!empty($title_v)) { ?>
                                            <?php foreach ($title_v as $k => $v) {
                                                if ($v != '') { ?>
                                                    <input type="hidden" name="title_check[]" value="<?php echo e($v); ?>">
                                                    <span class="text-xs whitespace-nowrap text-success bg-success/20 pending  pending-success/20 rounded-full px-2 py-1 mr-1 "><?php echo e($v); ?></span>
                                                <?php } ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </a>
                                    <?php if(!empty($ids)): ?>
                                    <input type="hidden" name="ids[]" value="<?php echo e(!empty($ids) ? $ids[$key] : 0); ?>">
                                    <?php endif; ?>
                                    <?php
                                    if ($errors->any()) { ?>
                                        <input type="hidden" name="title_version[]" value="<?php echo collect($title_v)->join('', '&&&&') ?>">
                                    <?php } else if ($action == 'update') { ?>
                                        <input type="hidden" name="title_version[]" value="<?php echo collect($title_v)->join('&&&&') ?>">
                                    <?php } ?>
                                    <a href="javascript:void(0)" class="text-danger version_remove" data-number="1">Xóa</a>
                                </div>
                                <div class="version_item_size hidden">
                                    <div class="grid grid-cols-2 gap-6 mt-3">
                                        <div class="">
                                            <label class="form-label">Hình ảnh</label>
                                            <div class="flex items-center space-x-3">
                                                <div class="avatar" style="cursor: pointer;flex:none">
                                                    <img src="<?php echo e(!empty($image_version[$key]) ? $image_version[$key] : url('images/404.png')); ?>" class="img-thumbnail" style="width: 100px;height: 100px;object-fit: cover;">
                                                </div>
                                                <input type="text" name="image_version[]" style="cursor: not-allowed;opacity: 0.56;" value="<?php echo !empty($image_version[$key]) ? $image_version[$key] : '' ?>" class="form-control" placeholder="Đường dẫn của ảnh" autocomplete="off">
                                            </div>
                                        </div>
                                        <div><label class="form-label">Mã sản phẩm</label><input type="text" name="code_version[]" value="<?php echo !empty($code_version[$key]) ? $code_version[$key] : '' ?>" class="form-control" placeholder="">
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-3 gap-3 mt-3">
                                        <div class="">
                                            <label class="form-label">Giá nhập</label>
                                            <input type="text" value="<?php echo !empty($price_import_version[$key]) ? $price_import_version[$key] : '' ?>" name="price_import_version[]" class="form-control int price" placeholder="">
                                        </div>
                                        <div>
                                            <label class="form-label">Giá</label>
                                            <input type="text" value="<?php echo  !empty($price_version[$key]) ? $price_version[$key] : '' ?>" name="price_version[]" class="form-control int price" placeholder="">
                                        </div>
                                        <div class="">
                                            <label class="form-label">Giá ưu đãi</label>
                                            <input type="text" value="<?php echo !empty($price_sale_version[$key]) ? $price_sale_version[$key] : '' ?>" name="price_sale_version[]" class="form-control int price" placeholder="">
                                        </div>
                                    </div>
                                    <!-- START: Quản lý tồn kho -->
                                    <div class="mt-3">
                                        <h2 class="font-bold text-base mr-auto">Quản lý tồn kho</h2>
                                        <div class="mt-3">
                                            <div class="form-switch">
                                                <input type="text" name="_stock_status[]" value="<?php echo e(!empty($_stock_status[$key])?$_stock_status[$key]:0); ?>" class="hidden">
                                                <div class="form-check">
                                                    <input id="horizontal-form-<?php echo e($key); ?>" class="form-check-input selectStock" type="checkbox" value="1" <?php if(!empty($_stock_status[$key]==1)): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="horizontal-form-<?php echo e($key); ?>">Quản lý kho hàng</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="showStock <?php if($_stock_status[$key]==0): ?> hidden <?php endif; ?>">
                                            <div class="mt-3">
                                                <input type="text" name="_outstock_status[]" value="<?php echo e(!empty($_outstock_status[$key])?$_outstock_status[$key]:''); ?>" class="hidden">
                                                <div class="form-check">
                                                    <input id="horizontal-status-<?php echo e($key); ?>" class="form-check-input selectStockStatus" type="checkbox" value="1" <?php if($_outstock_status[$key]==1): ?> checked <?php endif; ?>>
                                                    <label class="form-check-label" for="horizontal-status-<?php echo e($key); ?>">Đồng ý cho đặt hàng khi đã hết hàng</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END: Quản lý tồn kho -->
                                    <!-- START: Cân nặng, Kích cỡ(DxRxC) -->
                                    <div class="flex flex-col md:flex-row gap-6 mt-3">
                                        <div class="w-1/2">
                                            <div>
                                                <label class="form-label text-base font-semibold">Cân nặng(gram)</label>
                                                <?php echo Form::text('_ships_weight[]', !empty($_ships_weight[$key]) ? $_ships_weight[$key] : '', ['class' => 'form-control w-full ']); ?>
                                            </div>
                                        </div>
                                        <div class="w-1/2">
                                            <div>
                                                <label class="form-label text-base font-semibold">Kích cỡ(DxRxC)</label>
                                                <div class="flex gap-2">
                                                    <div class="w-1/3">
                                                        <?php echo Form::text('_ships_length[]', !empty($_ships_length[$key]) ? $_ships_length[$key] : '', ['class' => 'form-control w-full ']); ?>
                                                    </div>
                                                    <div class="w-1/3">
                                                        <?php echo Form::text('_ships_width[]', !empty($_ships_width[$key]) ? $_ships_width[$key] : '', ['class' => 'form-control w-full ']); ?>
                                                    </div>
                                                    <div class="w-1/3">
                                                        <?php echo Form::text('_ships_height[]', !empty($_ships_height[$key]) ? $_ships_height[$key] : '', ['class' => 'form-control w-full ']); ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- END -->
                                </div>
                            </div>
                        <?php } ?>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->startPush('html'); ?>
<!-- BEGIN: Ảnh đại diện thuộc tính -->
<div id="superlarge-modal-size-preview" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body p-10 text-center">
                <div class="alert alert-danger alert-dismissible show flex items-center mb-2 s_errorUploadImg" style="display: none;" role="alert">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="alert-octagon" data-lucide="alert-octagon" class="lucide lucide-alert-octagon w-6 h-6 mr-2">
                        <polygon points="7.86 2 16.14 2 22 7.86 22 16.14 16.14 22 7.86 22 2 16.14 2 7.86 7.86 2">
                        </polygon>
                        <line x1="12" y1="8" x2="12" y2="12"></line>
                        <line x1="12" y1="16" x2="12.01" y2="16"></line>
                    </svg>
                    Vui lòng chọn 1 ảnh
                    <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" icon-name="x" data-lucide="x" class="lucide lucide-x w-4 h-4">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <input class="form-control hidden s_inputImg" type="text">
                <div class="grid grid-cols-6 gap-2 s_listSelectImg">
                </div>
                <div class="flex justify-end mt-5 space-x-2">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Close</button>
                    <button type="button" class="btn btn-danger w-24 s_saveImg">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Ảnh đại diện thuộc tính -->
<!-- BEGIN: Cập nhập giá thuộc tính -->
<div id="modalPriceAttr" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body p-10 text-center">
                <input class="form-control int" type="text" placeholder="" name="price" value="0">
                <input class="form-control" type="hidden" placeholder="" name="typeModal">
                <div class="flex justify-end mt-5 space-x-2">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Close</button>
                    <button type="button" data-tw-dismiss="modal" class="btn btn-danger w-24 s_savePrice">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Cập nhập giá thuộc tính -->
<!-- BEGIN: Cập nhập Cân nặng(gram) - Kích cỡ(DxRxC) -->
<div id="modal_ships_weight" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body p-10 text-center">
                <div class="flex flex-col md:flex-row gap-6 mt-3">
                    <div class="w-1/2">
                        <div>
                            <label class="form-label text-base font-semibold w-full text-left">Cân nặng(gram)</label>
                            <input class="form-control w-full " name="_ships_weight_modal" type="text" value="">
                        </div>
                    </div>
                    <div class="w-1/2">
                        <div>
                            <label class="form-label text-base font-semibold w-full text-left">Kích cỡ(DxRxC)</label>
                            <div class="flex gap-2">
                                <div class="w-1/3">
                                    <input class="form-control w-full " name="_ships_length_modal" type="text" value="">
                                </div>
                                <div class="w-1/3">
                                    <input class="form-control w-full " name="_ships_width_modal" type="text" value="">
                                </div>
                                <div class="w-1/3">
                                    <input class="form-control w-full " name="_ships_height_modal" type="text" value="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end mt-5 space-x-2">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Close</button>
                    <button type="button" data-tw-dismiss="modal" class="btn btn-danger w-24 s_save_ships_weight">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Cập nhập Cân nặng(gram) - Kích cỡ(DxRxC) -->
<!-- BEGIN: Quản lí tồn kho -->
<div id="modal_stock" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-body p-10 text-center">
                <div class="flex flex-col md:flex-row gap-6 mt-3">
                    <div class="form-check form-switch">
                        <input id="checkbox-switch-stock" class="form-check-input" type="checkbox" value="1">
                        <label class="form-check-label" for="checkbox-switch-stock">Quản lí tồn kho</label>
                    </div>
                </div>
                <div class="mt-3 hidden s_box_stock_status">
                    <div class="form-check">
                        <input id="horizontal-status-stock" class="form-check-input selectStockStatus" type="checkbox" value="1">
                        <label class="form-check-label" for="horizontal-status-stock">Đồng ý cho đặt hàng khi đã hết hàng</label>
                    </div>
                </div>
                <div class="flex justify-end mt-5 space-x-2">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-primary w-24">Close</button>
                    <button type="button" data-tw-dismiss="modal" class="btn btn-danger w-24 s_save_stock">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Quản lí tồn kho -->
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/product/backend/product/common/attribute.blade.php ENDPATH**/ ?>