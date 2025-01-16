/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

/**
 * Check whether a value is "on".
 *
 * @since 4.0
 *
 * @param {*} value
 *
 * @returns {boolean}
 */
export const isOn = value => 'on' === value;

/**
 * Check whether a value is "off".
 *
 * @since 4.0
 *
 * @param {*} value
 *
 * @returns {boolean}
 */
export const isOff = value => 'off' === value;

/**
 * Check whether a value is "on" or "off".
 *
 * @since 4.0
 *
 * @param {*} value
 *
 * @returns {boolean}
 */
export const isOnOff = value => 'on' === value || 'off' === value;

/**
 * Check whether a value is "yes".
 *
 * @since 4.0
 *
 * @param {*} value
 *
 * @returns {boolean}
 */
export const isYes = value => 'yes' === value;

/**
 * Check whether a value is "no".
 *
 * @since 4.0
 *
 * @param {*} value
 *
 * @returns {boolean}
 */
export const isNo = value => 'no' === value;

/**
 * Check whether a value is "default".
 *
 * @since 4.0
 *
 * @param {*} value
 *
 * @returns {boolean}
 */
export const isDefault = value => 'default' === value;

/**
 * Get scrollbar width even when there is no scrollbar right now.
 *
 * @since 4.0
 *
 * @returns {integer}
 */
let scrollbarWidthCache = - 1;
export const getScrollbarWidth = () => {
  if (- 1 !== scrollbarWidthCache) {
    return scrollbarWidthCache;
  }

  const outer = document.createElement('div');
  const inner = document.createElement('div');

  outer.style.visibility = 'hidden';
  outer.style.width      = '100px';
  inner.style.width      = '100%';

  // Set explicit height to inner to ensure inner has dimension which later creates scroll on outer;
  // This is specifically needed on Safari
  inner.style.height = '100%';

  outer.appendChild(inner);
  document.body.appendChild(outer);

  const widthWithoutScrollbar = outer.offsetWidth;

  outer.style.overflow = 'scroll';

  const widthWithScrollbar = inner.offsetWidth;

  document.body.removeChild(outer);

  scrollbarWidthCache = widthWithoutScrollbar - widthWithScrollbar;

  return scrollbarWidthCache;
};

/**
 * Get whether the window has a scrollbar visible right now.
 *
 * @param window
 * @since 4.0
 * @returns {boolean}
 */
export const windowHasScrollbar = window => window.document.body.scrollHeight > window.document.body.clientHeight;

/**
 * Semantical previously sanitized acknowledgement.
 *
 * @param {*} value The value being passed-through.
 *
 * @returns {*}
 */
export function sanitizedPreviously(value) {
  return value;
}
