// External Dependencies
import $ from 'jquery';

// Internal Dependencies
import modules from '../../includes/modules/divi-4/index';

$(window).on('et_builder_api_ready', (event, API) => {
	API.registerModules(modules);
});
