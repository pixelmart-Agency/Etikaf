<div id="reassign-submission" class="modal fade" role="dialog" aria-modal="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content modal-md">
            <div class="modal-header flex-column align-items-start">
                <h2 class="block-title fs-20 mb-1">{{ __('translation.reassign_request') }}</h2>
                <div class="block-text fs-18">
                    <p>{{ __('translation.select_assign_employee') }}</p>
                </div>
            </div>
            <div class="modal-body p-0">
                <form action="{{ route('retreat-service-requests.reassign', $request->id) }}" method="post">
                    @csrf
                    <div class="form-group p-4 border-bottom">
                        <label
                            class="fs-16 fw-medium mb-2 text-blue">{{ __('translation.reassign_request_to') }}</label>
                        <div class="form-group form-focus select-focus mb-0">
                            <select id="selectForward" name="employee_id">
                                <option value="" disabled selected hidden>
                                    {{ __('translation.reassign_request_to') }}</option>
                                <!-- Placeholder option -->
                                @foreach ($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="btn-cont justify-content-between px-4 pb-4">
                        <button type="button" class="main-btn text-blue bg-main-color close"
                            data-dismiss="modal">{{ __('translation.Cancel') }}</button>
                        <button type="submit" class="main-btn bg-gold">
                            {{ __('translation.confirm_reassign') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
