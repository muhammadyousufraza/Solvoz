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
// import {
//     get,
//     includes,
//     indexOf,
//     initial,
//     isEmpty,
//     isObject,
//     isString,
//     isUndefined,
//     join,
//     last,
//     lowerCase,
//     remove,
// } from 'lodash';

import get from 'lodash/get';
import includes from 'lodash/includes';
import indexOf from 'lodash/indexOf';
import initial from 'lodash/initial';
import isEmpty from 'lodash/isEmpty';
import isObject from 'lodash/isObject';
import isString from 'lodash/isString';
import isUndefined from 'lodash/isUndefined';
import join from 'lodash/join';
import last from 'lodash/last';
import lowerCase from 'lodash/lowerCase';
import remove from 'lodash/remove';

// Internal dependencies
import * as Pure from './pure';

/**
 * The list of supported devices for responsive.
 *
 * @since 3.26.7
 *
 * @type {string[]}
 */
const _devices = ['desktop', 'tablet', 'phone'];

/**
 * List of responsive devices exist.
 *
 * @since 3.26.7
 *
 * @returns {Array}
 */
export const responsiveDevices = () => _devices;

/**
 * Check if responsive settings is enabled or not on the option.
 *
 * @since 3.26.7
 *
 * @param {object} attrs All module attributes.
 * @param {string} name  Option name.
 *
 * @returns {boolean} Responsive settings status.
 */
export const isResponsiveEnabled = (attrs = {}, name = '') => {
    const lastEdited = get(attrs, `${name}_last_edited`, '');
    return getResponsiveStatus(lastEdited);
};

/**
 * Check if current value is acceptable or not. Why we don't use simple if (value) to check
 * acceptability? Because we may save 0 value for the option, and even empty string or false.
 *
 * @since 3.26.7
 *
 * @param  {string}  value Check if current.
 * @returns {boolean} Value acceptability status.
 */
export const isValueAcceptable = Pure.hasValue;

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
export const isOrHasValue = (fieldValue, value) => {
    const isResponsive = isObject(fieldValue);

    return isResponsive ? includes(fieldValue, value) : value === fieldValue;
};

/**
 * Check if current option has mobile_options and it's not false.
 *
 * @since 3.26.7
 *
 * @param  {object}  props Option props.
 * @returns {boolean}       Mobile options prop status.
 */
export const hasMobileOptions = (props) => get(props, 'mobile_options', false);

/**
 * Check responsive value existence of responsive inputs (text/range/text margin) by passing its
 * *_last_edited value.
 *
 * Copy of Utils.getResponsiveStatus(). Moved here to organize the code.
 *
 * @since 3.26.7
 *
 * @param {string} _last_edited Saved *_last_edited attribute.
 *
 * @returns {boolean}
 */
export const getResponsiveStatus = (_last_edited) => {
    const lastEdited = isString(_last_edited) ? _last_edited.split('|') : ['off', 'desktop'];
    return !isUndefined(lastEdited[0]) ? 'on' === lastEdited[0] : false;
};

/**
 * Get list of all or selected devices.
 *
 * Default devices are desktop, tablet, and phone. Just in case we want to extend it, we have to
 * edit variable defaultDevices.
 *
 * @since 3.26.7
 *
 * @param {Array | string} ignoredDevices Ignored devices. Can be string or array to pass multiple devices.
 *
 * @returns {Array} Selected devices.
 */
export const getDevicesList = (ignoredDevices = '') => {
    const defaultDevices = [..._devices];

    // Remove specific ignored devices if needed.
    if (!isEmpty(ignoredDevices)) {
        if (isString(ignoredDevices)) {
            ignoredDevices = [ignoredDevices];
        }

        remove(defaultDevices, (device) => includes(ignoredDevices, device));
    }

    return defaultDevices;
};

/**
 * Returns the field responsive name by adding the `_tablet` or `_phone` suffix if it exists.
 *
 * @since 3.26.7
 *
 * @param {string} name   Setting name.
 * @param {string} device Device name.
 *
 * @returns {string} Responsive setting name.
 */
export const getFieldName = (name, device = 'desktop') => {
    // Field name should be string and not empty.
    if (!isString(name) || isEmpty(name)) {
        return name;
    }

    // Ensure device is not empty.
    device = '' === device ? 'desktop' : device;

    // Get device name.
    return 'desktop' !== device ? `${name}_${device}` : name;
};

/**
 * Return last edited field name. It contains the field name with last_edited suffix.
 *
 * @since 4.0
 *
 * @param  {string} name Field name.
 * @returns {string}      Last edited field name.
 */
export const getLastEditedFieldName = (name) => `${name}_last_edited`;

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
export const getFieldNames = (name, needBaseName = true, needLastEdited = true) => {
    const fields = [name, getFieldName(name, 'tablet'), getFieldName(name, 'phone'), getLastEditedFieldName(name)];

    // Remove the base name if needed.
    if (!needBaseName) {
        fields.shift();
    }

    // Remove the last edited name if needed.
    if (!needLastEdited) {
        fields.pop();
    }

    return fields;
};

/**
 * Returns the field original name by removing the `_tablet` or `_phone` suffix if it exists.
 *
 * Only remove desktop/tablet/phone string of the last setting name. Doesn't work for other format.
 *
 * @since 3.26.7
 *
 * @param {string} name Setting name.
 *
 * @returns {string} Base setting name.
 */
export const getFieldBaseName = (name) => {
    // Field name should be string and not empty.
    if (isEmpty(name) || !isString(name)) {
        return name;
    }

    // Ensure namePieces length is enough. If only one, just return current setting name.
    const namePieces = name.split('_');
    if (namePieces.length <= 1) {
        return name;
    }

    const initialPieces = initial(namePieces);
    const lastName = last(namePieces);
    const isSuffixExist = includes(getDevicesList(), lastName);

    // Ensure suffix added previously.
    if (!isSuffixExist) {
        return name;
    }

    // Get device name.
    return join(initialPieces, '_');
};

/**
 * Get previous device value based on responsive mode. It will be useful to compare current device
 * value with the previous one or default one. Mechanism:
 * - Desktop : Default
 * - Tablet  : Desktop -> Default
 * - Phone   : Tablet -> Desktop -> Default.
 *
 * @since 3.23
 *
 * @param  {object} attrs          All module attributes.
 * @param  {string} name           Field option name.
 * @param  {string} desktopDefault Desktop default value.
 *
 * @returns {string} Previous device value.
 */
export const getDefaultValue = (attrs, name, desktopDefault = '') => {
    // Module attributes and field name should not be empty.
    if (isEmpty(attrs) || isEmpty(name) || !isString(name)) {
        return '';
    }

    // Get device name.
    const namePieces = name.split('_');
    const device = includes(getDevicesList(), last(namePieces)) ? last(namePieces) : 'desktop';
    const baseName = 'desktop' !== device ? name.replace(`_${device}`, '') : name;

    // Get desktop default and return it if needed.
    if ('desktop' === device) {
        return desktopDefault;
    }

    // Get tablet default and return it if needed.
    const tabletDefault = getNonEmpty(attrs, baseName, desktopDefault);
    if ('tablet' === device) {
        return tabletDefault;
    }

    // Get phone default and return it if needed.
    const phoneDefault = getNonEmpty(attrs, `${baseName}_tablet`, tabletDefault);
    if ('phone' === device) {
        return phoneDefault;
    }

    return desktopDefault;
};

/**
 * Get previous device value based on responsive mode. Little bit different with getDefaultValue()
 * because this function will return previous attribute exist on attrs list even it's empty string.
 *
 * @since 3.24.1
 *
 * @param  {object} attrs          All module attributes.
 * @param  {string} name           Field option name.
 * @param  {string} desktopDefault Desktop default value.
 *
 * @returns {string} Previous device value.
 */
export const getDefaultDefinedValue = (attrs, name, desktopDefault = '') => {
    // Module attributes and field name should not be empty.
    if (isEmpty(attrs) || isEmpty(name) || !isString(name)) {
        return '';
    }

    // Get device name.
    const namePieces = name.split('_');
    const device = includes(getDevicesList(), last(namePieces)) ? last(namePieces) : 'desktop';
    const baseName = 'desktop' !== device ? name.replace(`_${device}`, '') : name;

    // Get desktop default and return it if needed.
    if ('desktop' === device) {
        return desktopDefault;
    }

    // Get tablet default and return it if needed.
    const tabletDefault = get(attrs, baseName, desktopDefault);
    if ('tablet' === device) {
        return tabletDefault;
    }

    // Get phone default and return it if needed.
    const phoneDefault = get(attrs, `${baseName}_tablet`, tabletDefault);
    if ('phone' === device) {
        return phoneDefault;
    }

    return desktopDefault;
};

/**
 * Get responsive value based on field base name and device.
 *
 * NOTE: Function getValue() is different with getAnyValue(). It will return only current
 *       field value without checking the previous device value.
 *
 * For example: We have Title Text Font Size -> desktop 30px, tablet 20px, phone 10px. When
 *              we fetch the value for phone, it will return pure 10px or default value given
 *              without compare it with tablet or even desktop values.
 *
 * To get tablet or phone value:
 * 1. You can pass only field base name and device name as the 4th argument. The parameters
 *    structure it's made like that to make it similar with other get* method we already have.
 *    For example: getValue(attrs, 'title_text_font_size', '', 'tablet').
 *
 * 2. Or you can pass the actual field name with device. If the field name is already contains
 *    _tablet and _phone, don't pass device parameter because it will be added as suffix.
 *    For example: getValue(attrs, 'title_text_font_size_tablet', '').
 *
 * @since 3.23
 *
 * @param {object}  attrs      All module attributes.
 * @param {string}  name       Field option name.
 * @param {string}  defaultVal Default value.
 * @param {string}  device     Current active device.
 *
 * @returns {string} Current device value.
 */
export const getValue = (attrs, name, defaultVal = '', device = 'desktop') => {
    // Ensure device is not empty.
    device = '' === device ? 'desktop' : device;

    // Module attributes and field name should not be empty.
    if (isEmpty(attrs) || isEmpty(name) || !isString(name)) {
        return defaultVal;
    }

    // Ensure always use device as suffix if device is not desktop/empty.
    if ('desktop' !== device) {
        name = `${getFieldBaseName(name)}_${device}`;
    }

    // Get current value.
    return get(attrs, name, defaultVal);
};

/**
 * Get current active device value from attributes.
 *
 * NOTE: Function getAnyValue() is different with getValue(). It also compare the value with the
 *       previous device value to avoid duplication. Or you can also force to return either
 *       current or previous default value if needed.
 *
 * For example: We have Title Text Font Size -> desktop 30px, tablet 30px, phone 10px. When
 *              we fetch the value for tablet, it will return pure empty as default because
 *              tablet value is equal with desktop value.
 *
 *              We have Title Text Font Size -> desktop 30px, tablet '', phone ''. When
 *              we fetch the value for phone and force it to return any value, it will
 *              return 30px because phone and tablet value is empty and the function will
 *              look up to tablet or even desktop value.
 *
 * To get tablet or phone value:
 * 1. You can pass only field base name and device name as the 5th argument. The parameters
 *    structure it's made like that to make it similar with other get* method we already have.
 *    For example: getAnyValue(attrs, 'title_text_font_size', '', false, 'tablet').
 *
 * 2. Or you can pass the actual field name with device. If the field name is already contains
 *    _tablet and _phone, don't pass device parameter because it will be added as suffix.
 *    For example: getAnyValue( attrs, 'title_text_font_size_tablet', '' ).
 *
 * 3. You can also force to return any value by passing true on the 5th argument. In some cases
 *    we need this to fill missing tablet/phone value with desktop value.
 *
 * @since 3.23
 *
 * @param {object}  attrs          All module attributes.
 * @param {string}  name           Field option name.
 * @param {string}   desktopDefault Desktop default value.
 * @param {boolean} forceReturn    Return current or default value.
 * @param {string}  device         Device name.
 *
 * @returns {string} Current device value.
 */
export const getAnyValue = (attrs, name, desktopDefault = '', forceReturn = false, device = 'desktop') => {
    // Ensure device is not empty.
    device = '' === device ? 'desktop' : device;

    // Module attributes and field name should not be empty.
    if (isEmpty(attrs) || isEmpty(name) || !isString(name)) {
        return '';
    }

    // Ensure always use device as suffix if device is not desktop/empty.
    if ('desktop' !== device) {
        name = `${getFieldBaseName(name)}_${device}`;
    }

    // Get current value.
    const value = get(attrs, name, '');

    // Get previous value to be compared.
    const prevValue = getDefaultValue(attrs, name, desktopDefault);

    // Force to return current or default value if needed.
    if (forceReturn) {
        return isValueAcceptable(value) && '' !== value ? value : prevValue;
    }

    // Ensure current value is different with the previous device or default value.
    if (value === prevValue) {
        return '';
    }

    return value;
};

/**
 * Get current active device value from attributes.
 *
 * NOTE: Function getAnyDefinedValue() is little bit different with getAnyValue(). It has similar
 *       basic function except will return any value exist in attrs even it's empty.
 *
 * @since 3.24.1
 *
 * @param {object}  attrs          All module attributes.
 * @param {string}  name           Field option name.
 * @param {string}  desktopDefault Desktop default value.
 * @param {boolean} forceReturn    Return current or default value.
 * @param {string}  device         Device name.
 *
 * @returns {string} Current device value.
 */
export const getAnyDefinedValue = (attrs, name, desktopDefault = '', forceReturn = false, device = 'desktop') => {
    // Ensure device is not empty.
    device = '' === device ? 'desktop' : device;

    // Module attributes and field name should not be empty.
    if (isEmpty(attrs) || isEmpty(name) || !isString(name)) {
        return '';
    }

    // Ensure always use device as suffix if device is not desktop/empty.
    if ('desktop' !== device) {
        name = `${getFieldBaseName(name)}_${device}`;
    }

    // Get current value.
    const value = get(attrs, name);

    // Return previous value as backup.
    const prevValue = getDefaultDefinedValue(attrs, name, desktopDefault);

    // Force to return current or default value if needed.
    if (forceReturn) {
        return !isUndefined(value) ? value : prevValue;
    }

    // Ensure current value is different with the previous device or default value.
    if (value === prevValue) {
        return '';
    }

    return value;
};

/**
 * Get non empty value.
 *
 * Basically, Lodash get() only return default value if it doesn't exist. However, in some cases
 * we need to return the default value when the current value is empty. This function still return
 * empty value if default value is empty. But at least, it can avoid to return empty value from
 * the original attribute value.
 *
 * @since 3.23
 *
 * @param {object} attrs        Attributes list.
 * @param {string} name         Attribute name.
 * @param {string}  defaultValue Default value to return.
 *
 * @returns {string} Non empty value.
 */
export const getNonEmpty = (attrs, name, defaultValue = '') => {
    const value = get(attrs, name, defaultValue);
    return !isEmpty(value) ? value : defaultValue;
};

/**
 * Returns the previous device name for the given device.
 * The function returns `undefined` for the unknown device names.
 *
 * NOTE: The previous device name for the `Desktop` is empty string.
 *
 * For example: `Phone` -> `Tablet`
 *              `Tablet` -> `Desktop`
 *              `Desktop` -> ``.
 *
 * @since 3.26
 *
 * @param {string} device     - The device name.
 *
 * @returns {string | undefined} - The device name which is previous for the given device.
 */
export const getPreviousDevice = (device) => {
    const normalizedName = lowerCase(device);

    if (!includes(_devices, normalizedName)) {
        return undefined;
    }

    if ('desktop' === normalizedName) {
        return '';
    }

    const index = indexOf(_devices, normalizedName);

    return _devices[index - 1];
};

export default {
    responsiveDevices,
    isResponsiveEnabled,
    isValueAcceptable,
    isOrHasValue,
    hasMobileOptions,
    getResponsiveStatus,
    getDevicesList,
    getFieldName,
    getFieldNames,
    getLastEditedFieldName,
    getFieldBaseName,
    getValue,
    getAnyValue,
    getAnyDefinedValue,
    getDefaultDefinedValue,
    getNonEmpty,
    getDefaultValue,
    getPreviousDevice,
};
