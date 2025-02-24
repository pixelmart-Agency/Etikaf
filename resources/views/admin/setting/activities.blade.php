@extends('layouts.master')

@section('title')
    @lang('translation.Activities')
@endsection

@section('content')
    @component('components.breadcrumb')
        @slot('li_1')
            Activities
        @endslot
    @endcomponent

    <div class="container mt-4">
        <h3>@lang('translation.Activity Log')</h3>

        @if ($activities->isNotEmpty())
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>@lang('translation.Date')</th>
                        <th>@lang('translation.Description')</th>
                        <th>@lang('translation.Causer')</th>
                        <th class="text-center">@lang('translation.Properties')</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($activities as $activity)
                        <tr>
                            <td>{{ $activity->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ __('translation.' . explode(' ', $activity->description)[1]) }}</td>
                            <td>
                                @if ($activity->causer)
                                    {{ $activity->causer->name }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td class="text-center">
                                @if ($activity->properties)
                                    <button class="btn btn-sm btn-outline-info"
                                        onclick="showProperties('{{ json_encode($activity->properties, JSON_HEX_APOS | JSON_HEX_QUOT) }}')">
                                        @lang('translation.View')
                                    </button>
                                @else
                                    <span class="badge bg-secondary">@lang('translation.None')</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <p>@lang('translation.No activities found')</p>
        @endif
    </div>
@endsection
@section('script-bottom')
    <script>
        function showProperties(properties) {
            const parsedProperties = JSON.parse(properties);

            Swal.fire({
                title: '@lang('translation.Properties')',
                html: `<pre style="text-align: left; font-size: 14px; background: #f8f9fa; padding: 10px; border-radius: 5px;">${JSON.stringify(parsedProperties, null, 2)}</pre>`,
                icon: 'info',
                customClass: {
                    popup: 'text-start'
                },
                confirmButtonText: '@lang('translation.Close')'
            });
        }
    </script>
@endsection
