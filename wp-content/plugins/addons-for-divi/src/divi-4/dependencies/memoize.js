/* @license
See the license.txt file for licensing information for third-party code that may be used in this file.
Relative to the scripts/ directory, the license.txt file is located at ../license.txt.
This file (or the corresponding source JS file) has been modified by Jonathan Hall and/or others.
This file (or the corresponding source JS file) was last modified 2020-11-25
*/
/*
	This file is from the submodule-builder repository.
*/

import fastMemoize from 'fast-memoize';


function ObjectWithoutPrototypeCache() {
  this.cache = Object.create(null);
}

ObjectWithoutPrototypeCache.prototype.has = function(key) {
  return (key in this.cache);
};

ObjectWithoutPrototypeCache.prototype.get = function(key) {
  return this.cache[key];
};

ObjectWithoutPrototypeCache.prototype.set = function(key, value) {
  this.cache[key] = value;
};

ObjectWithoutPrototypeCache.prototype.clear = function() {
  this.cache = Object.create(null);
};

/**
 * @typedef {object} MemoizeResult
 * @property {Function} memoized - The new memoized function.
 * @property {Function} clear   - The function used to reset the cache.
 */

/**
 * Custom fast-memoize implementation to support the cache clear method.
 *
 * @param {Function} func The function to have its output memoized.
 *
 * @returns {MemoizeResult}
 */
export const createMemoize = func => {
  const store = new ObjectWithoutPrototypeCache();

  return {
    memoized: fastMemoize(func, {
      cache: {
        create() {
          return store;
        },
      },

      // Use the `variadic` strategy explicitly since we will be memoize functions with default params
      strategy: fastMemoize.strategies.variadic,
    }),
    clear: () => store.clear(),
  };
};
