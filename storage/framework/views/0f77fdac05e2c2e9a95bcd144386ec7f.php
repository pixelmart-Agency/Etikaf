    <div class="row">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-4">
                    <li class="breadcrumb-item home"><a href="<?php echo e(route('root')); ?>"></a></li>
                    <?php if(!empty($parent_title)): ?>
                        <li class="breadcrumb-item"><a href="<?php echo e(route($parent_route)); ?>"><?php echo e($parent_title); ?></a></li>
                    <?php endif; ?>
                    <?php if(!empty($title)): ?>
                        <li class="breadcrumb-item active" aria-current="page"><?php echo e($title); ?></li>
                    <?php endif; ?>
                </ol>
            </nav>
        </div>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/breadcrumb.blade.php ENDPATH**/ ?>