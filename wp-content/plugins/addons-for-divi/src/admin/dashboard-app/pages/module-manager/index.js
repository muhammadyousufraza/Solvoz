import { __ } from '@wordpress/i18n';
import ModuleCard from './module-card';
import { Toast } from '@DashboardComponents';
import { useDispatch, useSelect } from '@wordpress/data';
import { useState, useEffect } from '@wordpress/element';

const Modules = () => {
	const {
		module_info: allLiteModules = [],
		pro_module_info: allProModules = [],
		is_lite_installed,
	} = window.diviTorqueLite || {};

	const allModules = [...allLiteModules, ...allProModules];

	const allModulesStatuses = useSelect((select) =>
		select('divitorque/dashboard').getModulesStatuses()
	);

	const [allEnabled, setAllEnabled] = useState(false);
	const [allDisabled, setAllDisabled] = useState(false);
	const [filter, setFilter] = useState('all');
	const [isLoading, setIsLoading] = useState(false);

	useEffect(() => {
		const liteModuleNames = allLiteModules.map((module) => module.name);
		const liteStatuses = Object.entries(allModulesStatuses)
			.filter(([key]) => liteModuleNames.includes(key))
			.map(([_, value]) => value);

		setAllDisabled(liteStatuses.every((status) => status === 'disabled'));
		setAllEnabled(liteStatuses.every((status) => status !== 'disabled'));
	}, [allModulesStatuses]);

	// Sort modules based on the 'new' badge and title
	const sortedModules = allModules.sort((a, b) => {
		if (a.badge === 'new' && b.badge !== 'new') return -1;
		if (a.badge !== 'new' && b.badge === 'new') return 1;
		return a.title.localeCompare(b.title);
	});

	const proModules = sortedModules.filter((module) => module.is_pro);
	const liteModules = sortedModules.filter((module) => !module.is_pro);

	const dispatch = useDispatch('divitorque/dashboard');

	const getFilteredModules = () => {
		switch (filter) {
			case 'pro':
				return proModules;
			case 'lite':
				return liteModules;
			default:
				return sortedModules;
		}
	};

	const toggleModuleStatus = async (status) => {
		if (isLoading) return;
		setIsLoading(true);

		const updatedStatuses = { ...allModulesStatuses };
		liteModules.forEach((module) => {
			updatedStatuses[module.name] = status ? module.name : 'disabled';
		});

		try {
			const res = await wp.apiFetch({
				path: '/divitorque-lite/v1/save_common_settings',
				method: 'POST',
				data: { modules_settings: updatedStatuses },
			});

			if (res.success) {
				dispatch.updateModuleStatuses(updatedStatuses);
				Toast(__('Successfully saved!', 'divitorque'), 'success');
			} else {
				Toast(__('Something went wrong!', 'divitorque'), 'error');
			}
		} catch (err) {
			Toast(err.message, 'error');
		} finally {
			setIsLoading(false);
		}
	};

	const renderModules = () => {
		return getFilteredModules().map((module, index) => (
			<ModuleCard
				key={index}
				moduleInfo={module}
				isLiteInstalled={is_lite_installed}
			/>
		));
	};

	return (
		<div className="divitorque-app">
			<div className="flex gap-4">
				<div className="w-3/4">
					<div className="bg-white p-4 rounded-lg">
						<h2 className="font-semibold text-2xl flex-1">
							{__('Module Manager', 'addons-for-divi')}
						</h2>

						<div className="mx-auto mt-5 flex items-center justify-between">
							<div className="flex items-center gap-2">
								{['all', 'pro', 'lite'].map((filterType) => (
									<button
										key={filterType}
										aria-label={__(
											filterType.charAt(0).toUpperCase() +
												filterType.slice(1),
											'addons-for-divi'
										)}
										type="button"
										className={`inline-flex items-center px-4 py-1 border text-sm font-medium rounded-full transition ${
											filter === filterType
												? 'bg-de-app-color-dark border-de-app-color-dark text-white'
												: 'bg-transparent border-de-gray text-de-gray hover:bg-white focus:text-de-gray'
										}`}
										onClick={() => setFilter(filterType)}
										disabled={isLoading}
									>
										{__(
											filterType.charAt(0).toUpperCase() +
												filterType.slice(1),
											'addons-for-divi'
										)}
										{filterType !== 'all' &&
											` (${
												filterType === 'pro'
													? proModules.length
													: liteModules.length
											})`}
									</button>
								))}
							</div>
							<div className="flex items-center gap-2">
								<button
									aria-label={__(
										'Disable',
										'addons-for-divi'
									)}
									type="button"
									className={`focus:text-de-black hover:bg-white relative inline-flex items-center px-4 py-2 border border-de-app-color-dark bg-transparent text-sm font-medium text-de-app-color-dark focus:z-10 rounded-md transition ${
										allDisabled || isLoading
											? 'opacity-50'
											: ''
									}`}
									onClick={() => toggleModuleStatus(false)}
									disabled={
										allDisabled ||
										filter === 'pro' ||
										isLoading
									}
								>
									{isLoading
										? __('Processing...', 'addons-for-divi')
										: __('Disable', 'addons-for-divi')}
								</button>
								<button
									aria-label={__('Enable', 'addons-for-divi')}
									type="button"
									className={`focus:text-slate-200 relative inline-flex items-center px-4 py-2 border border-de-app-color-dark bg-de-app-color-dark text-sm font-medium text-white focus:z-10 rounded-md transition ${
										allEnabled || isLoading
											? 'opacity-50'
											: ''
									}`}
									onClick={() => toggleModuleStatus(true)}
									disabled={
										allEnabled ||
										filter === 'pro' ||
										isLoading
									}
								>
									{isLoading
										? __('Processing...', 'addons-for-divi')
										: __('Enable', 'addons-for-divi')}
								</button>
							</div>
						</div>
						<div className="mx-auto mt-10 grid grid-flow-row grid-cols-3 gap-6">
							{renderModules()}
						</div>
					</div>
				</div>

				<div className="w-1/4">
					<div className="bg-white px-10 py-[40px] rounded-lg h-auto sticky top-10">
						<h2 className="font-semibold text-2xl mb-4">
							{__('🚀 Divi Torque Pro', 'addons-for-divi')}
						</h2>
						<p
							className="text-center text-base"
							dangerouslySetInnerHTML={{
								__html: __(
									'Get <strong>100</strong> lifetime licenses for just <strong>$89</strong> this Black Friday!',
									'addons-for-divi'
								),
							}}
						/>

						<ul className="list-inside py-[20px] text-base">
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('50+ Pro Modules', 'addons-for-divi')}
							</li>
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('Popup Builder', 'addons-for-divi')}
							</li>
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('Megamenu Builder', 'addons-for-divi')}
							</li>
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('Maintenance Mode', 'addons-for-divi')}
							</li>
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('Dark Menu', 'addons-for-divi')}
							</li>
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('Google Reviews', 'addons-for-divi')}
							</li>
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('Instagram Feed', 'addons-for-divi')}
							</li>
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('Divi Duplicate', 'addons-for-divi')}
							</li>
							<li className="flex items-center">
								<svg
									class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0"
									aria-hidden="true"
									xmlns="http://www.w3.org/2000/svg"
									fill="currentColor"
									viewBox="0 0 20 20"
								>
									<path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
								</svg>

								{__('Priority Support', 'addons-for-divi')}
							</li>
						</ul>

						<a
							href="https://diviepic.com/divi-torque-pro/?utm_source=module-manager&amp;utm_campaign=pro&amp;utm_medium=dashboard"
							className="w-full bg-de-app-color-dark hover:bg-de-app-color text-white hover:text-white text-base py-3 px-0 rounded block text-center"
							title={__('Get Divi Torque Pro', 'addons-for-divi')}
							target="_new"
						>
							{__('Get Divi Torque Pro', 'addons-for-divi')}
						</a>
					</div>
				</div>
			</div>
		</div>
	);
};

export default Modules;
