<div class="header d-flex align-items-center justify-content-between">
    <div class="header-right">
        <a href="#" class="logo">
            <img src="{{ getSettingMedia('app_logo') }}" alt="">
        </a>
    </div>
    <div class="header-left-cont d-flex align-items-center gap-2 justify-content-between flex-grow-1">
        <form action="{{ route('retreat_requests.index') }}" class="form-search">
            <fieldset>
                <legend class="sr-only">Search input</legend>
                <input type="search" class="form-control" name="keyword" value="{{ request()->keyword }}"
                    id="inputSearch" placeholder="{{ __('translation.Search') }}" aria-label="Search input">
            </fieldset>
            <button type="submit" class="main-btn position-absolute top-50 translate-middle-y"
                aria-label="Submit search"></button>
        </form>
        @php
            $notifications = unreadNotifications();
            $lastNotification = $notifications->last();
        @endphp
        <div class="d-flex align-items-center gap-3 ps-4">
            <ul class="nav user-menu">
                @if (auth()->user()->is_admin())
                    <li class="nav-item dropdown d-none d-sm-block">
                        <a href="#" class="dropdown-toggle nav-link nav-bell"
                            onclick="markLastRead({{ $lastNotification->id }})" data-toggle="dropdown"><i
                                class="fa fa-bell-o"></i>
                            @if (unreadNotificationsCount() > 0)
                                <span
                                    class="badge badge-pill bg-danger float-end">{{ unreadNotificationsCount() }}</span>
                            @endif
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span>{{ __('translation.Notifications') }}</span>
                            </div>
                            <div class="drop-scroll">
                                <ul class="notification-list">
                                    @foreach (unreadNotifications() as $notification)
                                        <li class="notification-message">
                                            <a onclick="markAsRead('{{ $notification->id }}')"
                                                @if (switchLogRoute($notification)) href="{{ switchLogRoute($notification) }}" @endif>
                                                <div class="media">
                                                    <span class="avatar">
                                                        <img alt="{{ $notification->causer?->name }}"
                                                            src="{{ $notification->causer?->avatar_url }}"
                                                            class="img-fluid">
                                                    </span>
                                                    <div class="media-body">
                                                        <p class="noti-details"><span
                                                                class="noti-title">{{ $notification->causer?->name ?? $notification->causer?->document_number }}</span>
                                                            {{ switchLogText($notification) }}
                                                        </p>
                                                        @php
                                                            $time = $notification->created_at->diffForHumans();
                                                            $time =
                                                                $time == '0 seconds ago' || $time == 'منذ 0 ثانية'
                                                                    ? __('translation.just_now')
                                                                    : $time;
                                                        @endphp
                                                        <p class="noti-time"><span
                                                                class="notification-time">{{ $time }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="{{ route('notifications.index') }}" class="btn btn-primary btn-sm">
                                    {{ __('translation.view_all_notifications') }}</a>
                            </div>
                        </div>
                    </li>
                @endif
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="{{ Auth::user()->avatar_url ?? default_avatar() }}"
                                width="32" height="32" alt="{{ Auth::user()->name }}">
                            <span class="status online"></span>
                        </span>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"
                            href="{{ route('admins.profile') }}">{{ __('translation.My Profile') }}</a>
                        <a class="dropdown-item"
                            href="{{ route('admins.profile') }}">{{ __('translation.Edit Profile') }}</a>
                        @if (is_admin())
                            <a class="dropdown-item"
                                href="{{ route('settings.index') }}">{{ __('translation.Settings') }}</a>
                        @endif
                        <a class="dropdown-item" href="{{ route('logout') }}">{{ __('translation.Logout') }}</a>
                    </div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"
                        href="{{ route('admins.profile') }}">{{ __('translation.My Profile') }}</a>
                    <a class="dropdown-item"
                        href="{{ route('admins.profile') }}">{{ __('translation.Edit Profile') }}</a>
                    @if (is_admin())
                        <a class="dropdown-item"
                            href="{{ route('settings.index') }}">{{ __('translation.Settings') }}</a>
                    @endif
                    <a class="dropdown-item" href="{{ route('logout') }}">{{ __('translation.Logout') }}</a>
                </div>
            </div>
            <a id="toggle_btn" href="javascript:void(0);">
                <svg width="30px" height="30px" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12H20M4 8H20M4 16H12" stroke="#25343E" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg>
            </a>
            <a id="mobile_btn" class="mobile_btn" href="#sidebar"> <svg width="30px" height="30px"
                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12H20M4 8H20M4 16H12" stroke="#25343E" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round" />
                </svg></a>
        </div>
    </div>
</div>
