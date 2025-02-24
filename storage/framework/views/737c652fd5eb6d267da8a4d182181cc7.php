 <div id="<?php echo e($id ?? 'request-createSurvey'); ?>" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
     <div class="modal-dialog">
         <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
             <div class="modal-header border-0 flex-column align-items-center py-0 mb-40">
                 <div class="img-cont mb-4">
                     <img src="<?php echo e(assetUrl('img_v2/img-request-denied.png')); ?>" class="w-100 mw-100" alt="">
                 </div>
                 <h2 class="block-title mb-2 fs-24"><?php echo e($confirm_title); ?></h2>
                 <div class="block-text fs-18">
                     <p><?php echo e($confirm_message ?? ''); ?></p>
                 </div>
             </div>
             <div class="modal-body py-0">
                 <div class="btn-cont gap-2 justify-content-center">
                     <button type="button" class="main-btn text-blue bg-main-color close"
                         data-dismiss="modal"><?php echo e(__('translation.Cancel')); ?></button>
                     <a href="<?php echo e($route); ?>" class="main-btn bg-gold" id="btn-remove-que">
                         <?php echo e(__('translation.Yes')); ?>

                     </a>
                 </div>
             </div>
         </div>
     </div>
 </div>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/modals/common_modal.blade.php ENDPATH**/ ?>