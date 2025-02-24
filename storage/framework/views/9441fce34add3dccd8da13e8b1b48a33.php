<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.retreat_requests'); ?> - #<?php echo e($request->id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'retreat_requests.index',
        'parent_title' => __('translation.retreat_requests'),
        'title' => __('translation.retreat_requests') . ' - ' . $request->id,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-12">
        <div class="row">
            <div class="col-12 col-lg-7 col-xl-8">
                <div class="card-bg px-4">
                    <div class="text-head d-flex flex-wrap justify-content-between gap-3">
                        <div class="text-cont-right d-flex gap-3">
                            <div class="img-cont img-placeholder">
                                <?php if(isset($request->user) && $request->user->avatar): ?>
                                    <img src="<?php echo e($request->user->avatar); ?>" class="w-100 mw-100 rounded-circle" alt="">
                                <?php else: ?>
                                    <img src="<?php echo e(default_avatar()); ?>" class="w-100 mw-100 rounded-circle" alt="">
                                <?php endif; ?>
                            </div>
                            <div>
                                <h3 class="block-subtitle fs-14 text-light-blue-92">
                                    <?php echo e(__('translation.national_id_passport')); ?></h3>
                                <h2 class="block-title fs-20 mb-0 text-break"><?php echo e($request->document_number); ?></h2>
                            </div>
                        </div>
                        <div class="text-cont-left">
                            <span class="<?php echo e($request->status_class); ?>">
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
                                        <p>#<?php echo e($request->id); ?></p>
                                    </td>
                                    <td>
                                        <span><?php echo e(__('translation.name')); ?></span>
                                        <p><?php echo e($request->name ?? $request->user->name); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><?php echo e(__('translation.nationality')); ?></span>
                                        <p><?php echo e(getTransValue($request->user?->country?->name)); ?></p>
                                    </td>
                                    <td>
                                        <span> <?php echo e(__('translation.request_date')); ?></span>
                                        <p><?php echo e($request->start_time_arabic); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><?php echo e(__('translation.request_mosque')); ?></span>
                                        <p><?php echo e(getTransValue($request->retreatMosque?->name)); ?></p>
                                    </td>
                                    <td>
                                        <span> <?php echo e(__('translation.request_mosque_location')); ?></span>
                                        <p><?php echo e(getTransValue($request->retreatMosqueLocation?->name)); ?></p>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span><?php echo e(__('translation.request_age')); ?></span>
                                        <p><?php echo e($request->user?->age); ?></p>
                                    </td>
                                    <td>
                                        <span> <?php echo e(__('translation.user_phone')); ?></span>
                                        <p><?php echo e($request->user?->mobile); ?></p>
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <span><?php echo e(__('translation.birthday')); ?></span>
                                        <p><?php echo e($request->user?->birthday); ?></p>
                                    </td>
                                    <?php if($request->user?->app_user_type): ?>
                                        <td>
                                            <span> <?php echo e(__('translation.app_user_type')); ?></span>
                                            <p><?php echo e(__('translation.' . $request->user?->app_user_type)); ?></p>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <td>
                                        <span><?php echo e(__('translation.status')); ?></span>
                                        <p><?php echo e(__('translation.' . $request->status)); ?></p>
                                    </td>
                                    <?php if($request->status == App\Enums\ProgressStatusEnum::REJECTED->value): ?>
                                        <td>
                                            <span><?php echo e(__('translation.reject_reason')); ?></span>
                                            <p><?php echo e(isset($request->rejectReasonObject) ? getTransValue($request->rejectReasonObject?->title) : __('translation.no_reason_specified')); ?>

                                            </p>
                                        </td>
                                    <?php endif; ?>
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
                                'location' => $request->retreatMosqueLocation?->location,
                                'height' => '100%',
                            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
                <div class="card-bg p-4 flex-grow-1">
                    <h4 class="block-subtitle mb-30 fw-medium fs-16 text-blue"> <?php echo e(__('translation.place_details')); ?>

                    </h4>
                    <div class="d-flex flex-wrap justify-content-between">
                        <div>
                            <span class="text-light-blue-92 fs-14"><?php echo e(__('translation.place_location')); ?></span>
                            <h4 class="block-subtitle mb-0 mt-3 fw-medium fs-16 text-blue">
                                <?php echo e(getTransValue($request->retreatMosqueLocation?->name)); ?> </h4>
                        </div>
                        <?php echo $request->retreatMosqueLocation?->request_status; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if($request->status == App\Enums\ProgressStatusEnum::PENDING->value): ?>
        <div class="col-12">
            <div class="row mt-50">
                <div class="col-12">
                    <div class="text-cont card-bg px-4 py-3">
                        <div class="btn-cont justify-content-end gap-3">
                            <a href="#" class="main-btn text-red bg-light-red" data-toggle="modal"
                                data-target="#request-denied"><?php echo e(__('translation.reject')); ?></a>

                            <a href="#" class="main-btn" data-toggle="modal" data-target="#request-accept">
                                <?php echo e(__('translation.accept_request')); ?></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php echo $__env->make('components.modals.confirm_modal', [
        'route' => route('retreat_requests.accept', $request->id),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('components.modals.reject_modal', [
        'rejectionReasons' => $rejectionReasons,
        'route' => route('retreat_requests.reject', $request->id),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/retreat-requests/show.blade.php ENDPATH**/ ?>