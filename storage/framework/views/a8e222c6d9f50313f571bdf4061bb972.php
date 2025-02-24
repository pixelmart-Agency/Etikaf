<div class="col-12">
    <div class="row row-main-order">
        <form action="<?php echo e($action); ?>" method="POST" enctype="multipart/form-data" class="validate_form">
            <?php echo csrf_field(); ?>
            <?php if($method == 'PUT'): ?>
                <?php echo method_field('PUT'); ?>
            <?php endif; ?>
            <div class="card-bg px-4">
                <div class="card-create-survey">
                    <h3 class="block-title border-bottom mb-4 pb-4"> <?php echo e($title); ?></h3>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/form/header.blade.php ENDPATH**/ ?>