<?php
/**
 * Template Code
 */

use \Directorist\Helper;

if (!defined('ABSPATH')) exit;

// Retrieve the display description settings
$display_category_description = !empty( get_directorist_option('display_categories_description') ) ? true : false;
// var_dump($display_category_description);
$display_location_description = !empty( get_directorist_option('display_locations_description') ) ? true : false;
// var_dump($display_location_description);

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
        <p class="tax-description" style="font-size: 16px; line-height: 1.6; color: #333;"><?php echo esc_html($description); ?></p>
    </div>
<?php endif; ?>

<div class="directorist-archive-items directorist-archive-grid-view">
    <?php do_action('directorist_before_grid_listings_loop'); ?>
    <div class="<?php Helper::directorist_container_fluid(); ?>">
        <?php if ($listings->have_posts()): ?>
            <div class="<?php echo $listings->has_masonry() ? 'directorist-masonry' : ''; ?> <?php Helper::directorist_row(); ?>">
                <?php foreach ($listings->post_ids() as $listing_id): ?>
                    <div class="<?php Helper::directorist_column($listings->columns); ?> directorist-all-listing-col">
                        <?php $listings->loop_template('grid', $listing_id); ?>
                    </div>
                <?php endforeach; ?>
            </div>
            <?php do_action('directorist_before_listings_pagination'); ?>
            <?php if ($listings->show_pagination): ?>
                <?php $listings->pagination(); ?>
            <?php endif; ?>
            <?php do_action('directorist_after_grid_listings_loop'); ?>
        <?php else: ?>
            <div class="directorist-archive-notfound"><?php esc_html_e('No listings found.', 'directorist'); ?></div>
        <?php endif; ?>
    </div>
</div>



<?php

/**
 * Add your custom php code here
 */


 add_filter('atbdp_listing_type_settings_field_list', function($fields) {
    $new_fields = [
        'display_categories_description' => [
            'label' => __('Display Description', 'directorist'),
            'type'  => 'toggle',
            'value' => false,
        ],
        'display_locations_description' => [
            'label' => __('Display Description', 'directorist'),
            'type'  => 'toggle',
            'value' => false,
        ],
    ];

    return array_merge($fields, $new_fields);
});

add_filter('atbdp_categories_settings_sections', function($sections) {
    $sections['categories_settings']['fields'][] = 'display_categories_description';
    $sections['locations_settings']['fields'][] = 'display_locations_description';
    return $sections;
});


