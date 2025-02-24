/*
Author       : Dreamguys
Template Name: PreClinic - Medical and Hospital Admin Template
Version      : 1.0
*/
$(document).ready(function ($) {

    // Variables declarations
    var $wrapper = $('.main-wrapper');
    var $pageWrapper = $('.page-wrapper');
    var $slimScrolls = $('.slimscroll');
    var $sidebarOverlay = $('.sidebar-overlay');

    // Sidebar
    var Sidemenu = function () {
        this.$menuItem = $('#sidebar-menu a');
    };

    function init() {
        var $this = Sidemenu;
        $('#sidebar-menu a').on('click', function (e) {
            if ($(this).parent().hasClass('submenu')) {
                e.preventDefault();
            }
            if (!$(this).hasClass('subdrop')) {
                $('ul', $(this).parents('ul:first')).slideUp(350);
                $('a', $(this).parents('ul:first')).removeClass('subdrop');
                $(this).next('ul').slideDown(350);
                $(this).addClass('subdrop');
            } else if ($(this).hasClass('subdrop')) {
                $(this).removeClass('subdrop');
                $(this).next('ul').slideUp(350);
            }
        });
        $('#sidebar-menu ul li.submenu a.active').parents('li:last').children('a:first').addClass('active').trigger('click');
    }
    // Sidebar Initiate
    init();

    // Sidebar overlay
    function sidebar_overlay($target) {
        if ($target.length) {
            $target.toggleClass('opened');
            $sidebarOverlay.toggleClass('opened');
            $('html').toggleClass('menu-opened');
            $sidebarOverlay.attr('data-reff', '#' + $target[0].id);
        }
    }

    // Mobile menu sidebar overlay
    $(document).on('click', '#mobile_btn', function () {
        var $target = $($(this).attr('href'));
        sidebar_overlay($target);
        $wrapper.toggleClass('slide-nav');
        $('#chat_sidebar').removeClass('opened');
        return false;
    });

    // Chat sidebar overlay
    $(document).on('click', '#task_chat', function () {
        var $target = $($(this).attr('href'));
        console.log($target);
        sidebar_overlay($target);
        return false;
    });

    // Sidebar overlay reset
    $sidebarOverlay.on('click', function () {
        var $target = $($(this).attr('data-reff'));
        if ($target.length) {
            $target.removeClass('opened');
            $('html').removeClass('menu-opened');
            $(this).removeClass('opened');
            $wrapper.removeClass('slide-nav');
        }
        return false;
    });

    // Select 2
    if ($('.select').length > 0) {
        $('.select').select2({
            minimumResultsForSearch: -1,
            width: '100%'
        });
    }

    // Right Sidebar Scroll
    if ($('#msg_list').length > 0) {
        $('#msg_list').slimscroll({
            height: '100%',
            color: '#878787',
            disableFadeOut: true,
            borderRadius: 0,
            size: '4px',
            alwaysVisible: false,
            touchScrollStep: 100
        });
        var msgHeight = $(window).height() - 124;
        $('#msg_list').height(msgHeight);
        $('.msg-sidebar .slimScrollDiv').height(msgHeight);
        $(window).resize(function () {
            var msgrHeight = $(window).height() - 124;
            $('#msg_list').height(msgrHeight);
            $('.msg-sidebar .slimScrollDiv').height(msgrHeight);
        });
    }

    // Left Sidebar Scroll
    if ($slimScrolls.length > 0) {
        $slimScrolls.slimScroll({
            height: 'auto',
            width: '100%',
            position: 'right',
            size: '7px',
            color: '#ccc',
            wheelStep: 10,
            touchScrollStep: 100
        });
        var wHeight = $(window).height() - 85;
        $slimScrolls.height(wHeight);
        $('.sidebar .slimScrollDiv').height(wHeight);
        $(window).resize(function () {
            var rHeight = $(window).height() - 85;
            $slimScrolls.height(rHeight);
            $('.sidebar .slimScrollDiv').height(rHeight);
        });
    }

    // Page wrapper height
    var pHeight = $(window).height();
    $pageWrapper.css('min-height', pHeight);
    $(window).resize(function () {
        var prHeight = $(window).height();
        $pageWrapper.css('min-height', prHeight);
    });

    // Datetimepicker
    if ($('.datetimepicker').length > 0) {
        $('.datetimepicker').datetimepicker({
            format: 'YYYY-MM-DD'  // This ensures the full date (year-month-day) is returned
        });
    }

    // Datatable
    if ($('.datatable').length > 0) {
        const table = $('.datatable').DataTable({
            language: {
                info: "تم عرض _START_ إلى _END_ من أصل _TOTAL_", // Custom info text
                infoEmpty: "لا توجد بيانات للعرض",
                infoFiltered: "(تمت التصفية من _MAX_ إجمالي الإدخالات)",
                zeroRecords: 'لم يتم العثور على سجلات مطابقة',
                loadingRecords: "جارٍ التحميل...",
                processing: "يرجى الانتظار...",
                paginate: {
                    first: "الأول",
                    last: "الأخير",
                    next: "n",
                    previous: "p"
                },
                lengthMenu: "_MENU_"
            },
            lengthMenu: [5, 10, 15, 20],
            pageLength: 5,
            pagingType: "simple_numbers",  // Display both numbers and previous/next

            // Your DataTable options here
            initComplete: function (settings, json) {
                $('#DataTables_Table_0_info').before($("#DataTables_Table_0_length"));
            }
        });

        // Custom filter functionality
        $('#submitFilterTable').on('click', function () {
            var searchValue = $('#inputSearchTable').val();
            var selectValue = $('#selectFilterTable').val();

            // Apply custom search
            table
                .columns(0)
                .search(searchValue) // Search in the first column
                .columns(6)
                .search(selectValue) // Filter by the 7 column
                .draw();
        });
    }

    // Bootstrap Tooltip
    if ($('[data-toggle="tooltip"]').length > 0) {
        $('[data-toggle="tooltip"]').tooltip();
    }

    // Lightgallery
    if ($('#lightgallery').length > 0) {
        $('#lightgallery').lightGallery({
            thumbnail: true,
            selector: 'a'
        });
    }

    // Incoming call popup
    if ($('#incoming_call').length > 0) {
        $('#incoming_call').modal('show');
    }

    // Summernote
    if ($('.summernote').length > 0) {
        $('.summernote').summernote({
            height: 200,
            minHeight: null,
            maxHeight: null,
            focus: false
        });
    }

    // Check all email
    $(document).on('click', '#check_all', function () {
        $('.checkmail').click();
        return false;
    });
    if ($('.checkmail').length > 0) {
        $('.checkmail').each(function () {
            $(this).on('click', function () {
                if ($(this).closest('tr').hasClass('checked')) {
                    $(this).closest('tr').removeClass('checked');
                } else {
                    $(this).closest('tr').addClass('checked');
                }
            });
        });
    }

    // Mail important
    $(document).on('click', '.mail-important', function () {
        $(this).find('i.fa').toggleClass('fa-star').toggleClass('fa-star-o');
    });

    // Dropfiles
    if ($('#drop-zone').length > 0) {
        var dropZone = document.getElementById('drop-zone');
        var uploadForm = document.getElementById('js-upload-form');
        var startUpload = function (files) {
            console.log(files);
        };
        uploadForm.addEventListener('submit', function (e) {
            var uploadFiles = document.getElementById('js-upload-files').files;
            e.preventDefault();
            startUpload(uploadFiles);
        });
        dropZone.ondrop = function (e) {
            e.preventDefault();
            this.className = 'upload-drop-zone';
            startUpload(e.dataTransfer.files);
        };
        dropZone.ondragover = function () {
            this.className = 'upload-drop-zone drop';
            return false;
        };
        dropZone.ondragleave = function () {
            this.className = 'upload-drop-zone';
            return false;
        };
    }

    // Small Sidebar
    if (screen.width >= 992) {
        $(document).on('click', '#toggle_btn', function () {
            if ($('body').hasClass('mini-sidebar')) {
                $('body').removeClass('mini-sidebar');
                $('.subdrop + ul').slideDown();
            } else {
                $('body').addClass('mini-sidebar');
                $('.subdrop + ul').slideUp();
            }
            return false;
        });
        $(document).on('mouseover', function (e) {
            e.stopPropagation();
            if ($('body').hasClass('mini-sidebar') && $('#toggle_btn').is(':visible')) {
                var targ = $(e.target).closest('.sidebar').length;
                if (targ) {
                    $('body').addClass('expand-menu');
                    $('.subdrop + ul').slideDown();
                } else {
                    $('body').removeClass('expand-menu');
                    $('.subdrop + ul').slideUp();
                }
                return false;
            }
        });
    }
});
