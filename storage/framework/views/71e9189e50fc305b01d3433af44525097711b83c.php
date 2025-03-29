 <?php if(!$configIs->isEmpty()): ?>
 <?php $__currentLoopData = $configIs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
 <th><?php echo $item->title; ?></th>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 <?php endif; ?><?php /**PATH D:\xampp\htdocs\chuan.local\resources\views/components/table/is_thead.blade.php ENDPATH**/ ?>