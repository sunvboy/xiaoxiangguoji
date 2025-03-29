function numberWithCommas(nStr) {
    const formattedNumber = nStr.toLocaleString("de-DE");
    return formattedNumber;
}
$(".js-tp-search,.js-btnCloseSearch").click(function () {
    $(".js-header-search").toggleClass("hidden");
});
$(".js_TPCart").click(function () {
    cartOpen();
});
$(".offcanvas-close, .offcanvas-overlay").on("click", function (e) {
    e.preventDefault();
    $(".offcanvas-overlay").addClass("hidden");
    $("#offcanvas-cart").addClass("hidden ");
});
function changeActiveTab(event, tabID) {
    $(".tab-content .tab").addClass("hidden");
    $("#" + tabID).removeClass("hidden");
    $(".changeActiveTab").removeClass("active");
    $("." + tabID).addClass("active");
}
$(".js_tabProduct").click(function () {
    var tab = $(this).attr("data-tab");
    $(".js_tabProduct").removeClass("current");
    $(this).addClass("current");
    $(".tab-content").removeClass("current").addClass("hidden");
    $("#" + tab)
        .removeClass("hidden")
        .addClass("current");
});
function cartOpen() {
    $(".offcanvas-overlay").toggleClass("hidden");
    $("#offcanvas-cart").toggleClass("hidden");
}

function numberWithCommas(x) {
    const formattedNumber = x.toLocaleString("de-DE");
    return formattedNumber;
}

$(function () {
    /*show hide loading customers */
    $(function () {
        $("#submit-auth-loading").hide();
        $("#form-auth").submit(function (event) {
            $("#submit-auth").hide();
            $("#submit-auth-loading").show();
        });
    });

    /*START: tăng giảm số lượng */
    $(document).on("click", ".card-inc", function () {
        var quantity = parseInt(
            $(this).parent().find(".tp_cardQuantity").val()
        );
        var max_quantity = parseInt(
            $(this).parent().find(".tp_cardQuantity").attr("max")
        );
        if (quantity >= max_quantity) {
            quantity = max_quantity;
        } else {
            quantity += 1;
        }
        $(this).parent().find(".tp_cardQuantity").val(quantity);
        $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .find(".tp_addToCart")
            .attr("data-quantity", quantity);
    });
    $(document).on("click", ".card-dec", function () {
        var quantity = parseInt(
            $(this).parent().find(".tp_cardQuantity").val()
        );
        if (quantity <= 1) {
            quantity = 1;
        } else {
            quantity -= 1;
        }
        $(this).parent().find(".tp_cardQuantity").val(quantity);
        $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .find(".tp_addToCart")
            .attr("data-quantity", quantity);
    });
    $(document).on("change keyup", ".tp_cardQuantity", function () {
        var quantity = $(this).val();
        $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .find(".tp_addToCart")
            .attr("data-quantity", quantity);
    });
    /* change input số lượng => view giỏ hàng*/
    $(document).on(
        "keyup change",
        ".product-details .tp_cardQuantity",
        function () {
            var quantity = parseInt($(this).val());
            var max_quantity = parseInt($(this).attr("max"));
            if (quantity >= max_quantity) {
                $(this).val(max_quantity);
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find(".tp_addToCart")
                    .attr("data-quantity", max_quantity);
            } else {
                $(this).val(quantity);
                $(this)
                    .parent()
                    .parent()
                    .parent()
                    .find(".tp_addToCart")
                    .attr("data-quantity", quantity);
            }
        }
    );
    /*END: tăng giảm số lượng */
    /*START: chọn thuộc tính version*/
    $(document).on("click", ".swatch-option", function () {
        let _this = $(this).parent();
        let __this = $(this).parent().parent().parent();
        //xóa selected có trong thẻ li của ul chứa li click
        _this.find(".swatch-option").removeClass("selected");
        //tìm đến li click thêm class selected
        _this.find(this).addClass("selected");
        //remove class selected ở ul cha
        _this.parent().find("ul").removeClass("selected");
        _this.addClass("done");
        let count_version = __this
            .find(".tp_addToCart")
            .attr("data-count-version");
        let check = __this.find(".swatch-option.selected").length;
        let attr = "";
        __this.find(".swatch-option.selected").each(function (key, index) {
            let id = $(this).attr("data-id");
            attr = attr + ";" + id;
        });
        if (count_version == check) {
            let URL = BASE_URL_AJAX + "ajax/product/get-version-product";
            $.post(
                URL,
                {
                    attr: attr,
                    id: __this.find(".tp_addToCart").attr("data-id"),
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                function (data) {
                    //kiểm tra hết hàng
                    if (data.getVersionproduct.status_version == 1) {
                        __this.find(".tp_addToCart").addClass("disabled");
                    } else {
                        __this
                            .find(".card-price")
                            .html(
                                numberWithCommas(
                                    data.getVersionproduct.price_version
                                ) + "₫"
                            );
                        //thực hiện add attr giỏ hàng
                        __this
                            .find(".tp_addToCart")
                            .attr(
                                "data-price",
                                data.getVersionproduct.price_version
                            );
                        __this
                            .find(".tp_addToCart")
                            .attr(
                                "data-title-version",
                                data.getVersionproduct.title_version
                            );
                        __this
                            .find(".tp_addToCart")
                            .attr(
                                "data-id-version",
                                data.getVersionproduct.id_sort
                            );
                    }
                }
            );
            return false;
        }
    });
    /*END: chọn thuộc tính version */
    /*START: submit thêm vào giỏ hàng*/
    /*
    $(document).on('click', '.tp_addToCart', function() {
        let _this = $(this).parent().parent().parent();
        let id = $(this).attr('data-id');
        let count_version = $(this).attr('data-count-version');
        let count_version_check = _this.find('ul li.selected').length;
        _this.find('.list-version').removeClass('selected');
        if (count_version_check == count_version) {
            let URL = BASE_URL_AJAX + "ajax/cart/add-to-cart";
            $.ajax({
                type: 'POST',
                url: URL,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: id,
                    id_version: $(this).attr('data-id-version'),
                    quantity: $(this).attr('data-quantity'),
                },
                success: function(data) {
                    let json = JSON.parse(data);
                    if (json.error == '') {
                        loadDataCart(json);
                        _this.find('ul').removeClass('done');
                        _this.find('ul li.selected').removeClass('selected');
                        toastr.success(json.message, 'Thông báo!')
                    } else {
                        toastr.error(json.error, 'Error!')
                    }

                }
            });
        } else {
            _this.find('.list-version').not('.done').addClass('selected');
        }
    });
    */
    $(document).on("click", ".tp_addToCart.disabled", function () {
        toastr.error("Sản phẩm hiện đang hết hàng!", "Thông báo!");
    });
    $(document).on("click", ".tp_addToCart:not(.disabled)", function () {
        let id = $(this).attr("data-id");
        let URL = BASE_URL_AJAX + "ajax/cart/add-to-cart";
        let cart = $(this).attr("data-cart");
        let image = $(this).attr("data-src");
        $.ajax({
            type: "POST",
            url: URL,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                id: id,
                image: image,
                title_version: $(this).attr("data-title-version"),
                id_version: $(this).attr("data-id-version"),
                quantity: $(this).attr("data-quantity"),
                price: $(this).attr("data-price"),
                type: $(this).attr("data-type"),
            },
            success: function (data) {
                let json = JSON.parse(data);
                if (json.error == "") {
                    if (cart == 1) {
                        window.location.href =
                            BASE_URL_AJAX + "gio-hang/thanh-toan";
                    } else {
                        setTimeout(function () {}, 1000);
                        cartOpen();
                        if (json.total_items > 0) {
                            $("#cart-none-header").hide();
                            $("#cart-show-header").show();
                            $("#cart-bottom-header").show();
                        }
                        loadDataCart(json);
                        toastr.success(json.message, "Thông báo!");
                    }
                } else {
                    toastr.error(json.error, "Error!");
                }
            },
            error: function (jqXhr, json, errorThrown) {
                toastr.error(
                    "Thêm sản phẩm vào giỏ hàng không thành công",
                    "Error!"
                );
            },
        });
    });
    /*END: submit thêm vào giỏ hàng*/

    /*START: submit deals thêm vào giỏ hàng*/
    $(document).on("click", ".tp_addToCartDeals", function (e) {
        var ids = [];
        $(".checkboxDeal").each(function () {
            if ($(this).is(":checked")) {
                var id = $(this)
                    .parent()
                    .parent()
                    .find("select")
                    .find(":selected")
                    .val();
                var id_version = $(this)
                    .parent()
                    .parent()
                    .find("select")
                    .find(":selected")
                    .attr("data-id-version");
                var parentid = $(this)
                    .parent()
                    .parent()
                    .find("select")
                    .find(":selected")
                    .attr("data-parentid");
                console.log("id", id);
                console.log("id_version", id_version);
                console.log("parentid", parentid);
                console.log("  ");
                if (typeof id === "undefined") {
                    id = $(this)
                        .parent()
                        .parent()
                        .find("input.handleInputDeal")
                        .val();
                }
                if (typeof parentid === "undefined") {
                    parentid = $(this)
                        .parent()
                        .parent()
                        .find("input.handleInputDeal")
                        .attr("data-parentid");
                }
                if (typeof id_version !== "undefined") {
                    id_version = id_version;
                } else {
                    id_version = "";
                }
                ids.push({
                    id: id,
                    id_version: id_version,
                    parentid: parentid,
                });
            }
        });
        $.ajax({
            type: "POST",
            url: BASE_URL_AJAX + "ajax/cart/add-to-cart-deals",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                ids: ids,
                id: $("#detailProductID").val(),
            },
            success: function (data) {
                let json = JSON.parse(data);
                if (json.error == "") {
                    loadDataCart(json);
                    toastr.success(json.message, "Thông báo!");
                    setTimeout(function () {
                        window.location.href = BASE_URL_AJAX + "gio-hang";
                    }, 3000);
                } else {
                    toastr.error(json.error, "Error!");
                }
            },
            error: function (jqXhr, json, errorThrown) {
                toastr.error(
                    "Thêm sản phẩm vào giỏ hàng không thành công",
                    "Error!"
                );
            },
        });
    });

    /* Backup addcartdeals
    $(document).on('click', '.tp_addToCartDeals', function(e) {
        var ids = [];
        $('.checkboxDeal').each(function() {
            if ($(this).is(':checked')) {
                var id = $(this).parent().parent().find('select').find(':selected').val();
                var id_version = $(this).parent().parent().find('select').find(':selected').attr('data-id-version');
                var parentid = $(this).parent().parent().find('select').find(':selected').attr('data-parentid');
                console.log('id', id);
                console.log('id_version', id_version);
                console.log('parentid', parentid);
                console.log('  ');
                if (typeof id === 'undefined') {
                    id = $(this).parent().parent().find('input.handleInputDeal').val();
                }
                if (typeof parentid === 'undefined') {
                    parentid = $(this).parent().parent().find('input.handleInputDeal').attr('data-parentid');
                }
                if (typeof id_version !== 'undefined') {
                    id_version = id_version;
                } else {
                    id_version = '';
                }
                ids.push({
                    id: id,
                    id_version: id_version,
                    parentid: parentid
                })
            }
        });
        $.ajax({
            type: 'POST',
            url: BASE_URL_AJAX + "ajax/cart/add-to-cart-deals",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                ids: ids,
                id: $('#detailProductID').val()
            },
            success: function(data) {
                let json = JSON.parse(data);
                if (json.error == '') {
                    loadDataCart(json);
                    toastr.success(json.message, 'Thông báo!')
                    setTimeout(function() {
                        window.location.href = BASE_URL_AJAX + "gio-hang";
                    }, 3000);
                } else {
                    toastr.error(json.error, 'Error!')
                }
            },
            error: function(jqXhr, json, errorThrown) {
                toastr.error("Thêm sản phẩm vào giỏ hàng không thành công", 'Error!')
            },
        });
    })*/
    /*END: submit deals thêm vào giỏ hàng*/

    /*xóa giỏ hàng*/
    $(document).on("click", ".js-cart-remove", function (e) {
        e.preventDefault();
        let rowid = $(this).attr("data-rowid");
        ajax_cart_update(rowid, 0, "delete");
        $(".cart-" + rowid).remove();
    });
    /*tăng giỏ hàng item => view giỏ hàng*/
    $(document).on("click", ".tp_cart_plus", function (e) {
        e.preventDefault();
        let _this = $(this).parent().find(".tp_cardQuantity");
        var quantity = parseInt(_this.val());
        var max_quantity = parseInt(_this.attr("max"));
        if (quantity >= max_quantity) {
            toastr.error("Hết hàng", "Error!");
            quantity = max_quantity;
            return false;
        } else {
            quantity += 1;
        }
        _this.val(quantity);
        // $(this).parent().parent().find('.tp_addToCart').attr('data-quantity', quantity);
        let rowid = $(this).attr("data-rowid");
        ajax_cart_update(rowid, quantity, "update");
    });

    /*giảm giỏ hàng item => view giỏ hàng*/
    $(document).on("click", ".tp_cart_minus", function (e) {
        e.preventDefault();
        let _this = $(this).parent().find(".tp_cardQuantity");
        var quantity = parseInt(_this.val());
        if (quantity <= 1) {
            quantity = 1;
        } else {
            quantity -= 1;
        }
        _this.val(quantity);
        // $(this).parent().parent().find('.tp_addToCart').attr('data-quantity', quantity);
        let rowid = $(this).attr("data-rowid");

        ajax_cart_update(rowid, quantity, "update");
    });

    /* change input số lượng => view giỏ hàng*/
    $(document).on("change", ".cart_item .tp_cardQuantity", function () {
        var quantity = parseInt(
            $(this).parent().find(".tp_cardQuantity").val()
        );
        var max_quantity = parseInt(
            $(this).parent().find(".tp_cardQuantity").attr("max")
        );
        if (quantity >= max_quantity) {
            $(this).parent().find(".tp_cardQuantity").val(max_quantity);
        } else {
            $(this).parent().find(".tp_cardQuantity").val();
        }
        let rowid = $(this).parent().parent().parent().attr("data-rowid");
        setTimeout(ajax_cart_update(rowid, quantity, "update"), 800);
    });

    /*update cart*/
    function ajax_cart_update(rowid, quantity, type) {
        $.ajax({
            type: "POST",
            url: BASE_URL_AJAX + "ajax/cart/update-cart",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                rowid: rowid,
                quantity: quantity,
                type: type,
            },
            success: function (data) {
                let json = JSON.parse(data);
                if (json.error == "") {
                    if (json.total_items > 0) {
                        $("#cart-show-header").show();
                        $("#cart-bottom-header").show();
                        $("#cart-none-header").hide();
                    } else {
                        $("#cart-show-header").hide();
                        $("#cart-bottom-header").hide();
                        $("#cart-none-header").show();
                    }
                    toastr.success(json.message, "Thông báo!");
                    $("#main-cart").html(json.html);
                    loadDataCart(json);
                    $(
                        'li[data-rowid="' + rowid + '"] .total-product-item'
                    ).html(numberWithCommas(json.total_item) + "₫");
                    if (json.total > 0 && json.total_items > 0) {
                        //thực hiện add coupon nếu có
                        $(".cart-discount").html(json.coupon_html);
                    }
                } else {
                    toastr.error(json.error, "Error!");
                }
            },
        });
    }

    function loadDataCart(json) {
        console.log(json);
        changeLayoutCanvasCart(json.html_upsell);
        $(".cart-html-header").html(json.html_header);
        $(".list-upsell").html(json.html_upsell);
        $(".cart-html-cart").html(json.html);
        $(".cart-quantity").html(json.total_items);
        $(".cart-coupon-price").html(numberWithCommas(json.coupon_price) + "₫");
        $(".cart-total").html(numberWithCommas(json.total) + "₫");
        $(".cart-total-final").html(numberWithCommas(json.total_coupon) + "₫");
        if (json.total_items == 0) {
            $(".box-empty-cart").show();
            $(".box-header-cart").hide();
        } else {
            $(".box-empty-cart").hide();
            $(".box-header-cart").show();
        }
    }

    function changeLayoutCanvasCart(check) {
        if (check == "") {
            $(".product-upsell").hide();
            $("#offcanvas-cart").removeClass("lg:w-120").addClass("lg:w-96");
            $(".product-cart").css("width", "100%");
            $(".car-html-add-upsell").removeClass("flex");
        } else {
            $("#offcanvas-cart").removeClass("lg:w-96").addClass("lg:w-120");
            $(".product-upsell").show();
        }
    }

    /*START:mã giảm giá */
    $(document).on("click", "#apply_coupon", function (e) {
        e.preventDefault();
        let name = $("#coupon_code").val();
        $.ajax({
            type: "POST",
            url: BASE_URL_AJAX + "ajax/cart/add-coupon",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                name: name,
                fee_ship: $('input[name="fee_ship"]').val(),
            },
            success: function (data) {
                let json = JSON.parse(data);
                $(".message-container").show();
                if (json.error == "") {
                    $(".message-danger").hide();
                    //coupon show html
                    $(".cart-coupon-html").html(json.html);
                    //cập nhập lại tổng tiền
                    $(".cart-total-final").html(json.total);
                    toastr.success(json.message, "Thông báo!");
                } else {
                    $(".message-success").hide();
                    $(".message-danger").show();
                    $(".danger-title").html("").html(json.error);
                }
            },
        });
    });
    /*END:mã giảm giá */
    /** START: xóa mã giảm giá */
    $(document).on("click", ".remove-coupon", function (e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: BASE_URL_AJAX + "ajax/cart/delete-coupon",
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            data: {
                id: $(this).attr("data-id"),
                fee_ship: $('input[name="fee_ship"]').val(),
            },
            success: function (data) {
                let json = JSON.parse(data);
                if (json.error == "") {
                    //coupon show html
                    $(".cart-coupon-html").html(json.html);
                    //cập nhập lại tổng tiền
                    $(".cart-total-final").html(json.total);
                    toastr.success(json.message, "Thông báo!");
                } else {
                    toastr.error(json.error, "Error!");
                }
            },
        });
    });
    /** END: xóa mã giảm giá */

    /*upload image comment*/
    $(document).on("click", ".write-review__button--image", function (e) {
        $(".write-review__file").click();
    });
    var inputFile = $("input.write-review__file");
    var uploadURI = BASE_URL_AJAX + "comment/upload-images-comment";
    var processBar = $("#progress-bar");
    $("input.write-review__file").change(function (event) {
        var filesToUpload = inputFile[0].files;
        if (filesToUpload.length > 0) {
            var formData = new FormData();
            for (var i = 0; i < filesToUpload.length; i++) {
                var file = filesToUpload[i];
                formData.append("file[]", file, file.name);
            }
            // console.log(formData);
            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                url: uploadURI,
                type: "post",
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $(".error_comment").removeClass("alert alert-danger");
                    $(".write-review__images").show();
                    var json = JSON.parse(data);
                    $(".write-review__images").append(json.html);
                    load_src_img();
                },
                error: function (jqXhr, json, errorThrown) {
                    // this are default for ajax errors
                    var errors = jqXhr.responseJSON;
                    $(".error_comment")
                        .removeClass("alert alert-success")
                        .addClass("alert alert-danger");
                    $(".error_comment").html("").html(errors.message);
                },
            });
        }
    });

    function load_src_img() {
        var outputText = "";
        $(".write-review__images img").each(function () {
            var divHtml = $(this).attr("src");
            outputText += divHtml + "-+-";
        });
        $('#form-comment input[name="images"]').attr(
            "value",
            outputText.slice(0, -3)
        );
    }

    $(document).on("click", ".js_delete_image_cmt", function () {
        var me = $(this);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: uploadURI,
            type: "post",
            data: {
                file: me.attr("data-file"),
                delete: "delete",
            },
            success: function () {
                $(".error_comment")
                    .removeClass("alert alert-danger")
                    .removeClass("alert alert-danger");
                me.parent().remove();
                load_src_img();
            },
            error: function (jqXhr, json, errorThrown) {
                // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                var errorsHtml = "";
                $.each(errors["errors"], function (index, value) {
                    errorsHtml += value + "/ ";
                });
                $(".error_comment")
                    .removeClass("alert alert-success")
                    .addClass("alert alert-danger");
                $(".error_comment").html(errorsHtml).show();
            },
        });
    });
    /*end: upload images*/
    /*START: submit comment*/
    $("#form-comment").submit(function (event) {
        event.preventDefault();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: BASE_URL_AJAX + "comment/products/post-comment",
            type: "POST",
            dataType: "JSON",
            data: {
                rating: $('#form-comment input[name="rating"]').val(),
                images: $('#form-comment input[name="images"]').val(),
                fullname: $('#form-comment input[name="fullname"]').val(),
                phone: $('#form-comment input[name="phone"]').val(),
                message: $('#form-comment textarea[name="message"]').val(),
                module_id: $('#form-comment input[name="module_id"]').val(),
            },
            success: function (data) {
                if (data == 200) {
                    $(".error_comment .alert-danger").hide();
                    $(".error_comment .alert-success").show();
                    $(".error_comment .js_text_success").html(
                        "Gửi bình luận thành công!"
                    );
                    setTimeout(function () {
                        location.reload();
                    }, 1500);
                } else {
                    $(".error_comment .alert-danger").show();
                    $(".error_comment .alert-success").hide();
                    $(".error_comment .js_text_danger").html("Có lỗi xảy ra");
                }
            },
            error: function (jqXhr, json, errorThrown) {
                // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                $(".error_comment .alert-danger").show();
                $(".error_comment .alert-success").hide();
                if (errors.message == "Unauthenticated.") {
                    $(".error_comment .js_text_danger").html(
                        "Bạn phải đăng nhập để sử dụng tính năng này"
                    );
                } else {
                    $(".error_comment .js_text_danger").html(errors.message);
                }
            },
        });
    });
    /*END: submit comment*/

    /*START: reply comment*/
    $(document).on("click", ".js_btn_reply", function (e) {
        e.preventDefault();
        let _this = $(this);
        let text = _this.text();
        if (text == "Bỏ bình luận") {
            _this.parent().find(".reply-comment").html("");
            _this.html("Bình luận");
        } else {
            let param = {
                parentid: _this.attr("data-id"),
                name: _this.attr("data-name"),
            };
            let reply = get_comment_html(param);
            $(".reply-comment").html("");
            $(".js_btn_reply").html("Bình luận");
            _this.parent().find(".reply-comment").html(reply);
            _this.attr("data-comment", 0);
            _this.html("Bỏ bình luận");
        }
    });

    function get_comment_html(param = "") {
        let comment = "";
        comment += '<div class="flex">';
        comment +=
            '<div class="reply_comment_avatar mt-5 mr-2 w-8 h-8 rounded-full bg-cover bg-center flex-shrink-0">';
        comment +=
            '<img src="../../images/90e54b0a7a59948dd910ba50954c702e.png" alt="avatar" class="block rounded-full bg-[#f2f2f2]">';
        comment += "</div>";
        comment += '<div class="reply_comment_wrapper mt-5 z-10 grow">';
        comment +=
            '<span class="font-semibold mb-1">@' + param.name + "</span>";
        comment +=
            '<input value="" type="text" name="" placeholder="Họ và tên" class="js_input_reply_cmt mt-2 border border-[#eeeeee] py-[10px] pr-10 pl-3 rounded-xl w-full outline-none hover:outline-none focus:outline-none text-[13px] leading-5 resize-none overflow-hidden mb-[10px]" required=""><span class="reply_fullname"></span>';
        comment += '<div class="relative">';
        comment +=
            '<textarea placeholder="Viết câu trả lời" class="js_textarea_reply_cmt border border-[#eeeeee] py-[10px] pr-10 pl-3 rounded-xl w-full outline-none hover:outline-none focus:outline-none text-[13px] leading-5 resize-none overflow-hidden mb-[10px]" required></textarea><span class="reply_message"></span>';
        comment +=
            '<button type="button" class="js_reply_comment_submit absolute z-10 w-[17px] right-3 cursor-pointer top-[13px]" data-parent-id="' +
            param.parentid +
            '">';
        comment +=
            '<img src="../../images/92f01c5a743f7c8c1c7433a0a7090191.png" alt="icon submit">';
        comment += "</button>";
        comment += "</div>";
        comment += "</div>";
        comment += "</div>";
        comment += '<div class="reply_comment_error">';
        comment +=
            '<div class="alert-success bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 shadow-md mb-5" style="display: none" role="alert">';
        comment += '<div class="flex items-center">';
        comment += '<div class="py-1">';
        comment +=
            '<svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">';
        comment +=
            '<path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"></path>';
        comment += "</svg>";
        comment += "</div>";
        comment += "<div>";
        comment += '<p class="font-bold js_text_success"></p>';
        comment += "</div>";
        comment += "</div>";
        comment += "</div>";
        comment +=
            '<div class="alert-danger bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-5" role="alert" style="display: none">';
        comment += '<strong class="font-bold">Lỗi!</strong>';
        comment += '<span class="block sm:inline js_text_danger"></span>';
        comment += "</div>";
        comment += "</div>";
        return comment;
    }

    $(document).on("click", ".js_reply_comment_submit", function () {
        var parent_id = $(this).attr("data-parent-id");
        let fullname = $(".js_input_reply_cmt").val();
        let message = $(".js_textarea_reply_cmt").val();
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: BASE_URL_AJAX + "comment/reply-comment",
            type: "POST",
            dataType: "JSON",
            data: {
                parent_id: parent_id,
                message: message,
                fullname: fullname,
            },
            success: function (data) {
                $(".reply_comment_error .alert-danger").hide();
                $(".reply_comment_error .alert-success").show();
                $(".reply_comment_error .js_text_success").html(
                    "Phản hồi bình luận thành công!"
                );
                setTimeout(function () {
                    location.reload();
                }, 1000);
            },
            error: function (jqXhr, json, errorThrown) {
                // this are default for ajax errors
                var errors = jqXhr.responseJSON;
                $(".reply_comment_error .alert-danger").show();
                $(".reply_comment_error .alert-success").hide();
                if (errors.message == "Unauthenticated.") {
                    $(".reply_comment_error")
                        .html("")
                        .html("Bạn phải đăng nhập để sử dụng tính năng này");
                } else {
                    if (fullname == "") {
                        $(".js_input_reply_cmt").css("border-color", "red");
                    }
                    if (fullname == "") {
                        $(".js_textarea_reply_cmt").css("border-color", "red");
                    }
                    $(".reply_comment_error .js_text_danger").html(
                        errors.message
                    );
                }
            },
        });
        return false;
    });
    /*END: reply comment */
    $(document).on("click", ".paginate_cmt a", function (event) {
        event.preventDefault();
        var page = $(this).attr("href").split("page=")[1];
        var sort = $(".filter_item.active .filter_text").attr("data-sort");
        get_list_object_cmt(page, sort, true);
    });
    $(document).on("click", ".filter_text", function (event) {
        event.preventDefault();
        var sort = $(this).attr("data-sort");
        $(".filter_item").removeClass("active");
        $(this).parent().addClass("active");
        get_list_object_cmt(1, sort, false);
    });

    function get_list_object_cmt(page = 1, sort = "id", animate = true) {
        setTimeout(function () {
            $.post(
                BASE_URL_AJAX + "comment/get-list-comment",
                {
                    page: page,
                    module_id: $('#form-comment input[name="module_id"]').val(),
                    sort: sort,
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                function (data) {
                    $("#getListComment").html(data);
                    console.log(animate);
                    if (animate === true) {
                        $("html, body").animate(
                            {
                                scrollTop: $("#getListComment").offset().top,
                            },
                            200
                        );
                    }
                }
            );
        }, 210);
    }

    $(document).on("click", ".scrollCmt", function (event) {
        $("html, body").animate(
            {
                scrollTop: $("#section-rating-comment").offset().top,
            },
            500
        );
    });
    $("form.checkout").submit(function (event) {
        $(".lds-show").removeClass("hidden");
        $(".offcanvas-overlay").removeClass("hidden");
    });
    $(document).on("change", "#city", function (e, data) {
        let _this = $(this);
        let param = {
            id: _this.val(),
            type: "city",
            trigger_district: typeof data != "undefined" ? true : false,
            text: "Chọn Quận/Huyện",
            select: "districtid",
        };
        getLocation(param, "#district");
    });
    $(document).on("change", "#district", function (e, data) {
        let _this = $(this);
        var id = _this.val();
        if (id == null) {
            id = districtid;
        }
        let param = {
            id: id,
            type: "district",
            trigger_ward: typeof data != "undefined" ? true : false,
            text: "Chọn Phường/Xã",
            select: "wardid",
        };
        getLocation(param, "#ward");
    });
    /* if (typeof (cityid) != 'undefined' && cityid != '') {
        $('#city').val(cityid).trigger('change', [{
            'trigger': true
        }]);

    }
    if (typeof (districtid) != 'undefined' && districtid != '') {
        $('#district').val(districtid).trigger('change', [{
            'trigger': true
        }]);
    } */
    function getLocation(param, object) {
        if (districtid == "" || param.trigger_district == false) districtid = 0;
        if (wardid == "" || param.trigger_ward == false) wardid = 0;
        let formURL = BASE_URL_AJAX + "gio-hang/get-location";
        $.post(
            formURL,
            {
                param: param,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            function (data) {
                let json = JSON.parse(data);
                if (param.select == "districtid") {
                    if (param.trigger_district == true) {
                        $(object).html(json.html).val(districtid);
                        $("#ward").html(json.textWard);
                    } else {
                        $(object).html(json.html).val(districtid);
                        $("#ward").html(json.textWard);
                    }
                } else if (param.select == "wardid") {
                    $(object).html(json.html).val(wardid);
                }
            }
        );
    }
    /*tính phí vận chuyển*/
    $(document).on("change", "#district", function (e) {
        var cityID = $("select#city").val();
        var districtID = $(this).val();
        loadPriceShipment(cityID, districtID);
    });
    function loadPriceShipment(cityID, districtID) {
        /*$.post(
            BASE_URL_AJAX + "gio-hang/get-shipping",
            {
                cityID: cityID,
                districtID: districtID,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            function (data) {
                if (data != "[]") {
                    var json = JSON.parse(data);
                    $(".list_shipping").html(json.html);
                    $(".js_fee_shipping").html(
                        numberWithCommas(parseInt(json.fee_ship)) + "₫"
                    );
                    $('input[name="fee_ship"]').val(json.fee_ship);
                    $('input[name="title_ship"]').val(json.title_ship);
                    $(".cart-total-final").html(
                        numberWithCommas(json.totalCart) + "₫"
                    );
                    $(".js_box_shipping").removeClass("hidden");
                }
            }
        );*/
    }
    $(document).on("click", ".js_change_fee_shipping", function (e) {
        $(".js_checked_ship").addClass("hidden");
        $(this).find(".js_checked_ship").removeClass("hidden");
        var title = $(this).attr("data-title");
        var fee = $(this).attr("data-fee");
        $('input[name="title_ship"]').val(title);
        $('input[name="fee_ship"]').val(fee);
        $(".js_fee_shipping").html(numberWithCommas(parseInt(fee)) + "₫");
        $.post(
            BASE_URL_AJAX + "gio-hang/change-shipping",
            {
                fee: fee,
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            function (data) {
                $(".cart-total-final").html(
                    numberWithCommas(data.totalCart) + "₫"
                );
            }
        );
    });
});

function handleSelectPayment(id) {
    $(".shadow_payment").addClass("hidden");
    $(".shadow_payment_" + id).removeClass("hidden");
}
