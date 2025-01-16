import React from 'react';
import { useLocation } from 'react-router-dom';
import { __ } from '@wordpress/i18n';
import { UpsellSection } from '@DashboardComponents';

// Import your pages/components
import Modules from './pages/module-manager';
import Rollback from './pages/rollback';
const Popups = () => (
	<UpsellSection
		heading="Create Popups with Divi Torque Pro"
		points={[
			'A Blank Canvas For Your Creations',
			'Determine the visitor’s activities that make the visitor qualify for a specific popup.',
			'Choose the pages you want to have the popup load on - based on a specific page, publish date, categories, and more.',
			'Set rules for the popup display, such as after a certain amount of time, page visits, scroll depth, and more.',
		]}
		upgradeLink="https://diviepic.com/divi-torque-pro/#pricing"
		videoLink=""
	/>
);

const GoogleReviews = () => (
	<UpsellSection
		heading="Display Google Reviews on Your Site"
		points={[
			'All connected Google reviews are automatically updated',
			'Display reviews on any page, post, or custom page',
			'Choose the number of reviews to display',
			'Responsive and really cool Slider, Grid and List layouts',
		]}
		upgradeLink="https://diviepic.com/divi-torque-pro/#pricing"
		videoLink=""
	/>
);

const Submissions = () => (
	<UpsellSection
		heading="Collect Leads with Divi Torque Pro"
		points={[
			'Collect lead submissions directly within your WordPress Admin to manage, analyze and perform bulk actions on the submitted lead',
		]}
		upgradeLink="https://diviepic.com/divi-torque-pro/#pricing"
		videoLink=""
	/>
);

const DiviMailer = () => (
	<UpsellSection
		heading="Send Email with Divi Mailer"
		points={[
			'Fixes your email deliverability issues by reconfiguring WordPress to use a proper SMTP provider when sending emails.',
		]}
		upgradeLink="https://diviepic.com/divi-torque-pro/#pricing"
		videoLink=""
	/>
);

const DarkMode = () => (
	<UpsellSection
		heading="Dark Mode for Divi"
		points={['Floating Dark Mode Switch', 'Dark Mode Color Presets']}
		upgradeLink="https://diviepic.com/divi-torque-pro/#pricing"
		videoLink=""
	/>
);

const AppRoutes = () => {
	const location = useLocation();
	const query = new URLSearchParams(location.search);

	const page = query.get('page') || '';
	const path = query.get('path') || '';

	let routePage = <p>{__('Page not found', 'divitorque')}</p>;

	if (diviTorqueLite.admin_slug === page) {
		switch (path) {
			case '':
			case 'module-manager':
				routePage = <Modules />;
				break;

			case 'popups':
				routePage = <Popups />;
				break;

			case 'form-submissions':
				routePage = <Submissions />;
				break;

			case 'google-reviews':
				routePage = <GoogleReviews />;
				break;

			case 'divi-mailer':
				routePage = <DiviMailer />;
				break;

			case 'dark-mode':
				routePage = <DarkMode />;
				break;

			case 'rollback':
				routePage = <Rollback />;
				break;

			default:
				routePage = <p>{__('Page not found', 'divitorque')}</p>;
				break;
		}
	}

	return <>{routePage}</>;
};

export default AppRoutes;
