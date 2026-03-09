<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
    <!-- Header -->
    <header id="header">
        <div class="container">
            <nav>
                <a href="<?php echo home_url(); ?>" class="logo-link">
                    <div class="logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo">
                        <div class="brand-text">
                            <span class="red-letter">r</span>esearch academy for<br>
                            creative excellence
                        </div>
                    </div>
                </a>

                <?php
$current_url = home_url($_SERVER['REQUEST_URI']);
function is_active($path)
{
    $page = get_page_by_path($path);
    if ($page && is_page($page->ID))
        return 'active';
    return '';
}
?>
                <ul class="nav-links">
                    <li><a href="<?php echo home_url('/#home'); ?>" class="<?php echo(is_front_page()) ? 'active' : ''; ?>">Home</a></li>
                    <li><a href="<?php $p = get_page_by_path('about');
echo $p ? get_permalink($p) : home_url('/about'); ?>" class="<?php echo is_active('about'); ?>">About Us</a></li>
                    <li><a href="<?php echo home_url('/team-race'); ?>" class="<?php echo is_active('team-race'); ?>">Team Race</a></li>
                    <li class="has-dropdown">
                        <a href="#" class="<?php echo(is_page(['ongoing-events', 'courses-training', 'projects', 'day-observations', 'collaborations', 'features-news'])) ? 'active' : ''; ?>">Action Plan</a>
                        <ul class="dropdown">
                            <li><a href="<?php echo home_url('/ongoing-events'); ?>" class="<?php echo is_active('ongoing-events'); ?>">Ongoing & Past Events</a></li>
                            <li><a href="<?php echo home_url('/courses-training'); ?>" class="<?php echo is_active('courses-training'); ?>">Courses & Training</a></li>
                            <li><a href="<?php echo home_url('/projects'); ?>" class="<?php echo is_active('projects'); ?>">Projects</a></li>
                            <li><a href="<?php echo home_url('/day-observations'); ?>" class="<?php echo is_active('day-observations'); ?>">Day Observations</a></li>
                            <li><a href="<?php echo home_url('/collaborations'); ?>" class="<?php echo is_active('collaborations'); ?>">Collaborations</a></li>
                            <li><a href="<?php echo home_url('/features-news'); ?>" class="<?php echo is_active('features-news'); ?>">Features in News</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo home_url('/meet-our-changemakers'); ?>" class="<?php echo is_active('meet-our-changemakers'); ?>">Meet Our Changemakers</a></li>
                    <li><a href="<?php echo home_url('/gallery'); ?>" class="<?php echo is_active('gallery'); ?>">Gallery</a></li>
                    <li><a href="<?php echo home_url('/your-voice-matters'); ?>" class="<?php echo is_active('your-voice-matters'); ?>">Your Voice Matters</a></li>
                </ul>
                <!-- <div class="header-actions">
                    <a href="#search"><svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg></a>
                </div> -->
                <div class="mobile-menu-toggle">
                    <span class="bar"></span>
                    <span class="bar"></span>
                    <span class="bar"></span>
                </div>
            </nav>
        </div>
    </header>