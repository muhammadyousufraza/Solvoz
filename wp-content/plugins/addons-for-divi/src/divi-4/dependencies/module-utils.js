/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

//import ETBuilderStore from '../stores/et-builder-store';
import isUndefined from 'lodash/isUndefined';

/**
 * Get whether a module type is a post content module type.
 *
 * @since 4.0
 *
 * @param {string} moduleType
 *
 * @returns {boolean}
 */
export function isPostContentModule(moduleType) {
  return window.ETBuilderBackend.themeBuilder.postContentModules.indexOf(moduleType) !== - 1;
}

/**
 * Check if a module is locked.
 *
 * @param {boolean} locked
 * @param {boolean} lockedParent
 *
 * @returns {boolean}
 */
export const isLocked = (locked, lockedParent) => !! (locked || lockedParent);

/**
 * Check if a module is editable.
 *
 * @param {boolean} locked
 * @param {boolean} lockedParent
 * @param {string} global
 * @param {boolean} globalParent
 * @param {string} moduleType
 *
 * @returns {boolean}
 */
 /*
export const isEditable = (locked, lockedParent, global, globalParent, moduleType) => {
  const isNotGlobal                  = ! global;
  const GlobalDescendantsAreEditable = ETBuilderStore.isAllowedAction('edit_global_library');
  let canEditModuleType              = true;

  if (! isUndefined(moduleType)) {
    canEditModuleType = ETBuilderStore.isAllowedAction(moduleType);
  }

  canEditModuleType = canEditModuleType && ETBuilderStore.isAllowedAction('edit_module');

  return canEditModuleType && isInteractable(locked, lockedParent, globalParent) && (isNotGlobal || GlobalDescendantsAreEditable);
};
*/

/**
 * Check if a module is copyable.
 *
 * @since 4.0
 *
 * @param {string} moduleType
 *
 * @returns {boolean}
 */
export function isCopyable(moduleType) {
  return ! isPostContentModule(moduleType);
}

/**
 * Check if a module is clonable.
 *
 * @since 4.0
 *
 * @param {string} moduleType
 *
 * @returns {boolean}
 */
export function isClonable(moduleType) {
  return ! isPostContentModule(moduleType);
}

/**
 * Check if a module is savable.
 *
 * @since 4.0
 *
 * @param {string} moduleType
 *
 * @returns {boolean}
 */
export function isSavable(moduleType) {
  return ! isPostContentModule(moduleType);
}

/**
 * Check if a module is split testable.
 *
 * @since 4.0
 *
 * @param {string} moduleType
 *
 * @returns {boolean}
 */
export function isSplitTestable(moduleType) {
  return ! isPostContentModule(moduleType);
}

/**
 * Check if a module is interactable.
 * An interactable module is a module that can be moved, for example.
 *
 * @param {boolean} locked
 * @param {boolean} lockedParent
 * @param {boolean} globalParent
 *
 * @returns {boolean}
 */
/*
export const isInteractable = (locked, lockedParent, globalParent) => {
  const isNotGlobalDescendant        = ! globalParent;
  const GlobalDescendantsAreEditable = ETBuilderStore.isAllowedAction('edit_global_library');

  return ! isLocked(locked, lockedParent) && (isNotGlobalDescendant || GlobalDescendantsAreEditable);
};
*/

/**
 * Check if module can add siblings.
 * Useful when checking if a module should show an ADD button after itself.
 *
 * @param {boolean} lockedParent
 * @param {boolean} globalParent
 * @param moduleType
 * @returns {boolean}
 */
/*
export const canAddSiblings = (lockedParent, globalParent, moduleType) => {
  const isNotLockedDescendant        = ! lockedParent;
  const isNotGlobalDescendant        = ! globalParent;
  const GlobalDescendantsAreEditable = ETBuilderStore.isAllowedAction('edit_global_library');
  const isOnlyLibraryItem            = ETBuilderStore.isEditingLibraryItem(moduleType);

  return isNotLockedDescendant && (isNotGlobalDescendant || GlobalDescendantsAreEditable) && ! isOnlyLibraryItem;
};
*/

/**
 * Get order class for module.
 *
 * @since 4.0
 *
 * @param {string} type
 * @param {number} index
 * @param {string} themeBuilderSuffix
 *
 * @returns {string}
 */
export function getModuleOrderClass(type, index, themeBuilderSuffix = '') {
  return `${type}_${index}${themeBuilderSuffix}`;
}

/**
 * Get whether a module type has a context menu.
 *
 * @since 4.0
 *
 * @param {string} moduleType
 *
 * @returns {boolean}
 */
export function hasContextMenu(moduleType) {
  return true;
}
