@push('javascript')
<script>
    var time;
    $(document).on('click', '.js_brand', function() {
        if ($(this).find('input.js_input_brand:checked').length) {
            $(this).addClass('checked');
        } else {
            $(this).removeClass('checked');
        }
        loadFilterChecked();

    })
    $(document).on('click', '.js_attr', function() {
        if ($(this).find('input.js_input_attr:checked').length) {
            $(this).addClass('checked');
        } else {
            $(this).removeClass('checked');
        }
        loadFilterChecked();
    })
    $(document).on('change', '.js_select_attr', function() {
        loadFilterChecked();
    })
    /* $(document).on('click', '.js_del', function() {
         let _this = $(this);
         let id = _this.attr('data-id');
         let attr = '';
         $('input.js_input_attr:checked').each(function(key, index) {
             let id_check = $(this).val();
             if (id == id_check) {
                 $(this).prop('checked', false);
                 $(this).parent().removeClass('checked');
                 _this.remove();
             } else {
                 let keyword = $(this).attr('data-keyword');
                 attr = attr + keyword + ';' + id_check + ';';
             }
         });
         $('input.js_input_brand:checked').each(function(key, index) {
             let id_check = $(this).val();
             if (id == id_check) {
                 $(this).prop('checked', false);
                 $(this).parent().removeClass('checked');
                 _this.remove();
             }
         });
         $('#choose_attr').val(attr);
         get_list_object(1)
     }) */

    function delay(callback, ms) {
        var timer = 0;
        return function() {
            var context = this,
                args = arguments;
            clearTimeout(timer);
            timer = setTimeout(function() {
                callback.apply(context, args);
            }, ms || 0);
        };
    }
    $(document).on('change', '.filter', function() {
        let page = $('.pagination .active span').text();
        time = setTimeout(function() {
            get_list_object(page);
        }, 500);
        return false;
    });
    $(document).on('click', '.ps-widget__filter', function() {
        let page = $('.pagination .active span').text();
        time = setTimeout(function() {
            get_list_object(page);
        }, 500);
        return false;
    });

    $(document).on('click', '.js_pagination_filter .pagination a', function(event) {
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        get_list_object(page);
    });
    $(document).on('click', '#onSaleProduct', function(e) {
        get_list_object();
    })
    $(document).on('click', '.js_typeHTML', function(e) {
        $('.js_typeHTML').removeClass('active')
        $(this).addClass('active')
        var type = $(this).attr('data-type')
        if (type == 'col') {
            $('.ps-categogy--detail').addClass('ps-categogy--grid')
            $('.ps-categogy--detail').removeClass('ps-categogy--list')
        } else {
            $('.ps-categogy--detail').addClass('ps-categogy--list')
            $('.ps-categogy--detail').removeClass('ps-categogy--grid')
        }
        get_list_object();
    })

    function loadFilterChecked() {
        let attr = '';
        let brand = '';
        // $('#js_selected_attr').html('');
        <?php if (svl_ismobile() == 'is mobile') { ?>
            $('select[name="attr[]"] option:selected').each(function(key, index) {
                let id = $(this).val();
                let keyword = $(this).attr('data-keyword');
                let title = $(this).attr('data-title');
                if ($(this).val()) {
                    attr = attr + keyword + ';' + id + ';';
                }
            });
        <?php } else { ?>
            $('input[name="attr[]"]:checked').each(function(key, index) {
                let id = $(this).val();
                let keyword = $(this).attr('data-keyword');
                let title = $(this).attr('data-title');
                attr = attr + keyword + ';' + id + ';';
                /*$('#js_selected_attr').append(
                    '<span class="js_del flex items-center p-2 rounded bg-red-200 cursor-pointer" data-type="attr" data-id="' +
                    id + '"><span>' +
                    title +
                    '</span><button class="w-[20px] ml-3 h-5 rounded-full flex justify-center bg-red-200 items-center"><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4 text-gray-100\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z\" clip-rule=\"evenodd\"></path></svg> </button></span>'
                );
                $('#js_selected_attr').removeClass('hidden') */

            });
        <?php } ?>

        /*$('input[name="brands[]"]:checked').each(function(key, index) {
            let id = $(this).val();
            let title = $(this).attr('data-title');
            $('#js_selected_attr').append(
                '<span class="js_del flex items-center p-2 rounded bg-red-100 cursor-pointer" data-type="brand" data-id="' +
                id + '"><span>' +
                title +
                '</span><button class="w-[20px] ml-3 h-5 rounded-full flex justify-center bg-red-200 items-center"><svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4 text-gray-100\" viewBox=\"0 0 20 20\" fill=\"currentColor\"><path fill-rule=\"evenodd\" d=\"M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z\" clip-rule=\"evenodd\"></path></svg> </button></span>'
            );
            $('#js_selected_attr').removeClass('hidden')
        }); */
        $('#choose_attr').val(attr);
    }

    function get_list_object(page = 1) {
        /*var checked_brand = [];
        $('input[name="brands[]"]:checked').each(function() {
            checked_brand.push($(this).val());
        }); */
        // var brandChecked = checked_brand.join(',');
        let keyword = '';
        <?php if ($module == 'search') { ?>
            keyword = "<?php echo request()->get('keyword') ?>";
        <?php } else { ?>
            keyword = $('input[name="keywordFilter"]').val();
        <?php } ?>
        let js_typeHTML = $('.js_typeHTML.active').attr('data-type');
        let perpage = $('select[name="perpage"]').val();
        let sort = $('select[name="sort"]').val();
        let attr = $('input[name="attr"]').val();
        let start_price = $('input[name="price_start"]').val();
        let end_price = $('input[name="price_end"]').val();
        let ajaxUrl = '<?php echo route('productF.filter') ?>';
        let catalogueid = 0;
        <?php if ($module == 'brands') { ?>
            catalogueid = 0;
            var checked_brand = [<?php echo $detail->id ?>];
        <?php } else { ?>
            catalogueid = <?php echo !empty($detail) ? $detail->id : 0 ?>;
            var checked_brand = [];
            $('input[name="brands[]"]:checked').each(function() {
                checked_brand.push($(this).val());
            });
        <?php } ?>
        let onSaleProduct = 0;
        $('#onSaleProduct:checked').each(function(key, index) {
            onSaleProduct = 1
        });
        $.ajax({
            type: 'POST',
            url: ajaxUrl,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                keyword: keyword,
                perpage: perpage,
                attr: attr,
                brand: checked_brand,
                sort: sort,
                start_price: start_price,
                end_price: end_price,
                page: page,
                catalogueid: catalogueid,
                onSaleProduct: onSaleProduct,
                js_typeHTML: js_typeHTML,
            },
            beforeSend: function() {
                $('.lds-show').removeClass('d-none');
                $('#js_data_product_filter').html('');
                $('.js_pagination_filter').html('');

            },
            success: function(data) {
                let json = JSON.parse(data);
                $('#js_data_product_filter').html(json.html);
                $('.js_pagination_filter').html(json.paginate);
                /*$('.js_total_filter').text(json.total);
                $('#tp-col-filter').addClass('hidden sticky pr-1').removeClass('bg-white fixed w-full p-4'); */
                // $('html, body').animate({
                //     scrollTop: $("#scrollTop").offset().top
                // }, 300);
            },
            complete: function() {
                $('.lds-show').addClass('d-none');
            },
        });
    }
</script>
<?php /*<script src="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/js/ion.rangeSlider.min.js"></script>
<script>
    var $range = $(".js-range-slider");
    var $inputFrom = $('input[name="price_start"]');
    var $inputTo = $('input[name="price_end"]');
    var instance;
    var min = 0;
    var max = 10;
    var from = 0;
    var to = 0.1;
    $range.ionRangeSlider({
        type: "double",
        min: min,
        max: max,
        from: 0,
        to: 0.5,
        grid: true,
        postfix: "tr",
        max_postfix: "+",
        onUpdate: updateInputs,
        // onStart: updateInputs,
        onChange: updateInputs,
        onFinish: updateInputs
    });
    instance = $range.data("ionRangeSlider");

    function updateInputs(data) {
        from = data.from;
        to = data.to;
        $inputFrom.prop("value", from);
        $inputTo.prop("value", to);
        time = setTimeout(function() {
            get_list_object(1);
        }, 500);
    }

    $inputFrom.on("keyup change", function() {
        var val = $(this).prop("value");
        // validate
        if (val < min) {
            val = min;
        } else if (val > to) {
            val = to;
        }
        instance.update({
            from: val
        });
        $(this).prop("value", val);
    });

    $inputTo.on("keyup change", function() {
        var val = $(this).prop("value");
        // validate
        if (val < from) {
            val = from;
        } else if (val > max) {
            val = max;
        }
        instance.update({
            to: val
        });
        $(this).prop("value", val);
    });
    $(document).on('click', '.js-handle-filter-mobile', function(e) {
        $('#tp-col-filter').removeClass('hidden sticky pr-1').addClass('bg-white fixed w-full p-4 !top-0 z-[999999999]');
    })
    $(document).on('click', '.js_close_filter_mobile', function(e) {
        $('#tp-col-filter').addClass('hidden sticky pr-1').removeClass('bg-white fixed w-full p-4 !top-0 z-[999999999]');
    })
</script>*/ ?>

@endpush
<?php /*@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ion-rangeslider/2.3.1/css/ion.rangeSlider.min.css" />
<style>
    .js_attr.checked,
    .js_brand.checked {
        border: 1px solid #ee4d2d;
    }

    .product-filter-tick {
        width: 0.9375rem;
        height: 0.9375rem;
        position: absolute;
        overflow: hidden;
        right: 0;
        bottom: 0;
        display: none
    }

    .js_attr.checked .product-filter-tick,
    .js_brand.checked .product-filter-tick {
        display: block !important;
    }

    .product-filter-tick:before {
        border: 0.9375rem solid transparent;
        border-bottom: 0.9375rem solid #ee4d2d;
        content: "";
        position: absolute;
        right: -0.9375rem;
        bottom: 0;
    }

    .product-filter-tick svg {
        position: absolute;
        right: 0;
        bottom: 0;
        color: #fff;
        font-size: 8px;
        display: inline-block;
        width: 1em;
        height: 1em;
        fill: currentColor;
    }

    .tp_scroll::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
        border-radius: 10px;
        background-color: #F5F5F5;

    }

    .tp_scroll::-webkit-scrollbar {
        width: 5px;
        background-color: #F5F5F5;
    }

    .tp_scroll::-webkit-scrollbar-thumb {
        border-radius: 10px;
        -webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
        background-color: #D62929;
    }

    .filter-box:last-child {
        border-bottom: 0px !important;
    }
</style>
@endpush*/ ?>