<?php
/**
 * Render Tables Functions
 */
namespace Quincy\ttft;

/**
 * Generate table for top ten
 *
 * @param string $donor_type Optional. The slug of the donor_type taxonomy term. Default empty.
 * @param string $donation_year Optional. The slug of the donation_year taxonomy term. Default empty.
 * @param int    $number_of_items Optional. The number of items to return. Default 10.
 * @return string HTML table markup.
 */
function generate_top_ten_table( $donor_type = '', $donation_year = '', $number_of_items = 10 ): string {
	$data = get_top_ten_data( $donor_type, $donation_year, $number_of_items );

	ob_start();
	if ( $data ) :
		?>

		<table id="table-<?php echo sanitize_title( $donor_type ); ?>" class="top-ten-recipients dataTable" data-total-rows="<?php echo intval( count( $data ) ); ?>">
			<thead>
				<tr>
					<th class="column-think-tank"><?php esc_html_e( 'Think Tank', 'ttft-data-tables' ); ?></th>
					<th class="column-min-amount column-numeric"><?php esc_html_e( 'Min Amount', 'ttft-data-tables' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $data as $row ) : ?>
					<tr>
						<td class="column-think-tank" data-heading="<?php esc_attr_e( 'Think Tank', 'ttft-data-tables' ); ?>">
							<a href="<?php echo esc_url( get_term_link( $row['think_tank'], 'think_tank' ) ); ?>"><?php echo esc_html( $row['think_tank'] ); ?></a>
						</td>
						<td class="column-min-amount column-numeric" data-heading="<?php esc_attr_e( 'Min Amount', 'ttft-data-tables' ); ?>"><?php echo number_format( $row['total_amount'], 0 ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>

		<?php
	endif;

	return ob_get_clean();
}

/**
 * Return the appropriate table based on the table_type.
 *
 * @param string $table_type The type of table to generate.
 * @param array  $args       Parameters required for table generation.
 * @return string            The generated table HTML markup.
 */
function generate_data_table( $table_type, $args ): string {
	switch ( $table_type ) {
		case 'think-tank-archive':
			return generate_think_tank_archive_table( $args['donation_year'] ?? '' );
		case 'single-think-tank':
			return generate_single_think_tank_table(
				$args['think_tank'] ?? '',
				$args['donation_year'] ?? '',
				$args['donor_type'] ?? ''
			);
		case 'donor-archive':
			return generate_donor_archive_table(
				$args['donation_year'] ?? '',
				$args['donor_type'] ?? ''
			);
		case 'single-donor':
			return generate_single_donor_table(
				$args['donor'] ?? '',
				$args['donation_year'] ?? '',
				$args['donor_type'] ?? ''
			);
		default:
			return __( 'Invalid table type.', 'ttft-data-tables' );
	}
}

/**
 * Generate table for think tanks
 *
 * @param  string $donation_year
 * @return string HTML table markup.
 */
function generate_think_tank_archive_table( $donation_year = '' ): string {
	$donation_year = sanitize_text_field( $donation_year );

	$data = get_think_tank_archive_data( $donation_year );

	ob_start();
	if ( $data ) :
		?>
		<table
			data-wp-interactive="<?php echo APP_NAMESPACE; ?>"
			
			data-wp-bind--id='state.tableId'
			class="think-tank-archive dataTable" 
			data-wp-bind--table-type='state.tableType'
			data-wp-bind--data-search-label='state.searchLabel'
		>
			<?php
			if ( $donation_year ) :
				?>
				<caption><?php printf( 'Donations in <span class="donation-year"  data-wp-text="state.donationYear">%s</span> received from…', $donation_year ); ?></caption>
				<?php
			endif;
			?>
			<thead>
				<tr>
					<th class="column-think-tank"><?php esc_html_e( 'Think Tank', 'ttft-data-tables' ); ?></th>
					<?php if ( ! empty( $data ) ) : ?>
						<?php
						$first_entry = reset( $data );
						foreach ( $first_entry['donor_types'] as $donor_type => $amount ) :
							?>
							<th class="column-numeric column-min-amount"><?php echo esc_html( $donor_type ); ?></th>
						<?php endforeach; ?>
					<?php endif; ?>
					<th class="column-numeric column-transparency-score"><?php esc_html_e( 'Score', 'ttft-data-tables' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $data as $think_tank_slug => $data ) : ?>
					<tr data-think-tank="<?php echo esc_attr( $think_tank_slug ); ?>">
						<td class="column-think-tank" data-heading="<?php esc_attr_e( 'Think Tank', 'ttft-data-tables' ); ?>"><a href="<?php echo esc_url( get_term_link( $think_tank_slug, 'think_tank' ) ); ?>"><?php echo esc_html( $data['think_tank'] ); ?></a></td>
						<?php foreach ( $data['donor_types'] as $donor_type => $amount ) : ?>
							<td class="column-numeric column-min-amount" data-heading="<?php echo esc_attr( $donor_type ); ?>"><?php echo esc_html( number_format( $amount, 0, '.', ',' ) ); ?></td>
						<?php endforeach; ?>
						<td class="column-numeric column-transparency-score" data-heading="<?php esc_attr_e( 'Transparency Score', 'ttft-data-tables' ); ?>"><?php echo esc_html( $data['transparency_score'] ); ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	endif;

	$output = ob_get_clean();

	return $output;
}

/**
 * Generate table for individual think tank
 *
 * @param string $think_tank    Optional. Slug of the think tank.
 * @param string $donation_year Optional. Slug of the donation year.
 * @param string $donor_type    Optional. Slug of the donor type.
 */
function generate_single_think_tank_table( $think_tank = '', $donation_year = '', $donor_type = '' ): string {
	$queried_obj   = get_queried_object();
	$think_tank    = sanitize_text_field( $think_tank );
	$donation_year = sanitize_text_field( $donation_year );
	$donor_type    = sanitize_text_field( $donor_type );

	$data = get_single_think_tank_data( $think_tank, $donation_year, $donor_type );

	ob_start();
	if ( $data ) :
		?>
		<table
			data-wp-interactive="<?php echo APP_NAMESPACE; ?>"
			data-wp-bind--id='state.tableId'
			class="single-think-tank dataTable" 
			data-wp-bind--table-type='state.tableType'
			data-wp-bind--data-search-label='state.searchLabel'
		>
			<?php
			if ( $donation_year ) :
				?>
				<caption><?php esc_html_e( 'Donations received in', 'ttft-data-tables' ); ?> <span class="donation-year" data-wp-text="context.donationYear"></span></caption>
				<?php
			endif;
			?>
			<thead>
				<tr>
					<th class="column-donor"><?php esc_html_e( 'Donor', 'ttft-data-tables' ); ?></th>
					<th class="column-numeric column-min-amount"><?php esc_html_e( 'Min Amount', 'ttft-data-tables' ); ?></th>
					<th class="column-source"><?php esc_html_e( 'Source', 'ttft-data-tables' ); ?></th>
					<th class="column-type"><?php esc_html_e( 'Type', 'ttft-data-tables' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $data as $key => $row ) :
					$amount           = $row['amount_calc'];
					$formatted_source = sprintf( '<a href="%1$s" class="source-link" target="_blank"><span class="screen-reader-text">%1$s</span><span class="icon material-symbols-outlined" aria-hidden="true">link</span></a>', esc_url( $row['source'] ) );
					?>
					<tr data-think-tank="<?php echo esc_attr( $row['donor_slug'] ); ?>">
						<td class="column-donor" data-heading="<?php esc_attr_e( 'Donor', 'ttft-data-tables' ); ?>"><a href="<?php echo esc_url( $row['donor_link'] ); ?>"><?php echo esc_html( $row['donor'] ); ?></a></td>
						<td class="column-numeric column-min-amount" data-heading="<?php esc_attr_e( 'Min Amount', 'ttft-data-tables' ); ?>"><?php echo esc_html( number_format( $amount, 0, '.', ',' ) ); ?>
						<td class="column-source" data-heading="<?php esc_attr_e( 'Source', 'ttft-data-tables' ); ?>"><?php echo ( $row['source'] ) ? $formatted_source : ''; ?></td>
						<td class="column-donor-type" data-heading="<?php esc_attr_e( 'Type', 'ttft-data-tables' ); ?>"><?php echo $row['donor_type']; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	endif;

	$output = ob_get_clean();

	return $output;
}


/**
 * Generate table for donors
 *
 * @param  string $donation_year
 * @return string HTML table markup.
 */
function generate_donor_archive_table( $donation_year = '', $donor_type = '' ): string {
	$donation_year = sanitize_text_field( $donation_year );
	$donor_type    = sanitize_text_field( $donor_type );

	$data = get_donor_archive_data( $donation_year, $donor_type );

	ob_start();
	if ( $data ) :
		?>
		<table 
			data-wp-interactive="<?php echo APP_NAMESPACE; ?>"
			
			data-wp-bind--id='state.tableId'
			class="donor-archive dataTable" 
			data-wp-bind--table-type='state.tableType'
			data-wp-bind--data-search-label='state.searchLabel'
		>
			<?php
			if ( $donation_year ) :
				?>
				<caption><?php printf( 'Donations given in <span class="donation-year" data-wp-text="context.donationYear">%s</span>…', $donation_year ); ?></caption>
				<?php
			endif;
			?>
			<thead>
				<tr>
					<th class="column-donor"><?php esc_html_e( 'Donor', 'ttft-data-tables' ); ?></th>
					<th class="column-numeric column-min-amount"><?php esc_html_e( 'Min Amount', 'ttft-data-tables' ); ?></th>
					<th class="column-type"><?php esc_html_e( 'Type', 'ttft-data-tables' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $data as $key => $row ) :
					$amount = $row['amount_calc'];
					?>
					<tr data-think-tank="<?php echo esc_attr( $row['donor_slug'] ); ?>">
						<td class="column-donor" data-heading="<?php esc_attr_e( 'Donor', 'ttft-data-tables' ); ?>"><a href="<?php echo esc_url( $row['donor_link'] ); ?>"><?php echo esc_html( $row['donor'] ); ?></a></td>
						<td class="column-numeric column-min-amount" data-heading="<?php esc_attr_e( 'Min Amount', 'ttft-data-tables' ); ?>"><?php echo esc_html( number_format( $amount, 0, '.', ',' ) ); ?>
						<td class="column-donor-type" data-heading="<?php esc_attr_e( 'Type', 'ttft-data-tables' ); ?>"><?php echo $row['donor_type']; ?>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	endif;

	$output = ob_get_clean();

	return $output;
}

/**
 * Generate table for individual donor
 *
 * @param string $donor    Optional. Slug of the donor.
 * @param string $donation_year Optional. Slug of the donation year.
 * @param string $donor_type    Optional. Slug of the donor type.
 */
function generate_single_donor_table( $donor = '', $donation_year = '', $donor_type = '' ): string {
	$donor         = sanitize_text_field( $donor );
	$donation_year = sanitize_text_field( $donation_year );
	$donor_type    = sanitize_text_field( $donor_type );

	$data = get_single_donor_data( $donor, $donation_year, $donor_type );

	ob_start();
	if ( $data ) :
		?>
		<table 
			data-wp-interactive="<?php echo APP_NAMESPACE; ?>"
			
			data-wp-bind--id='state.tableId'
			class="think-tank-archive dataTable" 
			data-wp-bind--table-type='state.tableType'
			data-wp-bind--data-search-label='state.searchLabel'
		>
			<?php
			if ( $donation_year ) :
				?>
				<caption><?php printf( 'Donations given in <span class="donation-year" data-wp-text="context.donationYear">%s</span>…', intval( $donation_year ) ); ?></caption>
				<?php
			endif;
			?>
			<thead>
				<tr>
					<th class="column-think-tank"><?php esc_html_e( 'Think Tank', 'ttft-data-tables' ); ?></th>
					<th class="column-donor"><?php esc_html_e( 'Donor', 'ttft-data-tables' ); ?></th>
					<th class="column-numeric column-min-amount"><?php esc_html_e( 'Min Amount', 'ttft-data-tables' ); ?></th>
					<th class="column-source"><?php esc_html_e( 'Source', 'ttft-data-tables' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php
				foreach ( $data as $key => $row ) :
					$amount           = $row['amount_calc'];
					$formatted_source = sprintf( '<a href="%1$s" class="source-link" target="_blank"><span class="screen-reader-text">%1$s</span><span class="icon material-symbols-outlined" aria-hidden="true">link</span></a>', esc_url( $row['source'] ) );
					?>
					<tr data-think-tank="<?php echo esc_attr( $row['think_tank_slug'] ); ?>">
						<td class="column-think-tank" data-heading="<?php esc_attr_e( 'Think Tank', 'ttft-data-tables' ); ?>"><a href="<?php echo esc_url( get_term_link( $row['think_tank_slug'], 'think_tank' ) ); ?>"><?php echo esc_html( $row['think_tank'] ); ?></a></td>
						<td class="column-donor" data-heading="<?php esc_attr_e( 'Donor', 'ttft-data-tables' ); ?>"><?php echo esc_html( $row['donor'] ); ?></td>
						<td class="column-numeric column-min-amount" data-heading="<?php esc_attr_e( 'Min Amount', 'ttft-data-tables' ); ?>"><?php echo esc_html( number_format( $amount, 0, '.', ',' ) ); ?>
						<td class="column-source" data-heading="<?php esc_attr_e( 'Source', 'ttft-data-tables' ); ?>"><?php echo ( $row['source'] ) ? $formatted_source : ''; ?></td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		<?php
	endif;

	$output = ob_get_clean();

	return $output;
}

/**
 * Render table for top ten
 *
 * @param  string  $donor_type
 * @param  string  $donation_year
 * @param  integer $number_of_items
 * @return void
 */
function render_top_ten_table( $donor_type = '', $donation_year = '', $number_of_items = 10 ): void {
	echo generate_top_ten_table( $donor_type, $donation_year, $number_of_items );
}

/**
 * Render table for think tanks
 *
 * @param  string  $donor_type
 * @param  string  $donation_year
 * @param  integer $number_of_items
 * @return void
 */
function render_think_tanks_table( $donation_year = '' ): void {
	echo generate_think_tank_archive_table( $donation_year );
}

/**
 * Render table for individual think tank
 *
 * @param string $think_tank    Optional. Slug of the think tank.
 * @param string $donation_year Optional. Slug of the donation year.
 * @param string $donor_type    Optional. Slug of the donor type.
 * @return void
 */
function render_think_tank_donor_table( $think_tank = '', $donation_year = '', $donor_type = '' ): void {
	echo generate_single_think_tank_table( $think_tank, $donation_year, $donor_type );
}

/**
 * Render table for individual donor
 *
 * @param string $donor    Optional. Slug of the donor.
 * @param string $donation_year Optional. Slug of the donation year.
 * @param string $donor_type    Optional. Slug of the donor type.
 * @return void
 */
function render_donor_think_tank_table( $donor = '', $donation_year = '', $donor_type = '' ): void {
	echo generate_single_donor_table( $donor, $donation_year, $donor_type );
}

/**
 * Render table for donors
 *
 * @param  string $donation_year
 * @return void
 */
function render_donors_table( $donation_year = '' ) {
	echo generate_donor_archive_table( $donation_year );
}
