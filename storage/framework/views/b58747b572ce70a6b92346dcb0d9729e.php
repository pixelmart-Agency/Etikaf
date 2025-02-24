<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.users_list'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                <?php echo $__env->make('components.index_head', [
                    'title' => __('translation.users_list'),
                    'createRoute' => route('users.create'),
                    'placeholder' => __('translation.SearchEmployee'),
                    'btn' => __('translation.addNewUser'),
                    'exportRoute' => route('users.export'),
                    'recordCount' => $users->count(),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('translation.document_number_passport')); ?></th>
                                            <th><?php echo e(__('translation.name_nationality')); ?></th>
                                            <th><?php echo e(__('translation.registered_at')); ?></th>
                                            <th><?php echo e(__('translation.user_request_status')); ?></th>
                                            <th><?php echo e(__('translation.user_status')); ?></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $__env->make('components.datatable.table', [
                                            'data' => $users,
                                            'route' => 'users',
                                            'hasDelete' => false,
                                            'customColumns' => 'users',
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/users/index.blade.php ENDPATH**/ ?>