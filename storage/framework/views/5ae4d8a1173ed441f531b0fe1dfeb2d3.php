<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.retreat_service_requests'); ?> - #<?php echo e($request->id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'retreat-service-requests.index',
        'parent_title' => __('translation.retreat_service_requests'),
        'title' => __('translation.retreat_service_requests') . ' - ' . $request->id,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-7 col-xl-8">
                <div class="card-bg px-4">
                    <div class="text-head d-flex flex-wrap justify-content-between gap-3">
                        <div class="text-cont-right d-flex gap-3">
                            <div class="img-cont img-placeholder">
                                <?php if(isset($request->retreatRequest?->user?->avatar)): ?>
                                    <img src="<?php echo e($request->retreatRequest?->user?->avatar); ?>"
                                        class="w-100 mw-100 rounded-circle" alt="">
                                <?php else: ?>
                                    <img src="<?php echo e(default_avatar()); ?>" class="w-100 mw-100 rounded-circle" alt="">
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="block-subtitle fs-14 text-light-blue-92">
                                    <?php echo e(__('translation.national_id_passport')); ?></h3>
                                <h2 class="block-title fs-20 mb-0 text-break">
                                    <?php echo e($request->retreatRequest?->document_number); ?></h2>
                            </div>
                        </div>
                        <div class="text-cont-left">
                            <span class="<?php echo e($request->retreatRequest?->status_class); ?>">
                                <span><?php echo e(__('translation.' . $request->status)); ?></span>
                            </span>
                        </div>
                    </div>
                    <div class="text-body">
                        <table class="basic-table">
                            <tbody>
                                <tr>
                                    <td>
                                        <span> <?php echo e(__('translation.request_number')); ?></span>
                                        <p>
                                            #<?php echo e($request->id); ?>

                                        </p>
                                    </td>
                                    <td>
                                        <span><?php echo e(__('translation.name')); ?></span>
                                        <p><?php echo e($request->retreatRequest?->user?->name); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><?php echo e(__('translation.retreat_service_type')); ?></span>
                                        <p><?php echo e(getTransValue($request->retreatService?->name)); ?></p>
                                    </td>
                                    <td>
                                        <span> <?php echo e(__('translation.user_phone')); ?></span>
                                        <p><?php echo e($request->retreatRequest?->user?->mobile); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><?php echo e(__('translation.nationality')); ?></span>
                                        <p><?php echo e(getTransValue($request->retreatRequest?->user?->country?->name)); ?></p>
                                    </td>
                                    <td>
                                        <span> <?php echo e(__('translation.retreat_date')); ?></span>
                                        <p><?php echo e($request->retreatRequest?->start_time_arabic); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><?php echo e(__('translation.mosque')); ?></span>
                                        <p><?php echo e(getTransValue($request->retreatRequest?->retreatMosque?->name)); ?></p>
                                    </td>
                                    <td>
                                        <span> <?php echo e(__('translation.mosque_location')); ?></span>
                                        <p><?php echo e($request->retreatRequest?->retreatMosqueLocation?->location); ?></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-5 col-xl-4 d-flex flex-column">
                <div class="card-bg px-4 mb-4 flex-grow-1">
                    <h3 class="block-subtitle mb-3 text-blue fw-medium"><?php echo e(__('translation.map')); ?></h3>
                    <div class="card-map">
                        <div class="img-cont rounded-3">
                            <?php echo $__env->make('components.inputs.map', [
                                'location' => $request->retreatRequest?->retreatMosqueLocation?->location,
                                'height' => '100%',
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-auto">
            <?php if(
                $request->retreatRequest?->status == App\Enums\ProgressStatusEnum::APPROVED->value &&
                    $request->status != App\Enums\ProgressStatusEnum::COMPLETED->value): ?>
                <div class="col-12">
                    <div class="text-cont card-bg px-4 py-3">
                        <div class="btn-cont justify-content-end gap-3">
                            <button type="button" class="main-btn border py-10 text-blue bg-transparent"
                                data-toggle="modal"
                                data-target="#reassign-submission"><?php echo e(__('translation.reassign')); ?></button>

                            <a href="#" data-toggle="modal" data-target="#confirm-request-service" class="main-btn">تم
                                تنفيذ الطلب</a>
                        </div>
                    </div>
                </div>
        </div>
        <?php echo $__env->make('components.modals.reassign_employee', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('components.modals.common_modal', [
            'id' => 'confirm-request-service',
            'confirm_title' => __('translation.complete_request'),
            'confirm_message' => __('translation.confirm_alert'),
            'route' => route('retreat-service-requests.accept', $request->id),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    <?php $__env->stopSection(); ?>
    <?php $__env->startSection('script'); ?>
    <?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/retreat-service-requests/show.blade.php ENDPATH**/ ?>