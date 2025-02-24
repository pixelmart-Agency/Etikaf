<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.delete_reasons'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo $__env->make('components.breadcrumb', [
            'parent_route' => 'delete-reasons.index',
            'parent_title' => __('translation.delete_reasons'),
            'title' => isset($delete_reason->id)
                ? __('translation.edit_delete_reason') . ' - ' . getTransValue($delete_reason->title)
                : __('translation.add_new_delete_reason'),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('components.form.header', [
            'action' => isset($delete_reason->id)
                ? route('delete-reasons.update', $delete_reason->id)
                : route('delete-reasons.store'),
            'title' => isset($delete_reason->id) ? __('translation.edit_reason') : __('translation.addNewReason'),
            'method' => isset($delete_reason->id) ? 'PUT' : 'POST',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="d-flex gap-3 flex-wrap">
            <fieldset class="flex-grow-1">
                <label for="title" class="block-title fs-14"><?php echo e(__('translation.title')); ?></label>
                <input type="text" id="title" name="title[ar]" placeholder="<?php echo e(__('translation.title')); ?>"
                    value="<?php echo e(old('title.ar', getTransValue($delete_reason->title))); ?>" class="form-control">
            </fieldset>

        </div>

        <?php echo $__env->make('components.form.footer', [
            'btn_text' => __('translation.Submit'),
            'confirm_title' => __('translation.confirm_title'),
            'backRoute' => route('delete-reasons.index'),
            // 'confirm_message' => __('translation.confirm_message'),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/delete_reasons/edit.blade.php ENDPATH**/ ?>