import React from 'react';

const Menu = ({ children }) => {
	return (
		<div className="flex items-center flex-row ml-[2rem]">{children}</div>
	);
};

export default Menu;
