import React, { useEffect } from 'react';
import { __ } from '@wordpress/i18n';
import { render } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';

import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import { ToastContainer } from 'react-toastify';
import { TorqueLogo, Header } from '@DashboardComponents';
import AppRoutes from './dashboard-app';
import registerStore from './dashboard-app/store';

import 'react-toastify/dist/ReactToastify.css';

domReady(() => {
	const rootElement = document.getElementById('divitorque-root');
	if (!rootElement) return;

	registerStore();

	const App = () => {
		return (
			<Router>
				<Header>
					<div className="flex-shrink-0 flex items-center justify-start gap-1">
						<TorqueLogo />
					</div>
				</Header>
				<Switch>
					<Route path="/">
						<AppRoutes />
					</Route>
				</Switch>
				<ToastContainer />
			</Router>
		);
	};

	render(<App />, rootElement);
});
