<!DOCTYPE html>
<html lang="ar" dir="rtl">


<!-- login23:11-->

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(assetUrl('img/favicon-2.ico')); ?>">
    <title><?php echo $__env->yieldContent('title'); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrl('css_v2/bootstrap.rtl@5.3.3.min.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrl('css/style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrl('css_v2/custom.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrl('css_v2/mahmoud_custom.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrl('css_v2/style.css')); ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrl('css_v2/responsive.css')); ?>">


    <style>
        .login-form-errors {
            color: #a24b4b;
            font-size: 14px;
            font-weight: 310;
        }
    </style>
    <!--[if lt IE 9]>
        <script src="assets/js/html5shiv.min.js"></script>
        <script src="assets/js/respond.min.js"></script>
        <![endif]-->
</head>

<?php echo $__env->yieldContent('content'); ?>
<?php echo $__env->make('layouts.flash_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<script src="<?php echo e(assetUrl('js_v2/custom.js')); ?>"></script>
<?php echo $__env->yieldContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/auth/layouts/app.blade.php ENDPATH**/ ?>