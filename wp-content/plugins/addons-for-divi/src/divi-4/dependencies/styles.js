// External dependenciess
import forEach from 'lodash/forEach';
import get from 'lodash/get';
import isArray from 'lodash/isArray';
import isEmpty from 'lodash/isEmpty';
import isObject from 'lodash/isObject';
import map from 'lodash/map';
import mapValues from 'lodash/mapValues';

import Utils from './utils';
import Hover from './hover-options';
import Responsive from './responsive-options';

/**
 * Format values by type.
 *
 * @since 4.6.0
 *
 * @param {object | Array | string} values
 * @param {string} type
 */
const formatValues = (values, type) => {
    const formatValue = (value) => {
        let val = '';
        switch (type) {
            case 'range':
                val = Utils.processRangeValue(value);
                break;
            case 'margin':
            case 'padding':
                if (value) {
                    value = value.split('|');
                    val =
                        (value[0] ? value[0] : 0) +
                        ' ' +
                        (value[1] ? value[1] : 0) +
                        ' ' +
                        (value[2] ? value[2] : 0) +
                        ' ' +
                        (value[3] ? value[3] : 0);
                }
                break;
            default:
                val = value;
                break;
        }

        return val;
    };

    if (isObject(values)) {
        return mapValues(values, formatValue);
    }
    if (isArray(values)) {
        return map(values, formatValue);
    }
    return formatValue(values);
};

/**
 * Generate responsive + sticky state styles
 * Use the `Responsive.generateResponsiveCSS`
 * with addition to generating sticky state styles if module enable it.
 *
 * @since 4.6.0
 * @param moduleArgs
 * @param {object} {moduleArgs}
 */
export const generateStyles = (moduleArgs) => {
    const defaultArgs = {
        address: '',
        attrs: {},
        name: '',
        defaultValue: '',
        type: '',
        forceReturn: false,
        selector: '%%order_class%%',
        cssProperty: '',
        important: false,
        hover: true,
        sticky: true,
        responsive: true,
        isStickyModule: null,
        stickyPseudoSelectorLocation: 'order_class',
    };

    const args = {
        ...defaultArgs,
        ...moduleArgs,
    };

    const {
        address,
        attrs,
        name,
        defaultValue,
        type,
        forceReturn,
        selector,
        cssProperty,
        important,
        hover,
        sticky,
        responsive,
        isStickyModule,
        stickyPseudoSelectorLocation,
    } = args;

    let cssDeclarations = [];
    let additionalCSS = important ? ' !important' : '';

    // Common styles
    if (responsive) {
        // Need to close the additionalCSS with the semicolon to prevent responsive css generation from generating invalid css
        // when the cssProperty is an array
        additionalCSS = '' === additionalCSS ? additionalCSS : `${additionalCSS};`;
        const reponsiveValues = formatValues(
            Responsive.getPropertyValues(attrs, name, defaultValue, hover, forceReturn),
            type
        );
        const reponsiveCss = Responsive.generateResponsiveCSS(reponsiveValues, selector, cssProperty, additionalCSS);
        cssDeclarations = isEmpty(reponsiveCss) ? cssDeclarations : reponsiveCss;
    } else {
        let cssValue = formatValues(get(attrs, name, defaultValue), type);
        if (hover) {
            const hoverValue = Hover.getHoverOrNormalOnHover(name, attrs);
            cssValue = Utils.hasValue(hoverValue) ? formatValues(hoverValue, type) : formatValues(defaultValue, type);
        }

        if (Utils.hasValue(cssValue)) {
            let declaration = '';

            // Allow to use multiple properties in array for the same value.
            if (isArray(cssProperty)) {
                forEach(cssProperty, (cssProp) => (declaration += `${cssProp}: ${cssValue}${additionalCSS}; `));
            } else {
                declaration = `${cssProperty}: ${cssValue}${additionalCSS};`;
            }

            cssDeclarations.push({
                selector,
                declaration: declaration.trim(),
                device: 'desktop',
            });
        }
    }

    return cssDeclarations;
};

export default {
    generateStyles,
};
