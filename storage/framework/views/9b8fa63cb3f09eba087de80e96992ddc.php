<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.activity_logs'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                <?php echo $__env->make('components.index_head', [
                    'title' => __('translation.activity_logs'),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('translation.notification_text')); ?></th>
                                            <th><?php echo e(__('translation.activity_time')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $index = 1;
                                        ?>
                                        <?php $__currentLoopData = $notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($index++); ?></td>
                                                <td>
                                                    <img width="32" height="32"
                                                        src="<?php echo e(imageUrl($notification->causer?->avatar_url)); ?>"
                                                        class="rounded-circle me-2" alt="">
                                                    <a onclick="markAsRead('<?php echo e($notification->id); ?>')"
                                                        notify-id="<?php echo e($notification->id); ?>"
                                                        is-read="<?php echo e(isset($notification->properties['is_read'])); ?>"
                                                        <?php if(switchLogRoute($notification)): ?> href="<?php echo e(switchLogRoute($notification) ?? ''); ?>" <?php endif; ?>
                                                        target="_blank">
                                                        <?php echo e($notification->causer?->name ?? $notification->causer?->document_number); ?>

                                                        <?php echo e(switchLogText($notification)); ?>

                                                    </a>
                                                </td>
                                                <td
                                                    class="<?php echo e(!isset($notification->properties['is_read']) ? 'under-review' : ''); ?>">
                                                    <?php echo e($notification->created_at->diffForHumans()); ?>

                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/notifications/index.blade.php ENDPATH**/ ?>