@push('javascript')
@if(session('error') || session('success'))
@if(session('success'))
<script>
    toastr.success('<?php echo session('success') ?>', 'Thông báo!')
</script>
@endif
@if(session('error'))
<script>
    toastr.error('<?php echo session('error') ?>', 'Error!')
</script>
@endif
@endif
@endpush