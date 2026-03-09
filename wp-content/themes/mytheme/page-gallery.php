<?php
/* Template Name: Gallery */
get_header(); ?>
<section class="page-header animate-on-scroll"
    style="background: url('<?php echo get_template_directory_uri(); ?>/images/gallerybg.png') no-repeat center center; background-size: cover; padding: 60px 0; text-align: center;">
    <div class="container">
        <h1 style="font-size: 48px; margin-bottom: 20px; text-transform: uppercase; color: #080808ff;">Gallery</h1>
    </div>
</section>

<main class="container" style="padding: 60px 20px;">
    <!-- Tabs -->
    <div class="gallery-tabs">
        <button class="tab-btn active" onclick="switchGallery('photos')">
            <i class="fas fa-images"></i> Photos
        </button>
        <button class="tab-btn" onclick="switchGallery('reels')">
            <i class="fas fa-film"></i> Reels
        </button>
    </div>

    <!-- Photos Section -->
    <div id="photos-section" class="gallery-content-section active">
        <div class="gallery-masonry" style="column-count: 4; column-gap: 20px;">
            <?php
$gallery_path = get_template_directory() . '/images/gallery/';
$gallery_url = get_template_directory_uri() . '/images/gallery/';
$images = glob($gallery_path . '*.{jpg,jpeg,png,gif}', GLOB_BRACE);

if ($images) {
    foreach ($images as $image) {
        $image_name = basename($image);
        echo '<div class="gallery-item animate-on-scroll" style="break-inside: avoid; margin-bottom: 20px; border-radius: 8px; overflow: hidden; box-shadow: 0 4px 10px rgba(0,0,0,0.1);">';
        echo '<a href="' . $gallery_url . $image_name . '" target="_blank">';
        echo '<img src="' . $gallery_url . $image_name . '" alt="Gallery Image" style="width: 100%; height: auto; display: block; transition: transform 0.5s ease;" onmouseover="this.style.transform=\'scale(1.05)\'" onmouseout="this.style.transform=\'scale(1)\'">';
        echo '</a>';
        echo '</div>';
    }
}
else {
    echo '<p style="text-align: center; color: #666;">No images found in the gallery.</p>';
}
?>
        </div>
    </div>

    <!-- Reels Section -->
    <div id="reels-section" class="gallery-content-section">
        <div class="reels-grid">
            <?php
$videos_path = get_template_directory() . '/videos/';
$videos_url = get_template_directory_uri() . '/videos/';
$videos = glob($videos_path . '*.{mp4,webm,ogg}', GLOB_BRACE);

if ($videos) {
    foreach ($videos as $index => $video) {
        $video_name = basename($video);
        $display_name = str_replace(['.mp4', '.webm', '.ogg', '_'], ['', '', '', ' '], $video_name);
        echo '<div class="reel-item animate-on-scroll" onclick="openReelsViewer(' . $index . ')">';
        echo '<video src="' . $videos_url . $video_name . '" preload="metadata" muted playsinline></video>';
        echo '<div class="reel-overlay">';
        echo '<div class="play-icon"><i class="fas fa-play"></i></div>';
        echo '<div class="reel-title">' . esc_html($display_name) . '</div>';
        echo '</div>';
        echo '</div>';
    }
}
else {
    echo '<p style="text-align: center; color: #666; grid-column: 1/-1;">No videos found in the reels section.</p>';
}
?>
        </div>
    </div>

    <!-- Lightbox Modal for Images -->
    <div id="galleryLightbox" class="lightbox-overlay">
        <span class="lightbox-close" onclick="closeLightbox()">&times;</span>
        <div class="lightbox-prev" onclick="changeImage(-1)">&#10094;</div>
        <div class="lightbox-next" onclick="changeImage(1)">&#10095;</div>
        <div class="lightbox-content">
            <img id="lightboxImg" src="" class="lightbox-image">
        </div>
    </div>

    <!-- Instagram-style Reels Viewer Overlay -->
    <div id="reelsViewer" class="reels-viewer-overlay">
        <span class="reels-close" onclick="closeReelsViewer()">&times;</span>
        <div class="reels-scroll-container" id="reelsScrollContainer">
            <?php
if ($videos) {
    foreach ($videos as $index => $video) {
        $video_name = basename($video);
        $display_name = str_replace(['.mp4', '.webm', '.ogg', '_'], ['', '', '', ' '], $video_name);
        echo '<div class="reel-slide" data-index="' . $index . '">';
        echo '<video class="viewer-video" src="' . $videos_url . $video_name . '" loop muted playsinline></video>';
        echo '<div class="reel-info">';
        echo '<h3>' . esc_html($display_name) . '</h3>';
        echo '<button class="mute-toggle" onclick="toggleMute(this)"><i class="fas fa-volume-mute"></i></button>';
        echo '</div>';
        echo '</div>';
    }
}
?>
        </div>
    </div>

    <style>
        /* Gallery Masonry */
        @media (max-width: 1200px) { .gallery-masonry { column-count: 3 !important; } }
        @media (max-width: 768px) { .gallery-masonry { column-count: 2 !important; } }
        @media (max-width: 480px) { .gallery-masonry { column-count: 1 !important; } }

        /* Lightbox Styles */
        .lightbox-overlay {
            display: none; position: fixed; z-index: 10001; top: 0; left: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.9); justify-content: center; align-items: center; opacity: 0; transition: opacity 0.3s ease;
        }
        .lightbox-overlay.active { display: flex; opacity: 1; }
        .lightbox-content { position: relative; max-width: 90%; max-height: 90%; }
        .lightbox-image { max-width: 100%; max-height: 90vh; border-radius: 4px; box-shadow: 0 5px 25px rgba(0, 0, 0, 0.5); display: block; }
        .lightbox-close { position: absolute; top: 20px; right: 30px; color: #fff; font-size: 40px; font-weight: bold; cursor: pointer; z-index: 10002; transition: color 0.3s; }
        .lightbox-close:hover { color: #aaa; }
        .lightbox-prev, .lightbox-next { position: absolute; top: 50%; transform: translateY(-50%); color: #fff; font-size: 30px; font-weight: bold; cursor: pointer; user-select: none; padding: 20px; transition: background 0.3s; border-radius: 5px; }
        .lightbox-prev:hover, .lightbox-next:hover { background-color: rgba(255, 255, 255, 0.1); }
        .lightbox-prev { left: 20px; }
        .lightbox-next { right: 20px; }

        /* Gallery Tabs */
        .gallery-tabs { display: flex; justify-content: center; gap: 20px; margin-bottom: 40px; }
        .tab-btn { padding: 10px 25px; background: #f4f4f4; border: none; border-radius: 30px; cursor: pointer; font-weight: 600; color: #666; transition: all 0.3s ease; display: flex; align-items: center; gap: 8px; }
        .tab-btn i { font-size: 1.1em; }
        .tab-btn.active { background: #11823b; color: white; box-shadow: 0 4px 10px rgba(17, 130, 59, 0.3); }

        .gallery-content-section { display: none; }
        .gallery-content-section.active { display: block; }

        /* Reels Grid */
        .reels-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .reel-item { aspect-ratio: 9 / 16; background: #000; border-radius: 12px; overflow: hidden; position: relative; box-shadow: 0 4px 15px rgba(0,0,0,0.2); cursor: pointer; }
        .reel-item video { width: 100%; height: 100%; object-fit: cover; }
        .reel-overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.3); display: flex; flex-direction: column; justify-content: flex-end; padding: 15px; color: white; transition: background 0.3s ease; }
        .reel-item:hover .reel-overlay { background: rgba(0,0,0,0.1); }
        .reel-title { font-size: 14px; font-weight: 600; margin-bottom: 5px; text-shadow: 0 1px 3px rgba(0,0,0,0.5); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .play-icon { position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 40px; opacity: 0.8; transition: all 0.3s ease; }
        .reel-item:hover .play-icon { transform: translate(-50%, -50%) scale(1.1); opacity: 1; }

        @media (max-width: 1024px) { .reels-grid { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 768px) { .reels-grid { grid-template-columns: repeat(2, 1fr); } }
        @media (max-width: 480px) { .reels-grid { grid-template-columns: 1fr; } }

        /* Reels Viewer Styles */
        .reels-viewer-overlay { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: #000; z-index: 10005; }
        .reels-viewer-overlay.active { display: block; }
        .reels-scroll-container { width: 100%; height: 100%; overflow-y: scroll; scroll-snap-type: y mandatory; scrollbar-width: none; }
        .reels-scroll-container::-webkit-scrollbar { display: none; }
        .reel-slide { width: 100%; height: 100vh; scroll-snap-align: start; position: relative; display: flex; align-items: center; justify-content: center; background: #000; }
        .viewer-video { height: 100%; width: auto; max-width: 100%; object-fit: contain; }
        .reels-close { position: absolute; top: 20px; right: 20px; color: #fff; font-size: 35px; z-index: 10010; cursor: pointer; text-shadow: 0 2px 10px rgba(0,0,0,0.5); }
        .reel-info { position: absolute; bottom: 40px; left: 20px; right: 20px; color: white; z-index: 10007; text-align: left; }
        .reel-info h3 { font-size: 18px; margin-bottom: 10px; font-weight: 500; }
        .mute-toggle { background: rgba(0,0,0,0.5); border: none; color: white; padding: 10px; border-radius: 50%; cursor: pointer; }
    </style>

    <script>
        function switchGallery(tab) {
            document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
            event.currentTarget.classList.add('active');
            document.querySelectorAll('.gallery-content-section').forEach(section => section.classList.remove('active'));
            document.getElementById(tab + '-section').classList.add('active');
        }

        // --- REELS VIEWER LOGIC ---
        const reelsViewer = document.getElementById('reelsViewer');
        const reelsScrollContainer = document.getElementById('reelsScrollContainer');
        const viewerVideos = document.querySelectorAll('.viewer-video');

        function openReelsViewer(index) {
            reelsViewer.classList.add('active');
            document.body.style.overflow = 'hidden';
            const targetSlide = document.querySelector(`.reel-slide[data-index="${index}"]`);
            if (targetSlide) {
                targetSlide.scrollIntoView();
            }
            initReelsObserver();
        }

        function closeReelsViewer() {
            reelsViewer.classList.remove('active');
            document.body.style.overflow = 'auto';
            viewerVideos.forEach(v => {
                v.pause();
                v.currentTime = 0;
            });
        }

        function toggleMute(btn) {
            const video = btn.closest('.reel-slide').querySelector('video');
            video.muted = !video.muted;
            btn.innerHTML = video.muted ? '<i class="fas fa-volume-mute"></i>' : '<i class="fas fa-volume-up"></i>';
        }

        let reelsObserver = null;
        function initReelsObserver() {
            if (reelsObserver) return;
            const observerOptions = { root: reelsScrollContainer, threshold: 0.6 };
            reelsObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    const video = entry.target.querySelector('video');
                    if (entry.isIntersecting) {
                        video.play().catch(e => console.log("Auto-play blocked"));
                    } else {
                        video.pause();
                    }
                });
            }, observerOptions);
            document.querySelectorAll('.reel-slide').forEach(slide => reelsObserver.observe(slide));
        }

        // --- LIGHTBOX LOGIC ---
        let images = [];
        let currentIndex = 0;
        const lightbox = document.getElementById('galleryLightbox');
        const lightboxImg = document.getElementById('lightboxImg');

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
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.remove('active');
            document.body.style.overflow = 'auto';
        }

        function showImage() { lightboxImg.src = images[currentIndex]; }

        function changeImage(n) {
            currentIndex += n;
            if (currentIndex >= images.length) currentIndex = 0;
            else if (currentIndex < 0) currentIndex = images.length - 1;
            showImage();
        }

        document.addEventListener('keydown', function (e) {
            if (reelsViewer.classList.contains('active') && e.key === 'Escape') closeReelsViewer();
            if (lightbox.classList.contains('active')) {
                if (e.key === 'Escape') closeLightbox();
                if (e.key === 'ArrowLeft') changeImage(-1);
                if (e.key === 'ArrowRight') changeImage(1);
            }
        });

        lightbox.addEventListener('click', function (e) {
            if (e.target === lightbox) closeLightbox();
        });
    </script>
</main>
<?php get_footer(); ?>