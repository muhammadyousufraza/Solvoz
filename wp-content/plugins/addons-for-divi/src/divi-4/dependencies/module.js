/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

// External dependencies.
import startsWith from 'lodash/startsWith';
import flip from 'lodash/flip';
import flatten from 'lodash/flatten';
import isArray from 'lodash/isArray';
import isEmpty from 'lodash/isEmpty';
import compact from 'lodash/compact';
import map from 'lodash/map';
import get from 'lodash/get';

// Internal dependencies.
//import ETBuilderStore from '../stores/et-builder-store';
import Utils from './utils';
import * as moduleLib from './module-utils';

/**
 * Returns module type.
 *
 * @param {object} module
 * @returns {string}
 */
export const getType = module => getProps(module).type || '';

/**
 * Returns module unique id.
 *
 * @param {object} module
 * @returns {string}
 */
export const getId = module => getProps(module)._key || '';

/**
 * Returns module unique id.
 *
 * @param {object} module
 * @returns {number}
 */
export const getVersion = module => getProps(module)._v || 0;

/**
 * Returns module address.
 *
 * @param {object} module
 * @returns {string}
 */
export const getAddress = module => getProps(module).address || '';

/**
 * Returns module props.
 *
 * @param {object} module
 * @returns {object}
 */
export const getProps = module => module && module.props && module.props || {};

/**
 * Returns module attributes.
 *
 * @param {object} module
 * @returns {object}
 */
export const getAttrs = module => getProps(module).attrs || {};

/**
 * Returns module order class.
 *
 * @param {object} module
 * @returns {string}
 */
export const getOrderClass = module => {
  const props = getProps(module);
  return moduleLib.getModuleOrderClass(props.type, props.shortcode_index, props.theme_builder_suffix);
};

/**
 * Returns module HTML Node.
 *
 * @param {object} module
 * @returns {HTMLElement|undefined}
 */
export const getNode = module => {
  const moduleObject = module || {};
  switch (getType(moduleObject)) {
    case 'et_pb_section':
      return moduleObject._section;
    case 'et_pb_row':
    case 'et_pb_row_inner':
      return moduleObject._row;
    case 'et_pb_column':
    case 'et_pb_column_inner':
      return moduleObject._column;
    default:
      const { refs } = moduleObject;
      return refs.moduleWrapper || refs.module;
  }
};

/**
 * Compares 2 modules if are the same by comparing the addresses
 * Returns false if the addresses are invalid.
 *
 * @param {object} module1
 * @param {object} module2
 * @returns {boolean}
 */
export const isModule = (module1, module2) => getId(module1) === getId(module2);

/**
 * Checks if the module is under edit operation.
 *
 * @param module
 * @returns {boolean}
 */
export const isEdited = module => !! (getProps(module).edited || false);

/**
 * Check if the first provided address is the parent of the second provided address.
 *
 * @param {string} parentAddress
 * @param {string} childAddress
 * @returns {boolean}
 */
export const isParentOf = (parentAddress, childAddress) => {
  const parentSize = (parentAddress || '').length;
  const childSize  = (childAddress || '').length;

  return !! (parentSize && childSize && (parentSize < childSize) && startsWith(childAddress, parentAddress));
};

/**
 * Check if the first provided address is the child of the second provided address.
 *
 * This function is just a flip of the `isParentOf` function.
 *
 * @param {string} parentAddress
 * @param {string} parentAddress
 * @returns {boolean}
 */
export const isChildOf = flip(isParentOf);

/**
 * Check is the module can be considered hovered.
 *
 * @param {string} address
 * @returns {boolean}
 */
 /*
export const isHovered = address => {
  const module        = ETBuilderStore.getHoveredModule();
  const moduleAddress = getAddress(module);
  const hovered       = address === moduleAddress;
  const childHovered  = ! hovered && isParentOf(address, moduleAddress);
  const childEdited   = isEdited(module);

  // The module is considered hovered if it's container is hovered or child is hovered
  return (hovered || childHovered) && ! childEdited

    // The module should not be treat as hovered during drag edit
    && ! ETBuilderStore.isDoingDragEdit()

    // If a setting modal is open module hover should be ignored
    && ! ETBuilderStore.isSettingsModalOpen()

    // Module hover is ignored in wireframe mode
    && 'wireframe' !== ETBuilderStore.getPreviewMode();
};
*/
export const getHeight = module => (module || {}).moduleHeight || 0;

/**
 * Check if current hovered module is child of provided module address.
 *
 * @param {string} address
 * @returns {boolean}
 */
/*
export const isChildHovered = address => {
  const moduleAddress = getAddress(ETBuilderStore.getHoveredModule());

  return isParentOf(address, moduleAddress) && isHovered(moduleAddress);
};
*/

/**
 * Tells if module has any children.
 *
 * @param module
 * @returns {boolean}
 */
export const hasChildren = module => {
  const modules = map(getProps(module).children, 'content');

  return ! isEmpty(compact(flatten(modules)));
};

/**
 * Check if module is locked.
 *
 * @param module
 * @returns Boolean.
 */
export const isLocked = module => moduleLib.isLocked(Utils.isOn(getAttrs(module).locked), !! getProps(module).lockedParent);

/**
 * Check if module parent is locked.
 *
 * @param module
 * @returns {boolean}
 */
export const isLockedParent = module => true === getProps(module).lockedParent;

/**
 * Check if module is a global module.
 *
 * @param module
 * @returns {boolean}
 */
export const isGlobal = module => Utils.hasValue(getAttrs(module).global_module);

/**
 * Check if module is a global module.
 *
 * @param module
 * @returns {number|undefined}
 */
export const getGlobalId = module => getAttrs(module).global_module;

/**
 * Check if any module parents are a global module.
 *
 * @param module
 * @returns {boolean}
 */
export const isGlobalParent = module => Utils.hasValue(getProps(module).globalParent);

/**
 * Check if module is row.
 *
 * @param module
 * @returns {boolean}
 */
export const isRow = module => 'et_pb_row' === getType(module);

/**
 * Check if module is inner row.
 *
 * @param module
 * @returns {boolean}
 */
export const isInnerRow = module => 'et_pb_row_inner' === getType(module);

/**
 * Check if module is column.
 *
 * @param module
 * @returns {boolean}
 */
export const isColumn = module => 'et_pb_column' === getType(module);

/**
 * Check if module is inner column.
 *
 * @param module
 * @returns {boolean}
 */
export const isInnerColumn = module => 'et_pb_column_inner' === getType(module);

/**
 * Check if module is specialty column.
 *
 * @param module
 *
 * @returns {boolean}
 */
export const isSpecialtyColumn = module => {
  const props = getProps(module);
  const attrs = getAttrs(module);

  return ! isInnerColumn(module) && ('' !== get(attrs, 'specialty_columns', '') || '' !== get(props, 'specialty_layout', ''));
};

/**
 * Check if module type is removed.
 *
 * @param {object} module
 * @returns {boolean}
 */
export const isRemoved = module => 'et-fb-removed-component' === getProps(module).component_path;

/**
 * Check if module is editable.
 *
 * @param module
 * @returns {boolean}
 */
/*
export const isEditable = module => {
  const locked       = isLocked(module);
  const lockedParent = isLockedParent(module);
  const globalId     = (getGlobalId(module) || '').toString();
  const globalParent = isGlobalParent(module);
  const type         = getType(module);

  return moduleLib.isEditable(locked, lockedParent, globalId, globalParent, type);
};
*/

/**
 * Check if module contains at least one of the specified modules down its hierarchy.
 *
 * @param {object} content
 * @param {string[]} modules
 * @returns {boolean}
 */
export const containsModules = (content, modules) => {
  if (! isArray(content)) {
    return false;
  }

  const queue = [...content];

  while (queue.length > 0) {
    const module = queue.shift();

    if (modules.indexOf(module.type) !== - 1) {
      return true;
    }

    if (isArray(module.content)) {
      queue.push(...module.content);
    }
  }

  return false;
};
