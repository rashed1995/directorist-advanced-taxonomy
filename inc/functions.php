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


