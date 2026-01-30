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