@extends('layouts.master')

@section('title')
    @lang('translation.rates')
@endsection

@section('content')
    <div class="row row-main-order">
        <div class="col-12">
            <div class="card-bg px-4">
                @include('components.index_head', [
                    'title' => __('translation.rates'),
                ])
                <div class="card-body-table">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table mb-0 datatable">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translation.user_name') }}</th>
                                            <th>{{ __('translation.answer') }}</th>
                                            <th>{{ __('translation.comment') }}</th>
                                            <th>{{ __('translation.created_at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $index = 1;
                                        @endphp
                                        @foreach ($rates as $rate)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>
                                                    <img width="32" height="32"
                                                        src="{{ imageUrl($rate->user?->avatar_url) }}"
                                                        class="rounded-circle me-2" alt="">
                                                    {{ $rate->user?->name }}
                                                </td>
                                                <td>{{ __('translation.' . $rate->rate . '_rate') }}</td>
                                                <td>{{ $rate->comment }}</td>
                                                <td class="text-center">
                                                    {{ convertToHijri($rate->created_at) }} |
                                                    {{ $rate->created_at->diffForHumans() }}
                                                </td>

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
