/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

import intersection from 'lodash/intersection';
import union from 'lodash/union';
import uniq from 'lodash/uniq';
import compact from 'lodash/compact';
import indexOf from 'lodash/indexOf';
import get from 'lodash/get';
import isEmpty from 'lodash/isEmpty';
import id from 'lodash/identity';
import negate from 'lodash/negate';
import castArray from 'lodash/castArray';
import diff from 'lodash/difference';
import keys from 'lodash/keys';
import endsWith from 'lodash/endsWith';
import some from 'lodash/some';
import isUndefined from 'lodash/isUndefined';
import Responsive from './responsive-options';
import Hover from './hover-options';
import { getOrderClass } from './module';
import Utils from './utils';
//import ETBuilderStore from '../stores/et-builder-store';


const toArr                             = i => castArray(i).filter(negate(isEmpty));
const animated_class                    = 'et-animated--vb';
const allowlistedModuleWrapperClassName = [
  'et_pb_hovered',
  'et_pb_sticky',
  'et_pb_sticky_module',
  'et_pb_sticky--editing',
  'et-fb-module-wrapper',
  'et_fb_locked_module',
  'et_pb_hidden_subject',
  'et_fb_editing_enabled',
  'et-first-child',
  'et-last-child',
  'et_fb_element_controls_visible',
  'et-fb-dragged',
];


let _waypoints_animated = false;

const _CSSModuleClassesMixin = {
  filters: id,
  shortcode_index: 0,
  defaultClasses(props) {
    const providedProps  = ! isUndefined(props) ? props : this.props;
    const hasFbSupport   = 'off' !== providedProps.vb_support;
    const isModuleItem   = providedProps.is_module_child;
    // const wireframe      = 'wireframe' === ETBuilderStore.getPreviewMode();
	
	// divi-woocommerce-customizer\includes\module_dependencies\utils.js
    const wireframe      = 'wireframe' === Utils.appWindow().ET_Builder.API.State.View_Mode;
    //const draggged       = ETBuilderStore.isDragEditedModule(this) && 'et-fb-dragged';
    const advancedModule = providedProps.advancedModule ? 'et-fb-advanced-module' : '';

    return wireframe
      ? [
        providedProps.type,
        advancedModule,
        'et_pb_module',
        'ui-sortable',
        this.orderClassName(),
        this.globalSavingClass(),
        this.globalModuleClass(),
      ]
      : (hasFbSupport || (! hasFbSupport && isModuleItem))
        ? [
          providedProps.type,
          'et_pb_module',
          'ui-sortable',
          this.orderClassName(),
          this.globalSavingClass(),
          this.globalModuleClass(),
          this.getAttrs().module_class || '',
          _waypoints_animated ? animated_class : '',
          'function' === typeof this.textOrientationClassName ? this.textOrientationClassName(providedProps) : '',
          'function' === typeof this.hideOnMobileClassName ? this.hideOnMobileClassName() : '',
          advancedModule,
          //draggged,
        ] : [
          'ui-sortable',
          'et_vb_supportless_module',
          'et_pb_module',
          this.orderClassName(),
          this.globalSavingClass(),
          this.globalModuleClass(),
          //draggged,
        ];
  },
  componentWillMount() {
    // Make sure that the classes aren't compounded from previous mixin usage
    this.shortcode_index = this.props.shortcode_index;
    this.filters         = id;
  },
  componentWillReceiveProps(nextProps) {
    this.shortcode_index = nextProps.shortcode_index;
    this.filters         = id;

    // Use updated props to generate correct classes
    this.cssClasses = this.defaultClasses(nextProps);

    // Make sure animated class is added, if a waypoint object was displayed on the screen
    if (! _waypoints_animated && indexOf(this.defaultClasses(), animated_class)) {
      _waypoints_animated = true;
    }
  },
  inheritModuleClassName(className) {
    // Remove all class name except some allowlisted class name
    const filters = this.filters || id;
    this.filters  = classes => intersection(allowlistedModuleWrapperClassName, filters(classes));

    this.addModuleClassName(className);
  },
  addModuleClassName(className) {
    const filters = this.filters || id;
    this.filters  = classes => union(filters(classes), toArr(className));
  },
  removeModuleClassName(className) {
    const filters = this.filters || id;
    this.filters  = classes => diff(filters(classes), toArr(className));
  },
  toggleModuleClassName(className, condition) {
    return condition ? this.addModuleClassName(className) : this.removeModuleClassName(className);
  },
  /*
  ABTestingClassName() {
    if (! ETBuilderStore.abIsMode('off')) {
      if (ETBuilderStore.abIsSubject(this.props)) {
        this.addModuleClassName('et_pb_ab_subject');
        this.addModuleClassName(`et_pb_ab_subject_id-${get(ETBuilderBackend, 'currentPage.id', '')}_${get(this, 'props.attrs.ab_subject_id', '')}`);
      }

      if (ETBuilderStore.abIsGoal(this.props)) {
        this.addModuleClassName('et_pb_ab_goal');
        this.addModuleClassName(`et_pb_ab_goal-${get(ETBuilderBackend, 'currentPage.id', '')}`);
      }
    }
  },
  */
  orderClassName() {
    return getOrderClass(this);
  },

  /**
   * Get text orientation class name.
   *
   * @since 3.23 Add responsive class name for responsive settings.
   *
   * @param  {object} props Module props.
   * @returns {string}       Text orientation class names.
   */
  textOrientationClassName(props) {
    const providedProps = ! isUndefined(props) ? props : this.props;

    const textOrientations    = Responsive.getPropertyValues(this.getAttrs(), 'text_orientation');
    let textOrientation       = Utils.getTextOrientation(textOrientations.desktop);
    let textOrientationTablet = Utils.getTextOrientation(textOrientations.tablet);
    let textOrientationPhone  = Utils.getTextOrientation(textOrientations.phone);

    // Should be `justified` instead of justify in classname.
    textOrientation = 'justify' === textOrientation ? 'justified' : textOrientation;
    textOrientationTablet = 'justify' === textOrientationTablet ? 'justified' : textOrientationTablet;
    textOrientationPhone = 'justify' === textOrientationPhone ? 'justified' : textOrientationPhone;

    let textOrientationClass = '';
    if (Utils.hasValue(textOrientation)) {
      textOrientationClass += `et_pb_text_align_${textOrientation}`;
    }

    if (Utils.hasValue(textOrientationTablet)) {
      textOrientationClass += '' === textOrientationClass ? `et_pb_text_align_${textOrientationTablet}-tablet` : ` et_pb_text_align_${textOrientationTablet}-tablet`;
    }

    if (Utils.hasValue(textOrientationPhone)) {
      textOrientationClass += '' === textOrientationClass ? `et_pb_text_align_${textOrientationPhone}-phone` : ` et_pb_text_align_${textOrientationPhone}-phone`;
    }

    return textOrientationClass;
  },
  hideOnMobileClassName() {
    return Utils.isOn(this.getAttrs().hide_on_mobile) ? 'et-hide-mobile' : '';
  },
  moduleClassNameArray() {
    const filters = this.filters || id;
    return uniq(compact(filters(this.defaultClasses())));
  },

  /**
   * Get module class names.
   *
   * @since 3.23 Add support to return animation class based on responsive settings.
   *
   * @param  {boolean} skipAnimation Skip animation status.
   * @returns {string}                All module class names.
   */
  moduleClassName(skipAnimation) {
    const device = Utils.appWindow().ET_Builder.API.State.View_Mode;
    if ('wireframe' === device) {
      return this.moduleClassNameArray().join(' ');
    }

    // Add animation class name.
    // This has to be done inside moduleClassName() to ensure that animation gets correct props from correct cycle.
    const animationStyle = skipAnimation || /*! ETBuilderStore.isAnimatingModule(this.props) ?*/ 'none' /*: get(this, 'props.attrs.animation_style', 'none')*/;

    if (Utils.hasValue(animationStyle) && 'none' !== animationStyle) {
      // Toggle et_animated class to start/restart animation
      const module = this.refs.module || this._section || this._row || this._column;
      if (module) {
        module.classList.remove('et_animated');
        setTimeout(() => {
          module.classList.add('et_animated');
        }, 0);
      }

      // Add classname which its style "disables" animation styling. Animation is disabled on VB and only
      // rendered when user changes animation configuration on settings modal
      if (isUndefined(this.props._v)) {
        this.addModuleClassName('et_animated--onload');
      }

      // Add animation class name
      let animationClassName = animationStyle;

      const attrs = this.getAttrs();

      let animationDirection = Responsive.getAnyValue(attrs, 'animation_direction', 'center', true, device);
      if (- 1 !== indexOf(['top', 'right', 'bottom', 'left'], animationDirection)) {
        // Fade doesn't have direction
        if ('fade' === animationStyle) {
          animationDirection = '';
        }

        // Append animation direction
        animationClassName += animationDirection.charAt(0).toUpperCase() + animationDirection.slice(1);
      }

      if (Utils.hasValue(animationClassName)) {
        this.addModuleClassName(animationClassName);
      }

      // Add animation repeat class name
      const animation_repeat = Responsive.getAnyValue(attrs, 'animation_repeat', 'once', true, device);

      if ('loop' === animation_repeat) {
        this.addModuleClassName('infinite');
      }
    }

    // This is only needed in hover mode for the hover preview.
    if (Hover.isHoverMode()) {
      const attrs              = this.getAttrs();
      const attrNames          = keys(attrs);
      const hoverEnabledSuffix = Hover.enabledSuffix();
      const hasHoverEnabled    = some(attrNames, attr => endsWith(attr, hoverEnabledSuffix) && Utils.isOn(attrs[attr]));

      if (hasHoverEnabled) {
        // This requires a separate class because we don't
        // want to trigger it on actual hover in VB.
        this.addModuleClassName('et_hover_enabled_preview');
      }
    }

    return this.moduleClassNameArray().join(' ');
  },
  moduleID() {
    const hasFbSupport = 'off' !== this.props.vb_support;
    const isModuleItem = this.props.is_module_child;
    const wireframe    = 'wireframe' === Utils.appWindow().ET_Builder.API.State.View_Mode;

    return ! wireframe && (hasFbSupport || (! hasFbSupport && isModuleItem)) ? this.getAttrs().module_id : '';
  },
  globalSavingClass() {
    if (this.getAttrs().savingGlobal) {
      return 'et_fb_saving_global_module';
    }
    return false;
  },
  globalModuleClass() {
    if (typeof this.getAttrs().global_module !== 'undefined' && '' !== this.getAttrs().global_module) {
      return 'et_fb_global_module';
    }
    return false;
  },
  linkRel(name, isModuleItem) {
    let savedRel = get(this.getAttrs(), [`${name}_rel`], '');

    if (isModuleItem && (! Utils.hasValue(savedRel) || 'off|off|off|off|off' === savedRel) && get(this, ['props', 'parentAttrs', `${name}_rel`])) {
      savedRel = get(this, ['props', 'parentAttrs', `${name}_rel`]);
    }

    return Utils.linkRel(savedRel);
  },
};


const {
  defaultClasses,
  componentWillMount,
  componentWillReceiveProps,
  inheritModuleClassName,
  addModuleClassName,
  removeModuleClassName,
  toggleModuleClassName,
  orderClassName,
  hideOnMobileClassName,
  moduleClassNameArray,
  moduleClassName,
  moduleID,
  globalSavingClass,
  globalModuleClass,
  textOrientationClassName,
  linkRel,
  //ABTestingClassName,
} = _CSSModuleClassesMixin;

export {
  defaultClasses,
  componentWillMount,
  componentWillReceiveProps,
  inheritModuleClassName,
  addModuleClassName,
  removeModuleClassName,
  toggleModuleClassName,
  orderClassName,
  hideOnMobileClassName,
  moduleClassNameArray,
  moduleClassName,
  moduleID,
  globalSavingClass,
  globalModuleClass,
  textOrientationClassName,
  linkRel,
  //ABTestingClassName,
};

export default _CSSModuleClassesMixin;
