<?php
/**
 * @author  wpWax
 * @since   6.6
 * @version 6.7
 */

use \Directorist\Helper;

if ( ! defined( 'ABSPATH' ) ) exit;
// Retrieve the display description settings
$display_category_description = !empty( get_directorist_option('display_categories_description') ) ? true : false;
var_dump($display_category_description);
$display_location_description = !empty( get_directorist_option('display_locations_description') ) ? true : false;
var_dump($display_location_description);

// Initialize description variable
$description = '';
$display_description = false;

// Get the description for category or location
if ($slug = get_query_var('atbdp_category')) {
    $term = get_term_by('slug', $slug, 'at_biz_dir-category');
    if ($term) {
        $description = $term->description;
        $display_description = $display_category_description;
    }
} elseif ($slug = get_query_var('atbdp_location')) {
    $term = get_term_by('slug', $slug, 'at_biz_dir-location');
    if ($term) {
        $description = $term->description;
        $display_description = $display_location_description;
    }
}
?>

<?php if ($display_description && !empty($description)): ?>
    <div class="description-container" style="background-color: #f2f2f2; padding: 20px; border: 1px solid #ccc; border-radius: 5px; margin-bottom: 20px;">
        <p class="tax-description" style="font-size: 16px; line-height: 1.6; color: #333;"><?php echo ($description); ?></p>
    </div>
<?php endif; ?>

<div class="directorist-archive-items directorist-archive-list-view">

	<?php do_action( 'directorist_before_list_listings_loop' ); ?>

	<div class="<?php Helper::directorist_container_fluid(); ?>">

		<?php if ( $listings->have_posts() ): ?>

			<?php foreach ( $listings->post_ids() as $listing_id ): ?>

				<?php $listings->loop_template( 'list', $listing_id ); ?>

			<?php endforeach; ?>

			<?php do_action( 'directorist_before_listings_pagination' ); ?>

			<?php
			if ( $listings->show_pagination ) {
				$listings->pagination();
			}
			?>

			<?php do_action('directorist_after_grid_listings_loop'); ?>

		<?php else: ?>

			<div class="directorist-archive-notfound"><?php esc_html_e( 'No listings found.', 'directorist' ); ?></div>

		<?php endif; ?>
	</div>
</div>