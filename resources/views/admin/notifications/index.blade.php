@extends('layouts.master')

@section('title')
    @lang('translation.activity_logs')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.activity_logs'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.notification_text') }}</th>
                                            <th>{{ __('translation.activity_time') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @foreach ($notifications as $notification)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>
                                                    <img width="32" height="32"
                                                        src="{{ imageUrl($notification->causer?->avatar_url) }}"
                                                        class="rounded-circle me-2" alt="">
                                                    <a onclick="markAsRead('{{ $notification->id }}')"
                                                        notify-id="{{ $notification->id }}"
                                                        is-read="{{ isset($notification->properties['is_read']) }}"
                                                        @if (switchLogRoute($notification)) href="{{ switchLogRoute($notification) ?? '' }}" @endif
                                                        target="_blank">
                                                        {{ $notification->causer?->name ?? $notification->causer?->document_number }}
                                                        {{ switchLogText($notification) }}
                                                    </a>
                                                </td>
                                                <td
                                                    class="{{ !isset($notification->properties['is_read']) ? 'under-review' : '' }}">
                                                    {{ $notification->created_at->diffForHumans() }}
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
@endsection
