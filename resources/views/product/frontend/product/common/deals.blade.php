@if(!empty($productDeals) && count($productDeals) > 0)
<?php
$tmpDeals = [];
if (!empty($detail->deals)) {
    foreach ($detail->deals as $item) {
        $tmpDeals[$item->rowid] = $item->price;
    }
}
?>
<div class="Frequently-Bought pt-[10px] md:pt-[40px]">
    <h2 class="text-f23 font-bold">{{$fcSystem['title_11']}}</h2>
    <h3 class="text-f18 font-bold pt-[15px]">
        {{$fcSystem['title_12']}}
    </h3>
    <div class="grid grid-cols-5 justify-between items-center mt-[30px] md:space-x-8">
        <div class="col-span-4 grid grid-cols-12 -mx-4">
            <div class="px-4 mb-5 col-span-3 ">
                <div class="space-y-2 flex flex-col h-full">
                    <div class="flex-shrink-0">
                        <img src="{{asset($detail->image)}}" alt="{{$detail->title}}" class="h-[160px] mx-auto w-full object-cover" />
                    </div>
                    <div class="flex-1 flex flex-col h-full justify-between space-y-2">
                        <div class="text-f16 font-bold flex items-center space-x-1">
                            <input type="checkbox" class="checkboxDeal float-left w-4 h-4 cursor-not-allowed" checked disabled />
                            <span>{{$detail->title}}</span>
                        </div>
                        <div class="space-y-2">
                            @if(!empty($detail->product_versions) && count($detail->product_versions) > 0)
                            <select id="handleMain" class="handleOptionDeal w-full h-[40px] border border-gray-200 outline-none focus:outline-none hover:outline-none">
                                @foreach($detail->product_versions as $item)
                                <?php
                                $disabled = '';
                                $getPriceV = getPrice(array('price' => $item->price_version, 'price_sale' => $item->price_sale_version));
                                if ($item['_stock_status'] == 1 && $item['_outstock_status']  == 0 && $item['_stock'] == 0) {
                                    $disabled = 'disabled';
                                }
                                ?>
                                <option value="{{$detail->id}}" data-parentid="0" data-id-version="{{$item['id_version']}}" data-price-final-none-format="{{$getPriceV['price_final_none_format']}}" data-price-old-none-format="{{$getPriceV['price_old_none_format']}}" data-price-final="{{$getPriceV['price_final']}}" data-price-old="{{$getPriceV['price_old']}}" {{$disabled}} data-title="{{collect(json_decode($item['title_version']))->join(' - ')}}">{{collect(json_decode($item['title_version']))->join(' - ')}}</option>
                                @endforeach
                            </select>
                            <p class="text-f18">
                                <span class="text-red mainPriceFinal"></span>
                                <del class="ml-[5px] mainPriceOld"></del>
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-1 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </div>
            <div class="px-4 col-span-8 grid grid-cols-3 -mx-4">
                @foreach($productDeals as $item)
                @if(!empty($item->product_versions) && count($item->product_versions) > 0)
                <div class="px-4 mb-5">
                    <div class="space-y-2 flex flex-col h-full">
                        <div class="flex-shrink-0">
                            <img src="{{asset($item->image)}}" alt="{{$item->title}}" class="h-[160px] mx-auto w-full object-cover" />
                        </div>
                        <div class="flex-1 flex flex-col h-full justify-between space-y-2">

                            <div class="text-f16 font-bold flex items-center space-x-1 ">
                                <input type="checkbox" class="checkboxDeal float-left w-4 h-4" />
                                <span>{{$item->title}}</span>
                            </div>
                            <div class="flex-1 flex flex-col justify-end space-y-2">
                                <select class="handleSecondary handleOptionDeal w-full h-[40px] border border-gray-200 outline-none focus:outline-none hover:outline-none">
                                    @foreach($item->product_versions as $val)
                                    <?php
                                    $disabled = '';
                                    $rowid = md5($item->id . $val->title_version);
                                    $getPriceTMP = getPrice(array('price' => $val->price_version, 'price_sale' => $val->price_sale_version));
                                    $getPriceV = getPrice(array('price' => $getPriceTMP['price_final_none_format'], 'price_sale' => $tmpDeals[$rowid]));
                                    if ($val['_stock_status'] == 1 && $val['_outstock_status']  == 0 && $val['_stock'] == 0) {
                                        $disabled = 'disabled';
                                    }
                                    ?>
                                    <option data-parentid="{{$detail->id}}" value="{{$item['id']}}" data-id-version="{{$val['id_version']}}" data-price-final-none-format="{{$getPriceV['price_final_none_format']}}" data-price-old-none-format="{{$getPriceTMP['price_final_none_format']}}" data-price-final="{{$getPriceV['price_final']}}" data-price-old="{{$getPriceV['price_old']}}" {{$disabled}} data-title="{{collect(json_decode($val['title_version']))->join(' - ')}}">{{collect(json_decode($val['title_version']))->join(' - ')}}</option>
                                    @endforeach
                                </select>
                                <p class="text-f18">
                                    <span class="text-red extraPriceFinal">{{$getPriceV['price_final']}}</span>
                                    <del class="ml-[5px] extraPriceOld">{{$getPriceV['price_old']}}</del>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                @else
                <?php
                $getPriceD = getPrice(array('price' => $item->price, 'price_sale' => $item->price_contact));
                $rowid = md5($item->id);
                $classVersion = '';
                if ($item['inventory'] == 1 && $item['inventoryPolicy'] == 0 && $item['inventoryQuantity'] == 0) {
                    $classVersion = 'disabled';
                } else {
                ?>
                    <div class="px-4 mb-5">
                        <div class="space-y-2 flex flex-col h-full">
                            <div class="flex-shrink-0">
                                <img src="{{asset($item->image)}}" alt="{{$item->title}}" class="h-[160px] mx-auto w-full object-cover" />
                            </div>
                            <div class="flex-1 flex flex-col h-full justify-between space-y-2">
                                <div class="text-f16 font-bold flex items-center space-x-1">
                                    <input type="checkbox" class="checkboxDeal float-left w-4 h-4" />
                                    <span>{{$item->title}}</span>
                                </div>
                                <div class="flex-1 flex flex-col justify-end space-y-2">
                                    <input disabled class="handleInputDeal hidden" value="{{$item->id}}" data-parentid="{{$detail->id}}" data-price-final="{{$tmpDeals[$rowid]}}" data-price-old="{{$getPriceD['price_final_none_format']}}">
                                    <p class="text-f18">
                                        <span class="text-red extraPriceFinal">{{number_format($tmpDeals[$rowid],'0',',','.')}}đ</span>
                                        @if($getPriceD['price_final_none_format'] > 0)
                                        <del class="ml-[5px] extraPriceOld">{{$getPriceD['price_final']}}</del>
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
                @endif
                @endforeach
            </div>
        </div>
        <div>
            <p class="text-f18">
                {{trans('index.TotalAmount')}}: <b class="font-bold totalPriceFinal"></b><del class="text-gray-600 totalPriceOld"></del>
            </p>
            <button class="addToCartDeals uppercase font-black py-[10px] text-white bg-red-600 cursor-pointer items-center px-6 w-full mt-[20px]">
                {{trans('index.AddToCart')}}
            </button>
        </div>
    </div>
</div>
@push('javascript')
<script type="text/javascript">
    $(document).on('change', '#handleMain', function(e) {
        var id = $(this).val();
        var title = $(this).find(':selected').attr('data-title');
        var priceFinal = $(this).find(':selected').attr('data-price-final');
        var priceOld = $(this).find(':selected').attr('data-price-old');
        $('.mainPriceFinal').html(priceFinal);
        $('.mainPriceOld').html(priceOld);
        loadInfoDeals();
    })
    $(document).on('change', '.handleSecondary', function(e) {
        var priceFinal = $(this).find(':selected').attr('data-price-final');
        var priceOld = $(this).find(':selected').attr('data-price-old');
        $(this).parent().find('.extraPriceFinal').html(priceFinal);
        $(this).parent().find('.extraPriceOld').html(priceOld);
        loadInfoDeals();
    })


    function handleMain() {
        var priceFinal = $('#handleMain').find(':selected').attr('data-price-final');
        var priceOld = $('#handleMain').find(':selected').attr('data-price-old');
        $('.mainPriceFinal').html(priceFinal);
        $('.mainPriceOld').html(priceOld);
    }
    $(document).on('click', '.checkboxDeal', function(e) {
        loadInfoDeals();

    })

    function loadInfoDeals() {
        var totalPriceFinal = 0;
        var totalPriceOld = 0;
        $('.checkboxDeal').each(function() {
            if ($(this).is(':checked')) {
                var priceFinal = $(this).parent().parent().find('select').find(':selected').attr('data-price-final-none-format');
                var priceOld = $(this).parent().parent().find('select').find(':selected').attr('data-price-old-none-format');
                var handleInputDealFinal = $(this).parent().parent().find('input.handleInputDeal').attr('data-price-final');
                var handleInputDealOld = $(this).parent().parent().find('input.handleInputDeal').attr('data-price-old');
                if (typeof priceFinal !== 'undefined') {
                    totalPriceFinal += parseFloat(priceFinal)
                }
                if (typeof handleInputDealFinal !== 'undefined') {
                    totalPriceFinal += parseFloat(handleInputDealFinal)
                }
                if (typeof priceOld !== 'undefined') {
                    totalPriceOld += parseFloat(priceOld)
                }
                if (typeof handleInputDealOld !== 'undefined') {
                    totalPriceOld += parseFloat(handleInputDealOld)
                }

            }
        });
        $('.totalPriceFinal').html(numberWithCommas(totalPriceFinal) + 'đ')
        $('.totalPriceOld').html(numberWithCommas(totalPriceOld) + 'đ')
    }
    handleMain();
    loadInfoDeals();
</script>
<style>
    .disabled {
        pointer-events: none;
        cursor: not-allowed;
        opacity: 0.3;
    }
</style>
@endpush
@endif