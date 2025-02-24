<?php $__env->startSection('title', __('translation.Login') . ' | ' . getSetting('app_name_' . myLang())); ?>
<?php $__env->startSection('content'); ?>
    <?php
        $countries = getDataByModel(App\Models\Country::class);
    ?>

    <body class="login23-page">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-7 col-xl-6">
                    <div class="main-wrapper account-wrapper">
                        <div class="account-page">
                            <div class="account-center">
                                <div class="account-box h-100">
                                    <form method="POST" action="<?php echo e(route('login')); ?>"
                                        class="form-signin h-100 d-flex flex-column">
                                        <?php echo csrf_field(); ?>
                                        <div class="account-logo">
                                            <a href="<?php echo e(route('home')); ?>" class="d-flex justify-content-start"><img
                                                    src="<?php echo e(getSettingMedia('app_logo')); ?>" alt=""></a>
                                        </div>
                                        <div class="text-cont mb-60">
                                            <h2 class="fs-45 text-blue mb-30"><?php echo e(__('translation.login_title')); ?></h2>
                                            <p class="text-light-blue fs-20 mb-0"><?php echo e(__('translation.login_description')); ?>

                                            </p>
                                        </div>
                                        <div class="form-group" role="group" aria-labelledby="phone-label">
                                            <label class="mb-2" id="phone-label"
                                                for="phone-number"><?php echo e(__('translation.phone_number')); ?></label>
                                            <div class="country-code-wrapper" aria-label="Select country code">
                                                <select id="country-code" class="form-select select2" dir="ltr"
                                                    name="phone_code" aria-describedby="phone-number-help" required
                                                    tabindex="2">
                                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($country->phone_code); ?>"
                                                            <?php if(old('phone_code', '966') == $country->phone_code): ?> selected <?php endif; ?>>
                                                            <?php echo e($country->phone_code); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                                <input id="phone-number" type="tel" value="<?php echo e(old('mobile')); ?>"
                                                    class="form-control" placeholder="<?php echo e(__('translation.phone_number')); ?>"
                                                    name="mobile" aria-describedby="phone-number-help"
                                                    style="text-align: right;" tabindex="1" autofocus>

                                            </div>

                                            <span id="phone-number-help" class="sr-only">
                                                <?php echo e(__('translation.phone_info')); ?>

                                            </span>
                                        </div>
                                        <div class="form-group mb-30" role="group" aria-labelledby="password-label">
                                            <label class="mb-2" id="password-label" for="password-number">
                                                <?php echo e(__('translation.Password')); ?>

                                            </label>

                                            <div class="password-container">
                                                <button type="button" id="toggle-password" aria-label="Show password"
                                                    aria-pressed="false">
                                                </button>
                                                <input id="password-number" type="password" class="form-control"
                                                    placeholder="<?php echo e(__('translation.Password')); ?>" name="password"
                                                    aria-describedby="pass-number-help" tabindex="3">
                                            </div>

                                            <span id="pass-number-help" class="sr-only">
                                                <?php echo e(__('translation.password_info')); ?>

                                        </div>
                                        <div class="form-group text-center">
                                            <button type="submit" class="main-btn account-btn w-100"
                                                tabindex="4"><?php echo e(__('translation.login')); ?></button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-5 col-xl-6 d-none d-lg-block">
                    <div class="text-cont">
                        <div class="img-cont position-relative w-100">
                            <img src="<?php echo e(assetUrl('img_v2/login-bg.png')); ?>"
                                class="position-absolute top-0 start-0 w-100 mw-100 h-100 mh-100" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="<?php echo e(assetUrl('js_v2/custom.js')); ?>"></script>
    </body>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('scripts'); ?>
    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            // Get the password input field
            var passwordField = document.getElementById('password-number');

            // Check the current type of the input field and toggle it
            if (passwordField.type === 'password') {
                passwordField.type = 'text'; // Show password
                this.setAttribute('aria-pressed', 'true'); // Update aria-pressed attribute to "true"
            } else {
                passwordField.type = 'password'; // Hide password
                this.setAttribute('aria-pressed', 'false'); // Update aria-pressed attribute to "false"
            }
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/auth/login.blade.php ENDPATH**/ ?>