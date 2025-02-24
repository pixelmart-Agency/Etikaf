<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.surveys'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                <?php echo $__env->make('components.index_head', [
                    'title' => __('translation.surveys'),
                    'createRoute' => route('surveys.create'),
                    'placeholder' => __('translation.SearchSurvey'),
                    'btn' => __('translation.addNewSurvey'),
                    'exportRoute' => route('surveys.export'),
                    'fileName' => __('translation.surveys_report'),
                ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="card-body-table">
                    <div class="row">
                        <span class="alert alert-warning" id="no-data-alert">
                            <?php echo e(__('translation.only_one_survey_can_be_active')); ?>

                        </span>
                        <input type="hidden" class="in_survey" value="1">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo e(__('translation.survey_id')); ?></th>
                                            <th><?php echo e(__('translation.survey_title')); ?></th>
                                            <th><?php echo e(__('translation.survey_start_date')); ?></th>
                                            <th><?php echo e(__('translation.survey_end_date')); ?></th>
                                            <th><?php echo e(__('translation.survey_status')); ?></th>
                                            <th></th>
                                            <?php echo $__env->make('components.common_show_th', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $__env->make('components.datatable.table', [
                                            'data' => $surveys,
                                            'route' => 'surveys',
                                            'hasDelete' => true,
                                            'hasShow' => true,
                                            'hasEdit' => false,
                                            'hasStatus' => true,
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </tbody>
                                </table>
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

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/surveys/index.blade.php ENDPATH**/ ?>