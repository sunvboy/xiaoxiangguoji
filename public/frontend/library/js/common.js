/*modal form comment*/
let modal = document.getElementById("modal");
function modalHandler(val) {
    if (val) {
        fadeIn(modal);
    } else {
        fadeOut(modal);
    }
}
function fadeOut(el) {
    el.style.opacity = 1;
    (function fade() {
        if ((el.style.opacity -= 0.1) < 0) {
            el.style.display = "none";
        } else {
            requestAnimationFrame(fade);
        }
    })();
}
function fadeIn(el, display) {
    el.style.opacity = 0;
    el.style.display = display || "flex";
    (function fade() {
        let val = parseFloat(el.style.opacity);
        if (!((val += 0.2) > 1)) {
            el.style.opacity = val;
            requestAnimationFrame(fade);
        }
    })();
}

/*END: modal form comment*/
$("input.rating-disabled").rating({
    filled: "fa fa-star rating-color",
    empty: "fa fa-star-o",
});
$(document).ready(function () {
    /*product version */
    if (typeof module !== "undefined") {
        var attr = [];
        $('.tp_item_variable.checked[data-stt="1"]').each(function (i, obj) {
            var id = parseInt($(this).attr("data-id"));
            attr.push(id);
        });
        $.post(
            BASE_URL_AJAX + "ajax/product/product-version",
            {
                attr: JSON.stringify(attr),
                stt: 1,
                module_id: $("#detailProductID").val(),
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            function (data) {
                var result = JSON.parse(data);
                if (result.type == "variable") {
                    loadDataVersion(result);
                }
            }
        );
    }

    $(document).on("click", '.tp_item_variable[data-stt="1"]', function (e) {
        $(".tp_item_variable").removeClass("disabled");
        $(this).parent().find(".tp_item_variable").removeClass("checked");
        $(this).addClass("checked");
        var stt = $(this).attr("data-stt");
        var attr = [];
        $('.tp_item_variable.checked[data-stt="1"]').each(function (i, obj) {
            var id = parseInt($(this).attr("data-id"));
            attr.push(id);
        });
        $.post(
            BASE_URL_AJAX + "ajax/product/product-version",
            {
                stt: stt,
                attr: JSON.stringify(attr),
                module_id: $("#detailProductID").val(),
                _token: $('meta[name="csrf-token"]').attr("content"),
            },
            function (data) {
                var result = JSON.parse(data);
                loadDataVersion(result);
            }
        );
    });
    $(document).on(
        "click",
        '.tp_item_variable[data-stt="0"]:not(.disabled)',
        function (e) {
            var id = parseInt($(this).attr("data-id"));
            var stt = $(this).attr("data-stt");
            var attr = [];
            $('.tp_item_variable.checked[data-stt="1"]').each(function (
                i,
                obj
            ) {
                var id = parseInt($(this).attr("data-id"));
                attr.push(id);
            });
            attr.push(id);
            $.post(
                BASE_URL_AJAX + "ajax/product/product-version",
                {
                    stt: stt,
                    attr: JSON.stringify(attr),
                    module_id: $("#detailProductID").val(),
                    _token: $('meta[name="csrf-token"]').attr("content"),
                },
                function (data) {
                    var result = JSON.parse(data);
                    loadDataVersion(result);
                }
            );
        }
    );

    function loadDataVersion(result) {
        // console.log(result);
        $(".tp_addToCart").removeClass("disabled");
        /*array id het hang*/
        if (result.idOutStock.length > 0) {
            result.idOutStock.forEach((element) => {
                $(".tp_item_variable_" + element + "")
                    .removeClass("checked")
                    .addClass("disabled");
            });
        }
        //trường hợp nếu tồn tại phiên bản thì lấy 1 phiên bản còn hàng đầu tiên
        if (result.idStock > 0) {
            var _inStock = $(".tp_item_variable_" + result.idStock + "");
            _inStock.parent().find(".tp_item_variable").removeClass("checked");
            $(".tp_item_variable_" + result.idStock + "").addClass("checked");
            if (result.data._stock > 0) {
                $("input.tp_cardQuantity").attr("max", result.data._stock);
                $(".js_product_stock").text(
                    result.data._stock + " sản phẩm có sẵn"
                );
            } else {
                $("input.tp_cardQuantity").attr("max", 1000);
                $(".js_product_stock").text("sản phẩm có sẵn");
            }
        } else {
            $(".tp_addToCart").addClass("disabled");
            $(".js_product_stock").text("Hết hàng");
        }
        /*array id con hang*/
        var version = result.data;
        if ($.isArray(version)) {
            version = version[0];
        }
        var title = JSON.parse(version.title_version).join(", ");
        var price_version = parseFloat(version.price_version);
        var price_sale_version = parseFloat(version.price_sale_version);
        $(".tp_addToCart")
            .attr("data-title-version", title)
            .attr("data-src", version.image_version)
            .attr("data-id-version", version.id_version);
        $(".tp_product_code").text(version.code_version);
        if (price_sale_version > 0) {
            $(".tp_addToCart").attr("data-price", price_sale_version);
            $(".tp_product_price_final").text(
                numberWithCommas(price_sale_version) + "đ"
            );
            $(".tp_product_price_old").text(
                numberWithCommas(price_version) + "đ"
            );
            var percent = Math.round(
                ((price_version - price_sale_version) * 100) / price_version
            );
            $(".tp_product_percent").text("-" + percent + "%");
            $(".tp_product_percent").html(
                '<span style="padding: 4px 10px;">-' + percent + "%</span>"
            );
        } else {
            if (price_version > 0) {
                $(".tp_product_price_final").text(
                    numberWithCommas(price_version) + "đ"
                );
            } else {
                $(".tp_product_price_final").text("Liên hệ");
            }
            $(".tp_product_percent").html("");
            $(".tp_product_price_old").text("");
            $(".tp_addToCart").attr("data-price", price_version);
        }
    }
});
