<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.retreat_service_requests'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
                    <div class="text-cont">
                        <h2 class="block-title"> <?php echo e(__('translation.retreat_service_requests')); ?> </h2>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <fieldset class="position-relative">
                            <legend class="sr-only">Search input</legend>
                            <input type="search" class="form-control" id="inputSearchTable" autocomplete="off"
                                placeholder="<?php echo e(__('translation.filter_with_national_passport')); ?>"
                                aria-label="Search input" name="inputSearchTable">
                            <i class="icon-search-i position-absolute top-50 translate-middle-y ms-3"></i>
                        </fieldset>
                        <div class="form-group form-focus select-focus mb-0">
                            <select class="select floating" id="selectFilterTable">
                                <option value=""><?php echo e(__('translation.request_status')); ?></option>
                                <?php $__currentLoopData = App\Enums\ProgressStatusEnum::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e(__('translation.' . $status->value)); ?>">
                                        <?php echo e(__('translation.' . $status->value)); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </select>
                        </div>
                        <button type="submit" class="btn-submit" id="submitFilterTable"></button>
                        <button type="button" class="custom-popovers" id="btnExportTable" data-content="تصدير"></button>
                        
                    </div>
                </div>
                <input type="hidden" id="export-route" value="<?php echo e(route('retreat-service-requests.export')); ?>">
                <input type="hidden" id="file-name" value="<?php echo e(__('translation.retreat_service_requests_report')); ?>">

                <?php if(retreat_season_is_open()): ?>
                    <?php if($requests->count() == 0): ?>
                        <div class="card-body-table">
                            <div class="card-body-default d-flex flex-column align-items-center mt-5">
                                <div class="img-cont mb-30">
                                    <img src="<?php echo e(assetUrl('img_v2/default-img-order.png')); ?>" alt="retreat-img">
                                </div>
                                <h2><?php echo e(__('translation.no_requests')); ?></h2>

                            </div>
                        </div>
                    <?php else: ?>
                        <div class="card-body-table">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped custom-table mb-0 datatable">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        
                                                        #
                                                    </th>
                                                    <th><?php echo e(__('translation.national_id_passport')); ?></th>
                                                    <th><?php echo e(__('translation.name_nationality')); ?></th>
                                                    <th><?php echo e(__('translation.retreat_service_type')); ?></th>
                                                    <th><?php echo e(__('translation.mosque')); ?></th>
                                                    <th><?php echo e(__('translation.mosque_location')); ?></th>
                                                    <th><?php echo e(__('translation.retreat_request_date')); ?></th>
                                                    <th><?php echo e(__('translation.status')); ?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            
                                                            <?php echo e($loop->iteration); ?>

                                                        </td>
                                                        <td><?php echo e($request->retreatRequest?->user?->document_number); ?></td>
                                                        <td>
                                                            <h2><a
                                                                    href="<?php echo e(route('users.edit', $request->retreatRequest?->user?->id)); ?>">
                                                                    <?php echo e($request->retreatRequest?->name); ?>

                                                                    <span><?php echo e(getTransValue($request->retreatRequest?->user?->country?->name)); ?></span>
                                                            </h2>
                                                        </td>
                                                        <td> <?php echo e(getTransValue($request->retreatService?->name)); ?>

                                                        <td> <?php echo e(getTransValue($request->retreatRequest?->retreatMosque?->name)); ?>

                                                        </td>
                                                        <td> <?php echo e(getTransValue($request->retreatRequest?->retreatMosqueLocation?->name)); ?>

                                                        <td><?php echo e($request->retreatRequest?->start_time_arabic); ?>

                                                        </td>
                                                        <td class="<?php echo e($request->status_class); ?>">
                                                            <span><?php echo e(__('translation.' . $request->status)); ?></span>
                                                        <td class="show-td"><a
                                                                href="<?php echo e(route('retreat-service-requests.show', $request->id)); ?>"><i
                                                                    aria-hidden="true"></i>
                                                                <?php echo e(__('translation.view')); ?></a></td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="card-body-table">
                        <div class="card-body-default d-flex flex-column align-items-center mt-5">
                            <div class="img-cont mb-30">
                                <img src="<?php echo e(assetUrl('img_v2/default-img-order.png')); ?>" alt="retreat-img">
                            </div>
                            <h2><?php echo e(__('translation.no_requests')); ?></h2>

                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
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
            $('.rejectAll-req').on('click', function(e) {
                e.preventDefault();
                let selectedIds = $(".select-box:checked").map(function() {
                    return this.value;
                }).get();

                $.ajax({
                    url: '<?php echo e(route('retreat-service-requests.rejects')); ?>',
                    method: 'POST',
                    data: {
                        selectedIds: selectedIds,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(data) {
                        console.log(data);
                        // window.location.reload();

                    }
                });
            });
            $('.acceptAll-req').on('click', function(e) {
                e.preventDefault();
                let selectedIds = $(".select-box:checked").map(function() {
                    return this.value;
                }).get();

                $.ajax({
                    url: '<?php echo e(route('retreat-service-requests.accepts')); ?>',
                    method: 'POST',
                    data: {
                        selectedIds: selectedIds,
                        _token: '<?php echo e(csrf_token()); ?>'
                    },
                    success: function(data) {
                        // window.location.reload();
                        console.log(data);
                    }
                });
            });
        });
        // Here, send `selectedIds` to the backend via AJAX or form submission
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/retreat-service-requests/index.blade.php ENDPATH**/ ?>