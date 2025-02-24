<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.employees_list'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'employees.index',
        'parent_title' => __('translation.employees_list'),
        'title' => isset($employee->id)
            ? __('translation.editEmployee') . ' - ' . getTransValue($employee->name)
            : __('translation.addNewEmployee'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.form.header', [
        'action' => isset($employee->id) ? route('employees.update', $employee->id) : route('employees.store'),
        'title' => isset($employee->id) ? __('translation.editEmployee') : __('translation.addNewEmployee'),
        'method' => isset($employee->id) ? 'PUT' : 'POST',
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14"><?php echo e(__('translation.Name')); ?></label>
            <input type="text" id="name" name="name" placeholder="<?php echo e(__('translation.Name')); ?>"
                value="<?php echo e(old('name', getTransValue($employee->name))); ?>" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="document_number" class="block-title fs-14"><?php echo e(__('translation.National ID')); ?></label>
            <input type="text" id="document_number" name="document_number"
                placeholder="<?php echo e(__('translation.National ID')); ?>"
                value="<?php echo e(old('document_number', $employee->document_number)); ?>" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="country_id" class="block-title fs-14"><?php echo e(__('translation.Nationality')); ?></label>
            <select id="country_id" name="country_id" class="form-control">
                <option value=""><?php echo e(__('translation.select_country')); ?></option>
                <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($country->id); ?>"
                        <?php echo e(old('country_id', $employee->country_id) == $country->id ? 'selected' : ''); ?>>
                        <?php echo e(getTransValue($country->name)); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="birthday" class="block-title fs-14"><?php echo e(__('translation.Date of Birth')); ?></label>
            <input type="text" id="birthday" name="birthday" placeholder="<?php echo e(__('translation.Date of Birth')); ?>"
                value="<?php echo e(old('birthday', $employee->birthday)); ?>" class="form-control datetimepicker">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="mobile" class="block-title fs-14"><?php echo e(__('translation.Mobile')); ?></label>
            <input type="text" id="mobile" name="mobile" placeholder="<?php echo e(__('translation.Mobile')); ?>"
                value="<?php echo e(old('mobile', $employee->mobile)); ?>" class="form-control">
        </fieldset>
        <fieldset class="flex-grow-1">
            <label for="email" class="block-title fs-14"><?php echo e(__('translation.Email')); ?></label>
            <input type="email" id="email" name="email" placeholder="<?php echo e(__('translation.Email')); ?>"
                value="<?php echo e(old('email', $employee->email)); ?>" class="form-control">
        </fieldset>
    </div>
    <?php if(auth()->user()->is_admin()): ?>
        <div class="form-group mb-0 mt-4">
            <label for="selectEmployeePermissions" class="block-title fs-16">
                <?php echo e(__('translation.employee_permissions')); ?>

                <span class="ms-1 text-red text-red-f5">*</span></label>
            <div class="form-group form-focus select-focus mb-0">
                <select id="selectEmployeePermissions" name="permissions[]" class="validate[required]"
                    placeholder="<?php echo e(__('translation.select_permissions')); ?>" multiple="multiple">
                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $permission): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($permission->id); ?>"
                            <?php echo e(in_array($permission->id, $employee->permissions->pluck('id')->toArray()) ||
                            in_array($permission->id, old('permissions', []))
                                ? 'selected'
                                : ''); ?>>
                            <?php echo e(__('translation.' . $permission->name)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    <?php endif; ?>
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
                <option value="male" <?php echo e(old('gender', $employee->gender) == 'male' ? 'selected' : ''); ?>>
                    <?php echo e(__('translation.male')); ?>

                </option>
                <option value="female" <?php echo e(old('gender', $employee->gender) == 'female' ? 'selected' : ''); ?>>
                    <?php echo e(__('translation.female')); ?>

                </option>
            </select>
        </fieldset>
        <?php if(auth()->user()->is_admin()): ?>
            <fieldset class="flex-grow-1">
                <label for="is_active" class="block-title fs-14"><?php echo e(__('translation.employee_status')); ?></label>
                <div>
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked-1"
                            name="is_active" <?php echo e(old('is_active', $employee->is_active) ? 'checked' : ''); ?>

                            value="1">
                        <label class="form-check-label"
                            for="flexSwitchCheckChecked-1"><?php echo e(__('translation.active')); ?></label>
                        <label class="form-check-label"
                            for="flexSwitchCheckChecked-1"><?php echo e(__('translation.inactive')); ?></label>
                    </div>
                </div>
            </fieldset>
        <?php endif; ?>
    </div>
    <?php echo $__env->make('components.image', ['single' => $employee, 'name' => 'avatar'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



    <?php echo $__env->make('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('employees.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/employees/edit.blade.php ENDPATH**/ ?>