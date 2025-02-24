<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Dashboard'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <input type="hidden" id="file-name" value="<?php echo e(__('translation.retreat_requests_report')); ?>">
    <?php echo $__env->make('components.request_components.states', [
        'newRequests' => $newRequests,
        'approvedRequests' => $approvedRequests,
        'completedRequests' => $completedRequests,
        'canceledRequests' => $canceledRequests,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.request_components.request_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php if(auth()->user()->hasPermissionTo('retreat_requests')): ?>
        <?php echo $__env->make('components.request_components.request_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/home/index.blade.php ENDPATH**/ ?>