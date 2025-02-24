<td class="delete-td">
    @if ($is_deletable)
        <a href="#request-delete-{{ $id }}" data-toggle="modal"
            data-target="#request-delete-{{ $id }}">
            <i aria-hidden="true"></i> {{ __('translation.delete') }}
        </a>
    @endif
</td>
<div id="request-delete-{{ $id }}" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <form action="{{ $route }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('DELETE')
        <div class="modal-dialog">
            <div class="modal-content modal-md border-0 py-5 px-3 px-md-4 px-lg-5">
                <div class="modal-header border-0 flex-column align-items-center py-0 mb-40">
                    <div class="img-cont mb-4">
                        <img src="{{ assetUrl('assets/img_v2/img-request-denied.png') }}" class="w-100 mw-100"
                            alt="">
                    </div>
                    <h2 class="block-title mb-2 fs-24">{{ __('translation.sureToDelete') }}</h2>
                    <div class="block-text fs-18">
                        <p>{{ __('translation.delete_alert') }}</p>
                    </div>
                </div>
                <div class="modal-body py-0">
                    <div class="btn-cont gap-2 justify-content-center">
                        <button type="button" class="main-btn text-blue bg-main-color close"
                            data-dismiss="modal">{{ __('translation.Cancel') }}</button>
                        <button type="submit" class="main-btn bg-gold" id="btn-remove-que">
                            {{ __('translation.confirm_delete') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
