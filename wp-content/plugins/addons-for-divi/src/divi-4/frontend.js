/**
 * Revamp Codebase
 *
 * @ver 4.0.0
 */
jQuery(function ($) {
	//  Image Swapper
	$('.dtq-swapped-img-selector').each(function () {
		const swappedImg = $(this).find('.dtq-swapped-img');
		const imgSchema = swappedImg.data('schema');

		if (imgSchema && typeof imgSchema === 'object') {
			updateImageSource(swappedImg, {
				desktop: imgSchema.desktop,
				tablet: imgSchema.tablet,
				phone: imgSchema.phone,
				hover: imgSchema.hover,
			});
		}
	});

	// Carousel Initialization
	$('.dtq-carousel').each(function () {
		const $this = $(this);
		const settings = $this.data('settings');
		const preSettings = {
			edgeFriction: 0.35,
			useTransform: true,
			touchThreshold: 600,
		};

		$this.slick(Object.assign(preSettings, settings));
	});

	// Lightbox Initialization
	$('.dtq-lightbox').magnificPopup({
		type: 'image',
		mainClass: 'mfp-with-zoom',
		gallery: { enabled: false },
		zoom: {
			enabled: true,
			duration: 300,
			easing: 'ease-in-out',
		},
	});

	// Animated Text Initialization
	$('.dtq-animated-text').each(function () {
		const $this = $(this);
		const settings = $this.data('settings');
		const target = $this.attr('id');
		const type = $this.data('type');
		const targetSelector = `#${target}`;

		switch (type) {
			case 'typed':
				new Typed(`${targetSelector} .dtq-typed-text`, settings);
				break;

			case 'tilt':
				$this.find('.dtq-animated-text-tilt').textillate(settings);
				console.log(settings);
				break;

			case 'slide':
				const $slides = $this.find('.dtq-animated-text-slide');
				const $firstSlide = $slides
					.find('li')
					.removeClass('text-in')
					.first()
					.addClass('text-in');

				setInterval(() => {
					const $activeText = $slides
						.find('.text-in')
						.addClass('text-out')
						.removeClass('text-in');
					const $nextText = $activeText.next('li');

					if ($nextText.length) {
						$nextText.addClass('text-in').removeClass('text-out');
					} else {
						$firstSlide.addClass('text-in').removeClass('text-out');
					}
				}, parseInt(settings.slide_gap));
				break;

			default:
				console.warn('Unsupported animation type:', type);
		}
	});

	// Before After Slider Initialization
	$('.dtq-image-compare').each(function () {
		var offsetpct = $(this).data('offsetpct'),
			moveonhover = $(this).data('moveonhover'),
			orientation = $(this).data('orientation'),
			beforelabel = $(this).data('beforelabel'),
			afterlabel = $(this).data('afterlabel'),
			overlay = $(this).data('overlay');

		$(this)
			.find('.dtq-image-compare-container')
			.twentytwenty({
				default_offset_pct: offsetpct,
				move_slider_on_hover: moveonhover === 'on',
				orientation: orientation,
				before_label: beforelabel,
				after_label: afterlabel,
				no_overlay: overlay !== 'on',
				move_with_handle_only: false,
				click_to_move: true,
			});
	});

	// News Ticker Initialization
	const newsTicker = $('.dtq-news-tricker');
	if (newsTicker && newsTicker.length > 0) {
		newsTicker.each(function () {
			var _width = $(this).find('#parent').width();
			$(this).get(0).style.setProperty(`--width`, `${_width}px`);
		});
	}

	// Counter Initialization
	$('.dtq-counter .dtq-number-text').each(function (ignore, counter) {
		const counterUp = window.counterUp['default'];
		counterUp(counter, {
			duration: 5000,
			delay: 16,
		});
	});

	// Scroll Image Initialization
	$('.dtq-scroll-image').each(function () {
		applyScrollImageEffect($(this));
	});

	// Video Modal Initialization
	const popupVideo = $('.dtq-popup-yt, .dtq-popup-vm');

	if (popupVideo.length > 0) {
		popupVideo.each(function () {
			if ($(this).data('popup-initialized')) return;
			$(this).data('popup-initialized', true);

			const href = $(this).attr('href');
			const type = $(this).data('type');
			let videoSource = '';

			if (type === 'vm') {
				const suffix = href.includes('?')
					? '&autoplay=1'
					: '?autoplay=1';
				if (href.includes('player')) {
					videoSource = href + suffix;
				} else {
					const videoId = href.split('/').pop();
					videoSource = `//player.vimeo.com/video/${videoId}${suffix}`;
				}
			}

			$(this).magnificPopup({
				type: 'iframe',
				mainClass: 'mfp-fade',
				removalDelay: 140,
				preloader: true,
				fixedContentPos: false,
				iframe: {
					markup: `
                    <div class="mfp-iframe-scaler">
                        <div class="mfp-close"></div>
                        <iframe class="mfp-iframe" frameborder="0" allow="autoplay" allowfullscreen></iframe>
                    </div>
                `,
					patterns: {
						youtube: {
							index: 'youtube.com/',
							src: '//www.youtube.com/embed/%id%?autoplay=1',
						},
						vimeo: {
							index: 'vimeo.com/',
							id: '/',
							src: videoSource,
						},
					},
				},
				callbacks: {
					beforeOpen: function () {
						const orderClass = $(this.st.el).data('order');
						$('body').addClass(
							`dtq-video-open dtq-video-popup-${orderClass}`
						);
					},
					close: function () {
						const orderClass = $(this.st.el).data('order');
						$('body').removeClass(
							`dtq-video-open dtq-video-popup-${orderClass}`
						);
					},
				},
			});
		});
	}

	$('.dtq-popup-video').magnificPopup({
		type: 'inline',
		mainClass: 'mfp-fade',
		removalDelay: 100,
		closeOnContentClick: false,
		midClick: false,
		callbacks: {
			beforeOpen: function () {
				$('body').addClass('dtq-modal-open dtq-video-popup');
			},
			open: function () {
				var targetEl = $(this.st.el).data('mfp-src');
				$('.dtq-modal').addClass('open');
				$(`${targetEl} video`).trigger('play');
			},
			close: function () {
				var targetEl = $(this.st.el).data('mfp-src');
				$(`${targetEl} video`).trigger('pause');
				$('body').removeClass('dtq-modal-open dtq-video-popup');
				$('.dtq-modal').removeClass('open');
			},
		},
	});

	// Alert Dismiss Initialization
	$('.dtq-alert-dismiss').each(function () {
		$(this).on('click', function () {
			$(this).parents('.ba_alert').fadeOut(400);
		});
	});
});

// Image Swapper
function updateImageSource(selector, imageConfig) {
	const updateSrc = (selector, src) => {
		if (src && src.length > 0) {
			jQuery(selector).attr('src', src);
		}
	};

	const handleResize = () => {
		const screenWidth = jQuery(document).width();
		if (screenWidth < 768) {
			updateSrc(selector, imageConfig.phone);
		} else if (screenWidth >= 768 && screenWidth < 981) {
			updateSrc(selector, imageConfig.tablet);
		} else {
			updateSrc(selector, imageConfig.desktop);
		}
	};

	handleResize(); // Call immediately to set the initial source

	jQuery(window).on('resize', handleResize);

	jQuery(selector)
		.closest('.dtq-swapped-img-selector')
		.on({
			mouseenter: () => {
				updateSrc(selector, imageConfig.hover);
				jQuery(selector).addClass('dtq-img-hovered');
			},
			mouseleave: () => {
				handleResize();
				jQuery(selector).removeClass('dtq-img-hovered');
			},
		});
}

// Scroll Image Initialization
function applyScrollImageEffect(element) {
	const imgElement = element.find('.dtq-scroll-image-el');
	const overlay = element.find('.dtq-scroll-image-overlay');
	const dirHover = element.data('dir-hover');
	const dirScroll = element.data('dir-scroll');

	// Calculate hover offset based on direction
	function calculateHoverOffset() {
		return dirHover[0] === 'X'
			? parseInt(imgElement.width()) - parseInt(element.width())
			: parseInt(imgElement.height()) - parseInt(element.height());
	}

	// Handle hover animations if applicable
	if (dirHover !== 'none') {
		const operator =
			dirHover === 'X_rtl' || dirHover === 'Y_btt' ? '-' : '';
		const axis = dirHover[0];
		const offset = Math.max(calculateHoverOffset(), 0);

		element.on('mouseenter', function () {
			imgElement.css(
				'transform',
				`translate${axis}(${operator}${offset}px)`
			);
		});

		element.on('mouseleave', function () {
			imgElement.css('transform', `translate${axis}(0px)`);
		});
	}

	// Handle scroll overflow styling if applicable
	if (dirScroll !== 'none') {
		if (dirScroll === 'horizontal') {
			overlay.css({
				width: imgElement.width(),
				height: imgElement.height(),
			});
		} else {
			overlay.css({
				width: '100%',
				height: '100%',
			});
		}
	}
}
