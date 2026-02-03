<?php

function race_theme_scripts()
{
    // Enqueue Styles
    wp_enqueue_style('race-style', get_stylesheet_uri(), array(), time());
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css');
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

// Function to display images for Day Observations
function race_display_day_observation_images($folder_name)
{
    $dir_path = get_template_directory() . '/images/' . $folder_name . '/';
    $dir_uri = get_template_directory_uri() . '/images/' . $folder_name . '/';

    if (!is_dir($dir_path))
        return;

    $images = glob($dir_path . "*.{jpg,jpeg,png,gif}", GLOB_BRACE);
    if (!$images)
        return;

    $count = count($images);
    $is_single = ($count === 1);

    $grid_style = "display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 40px;";

    // For single image, we might want to restrict width if it's too wide, but user asked for "preview" style.
    // The previous preview image was portrait. 
    // If we keep the grid 1fr, it will be full width.
    // We will rely on the image's intrinsic aspect ratio.

    echo '<div class="' . esc_attr($folder_name) . '-images" style="' . $grid_style . '">';

    foreach ($images as $image) {
        $filename = basename($image);
        $image_url = $dir_uri . $filename;

        echo '<div class="' . esc_attr($folder_name) . '-image" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">';

        if ($is_single) {
            // Single image: Smaller size (60%), centered margin auto style comes from parent grid if possible, but easier to set on image or container.
            // Actually, best to change the grid style for single items to center justify.
            // But here we can just restrict width.
            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($folder_name) . '" style="max-width: 250px; width: 100%; height: auto; object-fit: contain; display: block; margin: 20px 0; border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">';
        } else {
            // Multiple images: Fixed height for uniform grid
            echo '<img src="' . esc_url($image_url) . '" alt="' . esc_attr($folder_name) . '" style="width: 100%; height: 250px; object-fit: cover; display: block;">';
        }

        echo '</div>';
    }

    echo '</div>';
}