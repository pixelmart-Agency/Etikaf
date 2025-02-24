<!DOCTYPE html>
<html lang="<?php echo e(myLang()); ?>" dir="<?php echo e(appDir()); ?>">

<head>
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(assetUrl('img/favicon-2.ico')); ?>">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title><?php echo $__env->yieldContent('title'); ?> | <?php echo e(getSetting('app_name_' . myLang())); ?></title>
    <style>
        /* *************** */
        /* CREATIVE LOADER */
        /* *************** */

        .creative_loader-overlay {
            background: white;
            display: flex;
            min-height: 100vh;
            justify-content: center;
            align-items: center;
            gap: 10em;
            position: fixed;
            top: 0px;
            right: 0;
            width: 100%;
            height: 100vh;
            z-index: 99999;
        }

        /* Centering the Loader */
        .creative_loader-container {
            position: relative;
            width: 120px;
            height: 120px;
        }

        /* Dot Styling */
        .creative_loader-container div {
            position: absolute;
            width: 16px;
            height: 16px;
            background-color: black;
            border-radius: 50%;
            animation: fade 1.3s linear infinite;
            animation-direction: reverse;

        }

        /* Correctly Positioning 13 Dots Around the Circle */
        /* Using trigonometry: 360° / 13 dots = 27.7° spacing */
        .creative_loader-container div:nth-child(1) {
            top: 50%;
            left: 100%;
            transform: translate(-50%, -50%);
            animation-delay: 1.2s;
        }

        .creative_loader-container div:nth-child(2) {
            top: 23%;
            left: 92%;
            transform: translate(-50%, -50%);
            animation-delay: 1.1s;
        }

        .creative_loader-container div:nth-child(3) {
            top: 7%;
            left: 75%;
            transform: translate(-50%, -50%);
            animation-delay: 1.0s;
        }

        .creative_loader-container div:nth-child(4) {
            top: 0%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 0.9s;
        }

        .creative_loader-container div:nth-child(5) {
            top: 7%;
            left: 25%;
            transform: translate(-50%, -50%);
            animation-delay: 0.8s;
        }

        .creative_loader-container div:nth-child(6) {
            top: 23%;
            left: 8%;
            transform: translate(-50%, -50%);
            animation-delay: 0.7s;
        }

        .creative_loader-container div:nth-child(7) {
            top: 50%;
            left: 0%;
            transform: translate(-50%, -50%);
            animation-delay: 0.6s;
        }

        .creative_loader-container div:nth-child(8) {
            top: 77%;
            left: 8%;
            transform: translate(-50%, -50%);
            animation-delay: 0.5s;
        }

        .creative_loader-container div:nth-child(9) {
            top: 93%;
            left: 25%;
            transform: translate(-50%, -50%);
            animation-delay: 0.4s;
        }

        .creative_loader-container div:nth-child(10) {
            top: 100%;
            left: 50%;
            transform: translate(-50%, -50%);
            animation-delay: 0.3s;
        }

        .creative_loader-container div:nth-child(11) {
            top: 93%;
            left: 75%;
            transform: translate(-50%, -50%);
            animation-delay: 0.2s;
        }

        .creative_loader-container div:nth-child(12) {
            top: 77%;
            left: 92%;
            transform: translate(-50%, -50%);
            animation-delay: 0.1s;
        }

        .creative_loader-container div:nth-child(13) {
            top: 50%;
            left: 100%;
            transform: translate(-50%, -50%);
            animation-delay: 0s;
        }

        /* Fading animation */
        @keyframes fade {
            0% {
                opacity: 1;
            }

            50% {
                opacity: 0.2;
            }

            100% {
                opacity: 1;
            }
        }
    </style>
    <script>
        // window.onload = function() {
        //     const creative_loader_overlay = document.querySelector('div.creative_loader-overlay');
        //     if (creative_loader_overlay) {
        //         creative_loader_overlay.style.display = 'none';
        //     }
        // };
    </script>
    <?php echo $__env->make('layouts.head-css', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetUrl('css_v2/style.css')); ?>">
    <!-- resources/views/welcome.blade.php or your main layout file -->
    <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>

</head>
<?php $__env->startSection('body'); ?>
    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

    <body>
        
    <div class="main-wrapper"> <?php echo $__env->yieldSection(); ?>
        <!-- Begin page -->
        <?php echo $__env->make('layouts.topbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <div class="content">
                <?php echo $__env->make('layouts.flash_message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->yieldContent('content'); ?>
            </div>
            <!-- container-fluid -->
        </div>

        <?php echo $__env->make('components.modals.schadual_start', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('components.modals.schadual_end', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <div class="sidebar-overlay" data-reff=""></div>
    <?php echo $__env->make('layouts.vendor-scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->yieldContent('script'); ?>
    <!-- CREATIVE LOADER -->

</body>



</html>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/layouts/master.blade.php ENDPATH**/ ?>