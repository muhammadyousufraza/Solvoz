/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

import isEmpty from 'lodash/isEmpty';
import isString from 'lodash/isString';
import get from 'lodash/get';


const hover   = '__hover';
const enabled = '__hover_enabled';

/**
 * Returns the option suffix used for hover options.
 *
 * @returns {string}
 */
export const hoverSuffix = () => hover;

/**
 * Returns the option enabled suffix used for hover options.
 *
 * @returns {string}
 */
export const enabledSuffix = () => enabled;

/**
 * Gets the base name of the field without the "__hover" or "__hover_enabled" suffix.
 *
 * @param name
 * @returns String.
 */
export const getFieldBaseName = name => (! isEmpty(name) && isString(name) ? name.split(hover).shift() : name);

/**
 * Returns field name suffixed with `__hover`.
 *
 * @param {string} field
 * @returns {string}
 */
export const getHoverField = field => `${getFieldBaseName(field)}${hover}`;

/**
 * Returns field name suffixed with `__hover_enabled`.
 *
 * @param {string} field
 * @returns {string}
 */
export const getHoverEnabledField = field => `${getFieldBaseName(field)}${enabled}`;

/**
 * Tells if the module option has hover options enabled.
 *
 * @param {string} setting
 * @param {object} props
 * @returns {boolean}
 */
export const isEnabled = (setting, props) => 0 === get(props, getHoverEnabledField(setting), '').indexOf('on');

export default {
  isEnabled,
  hoverSuffix,
  enabledSuffix,
  getFieldBaseName,
  getHoverField,
  getHoverEnabledField,
};
