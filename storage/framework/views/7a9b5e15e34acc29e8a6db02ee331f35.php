<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Retreat_mosque_locations'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="row">
            <?php echo $__env->make('components.breadcrumb', [
                'parent_route' => 'retreat-mosque-locations.index',
                'parent_title' => __('translation.Retreat_mosque_locations'),
                'title' => isset($retreat_mosque_location->id)
                    ? __('translation.editMosqueLocation')
                    : __('translation.addNewMosqueLocation'),
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <?php echo $__env->make('components.form.header', [
            'action' => isset($retreat_mosque_location->id)
                ? route('retreat-mosque-locations.update', $retreat_mosque_location->id)
                : route('retreat-mosque-locations.store'),
            'title' => isset($retreat_mosque_location->id)
                ? __('translation.editMosqueLocation')
                : __('translation.addNewMosqueLocation'),
            'method' => isset($retreat_mosque_location->id) ? 'PUT' : 'POST',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="d-flex gap-3 flex-wrap">
            <fieldset class="flex-grow-1">
                <label for="name" class="block-title fs-14"><?php echo e(__('translation.mosque_location_name')); ?></label>
                <input type="text" id="name" name="name[ar]" placeholder="<?php echo e(__('translation.mosque_location_name')); ?>"
                    value="<?php echo e(old('name.ar', getTransValue($retreat_mosque_location->name))); ?>" class="form-control">
            </fieldset>
        </div>
        <div class="d-flex gap-3 flex-wrap mt-3">
            <fieldset class="flex-grow-1">
                <label for="phone_code" class="block-title fs-14"><?php echo e(__('translation.retreat_mosque')); ?></label>
                <select id="retreat_mosque_id" name="retreat_mosque_id" class="form-control">
                    <option value=""><?php echo e(__('translation.select_mosque')); ?></option>
                    <?php $__currentLoopData = $retreat_mosques; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $retreat_mosque): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($retreat_mosque->id); ?>"
                            <?php echo e(old('retreat_mosque_id', $retreat_mosque_location->retreat_mosque_id) == $retreat_mosque->id ? 'selected' : ''); ?>>
                            <?php echo e(getTransValue($retreat_mosque->name)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </fieldset>
        </div>
        <div class="d-flex gap-3 flex-wrap mt-3">
            <fieldset class="flex-grow-1">
                <label for="phone_code" class="block-title fs-14"><?php echo e(__('translation.Location')); ?></label>
                <?php echo $__env->make('components.inputs.map', [
                    'location' => $retreat_mosque_location->location,
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="phone_code" class="block-title fs-14"><?php echo e(__('translation.Description')); ?></label>
            <textarea id="description" name="description[ar]" placeholder="<?php echo e(__('translation.Description')); ?>"
                class="form-control"><?php echo e(old('description.ar', getTransValue($retreat_mosque_location->description))); ?></textarea>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="sort_order" class="block-title fs-14"><?php echo e(__('translation.sort_order')); ?></label>
            <input type="number" id="sort_order" name="sort_order" placeholder="<?php echo e(__('translation.sort_order')); ?>"
                value="<?php echo e(old('sort_order', $retreat_mosque_location->sort_order)); ?>"
                class="form-control input-right-align">
        </fieldset>
    </div>
    <?php echo $__env->make('components.image', [
        'single' => $retreat_mosque_location,
        'name' => 'image',
        'recommended_size' => '500x500',
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


    <?php echo $__env->make('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('retreat-mosque-locations.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/retreat_mosque_locations/edit.blade.php ENDPATH**/ ?>