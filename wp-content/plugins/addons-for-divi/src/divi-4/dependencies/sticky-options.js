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
import filter from 'lodash/filter';
import forEach from 'lodash/forEach';
import get from 'lodash/get';
import includes from 'lodash/includes';
import initial from 'lodash/initial';
import isArray from 'lodash/isArray';
import isEmpty from 'lodash/isEmpty';
import isObject from 'lodash/isObject';
import isString from 'lodash/isString';
import isUndefined from 'lodash/isUndefined';
import map from 'lodash/map';
import startsWith from 'lodash/startsWith';
import times from 'lodash/times';
import trim from 'lodash/trim';

// Internal dependencies
import {hasValue} from '@frontend-builder/utils/utils';
import {isParentOf} from '@frontend-builder/utils/module';
import {getCheckedPropertyValue} from './responsive-options';
import StickyPure from './sticky-options-pure';
import * as moduleUtils from './module';
import ETBuilderStore from '../stores/et-builder-store';
import {createMemoize} from './memoize';
import Utils from './utils';

// Memoize some methods for faster execution.
const {memoized: getEnabledStickyPositionAddressMemoized, clear: clearEnabledStickyPositionAddressMemoized} =
    createMemoize((address) => {
        let enabledAddress = false;
        let props = ETBuilderStore.getComponentAtAddress(address);

        const maxIteration = 1000;
        let i = 0;
        while (true) {
            // force breaking to prevent infinite loop
            if (i > maxIteration) {
                break;
            }
            i++;

            const attrs = get(props, 'attrs', {});
            const parentAddress = get(props, 'parent_address', '');

            // Can't use isStickyModule() because it'll cause infinite loop. Check for sticky_position
            // attribute instead.
            if (hasStickyPositionAttrs(attrs)) {
                enabledAddress = get(props, 'address', '');
            }

            if (!Utils.hasValue(parentAddress) || Utils.hasValue(enabledAddress)) {
                break;
            }

            // update props with props from parent address
            props = ETBuilderStore.getComponentAtAddress(parentAddress);
        }

        return enabledAddress;
    });

/**
 * Returns the option suffix used for sticky options.
 *
 * @since 4.6.0
 *
 * @returns {string}
 */
export const {stickySuffix} = StickyPure;

/**
 * Returns the option enabled suffix used for sticky options.
 *
 * @since 4.6.0
 *
 * @returns {string}
 */
export const {enabledSuffix} = StickyPure;

/**
 * Tells if the field has sticky field defined in the field registration.
 *
 * @since 4.6.0
 *
 * @param {object} props
 * @returns {boolean}
 */
export const {doesSupport} = StickyPure;

export const getActiveModuleStickyPositionAddress = () => {
    const activeModule = ETBuilderStore.getActiveModule();
    if (isEmpty(activeModule)) {
        return false;
    }

    const activeModuleAddress = get(activeModule, 'props.address', '');
    const activeModuleStickyAddress = getEnabledStickyPositionAddress(activeModuleAddress);
    return activeModuleStickyAddress;
};

/**
 * Get address of a module that enabled sticky position
 * This will loop through parent component to see if the parent has enabled sticky position.
 *
 * @since 4.6.0
 *
 * @param {string} address
 *
 * @returns {boolean}
 */
export const getEnabledStickyPositionAddress = getEnabledStickyPositionAddressMemoized;

/**
 * Clear getEnabledStickyPositionAddress caches.
 */
export const clearEnabledStickyPositionAddress = clearEnabledStickyPositionAddressMemoized;

/**
 * Tells if the module has to show sticky options
 * If the module is inside of a module that has a sticky position enabled,
 * it should display the sticky styles option.
 *
 * @since 4.6.0
 *
 * @param {object} props
 * @returns {boolean}
 */
export const hasStickyOptions = (props) => {
    const address = get(props, 'address', '');

    // Custom default mode should always display sticky options
    if (ETBuilderStore.isGlobalPresetsMode()) {
        return true;
    }
    return false !== getEnabledStickyPositionAddress(address);
};

/**
 * Check if the module can have sticky styles by checking if it a sticky module or inside a sticky module.
 * Note: this function did not check sticky enabled in the field level.
 *
 * @since 4.6.0
 *
 * @param {string} moduleAddress
 * @param {object} allValues
 *
 * @returns {boolean}
 */
export const canHaveStickyStyle = (moduleAddress, allValues) =>
    isStickyModule(moduleAddress, allValues) || isInsideStickyModule(moduleAddress);

/**
 * Check if the module should apply sticky styles in sticky mode.
 *
 * @since 4.6.0
 *
 * @param {string} moduleAddress
 * @param {object} allValues
 *
 * @returns {boolean}
 */
export const shouldUseStickyStyle = (moduleAddress, allValues) => {
    if (!isStickyMode()) {
        return false;
    }

    if (!canHaveStickyStyle(moduleAddress, allValues)) {
        return false;
    }

    const moduleStickyAddress = getEnabledStickyPositionAddress(moduleAddress);
    return isActive(moduleStickyAddress);
};

/**
 * Check if the sticky mode is currently active in the module
 * by checking it with sticky activation address from the currently active module.
 *
 * @since 4.6.0
 *
 * @param {string} moduleAddress
 *
 * @returns {boolean}
 */
export const isActive = (moduleAddress) => {
    if (!isStickyMode()) {
        return false;
    }

    const activeModuleStickyAddress = getActiveModuleStickyPositionAddress();
    return moduleAddress === activeModuleStickyAddress;
};

/**
 * Tells if the module option has sticky options enabled.
 *
 * @since 4.6.0
 *
 * @param {string} setting
 * @param {object} props
 * @returns {boolean}
 */
export const {isEnabled} = StickyPure;

/**
 * Check if module has valid sticky_position value which makes it a sticky module.
 *
 * @since 4.6.0
 *
 * @param {object} moduleAttrs
 *
 * @returns {bool}
 */
export const hasStickyPositionAttrs = (moduleAttrs) => {
    // Bail if there is fields which its selected value are incompatible to sticky mechanism
    if (hasIncompatibleAttrs(moduleAttrs)) {
        return false;
    }

    // Get sticky position value;
    const position = getCheckedPropertyValue(moduleAttrs, 'sticky_position', '', true);

    // Skip if no sticky position value found
    if (!hasValue(position)) {
        return false;
    }

    // Evaluate sticky status; consider responsive format
    let isSticky = false;

    if (isObject(position)) {
        // Responsive enabled. If one of any device uses valid sticky position, consider it as true
        forEach(position, (devicePosition) => {
            if (includes(getValidStickyPositions(), devicePosition)) {
                isSticky = true;

                // equal to break;
                return false;
            }
        });
    } else {
        // Responsive disabled
        isSticky = includes(getValidStickyPositions(), position);
    }

    return isSticky;
};

/**
 * Check if module with given module attributes is sticky module (module which has valid
 * sticky_position* attribute for sticky element mechanism).
 *
 * @since 4.6.2
 *
 * @param {string} moduleAddress
 * @param {object} moduleAttrs
 *
 * @returns {bool}
 */
export const isStickyModule = (moduleAddress, moduleAttrs) => {
    // No nested sticky element.
    if (isInsideStickyModule(moduleAddress)) {
        return false;
    }

    return hasStickyPositionAttrs(moduleAttrs);
};

/**
 * Check if a module is inside a sticky module.
 *
 * @since 4.6.0
 *
 * @param {string} moduleAddress
 *
 * @returns {bool}
 */
export const isInsideStickyModule = (moduleAddress) => {
    // Prevent unnecessary error
    if (!isString(moduleAddress)) {
        return false;
    }

    // `getEnabledStickyPositionAddress()` checks from bottom to top address (eg. 0.0.0 first, then
    // upward to 0.0, vice versa) which could lead to incorrect parentModuleAddress if current module
    // has sticky position attribute while its parent also has sticky position attribute. Thus, begin
    // check for enabled sticky position address from current module address' parent.
    const parentModuleAddress = initial(moduleAddress.split('.')).join('.');
    const moduleStickyAddress = getEnabledStickyPositionAddress(parentModuleAddress);
    if (false === moduleStickyAddress) {
        return false;
    }

    return moduleUtils.isChildOf(moduleAddress, moduleStickyAddress);
};

/**
 * Check if current module contains sticky module that is currently in sticky state.
 *
 * @param {string} moduleAddress
 *
 * @returns {bool}
 */
export const hasCurrentlyStickyModule = (moduleAddress) => {
    const stickyModules = get(Utils.appWindow(), 'ET_FE.stores.sticky.modules', {});

    // No sticky module on current layout, exit early
    if (isEmpty(stickyModules)) {
        return false;
    }

    // Filter list of sticky modules into list of child module that is sticky + in sticky state
    const stickyChild = filter(stickyModules, (stickyModule, id) => {
        const stickyModuleAddress = get(stickyModule, 'address');

        if (stickyModuleAddress === moduleAddress || !isCurrentlySticky(id)) {
            return false;
        }

        return startsWith(stickyModuleAddress, moduleAddress);
    });

    return !isEmpty(stickyChild);
};

/**
 * Check if module with given id is on sticky state. Alias of FE's exposed method
 * In VB, module id is derived from `props._key`.
 *
 * @since 4.6.0
 *
 * @param {string} id
 *
 * @returns {bool}
 */
export const isCurrentlySticky = (id) => Utils.appWindow().ET_FE.stores.sticky.isSticky(id);

/**
 * Tells if the sticky tabs are in sticky state.
 *
 * @since 4.6.0
 *
 * @returns {boolean}
 */
export const isStickyMode = () => !!ETBuilderStore.getStickyMode();

/**
 * Returns the field sticky value.
 *
 * @since 4.6.0
 *
 * @param {string} field
 * @param {object} props
 * @param defaultValue
 * @returns {*}
 */
export const getValue = (field, props, defaultValue) => {
    const fieldName = getStickyField(field);
    return isEnabled(field, props) ? get(props, fieldName, defaultValue) : defaultValue;
};

/**
 * Same as getValue, but for values that needs to be split like margin, padding.
 * The methods takes care that if n-th split value is missing from sticky value, it is inherited
 * from normal value.
 *
 * !!! Note: This method is useful only when you need the sticky value to inherit from normal.
 *           It should not be used on saving sticky value, as it will add redundancy.
 *
 * @since 4.6.0
 *
 * @param {string} setting
 * @param {object} props
 * @param {string} sep
 * @returns {*}
 */
export const getSplitValue = (setting, props, sep = '|') => {
    if (!isEnabled(setting, props)) {
        return;
    }

    const value = String(get(props, setting, '')).split(sep);
    const sticky = String(getValue(setting, props, '')).split(sep);

    // Get the longest length
    const len = Math.max(value.length, sticky.length);

    // Fill the sticky value empty values with default value
    const returnValue = times(len, (i) => (!isEmpty(sticky[i]) ? sticky[i] : value[i])).join(sep);

    return returnValue;
};

/**
 * Return the sticky value of composite option.
 *
 * @param {string} field Field name.
 * @param {string} option Composite option name.
 * @param {object} props
 * @returns {*}
 */
export const getCompositeValue = (field, option, props) =>
    isEnabled(option, props) ? get(props, getStickyField(field), get(props, field)) : undefined;

/**
 * Returns field name suffixed with `__sticky`.
 *
 * @since 4.6.0
 *
 * @param {string} field
 * @returns {string}
 */
export const {getStickyField} = StickyPure;

/**
 * Returns field name suffixed with `__sticky_enabled`.
 *
 * @since 4.6.0
 *
 * @param {string} field
 * @returns {string}
 */
export const {getStickyEnabledField} = StickyPure;

/**
 * Gets the base name of the field without the "__sticky" or "__sticky_enabled" suffix.
 *
 * @since 4.6.0
 *
 * @returns String.
 */
export const {getFieldBaseName} = StickyPure;

/**
 * Get valid sticky_position which implies module is sticky element.
 *
 * @since 4.6.0
 *
 * @returns {Array}
 */
export const getValidStickyPositions = () => get(ETBuilderBackend, 'stickyElements.validStickyPositions', {});

/**
 * @param field
 * @param option
 * @param props
 * @since 4.6.0
 * @returns String.
 */
export const getCompositeFieldOnSticky = (field, option, props) =>
    isStickyMode() && isEnabled(option, props) ? getStickyField(field) : getFieldBaseName(field);

/**
 * Adds sticky state selector prefix before given selectors.
 *
 * @since 4.6.0
 *
 * @param {string | Array} selector
 * @param {boolean}      isSticky
 * @param {boolean}      returnString
 */
export const addStickyToSelectors = (selector, isSticky = true, returnString = true) => {
    // Check value before proceeding to avoid broken component
    if (isUndefined(selector)) {
        return selector;
    }

    const addStickySelector = (selector) =>
        map(selector.split(','), (sel) => {
            const trimSelector = trim(sel);
            if (isSticky) {
                return `.${StickyPure.stickySelectorClass}${trimSelector}`;
            }
            return `.${StickyPure.stickySelectorClass} ${trimSelector}`;
        });

    const stickySelectors = isArray(selector) ? map(selector, addStickySelector) : addStickySelector(selector);
    return returnString ? stickySelectors.join(', ') : stickySelectors;
};

/**
 * Add sticky state selector prefix to the order class.
 *
 * @since 4.6.0
 *
 * @param {string | Array} selector
 * @param {boolean}      isSticky
 * @param {boolean}      returnString
 */
export const addStickyToOrderClass = (selector, isSticky = true, returnString = true) => {
    // Check value before proceeding to avoid broken component
    if (isUndefined(selector)) {
        return selector;
    }

    const addStickySelector = (selector) =>
        map(selector.split(','), (sel) => {
            const trimSelector = trim(sel);
            if (isSticky) {
                return trimSelector.replace(/(%%order_class%%)/i, `.${StickyPure.stickySelectorClass}$1`);
            }
            return trimSelector.replace(/(%%order_class%%)/i, `.${StickyPure.stickySelectorClass} $1`);
        });

    const stickySelectors = isArray(selector) ? map(selector, addStickySelector) : addStickySelector(selector);
    return returnString ? stickySelectors.join(', ') : stickySelectors;
};

/**
 * Check if given attrs has incompatible attribute value which makes sticky mechanism can't
 * be used on current module.
 *
 * @since 4.6.0
 *
 * @param {object} attrs
 *
 * @returns {bool}
 */
export const hasIncompatibleAttrs = (attrs) => {
    let incompatible = false;

    forEach(getIncompatibleFields(), (options, name) => {
        // Get attribute value of current incompatible field from attributes
        const attr = get(attrs, name, false);

        // If the value exist on current incompatible field's options, stop loop and return true
        if (includes(options, attr)) {
            incompatible = true;

            // Break
            return false;
        }
    });

    return incompatible;
};

/**
 * List of fields and its value which prevent sticky mechanism to work due to how it behaves.
 *
 * @since 4.6.0
 *
 * @returns {Array}
 */
export const getIncompatibleFields = () => get(ETBuilderBackend, 'stickyElements.incompatibleFields', {});

/**
 * Generate sticky fields based on current source fields.
 *
 * @since 4.6.0
 *
 * @param {object} fields Source fields object.
 *
 * @returns {object} Generated sticky fields.
 */
export const getStickyFieldsDefinition = (fields) => {
    // Ensure fields exist.
    if (isEmpty(fields)) {
        return {};
    }

    const stickyFields = {};

    forEach(fields, (field) => {
        // Create sticky and sticky enabled field if current field support Sticky.
        if (doesSupport(field)) {
            const fieldName = get(field, 'name', '');
            const stickyField = getStickyField(fieldName);
            const stickyEnabledField = getStickyEnabledField(fieldName);
            const defaultStickyField = {
                tab_slug: get(field, 'tab_slug', ''),
                toggle_slug: get(field, 'toggle_slug', ''),
                type: 'skip',
            };

            stickyFields[stickyField] = {...defaultStickyField, ...{name: stickyField}};
            stickyFields[stickyEnabledField] = {...defaultStickyField, ...{name: stickyEnabledField}};
        }
    });

    return stickyFields;
};

/**
 * Get sticky element object that exist inside given address.
 *
 * @since 4.6.0
 *
 * @param {object} stickyModules
 * @param {string} address
 *
 * @returns {object}
 */
export const getStickyModuleInsideAddress = (stickyModules, address) =>
    filter(stickyModules, (stickyModule) => isParentOf(address, stickyModule.address));

export default {
    stickySuffix,
    enabledSuffix,
    doesSupport,
    getActiveModuleStickyPositionAddress,
    getEnabledStickyPositionAddress,
    clearEnabledStickyPositionAddress,
    hasStickyOptions,
    canHaveStickyStyle,
    shouldUseStickyStyle,
    isActive,
    isEnabled,
    isStickyModule,
    isInsideStickyModule,
    hasCurrentlyStickyModule,
    isCurrentlySticky,
    isStickyMode,
    getStickyField,
    getValue,
    getSplitValue,
    getCompositeValue,
    getStickyEnabledField,
    getFieldBaseName,
    getValidStickyPositions,
    getCompositeFieldOnSticky,
    addStickyToSelectors,
    addStickyToOrderClass,
    hasStickyPositionAttrs,
    hasIncompatibleAttrs,
    getIncompatibleFields,
    getStickyFieldsDefinition,
    getStickyModuleInsideAddress,
};
