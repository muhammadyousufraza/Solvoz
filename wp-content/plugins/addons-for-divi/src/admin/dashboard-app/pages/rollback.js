import React, { useState } from 'react';
import { Button, Modal } from '@wordpress/components';
import { __ } from '@wordpress/i18n';

const Rollback = () => {
	const currentVersion = window.diviTorqueLite?.currentVersion || '';
	const rollbackVersions = window.diviTorqueLite?.rollbackVersions || [];
	const [selectedVersion, setSelectedVersion] = useState();
	const [rollbackLoading, setRollbackLoading] = useState(false);
	const [isOpen, setOpen] = useState(false);

	let rollbackLink = window.diviTorqueLite?.rollbackLink;

	if (!selectedVersion) {
		setSelectedVersion(Object.keys(rollbackVersions)[0]);
	}

	const openModal = () => setOpen(true);
	const closeModal = () => setOpen(false);

	if ('undefined' !== typeof selectedVersion) {
		const url = new URL(rollbackLink);
		const searchParams = new URLSearchParams(url.search);
		searchParams.set('version', selectedVersion);
		url.search = searchParams.toString();
		const newUrl = url.toString();

		rollbackLink = newUrl;
	}

	const handleRollback = () => {
		setRollbackLoading(true);
		setTimeout(() => {
			window.location
				? (window.location.href = rollbackLink)
				: console.log('No window.location');
		}, 3000);

		closeModal();
	};

	return (
		<div className="divitorque-app">
			<h2 className="font-semibold text-2xl flex-1">
				{__('Rollback', 'divitorque')}
			</h2>

			<div className="mt-5 bg-white rounded-lg shadow-sm p-8">
				<div className="flex flex-col gap-5">
					<div>
						<h2 className="text-xl font-semibold text-gray-800 mb-2">
							{__(
								'Rollback to Previous Version',
								'addons-for-divi'
							)}
						</h2>
						<p className="text-gray-600">
							{__(
								`Experiencing an issue with Divi Torque Lite v${currentVersion}? Roll back to a previous version to help troubleshoot the issue.`,
								'addons-for-divi'
							)}
						</p>
					</div>

					<select
						className="w-full md:w-1/3 border border-gray-300 rounded-md px-4 py-2.5 text-gray-700 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-200"
						value={selectedVersion}
						onChange={(e) => setSelectedVersion(e.target.value)}
					>
						{Object.keys(rollbackVersions).map((version) => {
							return (
								<option key={version} value={version}>
									Version {version}
								</option>
							);
						})}
					</select>

					<button
						className="inline-flex bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50 items-center justify-center gap-2 transition-all duration-200 w-48"
						onClick={openModal}
					>
						{rollbackLoading && (
							<svg
								xmlns="http://www.w3.org/2000/svg"
								width="20"
								height="20"
								viewBox="0 0 24 24"
								fill="none"
								stroke="currentColor"
								strokeWidth="2"
								strokeLinecap="round"
								strokeLinejoin="round"
								className="animate-spin"
							>
								<polyline points="23 4 23 10 17 10"></polyline>
								<polyline points="1 20 1 14 7 14"></polyline>
								<path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
							</svg>
						)}
						{__('Rollback', 'addons-for-divi')}
					</button>

					{isOpen && (
						<Modal
							title={__(
								'Rollback to Previous Version',
								'addons-for-divi'
							)}
							onRequestClose={closeModal}
							className="bg-white p-6 rounded-lg max-w-lg mx-auto"
						>
							<div className="mb-6">
								<p className="text-gray-700">
									{__(
										`Are you sure you want to rollback to Divi Torque Lite v${selectedVersion}?`,
										'addons-for-divi'
									)}
								</p>
							</div>
							<div className="flex gap-3">
								<Button
									onClick={handleRollback}
									className="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-md transition-colors duration-200"
								>
									{__('Rollback', 'addons-for-divi')}
								</Button>

								<Button
									onClick={closeModal}
									className="border border-gray-300 hover:bg-gray-100 text-gray-700 px-5 py-2 rounded-md transition-colors duration-200"
								>
									{__('Cancel', 'addons-for-divi')}
								</Button>
							</div>
						</Modal>
					)}
				</div>
			</div>
		</div>
	);
};

export default Rollback;
