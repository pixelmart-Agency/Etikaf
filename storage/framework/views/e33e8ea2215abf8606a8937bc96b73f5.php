<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.retreat_requests'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <input type="hidden" id="export-route" value="<?php echo e(route('retreat-requests.export')); ?>">
    <input type="hidden" id="file-name" value="<?php echo e(__('translation.retreat_requests_report')); ?>">
    <?php echo $__env->make('components.request_components.states', [
        'newRequests' => $newRequests,
        'approvedRequests' => $approvedRequests,
        'completedRequests' => $completedRequests,
        'canceledRequests' => $canceledRequests,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.request_components.request_status', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.request_components.request_data', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        let arrayDisabled = 0;
        let rejectAll = $(".rejectAll-req");
        let acceptAll = $(".acceptAll-req");
        // Select All Checkbox
        function btnStatusDisabled(boolean) {
            rejectAll.prop("disabled", boolean);
            acceptAll.prop("disabled", boolean);
        }
        $("input[type='checkbox']#selectAll").on("click", function() {
            $("input[type='checkbox'].select-box").prop("checked", this.checked);

            if ($(this).prop("checked")) {
                btnStatusDisabled(false)
                arrayDisabled = $(".select-box:checked").length;
            } else {
                btnStatusDisabled(true)
                arrayDisabled = 0;
            }

        });

        // Uncheck "Select All" if any checkbox is unchecked
        $("input[type='checkbox'].select-box").on("click", function() {
            $("input[type='checkbox']#selectAll").prop("checked", $(".select-box:checked").length === $(
                "input[type='checkbox'].select-box").length);
            $(this).prop("checked") ? arrayDisabled += 1 : arrayDisabled -= 1;
            arrayDisabled > 0 ? btnStatusDisabled(false) : btnStatusDisabled(true);
        });

        // Request Rejection Form with Selected IDs
        rejectAll.on("click", function(e) {
            e.preventDefault();
            let selectedIds = $(".select-box:checked").map(function() {
                return this.value;
            }).get();

            console.log("Rejection IDs:", selectedIds);
            // Here, send `selectedIds` to the backend via AJAX or form submission
        });

        // Request Accept Form with Selected IDs
        acceptAll.on("click", function(e) {
            e.preventDefault();
            let selectedIds = $(".select-box:checked").map(function() {
                return this.value;
            }).get();

            console.log("Accept IDs:", selectedIds);
            // Here, send `selectedIds` to the backend via AJAX or form submission
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.rejectAll-btn').on('click', function(e) {
                e.preventDefault();
                let selectedIds = $(".select-box:checked").map(function() {
                    return this.value;
                }).get();

                $.ajax({
                    url: '<?php echo e(route('retreat-requests.reject')); ?>',
                    method: 'POST',
                    data: {
                        selectedIds: selectedIds,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(data) {
                        console.log(data);
                        window.location.reload();

                    },
                    error: function(err) {
                        console.error('Error rejecting request:', err);
                        alert('Error rejecting request');
                    }
                });
            });
            $('.acceptAll-btn').on('click', function(e) {
                e.preventDefault();
                let selectedIds = $(".select-box:checked").map(function() {
                    return this.value;
                }).get();

                $.ajax({
                    url: '<?php echo e(route('retreat-requests.accept')); ?>',
                    method: 'POST',
                    data: {
                        selectedIds: selectedIds,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(data) {
                        window.location.reload();
                        console.log(data);
                    }
                });
            });
        });
        // Here, send `selectedIds` to the backend via AJAX or form submission
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/retreat-requests/index.blade.php ENDPATH**/ ?>