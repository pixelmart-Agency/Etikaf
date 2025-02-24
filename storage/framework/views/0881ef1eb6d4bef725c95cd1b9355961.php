<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.rates'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                <?php echo $__env->make('components.index_head', [
                    'title' => __('translation.rates'),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('translation.user_name')); ?></th>
                                            <th><?php echo e(__('translation.answer')); ?></th>
                                            <th><?php echo e(__('translation.comment')); ?></th>
                                            <th><?php echo e(__('translation.created_at')); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $index = 1;
                                        ?>
                                        <?php $__currentLoopData = $rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr>
                                                <td><?php echo e($index++); ?></td>
                                                <td>
                                                    <img width="32" height="32"
                                                        src="<?php echo e(imageUrl($rate->user?->avatar_url)); ?>"
                                                        class="rounded-circle me-2" alt="">
                                                    <?php echo e($rate->user?->name); ?>

                                                </td>
                                                <td><?php echo e(__('translation.' . $rate->rate . '_rate')); ?></td>
                                                <td><?php echo e($rate->comment); ?></td>
                                                <td class="text-center">
                                                    <?php echo e(convertToHijri($rate->created_at)); ?> |
                                                    <?php echo e($rate->created_at->diffForHumans()); ?>

                                                </td>

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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/rates/index.blade.php ENDPATH**/ ?>