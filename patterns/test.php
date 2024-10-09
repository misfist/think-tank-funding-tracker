<?php
/**
 * Title: Test Pattern
 * Slug: ttft/test
 * Categories: transparency
 * Inserter: false
 */
?>
<!-- wp:paragraph -->
<p>I am here.</p>
<!-- /wp:paragraph -->

<table id="test-table"></table>

<script>

	document.addEventListener( 'DOMContentLoaded', function () {
		const data = {
			"columns": [
				{ "data": "think_tank", "title": "Think Tank" },
				{ "data": "foreign_gov", "title": "Foreign Government" },
				{ "data": "us_gov", "title": "US Government" },
				{ "data": "pentagon_contractor", "title": "Pentagon Contractor" },
				{ "data": "score", "title": "Score" }
			],
			"data": [
				{
					"think_tank": "Atlantic Council",
					"foreign_gov": 500000,
					"us_gov": 200000,
					"pentagon_contractor": 100000,
					"score": 0.85
				},
				{
					"think_tank": "Brookings Institution",
					"foreign_gov": 300000,
					"us_gov": 150000,
					"pentagon_contractor": 80000,
					"score": 0.75
				},
				{
					"think_tank": "Heritage Foundation",
					"foreign_gov": 200000,
					"us_gov": 250000,
					"pentagon_contractor": 60000,
					"score": 0.90
				},
				{
					"think_tank": "Center for Strategic & International Studies",
					"foreign_gov": 450000,
					"us_gov": 300000,
					"pentagon_contractor": 95000,
					"score": 0.88
				},
				{
					"think_tank": "RAND Corporation",
					"foreign_gov": 150000,
					"us_gov": 500000,
					"pentagon_contractor": 200000,
					"score": 0.92
				}
			]
		}
		const table = new DataTable( '#test-table', {
			data: data.data,
			columns: data.columns
		} );
	} );

</script>
