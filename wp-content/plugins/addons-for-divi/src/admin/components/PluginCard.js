import { __ } from '@wordpress/i18n';
import { useState, useEffect } from '@wordpress/element';
import { Dashicon } from '@wordpress/components';
import { Toast } from '@DashboardComponents';

const PluginCard = ({ plugin }) => {
	const { icon, name, slug, plugin_file, description, plugin_uri, type } =
		plugin;
	const imageUrl = `https://diviepic.b-cdn.net/common-assets/plugin-icons/${icon}?ver=1.0.1`;

	const [status, setStatus] = useState({
		isInstalled: false,
		isActive: false,
	});

	const [buttonLoading, setButtonLoading] = useState(false);

	useEffect(() => {
		fetchPluginStatus();
	}, [slug, plugin_file]);

	const fetchPluginStatus = () => {
		wp.apiFetch({
			path: '/divitorque-lite/v1/check_plugin_installed_and_active/',
			method: 'POST',
			data: { slug, plugin_file },
		}).then((res) => {
			setStatus({
				isInstalled: res.installed,
				isActive: res.active,
			});
		});
	};

	const handleActivate = () => {
		setButtonLoading(true);
		const path = '/divitorque-lite/v1/activate_plugin/';
		wp.apiFetch({
			path: path,
			method: 'POST',
			data: { slug, plugin_file },
		})
			.then((res) => {
				if (res.success) {
					setStatus((prevStatus) => ({
						isActive: res.success ? true : prevStatus.isActive,
						isInstalled: res.success
							? true
							: prevStatus.isInstalled,
					}));
					Toast(res.message, 'success');
				} else {
					Toast(res.message, 'error');
				}
			})
			.catch(() => {
				Toast(__('An error occurred.', 'addons-for-divi'), 'error');
			})
			.finally(() => {
				setButtonLoading(false);
			});
	};

	const handleInstall = () => {
		setButtonLoading(true);

		const path = '/divitorque-lite/v1/install_plugin/';

		wp.apiFetch({
			path: path,
			method: 'POST',
			data: { slug, plugin_file },
		})
			.then((res) => {
				if (res.success) {
					setStatus((prevStatus) => ({
						isInstalled: res.success
							? true
							: prevStatus.isInstalled,
					}));
					Toast(res.message, 'success');
				} else {
					Toast(res.message, 'error');
				}
			})
			.catch(() => {
				Toast(__('An error occurred.', 'addons-for-divi'), 'error');
			})
			.finally(() => {
				setButtonLoading(false);
			});
	};

	const renderActionButton = () => {
		if (status.isActive) return null;
		if (buttonLoading) return renderLoadingButton();

		if (status.isInstalled) {
			return renderActivateButton();
		} else {
			return renderInstallButton();
		}
	};

	const renderLoadingButton = () => (
		<button
			className="bg-de-app-color text-white text-sm font-bold px-5 py-2 rounded-lg flex items-center justify-center gap-2 disabled:opacity-75"
			disabled
		>
			<LoadingIcon />
			{__('Loading...', 'addons-for-divi')}
		</button>
	);

	const renderActivateButton = () => (
		<button
			className="bg-de-app-color-dark hover:bg-de-app-color focus:bg-de-app-color text-white text-sm px-3 py-1 rounded"
			onClick={handleActivate}
		>
			{__('Activate', 'addons-for-divi')}
		</button>
	);

	const renderInstallButton = () => (
		<button
			className="bg-de-app-color-dark hover:bg-de-app-color focus:bg-de-app-color text-white text-sm px-3 py-1 rounded"
			onClick={handleInstall}
		>
			{__('Install', 'addons-for-divi')}
		</button>
	);

	const LoadingIcon = () => (
		<svg className="animate-spin h-4 w-4 mr-1" viewBox="0 0 24 24">
			<path
				fill="currentColor"
				d="M12,2A10,10 0 1,0 22,12A10,10 0 0,0 12,2M12,0A12,12 0 1,1 0,12A12,12 0 0,1 12,0M12,5A7,7 0 1,0 19,12A7,7 0 0,0 12,5z"
			/>
		</svg>
	);

	return (
		<article className="flex flex-col items-start gap-5 border bg-white rounded border-[#e2e5ed] relative">
			<PluginBadge label={type == 'pro' ? 'Premium' : 'Free'} />
			<PluginHeader
				imageUrl={imageUrl}
				name={name}
				plugin_uri={plugin_uri}
			/>
			<PluginDescription description={description} />
			<PluginStatusFooter
				status={status}
				renderActionButton={renderActionButton}
				plugin_uri={plugin_uri}
				type={type}
			/>
		</article>
	);
};

const PluginBadge = ({ label }) => (
	<div className="absolute top-[15px] right-[15px] flex gap-1">
		<span
			key={label}
			className={`text-[12px] px-2 py-1 bg-[#ecfdf5] rounded-lg text-[#047857]`}
		>
			{__(label, 'addons-for-divi')}
		</span>
	</div>
);

const PluginHeader = ({ imageUrl, name, plugin_uri }) => (
	<div className="flex flex-col gap-5 px-5 pt-5">
		<img
			src={imageUrl}
			alt={`${name} Plugin Icon`}
			className="w-[50px] rounded"
		/>
		<h3 className="text-lg flex items-center">
			<a
				href={plugin_uri}
				target="_blank"
				rel="noopener noreferrer"
				className="text-[#222c39] hover:text-[#222c39] font-bold"
			>
				{name || __('Unknown Plugin', 'addons-for-divi')}
			</a>
		</h3>
	</div>
);

const PluginDescription = ({ description }) => (
	<p className="text-sm text-de-black px-5 pb-5 mb-auto">
		{description || __('No description provided.', 'addons-for-divi')}
	</p>
);

const PluginStatusFooter = ({
	status,
	renderActionButton,
	plugin_uri,
	type,
}) => (
	<div className="flex items-center justify-between px-5 py-5 w-full mt-auto">
		<PluginStatus status={status} />
		{type === 'pro' && !status.isInstalled
			? LearnMoreLink(plugin_uri)
			: renderActionButton()}
	</div>
);

const PluginStatus = ({ status }) => (
	<span className="flex items-center gap-2 text-sm" role="status">
		<span className="font-bold text-[#354559]">
			{__('Status:', 'addons-for-divi')}
		</span>
		{status.isInstalled ? (
			status.isActive ? (
				<span className="text-[#609952] font-medium">
					{__('Active', 'addons-for-divi')}
				</span>
			) : (
				<span className="text-[#586892]">
					{__('Installed', 'addons-for-divi')}
				</span>
			)
		) : (
			<span className="text-[#c53d3d]">
				{__('Not Installed', 'addons-for-divi')}
			</span>
		)}
	</span>
);

const LearnMoreLink = (plugin_uri) => (
	<a
		href={plugin_uri}
		target="_blank"
		rel="noopener noreferrer"
		className="bg-de-app-color-dark hover:bg-de-app-color focus:bg-de-app-color text-white hover:text-de-feather-gray text-sm px-3 py-1 rounded"
	>
		{__('Learn More', 'addons-for-divi')}
	</a>
);

export default PluginCard;
