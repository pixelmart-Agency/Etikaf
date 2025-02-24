<td>
    <?php echo e(__('translation.' . $single->document_type) . ' : ' . $single->document_number); ?>

</td>
<td>
    <img width="32" height="32" src="<?php echo e(imageUrl($single->avatar_url)); ?>" class="rounded-circle me-2" alt="">
    <h2><a href="<?php echo e(route('users.edit', $single->id)); ?>">
            <?php echo e($single->name); ?>

            <span><?php echo e(getTransValue($single->country?->name)); ?></span>
    </h2>
</td>
<td>
    <?php echo e(convertToHijri($single->created_at)); ?>

</td>
<td class="<?php echo e($single->status_class); ?>">
    <span><?php echo e($single->request_status); ?></span>
</td>
<td class="switch-td">
    <div>
        <div class="form-check form-switch mb-0">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1" name="is_active"
                <?php echo e(old('is_active', $single->is_active) ? 'checked' : ''); ?> value="1"
                onclick="switchStatus(this, '<?php echo e(route('users.switch-status', $single)); ?>')">
            <label class="form-check-label" for="flexSwitchCheckChecked-1"><?php echo e(__('translation.active')); ?></label>
            <label class="form-check-label" for="flexSwitchCheckChecked-1"><?php echo e(__('translation.inactive')); ?></label>
        </div>
    </div>
</td>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/datatable/users.blade.php ENDPATH**/ ?>