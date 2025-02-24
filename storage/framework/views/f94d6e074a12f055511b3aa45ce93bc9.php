<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Retreat_service_categories'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                <?php echo $__env->make('components.index_head', [
                    'title' => __('translation.Retreat_service_categories'),
                    'createRoute' => route('retreat-service-categories.create'),
                    'placeholder' => __('translation.SearchRetreatServiceCategory'),
                    'btn' => __('translation.addNewRetreatServiceCategory'),
                    'exportRoute' => route('retreat-service-categories.export'),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('translation.title')); ?></th>
                                            <?php echo $__env->make('components.common_th', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $__env->make('components.datatable.table', [
                                            'data' => $retreat_service_categories,
                                            'route' => 'retreat-service-categories',
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/retreat_service_categories/index.blade.php ENDPATH**/ ?>