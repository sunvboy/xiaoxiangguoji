@extends('dashboard.layout.dashboard')
@section('title')
<title>{{!empty($action == 'create') ? "Thêm mới hóa đơn" : "Cập nhập hóa đơn"}}</title>
@endsection
@section('breadcrumb')
<?php

$routeIndex = '';
if ($action == 'create') {
    $array = array(
        [
            "title" => "Danh sách các hóa đơn",
            "src" => url()->previous(),
        ],
        [
            "title" => "Thêm mới",
            "src" => 'javascript:void(0)',
        ]
    );
} else {
    $array = array(
        [
            "title" => "Danh sách các hóa đơn",
            "src" => url()->previous(),
        ],
        [
            "title" => "Cập nhập",
            "src" => 'javascript:void(0)',
        ]
    );
}

echo breadcrumb_backend($array);
$source_date_start = \Carbon\Carbon::today()->format('d/m/Y');
$source_date_end = \Carbon\Carbon::today()->addYear()->format('d/m/Y');
?>

@endsection
@section('content')
<form class="" action="{{!empty($action == 'create') ? route('deals.invoices.store') : route('deals.invoices.update',['id' => $detail->id])}}" method="post" enctype="multipart/form-data" autocomplete="off">
    <div class="p-4 space-y-5 pb-20">
        <div class="grid grid-cols-1 md:grid-cols-1 gap-2">
            <div class="col-span-1">
                <div class="w-full mx-auto bg-white  rounded-bl-[10px] rounded-br-[10px]">
                    <h3 class="bg-primary text-white p-[15px] text-base rounded-tl-[10px] rounded-tr-[10px] font-bold"><i class="fas fa-folder-open"></i> Thông tin về hóa đơn</h3>
                    <div class="p-[10px] grid grid-cols-1 gap-8">
                        <div>
                            @include('components.alert-error')
                            @csrf
                            <ul class="p-0 m-0 ">
                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] ">
                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Danh mục*</span></span>
                                    <?php echo Form::select('catalogue_id', $category_products, !empty(old('catalogue_id')) ? old('catalogue_id') : (!empty($detail) ? $detail->catalogue_id : ''), ['class' => 'tom-select tom-select-field-category w-full', 'placeholder' => "Chọn danh mục", 'required']); ?>
                                </li>
                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px] ">
                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Tên hợp đồng*</span></span>
                                    <?php echo Form::select('deal_id', $deals, !empty($detail) ? $detail->deal_id : '', ['class' => 'tom-select tom-select-field-deal w-full', 'placeholder' => "Chọn hợp đồng", 'required']); ?>
                                </li>
                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Tên hóa đơn*</span></span>
                                    <?php echo Form::text('title', !empty($detail) ? $detail->title : '', ['class' => 'form-control', 'placeholder' => '', 'required']); ?>
                                </li>

                                <?php /*<li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Số tiền*</span></span>
                                    <?php echo Form::text('price', !empty($detail) ? number_format($detail->price, '0', ',', '.') : '', ['class' => 'form-control int', 'placeholder' => '', 'required']); ?>
                                </li>
                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Thuế</span></span>
                                    <div class="flex items-center space-x-1">
                                        <?php echo Form::select('status_tax', config('tamphat')['tax'], !empty($detail) ? $detail->status_tax : '', ['class' => 'form-control flex-1', 'placeholder' => "Chọn thuế"]); ?>
                                        <span class="flex-1 htmlPriceTax">{{!empty($detail) ? (!empty($detail->tax) ? number_format($detail->tax,'0',',','.').' VND' : '') : ''}}</span>
                                    </div>
                                </li>

                                <li class="flex flex-col text-[15px] p-[5px] space-y-[2px]">
                                    <span class="bg-white font-semibold flex-1"><span class="text-red-600">Số tiền thanh toán*</span></span>
                                    <?php echo Form::text('priceTotal', !empty($detail) ? number_format($detail->price + $detail->tax, '0', ',', '.') : '', ['class' => 'form-control int', 'placeholder' => '', 'disabled']); ?>
                                </li>*/ ?>

                                <li class="flex text-[15px] gap-4 p-[5px] space-y-[2px]">
                                    <div class="w-1/3">
                                        <span class="bg-white font-semibold flex-1"><span class="text-red-600">Người chịu trách nhiệm*</span></span>
                                        <?php echo Form::select('user_id', $users, !empty($detail) ? $detail->user_id : '', ['class' => 'tom-select tom-select-field-support-invoices w-full', 'placeholder' => "Chịu trách nghiệm", 'required']); ?>
                                    </div>
                                    <div class="w-1/3">
                                        <span class="bg-white font-semibold flex-1">Trạng thái</span>
                                        <?php echo Form::select('status', ['0' => 'Chưa thanh toán', '1' => 'Đã thanh toán'], !empty($detail) ? $detail->status : '', ['class' => 'tom-select tom-select-field-status-invoices']); ?>
                                    </div>

                                    <div class="w-1/3">
                                        <span class="bg-white font-semibold flex-1">Ngày thanh toán</span>
                                        <?php echo Form::text('date_end',  !empty($detail) ? (!empty($detail->date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->date_end)->format('d/m/Y') : '') : $source_date_start, ['class' => 'form-control', 'placeholder' => '']); ?>
                                    </div>
                                </li>
                                <li class="flex text-[15px] gap-4 p-[5px] space-y-[2px]">
                                    <div class="w-full">
                                        <span class="bg-white font-semibold flex-1">Ngày thanh toán</span>
                                        <?php echo Form::text('date_end',  !empty($detail) ? (!empty($detail->date_end) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->date_end)->format('d/m/Y') : '') : $source_date_start, ['class' => 'form-control', 'placeholder' => '']); ?>
                                    </div>
                                    <div class="w-1/2 hidden">
                                        <span class="bg-white font-semibold flex-1 ">Ngày kết thúc</span>
                                        <?php echo Form::text('source_date_end',  !empty($detail) ? (!empty($detail->source_date_end) ?  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $detail->source_date_end)->format('d/m/Y') : '') : $source_date_end, ['class' => 'form-control', 'placeholder' => '']); ?>
                                    </div>
                                </li>

                                <li class="flex text-[15px] gap-4 p-[5px] space-y-[2px]">
                                    <div class="w-1/2">
                                        <span class="bg-white font-semibold flex-1">Nội dung thanh toán</span>
                                        <?php echo Form::textarea('commentI', !empty($detail) ? $detail->comment : '', ['class' => 'form-control', 'placeholder' => '', 'rows' => '5']); ?>
                                    </div>
                                    <div class="w-1/2">
                                        <span class="bg-white font-semibold flex-1">Ghi chú</span>
                                        <?php echo Form::textarea('noteI', !empty($detail) ? $detail->note : '', ['class' => 'form-control', 'rows' => '5']); ?>
                                    </div>
                                </li>

                            </ul>
                            <div id="invoicesProduct">
                                @include('deal.invoices.product',['action' => $action])
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="relative">
            <div class="fixed bottom-0 bg-white shadow-lg w-full px-5 py-2 z-10">
                <button type="submit" class="text-white bg-primary font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                    {{!empty($action == 'create') ? "Thêm mới" : "Cập nhập"}}
                </button>
            </div>
        </div>
</form>
@endsection
@push('javascript')

<script type="text/javascript">
    function loadPirceConvert(price) {
        var numberWithDots = price;

        // Remove dots from the number
        var numberWithoutDots = numberWithDots.replace(/\./g, '');

        // Convert the string to a number
        var convertedNumber = parseInt(numberWithoutDots);
        return convertedNumber
    }
    $(document).on('keyup', 'input[name="price"]', function(e) {
        e.preventDefault()
        var price = $(this).val()
        var status_tax = $('select[name="status_tax"]').val();
        var convertedVersion = loadPirceConvert(price);
        var tax = 0;
        if (convertedVersion > 0) {
            if (status_tax) {
                tax = (convertedVersion / 100) * status_tax
            }
        }
        $('input[name="priceTotal"]').val(numberWithCommas(parseInt(tax) + parseInt(convertedVersion)))
        $('.htmlPriceTax').html(numberWithCommas(tax) + ' VND')

    })
    $(document).on('change', 'select[name="status_tax"]', function(e) {
        e.preventDefault()
        var price = $('input[name="price"]').val()
        var status_tax = $(this).val();
        var convertedVersion = loadPirceConvert(price);
        var tax = 0;
        if (convertedVersion > 0) {
            if (status_tax) {
                tax = (convertedVersion / 100) * status_tax
            }
        }
        $('input[name="priceTotal"]').val(numberWithCommas(parseInt(tax) + parseInt(convertedVersion)))
        $('.htmlPriceTax').html(numberWithCommas(tax) + ' VND')

    })
    $(function() {
        $('input[name="date_end"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="source_date_end"]').datetimepicker({
            format: 'd/m/Y',
        });

    });
    new TomSelect('.tom-select-field-deal', {
        valueField: 'id',
        labelField: 'title',
        searchField: ['id', 'title'],
        // fetch remote data
        load: function(query, callback) {
            var self = this;
            if (self.loading > 1) {
                callback();
                return;
            }
            var url = '<?php echo route('deals.invoices.ajax.update') ?>?keyword=' + encodeURIComponent(query);
            fetch(url)
                .then(response => response.json())
                .then(json => {
                    console.log(json.data)
                    callback(json.data);
                    self.settings.load = null;
                }).catch(() => {
                    callback();
                });
        },
        // custom rendering function for options
        render: {
            option: function(item, escape) {
                return `<div class="py-2 flex">
							${ escape(item.title) }
						</div>`;
            }
        },
    });
    new TomSelect(".tom-select-field-category", {
        plugins: [{
            remove_button: {
                title: 'Remove this item',
            },

        }],
        persist: false,
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });

    new TomSelect(".tom-select-field-status-invoices", {
        plugins: [{
            remove_button: {
                title: 'Remove this item',
            },

        }],
        persist: false,
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
    new TomSelect(".tom-select-field-support-invoices", {
        plugins: {
            remove_button: {
                title: 'Remove this item',
            }
        },
        persist: false,
        create: true,
        sortField: {
            field: "text",
            direction: "asc"
        }
    });
</script>
<script>
    $(document).on('change', '.tom-select-field-deal', function(e) {
        var deal_id = $(this).val();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.invoices.ajax.showDeal')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                deal_id: deal_id,
                action: "<?php echo $action ?>",
            },
            success: function(data) {
                $('#invoicesProduct').html(data.html)
            }
        });

    })
    //thay đổi giá hóa đơn
    $(document).on('keyup', 'input[name="invoices_price[]"]', function(e) {
        var price = parseInt($(this).val());
        var quantity = parseInt($(this).parent().parent().find('input[name="invoices_quantity[]"]').val())
        var tax = parseFloat($(this).parent().parent().find('select[name="invoices_tax[]"]').val())
        var price_tax = 0;
        if (tax > 0) {
            price_tax = (price * quantity) / 100 * tax
        }

        $(this).parent().parent().find('input[name="invoices_tax_price[]"]').val(numberWithCommas(price_tax))
        $(this).parent().parent().find('.invoices_price_total').html(numberWithCommas((price * quantity) + price_tax))
        $(this).parent().parent().find('input[name="invoices_price_total[]"]').val((price * quantity) + price_tax)
        loadInvoicesTotalPrice()

    })
    $(document).on('change', 'select[name="invoices_tax[]"]', function(e) {
        var price = parseInt($(this).parent().parent().find('input[name="invoices_price[]"]').val())
        var quantity = parseInt($(this).parent().parent().find('input[name="invoices_quantity[]"]').val())
        var tax = parseFloat($(this).val())
        var price_tax = 0;
        if (tax > 0) {
            price_tax = (price * quantity) / 100 * tax
        }
        $(this).parent().find('input[name="invoices_tax_price[]"]').val(numberWithCommas(price_tax))
        $(this).parent().parent().find('.invoices_price_total').html(numberWithCommas((price * quantity) + price_tax))
        $(this).parent().parent().find('input[name="invoices_price_total[]"]').val((price * quantity) + price_tax)
        loadInvoicesTotalPrice()
    })
    $(document).on('click', '.handleRemoveItemProductInvoices', function(e) {
        $(this).parent().parent().remove()
        loadInvoicesTotalPrice()
    })

    function loadInvoicesTotalPrice() {
        var priceTotal1 = priceTotal2 = priceTotal3 = 0;
        $('input[name="invoices_price[]').each(function() {
            var price = parseInt($(this).val());
            var quantity = parseInt($(this).parent().parent().find('input[name="invoices_quantity[]"]').val())
            var tax = parseFloat($(this).parent().parent().find('select[name="invoices_tax[]"]').val())
            var price_tax = 0;
            if (tax > 0) {
                price_tax = (price * quantity) / 100 * tax
            }
            priceTotal1 += (price * quantity);
            priceTotal2 += price_tax;
            priceTotal3 += (price * quantity) + price_tax;
        })
        $('.invoices_price_1').html(numberWithCommas(priceTotal1) + ' đ')
        $('.invoices_price_2').html(numberWithCommas(priceTotal2) + ' đ')
        $('.invoices_price_3').html(numberWithCommas(priceTotal3) + ' đ')
        $('input[name="invoices_price_1"]').val(priceTotal1)
        $('input[name="invoices_price_2"]').val(priceTotal2)
        $('input[name="invoices_price_3"]').val(priceTotal3)

    }
</script>
<style>
    .ts-control {
        padding: 0.625rem;
        border-radius: 0.5rem;
    }

    .ts-dropdown [data-selectable] .highlight {
        background: rgba(255, 237, 40, .4) !important;
        border-radius: 1px;
    }
</style>
@endpush