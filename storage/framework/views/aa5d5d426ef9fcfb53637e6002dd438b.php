 <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
     <div class="text-cont">
         <h2 class="block-title"> <?php echo e($title); ?>

             <?php if(isset($recordCount)): ?>
                 (<?php echo e($recordCount); ?>)
             <?php endif; ?>

         </h2>
     </div>
     <div class="d-flex flex-wrap align-items-center gap-2">
         <fieldset class="position-relative">
             <legend class="sr-only">Search input</legend>
             <input type="search" class="form-control" id="inputSearchTable" autocomplete="off"
                 placeholder="<?php echo e($placeholder ?? ''); ?>">
             <i class="icon-search-i position-absolute top-50 translate-middle-y ms-3"></i>
         </fieldset>
         <button type="submit" class="btn-submit" id="submitFilterTable"></button>
         <button type="button" class="custom-popovers" id="btnExportTable" data-content="تصدير"></button>
         <?php if(isset($createRoute)): ?>
             <a href="<?php echo e($createRoute ?? ''); ?>" class="main-btn fs-14"><?php echo e($btn ?? ''); ?></a>
         <?php endif; ?>
     </div>
 </div>
 <?php if(isset($exportRoute)): ?>
     <input type="hidden" id="export-route" value="<?php echo e($exportRoute ?? ''); ?>">
     <input type="hidden" id="file-name" value="<?php echo e($fileName ?? ''); ?>">
 <?php endif; ?>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/index_head.blade.php ENDPATH**/ ?>