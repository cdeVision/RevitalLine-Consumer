<?php

/////////////////////////////////////////////////
// Testimonials
//

// Modify testimonial post type columns - add location, quote, and type columns
add_filter('manage_testimonial_posts_columns', 'custom_testimonial_columns');
function custom_testimonial_columns($columns) {
    unset($columns['date']);

    $new_columns = array();
    foreach ($columns as $key => $label) {
        $new_columns[$key] = $label;
        if ($key === 'title') {
            $new_columns['location'] = __('Location', 'textdomain');
        }
    }
    $new_columns['quote'] = __('Quote', 'textdomain');
    $new_columns['type']  = __('Type', 'textdomain');

    return $new_columns;
}

// Add the content for the new columns
add_action('manage_testimonial_posts_custom_column', 'custom_testimonial_column_content', 10, 2);
function custom_testimonial_column_content($column, $post_id) {
    if ($column === 'quote') {
        $quote = get_post_meta($post_id, 'quote', true);
        echo esc_html($quote);
    }
    if ($column === 'location') {
        $location = get_field('location', $post_id);
        echo esc_html($location);
    }
    if ($column === 'type') {
        $type = get_field('type', $post_id);
        echo esc_html($type);
    }
}

// Remove date filter dropdown for testimonial CPT
add_filter('disable_months_dropdown', function($disable, $post_type) {
    if ($post_type === 'testimonial') {
        return true;
    }
    return $disable;
}, 10, 2);

// Update testimonial post title with name custom field
add_action('acf/save_post', 'sync_testimonial_name_to_title', 20);
function sync_testimonial_name_to_title($post_id) {
    // Only run for review post type
    if (get_post_type($post_id) !== 'testimonial') {
        return;
    }
    
    // Avoid infinite loops
    remove_action('acf/save_post', 'sync_testimonial_name_to_title', 20);
    
    // Get the name custom field
    $name = get_field('name', $post_id);
    
    // Update post title if name exists
    if ($name) {
        wp_update_post(array(
            'ID' => $post_id,
            'post_title' => sanitize_text_field($name)
        ));
    }
    
    // Re-add the action
    add_action('acf/save_post', 'sync_testimonial_name_to_title', 20);
}
