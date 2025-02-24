 <?php
 $i = 1;
 ?>

 <?php $__currentLoopData = $data; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $single): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <tr>
         <td><?php echo e($index + 1); ?></td>
         <?php if(isset($customColumns)): ?>
             <?php echo $__env->make('components.datatable.' . $customColumns, ['single' => $single], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php else: ?>
             <?php $__currentLoopData = $single->toArray(request()); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                 <?php if($key !== 'id'): ?>
                     <td><?php echo $value; ?></td>
                 <?php elseif($key === 'id' && $route === 'surveys'): ?>
                     <td><?php echo e($single->id); ?></td>
                 <?php endif; ?>
             <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
         <?php endif; ?>
         <?php if(isset($hasStatus) && $hasStatus): ?>
             <td class="switch-td">
                 <div>
                     <div class="form-check form-switch mb-0">
                         <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1"
                             name="is_active" <?php echo e(old('is_active', $single->is_active) ? 'checked' : ''); ?> value="1"
                             onclick="switchStatus(this, '<?php echo e(route($route . '.switch-status', $single)); ?>')">
                         <label class="form-check-label"
                             for="flexSwitchCheckChecked-1"><?php echo e(__('translation.active')); ?></label>
                         <label class="form-check-label"
                             for="flexSwitchCheckChecked-1"><?php echo e(__('translation.inactive')); ?></label>
                     </div>
                 </div>
             </td>
         <?php endif; ?>
         <?php if(!isset($hasEdit) || $hasEdit): ?>
             <?php echo $__env->make('components.edit', ['route' => route($route . '.edit', $single->id)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php endif; ?>
         <?php if(isset($hasShow) && $hasShow): ?>
             <?php echo $__env->make('components.show', ['route' => route($route . '.show', $single->id)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php endif; ?>
         <?php if(!isset($hasDelete) || $hasDelete): ?>
             <?php echo $__env->make('components.delete', [
                 'route' => route($route . '.destroy', $single->id),
                 'id' => $single->id,
                 'is_deletable' => $single->is_deletable ?? true,
             ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
         <?php endif; ?>
     </tr>
 <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/datatable/table.blade.php ENDPATH**/ ?>