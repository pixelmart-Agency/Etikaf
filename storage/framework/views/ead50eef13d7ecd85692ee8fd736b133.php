<?php $__env->startSection('title'); ?>
    <?php echo app('translator')->get('translation.support'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('css'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(assetURL('css_v2/chat.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="chat-main-row card-bg px-4">
        <div class="menu-ul-chat d-flex align-items-center justify-content-between w-100 mb-3">
            <p class="fs-24 fw-medium text-blue mb-0"> <?php echo e(__('translation.chats')); ?>

                (<span class="total-chats-count"><?php echo e($chats_count); ?></span>)
            </p>
            <a class="d-block d-lg-none flex-shrink-0 btn border-0" href="#chat_sidebar" aria-label="toggle users view menu"
                id="mobile_btn_chat"></a>
        </div>
        <div class="chat-main-wrapper">
            <div class="col-lg-3 message-view chat-profile-view chat-sidebar" id="chat_sidebar">
                <div class="sidebar-message mess-slimscroll">
                    <ul id="chat-list">
                        <?php if($lastUserId): ?>
                            <li class="li-search position-sticky top-0 z-1">
                                <fieldset class="position-relative mb-2 pb-1">
                                    <legend class="sr-only">Search input</legend>
                                    <input type="search" class="form-control" id="inputSearchTable" autocomplete="off"
                                        placeholder="<?php echo e(__('translation.Search')); ?>" aria-label="Search input"
                                        name="inputSearchTable">
                                    <i class="icon-search-i position-absolute top-50 translate-middle-y ms-3"></i>
                                </fieldset>
                            </li>
                        <?php else: ?>
                            <li>
                                <p class="empty-mess pt-4 px-3">
                                    <?php echo e(__('translation.No chats')); ?>

                                </p>
                            </li>
                        <?php endif; ?>
                        <?php if($chats): ?>
                            <?php $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($chat['other_user_id']): ?>
                                    <li class="<?php echo e($chat['unread_message_count'] > 0 ? 'unread' : ''); ?>">
                                        <a href="#" onclick="getChat(this)"
                                            data-user-id="<?php echo e($chat['other_user_id']); ?>"
                                            data-channel="<?php echo e($chat['channel']); ?>">
                                            <span class="chat-avatar-sm user-img"><img
                                                    src="<?php echo e(imageUrl($chat['other_user']['avatar_url'])); ?>" alt=""
                                                    class="rounded-circle"><span
                                                    class="status <?php echo e($chat['other_user']['active_now'] ? 'online' : 'offline'); ?>">
                                                </span></span>
                                            <div class="badge-text-mess d-flex gap-2 flex-column">
                                                <span> <?php echo e($chat['other_user']['name']); ?> </span>
                                                <span class="line-clamp text-light-blue fs-12 fw-medium">
                                                    <?php echo e($chat['message']); ?>

                                                </span>
                                                <span
                                                    class="fs-12 text-brown fw-normal"><?php echo e($chat['created_since']); ?></span>
                                            </div>
                                            <?php if($chat['unread_message_count']): ?>
                                                <span
                                                    class="badge rounded-pill bg-gold ms-auto"><?php echo e($chat['unread_message_count']); ?></span>
                                            <?php endif; ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-lg-9 message-view chat-view">
                <?php if($lastUserId): ?>
                    <div class="chat-window">
                        <div class="chat-contents">
                            <div class="chat-content-wrap">
                                <div class="chat-wrap-inner">
                                    <?php if($lastUserId): ?>
                                        <div class="chat-box">
                                            <div class="chats" id="chat-container"
                                                data-channel="channel_<?php echo e($lastUserId); ?>">
                                                <?php $__currentLoopData = $chatsGroupedByDate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date => $chatGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="chat-line">
                                                        <span
                                                            class="chat-date"><?php echo e(date('Y/m/d', strtotime($date))); ?></span>
                                                    </div>

                                                    <?php $__currentLoopData = $chatGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php if($chat->sender->user_type != App\Enums\UserTypesEnum::USER->value): ?>
                                                            <div class="chat chat-right">
                                                                <div class="chat-avatar">
                                                                    <a class="avatar">
                                                                        <img alt="Jennifer Robinson"
                                                                            src="<?php echo e(imageUrl($chat->sender->avatar_url)); ?>"
                                                                            class="img-fluid rounded-circle">
                                                                    </a>
                                                                </div>
                                                                <div class="chat-body">
                                                                    <div class="chat-bubble">
                                                                        <div class="chat-content d-flex gap-2">
                                                                            <div>
                                                                                <h6 class="fs-16 fw-medium text-blue">
                                                                                    <?php echo e($chat->sender->name); ?></h6>
                                                                                <p><?php echo e($chat->message); ?></p>
                                                                            </div>
                                                                            <span
                                                                                class="chat-time"><?php echo e($chat->created_at->format('H:i')); ?>

                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <div class="chat chat-left">
                                                                <div class="chat-body">
                                                                    <div class="chat-bubble">
                                                                        <div class="chat-content d-flex gap-2">
                                                                            <div>
                                                                                <p><?php echo e($chat->message); ?></p>
                                                                            </div>
                                                                            <span class="chat-time">
                                                                                <span
                                                                                    class="seen-message <?php echo e($chat->is_read ? 'active' : ''); ?>"></span>
                                                                                <span><?php echo e($chat->created_at->format('H:i')); ?></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <?php if(isset($chat)): ?>
                            <input type="hidden" name="sender_id" id="sender_id"
                                value="<?php echo e($chat['sender_id'] == user_id() ? $chat['receiver_id'] : $chat['sender_id']); ?>">
                            <input type="hidden" name="admin_id" value="<?php echo e(user_id()); ?>" id="admin_id">
                            <input type="hidden" name="receiver_id"
                                value="<?php echo e($chat['receiver_id'] == user_id() ? $chat['sender_id'] : $chat['receiver_id']); ?>">
                        <?php endif; ?>
                        <div class="chat-footer">
                            <div class="message-bar">
                                <div class="message-inner">
                                    <?php if($lastUserId): ?>
                                        <div class="message-area position-relative">
                                            <emoji-picker id="emoji-picker"></emoji-picker>

                                            <div class="input-group bg-white rounded-2">
                                                <button id="emoji-picker-button" type="button"
                                                    aria-label="Open emoji picker" aria-haspopup="dialog"
                                                    aria-expanded="false"
                                                    class="emoji-picker-btn btn bg-white rounded-2"></button>
                                                <textarea class="form-control bg-white border-0" placeholder="اكتب الرسالة..." id="chat-input"></textarea>
                                                <button id="send-button-chat" class="sub-mess-chat btn bg-white rounded-2"
                                                    type="button" aria-label="submit message chat"></button>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-lg-9">
                        <?php echo e(__('translation.No chats')); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script>
        var chatContainerScroll = $(".chat-wrap-inner");
        chatContainerScroll.scrollTop(chatContainerScroll.prop("scrollHeight"));
        window.scrollTo({
            top: document.body.scrollHeight, // Scroll to the bottom of the page
            behavior: 'smooth' // Optional: Adds smooth scrolling
        });
        $("#chat-container").animate({
            scrollTop: $("#chat-container")[0].scrollHeight
        }, 500);
    </script>
    <script>
        var userId = <?php echo e(user_id()); ?>; // This will make the userId available in your JavaScript
        var authUserId = <?php echo e(user_id()); ?>; // This will make the userId available in your JavaScript
    </script>

    <!-- Script that defines the getChat function -->
    <script>
        var channel_from_get = '<?php echo e(request()->channel); ?>';
        console.log(channel_from_get);
        if (channel_from_get.trim()) { // التأكد من أن القناة ليست فارغة
            var chatContainer = $('#chat-list a[data-channel="' + channel_from_get + '"]');
            chatContainer.click()
        }
        $("#chat-container").animate({
            scrollTop: $("#chat-container")[0].scrollHeight
        }, 500);
        // Ensure the getChat function is defined in the script
        function getChat(e) {
            let channel = $(e).data('channel');
            let userId = channel.split('_')[1];
            $('input[name="receiver_id"]').val(userId);
            $('#chat-container').data('channel', channel);
            console.log($('#chat-container').data('channel')); // Check
            console.log('User ID:', userId);
            $.ajax({
                url: '/admin/chat/' + channel, // Make sure the URL is correct
                method: 'GET',
                success: function(data) {
                    console.log('Chat data received:', data);
                    updateChatBox(data); // Call function to update the UI with chat data
                    if ($('.chat-wrap-inner').length) {
                        window.scrollTo({
                            top: document.body.scrollHeight, // Scroll to the bottom of the page
                            behavior: 'smooth' // Optional: Adds smooth scrolling
                        });
                        var chatContainerScroll = $(".chat-wrap-inner");
                        chatContainerScroll.scrollTop(chatContainerScroll.prop("scrollHeight"));
                    }
                    var channelSelector = 'a[data-channel="' + channel + '"]';
                    var badge = $(channelSelector).find('.badge');
                    badge.text('');

                },
                error: function(err) {
                    console.error('Error fetching chat:', err);
                }
            });
        }



        function updateChatBox(chats) {
            let chatContainer = $('#chat-container');
            console.log(chatContainer.data('channel'));
            chatContainer.empty(); // Clear current chats

            // Loop through each date group and render the chat
            for (let date in chats) {
                let chatGroup = chats[date];

                // Append the date line
                chatContainer.append(`<div class="chat-line"><span class="chat-date">${date}</span></div>`);

                // Loop through each chat in the group and render the chat
                chatGroup.forEach(function(chat) {
                    let chatClass = chat.sender_id === userId ? 'chat-right' : 'chat-left';
                    let avatarUrl = chat.sender.avatar_url || 'img_v2/user.png';
                    let senderName = chat.sender.name;
                    let otherUserId = chat.receiver_id;
                    let message = chat.message;
                    let date = new Date(chat.created_at);
                    date.setHours(date.getHours() - 2); // Subtract 2 hours

                    let time = date.toLocaleTimeString([], {
                        hour: '2-digit',
                        minute: '2-digit'
                    });


                    let authUserId = <?php echo e(auth()->id()); ?>; // Get the authenticated user's ID

                    let chatHtml = `
                <div class="chat ${chatClass}">
                    ${chat.sender_id === authUserId ? `
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            <div class="chat-avatar">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                    <a class="avatar">

                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                <!-- Only display avatar if sender is the authenticated user -->
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        <img alt="${senderName}" src="${avatarUrl}" class="img-fluid rounded-circle">
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </a>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        </div>
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        ` : ''}
                    <div class="chat-body">
                        <div class="chat-bubble">
                            <div class="chat-content d-flex gap-2">
                                <div>
                                   ${chat.sender_id === authUserId ? ` <h6 class="fs-16 fw-medium text-blue">${senderName}</h6> ` : ''}
                                    <p>${message}</p>
                                </div>
                                <span class="chat-time">${time}</span>
                            </div>
                        </div>
                    </div>
                </div>
                `;

                    chatContainer.append(chatHtml);
                });
            }
        }
    </script>

    <script>
        let $messSlimScrolls = $('.mess-slimscroll');
        if ($messSlimScrolls.length > 0) {
            $messSlimScrolls.slimScroll({
                height: 'auto',
                width: '100%',
                position: 'right',
                size: '7px',
                color: '#ccc',
                wheelStep: 10,
                touchScrollStep: 100
            });
        }
    </script>
    <script type="module">
        // Import the Emoji Picker Element
        import 'https://cdn.jsdelivr.net/npm/emoji-picker-element@1.7.0/index.js';

        // DOM Elements
        const chatContainer = $('#chat-container');
        const chatInput = $('#chat-input');
        const emojiPickerButton = $('#emoji-picker-button');
        const emojiPicker = $('#emoji-picker');
        const sendButton = $('#send-button-chat');

        // Toggle Emoji Picker
        emojiPickerButton.on('click', () => {
            emojiPicker.toggleClass('visible');
        });

        // Insert Emoji into Input
        emojiPicker.on('emoji-click', (event) => {
            const emoji = event.detail.unicode;
            chatInput.val(chatInput.val() + emoji);
        });

        // Send Message
        sendButton.on('click', () => {
            const message = chatInput.val().trim();
            if (message) {
                addMessage(message, 'admin', userName);
                chatInput.val('');
            }
        });
        chatInput.keypress(function(event) {
            if (event.which === 13 && !event.shiftKey) {
                const message = chatInput.val().trim();
                if (message) {
                    addMessage(message, 'admin', userName);
                    chatInput.val('');
                }

            }
        });

        function getFormattedTime() {
            return new Intl.DateTimeFormat('en-GB', {
                timeZone: 'Africa/Cairo', // ضبط المنطقة الزمنية الصحيحة
                hour: '2-digit',
                minute: '2-digit',
                hour12: false // استخدام نظام 24 ساعة
            }).format(new Date());
        }


        let IsAddImg = false;
        let userName = '<?php echo e(user()->name); ?>';
        let adminId = '<?php echo e(user_id()); ?>';
        // Add Message to Chat
        function addMessage(message, sender, senderName) {
            if (sender == 'admin') {
                saveChat(message);
            }
            let messType = '';
            let imgUrl = "<?php echo e(imageUrl(user()->avatar_url)); ?>";
            let imgBox = "";
            if (sender == "admin" || sender == "employee") {
                console.log(sender);
                imgBox = `<div class="chat-avatar">
                                <a href="profile.html" class="avatar">
                                    <img alt="Jennifer Robinson" src="${imgUrl}" class="img-fluid rounded-circle">
                                </a>
                            </div>`;
                messType = `<div class="chat chat-right">
                                ${imgBox}
                                <div class="chat-body">
                                    <div class="chat-bubble">
                                        <div class="chat-content d-flex gap-2">
                                            <div>
                                                <h6 class="fs-16 fw-medium text-blue">${senderName}</h6>
                                                <p>${message}</p>
                                            </div>
                                            <span class="chat-time">${getFormattedTime()}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                IsAddImg = false;
            } else {
                messType = `<div class="chat chat-left">
                                <div class="chat-body">
                                    <div class="chat-bubble">
                                        <div class="chat-content d-flex gap-2">
                                            <div>
                                                <p>${message}</p>
                                            </div>
                                            <span class="chat-time">
                                                <span class="seen-message"></span>
                                                <span>${getFormattedTime()}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                IsAddImg = true;
            }

            $('#chat-container').append(messType);
            if ($('.chat-wrap-inner').length) {
                window.scrollTo({
                    top: document.body.scrollHeight, // Scroll to the bottom of the page
                    behavior: 'smooth' // Optional: Adds smooth scrolling
                });
            }
        }


        // Example: Add a welcome message for Testin
        $(document).mouseup(function(event) {
            let eventTarget = $(event.target);
            if (!eventTarget.hasClass('visible') && !eventTarget.hasClass('emoji-picker-btn')) {
                emojiPicker.removeClass('visible');
            }
        });

        function saveChat(message) {
            let receiverId = $('input[name="receiver_id"]').val();
            let channel = $('#chat-container').data('channel');
            console.log('Saving chat with receiver ID:', receiverId);
            $.ajax({
                url: '/admin/chat/save',
                method: 'POST',
                data: {
                    message: message,
                    channel: channel,
                    _token: '<?php echo e(csrf_token()); ?>'
                },
                success: function(data) {
                    console.log('Chat saved:', data);
                    if ($('.chat-wrap-inner').length) {
                        window.scrollTo({
                            top: document.body.scrollHeight, // Scroll to the bottom of the page
                            behavior: 'smooth' // Optional: Adds smooth scrolling
                        });
                    }
                    let chatList = $('#chat-list');
                    let existingChatItem = chatList.find(`li a[data-channel="${channel}"]`).closest('li');

                    existingChatItem.insertAfter($('.li-search'));
                    existingChatItem.find('.line-clamp').text(data.message);
                    existingChatItem.find('.fs-12.text-brown').text('Just now');
                    var chatContainerScroll = $(".chat-wrap-inner");
                    chatContainerScroll.scrollTop(chatContainerScroll.prop("scrollHeight"));
                },
                error: function(err) {
                    console.error('Error saving chat:', err);
                }
            });
        }
        if ($('.chat-wrap-inner').length) {
            window.scrollTo({
                top: document.body.scrollHeight, // Scroll to the bottom of the page
                behavior: 'smooth' // Optional: Adds smooth scrolling
            });
        }
        $(document).ready(function() {
            $('#inputSearchTable').on('keyup', function() {
                let value = $(this).val().toLowerCase();

                $('#chat-list li:not(.li-search)').each(function() {
                    let userName = $(this).find('.badge-text-mess span:first-child').text()
                        .toLowerCase();
                    let lastMessage = $(this).find('.line-clamp').text().toLowerCase();

                    if (userName.includes(value) || lastMessage.includes(value)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Enable pusher logging - don't include this in production
            let senderId = $("#sender_id").val();
            let authUserId = $("#admin_id").val();
            Pusher.logToConsole = true;

            var pusher = new Pusher('87cdec77d0436c9d4849', {
                cluster: 'eu'
            });
            if ($('#chat-container').data('channel')) {
                let this_active_channel = $('#chat-container').data('channel');

            }
            let this_active_channel = $('#chat-container').data('channel');
            var channel = pusher.subscribe(this_active_channel);
            channel.bind('App\\Events\\MessageSent', function(data) {
                let total_chats_count = $('.total-chats-count').text();
                if (total_chats_count == 0 || total_chats_count == "0") {
                    window.location.reload();
                }
                let active_channel = $('#chat-container').data('channel');
                console.log(active_channel);
                console.log("Received message data: ", data);
                console.log(data.channel, active_channel);
                console.log(data.channel == active_channel && data.sender_id != authUserId);
                if (data.channel == active_channel && data.sender_id != authUserId) {
                    console.log(data.sender_id);
                    let sender = data.sender_type;
                    addMessage(data.message, sender, data.sender);
                    // Assuming the message data includes message, userId, and adminId
                }
                if (data.sender_id != authUserId) {
                    addMessageToList(data.message, data
                        .channel, data); // For example, receiver as userId and sender as adminId
                }
            });
        });

        function getFormattedTime() {
            return new Intl.DateTimeFormat('en-GB', {
                timeZone: 'Africa/Cairo', // ضبط المنطقة الزمنية الصحيحة
                hour: '2-digit',
                minute: '2-digit',
                hour12: false // استخدام نظام 24 ساعة
            }).format(new Date());
        }


        let IsAddImg = false;
        let userName = '<?php echo e(user()->name); ?>';
        let adminId = '<?php echo e(user_id()); ?>';
        // Add Message to Chat
        function addMessageToList(message, channel, data = null) {
            // Find the <a> tag with the correct data-channel attribute
            var channelSelector = 'a[data-channel="' + channel + '"]';

            //     // If the channel doesn't exist in the list, add a new li item
            //     // if ($(channelSelector).length == 0) {
            //     let newListItem = `
        //     <li class="li-chat">
        //         <a href="#" onclick="getChat(this)" data-channel="${channel}">
        //             <span class="chat-avatar-sm user-img">
        //                 <img src="${data.other_user_image}" alt="User Avatar" class="rounded-circle">
        //                 <span class="status online"></span>
        //             </span>
        //             <div class="badge-text-mess d-flex gap-2 flex-column">
        //                 <span>${data.sender}</span>
        //                 <span class="line-clamp text-light-blue fs-12 fw-medium">${message}</span>
        //                 <span class="fs-12 text-brown fw-normal">Just now</span>
        //             </div>
        //         </a>
        //     </li>
        // `;
            //     $('#chat-list').find('.li-search').after(newListItem);

            // }

            // Find the badge element (if it exists)
            var badge = $(channelSelector).find('.badge');
            var count = 0; // Default count value

            if (badge.length > 0) {
                // Get the current badge count, and make sure it's a number
                count = parseInt(badge.text(), 10) || 0; // Fallback to 0 if it's NaN or empty
            }

            // Increment the count
            count++;

            // If badge does not exist, create it and append it
            if (badge.length === 0) {
                var badgeElement = $('<span>', {
                    class: 'badge rounded-pill bg-gold ms-auto',
                    text: count
                });
                $(channelSelector).append(badgeElement); // Append the badge to the <a> element
            } else {
                // Update the badge count
                badge.text(count);
            }

            console.log('Updated Count:', count);

            // Update the message preview in the line-clamp span
            $(channelSelector).find('.line-clamp').text(message);
            $(channelSelector).find('.text-brown').text("<?php echo e(__('translation.just_now')); ?>");

            // Reposition the message item to appear after the search item
            let chatList = $('#chat-list');
            let existingChatItem = chatList.find(`li a[data-channel="${channel}"]`).closest('li');
            existingChatItem.insertAfter($('.li-search'));
        }



        function addMessage(message, sender, senderName = userName) {
            console.log(sender);
            // if (sender == 'admin') {
            //     saveChat(message);
            // }
            let messType = '';
            let imgUrl = "<?php echo e(imageUrl(user()->avatar_url)); ?>";
            let imgBox = "";
            if (sender == "admin" || sender == "employee") {
                imgBox = `<div class="chat-avatar">
                                <a href="profile.html" class="avatar">
                                    <img alt="Jennifer Robinson" src="${imgUrl}" class="img-fluid rounded-circle">
                                </a>
                            </div>`;
                messType = `<div class="chat chat-right">
                                ${imgBox}
                                <div class="chat-body">
                                    <div class="chat-bubble">
                                        <div class="chat-content d-flex gap-2">
                                            <div>
                                                <h6 class="fs-16 fw-medium text-blue">${senderName}</h6>
                                                <p>${message}</p>
                                            </div>
                                            <span class="chat-time">${getFormattedTime()}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                IsAddImg = false;
            } else {
                messType = `<div class="chat chat-left">
                                <div class="chat-body">
                                    <div class="chat-bubble">
                                        <div class="chat-content d-flex gap-2">
                                            <div>
                                                <p>${message}</p>
                                            </div>
                                            <span class="chat-time">
                                                <span class="seen-message"></span>
                                                <span>${getFormattedTime()}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                IsAddImg = true;
            }
            console.log(messType);
            $('#chat-container').append(messType);
            if ($('.chat-wrap-inner').length) {
                window.scrollTo({
                    top: document.body.scrollHeight, // Scroll to the bottom of the page
                    behavior: 'smooth' // Optional: Adds smooth scrolling
                });
            }

        }
        window.scrollTo({
            top: document.body.scrollHeight, // Scroll to the bottom of the page
            behavior: 'smooth' // Optional: Adds smooth scrolling
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\mahmo\Herd\eatikaf\resources\views/admin/chat/index.blade.php ENDPATH**/ ?>