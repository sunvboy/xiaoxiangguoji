<?php
$type = !empty(old('type')) ? old('type') : (!empty($detail->type) ? $detail->type : 'simple');
$inventory = !empty(old('inventory')) ? old('inventory') : (!empty($detail->inventory) ? $detail->inventory : 0);
$inventoryQuantity = !empty(old('inventoryQuantity')) ? old('inventoryQuantity') : (!empty($detail->inventoryQuantity) ? $detail->inventoryQuantity : 0);
$inventoryPolicy = !empty(old('inventoryPolicy')) ? old('inventoryPolicy') : (!empty($detail->inventoryPolicy) ? $detail->inventoryPolicy : 0);
?>
<div class="box p-5 mt-3 space-y-5 hidden <?php if (!in_array('attributes', $dropdown)) { ?>hidden<?php } ?>">
    <div class="flex items-center">
        <span class="font-bold">Dữ liệu sản phẩm</span>
        <select class="form-control flex-1 ml-4 s_handleSelectTypeProduct" name="type">
            <option value="simple" @if($type=='simple' ) selected="selected" @endif>Sản phẩm đơn giản</option>
            <option value="variable" @if($type=='variable' ) selected="selected" @endif>Sản phẩm biến thể</option>
        </select>
    </div>
</div>
<div class="box p-5 mt-3 space-y-5 s_boxSimple" style="display: none;">
    <div class="">
        <label class="form-label text-base font-semibold mb-0">Kho hàng</label>
        <div>Ghi nhận số lượng <b>Tồn kho @if($action != 'update')ban đầu @endif</b> của sản phẩm tại các Chi nhánh</div>
    </div>
    <!-- START: Quản lý tồn kho -->
    <div class="">
        <div class="form-check flex items-center">
            <input id="inventory-simple-1" class="form-check-input js_inventory" type="checkbox" value="1" name="inventory" @if($inventory==1) checked="checked" @endif>
            <label class="form-check-label font-bold text-base" for="inventory-simple-1">Quản lý kho hàng</label>
        </div>
    </div>
    <div class="box-inventory hidden mt-5 space-y-5">
        <?php /*<div class="hidden">
            <label class="form-label text-base font-semibold">Tổng số lượng tồn kho</label>
            <?php if (!in_array('addresses', $dropdown)) { ?>
                <?php echo Form::text('inventoryQuantity', $inventoryQuantity, ['class' => 'form-control w-full int', 'autocomplete' => 'off', '']); ?>
            <?php } else { ?>
                <?php echo Form::text('inventoryQuantity', $inventoryQuantity, ['class' => 'form-control w-full int disabled', 'autocomplete' => 'off', 'style' => 'opacity: 1;']); ?>
            <?php } ?>
        </div>
        <div class="scrollbar <?php if (!in_array('addresses', $dropdown)) { ?>hidden<?php } ?> hidden" style="max-height: 700px;">
            <table class="w-full">
                <thead>
                    <tr>
                        <th class="text-left p-2">Chi nhánh</th>
                        <th class="text-right p-2">Tồn kho</th>
                    </tr>
                </thead>
                <tbody>
                    @if(!$address->isEmpty())
                    @foreach($address as $item)
                    <tr>
                        <td class="text-left p-2 ">
                            <span class="font-medium">{{$item->title}}</span><br>
                            {{$item->ward_name->name}}-{{$item->district_name->name}}-{{$item->city_name->name}}
                        </td>
                        <td class="text-right p-2">
                            <?php echo Form::text('stockAddress[' . $item->id . ']', !empty($item->stocks) ? $item->stocks->value : 0, ['class' => 'form-control w-full int stockAddressInput', 'autocomplete' => 'off']); ?>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>
            </table>
        </div>*/ ?>
        <div class="flex items-center">
            <div class="mr-1 flex items-center">
                <?php if (isset($inventoryPolicy) && $inventoryPolicy == 1) { ?>
                    <input id="inventoryPolicy-simple-2" type="checkbox" checked name="inventoryPolicy" value="1" class="form-check-input">
                <?php } else { ?>
                    <input id="inventoryPolicy-simple-2" type="checkbox" name="inventoryPolicy" value="1" class="form-check-input">
                <?php } ?>
                <label class="form-check-label font-bold text-base" for="inventoryPolicy-simple-2">Cho phép tiếp tục đặt hàng khi hết hàng</label>
            </div>
        </div>
    </div>
    <!-- END: Quản lý tồn kho -->
</div>
@push('javascript')
<!-- START: kho hàng(sản phẩm đơn giản) -->
<script>
    var checkInventory = '<?php echo $inventory ?>';
    loadInventory(checkInventory);
    $(document).on('click', '.js_inventory', function() {
        checkInventory = $('input[name="inventory"]:checked').val();
        loadInventory(checkInventory);
    });

    function loadInventory(checkInventory) {
        if (checkInventory == 1) {
            $('.box-inventory').removeClass('hidden');
        } else {
            $('.box-inventory').addClass('hidden');
        }
    }
    $(document).on('keyup', '.stockAddressInput', function() {
        var total = 0;
        $(".stockAddressInput").each(function(idx, li) {
            var value = $(this).val();
            if (value > 0) {
                value = value.replace(".", "");
                total += parseInt(value);
            }
        });
        $('input[name="inventoryQuantity"]').val(total);
    })
    $('.s_handleSelectTypeProduct').each(function(idx, li) {
        var value = $(this).val();
        if (value === 'variable') {
            $('.s_boxSimple').addClass('hidden')
            $('.s_tdVariable').removeClass('hidden')
            $('.s_boxVariable').removeClass('hidden')
        } else {
            $('.s_boxSimple').removeClass('hidden')
            $('.s_tdVariable').addClass('hidden')
            $('.s_boxVariable').addClass('hidden')
        }
    })
    $(document).on('change', '.s_handleSelectTypeProduct', function() {
        var value = $(this).val();
        if (value === 'variable') {
            $('.s_boxSimple').addClass('hidden')
            $('.s_tdVariable').removeClass('hidden')
            $('.s_boxVariable').removeClass('hidden')
        } else {
            $('.s_boxSimple').removeClass('hidden')
            $('.s_tdVariable').addClass('hidden')
            $('.s_boxVariable').addClass('hidden')
        }
    })
</script>
<style>
    .scrollbar {
        overflow-y: overlay;
    }

    .scrollbar::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar {
        width: 6px;
        background-color: #F5F5F5;
    }

    .scrollbar::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #D62929;
    }
</style>
<!-- END: kho hàng(sản phẩm đơn giản) -->
@endpush