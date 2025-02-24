<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Countries'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'countries.index',
        'parent_title' => __('translation.Countries'),
        'title' => isset($country->id)
            ? __('translation.editCountry') . ' - ' . getTransValue($country->name)
            : __('translation.addNewCountry'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.form.header', [
        'action' => isset($country->id) ? route('countries.update', $country->id) : route('countries.store'),
        'title' => isset($country->id) ? __('translation.editCountry') : __('translation.addNewCountry'),
        'method' => isset($country->id) ? 'PUT' : 'POST',
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14"><?php echo e(__('translation.country_name')); ?></label>
            <input type="text" id="name" name="name[ar]" placeholder="<?php echo e(__('translation.country_name')); ?>"
                value="<?php echo e(old('name.ar', getTransValue($country->name))); ?>" class="form-control">
        </fieldset>

    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="phone_code" class="block-title fs-14"><?php echo e(__('translation.country_phone_code')); ?></label>
            <input type="number" id="phone_code" name="phone_code" placeholder="<?php echo e(__('translation.country_phone_code')); ?>"
                value="<?php echo e(old('phone_code', $country->phone_code)); ?>" class="form-control input-right-align">
        </fieldset>
    </div>

    <?php echo $__env->make('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('countries.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/countries/edit.blade.php ENDPATH**/ ?>