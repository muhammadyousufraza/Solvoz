(function($) {
  const generateObserver = (reveal_width) => {
    return new IntersectionObserver((entries, observer) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const ir_content_area = $(entry.target);

          const __class__difl__image_wrap = ir_content_area.find('.difl__image_wrap');
          const __class__difl__image_reveal_wrapper = ir_content_area.find('.difl__image_reveal_wrapper');
          const __class__difl__image_reveal_element = ir_content_area.find('.difl__image_reveal_element');
          const __class__difl__image_reveal_wrapper_img = ir_content_area.find('.difl__image_reveal_wrapper img');
          const __class__difl__image_reveal_hover_overlay_content = ir_content_area.find('.difl__image_reveal_hover_overlay_content');

          const settings = __class__difl__image_reveal_wrapper.data('settings');
          const {
            revealDirectionClass,
            revealEffect,
            revealDelay,
            animationTime,
          } = settings;

          const addClass = (element, className) => element.addClass(className);

          addClass(__class__difl__image_reveal_wrapper, revealDirectionClass);
          addClass(__class__difl__image_reveal_element, 'difl__image_reveal');

          if (revealEffect) {
            addClass(__class__difl__image_wrap, 'difl__animate ' + revealEffect);
          }

          if (__class__difl__image_reveal_hover_overlay_content) {
            setTimeout(() => __class__difl__image_reveal_hover_overlay_content.css('animationDuration', animationTime), 2000);
          }

          __class__difl__image_reveal_element.css({
            transform: 'scale(0, 1)',
            transformOrigin: '100% 50%',
            opacity: 1,
          });

          const noscriptContent = ir_content_area.find('noscript').text();
          const tempElement = $('<div>' + noscriptContent + '</div>').find('img').attr('src');
          const base64thumb = $('<div>' + noscriptContent + '</div>').find('p').text();

          setTimeout(() => {
            __class__difl__image_reveal_wrapper_img.parent().css('opacity', 1);
            __class__difl__image_wrap.css('background', 'none');
          }, revealDelay * 1000);

          function loadImage(url, selector) {
            selector.attr('src', url);
          }

          loadImage(tempElement, __class__difl__image_reveal_wrapper_img);

          observer.unobserve(entry.target);
        }
      });
    }, {'rootMargin': '0px 0px -' + reveal_width + 'px 0px'});
  };

  $(window).on('load', function() {
    const reveal_items = $('.difl_imagereveal');

    reveal_items.each(function() {
      const settings = $(this).find('.difl__image_reveal_wrapper').data('settings');
      const reveal_width = (($(window).height() - 40) / 100) * parseInt(settings.revealPosition);

      generateObserver(reveal_width).observe(this);

      const target = settings.link_url_target;
      if ('on' === settings.use_light_box) {
        const ir_lightbox_options = {
          enable_light_box: true,
          filter: false,
          filterValue: '',
          download: settings.use_lightbox_download === 'on',
        };

        df_ir_use_lightbox($(this).find('.difl__image_reveal_wrapper'), ir_lightbox_options);
      } else {
        df_ir_url_open(target, this);
      }
    });
  });

  function df_ir_use_lightbox(selector, options) {
    if ('on' === options.enable_light_box) {
      selector.style.cursor = 'pointer';
      const settings = {
        subHtmlSelectorRelative: true,
        addClass: 'df_si_lightbox',
        //counter: true,
        download: options.download,
        // download: options.download
      };

      lightGallery(selector, settings);
    }
  }

  function df_ir_url_open(target, ele) {
    const elements = ele.querySelector('.difl__image_reveal_content');
    const url = elements.dataset.url;
    if (url && url !== '') {
      ele.style.cursor = 'pointer';
      ele.addEventListener('click', function(event) {
        if ('same_window' === target) {
          window.location = url;
        } else {
          window.open(url);
        }
      });
    }else{
      ele.querySelector('img').style.cursor = 'default';
    }
  }

})(jQuery);
