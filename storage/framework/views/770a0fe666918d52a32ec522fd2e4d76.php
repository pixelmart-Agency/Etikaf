<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.survey_details'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row">
        <?php echo $__env->make('components.breadcrumb', [
            'parent_route' => 'surveys.index',
            'parent_title' => __('translation.surveys'),
            'title' => __('translation.survey_details'),
        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="row row-main-order tab-container">
            <div class="col-12">
                <div class="card-bg px-4">
                    <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
                        <div class="text-cont">
                            <h2 class="block-title">
                                <?php echo e(__('translation.survey_title') . ' : ' . getTransValue($survey->title)); ?>

                            </h2>
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
                                                    <th><?php echo e(__('translation.question_title')); ?></th>
                                                    <th><?php echo e(__('translation.answer')); ?></th>
                                                    <th><?php echo e(__('translation.answer_date')); ?></th>
                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <tr>
                                                        <td>
                                                            <img width="32" height="32"
                                                                src="<?php echo e($question->user->avatar_url); ?>"
                                                                class="rounded-circle me-2"
                                                                alt="<?php echo e($question->user->name); ?>">
                                                            <?php echo e($question->user->name); ?>

                                                        </td>
                                                        <td><?php echo e(getTransValue($question->retreatRateQuestion->question)); ?>

                                                        </td>
                                                        <td>
                                                            <?php if($question->retreatRateAnswer): ?>
                                                                <?php echo e(getTransValue($question->retreatRateAnswer->answer)); ?>

                                                            <?php else: ?>
                                                                <?php echo e($question->text_answer); ?>

                                                            <?php endif; ?>
                                                        </td>
                                                        <td><?php echo e(convertToHijri($question->created_at->format('Y-m-d'))); ?>

                                                        </td>
                                                    </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/surveys/questions_show.blade.php ENDPATH**/ ?>