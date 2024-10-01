import jszip from 'jszip';
import pdfmake from 'pdfmake';
import DataTable from 'datatables.net';
import 'datatables.net-buttons';
import 'datatables.net-buttons/js/buttons.html5';
import 'datatables.net-buttons/js/buttons.print';
// import 'datatables.net-plugins/filtering/type-based/html.mjs';

const tableId = 'funding-data';
const table = document.getElementById(tableId);

if (table) {
	const title =
		document.querySelector('.site-main h1')?.innerText || document.title;
	const searchLabelAttr = table.getAttribute('data-search-label');
	const searchLabel = searchLabelAttr || 'Filter data';

	new DataTable(`#${tableId}`, {
		info: false,
		pageLength: 50,
		layout: {
			bottomEnd: {
				paging: {
					type: 'simple_numbers',
				},
			},
			topEnd: {
				search: {
					placeholder: 'Enter keyword...',
					text: searchLabelAttr,
				},
			},
			topStart: {
				buttons: [
					{
						extend: 'csvHtml5',
						title: title,
						text: 'Download Data',
					},
				],
			},
		},
		footerCallback: function (row, data, start, end, display) {
			let tfoot = table.querySelector('tfoot');
			let footerRow = tfoot.querySelector('tr');

			if (!footerRow) {
				footerRow = document.createElement('tr');
				tfoot.appendChild(footerRow);
			}

			console.log(
				'ROW',
				row,
				'DATA',
				data,
				'START',
				start,
				'END',
				end,
				'DISPLAY',
				display
			);
		},
	});
}
