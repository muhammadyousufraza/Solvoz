/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/


export default function() {
  //   source   : http://locutus.io/php/sprintf/
  //
  //   example 1: sprintf("%01.2f", 123.1)
  //   returns 1: '123.10'

  const regex  = /%%|%(?:(\d+)\$)?((?:[-+#0 ]|'[\s\S])*)(\d+)?(?:\.(\d*))?([\s\S])/g;
  const args   = arguments;
  let i        = 0;
  const format = args[i++];

  const _pad = function(str, len, chr, leftJustify) {
    if (! chr) {
      chr = ' ';
    }
    const padding = (str.length >= len) ? '' : new Array(1 + len - str.length >>> 0).join(chr);
    return leftJustify ? str + padding : padding + str;
  };

  const justify = function(value, prefix, leftJustify, minWidth, padChar) {
    const diff = minWidth - value.length;
    if (diff > 0) {
      // when padding with zeros
      // on the left side
      // keep sign (+ or -) in front
      if (! leftJustify && '0' === padChar) {
        value = [
          value.slice(0, prefix.length),
          _pad('', diff, '0', true),
          value.slice(prefix.length),
        ].join('');
      } else {
        value = _pad(value, minWidth, padChar, leftJustify);
      }
    }
    return value;
  };

  const _formatBaseX = function(value, base, leftJustify, minWidth, precision, padChar) {
    // Note: casts negative numbers to positive ones
    const number = value >>> 0;
    value = _pad(number.toString(base), precision || 0, '0', false);
    return justify(value, '', leftJustify, minWidth, padChar);
  };

  // _formatString()
  const _formatString = function(value, leftJustify, minWidth, precision, customPadChar) {
    if (precision !== null && precision !== undefined) {
      value = value.slice(0, precision);
    }
    return justify(value, '', leftJustify, minWidth, customPadChar);
  };

  // doFormat()
  const doFormat = function(substring, argIndex, modifiers, minWidth, precision, specifier) {
    let number; let prefix; let method; let textTransform; let
      value;

    if ('%%' === substring) {
      return '%';
    }

    // parse modifiers
    let padChar              = ' '; // pad with spaces by default
    let leftJustify          = false;
    let positiveNumberPrefix = '';
    let j; let
      l;

    for (j = 0, l = modifiers.length; j < l; j++) {
      switch (modifiers.charAt(j)) {
        case ' ':
        case '0':
          padChar = modifiers.charAt(j);
          break;
        case '+':
          positiveNumberPrefix = '+';
          break;
        case '-':
          leftJustify = true;
          break;
        case "'":
          if (j + 1 < l) {
            padChar = modifiers.charAt(j + 1);
            j++;
          }
          break;
      }
    }

    if (! minWidth) {
      minWidth = 0;
    } else {
      minWidth = + minWidth;
    }

    if (! isFinite(minWidth)) {
      throw new Error('Width must be finite');
    }

    if (! precision) {
      precision = ('d' === specifier) ? 0 : 'fFeE'.indexOf(specifier) > - 1 ? 6 : undefined;
    } else {
      precision = + precision;
    }

    if (argIndex && 0 === + argIndex) {
      throw new Error('Argument number must be greater than zero');
    }

    if (argIndex && + argIndex >= args.length) {
      throw new Error('Too few arguments');
    }

    value = argIndex ? args[+ argIndex] : args[i++];

    switch (specifier) {
      case '%':
        return '%';
      case 's':
        return _formatString(`${value}`, leftJustify, minWidth, precision, padChar);
      case 'c':
        return _formatString(String.fromCharCode(+ value), leftJustify, minWidth, precision, padChar);
      case 'b':
        return _formatBaseX(value, 2, leftJustify, minWidth, precision, padChar);
      case 'o':
        return _formatBaseX(value, 8, leftJustify, minWidth, precision, padChar);
      case 'x':
        return _formatBaseX(value, 16, leftJustify, minWidth, precision, padChar);
      case 'X':
        return _formatBaseX(value, 16, leftJustify, minWidth, precision, padChar)
          .toUpperCase();
      case 'u':
        return _formatBaseX(value, 10, leftJustify, minWidth, precision, padChar);
      case 'i':
      case 'd':
        number = + value || 0;

        // Plain Math.round doesn't just truncate
        number = Math.round(number - number % 1);
        prefix = number < 0 ? '-' : positiveNumberPrefix;
        value = prefix + _pad(String(Math.abs(number)), precision, '0', false);

        if (leftJustify && '0' === padChar) {
          // can't right-pad 0s on integers
          padChar = ' ';
        }
        return justify(value, prefix, leftJustify, minWidth, padChar);
      case 'e':
      case 'E':
      case 'f': // @todo: Should handle locales (as per setlocale)
      case 'F':
      case 'g':
      case 'G':
        number = + value;
        prefix = number < 0 ? '-' : positiveNumberPrefix;
        method = ['toExponential', 'toFixed', 'toPrecision']['efg'.indexOf(specifier.toLowerCase())];
        textTransform = ['toString', 'toUpperCase']['eEfFgG'.indexOf(specifier) % 2];
        value = prefix + Math.abs(number)[method](precision);
        return justify(value, prefix, leftJustify, minWidth, padChar)[textTransform]();
      default:
        // unknown specifier, consume that char and return empty
        return '';
    }
  };

  try {
    return format.replace(regex, doFormat);
  } catch (err) {
    return false;
  }
}
