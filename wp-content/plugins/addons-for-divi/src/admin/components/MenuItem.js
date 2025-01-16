import React from 'react';
import { __ } from '@wordpress/i18n';
import { NavLink } from 'react-router-dom';

const MenuItem = ({ name, path }) => {
	const classes =
		'text-sm font-medium hover:text-de-app-color inline-flex items-center px-4 transition-colors duration-200 ease-in-out';

	return (
		<NavLink
			key={path}
			to={path}
			className={({ isActive }) =>
				`${classes} ${
					isActive ? 'text-de-app-color' : ' text-de-black'
				}`
			}
		>
			{name}
		</NavLink>
	);
};

export default MenuItem;
