<div>
    <!-- عرض رسائل الخطأ العامة -->
    <?php if($errors->any()): ?>
        <div class="alert alert-danger alert-dismissible error fade show" role="alert">
            <i aria-hidden="true"></i>
            <div class="text-cont d-flex flex-column gap-2">
                <strong><?php echo e(__('translation.Error')); ?></strong>
                <ul class="list-unstyled">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- عرض رسائل الخطأ الخاصة بـ Session -->
    <?php if(Session::has('error')): ?>
        <div class="alert alert-danger alert-dismissible error fade show" role="alert">
            <i aria-hidden="false"></i>
            <div class="text-cont d-flex flex-column gap-2">
                <strong><?php echo e(Session::get('title')); ?></strong>
                <span><?php echo e(Session::get('error')); ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
            session()->forget('error');
        ?>
    <?php endif; ?>

    <!-- عرض رسائل النجاح الخاصة بـ Session -->
    <?php if(Session::has('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i aria-hidden="true"></i>
            <div class="text-cont d-flex flex-column gap-2">
                <strong><?php echo e(Session::get('title')); ?></strong>
                <span><?php echo e(Session::get('success')); ?></span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php
            session()->forget('success');
        ?>
    <?php endif; ?>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Select all buttons with the class 'btn-close'
        const closeButtons = document.querySelectorAll('.btn-close');

        closeButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                // Find the closest parent with the class 'alert'
                const alertBox = this.closest('.alert');

                // Apply a fade-out effect using vanilla JS
                alertBox.style.transition = 'opacity 0.5s ease-out'; // Set transition effect
                alertBox.style.opacity = '0'; // Fade out by setting opacity to 0

                // After the fade-out animation, remove the element from the DOM
                setTimeout(function() {
                    alertBox.style.display = 'none';
                },
                500); // Wait for the duration of the fade-out (500ms) before hiding the element
            });
        });
    });
</script>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/layouts/flash_message.blade.php ENDPATH**/ ?>