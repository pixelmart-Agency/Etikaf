<td>
    <?php echo e($single->document_number); ?>

</td>
<td>
    <img width="32" height="32" src="<?php echo e(imageUrl($single->avatar_url)); ?>" class="rounded-circle me-2" alt="">
    <h2><a href="<?php echo e(route('employees.edit', $single->id)); ?>">
            <?php echo e($single->name); ?>

            <span><?php echo e(getTransValue($single->country?->name)); ?></span>
    </h2>
</td>
<?php if(auth()->user()->is_admin()): ?>
    <td class="tags-td">
        <div class="d-flex gap-2 flex-wrap">
            <?php if($single->permissions->count() > 0): ?>
                <?php $__currentLoopData = $single->permissions()->limit(3)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <span class="td-span"><?php echo e(__('translation.' . $permission->name)); ?></span>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if($single->permissions->count() > 3): ?>
                <span class="td-span-more">
                    <?php echo e($single->permissions->count() - 3); ?>

                    +</span>
            <?php endif; ?>
        </div>
    </td>
    <td class="switch-td">
        <div>
            <div class="form-check form-switch mb-0">
                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1"
                    name="is_active" <?php echo e(old('is_active', $single->is_active) ? 'checked' : ''); ?> value="1"
                    onclick="switchStatus(this, '<?php echo e(route('employees.switch-status', $single)); ?>')">
                <label class="form-check-label" for="flexSwitchCheckChecked-1"><?php echo e(__('translation.active')); ?></label>
                <label class="form-check-label" for="flexSwitchCheckChecked-1"><?php echo e(__('translation.inactive')); ?></label>
            </div>
        </div>
    </td>
<?php endif; ?>
<td>
    <?php echo e(convertToHijri($single->created_at)); ?>

</td>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/datatable/employees.blade.php ENDPATH**/ ?>