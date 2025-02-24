<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.employees_list'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                <?php echo $__env->make('components.index_head', [
                    'title' => __('translation.employees_list'),
                    'createRoute' => route('employees.create'),
                    'placeholder' => __('translation.SearchEmployee'),
                    'btn' => __('translation.addNewEmployee'),
                    'exportRoute' => route('employees.export'),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('translation.document_number')); ?></th>
                                            <th><?php echo e(__('translation.name_nationality')); ?></th>
                                            <?php if(auth()->user()->is_admin()): ?>
                                                <th><?php echo e(__('translation.employee_permissions')); ?></th>
                                                <th><?php echo e(__('translation.employee_status')); ?></th>
                                            <?php endif; ?>
                                            <th><?php echo e(__('translation.created_at')); ?></th>
                                            <th></th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $__env->make('components.datatable.table', [
                                            'data' => $employees,
                                            'route' => 'employees',
                                            'hasDelete' => false,
                                            'customColumns' => 'employees',
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/employees/index.blade.php ENDPATH**/ ?>