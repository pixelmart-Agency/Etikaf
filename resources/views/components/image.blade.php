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
        <label for="{{ $name }}" class="form-label">@lang('translation.' . $name)</label>

        <div class="input-group">
            <input type="file" class="form-control" id="{{ $name }}" name="{{ $name }}"
                onchange="previewImage(event)" accept="image/*" style="display: none;" aria-label="@lang('translation.Choose file')">
            <label class="input-group-text" for="{{ $name }}" id="file-label">@lang('translation.Choose file')</label>
        </div>

        @if ($single && ($single->image_url || $single->avatar_url))
            <div class="text-start mt-2">
                <img id="image-preview" src="{{ imageUrl($single->image_url ?? $single->avatar_url) }}"
                    alt="Preview Image" class="img-fluid rounded border shadow-sm">
            </div>
        @else
            <div class="text-start mt-2" id="preview-container" style="display: none;">
                <img id="image-preview" width="100%" alt="Preview Image" class="img-fluid rounded border shadow-sm" />
            </div>
        @endif

        <p>{{ __('translation.Recommended Size') }}: {{ $recommended_size ?? '200x200' }}</p>
    </fieldset>
</div>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        var file = event.target.files[0];
        var fileName = file?.name || '@lang('translation.No file chosen')';

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
</script>
