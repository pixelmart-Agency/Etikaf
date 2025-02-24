<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.pages'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'pages.index',
        'parent_title' => __('translation.pages'),
        'title' => isset($page->id)
            ? __('translation.editPage') . ' - ' . getTransValue($page->name)
            : __('translation.addNewPage'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.form.header', [
        'action' => isset($page->id) ? route('pages.update', $page->id) : route('pages.store'),
        'title' => isset($page->id) ? __('translation.editPage') : __('translation.addNewPage'),
        'method' => isset($page->id) ? 'PUT' : 'POST',
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="d-flex gap-3 flex-wrap">
        <fieldset class="flex-grow-1">
            <label for="name" class="block-title fs-14"><?php echo e(__('translation.title')); ?></label>
            <input type="text" id="name" name="name[ar]" placeholder="<?php echo e(__('translation.title')); ?>"
                value="<?php echo e(old('name.ar', getTransValue($page->name))); ?>" class="form-control">
        </fieldset>
    </div>
    <div class="d-flex gap-3 flex-wrap mt-3">
        <fieldset class="flex-grow-1">
            <label for="slug" class="block-title fs-14"><?php echo e(__('translation.slug')); ?></label>
            <input type="text" id="slug" name="slug" placeholder="<?php echo e(__('translation.slug')); ?>"
                <?php echo e(isset($page->slug) ? 'readonly' : ''); ?> value="<?php echo e(old('slug', $page->slug)); ?>" class="form-control">
        </fieldset>
    </div>

    <div id="blocks-container" class="d-flex flex-column gap-3 mt-3">
        <label for="content_title" class="block-title fs-14"><?php echo e(__('translation.content')); ?></label>
        <?php if(empty($decodedContent['block']['title']) && old('content.block.title') == null): ?>
            <!-- Empty block if no previous content -->
            <div class="my-block" data-index="0">
                <fieldset class="flex-grow-1">
                    <div class="my-block-content">
                        <div class="my-block-title">
                            <input type="text" name="content[block][title][]"
                                placeholder="<?php echo e(__('translation.block_title')); ?>" class="form-control"
                                value="<?php echo e(old('content.block.title.0')); ?>">
                        </div>
                        <div class="my-block-contents">
                            <div class="my-block-body mt-2 position-relative">
                                <textarea name="content[block][body][0][]" placeholder="<?php echo e(__('translation.block_content')); ?>" class="form-control"><?php echo e(old('content.block.body.0.0')); ?></textarea>
                                <button type="button" class="delete-btn position-absolute" onclick="deleteContent(this)">
                                    <?php echo e(__('translation.delete_content')); ?></button>
                            </div>
                        </div>
                        <button type="button" class="main-btn fs-14 mt-2" onclick="addContent(this)">+
                            <?php echo e(__('translation.add_content')); ?></button>
                        <button type="button" class="delete-page-content main-btn bg-main-color text-blue mt-2"
                            onclick="deleteBlock(this)"> <?php echo e(__('translation.delete_block')); ?></button>
                    </div>
                </fieldset>
            </div>
        <?php else: ?>
            <?php $__currentLoopData = $decodedContent['block']['title'] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $blockIndex => $title): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="my-block" data-index="<?php echo e($blockIndex); ?>">
                    <fieldset class="flex-grow-1">
                        <div class="my-block-content">
                            <div class="my-block-title">
                                <input type="text" name="content[block][title][]"
                                    placeholder="<?php echo e(__('translation.block_title')); ?>" class="form-control"
                                    value="<?php echo e(old('content.block.title.' . $blockIndex, $title)); ?>">
                            </div>
                            <div class="my-block-contents">
                                <?php $__currentLoopData = $decodedContent['block']['body'][$blockIndex] ?? []; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $contentIndex => $content): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="my-block-body mt-2 position-relative">
                                        <textarea name="content[block][body][<?php echo e($blockIndex); ?>][]" placeholder="<?php echo e(__('translation.block_content')); ?>"
                                            class="form-control"><?php echo e(old('content.block.body.' . $blockIndex . '.' . $contentIndex, $content)); ?></textarea>
                                        <button type="button" class="delete-btn position-absolute"
                                            onclick="deleteContent(this)">
                                            <?php echo e(__('translation.delete_content')); ?></button>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <button type="button" class="main-btn fs-14 mt-2" onclick="addContent(this)">+
                                <?php echo e(__('translation.add_content')); ?></button>
                            <button type="button" class="delete-page-content main-btn bg-main-color text-blue mt-2"
                                onclick="deleteBlock(this)"> <?php echo e(__('translation.delete_block')); ?></button>
                        </div>
                    </fieldset>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>



    <button type="button" class="main-btn bg-gold mt-2" onclick="addBlock()">+
        <?php echo e(__('translation.add_block')); ?></button>
    </div>
    <?php echo $__env->make('components.form.footer', [
        'btn_text' => __('translation.Submit'),
        'confirm_title' => __('translation.confirm_title'),
        'backRoute' => route('pages.index'),
        // 'confirm_message' => __('translation.confirm_message'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/pages/edit.blade.php ENDPATH**/ ?>