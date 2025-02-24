  <div class="row">
      <div class="col-12">
          <div class="card-bg d-flex align-items-center justify-content-between px-4">
              <div
                  class="text-cont flex-grow-1 gap-3 flex-shrink-0 d-flex flex-wrap justify-content-between align-items-start">
                  <div>
                      <h2 class="block-title"><?php echo e(__('translation.retreat_season_status')); ?></h2>
                      <div class="block-text">
                          <p><?php echo e(__('translation.open_time')); ?> :
                              <?php if(currentSeason()): ?>
                                  <span> <?php echo e(convertToHijri(currentSeason()->start_date)); ?></span>
                              <?php else: ?>
                                  <span> <?php echo e(__('translation.not_set_yet')); ?></span>
                              <?php endif; ?>
                          </p>
                      </div>
                  </div>
                  <?php if(retreat_season_is_open()): ?>
                      <h3 class="block-subtitle fs-14 rounded-pill py-1 px-3 mb-0 text-green bg-light-green">
                          <?php echo e(__('translation.season_open')); ?></h3>
                  <?php else: ?>
                      <h3 class="block-subtitle fs-14 rounded-pill py-1 px-3 mb-0 text-red bg-light-red">
                          <?php echo e(__('translation.season_closed')); ?></h3>
                  <?php endif; ?>
              </div>
              <?php if(retreat_season_is_open()): ?>
                  <div class="reschedule-closing-date flex-grow-1">
                      <div class="btn-cont justify-content-end">
                          <?php if(auth()->user()->hasPermissionTo('retreat_requests')): ?>
                              <a href="" class="secondary-btn" data-toggle="modal"
                                  data-target="#close-submission">
                                  <?php echo e(__('translation.close_submission')); ?>

                              </a>
                              <a href="#" data-toggle="modal" data-target="#request-createSurvey"
                                  class="main-btn bg-red-f5"><?php echo e(__('translation.close_now')); ?></a>
                          <?php endif; ?>
                      </div>
              <?php endif; ?>
          </div>
      </div>
  </div>
  <?php echo $__env->make('components.modals.common_modal', [
      'confirm_title' => __('translation.Are you sure you want to close the season?'),
      'confirm_message' => $confirm_message ?? '',
      'route' => route('close_season'),
  ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/request_components/request_status.blade.php ENDPATH**/ ?>