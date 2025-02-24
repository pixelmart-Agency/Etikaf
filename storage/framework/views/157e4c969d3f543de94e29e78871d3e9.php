<div id="reassign-submission" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header flex-column align-items-start">
                <h2 class="block-title fs-20 mb-1"><?php echo e(__('translation.reassign_request')); ?></h2>
                <div class="block-text fs-18">
                    <p><?php echo e(__('translation.select_assign_employee')); ?></p>
                </div>
            </div>
            <div class="modal-body p-0">
                <form action="<?php echo e(route('retreat-service-requests.reassign', $request->id)); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="form-group p-4 border-bottom">
                        <label
                            class="fs-16 fw-medium mb-2 text-blue"><?php echo e(__('translation.reassign_request_to')); ?></label>
                        <div class="form-group form-focus select-focus mb-0">
                            <select id="selectForward" name="employee_id">
                                <option value="" disabled selected hidden>
                                    <?php echo e(__('translation.reassign_request_to')); ?></option>
                                <!-- Placeholder option -->
                                <?php $__currentLoopData = $employees; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $employee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($employee->id); ?>"><?php echo e($employee->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                        </div>
                    </div>
                    <div class="btn-cont justify-content-between px-4 pb-4">
                        <button type="button" class="main-btn text-blue bg-main-color close"
                            data-dismiss="modal"><?php echo e(__('translation.Cancel')); ?></button>
                        <button type="submit" class="main-btn bg-gold">
                            <?php echo e(__('translation.confirm_reassign')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/modals/reassign_employee.blade.php ENDPATH**/ ?>