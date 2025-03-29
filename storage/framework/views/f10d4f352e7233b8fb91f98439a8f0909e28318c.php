<?php $__env->startPush('javascript'); ?>
<?php if(session('error') || session('success')): ?>
<?php if(session('success')): ?>
<script>
    toastr.success('<?php echo session('success') ?>', 'Thông báo!')
</script>
<?php endif; ?>
<?php if(session('error')): ?>
<script>
    toastr.error('<?php echo session('error') ?>', 'Error!')
</script>
<?php endif; ?>
<?php endif; ?>
<?php $__env->stopPush(); ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/components/alert-success.blade.php ENDPATH**/ ?>