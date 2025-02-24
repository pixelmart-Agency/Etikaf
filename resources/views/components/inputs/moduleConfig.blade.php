@php
    $id = request()->route('id') ?? 0;
    $enum = 'App\\Enums\\ModuleActionEnum';
    $name = 'actions';
    $module = isset($id) ? routeConfig($id) : null;
@endphp

<div class="col-md-{{ $col ?? 12 }}">
    <div class="{{ $class ?? 'mt-3' }}">
        <label for="">
            {{ __('translation.Actions') }}
        </label>
        <div class="d-flex flex-row">
            @foreach ($enum::cases() as $case)
                @php
                    $caseLabel = ucfirst(strtolower($case->name));
                @endphp
                <div class="custom-radio-container mb-3 me-3"
                    onclick="document.getElementById('{{ $name . '_' . $caseLabel }}').click()">
                    <input type="checkbox" class="custom-radio {{ $name }}" name="{{ $name }}[]"
                        id="{{ $name . '_' . $caseLabel }}" value="{{ !empty($case->value) ? $case->value : 0 }}"
                        {{ isset($module->module_name) && actionExists($module->module_name, $case->value) ? 'checked' : '' }}>
                    <label for="{{ $name . '_' . $caseLabel }}" class="custom-radio-label">
                        {{ __('translation.' . $caseLabel) }}
                    </label>
                </div>
            @endforeach
        </div>

        @error($name)
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
<div class="col-md-{{ $col ?? 12 }}">
    <div class="{{ $class ?? 'mt-3' }}">
        <label for="">
            {{ __('translation.Input fields') }}
        </label>
        <button type="button" id="add-row" class="btn btn-success btn-sm">
            {{ __('translation.add') }}
        </button>
        <table class="table" id="inputs-table">
            <thead>
                <tr>
                    <th>{{ __('translation.input_name') }}</th>
                    <th>{{ __('translation.input_type') }}</th>
                    <th>{{ __('translation.label') }}</th>
                    <th>{{ __('translation.class') }}</th>
                    <th>{{ __('translation.col') }}</th>
                    <th>{{ __('translation.model') }}</th>
                    <th>{{ __('translation.do_not_show') }}</th>
                    <th>{{ __('translation.type') }}</th>
                    <th>{{ __('translation.ajax_response_to') }}</th>
                    <th>{{ __('translation.ajax_model') }}</th>
                    <th>{{ __('translation.Parent') }}</th>
                    <th>{{ __('translation.actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @if (isset($module) && $module->inputs()->count())
                    @foreach ($module->inputs as $input)
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="inputs[input_name][]"
                                    value="{{ $input->input_name }}">
                            </td>
                            <td>
                                <select name="inputs[input_type][]" class="form-control">
                                    @foreach (\App\Enums\InputComponentTypeEnum::cases() as $type)
                                        <option {{ $input->input_type == $type->value ? 'selected' : '' }}
                                            value="{{ $type->value }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="inputs[label][]"
                                    value="{{ $input->label }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="inputs[class][]"
                                    value="{{ $input->class }}">
                            </td>
                            <td>
                                <input type="number" class="form-control" name="inputs[col][]"
                                    value="{{ $input->col ?? 12 }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="inputs[model][]"
                                    value="{{ $input->model }}">
                            </td>
                            <td>
                                <select name="inputs[do_not_show][]" class="form-control">
                                    <option value="1" {{ $input->do_not_show == 1 ? 'selected' : '' }}>
                                        {{ __('translation.Yes') }}
                                    </option>
                                    <option value="0" {{ $input->do_not_show == 0 ? 'selected' : '' }}>
                                        {{ __('translation.No') }}</option>
                                </select>
                            </td>
                            <td>
                                <select name="inputs[type][]" class="form-control">
                                    @foreach (\App\Enums\InputTypeEnum::cases() as $type)
                                        <option {{ $input->type == $type->value ? 'selected' : '' }}
                                            value="{{ $type->value }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="inputs[ajax_response_to][]"
                                    value="{{ $input->ajax_response_to }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="inputs[ajax_model][]"
                                    value="{{ $input->ajax_model }}">
                            </td>
                            <td>
                                <input type="text" class="form-control" name="inputs[parent_id][]"
                                    value="{{ $input->parent_id }}">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm delete-row">
                                    {{ __('translation.delete') }}
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>
                            <input type="text" class="form-control" name="inputs[input_name][]" value="">
                        </td>
                        <td>
                            <select name="inputs[input_type][]" class="form-control">
                                @foreach (\App\Enums\InputComponentTypeEnum::cases() as $type)
                                    <option value="{{ $type->value }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="inputs[label][]" value="">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="inputs[class][]" value="">
                        </td>
                        <td>
                            <input type="number" class="form-control" name="inputs[col][]" value="12">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="inputs[model][]" value="">
                        </td>
                        <td>
                            <select name="inputs[do_not_show][]" class="form-control">
                                <option value="1">
                                    {{ __('translation.Yes') }}
                                </option>
                                <option value="0">
                                    {{ __('translation.No') }}</option>
                            </select>
                        </td>
                        <td>
                            <select name="inputs[type][]" class="form-control">
                                @foreach (\App\Enums\InputTypeEnum::cases() as $type)
                                    <option value="{{ $type->value }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="text" class="form-control" name="inputs[ajax_response_to][]" value="">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="inputs[ajax_model][]" value="">
                        </td>
                        <td>
                            <input type="text" class="form-control" name="inputs[parent_id][]" value="">
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm delete-row">
                                {{ __('translation.delete') }}
                            </button>
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>


        @error('inputs')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
@if (isset($module) && $module->inputs()->count() > 0)
    <div class="col-md-{{ $col ?? 12 }}">
        <div class="{{ $class ?? 'mt-3' }}">
            <label for="">
                {{ __('translation.Table fields') }}
            </label>
            <div class="d-flex flex-row">
                @foreach ($module->inputs as $input)
                    <div class="custom-radio-container mb-3 me-3"
                        onclick="document.getElementById('{{ $input->input_name }}').click()">
                        <input type="checkbox" class="custom-radio table_fields" name="table_fields[]"
                            id="{{ $input->input_name }} PP"
                            value="{{ !empty($input->input_name) ? $input->input_name : 0 }}"
                            {{ isset($module->module_name) &&
                            (tableFieldExists($module->module_name, $input->input_name) ||
                                tableFieldExists($module->module_name, trim($input->input_name, '_id')))
                                ? 'checked'
                                : '' }}>
                        <label for="{{ $input->input_name }}" class="custom-radio-label">
                            {{ __('translation.' . $input->label) }}
                        </label>
                    </div>
                @endforeach
            </div>

            @error($name)
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
@endif
<script>
    const inputComponentTypes = @json(\App\Enums\InputComponentTypeEnum::cases());
    const inputTypes = @json(\App\Enums\InputTypeEnum::cases());
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const inputsTable = document.getElementById('inputs-table');
        const addRowButton = document.getElementById('add-row');

        // Add a new row
        addRowButton.addEventListener('click', function() {
            const newRow = `
                <tr>
                    <td>
                        <input type="text" class="form-control" name="inputs[input_name][]" value="">
                    </td>
                    <td>
                        <select name="inputs[input_type][]" class="form-control">
                            ${generateInputComponentTypeOptions()}
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="inputs[label][]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="inputs[class][]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="inputs[col][]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="inputs[model][]" value="">
                    </td>
                    <td>
                        <select name="inputs[do_not_show][]" class="form-control" id="do_not_show_select">
                            ${generateSelectOption()}
                        </select>
                    </td>
                    <td>
                        <select name="inputs[type][]" class="form-control">
                            ${generateInputTypeOptions()}
                        </select>
                    </td>
                    <td>
                        <input type="text" class="form-control" name="inputs[ajax_response_to][]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="inputs[ajax_model][]" value="">
                    </td>
                    <td>
                        <input type="text" class="form-control" name="inputs[parent_id][]" value="">
                    </td>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">
                            {{ __('translation.delete') }}
                        </button>
                    </td>
                </tr>
            `;
            inputsTable.querySelector('tbody').insertAdjacentHTML('beforeend', newRow);
        });

        function generateSelectOption() {
            const options = [{
                    value: '1',
                    text: '{{ __('translation.Yes') }}'
                },
                {
                    value: '0',
                    text: '{{ __('translation.No') }}'
                }
            ];

            // توليد الخيارات
            return options.map(option => {
                return `<option value="${option.value}">${option.text}</option>`;
            }).join('');
        }

        // Delete a row
        inputsTable.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-row')) {
                e.target.closest('tr').remove();
            }
        });

        // Sorting function for each column
        function sortTable(columnIndex) {
            const rows = Array.from(inputsTable.querySelector('tbody').rows);
            const isNumericColumn = columnIndex === 4 || columnIndex === 5 || columnIndex ===
                6; // For 'col', 'do_not_show', 'type'

            const sortedRows = rows.sort((rowA, rowB) => {
                const cellA = rowA.cells[columnIndex];
                const cellB = rowB.cells[columnIndex];

                const valueA = isNumericColumn ?
                    (cellA.querySelector('input') ? cellA.querySelector('input').value : cellA
                        .textContent).trim() :
                    (cellA.querySelector('select') ? cellA.querySelector('select').value : cellA
                        .textContent).trim();
                const valueB = isNumericColumn ?
                    (cellB.querySelector('input') ? cellB.querySelector('input').value : cellB
                        .textContent).trim() :
                    (cellB.querySelector('select') ? cellB.querySelector('select').value : cellB
                        .textContent).trim();

                // Compare the values (ascending order)
                return valueA.localeCompare(valueB, undefined, {
                    numeric: isNumericColumn,
                    sensitivity: 'base'
                });
            });

            // Reattach sorted rows
            rows.forEach(row => inputsTable.querySelector('tbody').removeChild(row));
            inputsTable.querySelector('tbody').append(...sortedRows);
        }

        // Generate options for InputComponentTypeEnum
        function generateInputComponentTypeOptions() {
            let options = '';
            @foreach (\App\Enums\InputComponentTypeEnum::cases() as $type)
                options += `<option value="{{ $type->value }}">{{ $type->name }}</option>`;
            @endforeach
            return options;
        }

        // Generate options for InputTypeEnum
        function generateInputTypeOptions() {
            let options = '';
            @foreach (\App\Enums\InputTypeEnum::cases() as $type)
                options += `<option value="{{ $type->value }}">{{ $type->name }}</option>`;
            @endforeach
            return options;
        }
    });
</script>
