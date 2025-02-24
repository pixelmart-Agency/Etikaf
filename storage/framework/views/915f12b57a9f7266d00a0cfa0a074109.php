<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.Settings'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="row">
            <?php echo $__env->make('components.breadcrumb', [
                'parent_route' => 'retreat-instructions.index',
                'parent_title' => __('translation.Settings'),
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
        <?php echo $__env->make('components.form.header', [
            'action' => route('settings.store'),
            'title' => __('translation.Settings'),
            'method' => 'POST',
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="d-flex gap-3 flex-wrap">
            <fieldset class="flex-grow-1">
                <label for="app_name_ar" class="block-title fs-14"><?php echo e(__('translation.app_name')); ?></label>
                <input type="text" id="app_name_ar" name="app_name_ar" placeholder="<?php echo e(__('translation.app_name')); ?>"
                    value="<?php echo e(old('app_name_ar', getSetting('app_name_ar'))); ?>" class="form-control">
            </fieldset>
        </div>
        <div class="d-flex gap-3 flex-wrap mt-3">
            <fieldset class="flex-grow-1">
                <label for="app_email" class="block-title fs-14"><?php echo e(__('translation.app_email')); ?></label>
                <input type="text" id="app_email" name="app_email" placeholder="<?php echo e(__('translation.app_email')); ?>"
                    value="<?php echo e(old('app_email', getSetting('app_email'))); ?>" class="form-control">
            </fieldset>
        </div>
        <div class="d-flex gap-3 flex-wrap mt-3">
            <fieldset class="flex-grow-1">
                <label for="app_email" class="block-title fs-14"><?php echo e(__('translation.rate_question')); ?></label>
                <input type="text" id="rate_question" name="rate_question"
                    placeholder="<?php echo e(__('translation.rate_question')); ?>"
                    value="<?php echo e(old('rate_question', getSetting('rate_question'))); ?>" class="form-control">
            </fieldset>
        </div>
        <div class="d-flex gap-3 flex-wrap mt-3">
            <fieldset class="flex-grow-1">
                <label for="app_email" class="block-title fs-14"><?php echo e(__('translation.rate_question_title')); ?></label>
                <input type="text" id="rate_question_title" name="rate_question_title"
                    placeholder="<?php echo e(__('translation.rate_question_title')); ?>"
                    value="<?php echo e(old('rate_question_title', getSetting('rate_question_title'))); ?>" class="form-control">
            </fieldset>
        </div>
        <?php echo $__env->make('components.setting_image', ['name' => 'app_logo'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="d-flex gap-3 flex-wrap mt-3">

            <?php echo $__env->make('components.form.footer', [
                'btn_text' => __('translation.Submit'),
                'confirm_title' => __('translation.confirm_title'),
                'backRoute' => route('retreat-instructions.index'),
                // 'confirm_message' => __('translation.confirm_message'),
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/setting/index.blade.php ENDPATH**/ ?>