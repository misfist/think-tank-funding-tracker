document.addEventListener('DOMContentLoaded', function () {
	const customFilters = document.getElementById('custom-filters');

	// Return early if #custom-filters is not present
	if (!customFilters) {
		return;
	}

	const filters = customFilters.querySelectorAll('.filter-checkbox');
	const url = new URL(window.location.href);
	const params = new URLSearchParams(url.search);

	// Set active tabs on initial load based on current query params
	filters.forEach(function (filter) {
		const queryVar = filter.dataset.queryVar || '';
		const paramKey = queryVar.split('=')[0];
		const paramValue = queryVar.split('=')[1]?.replace(/'/g, '');

		// Check if URL contains the parameter and value
		if (params.has(paramKey) && params.get(paramKey) === paramValue) {
			filter.checked = true;
		}

		// Event listener to update URL on filter change
		filter.addEventListener('change', function () {
			const queryVar = this.dataset.queryVar || '';
			const paramKey = queryVar.split('=')[0];

			if (this.checked) {
				// Remove the parameter if the "All" option is selected
				if (this.value === 'all' || this.value === '') {
					params.delete(paramKey);
				} else {
					// Otherwise, set the parameter
					const paramValue = queryVar.split('=')[1].replace(/'/g, '');
					params.set(paramKey, paramValue);
				}
			}

			// Generate the new URL
			const newUrl = params.toString()
				? `${url.pathname}?${params}`
				: url.pathname;

			// Reload the page with the updated URL
			window.location.href = newUrl;

			// Update the URL without reloading the page
			// const newUrl = params.toString() ? `${url.pathname}?${params}` : url.pathname;
			// window.history.replaceState({}, '', newUrl);
		});
	});
});
