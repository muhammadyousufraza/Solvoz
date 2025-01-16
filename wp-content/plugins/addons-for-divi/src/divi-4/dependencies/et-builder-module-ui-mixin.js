/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

import isEqual from 'lodash/isEqual';
import isUndefined from 'lodash/isUndefined';
import forEach from 'lodash/forEach';
import get from 'lodash/get';

import ETBuilderStore from '../stores/et-builder-store';
import Utils from '../utils/utils';
import * as moduleUtils from '../utils/module';
import { canAddSiblings, isEditable, isInteractable, isLocked } from '../lib/module-utils';
import {
  getSettingNames,
} from './multi-view/base';


const ModuleUIMixin = {
  _shouldReinit(nextAttrs) {
    const thisClass   = this;
    const attrs       = nextAttrs || this.props.attrs;
    const reinitAttrs = {};
    let shouldReinit  = false;

    /**
     * Loop reinit attrs list.
     */
    forEach(getSettingNames(this.reinitAttrsList, true, true), attrName => {
      const reinitAttr = thisClass.reinitAttrs[attrName];
      const attr       = attrs[attrName];

      /**
       * Determine whether the component needs to be reinited or not.
       */
      if (! isEqual(reinitAttr, attr)) {
        shouldReinit = true;
      }

      reinitAttrs[attrName] = attrs[attrName];
    });

    /**
     * Update attrs that need to reinited.
     */
    this.reinitAttrs = reinitAttrs;

    return shouldReinit;
  },

  _shouldReinitByProps(nextProps, checkContentSizeOnly = false) {
    let shouldReinit = false;

    nextProps = nextProps || this.props;

    forEach(this.reinitPropsList, propName => {
      const prevProp = this.reinitProps[propName];
      const nextProp = nextProps[propName];

      if (isUndefined(prevProp) && isUndefined(nextProp)) {
        return;
      }

      const checkContentSize   = 'content' === propName && checkContentSizeOnly;
      const contentSizeChanged = checkContentSize && get(prevProp, 'length', 0) !== get(nextProp, 'length', 0);

      if ((! checkContentSize && ! isEqual(prevProp, nextProp)) || (isUndefined(prevProp) && ! isUndefined(nextProp)) || contentSizeChanged) {
        shouldReinit = true;
        this.reinitProps[propName] = nextProp;
      }
    });

    return shouldReinit;
  },

  _updateLoadingStatus() {
    this.loading = this.props.loading;
  },

  _updateLoadingByRowStatus() {
    this.rowLoading = get(this, 'props.row.props.loading', false);
  },

  _isDoneLoading() {
    return this.loading && ! this.props.loading;
  },

  _isDoneLoadingByRow() {
    return this.rowLoading && ! get(this, 'props.row.props.loading', false);
  },

  _applyFirstSectionAdjustment(property, isFullwidth) {
    // do not need to apply the adjustments for 3rd party themes
    if (Utils.isLimitedMode()) {
      return;
    }

    const $section            = jQuery(moduleUtils.getNode(this));
    const $mainHeader         = jQuery('#main-header');
    const isDesktopPreview    = 'desktop' === ETBuilderStore.getPreviewMode();
    const isSectionFirst      = '0' === this.props.address || (ETBuilderStore.abIsSubject(this.props) && 0 === $section.index());
    const $tbBodyParentModule = $section.closest('.et_pb_module');

    if ($tbBodyParentModule.length > 0) {
      const $tbBody        = $tbBodyParentModule.closest('.et-l--body');
      const $tbBodyModules = $tbBody.find('.et_pb_module:not(.et-l--post .et_pb_module)');
      const index          = $tbBodyModules.index($tbBodyParentModule);

      if (index > 0) {
        // This section is not the first section when accounting for the TB body
        // and as such should not get any top padding.
        return;
      }
    }

    if ($mainHeader.length && isSectionFirst) {
      // Cleanup inline property value
      $section.css(property, '');

      // do not apply adjustment on custom post type builder if builder has margin to top body due to post type elements
      if (Utils.condition('is_custom_post_type') && Utils.hasBodyMargin()) {
        return;
      }

      const mainHeaderBackgroundColor = $mainHeader.css('backgroundColor');
      const isVerticalNav             = jQuery('body').hasClass('et_vertical_nav');

      if (isDesktopPreview && Utils.appWindow().et_is_transparent_nav && ! isVerticalNav && isFullwidth && $section.find('.et_pb_module:first').is('.et_pb_fullwidth_menu')) {
        $section.css('paddingTop', 1);
      }

      if (Utils.appWindow().et_is_transparent_nav && ! isVerticalNav && ! isFullwidth) {
        if ('paddingTop' === property) {
          const hasTitle = jQuery('body.et_divi_theme #main-content .container:first-child .et_post_meta_wrapper:first h1.entry-title').length > 0;

          if (hasTitle) {
            // Do not adjust first section top padding when we are on a post page in Divi.
            return;
          }
        }

        // We need to disable section transitions while computing the property value
        $section.addClass('et_pb_section__notransition');
        const modulePropertyTop  = $section.css(property);
        const $topHeader         = jQuery('#top-header');
        const topHeaderHeight    = $topHeader.length ? $topHeader.outerHeight() : 0;
        const mainHeaderHeight   = $mainHeader.outerHeight();
        const sectionPropertyTop = parseInt(modulePropertyTop) + parseInt(mainHeaderHeight) + parseInt(topHeaderHeight);
        $section.css(property, sectionPropertyTop);

        // Restore transitions
        setTimeout(() => {
          $section.removeClass('et_pb_section__notransition');
        }, 0);
      }
    }
  },

  _applyFirstModuleAdjustment(property, childSelector) {
    // do not need to apply the adjustments for 3rd party themes
    if (Utils.isLimitedMode()) {
      return;
    }

    const $thisNode        = jQuery(moduleUtils.getNode(this));
    const $module          = isUndefined(childSelector) ? $thisNode : $thisNode.find(childSelector);
    const $mainHeader      = jQuery('#main-header');
    const isDesktopPreview = 'desktop' === ETBuilderStore.getPreviewMode();
    const isModuleFirst    = '0.0' === this.props.address || (ETBuilderStore.abIsSubject(this.props) && 0 === $thisNode.index('.et_pb_module'));

    if ($mainHeader.length && isModuleFirst) {
      // Cleanup inline property value
      $module.css(property, '');

      // do not apply adjustment on custom post type builder if builder has margin to top body due to post type elements
      if (Utils.condition('is_custom_post_type') && Utils.hasBodyMargin()) {
        return;
      }

      const mainHeaderBackgroundColor = $mainHeader.css('backgroundColor');
      const isVerticalNav             = jQuery('body').hasClass('et_vertical_nav');

      // Apply first row adjustment
      if (Utils.appWindow().et_is_transparent_nav && ! isVerticalNav) {
        // Wait until other animation (mainly drag and drop effect) is finished before kickstart adjustment calculation
        $module.promise().done(function() {
          const $animatedModule            = jQuery(this);
          const modulePropertyTop          = $animatedModule.css(property);
          const $topHeader                 = jQuery('#top-header');
          const topHeaderHeight            = $topHeader.length ? $topHeader.outerHeight() : 0;
          const mainHeaderHeight           = $mainHeader.outerHeight();
          const fullwidthModulePropertyTop = parseInt(modulePropertyTop) + parseInt(mainHeaderHeight) + parseInt(topHeaderHeight);

          $animatedModule.css(property, fullwidthModulePropertyTop);
        });
      }
    }
  },

  _applyFirstModuleAdjustmentOnSlide(property) {
    // do not need to apply the adjustments for 3rd party themes
    if (Utils.isLimitedMode()) {
      return;
    }

    const $module          = jQuery(moduleUtils.getNode(this));
    const $slides          = $module.find('.et_pb_slide');
    const $mainHeader      = jQuery('#main-header');
    const isDesktopPreview = 'desktop' === ETBuilderStore.getPreviewMode();

    if ($mainHeader.length && '0.0' === this.props.address) {
      // Cleanup inline property value
      $slides.css(property, '');

      // do not apply adjustment on custom post type builder if builder has margin to top body due to post type elements
      if (Utils.condition('is_custom_post_type') && Utils.hasBodyMargin()) {
        return;
      }

      const mainHeaderBackgroundColor = $mainHeader.css('backgroundColor');
      const $topHeader                = jQuery('#top-header');
      const topHeaderHeight           = $topHeader.length ? $topHeader.outerHeight() : 0;
      const isVerticalNav             = jQuery('body').hasClass('et_vertical_nav');

      // Apply first row adjustment
      if (isDesktopPreview && Utils.appWindow().et_is_transparent_nav && ! isVerticalNav) {
        const mainHeaderHeight = $mainHeader.outerHeight();

        $slides.each(function() {
          const $slide                    = jQuery(this);
          const slidePropertyTop          = $slide.css(property);
          const fullwidthSlidePropertyTop = parseInt(slidePropertyTop) + parseInt(mainHeaderHeight) + parseInt(topHeaderHeight);

          // add data attribute which needed to calculate the slider height properly
          $slide.data('adjustedHeight', fullwidthSlidePropertyTop);
          $slide.css(property, fullwidthSlidePropertyTop);
        });
      }
    }
  },

  _applyCollapsedClassName(elemName) {
    const $elem = jQuery(moduleUtils.getNode(this));

    /**
     * Always reset it first.
     */
    $elem.removeClass(`${elemName}--collapsed`);

    /**
     * Calculate and applying class name.
     */
    if (0 === $elem.height()) {
      $elem.addClass(`${elemName}--collapsed`);
    }
  },

  _isLocked() {
    return isLocked(Utils.isOn(this.props.attrs.locked), this.props.lockedParent);
  },

  _isEditable() {
    return isEditable(Utils.isOn(this.props.attrs.locked), this.props.lockedParent, this.props.attrs.global_module, this.props.globalParent, this.props.type);
  },

  _isInteractable() {
    return isInteractable(Utils.isOn(this.props.attrs.locked), this.props.lockedParent, this.props.globalParent);
  },

  _canAddSiblings() {
    return canAddSiblings(this.props.lockedParent, this.props.globalParent);
  },

  /**
   * Temporarily set CSS transition to none on mouse leave so that they don't interfere with the design workflow.
   *
   * @param e Event from onMouseLeave.
   * @private
   */
  _mouseLeaveTransition(e) {
    const { currentTarget } = e;

    if (Utils.hasValue(currentTarget)) {
      currentTarget.style.transition = 'none';
      setTimeout(() => {
        currentTarget.style.removeProperty('transition');
      }, 150);
    }
  },
};


const {
  _shouldReinit,
  _updateLoadingStatus,
  _isDoneLoading,
  _applyCollapsedClassName,
  _applyFirstModuleAdjustmentOnSlide,
  _applyFirstModuleAdjustment,
  _applyFirstSectionAdjustment,
  _isDoneLoadingByRow,
  _updateLoadingByRowStatus,
  _shouldReinitByProps,
  _isLocked,
  _isEditable,
  _isInteractable,
  _canAddSiblings,
  _mouseLeaveTransition,
} = ModuleUIMixin;

export {
  _shouldReinit,
  _updateLoadingStatus,
  _isDoneLoading,
  _applyCollapsedClassName,
  _applyFirstModuleAdjustmentOnSlide,
  _applyFirstModuleAdjustment,
  _applyFirstSectionAdjustment,
  _isDoneLoadingByRow,
  _updateLoadingByRowStatus,
  _shouldReinitByProps,
  _isLocked,
  _isEditable,
  _isInteractable,
  _canAddSiblings,
  _mouseLeaveTransition,
};

export default ModuleUIMixin;
