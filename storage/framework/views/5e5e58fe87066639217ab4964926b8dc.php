<td class="delete-td">
    <?php if($is_deletable): ?>
        <a href="#request-delete-<?php echo e($id); ?>" data-toggle="modal"
            data-target="#request-delete-<?php echo e($id); ?>">
            <i aria-hidden="true"></i> <?php echo e(__('translation.delete')); ?>

        </a>
    <?php endif; ?>
</td>
<div id="request-delete-<?php echo e($id); ?>" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="<?php echo e($route); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php echo method_field('DELETE'); ?>
        <div class="modal-dialog">
            <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
                <div class="modal-header border-0 flex-column align-items-center py-0 mb-40">
                    <div class="img-cont mb-4">
                        <img src="<?php echo e(assetUrl('assets/img_v2/img-request-denied.png')); ?>" class="w-100 mw-100"
                            alt="">
                    </div>
                    <h2 class="block-title mb-2 fs-24"><?php echo e(__('translation.sureToDelete')); ?></h2>
                    <div class="block-text fs-18">
                        <p><?php echo e(__('translation.delete_alert')); ?></p>
                    </div>
                </div>
                <div class="modal-body py-0">
                    <div class="btn-cont gap-2 justify-content-center">
                        <button type="button" class="main-btn text-blue bg-main-color close"
                            data-dismiss="modal"><?php echo e(__('translation.Cancel')); ?></button>
                        <button type="submit" class="main-btn bg-gold" id="btn-remove-que">
                            <?php echo e(__('translation.confirm_delete')); ?>

                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/delete.blade.php ENDPATH**/ ?>