 <div class="filter-row d-flex flex-wrap align-items-center gap-2 justify-content-between mb-2">
     <div class="text-cont">
         <h2 class="block-title"> {{ $title }}
             @if (isset($recordCount))
                 ({{ $recordCount }})
             @endif

         </h2>
     </div>
     <div class="d-flex flex-wrap align-items-center gap-2">
         <fieldset class="position-relative">
             <legend class="sr-only">Search input</legend>
             <input type="search" class="form-control" id="inputSearchTable" autocomplete="off"
                 placeholder="{{ $placeholder ?? '' }}">
             <i class="icon-search-i position-absolute top-50 translate-middle-y ms-3"></i>
         </fieldset>
         <button type="submit" class="btn-submit" id="submitFilterTable"></button>
         <button type="button" class="custom-popovers" id="btnExportTable" data-content="تصدير"></button>
         @if (isset($createRoute))
             <a href="{{ $createRoute ?? '' }}" class="main-btn fs-14">{{ $btn ?? '' }}</a>
         @endif
     </div>
 </div>
 @if (isset($exportRoute))
     <input type="hidden" id="export-route" value="{{ $exportRoute ?? '' }}">
     <input type="hidden" id="file-name" value="{{ $fileName ?? '' }}">
 @endif
