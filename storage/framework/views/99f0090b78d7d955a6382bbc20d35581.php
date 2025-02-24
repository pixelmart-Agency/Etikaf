 <div class="row row-main-order">
     <div class="col-12">
         <div class="card-bg px-4">
             <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
                 <div class="text-cont">
                     <h2 class="block-title"> <?php echo e(__('translation.retreat_requests')); ?> </h2>
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
                     <?php if(!route_is('root')): ?>
                         <div class="d-flex gap-2 flex-wrap">
                             <button type="button" class="rejectAll-req main-btn fs-14 px-4 bg-light-red text-red"
                                 data-target="#rejectAll-survey" data-toggle="modal" disabled>
                                 <?php echo e(__('translation.reject')); ?>

                             </button>
                             <button type="button" class="acceptAll-req main-btn fs-14 px-4"
                                 data-target="#acceptAll-survey" data-toggle="modal" disabled>
                                 <?php echo e(__('translation.accept_request')); ?>

                             </button>
                         </div>
                     <?php endif; ?>
                 </div>
             </div>
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
                                                 <th class="<?php echo e(!route_is('root') ? 'th-checkbox' : ''); ?>">
                                                     <?php if(!route_is('root')): ?>
                                                         <span class="position-absolute top-50 translate-middle-y">
                                                             <label class="lable-select-box">
                                                                 <input type="checkbox" id="selectAll"
                                                                     aria-label="Select all">
                                                             </label>
                                                         </span>
                                                     <?php endif; ?>
                                                     #
                                                 </th>
                                                 <th><?php echo e(__('translation.national_id_passport')); ?></th>
                                                 <th><?php echo e(__('translation.name_nationality')); ?></th>
                                                 <th><?php echo e(__('translation.mosque')); ?></th>
                                                 <th><?php echo e(__('translation.age')); ?></th>
                                                 <th><?php echo e(__('translation.mosque_location')); ?></th>
                                                 <th><?php echo e(__('translation.retreat_date')); ?></th>
                                                 <th><?php echo e(__('translation.status')); ?></th>
                                                 <th></th>
                                             </tr>
                                         </thead>
                                         <tbody>
                                             <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                 <tr>
                                                     <td>
                                                         <?php if(!route_is('root') && $request->status == App\Enums\ProgressStatusEnum::PENDING->value): ?>
                                                             <label class="lable-select-box">
                                                                 <input type="checkbox" class="select-box"
                                                                     name="selectedIds[]" value="<?php echo e($request->id); ?>">
                                                             </label>
                                                         <?php endif; ?>
                                                         <?php echo e($loop->iteration); ?>

                                                     </td>
                                                     <td><?php echo e($request->user->document_number); ?></td>
                                                     <td>
                                                         <h2><a href="<?php echo e(route('users.edit', $request->user?->id)); ?>">
                                                                 <?php echo e($request->name ?? $request->user->name); ?>

                                                                 <span><?php echo e(getTransValue($request->user?->country?->name)); ?></span>
                                                         </h2>
                                                     </td>
                                                     <td> <?php echo e(getTransValue($request->retreatMosque?->name)); ?>

                                                     </td>
                                                     <td><?php echo e($request->age ?? $request->user->age); ?>

                                                         <?php echo e(__('translation.years')); ?></td>
                                                     <td> <?php echo e(getTransValue($request->retreatMosqueLocation?->name)); ?>

                                                     <td><?php echo e($request->start_time_arabic); ?></td>
                                                     </td>
                                                     <td class="<?php echo e($request->status_class); ?>">
                                                         <span><?php echo e(__('translation.' . $request->status)); ?></span>
                                                     <td class="show-td"><a
                                                             href="<?php echo e(route('retreat_requests.show', $request->id)); ?>"><i
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
                 <div class="card-body-table">
                     <div class="card-body-default d-flex flex-column align-items-center mt-5">

                         <div class="btn-cont mb-30">
                             <?php if(upComingSeason() || seasonEnded()): ?>
                                 <a href="#" class="secondary-btn" data-toggle="modal"
                                     data-target="#open-submission">
                                     <?php echo e(__('translation.schadual_season')); ?></a>
                             <?php endif; ?>

                             <?php if(currentPendingSeason() || seasonEnded()): ?>
                                 <a href="#" data-toggle="modal" data-target="#open-now" class="main-btn">
                                     <?php echo e(__('translation.open_now')); ?></a>
                             <?php endif; ?>
                         </div>
                     </div>
                 </div>
             <?php endif; ?>

         </div>
     </div>
 </div>

 <?php echo $__env->make('components.modals.common_modal', [
     'confirm_title' => __('translation.Are you sure you want to open the season now?'),
     'confirm_message' => $confirm_message ?? '',
     'route' => route('open_season_now'),
     'id' => 'open-now',
 ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
 <div id="acceptAll-survey" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
             <div class="modal-header border-0 flex-column align-items-center py-0 mb-40">

                 <h2 class="block-title mb-2 fs-24">
                     <?php echo e(__('translation.Are you sure you want to accept all requests?')); ?></h2>
                 <div class="block-text fs-18">
                     <p></p>
                 </div>
             </div>
             <div class="modal-body py-0">
                 <div class="btn-cont gap-2 justify-content-center">
                     <button type="button" class="main-btn text-blue bg-main-color close"
                         data-dismiss="modal"><?php echo e(__('translation.Cancel')); ?></button>
                     <button class="main-btn bg-gold acceptAll-btn" id="acceptAll-btn">
                         <?php echo e(__('translation.Yes')); ?>

                     </button>
                 </div>
             </div>
         </div>

     </div>

 </div>
 <div id="rejectAll-survey" class="modal fade" role="dialog" style="display: none;" aria-hidden="true">
     <div class="modal-dialog">
         <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
             <div class="modal-header border-0 flex-column align-items-center py-0 mb-40">

                 <h2 class="block-title mb-2 fs-24">
                     <?php echo e(__('translation.Are you sure you want to reject all requests?')); ?></h2>
                 <div class="block-text fs-18">
                     <p></p>
                 </div>
             </div>
             <div class="modal-body py-0">
                 <div class="btn-cont gap-2 justify-content-center">
                     <button type="button" class="main-btn text-blue bg-main-color close"
                         data-dismiss="modal"><?php echo e(__('translation.Cancel')); ?></button>
                     <button class="main-btn bg-gold rejectAll-btn" id="rejectAll-btn">
                         <?php echo e(__('translation.Yes')); ?>

                     </button>
                 </div>
             </div>
         </div>

     </div>

 </div>
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/components/request_components/request_data.blade.php ENDPATH**/ ?>