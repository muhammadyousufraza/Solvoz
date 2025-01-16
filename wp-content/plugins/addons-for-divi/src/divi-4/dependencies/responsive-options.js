/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

// External dependencies
import forEach from 'lodash/forEach';
import get from 'lodash/get';
import last from 'lodash/last';
import endsWith from 'lodash/endsWith';
import includes from 'lodash/includes';
import isUndefined from 'lodash/isUndefined';
import isString from 'lodash/isString';
import isEmpty from 'lodash/isEmpty';
import isArray from 'lodash/isArray';
import isObject from 'lodash/isObject';

// Internal dependencies
// import ETBuilderStore from './et-builder-store';
import ETBuilderPreviewModes from './previewModes';
// import ETBuilderComponentDefinitionStore from './et-builder-component-definition-store';
import ETBuilderOffsets from './et-builder-offsets';
import Utils from './utils';
import Hover from './hover-options';
import ResponsivePure from './responsive-options-pure';

/**
 * Check if responsive settings is enabled or not on the option.
 *
 * @since 3.23
 * @since 3.26.7 Move it to responsive options pure library.
 */
export const {isResponsiveEnabled} = ResponsivePure;

/**
 * Check if responsive settings are enabled on the list of options.
 *
 * @since 3.23
 *
 * @param  {Array} attrs All module attributes.
 * @param  {Array} list  Options list.
 * @returns {boolean}     Responsive styles status.
 */
export const isAnyResponsiveEnabled = (attrs = {}, list) => {
    // Ensure list is not empty and valid array.
    if (isEmpty(list) || !isArray(list)) {
        return false;
    }

    // Check the responsive status one by one.
    let isAnyResponsiveActive = false;
    forEach(list, (name) => {
        if (isResponsiveEnabled(attrs, name)) {
            isAnyResponsiveActive = true;
            return false;
        }
    });

    return isAnyResponsiveActive;
};

/**
 * Check if current option is in tablet or phone mode and the responsive setting is enabled.
 *
 * @since 3.23
 *
 * @param {object} props Settings modal props.
 * @param {object} attrs Module attrs.
 * @param {string} name  Field name.
 *
 * @returns {boolean} Status.
 */
export const isMobileSettingsEnabled = (props, attrs, name) => {
    const isResponsive = isResponsiveEnabled(attrs, name);
    const activeTabMode = get(props, 'activeTabMode', 'desktop');
    if (includes(getDevicesList('desktop'), activeTabMode) && isResponsive) {
        return true;
    }

    return false;
};

/**
 * Check if current value is acceptable or not. Why we don't use simple if (value) to check
 * acceptability? Because we may save 0 value for the option, and even empty string or false.
 *
 * @since 3.23
 * @since 3.26.7 Move it to responsive options pure library.
 *
 * @param  {Mixed} value Check if current.
 * @returns {boolean}     Value accepability status.
 */
export const {isValueAcceptable} = ResponsivePure;

/**
 * Check if a field's selected value is OR has a value
 * If responsive is active, field returns array of desktop, tablet and phone values.
 *
 * @since 4.6.0
 *
 * @param {string|object} fieldValue The field's value; if string, responsive mode isn't active.
 * @param {string}        value      Value to be compared / contained.
 *
 * @returns {bool}
 */
export const {isOrHasValue} = ResponsivePure;

/**
 * Check if current state is responsive but desktop or not responsive at all.
 *
 * Basically, not responsive means we are on normal mode with non suffix value and name are used.
 *
 * @since 3.23
 *
 * @param {object} props          Module, field, or control props.
 * @param {object} needResponsive If need to check responsive status.
 *
 * @returns {boolean} Desktop status.
 */
export const isMobile = (props, needResponsive = true) => {
    // Module pros should not be empty.
    if (isEmpty(props)) {
        return false;
    }

    const isResponsive = needResponsive ? get(props, 'isResponsive', false) : true;
    const activeTabMode = get(props, 'activeTabMode', 'desktop');

    return isResponsive && includes(getDevicesList('desktop'), activeTabMode);
};

/**
 * Check if current field name already contains responsive suffix.
 *
 * @since 3.23
 *
 * @param  {string} name Field name.
 * @returns {boolean}     Responsive suffix status.
 */
export const isFieldBaseName = (name) => {
    let isFieldBaseName = false;
    forEach(getDevicesList('desktop'), (device) => {
        if (endsWith(name, `_${device}`)) {
            isFieldBaseName = true;
        }
    });

    return isFieldBaseName;
};

/**
 * Check if current option has mobile_options and it's not false.
 *
 * @since 3.23
 * @since 3.26.7 Move it to responsive options pure library.
 *
 * @param  {object}  props Option props.
 * @returns {boolean}       Mobile options prop status.
 */
export const {hasMobileOptions} = ResponsivePure;

/**
 * Check responsive value existence of responsive inputs (text/range/text margin) by passing its
 * *_last_edited value.
 *
 * Copy of Utils.getResponsiveStatus(). Moved here to organize the code.
 *
 * @since 3.23
 * @since 3.26.7 Move it to responsive options pure library.
 */
export const {getResponsiveStatus} = ResponsivePure;

/**
 * @inheritDoc
 */
export const {getValue} = ResponsivePure;

/**
 * @inheritDoc
 */
export const {getAnyValue} = ResponsivePure;

/**
 * @inheritDoc
 */
export const {getAnyDefinedValue} = ResponsivePure;

/**
 * Get property's values for requested device.
 *
 * This function is added to summarize how we fetch desktop/hover/tablet/phone value. This
 * function still uses getAnyValue to get current device values.
 *
 * @since 3.23
 *
 * @param {object}  attrs        List of all attributes and values.
 * @param {string}  name         Property name.
 * @param {Mixed}   defaultValue Default value.
 * @param {string}  device       Device name.
 * @param {boolean} needHover    Need hover value status.
 * @param {boolean} forceReturn  Force to return any values found.
 *
 * @returns {object} Pair of devices and the values.
 */
export const getPropertyValue = (
    attrs,
    name,
    defaultValue = '',
    device = 'dekstop',
    needHover = false,
    forceReturn = false
) => {
    // Default values.
    let value = defaultValue;

    // Ensure device is not empty.
    device = '' === device ? 'desktop' : device;

    // Ensure attrs (values list) and name (property name) are not empty.
    if (isEmpty(attrs) || '' === name) {
        return value;
    }

    // Responsive and Hover status.
    const isEnabled = 'desktop' !== device ? isResponsiveEnabled(attrs, name) : true;
    const isHover = needHover && Hover.isHoverMode() && Hover.isEnabled(name, attrs);
    const suffix = 'desktop' !== device ? `_${device}` : '';

    value = isEnabled ? getAnyValue(attrs, `${name}${suffix}`, defaultValue, forceReturn) : defaultValue;
    if (isHover) {
        value = Hover.getHoverOrNormalOnHover(name, attrs);
    }

    return value;
};

/**
 * Get all properties values for all devices.
 *
 * This function is added to summarize how we fetch desktop/hover, tablet, and phone values. This
 * function still use getAnyValue to get current device values.
 *
 * @since 3.23
 *
 * @param {object}  attrs        List of all attributes and values.
 * @param {string}  name         Property name.
 * @param {Mixed}   defaultValue Default value.
 * @param {boolean} needHover    Need hover value status.
 * @param {boolean} forceReturn  Force to return any values found.
 *
 * @returns {object} Pair of devices and the values.
 */
export const getPropertyValues = (attrs, name, defaultValue = '', needHover = false, forceReturn = false) => {
    // Default values.
    const values = {
        desktop: defaultValue,
        tablet: defaultValue,
        phone: defaultValue,
    };

    // Ensure attrs (values list) and name (property name) are not empty.
    if (isEmpty(attrs) || '' === name) {
        return values;
    }

    const isResponsive = isResponsiveEnabled(attrs, name);
    const isHover = needHover && Hover.isHoverMode() && Hover.isEnabled(name, attrs);

    // Get values for each devices.
    values.desktop = isHover
        ? Hover.getHoverOrNormalOnHover(name, attrs)
        : getAnyValue(attrs, name, defaultValue, forceReturn);
    values.tablet =
        isResponsive && !isHover ? getAnyValue(attrs, `${name}_tablet`, defaultValue, forceReturn) : defaultValue;
    values.phone =
        isResponsive && !isHover ? getAnyValue(attrs, `${name}_phone`, defaultValue, forceReturn) : defaultValue;

    return values;
};

/**
 * Get property value after checking whether it uses responsive or not.
 *
 * If responsive is used, automatically return array of all devices value.
 * If responsive is not used, return string of desktop value.
 *
 * @since 4.6.0
 *
 * @param {object}  attrs        List of all attributes and values.
 * @param {string}  name         Property name.
 * @param {Mixed}   defaultValue Default value.
 * @param {boolean} needHover    Need hover value status.
 * @param {boolean} forceReturn  Force to return any values found.
 *
 * @returns {object|string}
 */
export const getCheckedPropertyValue = (attrs, name, defaultValue = '', needHover = false, forceReturn = false) => {
    const isResponsive = isResponsiveEnabled(attrs, name);

    return isResponsive
        ? getPropertyValues(attrs, name, defaultValue, needHover, forceReturn)
        : getPropertyValue(attrs, name, defaultValue, 'desktop', needHover, forceReturn);
};

/**
 * Get composite property's value for requested device.
 *
 * This function is added to summarize how we fetch desktop/hover/tablet/phone value. This
 * function still uses getAnyValue to get current device values.
 *
 * @since 3.27.4
 *
 * @param {object}  attrs         List of all attributes and values.
 * @param {string}  compositeName Composite property name.
 * @param {string}  name          Property name.
 * @param {mixed}   defaultValue  Default value.
 * @param {string}  device        Device name.
 * @param {boolean} needHover     Need hover value status.
 * @param {boolean} forceReturn   Force to return any values found.
 *
 * @returns {object} Pair of devices and the values.
 */
export const getCompositePropertyValue = (
    attrs,
    compositeName,
    name,
    defaultValue = '',
    device = 'dekstop',
    needHover = false,
    forceReturn = false
) => {
    // Default values.
    let value = defaultValue;

    // Ensure device is not empty.
    device = '' === device ? 'desktop' : device;

    // Ensure attrs, composite name (parent property name), name (property name) are not empty.
    if (isEmpty(attrs) || '' === compositeName || '' === name) {
        return value;
    }

    // Responsive and Hover status.
    const isEnabled = 'desktop' !== device ? isResponsiveEnabled(attrs, compositeName) : true;
    const isHover = needHover && Hover.isHoverMode() && Hover.isEnabled(compositeName, attrs);
    const suffix = 'desktop' !== device ? `_${device}` : '';

    value = isEnabled ? getAnyValue(attrs, `${name}${suffix}`, defaultValue, forceReturn) : defaultValue;

    if (isHover) {
        value = Hover.getHoverOrNormalOnHover(name, attrs);
    }

    return value;
};

/**
 * Get all composite properties values for all devices.
 *
 * This function is added to summarize how we fetch desktop/hover, tablet, and phone values. This
 * function still use getAnyValue to get current device values.
 *
 * @since 3.27.4
 *
 * @param {object}  attrs         List of all attributes and values.
 * @param {string}  compositeName Composite field name.
 * @param {string}  name          Property name.
 * @param {mixed}   defaultValue  Default value.
 * @param {boolean} needHover     Need hover value status.
 * @param {boolean} forceReturn   Force to return any values found.
 *
 * @returns {object} Pair of devices and the values.
 */
export const getCompositePropertyValues = (
    attrs,
    compositeName,
    name,
    defaultValue = '',
    needHover = false,
    forceReturn = false
) => {
    // Default values.
    const values = {
        desktop: defaultValue,
        tablet: defaultValue,
        phone: defaultValue,
    };

    // Ensure attrs, composite name (parent property name), name (property name) are not empty.
    if (isEmpty(attrs) || '' === compositeName || '' === name) {
        return values;
    }

    const isResponsive = isResponsiveEnabled(attrs, compositeName);
    const isHover = needHover && Hover.isHoverMode() && Hover.isEnabled(compositeName, attrs);

    // Get values for each devices.
    values.desktop = isHover
        ? Hover.getCompositeValue(name, compositeName, attrs)
        : getAnyValue(attrs, name, defaultValue, forceReturn);
    values.tablet =
        isResponsive && !isHover ? getAnyValue(attrs, `${name}_tablet`, defaultValue, forceReturn) : defaultValue;
    values.phone =
        isResponsive && !isHover ? getAnyValue(attrs, `${name}_phone`, defaultValue, forceReturn) : defaultValue;

    return values;
};

/**
 * Get some current active device values from attributes.
 *
 * Basically, this function is combination of:
 * - Get any value of attribute
 * - Check attribute responsive status for tablet/phone
 * - Only send non empty attributes, except you force to return any given value
 * - Doing all of the process above for more than one fields.
 *
 * @since 3.23
 *
 * @param  {Array}   attrs       All module attributes.
 * @param  {string}  list        List of options name. Name should be field base name.
 * @param  {boolean} forceReturn Force to return any value.
 * @param  {string}  device      Current device name.
 *
 * @returns {Array} All option values.
 */
export const getAnyResponsiveValues = (attrs, list, forceReturn = false, device = 'desktop') => {
    // Ensure list is not empty and valid array.
    if (isEmpty(list) || !isObject(list)) {
        return {};
    }

    // Ensure device is not empty.
    device = '' === device ? 'desktop' : device;

    // Fetch each attribute and store it in $values.
    const values = {};
    forEach(list, (defaultValue, name) => {
        // Check responsive status if current device is tablet or phone.
        if ('desktop' !== device && !isResponsiveEnabled(attrs, name)) {
            return;
        }

        // Get value.
        const value = getAnyValue(attrs, name, defaultValue, forceReturn, device);

        // No need to save the value if it's empty and we don't force to return any value.
        if (!forceReturn && isEmpty(value)) {
            return;
        }

        values[name] = value;
    });

    return values;
};

/**
 * @inheritDoc
 */
export const {getDefaultValue} = ResponsivePure;

/**
 * @inheritDoc
 */
export const {getDefaultDefinedValue} = ResponsivePure;

/**
 * @inheritDoc
 */
export const {getNonEmpty} = ResponsivePure;

/**
 * Returns the field responsive name by adding the `_tablet` or `_phone` suffix if it exists.
 *
 * @since 3.24.1
 * @since 3.26.7 Move it to responsive options pure library.
 *
 * @param {string} name   Setting name.
 * @param {string} device Device name.
 *
 * @returns {string} Responsive setting name.
 */
export const {getFieldName} = ResponsivePure;

/**
 * Return all fields name with responsive suffix.
 *
 * @since 4.0
 *
 * @param  {string}  name
 * @param  {boolean} needBaseName
 * @param  {boolean} needLastEdited
 * @returns {Array}
 */
export const {getFieldNames} = ResponsivePure;

/**
 * Returns the field original name by removing the `_tablet` or `_phone` suffix if it exists.
 *
 * Only remove desktop/tablet/phone string of the last setting name. Doesn't work for other format.
 *
 * @since 3.23
 * @since 3.26.7 Move it to responsive options pure library.
 *
 * @param {string} name Setting name.
 *
 * @returns {string} Base setting name.
 */
export const {getFieldBaseName} = ResponsivePure;

/**
 * Returns the device name by removing the `name` prefix.
 *
 * @since 3.23
 *
 * @param {string} name Setting name.
 *
 * @returns {string} Device name.
 */
export const getDeviceName = (name) => {
    // Field name should be string and not empty.
    if (isEmpty(name) || !isString(name)) {
        return '';
    }

    // Ensure namePieces length is enough. If only one, just return current setting name.
    const namePieces = name.split('_');
    if (namePieces.length <= 1) {
        return '';
    }

    const device = last(namePieces);
    const isSuffixExist = includes(getDevicesList(), device);

    // Ensure device is valid.
    if (!isSuffixExist || 'desktop' === device) {
        return '';
    }

    // Return device name.
    return device;
};

/**
 * Get active tab field name contains base name and current active tab as suffix.
 *
 * Should be used only under settings modal. Don't use this if you want to add the suffix manually.
 *
 * @since 3.23
 *
 * @param {string} baseName Field base name.
 * @param {object} props    Module props.
 *
 * @returns {string} Responsive field name.
 */
export const getActiveSettingName = (baseName, props) => {
    // Module pros and field base name should not be empty.
    if (isEmpty(props) || isEmpty(baseName) || !isString(baseName)) {
        return baseName;
    }

    // Ensure no suffix added previously.
    const baseNamePieces = baseName.split('_');
    if (includes(getDevicesList(), last(baseNamePieces))) {
        return baseName;
    }

    // Return base name with suffix only if it's not desktop.
    const isResponsive = get(props, 'isResponsive', false);
    const activeTabMode = get(props, 'activeTabMode', 'desktop');
    if (isResponsive && activeTabMode !== 'desktop') {
        return `${baseName}_${activeTabMode}`;
    }

    return baseName;
};

/**
 * Get inherited field name if current field value is inherited from bigger device.
 *
 * For example:
 * background_image_tablet current value is inherited from background_image, so this
 * function will return background_image field name.
 *
 * @since 3.23
 *
 * @param {object} props            Background field props.
 * @param {object} attrs            Module attrs.
 * @param {string} fieldName        Field name with suffix (_tablet, __hover, _phone).
 * @param {string} defaultFieldName Field name without suffix.
 *
 * @returns {string} Inherited field name without suffix.
 */
export const getInheritedSettingName = (props, attrs, fieldName, defaultFieldName) => {
    // Just return default field name, if current device is desktop and not hover.
    const device = props.activeTabMode;
    const isHover = Hover.isHoverMode();
    if ('desktop' === device && !isHover) {
        return defaultFieldName;
    }

    // Get pure field value (without inheritance) and inherited value.
    const fieldValue = isHover ? get(attrs, fieldName, '') : getAnyValue(attrs, fieldName);
    const inheritedValue = isHover
        ? get(attrs, fieldName.replace(Hover.hoverSuffix(), ''), '')
        : getAnyValue(attrs, fieldName, '', true);

    // If original field value is empty and the value is inherited.
    if ('' === fieldValue && inheritedValue) {
        // Hover. Just return default field name.
        if (isHover) {
            return defaultFieldName;
        }

        const fieldBaseName = getFieldBaseName(fieldName);

        // If current device is tablet or phone and tablet value exists, return field name with tablet suffix.
        const fieldValueTablet = getAnyValue(attrs, `${fieldBaseName}_tablet`);
        if ('' !== fieldValueTablet) {
            return `${fieldBaseName}_tablet`;
        }

        // If current device is tablet or phone and desktop value exists, return field base name.
        const fieldValueDesktop = getAnyValue(attrs, fieldBaseName);
        if ('' !== fieldValueDesktop) {
            return fieldBaseName;
        }
    }

    return fieldName;
};

/**
 * Get initial active responsive tab.
 * - Calculate current active preview mode on builder. The active mode will be one of desktop,
 *   tablet, phone, or wireframe. How about zoom? Zoom mode is basically desktop mode. It will
 *   be converted to desktop on getCalculatedPreviewMode().
 * - Return calculated mode as the initial active tab.
 * - However, if the calculated mode is not valid device, we have to return desktop value just
 *   to make sure it has valid device value (desktop, tablet, phone).
 *
 * - Don't use it for the actual action to get current active tab. Why? Because in settings
 *   modal we will save current active tab in the state. It will be actual and can be used
 *   on the field controls under settings modal. Be wise to use it only to get initial active
 *   tab during first rendering.
 *
 * Currently used by:
 * - Settings modal.
 *
 * @since 3.23
 *
 * @returns {string} Reposive active tab.
 */
export const getInitialActiveTabMode = () => {
    // Calculate current active preview mode.
    const mode = getCalculatedPreviewMode();

    // Ensure calculated mode is one of valid devices.
    const devices = getDevicesList();
    return includes(devices, mode) ? mode : 'desktop';
};

/**
 * Get calculated preview mode.
 * - Get current preview mode first. We don't want to use it as active tab since the value is not
 *   really up to date. We need it to ensure if it's actual device or maybe desktop or wireframe.
 * - If the current active mode is not zoom or wireframe, we need to calculate $appWindow widht
 *   to get the correct view mode.
 *
 * @since 3.23
 *
 * @returns {string} Calculated preview mode.
 */
export const getCalculatedPreviewMode = () => {
    // Get current preview mode.
    // const previewMode = ETBuilderStore.getPreviewMode();
    const previewMode = window.ET_Builder.Frames.app.ET_Builder.API.State.View_Mode.current;

    // Bail early if current preview mode is zoom of wireframe.
    if ('zoom' === previewMode) {
        return 'desktop';
    }
    if ('wireframe' === previewMode) {
        return 'wireframe';
    }

    // Calculate current view mode based on $appWindow width. Desktop, Tablet, or Phone.
    const ETPreviewModes = ETBuilderPreviewModes.instance();
    return ETPreviewModes.getViewModeByWidth(Utils.$appWindow().width());
};

/**
 * Get list of all or selected devices.
 *
 * Default devices are desktop, tablet, and phone. Just in case we want to extend it, we have to
 * edit variable defaultDevices.
 *
 * @since 3.23
 * @since 3.26.7 Move it to responsive options pure library.
 *
 * @param {Array | string} ignoredDevices Ignored devices. Can be string or array to pass multiple devices.
 *
 * @returns {Array} Selected devices.
 */
export const {getDevicesList} = ResponsivePure;

/**
 * Get view mode by width.
 *
 * Copy of ETPreviewModes.getViewModeByWidth.
 *
 * @param {string} value Preview width.
 *
 * @returns {string} Mode name.
 */
export const getModeByWidth = (value) => {
    const responsiveWidth = ETBuilderOffsets.responsive;

    let mode = 'desktop';
    if (value <= responsiveWidth.phone) {
        mode = 'phone';
    } else if (value <= responsiveWidth.tablet) {
        mode = 'tablet';
    }

    return mode;
};

/**
 * Get responsive break points based on the options last_edited status.
 *
 * @since 3.23
 *
 * @param {object} allValues  All advanced settings module value.
 * @param {Array}  properties Options group properties.
 * @param {string} label      Field option label.
 * @param {string} element    Element or options group label.
 *
 * @returns {Array} Correct responsive breakpoint.
 */
export const getDevicesByLastEdited = (allValues, properties, label, element) => {
    let isResponsive = false;

    // Check last_edited status for all properties.
    forEach(properties, (property) => {
        // Build property name.
        const prefix = label ? `${label}_` : '';
        const propertyName = `${prefix}${element}_${property}`;

        // Get last edited value to clarify the responsive status.
        const lastEdited = get(allValues, `${propertyName}_last_edited`, '');
        isResponsive = getResponsiveStatus(lastEdited);

        // Stop early if we already know responsive is enabled on one of the options.
        if (isResponsive) {
            return false;
        }
    });

    // Return all devices if responsive is enabled.
    return isResponsive ? ['tablet', 'phone'] : [];
};

/**
 * Get breakpoint based on device name.
 *
 * @since 3.23
 * @since 4.0 Introduces min_width_768 for desktop & tablet only.
 *
 * @param {string} device Device name.
 *
 * @returns {string} Device breakpoint.
 */
export const getBreakpointByDevice = (device) => {
    switch (device) {
        case 'desktop_only':
            return 'min_width_981';
        case 'tablet':
            return 'max_width_980';
        case 'tablet_only':
            return '768_980';
        case 'desktop_tablet_only':
            return 'min_width_768';
        case 'phone':
            return 'max_width_767';
        default:
            return 'general';
    }
};

/**
 * Get tab name based on preview mode.
 *
 * @since 3.23
 *
 * @param {string} previewMode Current active preview mode.
 *
 * @returns {string} Active tab name.
 */
export const getTabByMode = (previewMode) => {
    switch (previewMode) {
        case 'wireframe':
        case 'zoom':
        case 'desktop':
            return Hover.isHoverMode() ? 'hover' : 'desktop';
            break;
        case 'tablet':
        case 'phone':
            return previewMode;
            break;
        default:
            return 'desktop';
            break;
    }
};

/**
 * Get icon font size value or default.
 *
 * @since 3.23
 *
 * @param {object} attrs        List of all attributes and values.
 * @param {string} moduleName   Module name.
 * @param {string} size         Original size either empty or valid string.
 * @param {string} defaultSize  Default icon size if any.
 * @param {string} iconSizeName Property name.
 * @param {string} useIconSize  Parent property name.
 *
 * @returns {string} Default or valid font size.
 */
export const getIconSize = (
    attrs,
    moduleName,
    size,
    defaultSize = '16px',
    iconSizeName = 'icon_font_size',
    useIconSize = 'use_icon_font_size'
) => {
    // Default icon size on definition store.
    // const defaultIconFontSize = get(ETBuilderComponentDefinitionStore.getComponentAdvancedField(moduleName, iconSizeName), 'default', defaultSize);
    const defaultIconFontSize = 0;

    // If undefined or not default size or custom setting off, return original value.
    return isUndefined(size) || size !== defaultIconFontSize || Utils.isOff(attrs[useIconSize]) ? size : defaultSize;
};

/**
 * Get all icon sizes values for all devices.
 *
 * This function is added to summarize how we fetch desktop/hover, tablet, and phone icon size
 * values. This function still use getIconSize to get device icon size values.
 *
 * @since 3.23
 *
 * @param {object}  attrs        List of all attributes and values.
 * @param {string}  moduleName   Module name.
 * @param {string}  propertyName Property name.
 * @param {boolean} needHover    Need hover value status.
 *
 * @returns {object} Pair of devices and the values.
 */
export const getIconSizes = (attrs, moduleName, propertyName, needHover = false) => {
    // Default values.
    const values = {
        desktop: '',
        tablet: '',
        phone: '',
    };

    // Ensure attrs (values list) and name (property & module) are not empty.
    if (isEmpty(attrs) || '' === moduleName || '' === propertyName) {
        return values;
    }

    const isResponsive = isResponsiveEnabled(attrs, propertyName);
    const isHover = needHover ? Hover.isHoverMode() : false;
    const desktopValue = getAnyValue(attrs, propertyName);
    const tabletValue = getAnyValue(attrs, `${propertyName}_tablet`);
    const phoneValue = getAnyValue(attrs, `${propertyName}_phone`);

    // Get icon size values for each devices.
    values.desktop = getIconSize(attrs, moduleName, Hover.getValueOnHover(propertyName, attrs, desktopValue));
    values.tablet = isResponsive && !isHover ? getIconSize(attrs, moduleName, tabletValue) : '';
    values.phone = isResponsive && !isHover ? getIconSize(attrs, moduleName, phoneValue) : '';

    return values;
};

/**
 * Get main background value based on enabled status of current field. It's used to selectively
 * get the correct color, gradient status, image, and video. It's introduced along with new
 * enable fields to decide should we remove or inherit the value from larger device.
 *
 * @since 3.24.1
 * @since 4.5.0 Set default for background color, image, gradient, and video to adapt Global Presets.
 *
 * @param {object} attrs          All module attributes.
 * @param {string} baseSetting    Setting need to be checked.
 * @param {string} mode           Current preview mode.
 * @param {string} backgroundBase Background base name (background, button_bg, etc.).
 * @param {string} moduleName     Module name.
 * @param {string} value          Active value.
 * @param {string} defaultValue   Active default value.
 *
 * @returns {object} Pair of new value and default value.
 */
/*
export const getInheritanceBackgroundValue = (attrs, baseSetting, mode, backgroundBase = 'background', moduleName = '', value = '', defaultValue = '') => {
  // Default new values is same with the generated one.
  const newValues = {
    default: defaultValue,
    value,
  };

  // Empty string  slug for desktop.
  const mapSlugs = {
    desktop: [''],
    hover: ['__hover', ''],
    sticky: ['__sticky', ''],
    tablet: ['_tablet', ''],
    phone: ['_phone', '_tablet', ''],
  };

  // Bail early if setting name is not listed on.
  const enabledFields = [`${backgroundBase}_color`, 'use_background_color_gradient', `${backgroundBase}_use_color_gradient`, `${backgroundBase}_image`, `${backgroundBase}_video_mp4`, `${backgroundBase}_video_webm`, `${backgroundBase}_video_webm`, `__video_${backgroundBase}`];
  if (! includes(enabledFields, baseSetting) || isUndefined(mapSlugs[mode])) {
    return newValues;
  }

  // Need to set value and defaultValue for the initial new default and value.
  let newValue              = value;
  let newDefault            = defaultValue;
  const isGlobalPresetsMode = ETBuilderStore.isGlobalPresetsMode();
  const fields              = ETBuilderComponentDefinitionStore.getComponentFields({
    props: {
      type: moduleName,
      attrs,
    },
  }, isGlobalPresetsMode);

  let originMp4Enabled  = '';
  let originMp4Data     = '';
  let originWebmEnabled = '';
  let originWebmData    = '';

  forEach(mapSlugs[mode], slug => {
    // Enabled Background Color and Image.
    if (includes([`${backgroundBase}_color`, `${backgroundBase}_image`, `${backgroundBase}_video_mp4`, `${backgroundBase}_video_webm`], baseSetting)) {
      const bgBaseType    = baseSetting.replace(`${backgroundBase}_`, '');
      const enableDefault = get(fields, `${backgroundBase}_enable_${bgBaseType}${slug}.default`, '');
      const enableValue   = get(attrs, `${backgroundBase}_enable_${bgBaseType}${slug}`, enableDefault);
      const bgDefault     = get(fields, `${backgroundBase}_${bgBaseType}${slug}.default`, '');
      const bgValue       = get(attrs, `${backgroundBase}_${bgBaseType}${slug}`, bgDefault);
      const isBgEnabled   = ! Utils.isOff(enableValue);

      if ('' !== bgValue && isBgEnabled) {
        newValue   = bgValue;
        newDefault = defaultValue;
        return false;
      } if (! isBgEnabled) {
        newValue   = '';
        newDefault = '';
        return false;
      }

    // Enabled Background Gradient.
    } else if (includes(['use_background_color_gradient', `${backgroundBase}_use_color_gradient`], baseSetting)) {
      newValue = 'off';

      const grdientMap = {
        use_background_color_gradient: {
          value: `use_background_color_gradient${slug}`,
          start: `${backgroundBase}_color_gradient_start${slug}`,
          end: `${backgroundBase}_color_gradient_end${slug}`,
        },
        [`${backgroundBase}_use_color_gradient`]: {
          value: `${backgroundBase}_use_color_gradient${slug}`,
          start: `${backgroundBase}_color_gradient_start${slug}`,
          end: `${backgroundBase}_color_gradient_end${slug}`,
        },
      };

      const selectedField = ! isUndefined(grdientMap[baseSetting]) ? grdientMap[baseSetting] : {};

      // Enable Gradient Field.
      const useGradientField   = get(fields, selectedField.value, {});
      const useGradientDefault = get(useGradientField, 'default', '');
      const useGradientValue   = get(attrs, selectedField.value, useGradientDefault);
      const isGradientEnabled  = ! Utils.isOff(useGradientValue);

      // Gradient Start Color Field.
      const gradientStartField   = get(fields, selectedField.start, {});
      const gradientStartDefault = get(gradientStartField, 'default', '');
      const gradientStartValue   = get(attrs, selectedField.start, gradientStartDefault);

      // Gradient End Color Field.
      const gradientEndField   = get(fields, selectedField.end, {});
      const gradientEndDefault = get(gradientEndField, 'default', '');
      const gradientEndValue   = get(attrs, selectedField.end, gradientEndDefault);

      if (('' !== gradientStartValue || '' !== gradientEndValue) && isGradientEnabled) {
        newValue = 'on';
        return false;
      } if (! isGradientEnabled) {
        newValue = 'off';
        return false;
      }
    } else if (`__video_${backgroundBase}` === baseSetting) {
      const baseSlug    = slug.replace(/_/g, '');
      const currentMode = '' !== baseSlug ? baseSlug : 'desktop';

      // Video markup.
      const videoBackground  = get(attrs, baseSetting, '');
      const videoBackgrounds = ! isObject(videoBackground) ? { desktop: videoBackground } : videoBackground;
      const videoValue       = get(videoBackgrounds, currentMode, '');

      // MP4.
      const enableMp4Default = get(fields, `${backgroundBase}_enable_video_mp4${slug}.default`, '');
      const enableMp4Value   = getAnyValue(attrs, `${backgroundBase}_enable_video_mp4${slug}`, enableMp4Default, true);
      const videoMp4Value    = ! includes(['hover', 'sticky'], currentMode) ? getAnyValue(attrs, `${backgroundBase}_video_mp4${slug}`, '', true) : get(attrs, `${backgroundBase}_video_mp4${slug}`, get(attrs, `${backgroundBase}_video_mp4`, ''));
      const isMp4Enabled     = ! Utils.isOff(enableMp4Value);

      if ('' === originMp4Enabled) {
        if ('' !== videoMp4Value && isMp4Enabled) {
          originMp4Enabled = 'enabled';
          originMp4Data    = {
            mode: currentMode,
            videoValue: videoMp4Value,
            videoBackground: videoValue,
          };
        } else if (! isMp4Enabled) {
          originMp4Enabled = 'disabled';
          originMp4Data    = {};
        }
      } else if ('enabled' === originMp4Enabled && ! Utils.hasValue(originMp4Data.videoBackground)) {
        originMp4Data.videoBackground = videoValue;
      }

      // Webm.
      const enableWebmDefault = get(fields, `${backgroundBase}_enable_video_webm${slug}.default`, '');
      const enableWebmValue   = getAnyValue(attrs, `${backgroundBase}_enable_video_webm${slug}`, enableWebmDefault, '');
      const videoWebmValue    = ! includes(['hover', 'sticky'], currentMode) ? getAnyValue(attrs, `${backgroundBase}_video_webm${slug}`, '', true) : get(attrs, `${backgroundBase}_video_webm${slug}`, get(attrs, `${backgroundBase}_video_webm`, ''));
      const isWebmEnabled     = ! Utils.isOff(enableWebmValue);

      if ('' === originWebmEnabled) {
        if ('' !== videoWebmValue && isWebmEnabled) {
          originWebmEnabled = 'enabled';
          originWebmData    = {
            mode: currentMode,
            videoValue: videoWebmValue,
            videoBackground: videoValue,
          };
        } else if (! isWebmEnabled) {
          originWebmEnabled = 'disabled';
          originWebmData    = {};
        }
      } else if ('enabled' === originWebmEnabled && ! Utils.hasValue(originWebmData.videoBackground)) {
        originWebmData.videoBackground = videoValue;
      }

      // Decide to display the video or not.
      if ('' !== slug) {
        return;
      }

      if ('disabled' === originMp4Enabled && 'disabled' === originWebmEnabled) {
        newValue = '';
      } else {
        const mp4VideoBackground  = get(originMp4Data, 'videoBackground', '');
        const webmVideoBackground = get(originWebmData, 'videoBackground', '');
        newValue = mp4VideoBackground || webmVideoBackground;
      }
    }
  });

  return { value: newValue, default: newDefault };
};
*/

/**
 * Generate last edited field name. It contains the field name with last_edited suffix.
 *
 * @since 3.23
 * @since 4.0 Move it to responsive options pure library.
 *
 * @param  {string} name Field name.
 * @returns {string}      Last edited field name.
 */
export const {getLastEditedFieldName} = ResponsivePure;

/**
 * Generate last edited string. It contains the last device used and responsive status.
 *
 * @since 3.23
 *
 * @param  {boolean} status        Responsive status.
 * @param  {string}  activeTabMode Current active tab.
 * @returns {string}                Last edited value.
 */
export const getLastEditedFieldValue = (status, activeTabMode) => {
    const statusString = status ? 'on' : 'off';
    activeTabMode = status ? activeTabMode : 'desktop';
    return `${statusString}|${activeTabMode}`;
};

/**
 * Generate responsive CSS.
 *
 * @since 3.23
 *
 * @param  {object}        values        All values of all devices.
 * @param  {string | object} selector      Main selector.
 * @param  {object}        cssProperty   CSS property.
 * @param  {string}        additionalCSS Custom additional CSS if needed.
 * @returns {Array}                       Processed CSS styles.
 */
export const generateResponsiveCSS = (values, selector, cssProperty = '', additionalCSS = '') => {
    // Ensure the values exists.
    if (isEmpty(values)) {
        return '';
    }

    const deviceList = getDevicesList();

    // To save all processed styles.
    const processedCSS = [];

    // Print each values.
    forEach(values, (value, device) => {
        // Ensure device name is valid.
        if (!includes(deviceList, device)) {
            return;
        }

        // Ensure the value is valid.
        if (isUndefined(value) || isEmpty(value)) {
            return;
        }

        // 1. Selector.
        // There are some cases where selector is an object contains specific selector for each devices.
        let CSSselector = selector;
        if (isObject(selector)) {
            CSSselector = !isUndefined(selector[device]) && !isEmpty(selector[device]) ? selector[device] : '';
        }

        if (isEmpty(CSSselector)) {
            return;
        }

        // 2. Append CSS.
        // We can set important status from additionalCSS.
        const appendCSS = !isUndefined(additionalCSS) && additionalCSS !== '' ? additionalCSS : ';';

        // 3. Declare CSS style.
        // There are some cases before we can declare the CSS style:
        // 1. The value is an object contains pair of properties and values.
        // 2. The value is single string but we have multiple properties exist.
        // 3. The value is single string with only one property.
        let declaration = '';

        if (isObject(value)) {
            // Allow to use array or object for the pair of properties and values.
            forEach(value, (currentValue, currentProperty) => {
                if (isEmpty(currentProperty) || isEmpty(currentValue)) {
                    return;
                }

                declaration += `${currentProperty}: ${currentValue}${appendCSS}`;
            });
        } else if (isArray(cssProperty)) {
            // Allow to use multiple properties in array for the same value.
            forEach(cssProperty, (currentProperty) => {
                if (isEmpty(currentProperty)) {
                    return;
                }

                declaration += `${currentProperty}: ${value}${appendCSS}`;
            });
        } else if (!isEmpty(cssProperty)) {
            declaration = `${cssProperty}: ${value}${appendCSS}`;
        }

        if (isEmpty(declaration)) {
            return;
        }

        const currentCSS = {
            selector: CSSselector,
            declaration,
            device,
        };

        processedCSS.push(currentCSS);
    });

    return processedCSS;
};

/**
 * @inheritDoc
 */
export const {getPreviousDevice} = ResponsivePure;

export default {
    isResponsiveEnabled,
    isAnyResponsiveEnabled,
    isMobileSettingsEnabled,
    isValueAcceptable,
    isOrHasValue,
    isMobile,
    isFieldBaseName,
    hasMobileOptions,
    getResponsiveStatus,
    getValue,
    getAnyValue,
    getAnyDefinedValue,
    getPropertyValue,
    getPropertyValues,
    getCompositePropertyValue,
    getCompositePropertyValues,
    getAnyResponsiveValues,
    getDefaultValue,
    getDefaultDefinedValue,
    getNonEmpty,
    getFieldName,
    getFieldNames,
    getFieldBaseName,
    getDeviceName,
    getActiveSettingName,
    getInheritedSettingName,
    getInitialActiveTabMode,
    getCalculatedPreviewMode,
    getDevicesList,
    getModeByWidth,
    getDevicesByLastEdited,
    getBreakpointByDevice,
    getTabByMode,
    getIconSize,
    getIconSizes,
    //getInheritanceBackgroundValue,
    getLastEditedFieldName,
    getLastEditedFieldValue,
    generateResponsiveCSS,
    getPreviousDevice,
};
