<div id="close-submission" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header flex-column align-items-start">
                <h2 class="block-title fs-20 mb-1"><?php echo e(__('translation.close_submission')); ?></h2>
                <div class="block-text fs-18">
                    <p><?php echo e(__('translation.choose_close_time')); ?></p>
                </div>
            </div>
            <div class="modal-body p-0">
                <form action="<?php echo e(route('schaduale_close_season')); ?>" method="post">
                    <?php echo csrf_field(); ?>
                    <div class="form-group p-4">
                        <label class="fs-16 fw-medium mb-2"><?php echo e(__('translation.close_submission_time')); ?></label>
                        <div class="cal-icon">
                            <input class="form-control datetimepicker" type="text" name="end_date"
                                format="YYYY-MM-DD" placeholder="<?php echo e(__('translation.choose_time')); ?>">
                        </div>
                    </div>
                    <div class="btn-cont justify-content-between px-4 pb-4">
                        <button type="button" class="main-btn text-blue bg-main-color close"
                            data-dismiss="modal"><?php echo e(__('translation.Cancel')); ?></button>
                        <button type="submit" class="main-btn bg-gold"><?php echo e(__('translation.approve_time')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/modals/schadual_end.blade.php ENDPATH**/ ?>