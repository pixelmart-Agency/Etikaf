<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.survey_details'); ?> - #<?php echo e($survey->id); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('components.breadcrumb', [
        'parent_route' => 'surveys.index',
        'parent_title' => __('translation.surveys'),
        'title' => __('translation.survey_details') . ' - ' . $survey->id,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="col-12">
        <div class="row row-main-order tab-container">
            <div class="card-bg px-4">
                <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
                    <div class="text-cont">
                        <h2 class="block-title">
                            <?php echo e(__('translation.survey_title')); ?> : <?php echo e(getTransValue($survey->title)); ?>

                        </h2>
                        <span class="d-block fs-16 text-light-blue">#<?php echo e($survey->id); ?></span>
                    </div>
                    <div class="d-flex flex-wrap align-items-center gap-2">

                        <!-- tabs -->
                        <div class="nav nav-tabs" role="tablist">
                            <button class="nav-item tab active" role="tab" aria-selected="true" id="tab-1"
                                aria-controls="card-body-table-panel" tabindex="0">
                                <span class="nav-link"><?php echo e(__('translation.answers')); ?></span>
                            </button>
                            <button class="nav-item tab" role="tab" aria-selected="false" id="tab-2"
                                aria-controls="survey-details-panel" tabindex="-1">
                                <span class="nav-link"><?php echo e(__('translation.statistics')); ?></span>
                            </button>
                        </div>

                    </div>
                </div>
                <!-- tab-panels -->
                <div class="tab-panels">
                    <div class="card-body-table panel active" id="card-body-table-panel" role="tabpanel"
                        aria-labelledby="tab-1">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-striped custom-table mb-0 datatable">
                                        <thead>
                                            <tr>
                                                <th><?php echo e(__('translation.survey_taker')); ?></th>
                                                <th><?php echo e(__('translation.national_id')); ?></th>
                                                <th><?php echo e(__('translation.survey_answe_date')); ?></th>
                                                <th><?php echo e(__('translation.number_of_answers')); ?></th>
                                                <th></th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td>
                                                        <img width="32" height="32" src="<?php echo e($user->avatar_url); ?>"
                                                            class="rounded-circle me-2" alt="<?php echo e($user->name); ?>">
                                                        <?php echo e($user->name); ?>

                                                    </td>
                                                    <td><?php echo e($user->document_number); ?></td>
                                                    <td><?php echo e(convertToHijri($user->survey_answer_date)); ?></td>
                                                    <td><?php echo e($survey->retreatRateQuestions->count()); ?>/<?php echo e($user->retreat_rate_questions_count); ?>

                                                    </td>
                                                    <td class="show-td">
                                                        <a
                                                            href="<?php echo e(route('retreat-rate-questions.show', [$survey->id, $user->id])); ?>">

                                                            <i aria-hidden="true"></i>
                                                            <?php echo e(__('translation.view')); ?></a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body-table panel" id="survey-details-panel" role="tabpanel" aria-labelledby="tab-2">
                        <div class="card-gray-bg">
                            <h3 class="block-title fs-16 mb-4"><?php echo e(__('translation.total_stats')); ?></h3>
                            <div class="card-bg bar-title d-flex rounded-3 mb-0">
                                <div class="flex-grow-1">
                                    <h5 class="block-title fs-14"><?php echo e(__('translation.sent_count')); ?></h5>
                                    <p class="fs-14 text-light-blue m-0"><?php echo e($usersCount); ?>

                                        <?php echo e(__('translation.persons')); ?></p>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="block-title fs-14"><?php echo e(__('translation.received_count')); ?></h5>
                                    <p class="fs-14 text-light-blue m-0"><?php echo e($surveysCount); ?>

                                        <?php echo e(__('translation.persons')); ?></p>
                                </div>
                                <div class="flex-grow-1">
                                    <h5 class="block-title fs-14"><?php echo e(__('translation.received_percent')); ?></h5>
                                    <p class="fs-14 text-light-blue m-0">%<?php echo e($surveysPercent); ?></p>
                                </div>
                            </div>
                            <div class="d-flex flex-wrap align-items-center">

                                <div class="bar-chart" aria-label="مخطط شريطي يوضح مستويات التقدم">
                                    <?php $__currentLoopData = $surveyStats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="item">
                                            <span class="title" id="<?php echo e($stat->status_id); ?>"><?php echo e($stat->name); ?></span>
                                            <div class="bar" role="progressbar" aria-labelledby="<?php echo e($stat->status_id); ?>"
                                                aria-valuenow="<?php echo e($stat->percent); ?>" aria-valuemin="0" aria-valuemax="100">
                                                <div class="item-progress <?php echo e($stat->class); ?>"
                                                    style="width: <?php echo e($stat->percent); ?>%;">
                                                </div>
                                            </div>
                                            <span class="percent"><?php echo e($stat->percent); ?>%</span>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </div>

                            </div>
                        </div>
                        <div class="card-gray-bg">
                            <h3 class="block-title fs-16 mb-4"><?php echo e(__('translation.answers_stats')); ?></h3>
                            <div class="row row-bar-lg">
                                <?php $__currentLoopData = $surveyRateQuestions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $surveyRateQuestion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-12 col-md-6">
                                        <div class="card-bg mb-0 rounded-16">
                                            <h3 class="block-title fs-16">
                                                <?php echo e($surveyRateQuestion->question); ?>

                                            </h3>
                                            <p class="fs-14 text-light-blue"><?php echo e($surveyRateQuestion->people_count); ?>

                                                <?php echo e(__('translation.persons')); ?>

                                            </p>
                                            <div class="bar-chart flex-column" aria-label="مخطط شريطي يوضح مستويات التقدم">
                                                <?php $__currentLoopData = $surveyRateQuestion->retreatRateAnswers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="item">
                                                        <span class="title" id="<?php echo e($answer->status_id); ?>"
                                                            style="background-color: rgba(<?php echo e(hexToRgb($answer->text_color)); ?>, 0.2);">
                                                            <span
                                                                style="color: <?php echo e($answer->text_color); ?>;"><?php echo e($answer->answer); ?></span>
                                                        </span>

                                                        <div class="bar" role="progressbar"
                                                            aria-labelledby="<?php echo e($answer->answerus_id); ?>"
                                                            aria-valuenow="<?php echo e($answer->survey_answer_percent); ?>"
                                                            aria-valuemin="0" aria-valuemax="100">
                                                            <div class="item-progress <?php echo e($answer->class); ?>"
                                                                style="width: <?php echo e($answer->survey_answer_percent); ?>%;background-color: rgba(<?php echo e(hexToRgb($answer->text_color)); ?>, 0.5);">
                                                            </div>
                                                        </div>
                                                        <span class="percent"><?php echo e($answer->survey_answer_percent); ?>%</span>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/surveys/show.blade.php ENDPATH**/ ?>