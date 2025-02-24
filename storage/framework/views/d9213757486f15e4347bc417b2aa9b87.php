<div class="header d-flex align-items-center justify-content-between">
    <div class="header-right">
        <a href="#" class="logo">
            <img src="<?php echo e(getSettingMedia('app_logo')); ?>" alt="">
        </a>
    </div>
    <div class="header-left-cont d-flex align-items-center gap-2 justify-content-between flex-grow-1">
        <form action="<?php echo e(route('retreat_requests.index')); ?>" class="form-search">
            <fieldset>
                <legend class="sr-only">Search input</legend>
                <input type="search" class="form-control" name="keyword" value="<?php echo e(request()->keyword); ?>"
                    id="inputSearch" placeholder="<?php echo e(__('translation.Search')); ?>" aria-label="Search input">
            </fieldset>
            <button type="submit" class="main-btn position-absolute top-50 translate-middle-y"
                aria-label="Submit search"></button>
        </form>
        <?php
            $notifications = unreadNotifications();
            $lastNotification = $notifications->last();
        ?>
        <div class="d-flex align-items-center gap-3 ps-4">
            <ul class="nav user-menu">
                <?php if(auth()->user()->is_admin()): ?>
                    <li class="nav-item dropdown d-none d-sm-block">
                        <a href="#" class="dropdown-toggle nav-link nav-bell"
                            onclick="markLastRead(<?php echo e($lastNotification->id); ?>)" data-toggle="dropdown"><i
                                class="fa fa-bell-o"></i>
                            <?php if(unreadNotificationsCount() > 0): ?>
                                <span
                                    class="badge badge-pill bg-danger float-end"><?php echo e(unreadNotificationsCount()); ?></span>
                            <?php endif; ?>
                        </a>
                        <div class="dropdown-menu notifications">
                            <div class="topnav-dropdown-header">
                                <span><?php echo e(__('translation.Notifications')); ?></span>
                            </div>
                            <div class="drop-scroll">
                                <ul class="notification-list">
                                    <?php $__currentLoopData = unreadNotifications(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="notification-message">
                                            <a onclick="markAsRead('<?php echo e($notification->id); ?>')"
                                                <?php if(switchLogRoute($notification)): ?> href="<?php echo e(switchLogRoute($notification)); ?>" <?php endif; ?>>
                                                <div class="media">
                                                    <span class="avatar">
                                                        <img alt="<?php echo e($notification->causer?->name); ?>"
                                                            src="<?php echo e($notification->causer?->avatar_url); ?>"
                                                            class="img-fluid">
                                                    </span>
                                                    <div class="media-body">
                                                        <p class="noti-details"><span
                                                                class="noti-title"><?php echo e($notification->causer?->name ?? $notification->causer?->document_number); ?></span>
                                                            <?php echo e(switchLogText($notification)); ?>

                                                        </p>
                                                        <?php
                                                            $time = $notification->created_at->diffForHumans();
                                                            $time =
                                                                $time == '0 seconds ago' || $time == 'منذ 0 ثانية'
                                                                    ? __('translation.just_now')
                                                                    : $time;
                                                        ?>
                                                        <p class="noti-time"><span
                                                                class="notification-time"><?php echo e($time); ?></span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                            <div class="topnav-dropdown-footer">
                                <a href="<?php echo e(route('notifications.index')); ?>" class="btn btn-primary btn-sm">
                                    <?php echo e(__('translation.view_all_notifications')); ?></a>
                            </div>
                        </div>
                    </li>
                <?php endif; ?>
                <li class="nav-item dropdown has-arrow">
                    <a href="#" class="dropdown-toggle nav-link user-link" data-toggle="dropdown">
                        <span class="user-img">
                            <img class="rounded-circle" src="<?php echo e(Auth::user()->avatar_url ?? default_avatar()); ?>"
                                width="32" height="32" alt="<?php echo e(Auth::user()->name); ?>">
                            <span class="status online"></span>
                        </span>
                        <span><?php echo e(Auth::user()->name); ?></span>
                    </a>
                    <div class="dropdown-menu">
                        <a class="dropdown-item"
                            href="<?php echo e(route('admins.profile')); ?>"><?php echo e(__('translation.My Profile')); ?></a>
                        <a class="dropdown-item"
                            href="<?php echo e(route('admins.profile')); ?>"><?php echo e(__('translation.Edit Profile')); ?></a>
                        <?php if(is_admin()): ?>
                            <a class="dropdown-item"
                                href="<?php echo e(route('settings.index')); ?>"><?php echo e(__('translation.Settings')); ?></a>
                        <?php endif; ?>
                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"><?php echo e(__('translation.Logout')); ?></a>
                    </div>
                </li>
            </ul>
            <div class="dropdown mobile-user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i
                        class="fa fa-ellipsis-v"></i></a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item"
                        href="<?php echo e(route('admins.profile')); ?>"><?php echo e(__('translation.My Profile')); ?></a>
                    <a class="dropdown-item"
                        href="<?php echo e(route('admins.profile')); ?>"><?php echo e(__('translation.Edit Profile')); ?></a>
                    <?php if(is_admin()): ?>
                        <a class="dropdown-item"
                            href="<?php echo e(route('settings.index')); ?>"><?php echo e(__('translation.Settings')); ?></a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"><?php echo e(__('translation.Logout')); ?></a>
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
<?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/layouts/topbar.blade.php ENDPATH**/ ?>