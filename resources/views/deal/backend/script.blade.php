@push('javascript')
<script>
    $(document).ready(function() {
        $('input[name="brand_id"]').click(function() {
            // Uncheck all other checkboxes in the group
            $('input[name="' + $(this).attr('name') + '"]').not(this).prop('checked', false);
        });
    });
</script>
<script>
    function loadCheckCategory() {
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var textCheck = $(this).children("option:selected").text();
        if (catalogue_id == 1) {
            $('.tdDeal').removeClass('hidden')
        } else {
            $('.tdDeal').addClass('hidden')
        }

    }
    new TomSelect('.tom-select-field-website', {
        valueField: 'name',
        labelField: 'name',
        searchField: 'name',
        searchField: ['name'],
        shouldLoad: function(query) {
            return query.length > 1;
        },
        // fetch remote data
        load: function(query, callback) {

            var url = '<?php echo route('deals.ajax.searchDomain') ?>?keyword=' + encodeURIComponent(query);
            fetch(url)
                .then(response => response.json())
                .then(json => {
                    callback(json.items);
                }).catch(() => {
                    callback();
                });
        },
        // custom rendering functions for options and items
        render: {
            option: function(item, escape) {
                return `<div class="py-2 d-flex">
							${escape(item.name)}
						</div>`;
            },
            item: function(item, escape) {
                return `<div class="py-2 d-flex">
							${escape(item.name)}
						</div>`;
            }
        },
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
    new TomSelect(".tom-select-field-customer", {
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
    new TomSelect(".tom-select-field-type", {
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
    new TomSelect(".tom-select-field-source", {
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
    new TomSelect(".tom-select-field-support", {
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
    new TomSelect(".tom-select-field-join", {
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
    new TomSelect(".tom-select-field-free", {
        plugins: {
            remove_button: {
                title: 'Remove this item',
            }
        },
        persist: false,
        create: true,
    });
    new TomSelect(".tom-select-field-company", {
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
<script type="text/javascript">
    $(function() {
        $('input[name="date_end"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="source_date_start"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="source_date_end"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="date_endI"]').datetimepicker({
            format: 'd/m/Y',
        });
        $('input[name="source_date_endI"]').datetimepicker({
            format: 'd/m/Y',
        });
    });
</script>
<script>
    $(document).on('change', 'input[name="source_date_start"]', function(e) {
        var value = $(this).val()
        var inputDateStr = value;
        var inputDateParts = inputDateStr.split("/");
        var day = parseInt(inputDateParts[0], 10);
        var month = parseInt(inputDateParts[1], 10) - 1; // Months are zero-based
        var year = parseInt(inputDateParts[2], 10);

        // Create a JavaScript Date object
        var inputDate = new Date(year, month, day);

        // Add one year to the date
        inputDate.setFullYear(inputDate.getFullYear() + 1);

        // Output the result in the same format
        var outputDay = inputDate.getDate();
        var outputMonth = inputDate.getMonth() + 1; // Months are zero-based
        var outputYear = inputDate.getFullYear();

        // Pad single digits with leading zero if necessary
        outputDay = outputDay < 10 ? "0" + outputDay : outputDay;
        outputMonth = outputMonth < 10 ? "0" + outputMonth : outputMonth;

        // Output the result in the format "dd/mm/yyyy"
        var outputDateStr = outputDay + "/" + outputMonth + "/" + outputYear;
        $('input[name="source_date_end"]').val(outputDateStr)
    })
</script>
<script>
    /*lấy hình ảnh khi upload */
    function mainThamUrl(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                console.log(input.files[0].name)
                $('.uploadFile').text(input.files[0].name);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $(document).on('change', 'select[name="customer_id"]', function(e) {
        e.preventDefault()
        var id = $(this).val()
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.customer')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                id: id,
            },
            success: function(data) {
                $('input[name="email"]').val(data.customer.email)
                $('input[name="phone"]').val(data.customer.phone)
                $('input[name="address"]').val(data.customer.address)
                $('#infoCustomer').removeClass('hidden')
            },
            error: function(jqXhr, json, errorThrown) {
                var errors = jqXhr.responseJSON;
                var errorsHtml = "";
                $.each(errors["errors"], function(index, value) {
                    errorsHtml += value + "/ ";
                });
                $("#myModal .alert").html(errorsHtml).show();
            },
        });
    })
    $(document).on('click', '.handleAddProduct', function(e) {
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var textCheck = $(this).children("option:selected").text();
        console.log(catalogue_id)
        e.preventDefault();
        var html = '';
        html += '<tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 odd">'
        html += '<td class="p-2">'
        html += '<a href="javascript:void(0)" class="handleRemoveItemProduct"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-red-600">'
        html += '<path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />'
        html += '</svg></a>'
        html += '</td>'
        html += '<td class="p-2">'
        html += '<div class="relative"><input name="product_title[]" class="form-control w-full"></div><div class="listProducts"></div>'
        html += '</td>'
        html += '<td class="p-2">'
        html += '<input name="product_domain[]" class="form-control w-full">'
        html += '</td>'
        /*mới */
        <?php
        $phan_loai_1 = dropdown($brands, 'Phân loại', 'title', 'title');
        $phan_loai_2 = $category_products_child;
        $phan_loai = $category_products;
        ?>
        html += '<td class="p-2">'
        html += '<select placeholder="" class="form-control" name="product_phanloai[]">'
        html += '<option value="">Phân loại</option>'
        if (catalogue_id == 1) {
            <?php foreach ($phan_loai_1 as $item) { ?>
                html += '<option value="<?php echo $item ?>"><?php echo $item ?></option>'
            <?php } ?>
        } else if (catalogue_id == 2) {
            <?php foreach ($phan_loai_2 as $item) { ?>
                html += '<option value="<?php echo $item ?>"><?php echo $item ?></option>'
            <?php } ?>
        } else {
            <?php foreach ($phan_loai as $item) { ?>
                if (textCheck === '<?php echo $item ?>') {
                    html += '<option value="<?php echo $item ?>" selected><?php echo $item ?></option>'
                } else {
                    html += '<option value="<?php echo $item ?>"><?php echo $item ?></option>'
                }
            <?php } ?>
        }
        html += '</select>'
        html += '</td>'

        html += '<td class="p-2 tdDeal">'
        html += '<select placeholder="" class="form-control" name="product_duytri_deal[]">'
        html += '<option value="">Duy trì</option>'
        <?php if (!empty($tags)) {
            foreach ($tags as $key => $val) { ?>
                html += '<option value="<?php echo $val->title ?>"><?php echo $val->title ?></option>'
        <?php }
        } ?>
        html += '</select>'
        html += '</td>'
        /*END: mới */
        html += '<td class="p-2">'
        html += '<input name="product_price[]" class="form-control w-full">'
        html += '</td>'
        html += '<td class="p-2">'
        html += '<div class="relative flex space-x-1">'
        html += '<input name="product_quantity[]" class="form-control w-full" value="1">'
        html += '<select class="outline-none focus:outline-none hover:outline-none border-0 flex-1" data-placeholder="" name="product_unit[]">'
        html += '<option value="year">Năm</option>'
        html += '<option value="month">Tháng</option>'
        html += '<option value="vnd">VNĐ</option>'
        html += '<option value="cai">Cái</option>'
        html += '</select>'
        html += '</div>'
        html += '</td>'
        html += '<td class="p-2 flex space-x-1">'
        html += '<input name="product_price_sale[]" class="form-control w-full ">'
        html += '<select class="outline-none focus:outline-none hover:outline-none border-0 flex-1 hidden" data-placeholder="" name="product_price_sale_type[]">'
        html += '<option value="VND">VNĐ</option>'
        html += '<option value="percent">%</option>'
        html += '</select>'
        html += '</td>'
        html += '<td class="p-2">'
        html += '<select class="form-control" name="product_price_tax[]">'
        html += '<option value="-1">Chưa tính thuế</option>'
        html += '<option value="0">0%</option>'
        html += '<option value="10">10%</option>'
        html += '</select><input type="text" name="taxInputOfItem[]" class="taxInputOfItem hidden">'
        html += '</td>'
        html += '<td class="p-2 taxValueOfItem">'
        html += '0đ'
        html += '</td>'
        html += '<td class="p-2 totalValuePrice">'
        html += '0đ'
        html += '</td>'
        html += '</tr>';
        $('#listProduct').append(html)
        loadCheckCategory()
    })
    $(document).on('click', '.handleRemoveItemProduct', function(e) {
        $(this).parent().parent().remove()
        loadCheckCategory()
        loadPrice()
    })
    /*Thay đổi sản phẩm */
    $(document).on('click', '.itemProduct', function(e) {
        e.preventDefault()
        var catalogue_id = $('select[name="catalogue_id"]').val()
        var title = $(this).attr("data-title")
        var price = $(this).attr("data-price")
        var priceNoneFormat = $(this).attr("data-price-none")
        var categoryTitle = $(this).attr("data-category-title")
        if (catalogue_id == 2) {
            $(this).parent().parent().parent().parent().parent().parent().find('select[name="product_phanloai_website[]"]').val(categoryTitle)
        } else {
            $(this).parent().parent().parent().parent().parent().parent().find('select[name="product_duytri_deal[]"]').val(categoryTitle)
        }
        $(this).parent().parent().parent().parent().parent().find('input[name="product_title[]"]').val(title)
        $(this).parent().parent().parent().parent().parent().parent().find('input[name="product_price[]"]').val(price)
        var tax = $(this).parent().parent().parent().parent().parent().parent().find('select[name="product_price_tax[]"]').val()
        var price_sale = $(this).parent().parent().parent().parent().parent().parent().find('input[name="product_price_sale[]"]').val()
        var product_price_sale_type = $(this).parent().parent().parent().parent().parent().parent().find('input[name="product_price_sale_type[]"]').val() /*Loại giảm giá */
        var quantity = $(this).parent().parent().parent().parent().parent().parent().find('input[name="product_quantity[]"]').val()
        var taxValueOfItem = totalValuePrice = totalSales = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        if (product_price_sale_type == 'percent') {
            totalSales = ((parseInt(price) * parseFloat(quantity)) / 100) * price_sale
        } else {
            totalSales = price_sale;
        }
        totalValuePrice = (((parseInt(price) * parseFloat(quantity)) - parseInt(totalSales)))
        if (tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        // console.log("price - " + price)
        // console.log("tax - " + taxValueOfItem)
        // console.log("price_sale - " + taxValueOfItem)
        // console.log("quantity - " + taxValueOfItem)
        // console.log("taxValueOfItem - " + taxValueOfItem)
        $(this).parent().parent().parent().parent().parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().parent().parent().parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().parent().parent().parent().parent().find('.totalValuePrice').html(numberWithCommas(totalValuePrice + taxValueOfItem))
        $('.listProducts').html('')
        loadPrice()
    })
    /*Thay đổi kiểu giảm giá */
    $(document).on('change', 'select[name="product_price_sale_type[]"]', function(e) {
        e.preventDefault()
        //tính lại thuế
        var product_price_sale_type = $(this).val()
        var price_sale = $(this).parent().find('input[name="product_price_sale[]"]').val()
        var tax = $(this).parent().parent().find('select[name="product_price_tax[]"]').val()
        var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
        var price = $(this).parent().parent().find('input[name="product_price[]"]').val()
        var taxValueOfItem = totalValuePrice = totalSales = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        if (product_price_sale_type == 'percent') {
            totalSales = ((parseInt(price) * parseFloat(quantity)) / 100) * price_sale
            console.log(price)
            console.log(quantity)
            console.log(price_sale)
            console.log(totalSales)
        } else {
            totalSales = price_sale;
        }
        totalValuePrice = ((price * parseFloat(quantity)) - parseInt(totalSales))
        if (price_sale && tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().find('.totalValuePrice').html(numberWithCommas(taxValueOfItem + totalValuePrice))
        loadPrice()

    })
    $(document).on('change', 'select[name="product_price_tax[]"]', function(e) {
        e.preventDefault()
        var tax = $(this).val()
        var price = $(this).parent().parent().find('input[name="product_price[]"]').val()
        var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
        var price_sale = $(this).parent().parent().find('input[name="product_price_sale[]"]').val()
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        var taxValueOfItem = totalValuePrice = 0
        totalValuePrice = (((parseInt(price) * parseFloat(quantity)) - parseInt(price_sale)))
        if (tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().find('.totalValuePrice').html(numberWithCommas(totalValuePrice + taxValueOfItem))
        loadPrice()

    })
    $(document).on('keyup', 'input[name="product_price[]"]', function(e) {
        e.preventDefault()
        var price = $(this).val()
        var tax = $(this).parent().parent().find('select[name="product_price_tax[]"]').val()
        var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
        var price_sale = $(this).parent().parent().find('input[name="product_price_sale[]"]').val()
        var taxValueOfItem = totalValuePrice = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        totalValuePrice = (((parseInt(price) * parseFloat(quantity)) - parseInt(price_sale)))
        if (tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().find('.totalValuePrice').html(numberWithCommas(totalValuePrice + taxValueOfItem))
        loadPrice()
    })
    $(document).on('keyup', 'input[name="product_quantity[]"]', function(e) {
        e.preventDefault()
        var quantity = $(this).val()
        var tax = $(this).parent().parent().parent().find('select[name="product_price_tax[]"]').val()
        var price = $(this).parent().parent().parent().find('input[name="product_price[]"]').val()
        var price_sale = $(this).parent().parent().parent().find('input[name="product_price_sale[]"]').val()
        var taxValueOfItem = totalValuePrice = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        totalValuePrice = (((parseInt(price) * parseFloat(quantity)) - parseInt(price_sale)))
        if (tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().parent().find('.totalValuePrice').html(numberWithCommas(taxValueOfItem + totalValuePrice))
        loadPrice()
    })
    $(document).on('keyup', 'input[name="product_price_sale[]"]', function(e) {
        e.preventDefault()
        //tính lại thuế
        var price_sale = $(this).val()
        var tax = $(this).parent().parent().find('select[name="product_price_tax[]"]').val()
        var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
        var price = $(this).parent().parent().find('input[name="product_price[]"]').val()
        var taxValueOfItem = totalValuePrice = 0
        if (!price) {
            price = 0
        }
        if (!price_sale) {
            price_sale = 0
        }
        if (!quantity) {
            quantity = 0
        }
        totalValuePrice = ((price * parseFloat(quantity)) - parseInt(price_sale))
        if (price_sale && tax > 0) {
            taxValueOfItem = (totalValuePrice / 100) * tax
        }
        $(this).parent().parent().find('.taxValueOfItem').html(numberWithCommas(taxValueOfItem))
        $(this).parent().parent().find('.taxInputOfItem').val(taxValueOfItem)
        $(this).parent().parent().find('.totalValuePrice').html(numberWithCommas(taxValueOfItem + totalValuePrice))
        loadPrice()
    })
    $(document).on('click keyup', 'input[name="product_title[]"]', function(e) {
        var keyword = $(this).val()
        var _this = $(this)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.product')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                keyword: keyword,
            },
            success: function(data) {
                var html = ''
                html += '<div class="absolute w-[565px] h-[300px] bg-white z-[99999] rounded-lg" style="overflow-x: hidden;overflow-y: scroll;scrollbar-color: rgba(0, 0, 0, 0.21) transparent;scrollbar-width: thin;">' + data.html + '</div>'
                _this.parent().parent().find('.listProducts').append(html)
                if (!data.count) {
                    $('.titlePrd').html(keyword)
                }
            }
        });
    })
    $('body').click(function(e) {
        // Check if the click did not occur inside #myDiv
        // console.log($(e.target).closest('.listProducts input').length)
        if ($(e.target).closest('.listProducts').length || $(e.target).closest('input[name="product_title[]"]').length) {} else {
            $('.listProducts').html('')
        }
    });
    //load price 
    function loadPrice() {
        var total = sales = tax = 0;
        $('input[name="product_price[]"]').each(function() {
            var price = $(this).val()
            var quantity = $(this).parent().parent().find('input[name="product_quantity[]"]').val()
            total += price * quantity
        });
        $('input[name="product_price_sale[]"]').each(function() {
            sales += parseInt($(this).val())
        });
        $('input[name="taxInputOfItem[]"]').each(function() {
            tax += parseInt($(this).val())
        });
        if (isNaN(sales)) {
            sales = 0
        }
        if (isNaN(tax)) {
            tax = 0
        }
        $('.price_1').html(numberWithCommas(total))
        $('.price_2').html(numberWithCommas(sales))
        $('.price_3').html(numberWithCommas(total - sales))
        $('.price_4').html(numberWithCommas(tax))
        $('.price_5').html(numberWithCommas(total - sales + tax))
        $('input[name="price_1"]').val(total)
        $('input[name="price_2"]').val(sales)
        $('input[name="price_3"]').val(total - sales)
        $('input[name="price_4"]').val(tax)
        $('input[name="price_5"]').val(total - sales + tax)
        $('input[name="price"]').val(numberWithCommas(total - sales + tax))
    }
</script>
<script>
    $(document).on('click', '.handleSubmitNote', function(e) {
        var note = $('#textNote').val()
        var _this = $(this)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.note')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                note: note,
                id: <?php echo !empty($detail) ? $detail->id : 0 ?>
            },
            success: function(data) {
                $('#listHistories').html(data.html)
            }
        });
    })
    $(document).on('click', '.changeStatus', function(e) {
        var status = $(this).attr('data-status');
        var catalogue_id = $('select[name="catalogue_id"] option:selected').val();
        var _this = $(this)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: "{{route('deals.ajax.status')}}",
            type: "POST",
            dataType: "JSON",
            data: {
                status: status,
                id: <?php echo !empty($detail) ? $detail->id : 0 ?>,
                active: "<?php echo $active ?>",
                catalogue_id: catalogue_id
            },
            success: function(data) {
                $('select[name="status"]').val(status).change()
                $('#listHistories').html(data.history)
                $('#listStatus').html(data.status)
            }
        });
    })
</script>
<!-- Xóa file hợp đồng -->
<script>
    $(document).on('click', '.handleRemoveFile', function(e) {
        e.preventDefault()
        var id = $(this).attr('data-id');
        let _this = $(this);
        swal({
                title: "Hãy chắc chắn rằng bạn muốn thực hiện thao tác này?",
                text: "Bạn có muốn xóa file hợp đồng không?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Thực hiện!",
                cancelButtonText: "Hủy bỏ!",
                closeOnConfirm: false,
                closeOnCancel: false,
            },
            function(isConfirm) {
                if (isConfirm) {
                    let formURL = "<?php echo route('deals.ajax.removeFile') ?>";
                    $.ajax({
                        headers: {
                            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                                "content"
                            ),
                        },
                        url: formURL,
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            id: id,
                        },
                        success: function(data) {
                            if (data.code === 200) {
                                $('.htmlFile').html('');
                                swal({
                                    title: "Xóa thành công!",
                                    text: "Hạng mục đã được xóa khỏi danh sách.",
                                    type: "success",
                                });
                            } else {
                                swal({
                                    title: "Có vấn đề xảy ra",
                                    text: "Vui lòng thử lại",
                                    type: "error",
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
                        title: "Hủy bỏ",
                        text: "Thao tác bị hủy bỏ",
                        type: "error",
                    });
                }
            }
        );

    })
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