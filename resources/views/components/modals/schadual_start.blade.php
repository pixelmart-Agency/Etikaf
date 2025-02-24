 <div id="open-submission" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
     <div class="modal-dialog">
         <div class="modal-content modal-md">
             <div class="modal-header flex-column align-items-start">
                 <h2 class="block-title fs-20 mb-1">{{ trans('translation.open_season') }}</h2>
                 <div class="block-text fs-18">
                     <p>{{ trans('translation.schadual_season_automatic') }}</p>
                 </div>
             </div>
             <div class="modal-body p-0">
                 <form action='{{ route('schaduale_season') }}' method="post">
                     @csrf
                     <div class="form-group p-4">
                         <label class="fs-16 fw-medium mb-2">{{ trans('translation.open_time') }}</label>
                         <div class="cal-icon">
                             <input class="form-control datetimepicker" type="text" name="start_date"
                                 format="YYYY-MM-DD" placeholder="{{ trans('translation.choose_open_time') }}">
                         </div>
                     </div>
                     <div class="btn-cont justify-content-between px-4 pb-4">
                         <button type="button" class="main-btn text-blue bg-main-color close"
                             data-dismiss="modal">{{ __('translation.Cancel') }}</button>
                         <button type="submit" class="main-btn bg-gold">{{ __('translation.approve_time') }}</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>
 </div>
