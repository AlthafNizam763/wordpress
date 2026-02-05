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
                <div class="logo">
                    <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo">
                </div>

                <ul class="nav-links">
                    <li><a href="<?php echo home_url('/#home'); ?>">Home</a></li>
                    <li><a href="<?php $p = get_page_by_path('about');
                    echo $p ? get_permalink($p) : home_url('/about'); ?>">About
                            Us</a></li>
                    <li><a href="<?php echo home_url('/team-race'); ?>">Team Race</a></li>
                    <li class="has-dropdown">
                        <a href="#">Action Plan</a>
                        <ul class="dropdown">
                            <li><a href="<?php echo home_url('/ongoing-events'); ?>">Ongoing & Past Events</a>
                            </li>
                            <li><a href="<?php echo home_url('/courses-training'); ?>">Courses & Training</a></li>
                            <li><a href="<?php echo home_url('/projects'); ?>">Projects</a></li>
                            <li><a href="<?php echo home_url('/day-observations'); ?>">Day Observations</a></li>
                            <li><a href="<?php echo home_url('/collaborations'); ?>">Collaborations</a></li>
                            <li><a href="<?php echo home_url('/features-news'); ?>">Features in News</a></li>
                        </ul>
                    </li>
                    <li><a href="<?php echo home_url('/meet-our-changemakers'); ?>">Meet Our Changemakers</a></li>
                    <li><a href="<?php echo home_url('/gallery'); ?>">Gallery</a></li>
                    <li><a href="<?php echo home_url('/your-voice-matters'); ?>">Your Voice Matters</a></li>
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