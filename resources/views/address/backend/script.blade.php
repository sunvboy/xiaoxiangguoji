@push('javascript')
<script>
    $(document).on('change', '#cityID', function(e, data) {
        $.post('<?php echo route('addresses.getLocation') ?>', {
                id: $(this).val(),
                'type': 'district',
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                let json = JSON.parse(data);
                $('#districtID').html(json.html);
                $('#wardID').html('<option value="0">Chọn Phường/Xã</option>');
            });
    });
    $(document).on('change', '#districtID', function(e, data) {
        $.post('<?php echo route('addresses.getLocation') ?>', {
                id: $(this).val(),
                'type': 'ward',
                "_token": $('meta[name="csrf-token"]').attr("content")
            },
            function(data) {
                let json = JSON.parse(data);
                $('#wardID').html(json.html);
            });
    });
</script>
@endpush