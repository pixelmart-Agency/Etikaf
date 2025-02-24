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
			width: '100%',
			language: 'ar', // Set Arabic as the language
		});
	}
	let arrRoundomColor = ["#35685F", "#35685F", "#86A49F", "#1E874C", "#FFC233", "#F53D6B", "#8A6100", "#8A0023", "#04053F", "#7E0685"]
	// Object to store colors for each option
	const optionColors = {};

	// Function to generate a consistent color for each option
	function getColorForOption(optionId) {
		if (!optionColors[optionId]) {
			// Assign a random color and store it for this option
			const randomColor = arrRoundomColor[Math.floor(Math.random() * 10)];
			optionColors[optionId] = randomColor;
		}
		return optionColors[optionId];
	}

	function formatStateImg(state) {

		if (!state.id) {
			return state.text;
		}
		let slice = state.text.trim().slice(0, 1);
		// Get a consistent color for this option
		const color = getColorForOption(state.id);
		let $state = $(
			'<span class="d-flex align-items-center gap-3"> <i class="radio-i"></i> <span class="d-flex align-items-center justify-content-center rounded-circle fs-12 fw-medium text-white" style="width:24px;height: 24px;background-color:' + color + '">' + slice + '</span>' + state.text + '</span>'
		);
		return $state;

	}
	function formatStateEmployee(state) {

		if (!state.id) {
			return state.text;
		}

		let $state = $(
			'<span class="rounded-2" style="display:inline-block; padding:2px 12px; color:#35685F; background-color: #EBF0EF;">   ' + state.text + '</span>'
		);
		return $state;

	}

	if ($('#selectForward').length > 0) {
		$('#selectForward').select2({
			width: '100%',
			templateResult: formatStateImg,
			templateSelection: formatStateImg,
			language: {
				noResults: function () {
					return "لا توجد نتائج مخصصة.";
				},
				searching: function () {
					return "جاري البحث...";
				}
			},
		});
		// Add placeholder to the search input
		$('#selectForward').on('select2:open', function () {
			$('.select2-search__field').attr('placeholder', 'يبحث...');
		});
	}

	if ($('#selectEmployeePermissions').length > 0) {
		$('#selectEmployeePermissions').select2({
			width: '100%',
			templateResult: formatStateEmployee,
			templateSelection: formatStateEmployee,
			language: {
				noResults: function () {
					return "لا توجد نتائج مخصصة.";
				},
				searching: function () {
					return "جاري البحث...";
				}
			},
			closeOnSelect: false, // Prevent dropdown from closing on selection
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
		$('.datetimepicker').datepicker({
			language: "ar",
			todayHighlight: true
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
			var selectValue = $('#selectFilterTable');

			if (selectValue.length) {
				selectValue = selectValue.val();
			} else {
				selectValue = '';
			}

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

	if ($(".tab-container").length) {

		document.querySelectorAll('.tab-container .tab').forEach((tab) => {
			tab.addEventListener('click', () => {
				const tabId = tab.id;
				// Update active tab
				document.querySelectorAll('.tab-container .tab').forEach((t) => {
					t.setAttribute('aria-selected', 'false');
					t.classList.remove('active');
					t.setAttribute('tabindex', '-1');
				});
				tab.setAttribute('aria-selected', 'true');
				tab.classList.add('active');
				tab.setAttribute('tabindex', '0');

				// Update active panel
				document.querySelectorAll('.tab-container .panel').forEach((panel) => {
					panel.classList.remove('active');
				});
				const activePanel = document.querySelector(`.tab-container [aria-labelledby="${tabId}"]`);
				activePanel.classList.add('active');
			});
		});

	}

	$('.card-create-survey').on('change', ".select-type-que", function () {
		let thisElement = $(this).parents('.ques-types');

		if (this.value == '1') {
			thisElement.removeClass("ques-types-active")
		}
		else {
			thisElement.addClass("ques-types-active");
		}

		if (this.value == '2') {
			$(this).parents('.que-body').find('> .answer-options').slideDown("slow");
		}
		else {
			$(this).parents('.que-body').find('> .answer-options').slideUp("slow");
		}

	});

	let i = 2;
	let n = 5;
	var cardGrayBgId = ''
	$('.card-create-survey').on('click', ".que-trash", function () {
		let cardGrayBg = $(this).parents('.card-gray-bg');
		cardGrayBgId = cardGrayBg.attr('id');
	})
	$('#remove-que-modal').on('click', "#btn-remove-que", function () {
		$("#" + cardGrayBgId + "").remove();
		$(this).prev('.close').click();
		cardGrayBgId = '';
	})

	$('.card-create-survey').on('click', ".btnDeleAnsOptions", function () {
		$(this).parent().parent('.form-group').remove();
	})

	$('#btnAddNewQue').on('click', function () {
		let queHTML = `    <div class="card-gray-bg px-4 pb-4 dynamicallyAdded" id="dynamicallyAdded-${i}">
                                        <div class="que-head d-flex align-items-center gap-3 flex-wrap-reverse justify-content-between">
                                            <div class="que-h-right d-flex align-items-center">
                                                <span class="que-menu-icon" aria-hidden="true"></span>
                                                <span class="que-inc" aria-hidden="true"></span>
                                                <h4 class="block-title fs-18 mb-0 ms-3">صيغة السؤال</h4>
                                            </div>
                                            <div class="que-h-left d-flex align-items-center gap-3 ms-auto">
                                                <button type="button" class="btn que-trash" data-toggle="modal"
                                                data-target="#remove-que-modal"></button>
                                                <button type="button" class="btn que-arrow" data-toggle="collapse"
                                                    data-target="#collapseExample${i}" aria-expanded="true"
                                                    aria-controls="collapseExample${i}">
                                                </button>
                                            </div>
                                        </div>
                                        <div class="que-body border-top pt-4 mt-3 collapse show" id="collapseExample${i}">
                                            <fieldset class="mb-3 que-name">
                                                <label for="nameQue${i}" class="block-title fs-14">السؤال</label>
                                                <input type="text" id="nameQue${i}" name="nameQue${i}" placeholder="السؤال"
                                                    class="form-control bg-white">
                                            </fieldset>
                                            <fieldset class="ques-types d-flex align-items-center gap-3 overflow-hidden position-relative">
                                                <div class="form-group mb-0 form-typeQue flex-shrink-0">
                                                    <label for="typeQue${i}" class="block-title fs-14">نوع السؤال</label>
                                                    <select class="select floating bg-white select-type-que" dir="rtl" id="typeQue${i}"
                                                        name="typeQue${i}">
                                                        <option value="1" selected>مقالي</option>
                                                        <option value="2">اختيار من متعدد</option>
                                                        <option value="3">تقييم</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-0 form-typeAns flex-shrink-0">
                                                    <label for="typeAnswer${i}" class="block-title fs-14">نوع
                                                        الاجابة</label>
                                                    <select class="select floating bg-white" dir="rtl" id="typeAnswer${i}"
                                                        name="typeAnswer${i}">
                                                        <option value="1" selected>اجباري</option>
                                                        <option value="2">اختياري</option>
                                                    </select>
                                                </div>
                                                <div class="form-group mb-0 form-maxNum">
                                                    <label for="maxNumCharacters${i}" class="block-title fs-14">العدد
                                                        الاقصى للحروف</label>
                                                    <div class="data-icon" data-holder="حرف">
                                                        <input type="text" id="maxNumCharacters${i}"
                                                            name="maxNumCharacters${i}" placeholder="500"
                                                            class="form-control bg-white">
                                                    </div>
                                                </div>
                                            </fieldset>
											<div class="answer-options pt-4" style="display: none;">
                                                <h2 class="fs-18 fw-medium mb-4">خيارات الاجوبة</h2>
                                                <fieldset class="answer-options-groups d-flex align-items-center flex-wrap">
    
                                                    <div class="form-group mb-3 w-50 px-2">
                                                        <label for="inputAnsOptions${i}-1" class="block-title fs-14">عنوان
                                                            الاجابة</label>
                                                        <div class="delete-icon position-relative">
                                                            <input type="text" id="inputAnsOptions${i}-1"
                                                                name="inputAnsOptions${i}-1" placeholder="صيغة اختيار الاجابة"
                                                                class="form-control bg-white">
                                                            <button type="button"
                                                                class="main-btn p-0 border-0 bg-white fs-14 text-red position-absolute end-0 top-50 translate-middle-y me-3 btnDeleAnsOptions">حذف</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 w-50 px-2">
                                                        <label for="inputAnsOptions${i}-2" class="block-title fs-14">عنوان
                                                            الاجابة</label>
                                                        <div class="delete-icon position-relative">
                                                            <input type="text" id="inputAnsOptions${i}-2"
                                                                name="inputAnsOptions${i}-2" placeholder="صيغة اختيار الاجابة"
                                                                class="form-control bg-white">
                                                            <button type="button"
                                                                class="main-btn p-0 border-0 bg-white fs-14 text-red position-absolute end-0 top-50 translate-middle-y me-3 btnDeleAnsOptions">حذف</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 w-50 px-2">
                                                        <label for="inputAnsOptions${i}-3" class="block-title fs-14">عنوان
                                                            الاجابة</label>
                                                        <div class="delete-icon position-relative">
                                                            <input type="text" id="inputAnsOptions${i}-3"
                                                                name="inputAnsOptions${i}-3" placeholder="صيغة اختيار الاجابة"
                                                                class="form-control bg-white">
                                                            <button type="button"
                                                                class="main-btn p-0 border-0 bg-white fs-14 text-red position-absolute end-0 top-50 translate-middle-y me-3 btnDeleAnsOptions">حذف</button>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-3 w-50 px-2">
                                                        <label for="inputAnsOptions${i}-4" class="block-title fs-14">عنوان
                                                            الاجابة</label>
                                                        <div class="delete-icon position-relative">
                                                            <input type="text" id="inputAnsOptions${i}-4"
                                                                name="inputAnsOptions${i}-4" placeholder="صيغة اختيار الاجابة"
                                                                class="form-control bg-white">
                                                            <button type="button"
                                                                class="main-btn p-0 border-0 bg-white fs-14 text-red position-absolute end-0 top-50 translate-middle-y me-3 btnDeleAnsOptions">حذف</button>
                                                        </div>
                                                    </div>
    
                                                </fieldset>
                                                <button type="button"
                                                    class="btnAddNewAns main-btn p-0 bg-transparent mt-1 text-gold d-flex align-items-center"
                                                    data-id="${i}">اضافة اجابة جديدة</button>
                                            </div>
                                        </div>
                                    </div>`;

		$(this).before(queHTML);
		++i;
		$('.dynamicallyAdded select.select ').select2({
			minimumResultsForSearch: -1,
			width: '100%'
		});
	});

	$('.card-create-survey').on('click', '.btnAddNewAns', function () {
		let dataId = $(this).attr('data-id');
		let ansHTML = ` <div class="form-group mb-3 w-50 px-2">
							<label for="inputAnsOptions${dataId}-${n}" class="block-title fs-14">عنوان
								الاجابة</label>
							<div class="delete-icon position-relative">
								<input type="text" id="inputAnsOptions${dataId}-${n}"
									name="inputAnsOptions${dataId}-${n}" placeholder="صيغة اختيار الاجابة"
									class="form-control bg-white">
								<button type="button"
									class="main-btn p-0 border-0 bg-white fs-14 text-red position-absolute end-0 top-50 translate-middle-y me-3 btnDeleAnsOptions">حذف</button>
							</div>
						</div>`;
		$(this).prev('.answer-options-groups').append(ansHTML);
		++n;
	});
});
