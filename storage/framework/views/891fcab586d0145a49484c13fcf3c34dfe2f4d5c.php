
<?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $field): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make($crud->getFirstFieldView($field['type'], $field['view_namespace'] ?? false), $field, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php /**PATH C:\Projects\needhelp\resources\views/vendor/backpack/crud/inc/show_fields.blade.php ENDPATH**/ ?>