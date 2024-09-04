<?php
/**
 * Title: Data Table - Think Tank
 * Slug: ttt/data-table-think-tank
 * Categories: transparency
 * Inserter: false
 * 
 * %VAR1% = think_tank
 * %VAR2% = donor
 * %VAR3% = donation_year
 * %VAR4% = donor_type
 * %VAR5% = limit
 */
use function Quincy\ttt\get_most_recent_donation_year;
use function Quincy\ttt\print_years;
use function Quincy\ttt\print_types;

$post_id        = get_the_ID();
$post_title     = get_the_title( $post_id );
$terms          = wp_get_post_terms( $post_id, 'think_tank' );
$term_name      = ( $terms ) ? $terms[0]->name : $post_title;
$limited_info   = get_post_meta( $post_id, 'limited_info', true );
$is_limited     = ( $limited_info && strtolower( trim( $limited_info ) ) == 'x' ) ? true : false;
$is_transparent = ( $limited_info && str_contains( strtolower( trim( $limited_info ) ), 'transparent' ) ) ? true : false;
$table_id       = 11;
$year           = get_most_recent_donation_year();

if ( $is_limited ) :
	?>
	<!-- wp:group {"metadata":{"name":"No Data"},"className":"no-data","style":{"spacing":{"padding":{"top":"var:preset|spacing|10","bottom":"var:preset|spacing|10","left":"var:preset|spacing|10","right":"var:preset|spacing|10"}}},"backgroundColor":"var:custom|color|pink-light","layout":{"type":"default"}} -->
		<div class="wp-block-group has-pink-light-background-color has-background no-data" style="background-color:var(--wp--custom--color--pink-light);padding-top:var(--wp--preset--spacing--10);padding-right:var(--wp--preset--spacing--10);padding-bottom:var(--wp--preset--spacing--10);padding-left:var(--wp--preset--spacing--10)">

		<!-- wp:heading {"level":4} -->
		<h4><?php esc_html_e( 'This think tank has not provided data about it\'s donations.', 'ttt' ); ?></h4>
		<!-- /wp:heading -->

	</div>
	<!-- /wp:group -->
	<?php
elseif ( $is_transparent ) :
	?>
		<!-- hidden -->
	<?php
else :
	?>

	<!-- wp:group {"metadata":{"name":"Data Filters"},"id":"custom-filters","className":"wpDataTables data-filters","layout":{"type":"default"}} -->
	<div id="custom-filters" class="wp-block-group wpDataTables data-filters" data-table-id="<?php echo intval( $table_id ); ?>" data-table-number="table_1">
		<?php
		print_years( '', 'think_tank', 3 );

		print_types( 4 );
		?>
	</div>
	<!-- /wp:group -->
	
	<!-- wp:shortcode -->
	<?php echo do_shortcode( "[wpdatatable id={$table_id} var1='{$term_name}' var2='']" ); ?>
	<!-- /wp:shortcode -->
	<?php
endif;
