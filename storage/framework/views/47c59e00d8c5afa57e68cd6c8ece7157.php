<div class="card-gray-bg px-4 pb-4" id="queCardmain">
    <div class="que-head d-flex align-items-center gap-3 flex-wrap-reverse justify-content-between">
        <div class="que-h-right d-flex align-items-center">
            <span class="que-menu-icon" aria-hidden="true"></span>
            <span class="que-inc" aria-hidden="true"></span>
            <h4 class="block-title fs-18 mb-0 ms-3"><?php echo e(__('translation.question_body')); ?></h4>
        </div>
        <div class="que-h-left d-flex align-items-center gap-3 ms-auto">
            <button type="button" class="btn que-trash" data-toggle="modal" data-target="#remove-que-modal"></button>
            <button type="button" class="btn que-arrow" data-toggle="collapse" data-target="#collapseExample1"
                aria-expanded="true" aria-controls="collapseExample1">
            </button>
        </div>
    </div>

    <div class="que-body border-top pt-4 mt-3 collapse show" id="collapseExample1">
        <!-- Question 1 -->
        <fieldset class="mb-3 que-name">
            <label for="nameQue1" class="block-title fs-14"><?php echo e(__('translation.question_title')); ?></label>
            <input type="text" id="nameQue1" name="questions[1][question]"
                value="<?php echo e(old('questions.1.question', $question['question'] ?? '')); ?>"
                placeholder="<?php echo e(__('translation.question_title')); ?>" class="form-control bg-white validate[required]">
        </fieldset>
        <fieldset class="ques-types d-flex align-items-center gap-3 overflow-hidden position-relative">

            <div class="form-group mb-0 form-typeAns flex-shrink-0">
                <label for="typeAnswer1" class="block-title fs-14"><?php echo e(__('translation.question_answer_type')); ?></label>
                <select class="select floating bg-white" dir="rtl" id="typeAnswer1"
                    name="questions[1][answer_type]">
                    <?php $__currentLoopData = $answerTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($type->value); ?>"
                            <?php echo e(old('questions.1.answer_type', $question['answer_type'] ?? '') == $type->value ? 'selected' : ''); ?>>
                            <?php echo e(__('translation.' . $type->name)); ?>

                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

        </fieldset>

        <!-- Answer Options for Question 1 -->
        <div class="answer-options pt-4" style="display: ;">
            <h2 class="fs-18 fw-medium mb-4"><?php echo e(__('translation.question_answer_options')); ?></h2>
            <fieldset class="answer-options-groups d-flex align-items-center flex-wrap">
                <?php for($i = 1; $i <= 4; $i++): ?>
                    <div class="form-group mb-3 w-50 px-2">
                        <label for="inputAnsOptions1-<?php echo e($i); ?>"
                            class="block-title fs-14"><?php echo e(__('translation.question_answer_title')); ?></label>
                        <div class="row row-ansOptions">
                            <div class="col-md-6">
                                <input type="text" id="inputAnsOptions1-<?php echo e($i); ?>"
                                    name="questions[1][answers][<?php echo e($i); ?>]"
                                    placeholder="<?php echo e(__('translation.question_answer_title')); ?>"
                                    class="form-control bg-white ">
                            </div>
                            <div class="col-md-6">
                                <div class="delete-icon position-relative">
                                    <select class="select floating bg-white" id="inputAnsColot1-<?php echo e($i); ?>"
                                        name="questions[1][colors][<?php echo e($i); ?>]">
                                        <?php $__currentLoopData = App\Enums\ColorsEnum::cases(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $color): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($color->value); ?>">
                                                <?php echo e(__('translation.' . $color->name)); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <button type="button"
                                        class="main-btn p-0 border-0 bg-white fs-14 text-red position-absolute end-0 top-50 translate-middle-y me-3 btnDeleAnsOptions">
                                        <?php echo e(__('translation.delete')); ?>

                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endfor; ?>
            </fieldset>
            <button type="button"
                class="btnAddNewAns main-btn p-0 bg-transparent mt-1 text-gold d-flex align-items-center"
                data-id="1"><?php echo e(__('translation.add_answer')); ?></button>
        </div>
    </div>
</div>
<?php $__env->startSection('script'); ?>
    <script>
        function getTypeQueOptions() {
            let options = '';
            <?php
                $jj = 1;
            ?>
            <?php $__currentLoopData = $questionTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                options += `<option value="<?php echo e($jj++); ?>">
                <?php echo e(__('translation.' . $type->name)); ?>

            </option>`;
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            return options;
        }

        function getTypeAnswerOptions() {
            let options = '';
            <?php $__currentLoopData = $answerTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                options += `<option value="<?php echo e($type->value); ?>" >
                <?php echo e(__('translation.' . $type->name)); ?>

            </option>`;
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            return options;
        }
    </script>
    <script>
        const colors = <?php echo json_encode(App\Enums\ColorsEnum::getAll(), 15, 512) ?>;
        console.log(colors);
    </script>
<?php $__env->stopSection(); ?>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/questions.blade.php ENDPATH**/ ?>