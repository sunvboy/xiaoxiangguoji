<!-- START: hoàn trả -->
<!-- Main modal -->
<div id="createOrderReturn" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full  flex justify-center items-center " style="background: #808080cc">
    <div class="relative p-4 h-full md:h-auto w-[790px]">
        <!-- Modal content -->
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="flex justify-end p-2">
                <button type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-800 dark:hover:text-white" onclick="handleCloseReturn()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>
            <form id="form-addReturn" class="px-6 pb-4 space-y-6 lg:px-8 sm:pb-6 xl:pb-8" action="">
                <h3 class="text-black font-bold text-xl">{{trans('index.ToReturn')}}</h3>
                @csrf
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-2 print-error-msg text-sm" style="display: none">
                    <strong class="font-bold">ERROR!</strong>
                    <span class="block sm:inline"></span>
                </div>
                <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-2 print-success-msg text-sm" style="display: none">
                    <div class="flex items-center">
                        <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold"></span>
                        </div>
                    </div>
                </div>
                <div class="loadDataHtmlReturn space-y-6">
                </div>
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="handleCloseReturn()" class="text-black hover:text-white bg-gray-300 hover:bg-rose-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-global dark:hover:bg-rose-600 dark:focus:ring-blue-800">{{trans('index.Cancel')}}</button>
                    <button type="submit" class="js_submit_return_order text-white bg-global hover:bg-rose-600 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-global dark:hover:bg-rose-600 dark:focus:ring-blue-800">
                        {{trans('index.ToReturn')}}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END -->
@push('javascript')
<script type="text/javascript">
    function handleCloseReturn() {
        $('#createOrderReturn').toggleClass('hidden');
    }

    function showModalOrderReturn(id) {
        $.post("<?php echo route('customer.returnOrder') ?>", {
                id: id,
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                $('.loadDataHtmlReturn').html(data.html);
                $('#createOrderReturn').toggleClass('hidden');
            });
    }
    $(document).on('change keyup', '.js_change_return_cart', function(e) {
        e.preventDefault();
        var price = $(this).attr('data-price')
        var quantity = $(this).val()
        $(this).parent().parent().find('.js_priceOfItem').html(numberWithCommas(quantity * price) + '₫');
        loadDataPriceReturn();
    })

    function loadDataPriceReturn() {
        var total = 0;
        var q = 0;
        $('.js_change_return_cart').each(function() {
            var price = $(this).attr('data-price')
            var quantity = $(this).val()
            total += parseFloat(price) * parseInt(quantity);
            q += parseInt(quantity);
        });
        $('.js_total_price_return').html(numberWithCommas(total) + '₫')
        $('.js_quantity_return_order').html(q)
    }
    $(document).ready(function() {
        $('#form-addReturn').on('submit', function(e) {
            e.preventDefault();
            var postData = $(this).serializeArray();
            let r = [];
            let q = [];
            $('#form-addReturn input[name="rowid[]"]').each(function() {
                var rowid = $(this).val()
                r.push(rowid);
            });
            $('#form-addReturn input[name="quantity[]"]').each(function() {
                var quantity = $(this).val()
                q.push(quantity);
            });
            $.ajax({
                url: "<?php echo route('customer.returnOrderSubmit') ?>",
                type: 'POST',
                data: {
                    "_token": $('meta[name="csrf-token"]').attr("content"),
                    rowid: r,
                    quantity: q,
                    orderID: $('#form-addReturn input[name="orderID"]').val()

                },
                success: function(data) {
                    if (data.data.status == 200) {
                        $("#form-addReturn .print-error-msg").css('display', 'none');
                        $("#form-addReturn .print-success-msg").css('display', 'block');
                        $("#form-addReturn .print-success-msg span").html("<?php echo $fcSystem['message_1'] ?>");
                        setTimeout(function() {
                            location.reload();
                        }, 2000);
                    } else {
                        $("#form-addReturn .print-error-msg").css('display', 'block');
                        $("#form-addReturn .print-success-msg").css('display', 'none');
                        $("#form-addReturn .print-error-msg span").html(data.data.error);
                        return false;
                    }
                }
            });
        });
    });
</script>
@endpush
<!-- END: hoàn trả -->