<?php
/* Template Name: Gallery */
get_header(); ?>

<section class="page-header" style="background-color: #f4f4f4; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase;">Gallery</h1>
        <p style="color: #666; font-size: 18px;">A visual journey through our events and activities.</p>
    </div>
</section>

<main class="container" style="padding: 60px 20px;">
    <div class="gallery-masonry" style="column-count: 4; column-gap: 20px;">
        <?php
        $gallery_path = get_template_directory() . '/images/gallery/';
        $gallery_url = get_template_directory_uri() . '/images/gallery/';

        // Get all image files
        $images = glob($gallery_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

        if ($images) {
            foreach ($images as $image) {
                $image_name = basename($image);
                echo '<div class="gallery-item" style="break-inside: avoid; margin-bottom: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';
                echo '<a href="' . $gallery_url . $image_name . '" target="_blank">';
                echo '<img src="' . $gallery_url . $image_name . '" alt="Gallery Image" style="width: 100%; height: auto; display: block; transition: transform 0.5s ease;" onmouseover="this.style.transform=\'scale(1.05)\'" onmouseout="this.style.transform=\'scale(1)\'">';
                echo '</a>';
                echo '</div>';
            }
        } else {
            echo '<p style="text-align: center; color: #666;">No images found in the gallery.</p>';
        }
        ?>
    </div>
    <style>
        @media (max-width: 1200px) {
            .gallery-masonry {
                column-count: 3 !important;
            }
        }

        @media (max-width: 768px) {
            .gallery-masonry {
                column-count: 2 !important;
            }
        }

        @media (max-width: 480px) {
            .gallery-masonry {
                column-count: 1 !important;
            }
        }

        /* Lightbox Styles */
        .lightbox-overlay {
            display: none;
            position: fixed;
            z-index: 10001;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.9);
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .lightbox-overlay.active {
            display: flex;
            opacity: 1;
        }

        .lightbox-content {
            position: relative;
            max-width: 90%;
            max-height: 90%;
        }

        .lightbox-image {
            max-width: 100%;
            max-height: 90vh;
            border-radius: 4px;
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5);
            display: block;
        }

        .lightbox-close {
            position: absolute;
            top: 20px;
            right: 30px;
            color: #fff;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            z-index: 10002;
            transition: color 0.3s;
        }

        .lightbox-close:hover {
            color: #aaa;
        }

        .lightbox-prev,
        .lightbox-next {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            color: #fff;
            font-size: 30px;
            font-weight: bold;
            cursor: pointer;
            user-select: none;
            padding: 20px;
            transition: background 0.3s;
            border-radius: 5px;
        }

        .lightbox-prev:hover,
        .lightbox-next:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }

        .lightbox-prev {
            left: 20px;
        }

        .lightbox-next {
            right: 20px;
        }
    </style>

    <!-- Lightbox Modal -->
    <div id="galleryLightbox" class="lightbox-overlay">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <div class="lightbox-prev" onclick="changeImage(-1)">&#10094;</div>
        <div class="lightbox-next" onclick="changeImage(1)">&#10095;</div>
        <div class="lightbox-content">
            <img id="lightboxImg" src="" class="lightbox-image">
        </div>
    </div>
</main>

<script>
    let images = [];
    let currentIndex = 0;
    const lightbox = document.getElementById('galleryLightbox');
    const lightboxImg = document.getElementById('lightboxImg');

    // Initialize Gallery
    document.addEventListener('DOMContentLoaded', function () {
        const galleryLinks = document.querySelectorAll('.gallery-item a');

        galleryLinks.forEach((link, index) => {
            images.push(link.href);

            link.addEventListener('click', function (e) {
                e.preventDefault();
                currentIndex = index;
                openLightbox();
                showImage();
            });
        });
    });

    function openLightbox() {
        lightbox.classList.add('active');
        document.body.style.overflow = 'hidden'; // Disable scroll
    }

    function closeLightbox() {
        lightbox.classList.remove('active');
        document.body.style.overflow = 'auto'; // Enable scroll
    }

    function showImage() {
        lightboxImg.src = images[currentIndex];
    }

    function changeImage(n) {
        currentIndex += n;
        if (currentIndex >= images.length) {
            currentIndex = 0;
        } else if (currentIndex < 0) {
            currentIndex = images.length - 1;
        }
        showImage();
    }

    // Keyboard Control
    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('active')) return;

        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') changeImage(-1);
        if (e.key === 'ArrowRight') changeImage(1);
    });

    // Close on outside click
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) {
            closeLightbox();
        }
    });
</script>

<?php get_footer(); ?>