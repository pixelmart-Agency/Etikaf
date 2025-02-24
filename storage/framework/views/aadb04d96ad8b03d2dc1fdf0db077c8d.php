<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.users_list'); ?>
<?php $__env->stopSection(); ?>
<?php if(old('app_user_type', $user->app_user_type)): ?>
    <?php if($user->app_user_type == 'visitor'): ?>
        <style id="dynamic-style">
            #visa_number_div {
                display: block !important;
            }
        </style>
    <?php else: ?>
        <style id="dynamic-style">
            #visa_number_div {
                display: none !important;
            }
        </style>
    <?php endif; ?>
<?php endif; ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'users.index',
        'parent_title' => __('translation.users_list'),
        'title' => isset($user->id)
            ? __('translation.editUser') . ' - ' . getTransValue($user->name)
            : __('translation.addNewUser'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.form.header', [
        'action' => isset($user->id) ? route('users.update', $user->id) : route('users.store'),
        'title' => isset($user->id) ? __('translation.editUser') : __('translation.addNewUser'),
        'method' => isset($user->id) ? 'PUT' : 'POST',
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14"><?php echo e(__('translation.Name')); ?></label>
            <input type="text" id="name" name="name" placeholder="<?php echo e(__('translation.Name')); ?>"
                value="<?php echo e(old('name', getTransValue($user->name))); ?>" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="app_user_type" class="block-title fs-14"><?php echo e(__('translation.user_type')); ?></label>
            <select name="app_user_type" class="form-control" id="app_user_type">
                <option value=""><?php echo e(__('translation.select_user_app_type')); ?></option>
                <?php $__currentLoopData = App\Enums\AppUserTypesEnum::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $app_user_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($app_user_type->value); ?>"
                        <?php echo e(old('app_user_type', $user->app_user_type) == $app_user_type->value ? 'selected' : ''); ?>>
                        <?php echo e(__('translation.' . $app_user_type->value)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3" id="visa_number_div">
        <fieldset class="flex-grow-1">
            <label for="visa_number" class="block-title fs-14"><?php echo e(__('translation.visa_number')); ?></label>
            <input type="text" id="visa_number" name="visa_number" placeholder="<?php echo e(__('translation.visa_number')); ?>"
                value="<?php echo e(old('visa_number', $user->visa_number)); ?>" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="document_number" class="block-title fs-14"><?php echo e(__('translation.document_type')); ?></label>
            <select id="document_type" name="document_type" class="form-control">
                <option value=""><?php echo e(__('translation.select_document_type')); ?></option>
                <?php $__currentLoopData = App\Enums\DocumentTypesEnum::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $document_type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($document_type->value); ?>"
                        <?php echo e(old('document_type', $user->document_type) == $document_type->value ? 'selected' : ''); ?>>
                        <?php echo e(__('translation.' . $document_type->value)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="document_number" class="block-title fs-14"><?php echo e(__('translation.National ID')); ?></label>
            <input type="text" id="document_number" name="document_number"
                placeholder="<?php echo e(__('translation.National ID')); ?>"
                value="<?php echo e(old('document_number', $user->document_number)); ?>" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="country_id" class="block-title fs-14"><?php echo e(__('translation.Nationality')); ?></label>
            <select id="country_id" name="country_id" class="form-control">
                <option value=""><?php echo e(__('translation.select_country')); ?></option>
                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($country->id); ?>"
                        <?php echo e(old('country_id', $user->country_id) == $country->id ? 'selected' : ''); ?>>
                        <?php echo e(getTransValue($country->name)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="birthday" class="block-title fs-14"><?php echo e(__('translation.Date of Birth')); ?></label>
            <input type="text" id="birthday" name="birthday" placeholder="<?php echo e(__('translation.Date of Birth')); ?>"
                format="YYYY-MM-DD" value="<?php echo e(old('birthday', $user->birthday)); ?>" class="form-control datetimepicker">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="mobile" class="block-title fs-14"><?php echo e(__('translation.Mobile')); ?></label>
            <input type="text" id="mobile" name="mobile" placeholder="<?php echo e(__('translation.Mobile')); ?>"
                value="<?php echo e(old('mobile', $user->mobile)); ?>" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="email" class="block-title fs-14"><?php echo e(__('translation.Email')); ?></label>
            <input type="email" id="email" name="email" placeholder="<?php echo e(__('translation.Email')); ?>"
                value="<?php echo e(old('email', $user->email)); ?>" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1 password-container">
            <label for="password" class="block-title fs-14"><?php echo e(__('translation.Password')); ?></label>
            <button type="button" id="toggle-password" aria-label="Show password" aria-pressed="false">
            </button>
            <input type="password" id="password" name="password" placeholder="<?php echo e(__('translation.Password')); ?>"
                value="<?php echo e(old('password')); ?>" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1 password-container">
            <label for="password_confirmation" class="block-title fs-14"><?php echo e(__('translation.Confirm Password')); ?></label>
            <button type="button" id="toggle-confirm-password" aria-label="Show password" aria-pressed="false">
            </button>
            <input type="password" id="password_confirmation" name="password_confirmation"
                placeholder="<?php echo e(__('translation.Confirm Password')); ?>" value="<?php echo e(old('password_confirmation')); ?>"
                class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="gender" class="block-title fs-14"><?php echo e(__('translation.Gender')); ?></label>
            <select id="gender" name="gender" class="form-control">
                <option value="male" <?php echo e(old('gender', $user->gender) == 'male' ? 'selected' : ''); ?>>
                    <?php echo e(__('translation.male')); ?>

                </option>
                <option value="female" <?php echo e(old('gender', $user->gender) == 'female' ? 'selected' : ''); ?>>
                    <?php echo e(__('translation.female')); ?>

                </option>
            </select>
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="is_active" class="block-title fs-14"><?php echo e(__('translation.user_status')); ?></label>
            <div>
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1"
                        name="is_active" <?php echo e(old('is_active', $user->is_active) ? 'checked' : ''); ?> value="1">
                    <label class="form-check-label" for="flexSwitchCheckChecked-1"><?php echo e(__('translation.active')); ?></label>
                    <label class="form-check-label"
                        for="flexSwitchCheckChecked-1"><?php echo e(__('translation.inactive')); ?></label>
                </div>
            </div>
        </fieldset>
    </div>
    <?php echo $__env->make('components.image', ['single' => $user, 'name' => 'avatar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



    <?php echo $__env->make('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('users.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        $(document).ready(function() {
            let styleTag = $('<style id="dynamic-style"></style>').appendTo('head');

            $('#app_user_type').change(function() {
                if ($(this).val() == 'visitor') {
                    console.log($(this).val());
                    styleTag.html('#visa_number_div { display: block !important; }');
                } else {
                    console.log($(this).val());
                    styleTag.html('#visa_number_div { display: none !important; }');
                }
            });
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>