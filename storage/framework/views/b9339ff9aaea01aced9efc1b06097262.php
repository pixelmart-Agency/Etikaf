<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.surveys'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'surveys.index',
        'parent_title' => __('translation.surveys'),
        'title' => isset($survey->id)
            ? __('translation.editSurvey') . ' - ' . getTransValue($survey->title)
            : __('translation.addNewSurvey'),
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-12">
        <div class="row row-main-order">
            <form action="<?php echo e(route('surveys.store')); ?>" class="validate_form" method="POST">
                <?php echo csrf_field(); ?>
                <div class="card-bg px-4">
                    <div class="card-create-survey">
                        <h3 class="block-title border-bottom mb-4 pb-4"><?php echo e(__('translation.survey_settings')); ?></h3>
                        <div class="d-flex gap-3 flex-wrap">
                            <fieldset class="flex-grow-1">
                                <label for="title" class="block-title fs-14"><?php echo e(__('translation.survey_title')); ?></label>
                                <input type="text" id="title" name="title[ar]"
                                    value="<?php echo e(old('title.ar', getTransValue($survey->title))); ?>"
                                    class="form-control validate[required]"
                                    placeholder="<?php echo e(__('translation.survey_title')); ?>" class="form-control">
                            </fieldset>
                            <fieldset class="flex-grow-1">
                                <label for="start_date" class="block-title fs-14">
                                    <?php echo e(__('translation.survey_start_date')); ?></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker validate[required]" type="text"
                                        id="start_date" name="start_date"
                                        placeholder="<?php echo e(__('translation.select_survey_start_date')); ?>" format="YYYY-MM-DD"
                                        value="<?php echo e(old('start_date', $survey->start_date)); ?>">
                                </div>
                            </fieldset>
                            <fieldset class="flex-grow-1">
                                <label for="end_date" class="block-title fs-14">
                                    <?php echo e(__('translation.survey_end_date')); ?></label>
                                <div class="cal-icon">
                                    <input class="form-control datetimepicker validate[required]" type="text"
                                        id="end_date" name="end_date"
                                        placeholder="<?php echo e(__('translation.select_survey_end_date')); ?>" format="YYYY-MM-DD"
                                        value="<?php echo e(old('end_date', $survey->end_date)); ?>">
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
                <div class="card-bg px-4">
                    <div class="card-create-survey">
                        <h3 class="block-title border-bottom mb-4 pb-4"><?php echo e(__('translation.survey_questions')); ?></h3>
                        <?php if(old('questions')): ?>
                            <?php $__currentLoopData = old('questions'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php echo $__env->make('components.questions', ['question' => $question], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <?php echo $__env->make('components.questions', ['question' => null], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                        <button type="button" class="main-btn p-0 bg-transparent mt-4 text-gold d-flex align-items-center"
                            id="btnAddNewQue"> <?php echo e(__('translation.add_question')); ?></button>
                    </div>
                </div>
                <div class="card-bg px-4 py-3 mt-4">
                    <div class="text-cont">
                        <div class="btn-cont justify-content-between gap-3 flex-wrap">
                            <a href="<?php echo e(route('surveys.index')); ?>" class="main-btn bg-main-color text-blue">
                                <?php echo e(__('translation.Cancel')); ?></a>

                            <button type="button" class="main-btn bg-gold" data-toggle="modal"
                                data-target="#request-createSurvey"> <?php echo e(__('translation.send_survey')); ?></button>
                        </div>
                    </div>
                    <div id="request-createSurvey" class="modal fade" role="dialog" aria-modal="true"
                        style="display: none;">
                        <div class="modal-dialog">
                            <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
                                <div class="modal-header border-0 flex-column align-items-center py-0 mb-40">
                                    <div class="img-cont mb-4">
                                        <img src="assets/img_v2/img-request-denied.png" class="w-100 mw-100" alt="">
                                    </div>
                                    <h2 class="block-title mb-2 fs-24"><?php echo e(__('translation.survey_confirm_title')); ?></h2>
                                    <div class="block-text fs-18">
                                        <p><?php echo e(__('translation.survey_confirm_message')); ?></p>
                                    </div>
                                </div>
                                <div class="modal-body py-0">
                                    <div class="btn-cont gap-2 justify-content-center">
                                        <button type="button" class="main-btn text-blue bg-main-color close"
                                            data-dismiss="modal"> <?php echo e(__('translation.Cancel')); ?></button>
                                        <button type="submit" class="main-btn bg-gold" id="btn-remove-que">
                                            <?php echo e(__('translation.send_survey')); ?></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div id="remove-que-modal" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
                <div class="modal-header border-0 flex-column align-items-center py-0 mb-4">
                    <div class="img-cont mb-4">
                        <img src="assets/img_v2/img-request-denied.png" class="w-100 mw-100" alt="">
                    </div>
                    <h2 class="block-title mb-2 fs-24"><?php echo e(__('translation.remove_question')); ?></h2>
                    <div class="block-text fs-18">
                        <p><?php echo e(__('translation.confirm_question')); ?></p>
                    </div>
                </div>
                <div class="modal-body py-0">
                    <div class="btn-cont gap-2 justify-content-center">
                        <button type="button" class="main-btn text-blue bg-main-color close"
                            data-dismiss="modal"><?php echo e(__('translation.Cancel')); ?></button>
                        <button type="button" class="main-btn bg-gold"
                            id="btn-remove-que"><?php echo e(__('translation.delete_question')); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/surveys/edit.blade.php ENDPATH**/ ?>