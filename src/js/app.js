var site = (function ($) {
	var self;

	var init = function () {
		self = this;

		initHeader();
		initAccordion();
		initSlider();
		initBorderlessImg();
		initFancybox();

		initBlog();
		initCDs();
		initWorks();
		initCalendar();
	};

	var initHeader = function () {

		// event on first-level navigation if chapter has children
		$('.nav-main > li:has(ul)').addClass('has-children')
		.children('a')
		.on('click', function (e) {

			var p = $(this).parent();

			// reset and set selected class on element
			p.siblings().removeClass('selected');
			p.addClass('selected');

			// set second-level-class to show second level
			$('#header').removeClass('nav-level-1');
			$('#header').addClass('nav-level-2');

			e.preventDefault();
		});

		// prepend back button to sub navigation and add name of parent main chapter to button
		$('.nav-main li ul').prepend('<li class="level-2-back"><button class="btn-back"></button></li>');

		for (var i = 0; i < $('.nav-main > li').length; i++) {

			var el = $('.nav-main > li')[i];

			if ($(el).hasClass('has-children')) {
				var navTitle = $('.nav-main > li > a')[i];
				$(el).find('.btn-back').text($(navTitle).text());
			}

		}

		// return to first level navigation
		$('.nav-main .btn-back').click(function (e) {
			$('.nav-main > li').removeClass('selected');
			$('#header').addClass('nav-level-1');
			$('#header').removeClass('nav-level-2');
			e.preventDefault();
		});

		// open / close navigation
		$('.toggle-btn-burger').click(function (e) {
			toggleNavigation();
			e.preventDefault();
		});

		// close navigation on esc key
		$(document).on('keydown', function(event) {
			if (event.key == "Escape") {
					if ($('html').hasClass('nav-main-open')) {
							toggleNavigation();
					}
			}
		});

		var toggleNavigation = function () {

			// toggle class to show / hide navigation
			$('html').toggleClass('nav-main-open');

			// remove dynamic classes in case navigation has been closed
			if (!$('html').hasClass('nav-main-open')) {
					$('#header').removeClass('nav-level-1 nav-level-2');
					$('.nav-main > li').removeClass('selected');
			}

		};

		// remove dynamic classes on reload just for safety reasons (history back)
		$(window).on('unload', function () {
			$('html').removeClass('nav-main-open');
			$('#header').removeClass('nav-level-1 nav-level-2');
			$('.nav-main > li').removeClass('selected');
		});

		var lastScr = 0;
		var customVariables,
				headerHeight,
			  stickyHeaderOffset;

		$(window).resize(function () {
			// get custom css variable --sticky-header-offset on resize
			customVariables = window.getComputedStyle(document.body);
			headerHeight = parseInt(customVariables.getPropertyValue('--header-height'), 10);
			stickyHeaderOffset = parseInt(customVariables.getPropertyValue('--center-top-padding'), 10);
		}).resize();

		$(window).scroll(function () {
				var scr = $(window).scrollTop();
				// $('html').toggleClass('sticky', scr >= (stickyHeaderOffset - headerHeight + 10));
				$('html').toggleClass('sticky', scr >= (stickyHeaderOffset - headerHeight));
				$('html').toggleClass('scrolling-up', (scr < lastScr));
				$('html').toggleClass('scrolling-down', scr > lastScr);
				lastScr = scr;
		}).scroll();

	};

	var initAccordion = function () {

		$('.accordion .accordion-headline').append('<span class="accordion-toggle-btn"><svg viewBox="0 0 7 9" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2"><path d="M2.942 5.667V0h1.116v5.667C4.797 4.788 5.842 4.238 7 4.238v1.256c-1.622 0-2.942 1.487-2.942 3.314V9H2.942v-.192c0-1.827-1.32-3.314-2.942-3.314V4.238c1.158 0 2.203.55 2.942 1.429" fill="#ffbc00"/></svg></span>');

		$('.accordion .accordion-headline').click(function (e) {
				e.preventDefault();
				var elem = $(this).closest('.accordion-panel');
				elem.siblings('.open').addBack().toggleClass('open').children('.accordion-content').slideToggle(200, function () {

						var p = $(this).closest('.accordion-panel');

						if (p.is('.open')) {
								$('body, html').animate({scrollTop: p.offset().top - ($('#header').height() + 10)}, 300);
						}

				});
		});

	};

	var initSlider = function () {

		$('.img-slider .swiper-container').each(function () {
			var t = $(this);

			if (t.find('.swiper-slide').length < 2) {
					t.closest('.artwork-slider').addClass('no-pagination');
			} else {

					var sw = new Swiper(this, {
							paginationClickable: true,
							loop: true,
							spaceBetween: 0,
							speed: 500,
							autoHeight: true,
							grabCursor: true,

							navigation: {
									nextEl: t.find('.swiper-button-next')[0],
									prevEl: t.find('.swiper-button-prev')[0]
							}

					});

			}
		});

	};

	var initBorderlessImg = function () {

		$('.borderless-img').wrap('<div class="borderless-img-wrapper"></div>');

	};

	var initFancybox = function () {

		$('#header .nav-meta-search a').fancybox({
				type: 'inline',
				smallBtn: false,
				idleTime: false,
				backFocus: false
		});

	};

	var initBlog = function () {
		var postsFilter = $('.filter-posts');

		if (!postsFilter.length) {
			return;
		}

		// OLD VERSION (filter by single criterion)
		/*postsFilter.find('.category-select select, .tag-select select').on('change', function () {
			var form = $(this).closest('form');

			if ($(this).val() == '0') {
				document.location = form.data('archive-url');
			} else {
				form.submit();
			}
		});

		postsFilter.find('.years-select select').on('change', function () {
			location.href = $(this).val();
		});*/

		// NEW VERSION (filter by multiple criteria)
		postsFilter.find('select').on('change', function () {
			$(this).closest('form').submit();
		});
	};

	var initCDs = function () {
		var postsFilter = $('.filter-cds');

		if (!postsFilter) {
			return;
		}

		postsFilter.find('#filter-edition').on('click', function () {
			$(this).closest('form').submit();
		});

		postsFilter.find('.filter-item-select select').on('change', function () {
			var form = $(this).closest('form');

			if ($(this).val() == '0') {
				document.location = form.data('archive-url');
			} else {
				form.submit();
			}
		});
	};

	var initWorks = function () {
		var postsFilter = $('.filter-works');

		if (!postsFilter) {
			return;
		}

		postsFilter.find('select').on('change', function () {
			var form = $(this).closest('form');

			if ($(this).val() == '0') {
				document.location = form.data('archive-url');
			} else {
				form.submit();
			}
		});
	};

	var initCalendar = function () {
		var postsFilter = $('.filter-events');

		if (!postsFilter) {
			return;
		}

		postsFilter.find('select').on('change', function () {
			$(this).closest('form').submit();
		});
	};

	return {
			init: init
	};

})(jQuery);

jQuery(document).ready(function () {
    site.init();
});