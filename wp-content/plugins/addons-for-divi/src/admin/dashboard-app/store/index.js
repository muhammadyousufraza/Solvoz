import { combineReducers, createReduxStore, register } from '@wordpress/data';
import {
	modulesReducer,
	modulesActions,
	modulesResolvers,
	modulesControls,
	modulesSelectors,
} from './modules';

const STORE_NAME = 'divitorque/dashboard';

const createStore = (initialState) => {
	return createReduxStore(STORE_NAME, {
		reducer: combineReducers({
			modulesReducer,
		}),
		actions: {
			...modulesActions,
		},
		selectors: {
			...modulesSelectors,
		},
		resolvers: {
			...modulesResolvers,
		},
		controls: {
			...modulesControls,
		},
	});
};

const registerStore = ({ initialState = {} } = {}) => {
	register(createStore(initialState));
};

export default registerStore;
