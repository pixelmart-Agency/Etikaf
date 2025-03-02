<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Retreat_mosques'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'retreat-mosques.index',
        'parent_title' => __('translation.Retreat_mosques'),
        'title' => isset($retreat_mosque->id) ? __('translation.editMosque') : __('translation.addNewMosque'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.form.header', [
        'action' => isset($retreat_mosque->id)
            ? route('retreat-mosques.update', $retreat_mosque->id)
            : route('retreat-mosques.store'),
        'title' => isset($retreat_mosque->id) ? __('translation.editMosque') : __('translation.addNewMosque'),
        'method' => isset($retreat_mosque->id) ? 'PUT' : 'POST',
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14"><?php echo e(__('translation.mosque_name')); ?></label>
            <input type="text" id="name" name="name[ar]" placeholder="<?php echo e(__('translation.mosque_name')); ?>"
                value="<?php echo e(old('name.ar', getTransValue($retreat_mosque->name))); ?>" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="phone_code" class="block-title fs-14"><?php echo e(__('translation.Description')); ?></label>
            <textarea id="description" name="description[ar]" placeholder="<?php echo e(__('translation.Description')); ?>"
                class="form-control"><?php echo e(old('description.ar', getTransValue($retreat_mosque->description))); ?></textarea>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="sort_order" class="block-title fs-14"><?php echo e(__('translation.sort_order')); ?></label>
            <input type="number" id="sort_order" name="sort_order" placeholder="<?php echo e(__('translation.sort_order')); ?>"
                value="<?php echo e(old('sort_order', $retreat_mosque->sort_order)); ?>" class="form-control input-right-align">
        </fieldset>
    </div>
    <?php echo $__env->make('components.image', [
        'single' => $retreat_mosque,
        'name' => 'image',
        'recommended_size' => '500x500',
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php echo $__env->make('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('retreat-mosques.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/retreat_mosques/edit.blade.php ENDPATH**/ ?>