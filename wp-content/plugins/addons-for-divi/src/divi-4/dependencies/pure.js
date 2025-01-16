/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

/* =========================================================================================================== */
/* This module contains only pure utility functions.                                                           */
/* By this any functions that read or update some global state are forbidden.                                  */
/* =========================================================================================================== */

// External dependencies
import isObject from 'lodash/isObject';
import head from 'lodash/head';
import last from 'lodash/last';
import forEach from 'lodash/forEach';
import isArray from 'lodash/isArray';
import isEmpty from 'lodash/isEmpty';
import _toString from 'lodash/toString';
import isNaN from 'lodash/isNaN';
import findIndex from 'lodash/findIndex';

/**
 * Check whether given value can be printed or not (string). Originally a simpler way to check
 * against empty string, but later several checks were added as well to avoid unnecessary repetition.
 *
 * A value considered empty if:
 *  - is an empty string
 *  - is undefined
 *  - is false.
 *
 * @since 4.3
 *
 * @param {*} value
 * @returns {boolean}
 */
export const hasValue = value => '' !== value && undefined !== value && value !== false && ! isNaN(value);

/**
 * Return given value or its default if current value returns false against hasValue()
 * Mainly used to return default if given value is empty string.
 *
 * @since 4.3
 *
 * @param {*} value
 * @param {*} defaultValue Value that will be return if value fails hasValue().
 *
 * @returns {*} Value|default.
 */
export const get = (value, defaultValue) => (hasValue(value) ? value : defaultValue);

/**
 * Test if provided string is a valid JSON.
 *
 * @since 4.3
 *
 * @param {string} string
 * @returns {boolean}
 */
export const isJson = string => {
  try {
    return isObject(JSON.parse(string));
  } catch (e) {
    return false;
  }
};

/**
 * Test if provided string is a valid HTML string.
 *
 * @since 4.3
 *
 * @param {string} html
 * @returns {boolean}
 */
export const isValidHtml = html => {
  const selfClosingTags = [
    'area',
    'base',
    'br',
    'col',
    'embed',
    'hr',
    'img',
    'input',
    'link',
    'menuitem',
    'meta',
    'param',
    'source',
    'track',
    'wbr',
    '!--', // Needed for comment tag
  ].join('|');

  const selfClosingRegex = new RegExp(`<(${selfClosingTags}).*?>`, 'gi');

  // Remove all self closing tags
  const cleanedHtml = html.replace(selfClosingRegex, '');

  // Get remaining opening tags
  const openingTags = cleanedHtml.match(/<[^\/].*?>/g) || [];

  // Get remaining closing tags
  const closingTags = cleanedHtml.match(/<\/.+?>/g) || [];

  return openingTags.length === closingTags.length;
};

/**
 * Check if parameter value equals to `on`.
 *
 * @since 4.3
 *
 * @param {string} value
 * @returns {boolean}
 */
export const isOn = value => 'on' === value;

/**
 * Check if parameter value equals to `off`.
 *
 * @since 4.3
 *
 * @param {string} value
 * @returns {boolean}
 */
export const isOff = value => 'off' === value;

/**
 * Check if parameter value equals to `on` or `off`.
 *
 * @since 4.3
 *
 * @param {string} value
 * @returns {boolean}
 */
export const isOnOff = value => 'on' === value || 'off' === value;

/**
 * Converts the given value to "on/off" notation.
 *
 * @param {boolean} value
 *
 * @returns {string}
 */
export const toOnOff = value => (value ? 'on' : 'off');

/**
 * Check if parameter value equals to `yes`.
 *
 * @since 4.3
 *
 * @param {string} value
 * @returns {boolean}
 */
export const isYes = value => 'yes' === value;

/**
 * Check if parameter value equals to `no`.
 *
 * @since 4.3
 *
 * @param {string} value
 * @returns {boolean}
 */
export const isNo = value => 'no' === value;

/**
 * Check if parameter value equals to `default`.
 *
 * @since 4.3
 *
 * @param {string} value
 * @returns {boolean}
 */
export const isDefault = value => 'default' === value;

/**
 * Check if provided url or path point to a file with specific extension.
 *
 * @since 4.3
 *
 * @param {string} url
 * @param {string} extension
 * @returns {boolean}
 */
export const isFileExtension = (url, extension) => extension === head(last(url.split('.')).split('?'));

/**
 * Generates CSS input placeholders styles for provided selectors.
 *
 * @since 4.3
 *
 * @param {Array} selectors
 * @param {string} declaration
 * @returns {Array}
 */
export const generatePlaceholderCss = (selectors, declaration) => {
  const suffixes = [
    '::-webkit-input-placeholder',
    ':-moz-placeholder',
    '::-moz-placeholder',
    ':-ms-input-placeholder',
  ];

  const processedCSS = [];

  if (! isEmpty(selectors) && isArray(selectors)) {
    forEach(selectors, selector => {
      forEach(suffixes, suffix => {
        processedCSS.push({
          selector: selector + suffix,
          declaration,
        });
      });
    });
  }

  return processedCSS;
};

/**
 * Replace string entities to their character representation.
 *
 * @since 4.3
 *
 * @param {string} content
 * @returns {string}
 */
export const replaceCodeContentEntities = content => {
  content = _toString(content);

  if ('string' === typeof content) {
    content = content.replace(/&#039;/g, '\'');
    content = content.replace(/&#091;/g, '[');
    content = content.replace(/&#093;/g, ']');
    content = content.replace(/&#215;/g, 'x');
  }
  return content;
};

/**
 * Check if the string is a numeric value
 * Numeric values are strings that contain a numeric value or starts with a numeric value.
 *
 * @since 4.3
 *
 * @param {string} value
 * @returns {boolean}
 */
export const hasNumericValue = value => '' !== value && undefined !== value && ! isNaN(parseInt(value));

/**
 * Replace `”`&`″` characters HTML entities that is similar to the actual builder output's counterpart.
 *
 * @since 4.3
 *
 * @param {string} string
 * @returns {string}
 */
export const removeFancyQuotes = string => {
  string = _toString(string);

  if ('string' === typeof string) {
    string = string.replace(/&#8221;/g, '').replace(/&#8243;/g, '');
  }

  return string;
};

/**
 * Returns allowed corners names list.
 *
 * @since 4.3
 *
 * @returns {string[]}
 */
export const getCorners = () => ['top', 'right', 'bottom', 'left'];

/**
 * Return specific corner name by index.
 *
 * @since 4.3
 *
 * @param {number} index
 * @returns {string}
 */
export const getCorner = index => getCorners()[index];

/**
 * Returns spacing value by provided corner.
 *
 * @since 4.3
 *
 * @param {string} spacing
 * @param {string} corner
 * @param {*} defaultValue
 * @returns {string|*}
 */
export const getSpacing = (spacing, corner, defaultValue = '0px') => {
  if (! hasValue(spacing)) {
    return defaultValue;
  }

  const corners      = getCorners();
  const cornerIndex  = findIndex(corners, corner_item => corner_item === corner);
  const spacingArray = _toString(spacing).split('|');

  return hasValue(spacingArray[cornerIndex]) ? spacingArray[cornerIndex] : defaultValue;
};

/**
 * Converts a value to string by checking if the value is a valid value using `hasValue`
 * If value doesn't pass the check, return empty string.
 *
 * @since 4.3
 *
 * @param value
 * @returns {string}
 */
export const toString = value => (hasValue(value) ? _toString(value) : '');

/**
 * Return the object property value, in case the value does not satisfy empty validation,
 * return the defaultValue.
 *
 * @since 4.3
 *
 * @param {*} defaultValue
 * @param {string} prop
 * @param {object} object
 * @returns {*}
 */
export const prop = (defaultValue, prop, object) => (object && get(object[prop], defaultValue)) || defaultValue;

/**
 * Sets object property with provided value.
 *
 * @since 4.3
 *
 * @param {string} prop
 * @param {*} value
 * @param {object} object
 * @returns {object}
 */
export const set = (prop, value, object) => ({ ...(object || {}), [prop]: value });

export function isRealMobileDevice() {
  return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
}

/**
 * Get percentage of given value.
 *
 * @since 4.6.0
 *
 * @param {number} value
 * @param {number|string} percentage
 *
 * @returns {number}
 */
export const getPercentage = (value, percentage) => (value / 100) * parseFloat(percentage);
