<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <?php $__currentLoopData = getSidebarMenuItems(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $routes = array_map(function ($item) {
                            return $item['route'];
                        }, $menu['items']);
                    ?>
                    <?php if(auth()->user()->hasPermissionsTo($routes)): ?>
                        <li class="menu-title"><?php echo e($menu['title']); ?></li>
                        <?php $__currentLoopData = $menu['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(auth()->user()->hasPermissionTo($item['route'])): ?>
                                <li class="<?php echo e($item['is_active'] ? 'active' : ''); ?> <?php echo e($item['class']); ?>">
                                    <a href="<?php echo e(!empty($item['route']) ? route($item['route']) : ''); ?>"
                                        <?php if($item['is_active']): ?> aria-current="page" <?php endif; ?>>
                                        <span><?php echo e($item['label']); ?></span>
                                    </a>
                                </li>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/layouts/sidebar.blade.php ENDPATH**/ ?>