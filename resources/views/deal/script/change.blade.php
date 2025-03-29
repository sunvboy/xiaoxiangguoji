<script>
    $(document).on('change', '.js_changeBrand', function(e) {
        var value = $(this).val();
        var id = $(this).parent().attr('data-id');
        var _this = $(this)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            url: '<?php echo route('deals.ajax.updatePL') ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                value: value,
                id: id
            },
            success: function(data) {
                if (data.status == 200) {
                    $('.brand-title-' + id).html(value)
                    _this.val('')
                    toastr.success(data.message, 'Thông báo')
                } else {
                    toastr.error(data.message, 'Thông báo')
                }

            }
        });
    })
    $(document).on('change', '.js_changeTags', function(e) {
        var value = $(this).val();
        var id = $(this).parent().attr('data-id');
        var _this = $(this)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            beforeSend: function() {},
            complete: function(data) {

            },
            url: '<?php echo route('deals.ajax.updateDT') ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                value: value,
                id: id
            },
            success: function(data) {
                if (data.status == 200) {
                    $('.listTags-' + id).html(data.html)
                    _this.val('')
                    toastr.success(data.message, 'Thông báo')
                } else {
                    toastr.error(data.message, 'Thông báo')
                }

            }
        });
    })
    $(document).on('click', '.js_removeDT', function(e) {
        e.preventDefault()
        var value = $(this).attr('data-value');
        var id = $(this).attr('data-id');
        var _this = $(this)
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                    "content"
                ),
            },
            beforeSend: function() {},
            complete: function(data) {

            },
            url: '<?php echo route('deals.ajax.RemoveDT') ?>',
            type: "POST",
            dataType: "JSON",
            data: {
                value: value,
                id: id
            },
            success: function(data) {
                if (data.status == 200) {
                    $('.listTags-' + id).html(data.html)
                    _this.val('')
                    toastr.success(data.message, 'Thông báo')
                } else {
                    toastr.error(data.message, 'Thông báo')
                }

            }
        });
    })
</script>