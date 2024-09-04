document.addEventListener('DOMContentLoaded', function () {
    const tabs = document.querySelectorAll('.tab-link a');
    const contents = document.querySelectorAll('.tab-content .tab');
	
	function dataTabs() {
		 // Function to get the value of a query parameter by name
		 function getQueryParam(param) {
			const urlParams = new URLSearchParams(window.location.search);
			return urlParams.get(param);
		}
	
		// Function to set the query parameter in the URL
		function setQueryParam(param, value) {
			const url = new URL(window.location);
			url.searchParams.set(param, value);
			history.pushState({}, '', url);
		}
	
		// Function to activate a tab based on its href
		function activateTab(href) {
			const targetTab = document.querySelector(`.tab-link a[href="${href}"]`);
			const targetContent = document.querySelector(href);
	
			if (targetTab && targetContent) {
				// Remove active class from all tabs and content
				tabs.forEach(tab => tab.parentElement.classList.remove('active'));
				contents.forEach(content => content.classList.remove('active'));
	
				// Add active class to the target tab and content
				targetTab.parentElement.classList.add('active');
				targetContent.classList.add('active');
	
				// Update URL with the selected entity_type
				const entityType = href === '#think-tank-results' ? 'think_tank' : 'donor';
				setQueryParam('entity_type', entityType);
			}
		}
	
		function activateSelector(entityType) {
			console.log(entityType);
		}
	
		// Check for the initial active tab based on the URL
		const entityType = getQueryParam('entity_type');
		let initialHref = '#think-tank-results'; // Default tab
	
		if (entityType === 'donor') {
			initialHref = '#donor-results';
		}
	
		activateTab(initialHref);
		activateSelector(entityType);
	
		// Handle tab click events
		tabs.forEach(tab => {
			tab.addEventListener('click', function(e) {
				e.preventDefault();
	
				const href = tab.getAttribute('href');
				const entityType = tab.getAttribute('data-entity-type');
				activateTab(href);
				activateSelector(entityType);
			});
		});
	}

	if( ! tabs.length || ! contents.length ) {
		return;
	}

	dataTabs();
});
