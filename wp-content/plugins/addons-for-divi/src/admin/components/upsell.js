import React from 'react';
import { __ } from '@wordpress/i18n';

const UpsellSection = ({ heading, points, upgradeLink, videoLink }) => {
	return (
		<div className="flex flex-col md:flex-row items-center justify-between p-8">
			<div className="md:w-1/2">
				<h2 className="text-2xl font-bold mb-4">{heading}</h2>
				<ul className="mb-6 space-y-4">
					{points.map((point, index) => (
						<li key={index} className="flex items-start space-x-2">
							<span className="text-green-500">&#10003;</span>
							<p>{point}</p>
						</li>
					))}
				</ul>
				<a
					href={upgradeLink}
					className="inline-block px-6 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 hover:text-white"
					target="_blank"
				>
					{__('Upgrade Now', 'divitorque')}
				</a>
				<p className="mt-4 text-sm text-gray-600">
					*{' '}
					{__(
						'Requires an Pro subscription or lifetime access',
						'divitorque'
					)}
				</p>
			</div>
			<div className="md:w-1/2 mt-8 md:mt-0 flex justify-center">
				<iframe
					width="560"
					height="315"
					src={videoLink}
					title="YouTube video player"
					frameBorder="0"
					allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
					allowFullScreen
				></iframe>
			</div>
		</div>
	);
};

export default UpsellSection;

// Usage Example:
// <UpsellSection
//   heading="Create Forms and Collect Leads with Elementor Pro"
//   points={["Create single or multi-step forms to engage and convert visitors", "Use any field to collect the information you need", "Integrate your favorite marketing software", "Collect lead submissions directly within your WordPress Admin to manage, analyze and perform bulk actions on the submitted lead"]}
//   upgradeLink="https://example.com/upgrade"
//   videoLink="https://www.youtube.com/embed/dQw4w9WgXcQ"
// />
