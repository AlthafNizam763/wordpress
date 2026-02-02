<?php
define('WP_USE_THEMES', false);
require(__DIR__ . '/wp-load.php');

$pages = [
    'Ongoing & Past Events' => 'ongoing-events',
    'Courses & Training' => 'courses-training',
    'Projects' => 'projects',
    'Day Observations' => 'day-observations',
    'Collaborations' => 'collaborations',
    'Features in News' => 'features-news'
];

foreach ($pages as $title => $slug) {
    $existing_page = get_page_by_path($slug);

    if ($existing_page) {
        echo "Page '$title' already exists (ID: " . $existing_page->ID . ").\n";
    } else {
        $page_id = wp_insert_post([
            'post_title' => $title,
            'post_name' => $slug,
            'post_content' => '',
            'post_status' => 'publish',
            'post_type' => 'page',
            'post_author' => 1
        ]);

        if ($page_id && !is_wp_error($page_id)) {
            // Assign custom template if file exists (will create files next)
            update_post_meta($page_id, '_wp_page_template', 'page-' . $slug . '.php');
            echo "Created '$title' (ID: $page_id).\n";
        } else {
            echo "Error creating '$title'.\n";
        }
    }
}
?>