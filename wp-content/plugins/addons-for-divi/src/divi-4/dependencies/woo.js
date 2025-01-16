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
import isEmpty from 'lodash/isEmpty';
import forEach from 'lodash/forEach';
import get from 'lodash/get';
import includes from 'lodash/includes';
import keys from 'lodash/keys';
import join from 'lodash/join';

// Internal Dependencies
import Responsive from './responsive-options';
import {condition} from './utils';

/**
 * Get calculated width based on letter spacing value.
 *
 * WooCommerce's .star-rating uses `em` based width on float layout;
 * any additional width caused by letter-spacing makes the calculation incorrect;
 * thus the `width: calc()` overwrite.
 *
 * @since 3.29
 *
 * @param {string} value
 *
 * @returns {object}
 */
export const getRatingWidthStyle = (value) => ({width: `calc(5.4em + (${value} * 4))`});

/**
 * Get margin properties & values based on current alignment status.
 *
 * Default star alignment is not controlled by standard text align system. It uses float to control
 * how stars symbol will be displayed based on the percentage. It's not possible to convert it to
 * simple text align. We have to use margin left & right to set the alignment.
 *
 * @since 3.29
 *
 * @param {string} align
 * @param {string} mode
 *
 * @returns {object}
 */
export const getRatingAlignmentStyle = (align, mode = 'desktop') => {
    // Bail early if mode is desktop and alignment is left or justify.
    if ('desktop' === mode && includes(['left', 'justify'], align)) {
        return {};
    }

    const marginProperties = {
        center: {
            left: 'auto',
            right: 'auto',
        },
        right: {
            left: 'auto',
            right: '0',
        },
    };

    // By default (left or justify), the margin will be left: inherit and right: auto.
    const marginLeft = get(marginProperties, [align, 'left'], '0');
    const marginRight = get(marginProperties, [align, 'right'], 'auto');

    return {
        'margin-left': `${marginLeft} !important`,
        'margin-right': `${marginRight} !important`,
    };
};

/**
 * Get styles for Woo's .star-rating element.
 *
 * @since 3.29
 *
 * @param {object} attrs
 * @param {string} selector
 *
 * @returns {Array}
 */
export const getStarRatingStyle = (attrs, selector = '%%order_class%% .star-rating') => {
    const additionalCss = [];
    const props = ['rating_letter_spacing', 'rating_text_align'];

    forEach(props, (prop) => {
        const values = Responsive.getPropertyValues(attrs, prop, '', true);
        const processedValues = {};

        forEach(values, (value, device) => {
            if (isEmpty(value)) {
                return;
            }

            switch (prop) {
                case 'rating_letter_spacing':
                    processedValues[device] = getRatingWidthStyle(value);
                    break;
                case 'rating_text_align':
                    processedValues[device] = getRatingAlignmentStyle(value, device);
                    break;
            }
        });

        additionalCss.push(Responsive.generateResponsiveCSS(processedValues, selector));
    });

    return additionalCss;
};

/*
addAppFilter('et.builder.get.woo.default.columns', 'et.builder.get.woo.default.columns', () => {
  const pageLayout = ETBuilderComponentDefinitionStore.getCurrentPage('page_layout');
  return pageLayout && 'et_full_width_page' !== pageLayout ? '3' : '4';
});

addAppFilter('et.builder.get.woo.default.product', 'et.builder.get.woo.default.product', () => {
  const { postType } = ETBuilderComponentDefinitionStore;
  const isLayout     = condition('is_layout_post_type');
  return 'product' === postType || isLayout ? 'current' : 'latest';
});

addAppFilter('et.builder.get.woo.default.tabs', 'et.builder.get.woo.default.tabs', () => {
  const woocommerceTabs = ETBuilderComponentDefinitionStore.getCurrentPage('woocommerceTabs') || {};
  const tabs            = keys(woocommerceTabs);
  return join(tabs, '|');
});
*/
