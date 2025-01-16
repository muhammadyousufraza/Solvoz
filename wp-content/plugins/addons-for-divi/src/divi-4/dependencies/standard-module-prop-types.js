/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

import PropTypes from 'prop-types';
import React from 'react';


const ReactPropTypes          = PropTypes;
const standardModulePropTypes = {
  _i: ReactPropTypes.number,
  _order: ReactPropTypes.number,
  _v: ReactPropTypes.number,
  active: ReactPropTypes.bool,
  hovered: ReactPropTypes.bool,
  address: ReactPropTypes.string,
  attrs: ReactPropTypes.object,
  child_slug: ReactPropTypes.string,
  component_path: ReactPropTypes.string,
  defaults: ReactPropTypes.oneOfType([
    ReactPropTypes.string,
    ReactPropTypes.object,
  ]),
  edited: ReactPropTypes.bool,
  vb_support: ReactPropTypes.string,
  focused: ReactPropTypes.bool,
  lockedParent: ReactPropTypes.bool,
  parent_address: ReactPropTypes.string,
  shortcode_index: ReactPropTypes.number,
  type: ReactPropTypes.string,
  previewWidth: ReactPropTypes.number,
  previewMode: ReactPropTypes.string,
  currentRowStructure: ReactPropTypes.string,
  currentSubject: ReactPropTypes.string,
  onChildMouseOut: ReactPropTypes.func,
  isFirstChild: ReactPropTypes.bool,
  isLastChild: ReactPropTypes.bool,
  unsyncedGlobalSettings: ReactPropTypes.oneOfType([
    ReactPropTypes.string,
    ReactPropTypes.array,
  ]),
  main_css_element: ReactPropTypes.string,
  is_specialty_placeholder: ReactPropTypes.bool,
};

export default standardModulePropTypes;
