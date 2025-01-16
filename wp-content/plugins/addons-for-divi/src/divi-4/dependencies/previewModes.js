/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

// External Dependencies
/*
import {
  easing,
  tween,
} from 'popmotion';

import {
  assign,
  debounce,
  find,
  forEach,
  get,
  includes,
  intersection,
  isEmpty,
  isUndefined,
  noop,
  pick,
} from 'lodash';
*/
// Internal Dependencies
import Utils from './utils';
//import ETBuilderStore from '../stores/et-builder-store';
import ETBuilderOffsets from './et-builder-offsets';
//import ETBuilderBreakpoints from '../constants/et-builder-breakpoints';
/*
import {
  getModalPreferredDimensions,
  getModalPreferredSnapSettings,
} from '../components/modal/preferences';


const $app_body        = Utils.$appWindow('body');
const $app_html        = Utils.$appWindow('html');
const $bfb_metabox     = Utils.$topWindow('#et_pb_layout');
const $html            = Utils.$appWindow('html');
const $publish_metabox = Utils.$topWindow('.submitbox').closest('.postbox');
const $top_body        = Utils.$topWindow('body');
const $top_html        = Utils.$topWindow('html');
const $post_body       = Utils.$topWindow('#post-body');

const isBFB = Utils.condition('is_bfb');
const isTB  = Utils.isTB();
const isDBP = Utils.isLimitedMode();
const isRtl = Utils.condition('is_rtl') && ! Utils.condition('is_no_rtl');

const isSafari = Utils.$topWindow('body').hasClass('safari');

const sideLeft  = isRtl ? 'right' : 'left';
const sideRight = isRtl ? 'left' : 'right';

const adminMenuWidth       = 160;
const adminMenuWidthFolded = 36;
const adminMenuTextWidth   = 124;

const isOneColumn = () => $post_body.hasClass('columns-1');
*/
const responsive_widths = ETBuilderOffsets.responsive;
const responsive_landscape_widths = ETBuilderOffsets.responsiveLandscape;
/*
let $iframe;
let $iframe_body;
let _instance;
let _pmb_container       = false;
let _pmb_container_index = false;
let _scroll_to_focus     = false;
*/

class ETBuilderPreviewModes {
    /*
  $admin_menu;

  $admin_sidebar;

  $admin_content;

  $admin_menu_names;

  $in_viewport = jQuery();

  current_mode = '';

  current_width = 0;

  current_translate = {
    iframe_translate_x: 0,
    iframe_translate_y: 0,
  };

  is_DFM = false;

  is_animating = false;

  is_zoom = false;

  is_mobile_preview = false;

  is_large_layout = false;

  is_animation_enabled = false;

  is_modal_snapped = false;

  is_iframe = Utils.topWindow() !== self;

  mode_widths = this.modeWidths();

  previous_mode = '';

  was_zoom = false;

  bfbAdminMenuManuallyFolded = false;

  static PORTRAIT = 'portrait';

  static LANDSCAPE = 'landscape';

  get mode_class() {
    return `et-fb-preview--${this.current_mode}`;
  }

  constructor(preview_mode) {
    if (_instance) {
      return _instance;
    }

    _instance = this;

    if (! this.is_iframe) {
      return _instance;
    }

    this.current_mode = preview_mode;
  }

  _animate = values => {
    this.current_translate = pick(values, ['iframe_translate_x', 'iframe_translate_y']);

    let transform       = `translate(${values.iframe_translate_x}px, ${values.iframe_translate_y}px)`;
    let transformOrigin = '';

    if (this.is_zoom || this.was_zoom) {
      transform      += ` scale(${values.iframe_scale})`;
      transformOrigin = 'top center';
    }

    $iframe.css({
      width: values.iframe_width,
      transform,
      transformOrigin,
    });

    if (! isBFB) {
      this._scrollIntoView($iframe[0], { scrollMode: 'if-needed' });

      // Skip scrollIntoView if modal is snapped to bottom. Snapped bottom modal requires offset while there's no way to
      // set dynamic offset for scrollIntoView. Use manually calculated scroll into view in _complate() callback
      if (this.$in_viewport[0] && ! this._is_using_wheel && ! this._isModalSnapped('bottom')) {
        this._scrollIntoView(this.$in_viewport[0], { scrollMode: 'if-needed' });
      }
    }

    if (isBFB && this.animate_admin) {
      this.$admin_menu.width(values.admin_menu_width);
      this.$admin_content.css(`margin-${sideLeft}`, values.admin_menu_width);
      this.$admin_menu_names.css('text-indent', values[sideLeft]);
      this.$admin_menu_names.css('left', 0);

      $iframe
        .parents('#post-body')
        .css(`margin-${sideRight}`, `${values.postbox_margin}px`);

      $iframe
        .parents('#et_pb_layout')
        .width(this.is_zoom || this.is_mobile_preview ? '' : values.iframe_width);
    }
  };

  _complete = () => {
    if (this._is_animating) {
      this._is_animating = false;
      $top_html.removeClass('et-fb-preview--animating');
      $app_html.removeClass('et-fb-preview--animating');
      this._toggleStyleOverrides(true);
      Utils.$topWindow().trigger('et-preview-animation-complete');

      if (! isBFB) {
        get(Utils.appWindow(), 'et_change_primary_nav_position', noop)(0);
      }
    }

    if (isBFB && ! this.is_mobile_preview) {
      $iframe
        .width('')
        .parents('#et_pb_layout')
        .width('');
    }

    if (isBFB) {
      // Remove inline styling(s) if they are returned to default WordPress admin value
      if (adminMenuWidth === get(this, 'animation_config.to.admin_menu_width')) {
        // Removing #post-body marginRight returns #postbox-container-1 (sidebar) to its original place
        // This is the likely result unless the modal is snapped. When modal is snapped, builder metabox
        // should fill the entire content area (#post-body) width (one column layout)
        if (! this.is_modal_snapped) {
          $iframe
            .parents('#post-body')
            .css(`margin-${sideRight}`, '');
        }
      }

      if (this.animate_admin) {
        this.$admin_menu.css('width', '');
        this.$admin_menu_names.css('text-indent', '');
        this.$admin_menu_names.css('left', '');
        this.$admin_content.css(`margin-${sideLeft}`, '');
      }
    } else {
      this._scrollIntoView($iframe[0], { scrollMode: 'if-needed' });

      if (this.$in_viewport[0] && ! this._is_using_wheel) {
        // Bottom-snapped modal requires manually calculated scroll into view due to no dynamic offset can be given
        if (this._isModalSnapped('bottom')) {
          const $firstVisibleModule = jQuery(this.$in_viewport[0]);

          // responsive to desktop requires longer timeout to get correct calculation
          const fromFrameWidth              = get(this, 'animation_config.from.iframe_width', 0);
          const toFrameWidth                = get(this, 'animation_config.to.iframe_width', 0);
          const bottomScrollIntoViewTimeout = fromFrameWidth > toFrameWidth ? 0 : 200;

          // Manually calculate "center" of given visible module when modal is snapped to bottom
          setTimeout(() => {
            const topWindowHeight = parseInt(Utils.$topWindow().innerHeight());
            const adminBarHeight  = Utils.getAdminBarHeight();
            const fixedHeader     = Utils.getFixedHeaderHeight();
            const modalHeight     = parseInt(ETBuilderStore.getAppPreference('modal_dimension_height')) + ETBuilderOffsets.modal.headerHeight + ETBuilderOffsets.modal.footerHeight;
            const visibleWindow   = topWindowHeight - adminBarHeight - modalHeight - fixedHeader;

            jQuery(Utils.$topWindow('html, body').animate({
              scrollTop: parseInt($firstVisibleModule.offset().top) - (visibleWindow / 2),
            }, 100));
          }, bottomScrollIntoViewTimeout);
        } else {
          this._scrollIntoView(this.$in_viewport[0], { scrollMode: 'if-needed' });
        }
      }

      // Fixed possibly broken iframe container because setContainer randomly executed little bit late than previewMode
      if (this._isModalSnapped('bottom')) {
        // If iframe width equal window width but has offset left, remove transform
        if (Utils.$topWindow().innerWidth() <= $iframe.width() && get($iframe.offset(), 'left', 0) > 0) {
          $iframe.css('transform', '');
        } else {
          // Need to manually parse inline CSS because jQuery's .css() sometimes fetch the computed value instead
          const iframeStyles = Utils.parseInlineCssIntoObject($iframe.attr('style'));

          // Calculate valid `transform` attribute based on _animate() callback
          const validTransform = `translate(${get(this, 'animation_config.to.iframe_translate_x')}px, ${get(this, 'animation_config.to.iframe_translate_y')}px)`;

          // If valid transform doesn't match its inline CSS counterpart, re-apply it
          if (validTransform !== iframeStyles.transform) {
            $iframe.css('transform', validTransform);
          }
        }
      }
    }

    if (isTB) {
      if (! this.is_mobile_preview && ! this._isModalSnapped('left') && ! this._isModalSnapped('right')) {
        $iframe.width('');
      }
    }

    this.$in_viewport = $();
  };

  _animationEnabled = () => ETBuilderStore.getAppPreference('builder_animation');

  _isBFBMobile = () => isBFB && Utils.$topWindow().innerWidth() < get(ETBuilderBreakpoints, 'wpAdmin.oneColumnLayout');

  _isLargeLayout = () => {
    const $elements = Utils.$appWindow('.et_pb_section, .et_pb_row, .et_pb_column, .et_pb_module');

    return $elements.length > 130;
  };

  _isModalSnapped(location = false) {
    const { snap, snapLocation } = getModalPreferredSnapSettings();
    const isModalSnapped         = ETBuilderStore.isSettingsModalOpen('settings') && snap;

    return location ? isModalSnapped && location === snapLocation : isModalSnapped;
  }

  _repositionPublishMbox = (where = 'top') => {
    if ('top' === where) {
      // Save current publish metabox position
      _pmb_container       = $publish_metabox.closest('.ui-sortable').attr('id');
      _pmb_container_index = $publish_metabox.index();

      // Move publish metabox to the top of side-sortables to ensure its position stays
      $publish_metabox.insertAfter($bfb_metabox);
      Utils.$topWindow('.meta-box-sortables').sortable('refreshPositions');
    } else if (_pmb_container && false !== _pmb_container_index) {
      // Move publish metabox back to its original position
      if (Utils.$topWindow(`#${_pmb_container} .postbox`).size() <= _pmb_container_index) {
        $publish_metabox.appendTo(`#${_pmb_container}`);
      } else {
        $publish_metabox.insertBefore(Utils.$topWindow(`#${_pmb_container} .postbox`).eq(_pmb_container_index));
      }

      Utils.$topWindow('.meta-box-sortables').sortable('refreshPositions');

      // Reset sortable position
      _pmb_container       = false;
      _pmb_container_index = false;
    }

    // Emit events that tells frontend component that a metabox on editor has been moved
    // This is particularly userul on component that relies on frame offset (eg. Sticky Elements)
    Utils.topWindow().dispatchEvent(new CustomEvent('ETBFBMetaboxSortStopped', {}));
  };

  _maybeToggleDistractionFreeMode = force_state => {
    if (isTB) {
      return;
    }

    if (this.is_DFM && ('wireframe' === this.current_mode || 'open' === force_state)) {
      this.is_DFM = false;

      if (! this.bfbAdminMenuManuallyFolded) {
        $top_body.removeClass('folded');
      }

      $top_body.removeClass('et-bfb-distraction-free-mode');

      this._repositionPublishMbox('original');
    } else if (! this.is_DFM && ('wireframe' !== this.current_mode || 'folded' === force_state)) {
      this.is_DFM = true;

      $top_body.addClass('folded');
      $top_body.addClass('et-bfb-distraction-free-mode');

      this._repositionPublishMbox('top');
    }
  };

  _toggleStyleOverrides = (final = false) => {
    if (isTB) {
      $iframe_body
        .css('overflow', 'hidden')
        .parent()
        .css('overflow', 'hidden');

      return;
    }

    if (this.is_mobile_preview || this.is_zoom) {
      if (! isBFB) {
        $iframe_body
          .css('overflow', 'hidden')
          .parent()
          .css('overflow', 'hidden');

        $top_body
          .parent()
          .css('overflow-y', 'auto')
          .css('overflow-x', 'hidden');
      }
    } else if (isBFB) {
      $iframe
        .parents('#et_pb_layout')
        .width('');
    } else if (final || this._is_using_wheel) {
      $iframe_body
        .css('overflow', '')
        .parent()
        .css('overflow', '');

      $top_body
        .css('overflow', '')
        .parent()
        .css('overflow-y', '')
        .css('overflow-x', '');

      if (final) {
        if (this._isModalSnapped()) {
          const fix = () => $iframe.width(Utils.$topWindow().width() - this.mode_widths.modal);
          fix();
          setTimeout(fix, 100);
        } else {
          $iframe.width('');
        }
      }
    }
  };

  _updateDOMForCurrentMode = () => {
    const nodes = [$html];

    if (! isTB) {
      nodes.push($top_html);
    }

    forEach(nodes, $el => {
      $el.removeClass((index, className) => {
        const matches = className.match(/et-fb-preview--\w+/);
        return matches ? matches.shift() : '';
      });

      $el.addClass(this.mode_class);
    });

    if ('desktop' !== this.current_mode) {
      if (isDBP && ! isBFB && 0 === $top_body.find('.et-fb-preview__caption').length) {
        // Add an caption to hide all the page contents
        $top_body.append('<div class="et-fb-preview__caption"></div>');
        $top_body.addClass('et_pb_3rd_party_theme');
      }
    } else if (! $top_body.hasClass('et_divi_theme')) {
      // Remove the caption that we added earlier (see above)
      $top_body.find('.et-fb-preview__caption').remove();
    }
  };

  _updateProperties = (mode, applyAnimation = true) => {
    if (! $iframe) {
      $iframe      = Utils.$topWindow(window.frameElement);
      $iframe_body = $iframe.contents().find('body');
    }

    this.previous_mode = this.current_mode;
    this.current_mode  = mode;

    this.mode_widths        = this.modeWidths();
    this.current_mode_width = this.mode_widths[mode];

    this.is_zoom = 'zoom' === this.current_mode;
    this.was_zoom = 'zoom' === this.previous_mode;
    this.is_mobile_preview  = includes(['tablet', 'phone'], this.current_mode);
    this.was_mobile_preview = includes(['tablet', 'phone'], this.previous_mode);
    this.is_modal_snapped   = this._isModalSnapped();

    const is_DFM     = 'wireframe' !== this.current_mode;
    const doing_init = isUndefined(this.previous_mode);

    this.animate_admin = (is_DFM !== this.is_DFM || includes([this.current_mode, this.previous_mode], 'wireframe')) && ! this._isBFBMobile();

    const animate_from = {
      iframe_width: $iframe.width() || $iframe.parent().width(),
      iframe_scale: this.was_zoom ? 0.5 : 1,
      ...this.current_translate,
    };

    // Mode width is limited by the #et_pb_layout container in BFB, do not allow to exceed the width of the container
    if (isBFB && this.is_mobile_preview) {
      const maxWidthAvailable = Utils.getTopWindowWidth();

      this.current_mode_width = this.current_mode_width > maxWidthAvailable ? maxWidthAvailable : this.current_mode_width;
    }

    // Mode width is limited by the TB container, do not allow to exceed the width of the container.
    if (isTB && this.is_mobile_preview) {
      const maxWidthAvailable = Utils.topViewportWidth();

      this.current_mode_width = this.current_mode_width > maxWidthAvailable ? maxWidthAvailable : this.current_mode_width;
    }

    // Use the full width when animating from a mobile preview to wireframe
    if (isBFB && ! is_DFM && this.was_mobile_preview) {
      assign(animate_from, {
        iframe_width: $bfb_metabox.width(),
      });
    }

    const animate_to = {
      iframe_width: this.current_mode_width,
      iframe_scale: this.is_zoom ? 0.5 : 1,
      ...this.cssTranslate(),
    };

    if (isBFB && this.animate_admin) {
      this.$admin_menu       = Utils.$topWindow('#adminmenuback, #adminmenuwrap, #adminmenu');
      this.$admin_sidebar    = Utils.$topWindow('#postbox-container-1');
      this.$admin_content    = Utils.$topWindow('#wpcontent');
      this.$admin_menu_names = Utils.$topWindow('#adminmenu .wp-menu-name, #collapse-button .collapse-button-label');

      assign(animate_from, {
        admin_menu_width: this.$admin_menu.width(),
        postbox_margin: parseInt($post_body.css('margin-right')),
        [sideLeft]: is_DFM || doing_init ? 0 : - adminMenuTextWidth,
      });

      assign(animate_to, {
        admin_menu_width: is_DFM || this.bfbAdminMenuManuallyFolded ? adminMenuWidthFolded : adminMenuWidth,
        postbox_margin: is_DFM || this.is_modal_snapped || isOneColumn() ? 0 : 300,
        [sideLeft]: is_DFM ? - adminMenuTextWidth : 0,
      });
    }

    // We could skip container animation in some cases.
    // When resizing snapped modal for example to improve the performance
    const animate = applyAnimation && this._animationEnabled();

    this.animation_config = {
      from: animate_from,
      to: animate_to,
      ease: easing.cubicBezier(0.230, 1.000, 0.320, 1.000),
      duration: animate ? 400 : 0,
    };

    let scrollTop = this.was_mobile_preview || this.was_zoom ? Utils.$topWindow().scrollTop() : Utils.$appWindow().scrollTop();

    if (Utils.isTB()) {
      scrollTop = Utils.viewportScrollTop();
    }

    this.keep_module_in_viewport = 0 !== scrollTop;
    this.$in_viewport            = $();

    if (this.keep_module_in_viewport) {
      // Figure out which modules are visible in viewport and save for use later in this._animate()
      const $modules = Utils.$appWindow('.et_pb_module').removeClass('et-pb-in-viewport');

      this.$in_viewport = $(find($modules, $el => Utils.isElementInViewport($el))).addClass('et-pb-in-viewport');
    }
  };
  */

    /**
     * ScrollIntoView pollyfill for Safari; Use native API for the rest.
     *
     * @since 3.19.5
     * @param {object} DOM Element.
     * @param element
     * @param Settings.
     * @param Settings.
     * @param settings
     * @param {object|bool} .scrollIntoView()'s settings
     */
    /*
  _scrollIntoView = (element, settings = {}) => {
    // Safari has partial support for scrollIntoView which makes it has inconsistent behaviour
    if (isSafari) {
      const windowScroll        = ! isBFB && includes(['wireframe', 'desktop'], this.current_mode) ? 'app' : 'top';
      const scale               = this.is_zoom ? 0.5 : this.was_zoom ? 2 : 1;
      const topWindowHeight     = Utils.topWindow().innerHeight;
      const windowOffsetTop     = 'app' === windowScroll ? Utils.appWindow().pageYOffset : Utils.topWindow().pageYOffset;
      const windowOffsetBottom  = windowOffsetTop + topWindowHeight;
      const windowCenterOffset  = topWindowHeight * 0.3;
      const elementOffsetTop    = jQuery(element).offset().top * scale;
      const elementOffsetBottom = elementOffsetTop + (jQuery(element).height() * scale);

      // Determine if scrolling into view is needed; initially mimics {scrollMode: 'if-needed'} but also adjusted for
      // builder situation. Scrolling into view is needed when element's offset top position is not between 1/3 to 2/3
      // (to ensure element is in the center area of viewport, mimicking {block: 'center'} settings) area of viewport
      // with an exception: if visible viewport is between element (ie. app iframe), scrolling into view is not needed
      const isViewportBetweenElement  = elementOffsetTop <= windowOffsetTop && elementOffsetBottom >= windowOffsetBottom;
      const isElementOnViewportCenter = elementOffsetTop >= windowOffsetTop + windowCenterOffset && elementOffsetTop <= windowOffsetBottom - windowCenterOffset;
      const needScroll                = ! (isViewportBetweenElement || isElementOnViewportCenter);

      if (needScroll) {
        const scrollingWindow = 'app' === windowScroll ? Utils.appWindow() : Utils.topWindow();

        scrollingWindow.scrollTo({
          top: (elementOffsetTop - (topWindowHeight / 2)),
        });
      }
    } else {
      element.scrollIntoView(settings);
    }
  };

  activate = (mode, update_width = true, force = false, animation = true) => {
    if (this.current_mode === mode && ! force) {
      return this.current_mode_width;
    }

    this._updateProperties(mode, animation);

    if (isBFB) {
      Utils.$topWindow('#collapse-menu').toggleClass('et_pb_hidden', this.current_mode !== 'wireframe');
    }

    if (! isTB && ! update_width) {
      this.animation_config.to.iframe_width       = this.animation_config.from.iframe_width;
      this.animation_config.to.iframe_translate_x = this.animation_config.from.iframe_translate_x;
      this.animation_config.to.iframe_translate_y = this.animation_config.from.iframe_translate_y;
    }

    const is_large_layout      = this._isLargeLayout();
    const is_animation_enabled = animation && this._animationEnabled();

    $top_html
      .toggleClass('et-fb-large-layout', is_large_layout)
      .toggleClass('et-fb-animation-disabled', ! is_animation_enabled);

    if (isBFB && mode !== 'wireframe') {
      // If BFB isn't the first mbox, we need to keep it on focus by scrolling the viewport
      const $mboxes    = Utils.$topWindow('#postbox-container-2');
      const bfbTop     = $bfb_metabox.offset().top - parseInt($bfb_metabox.css('margin-top'), 10);
      _scroll_to_focus = $mboxes.offset().top !== bfbTop;
    }

    if (! isBFB) {
      if (! isTB) {
        if (includes(['tablet', 'phone'], mode)) {
          const adminBarHeight = Utils.getAdminBarHeight();

          if (32 === adminBarHeight) {
            $app_body.addClass('et_fb_thin_admin_bar');
          }
        } else {
          $app_body.removeClass('et_fb_thin_admin_bar');
        }
      }

      // Trigger resize event to make sure all sizes recalculated after preview toggling
      if (includes(['zoom', 'desktop'], mode)) {
        Utils.$appWindow().trigger('resize');
      }
    }

    this._maybeToggleDistractionFreeMode();
    this._updateDOMForCurrentMode();

    if (_scroll_to_focus) {
      // need to compute this again because offsets can be modified by the above code.
      const bfbTop = $bfb_metabox.offset().top - parseInt($bfb_metabox.css('margin-top'), 10);
      $top_html.animate({ scrollTop: bfbTop - 20 }, 300);
    }

    if (is_animation_enabled && ! is_large_layout) {
      // Apply style overrides before animation starts so that we don't show scrollbar on wrong
      // element and have it suddenly jump to the correct element after a delay. The height values
      // will be inaccurate during the first call but they will be fixed when the complete()
      // callback is called after animation is finished.
      this._toggleStyleOverrides();

      if (this.$in_viewport[0] && ! isBFB) {
        // We moved the scroll between top and app window so we need to fix initial scroll position.
        this._scrollIntoView(this.$in_viewport[0]);
      }

      this.is_animating = this._is_animating = true;

      // .et-fb-preview--animating class cancels custom stacking needed to keep metabox on the first order
      // This cancellation is logical on desktop but causes serious glitch on BFB mobile breakpoints
      if (! this._isBFBMobile()) {
        $top_html.addClass('et-fb-preview--animating');
        $app_html.addClass('et-fb-preview--animating');
      }

      // Use setTimeout() instead of the complete event handler because we want
      // to disable 'is_animating' prop a little bit before the animation actually ends.
      // Note: Animation actually runs a bit longer than the duration we configure :rolling_eyes:
      setTimeout(() => this.is_animating = false, this.animation_config.duration);

      this._is_using_wheel = false;

      tween(this.animation_config).start({
        update: this._animate,
        complete: this._complete,
      });
    } else {
      this._animate(this.animation_config.to);
      this._is_using_wheel = false;
      this._complete();
      this._toggleStyleOverrides(true);
    }

    return this.current_mode_width;
  };

  cssTranslate = (is_modal_snapped, mode_width, modal_width, snap_location) => {
    const { snapLocation } = getModalPreferredSnapSettings();

    is_modal_snapped = isUndefined(is_modal_snapped) ? this.is_modal_snapped : is_modal_snapped;
    mode_width       = mode_width || this.current_mode_width;
    modal_width      = modal_width || this.mode_widths.modal;
    snap_location    = snap_location || snapLocation;

    const translate = {
      iframe_translate_x: 0,
      iframe_translate_y: 0,
    };

    if (is_modal_snapped && (this.is_mobile_preview || this.is_zoom) && ! isBFB) {
      // Need to center the iframe within the remaining space
      const window_width = Utils.topViewportWidth();

      let whitespace = 0;

      if (this.is_mobile_preview) { // Responsive view mode handler
        whitespace = window_width - mode_width;

        if ('bottom' !== snap_location) {
          whitespace -= modal_width;

          if (isTB) {
            whitespace -= Utils.maybeGetScrollbarWidth();
          }
        }

        if (whitespace) {
          whitespace /= 2;
        }

        if ('left' === snap_location) {
          translate.iframe_translate_x = whitespace > 0 ? - whitespace : whitespace;
        } else if ('right' === snap_location || 'bottom' === snap_location) {
          translate.iframe_translate_x = whitespace;
        }
      }
    }

    return translate;
  };
*/
    getViewModeByWidth = (value, orientation = ETBuilderPreviewModes.PORTRAIT) => {
        const widths =
            ETBuilderPreviewModes.LANDSCAPE === orientation ? responsive_landscape_widths : responsive_widths;

        if (value <= widths.phone) {
            return 'phone';
        }

        if (value <= widths.tablet) {
            return 'tablet';
        }

        return 'desktop';
    };
    /*
  handleTopWindowResize = event => {
    if (! this.$admin_content || 0 === this.$admin_content.length) {
      return;
    }

    const top_window_width = Utils.$topWindow().width();

    if (top_window_width > get(ETBuilderBreakpoints, 'wpAdmin.mobileAdminBar')) {
      this.$admin_content.css('margin-left', this.$admin_menu.width());
    } else {
      this.$admin_content.css('margin-left', '');
    }

    const post_body_margin_reset = '0px' === $iframe.parents('#post-body').css(`margin-${sideRight}`);

    if (this._isBFBMobile() && 'wireframe' === this.current_mode && ! post_body_margin_reset) {
      $iframe.parents('#post-body').css(`margin-${sideRight}`, '');
    }
  };

  handleTopDocumentColumnChange = event => {
    if ('wireframe' === this.current_mode) {
      // If mboxes use 1 column layout, move publish on top
      this._repositionPublishMbox(isOneColumn() ? 'top' : 'original');
    }
  };

  handleBFBAdminMenuManuallyFoldedChange = event => {
    this.bfbAdminMenuManuallyFolded = Utils.$topWindow('body').hasClass('folded');
    $top_body.toggleClass('et-manually-folded', this.bfbAdminMenuManuallyFolded);
  };

  initialize = preview_mode => {
    this.preview_mode = preview_mode;

    this._updateDOMForCurrentMode();

    // Manually folded state must be checked before activating the preview mode.
    if (isBFB) {
      this.handleBFBAdminMenuManuallyFoldedChange();
    }

    // Do not animate (on first load) when 'wireframe' mode and sidebar already collapsed
    this.activate(preview_mode, true, true, ! $top_body.hasClass('folded') || preview_mode !== 'wireframe');

    if (isBFB) {
      if ('wireframe' === preview_mode) {
        this.handleTopDocumentColumnChange();
      }

      Utils.$topWindow().on('resize', this.handleTopWindowResize);
      Utils.$topDocument().on('postboxes-columnchange', this.handleTopDocumentColumnChange);
      Utils.$topWindow('#collapse-button').on('click', this.handleBFBAdminMenuManuallyFoldedChange);
    }

    Utils.$appWindow().off('wheel.ETBuilderPreviewModes');
    Utils.$topWindow().off('wheel.ETBuilderPreviewModes');

    Utils.$appWindow().on('wheel.ETBuilderPreviewModes', this.onWheel);
    Utils.$topWindow().on('wheel.ETBuilderPreviewModes', this.onWheel);

    return this;
  };

  static instance(preview_mode) {
    if (! _instance) {
      _instance = new ETBuilderPreviewModes(preview_mode);
    }

    return _instance;
  }

  isAnimating = (early = true) => (early ? this.is_animating : this._is_animating);

  modeWidths() {
    const windowWidth               = Utils.topViewportWidth();
    const isModalSnapped            = this._isModalSnapped();
    const modalPreferredDimensions  = getModalPreferredDimensions();
    const modalPreferredSnapSetting = getModalPreferredSnapSettings();
    const { tablet }                = responsive_widths;
    const { phone }                 = responsive_widths;

    let wireframe;
    let zoom;
    let desktop;
    let modal     = 0;
    let scrollbar = 0;

    if (isModalSnapped) {
      if (includes(['left', 'right'], modalPreferredSnapSetting.snapLocation)) {
        modal = modalPreferredDimensions.width;
      }
    }

    if (isTB) {
      scrollbar = Utils.maybeGetScrollbarWidth();
    }

    if (isBFB) {
      const isDFM          = 'wireframe' !== this.current_mode;
      const adminMenu      = () => {
        if (windowWidth < get(ETBuilderBreakpoints, 'wpAdmin.mobileAdminBar')) {
          return 0;
        }

        if (windowWidth < get(ETBuilderBreakpoints, 'wpAdmin.autoFoldAdminMenu')) {
          return adminMenuWidthFolded;
        }

        return isDFM || this.bfbAdminMenuManuallyFolded ? adminMenuWidthFolded : adminMenuWidth;
      };
      const margin_padding = isDFM || isModalSnapped || this._isBFBMobile() ? (22 + 20) : (22 + 20 + 22);
      const sidebar        = isDFM || isModalSnapped || this._isBFBMobile() ? 0 : 278;

      wireframe = zoom = desktop = (windowWidth - adminMenu() - margin_padding - sidebar - modal);
    } else {
      wireframe = zoom = desktop = (windowWidth - modal - scrollbar);
    }

    return { wireframe, zoom, desktop, tablet, phone, modal };
  }

  onWheel = event => this._is_using_wheel = true;
*/
    /**
     * Set the style of the provided element with the option to prevent resize handlers
     * from firing on the window.
     *
     * @since 3.18
     *
     * @param {jQuery}  $container Element for which to set the style.
     * @param {object}  style      Style to set.
     * @param {boolean} [final]    Enable this to allow resize handlers to fire on the window.
     */
    /*
  setContainerStyle = ($container, style, final = false) => {
    if (! final) {
      this.is_animating = this._is_animating = true;
    }

    $container.css(style);

    const breakpoint = 680 + $top_body.find('#adminmenu').width();
    $top_body.toggleClass('et-bfb-small-screen', style.width && style.width <= breakpoint);

    if (! final) {
      this.is_animating = this._is_animating = false;
    }
  };

  waitForAnimation = () => {
    if (! this._is_animating) {
      return Promise.resolve();
    }

    return new Promise(resolve => {
      const waiting = setInterval(() => {
        if (! this._is_animating) {
          clearInterval(waiting);
          resolve();
        }
      }, 100);
    });
  };*/
}

export default ETBuilderPreviewModes;
