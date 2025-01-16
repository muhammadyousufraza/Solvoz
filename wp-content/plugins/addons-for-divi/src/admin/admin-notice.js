(() => {
	document.addEventListener('DOMContentLoaded', function () {
		var notice = document.getElementById(adminNoticeData.notice_slug);
		if (notice) {
			notice
				.querySelector('.notice-dismiss')
				.addEventListener('click', function () {
					var request = new XMLHttpRequest();
					request.open('POST', adminNoticeData.ajax_url, true);
					request.setRequestHeader(
						'Content-Type',
						'application/x-www-form-urlencoded'
					);
					request.onreadystatechange = function () {
						if (
							request.readyState === 4 &&
							request.status === 200
						) {
							JSON.parse(request.responseText);
						}
					};
					request.send(
						'action=dismiss_admin_notice&notice=' +
							encodeURIComponent(adminNoticeData.notice_slug) +
							'&security=' +
							encodeURIComponent(adminNoticeData.security)
					);
				});
		}
	});
})();
