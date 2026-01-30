<?php

function race_theme_scripts()
{
    // Enqueue Styles
    wp_enqueue_style('race-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'race_theme_scripts');

// Add Title Tag Support and Fix Deprecated Warning
function race_theme_setup()
{
    add_theme_support('title-tag');
    // Fix for: Function the_block_template_skip_link is deprecated using remove_action
    remove_action('wp_footer', 'the_block_template_skip_link');
}
add_action('after_setup_theme', 'race_theme_setup');

// Auto-create pages if they don't exist
function race_create_pages()
{
    $page_title = 'About Us';

    // Replacement for deprecated get_page_by_title
    $query = new WP_Query(array(
        'post_type' => 'page',
        'title' => $page_title,
        'post_status' => 'all',
        'posts_per_page' => 1,
        'no_found_rows' => true,
        'ignore_sticky_posts' => true,
        'update_post_term_cache' => false,
        'update_post_meta_cache' => false,
    ));

    if (!$query->have_posts()) {
        $new_page = array(
            'post_type' => 'page',
            'post_title' => $page_title,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'about'
        );
        wp_insert_post($new_page);
    }
}
add_action('init', 'race_create_pages');