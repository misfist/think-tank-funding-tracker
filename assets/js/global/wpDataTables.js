jQuery(document).ready(function ($) {
	const tableId = '#table_1';
	const table = $(tableId).DataTable();

	if (!table) {
		console.error("Table object doesn't exist");
		return;
	}

	function applyFilter() {
		const $filters = $('.filter-group');
		if (!$filters) {
			console.warn('No filters present on page.');
			return;
		}

		$filters.each(function () {
			const columnIndex = $(this).data('index');
			const selectedValue = $(this).find('input:radio:checked').val();

			if (selectedValue === 'all') {
				table.column(columnIndex).search('').draw();
			} else {
				table.column(columnIndex).search(selectedValue).draw();
			}
		});
	}

	$('.filter-checkbox').on('change', function () {
		applyFilter();
	});

	applyFilter();
});
