<?php

function race_theme_scripts()
{
    wp_enqueue_style('race-style', get_stylesheet_uri(), array(), filemtime(get_stylesheet_directory() . '/style.css'));
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css', array(), '6.5.2');
}
add_action('wp_enqueue_scripts', 'race_theme_scripts');

function race_theme_setup()
{
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    remove_action('wp_footer', 'the_block_template_skip_link');
}
add_action('after_setup_theme', 'race_theme_setup');

function race_create_pages()
{
    $page_title = 'About Us';

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
        wp_insert_post(array(
            'post_type' => 'page',
            'post_title' => $page_title,
            'post_content' => '',
            'post_status' => 'publish',
            'post_author' => 1,
            'post_name' => 'about',
        ));
    }
}
add_action('init', 'race_create_pages');

function race_get_page_url($path)
{
    $page = get_page_by_path($path);
    return $page ? get_permalink($page) : home_url('/' . trim($path, '/'));
}

function race_is_active($path)
{
    $page = get_page_by_path($path);
    return ($page && is_page($page->ID)) ? 'is-active' : '';
}

function race_get_image_files($folder_name)
{
    $dir_path = trailingslashit(get_template_directory()) . 'images/' . trim($folder_name, '/') . '/';

    if (!is_dir($dir_path)) {
        return array();
    }

    $files = glob($dir_path . '*.{jpg,jpeg,png,gif,webp}', GLOB_BRACE);
    return $files ?: array();
}

function race_get_image_url($folder_name, $filename)
{
    return trailingslashit(get_template_directory_uri()) . 'images/' . trim($folder_name, '/') . '/' . $filename;
}

function race_get_first_image_url($folder_name, $fallback = '')
{
    $images = race_get_image_files($folder_name);
    if (!$images) {
        return $fallback;
    }

    return race_get_image_url($folder_name, basename($images[0]));
}

function race_render_page_hero($args = array())
{
    $defaults = array(
        'eyebrow' => 'Research Academy for Creative Excellence',
        'title' => get_the_title(),
        'description' => '',
        'image' => trailingslashit(get_template_directory_uri()) . 'images/bg.jpg',
        'align' => 'center',
    );

    $args = wp_parse_args($args, $defaults);
    $style = $args['image'] ? ' style="--hero-image: url(\'' . esc_url($args['image']) . '\');"' : '';
    ?>
    <section class="page-hero page-hero-<?php echo esc_attr($args['align']); ?>"<?php echo $style; ?>>
        <div class="container">
            <div class="page-hero__content animate-on-scroll">
                <span class="eyebrow"><?php echo esc_html($args['eyebrow']); ?></span>
                <h1><?php echo esc_html($args['title']); ?></h1>
                <?php if ($args['description']) : ?>
                    <p><?php echo esc_html($args['description']); ?></p>
                <?php endif; ?>
            </div>
        </div>
    </section>
    <?php
}

function race_render_media_grid($folder_name, $options = array())
{
    $defaults = array(
        'class' => '',
        'lightbox_group' => $folder_name,
        'columns' => 'grid',
        'card_class' => 'media-card',
        'image_class' => 'media-card__image',
    );

    $options = wp_parse_args($options, $defaults);
    $images = race_get_image_files($folder_name);

    if (!$images) {
        echo '<p class="empty-state">No media available yet.</p>';
        return;
    }

    $wrapper_class = $options['columns'] === 'masonry' ? 'media-masonry' : 'media-grid';
    $wrapper_class .= $options['class'] ? ' ' . $options['class'] : '';

    echo '<div class="' . esc_attr($wrapper_class) . '">';

    foreach ($images as $image) {
        $filename = basename($image);
        $image_url = race_get_image_url($folder_name, $filename);
        echo '<a class="' . esc_attr($options['card_class']) . ' animate-on-scroll" href="' . esc_url($image_url) . '" data-lightbox-group="' . esc_attr($options['lightbox_group']) . '">';
        echo '<img class="' . esc_attr($options['image_class']) . '" src="' . esc_url($image_url) . '" alt="' . esc_attr(pathinfo($filename, PATHINFO_FILENAME)) . '">';
        echo '</a>';
    }

    echo '</div>';
}

function race_render_video_cards()
{
    $videos_path = trailingslashit(get_template_directory()) . 'videos/';
    $videos_url = trailingslashit(get_template_directory_uri()) . 'videos/';
    $videos = glob($videos_path . '*.{mp4,webm,ogg}', GLOB_BRACE);

    if (!$videos) {
        echo '<p class="empty-state">No videos available yet.</p>';
        return;
    }

    echo '<div class="video-grid">';

    foreach ($videos as $index => $video) {
        $video_name = basename($video);
        $title = ucwords(str_replace(array('-', '_'), ' ', pathinfo($video_name, PATHINFO_FILENAME)));
        echo '<button class="video-card animate-on-scroll" type="button" data-video-index="' . esc_attr($index) . '" data-video-src="' . esc_url($videos_url . $video_name) . '" data-video-title="' . esc_attr($title) . '">';
        echo '<video src="' . esc_url($videos_url . $video_name) . '" preload="metadata" muted playsinline></video>';
        echo '<span class="video-card__play"><i class="fas fa-play"></i></span>';
        echo '<span class="video-card__title">' . esc_html($title) . '</span>';
        echo '</button>';
    }

    echo '</div>';
}

function race_render_day_observation_images($folder_name)
{
    race_render_media_grid($folder_name, array(
        'class' => 'observation-gallery',
        'lightbox_group' => $folder_name,
    ));
}

function race_display_day_observation_images($folder_name)
{
    race_render_day_observation_images($folder_name);
}
