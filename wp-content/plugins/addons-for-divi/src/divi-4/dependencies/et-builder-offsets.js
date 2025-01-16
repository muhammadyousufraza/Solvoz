/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

import assignIn from 'lodash/assignIn';

// Internal dependencies.
import Utils from './utils';
import ETBuilderOffsetsConst from './et-builder-offsets-const';


const isBFB = Utils.condition('is_bfb');
const isTB  = Utils.isTB();

const adminBarHeight = Utils.getAdminBarHeight();

const ETBuilderOffsets = assignIn(ETBuilderOffsetsConst, {
  topbar: {
    desktop: adminBarHeight,
    mobile: isTB ? 0 : 46,
  },
  tooltipModal: {
    top: isBFB ? 5 : (isTB ? 44 : adminBarHeight + 30),
    bottom: isBFB ? 117 : 100,
  },
});

export default ETBuilderOffsets;
