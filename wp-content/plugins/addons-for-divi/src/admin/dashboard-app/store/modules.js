const { apiFetch } = wp;

export const UPDATE_MODULE_STATUSES = 'UPDATE_MODULE_STATUSES';
export const API_FETCH = 'API_FETCH';

const initialState = {
	modulesStatuses: {},
};

export const modulesActions = {
	updateModuleStatuses: (modulesStatuses) => ({
		type: UPDATE_MODULE_STATUSES,
		modulesStatuses,
	}),

	fetchFromAPI: (request) => ({
		type: API_FETCH,
		request,
	}),
};

export const modulesReducer = (state = initialState, action) => {
	switch (action.type) {
		case UPDATE_MODULE_STATUSES:
			return {
				...state,
				modulesStatuses: action.modulesStatuses,
			};
		default:
			return state;
	}
};

export const modulesResolvers = {
	*getModulesStatuses() {
		try {
			const data = yield modulesActions.fetchFromAPI({
				path: '/divitorque-lite/v1/get_common_settings',
			});

			console.log(data);

			const modulesStatuses = data.modules_settings;

			yield modulesActions.updateModuleStatuses(modulesStatuses);
		} catch (error) {
			console.error('Error fetching module statuses:', error);
		}
	},
};

export const modulesControls = {
	[API_FETCH]: (action) => apiFetch(action.request),
};

export const modulesSelectors = {
	getModulesStatuses: (state) => state.modulesReducer.modulesStatuses,
};
