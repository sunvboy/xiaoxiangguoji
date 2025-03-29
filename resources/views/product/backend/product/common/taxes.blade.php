<?php
$taxes = !empty(old('taxes')) ? old('taxes') : (!empty($detail->TaxesRelationships->id) ? 1 : 0);
$taxes_type = !empty(old('taxes_type')) ? old('taxes_type') : (!empty($detail->TaxesRelationships->taxes_type) ? $detail->TaxesRelationships->taxes_type : 'notax');
$taxes_import = !empty(old('taxes_import')) ? old('taxes_import') : (!empty($detail->TaxesRelationships->taxes_import) ? $detail->TaxesRelationships->taxes_import : '');
$taxes_export = !empty(old('taxes_export')) ? old('taxes_export') : (!empty($detail->TaxesRelationships->taxes_export) ? $detail->TaxesRelationships->taxes_export : '');
?>
<div class="box p-5 mt-3 space-y-3 <?php if (!in_array('taxes', $dropdown)) { ?>hidden<?php } ?>">
    <div class="flex flex-col md:flex-row justify-between items-center">
        <div>
            <label class="form-label text-base font-semibold  flex items-center mb-0">Thuế
                <a href="" class="text-primary tooltip" title='Sản phẩm có tính thuế, hệ thống sẽ tự động gợi ý giá trị thuế cho sản phẩm theo chính sách thuế của cửa hàng'>
                    <i data-lucide="alert-circle" class="w-4 h-4 ml-2"></i>
                </a>
            </label>
            <span>Áp dụng thuế</span>
        </div>
        <div>
            <div class="form-switch">
                <input type="text" name="taxes" value="1" class="hidden">
                <div class="form-check">
                    <input id="horizontal-taxes-0" class="form-check-input selectTaxes" type="checkbox" value="1" @if(!empty($taxes)) checked="checked" @endif>
                </div>
            </div>
        </div>
    </div>
    <div class="grid grid-cols-3 gap-6 hidden" id="htmlTaxesTP">
        <div>
            <label class="form-label text-base font-semibold">Giá sản phẩm</label>
            <?php echo Form::select('taxes_type', $taxesType, $taxes_type, ['class' => 'form-control', 'autocomplete' => 'off']);; ?>
        </div>
        <div>
            <label class="form-label text-base font-semibold">Thuế đầu vào</label>
            <select class="form-control" autocomplete="off" name="taxes_import">
                @if(!$listTaxes->isEmpty())
                @foreach($listTaxes as $item)
                <option value="{{$item->value}}" @if($taxes_import==$item->value) selected @endif>{{$item->title}} - {{$item->value}}%</option>
                @endforeach
                @endif
            </select>
        </div>
        <div>
            <label class="form-label text-base font-semibold">Thuế đầu ra</label>
            <select class="form-control" autocomplete="off" name="taxes_export">
                @if(!$listTaxes->isEmpty())
                @foreach($listTaxes as $item)
                <option value="{{$item->value}}" @if($taxes_export==$item->value) selected @endif>{{$item->title}} - {{$item->value}}%</option>
                @endforeach
                @endif
            </select>
        </div>
    </div>
</div>
@push('javascript')
<!-- script: thuế -->
<script>
    var taxes = '<?php echo $taxes ?>';
    loadTaxes(taxes);
    $(document).on('click', '#horizontal-taxes-0', function() {
        taxes = $('#horizontal-taxes-0:checked').val();
        loadTaxes(taxes);
    });

    function loadTaxes(taxes) {
        if (taxes == 1) {
            $('#htmlTaxesTP').removeClass('hidden');
            $('input[name="taxes"]').val(taxes);
        } else {
            $('#htmlTaxesTP').addClass('hidden');
            $('input[name="taxes"]').val(0);
        }
    }
</script>
<!-- script: thuế -->
@endpush