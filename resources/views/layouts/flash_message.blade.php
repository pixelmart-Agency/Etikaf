<div>
    <!-- عرض رسائل الخطأ العامة -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible error fade show" role="alert">
            <i aria-hidden="true"></i>
            <div class="text-cont d-flex flex-column gap-2">
                <strong>{{ __('translation.Error') }}</strong>
                <ul class="list-unstyled">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- عرض رسائل الخطأ الخاصة بـ Session -->
    @if (Session::has('error'))
        <div class="alert alert-danger alert-dismissible error fade show" role="alert">
            <i aria-hidden="false"></i>
            <div class="text-cont d-flex flex-column gap-2">
                <strong>{{ Session::get('title') }}</strong>
                <span>{{ Session::get('error') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @php
            session()->forget('error');
        @endphp
    @endif

    <!-- عرض رسائل النجاح الخاصة بـ Session -->
    @if (Session::has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i aria-hidden="true"></i>
            <div class="text-cont d-flex flex-column gap-2">
                <strong>{{ Session::get('title') }}</strong>
                <span>{{ Session::get('success') }}</span>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @php
            session()->forget('success');
        @endphp
    @endif
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
