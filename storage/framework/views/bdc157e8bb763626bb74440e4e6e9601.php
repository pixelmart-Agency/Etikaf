<style>
    #image-preview {
        max-width: 200px;
        /* Set the maximum width */
        max-height: 200px;
        /* Set the maximum height */
        object-fit: contain;
        /* Ensure the image fits nicely */
    }
</style>

<div class="d-flex gap-3 flex-wrap mt-3">
    <fieldset class="flex-grow-1">
        <label for="<?php echo e($name); ?>" class="form-label"><?php echo app('translator')->get('translation.' . $name); ?></label>

        <div class="input-group">
            <input type="file" class="form-control" id="<?php echo e($name); ?>" name="<?php echo e($name); ?>"
                onchange="previewImage(event)" accept="image/*" style="display: none;" aria-label="<?php echo app('translator')->get('translation.Choose file'); ?>">
            <label class="input-group-text" for="<?php echo e($name); ?>" id="file-label"><?php echo app('translator')->get('translation.Choose file'); ?></label>
        </div>

        <?php if(getSettingMedia($name)): ?>
            <div class="text-start mt-2">
                <img id="image-preview" src="<?php echo e(getSettingMedia($name)); ?>" alt="Preview Image"
                    class="img-fluid rounded border shadow-sm">
            </div>
        <?php else: ?>
            <div class="text-start mt-2" id="preview-container" style="display: none;">
                <img id="image-preview" width="100%" alt="Preview Image" class="img-fluid rounded border shadow-sm" />
            </div>
        <?php endif; ?>

        <p><?php echo e(__('translation.Recommended Size')); ?>: <?php echo e($recommended_size ?? '200x200'); ?></p>
    </fieldset>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        function previewImage(event) {
            var reader = new FileReader();
            var file = event.target.files[0];
            var fileName = file?.name || '<?php echo app('translator')->get('translation.No file chosen'); ?>';

            document.getElementById('file-label').innerText = fileName;

            reader.onload = function() {
                var output = document.getElementById('image-preview');
                output.src = reader.result;

                // Ensure the preview container is visible
                document.getElementById('preview-container').style.display = 'block';
            };

            if (file) {
                reader.readAsDataURL(file);
            }
        }

        // اجعل الدالة متاحة في النطاق العام
        window.previewImage = previewImage;
    });
</script>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/setting_image.blade.php ENDPATH**/ ?>