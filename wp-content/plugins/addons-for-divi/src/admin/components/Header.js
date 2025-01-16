import React from 'react';
import { RightMenu } from '@DashboardComponents';

const Header = ({ children, pro_link }) => {
	return (
		<div className="bg-white shadow-de-header px-4 sm:px-8 lg:max-w-full">
			<div className="relative flex flex-col lg:flex-row justify-between h-24 lg:h-14 py-3 lg:py-0">
				<div className="lg:flex-1 flex items-start justify-center sm:items-stretch sm:justify-start">
					{children}
				</div>
				<RightMenu pro_link={pro_link} />
			</div>
		</div>
	);
};

export default Header;
