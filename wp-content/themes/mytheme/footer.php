<footer class="footer">
    <div class="container">
        <div class="footer__shell">
            <div class="footer__top">
                <div class="footer__brand">
                    <span class="eyebrow">Creative Excellence With Purpose</span>
                    <h3>Building confidence, community, and meaningful transformation.</h3>
                    <p>RACE brings together training, youth leadership, counselling, and collaborative community initiatives to create durable human impact.</p>
                </div>

                <div>
                    <h4>Explore</h4>
                    <div class="footer__links">
                        <a href="<?php echo esc_url(race_get_page_url('about')); ?>">Chairman&rsquo;s Desk</a>
                        <a href="<?php echo esc_url(race_get_page_url('team-race')); ?>">Team RACE</a>
                        <a href="<?php echo esc_url(race_get_page_url('gallery')); ?>">Gallery</a>
                        <a href="<?php echo esc_url(race_get_page_url('meet-our-changemakers')); ?>">Changemakers</a>
                    </div>
                </div>

                <div>
                    <h4>Action Plan</h4>
                    <div class="footer__links">
                        <a href="<?php echo esc_url(race_get_page_url('ongoing-events')); ?>">Ongoing &amp; Past Events</a>
                        <a href="<?php echo esc_url(race_get_page_url('courses-training')); ?>">Courses &amp; Training</a>
                        <a href="<?php echo esc_url(race_get_page_url('projects')); ?>">Projects</a>
                        <a href="<?php echo esc_url(race_get_page_url('features-news')); ?>">Features in News</a>
                    </div>
                </div>

                <div>
                    <h4>Contact</h4>
                    <div class="footer__links">
                        <a href="https://maps.google.com/?q=Bhavana+Nagar+Town+Kadappakada+Kollam+691008" target="_blank" rel="noreferrer">261 Bhavana Nagar Town, Kadappakada, Kollam 691008</a>
                        <a href="tel:+919645567295">+91 96455 67295</a>
                        <a href="mailto:raceindianow@gmail.com">raceindianow@gmail.com</a>
                        <a href="<?php echo esc_url(race_get_page_url('your-voice-matters')); ?>">Send a message</a>
                    </div>
                </div>
            </div>

            <div class="footer__bottom">
                <p>&copy; <?php echo esc_html(date('Y')); ?> Research Academy for Creative Excellence. All rights reserved.</p>
                <a href="<?php echo esc_url(home_url('/')); ?>">Back to top</a>
            </div>
        </div>
    </div>
</footer>

<a href="https://wa.me/919645567295" target="_blank" rel="noreferrer" class="whatsapp-float" aria-label="Chat on WhatsApp">
    <i class="fab fa-whatsapp"></i>
</a>

<div class="lightbox" id="race-lightbox" aria-hidden="true">
    <div class="lightbox__frame">
        <button class="lightbox__close" type="button" aria-label="Close image viewer"><i class="fas fa-times"></i></button>
        <button class="lightbox__prev" type="button" aria-label="Previous image"><i class="fas fa-chevron-left"></i></button>
        <img class="lightbox__image" src="" alt="">
        <button class="lightbox__next" type="button" aria-label="Next image"><i class="fas fa-chevron-right"></i></button>
    </div>
</div>

<div class="video-modal" id="race-video-modal" aria-hidden="true">
    <div class="video-modal__frame">
        <button class="video-modal__close" type="button" aria-label="Close video viewer"><i class="fas fa-times"></i></button>
        <video controls playsinline></video>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const header = document.getElementById('site-header');
    const menuToggle = document.getElementById('mobile-menu-toggle');
    const navLinks = document.getElementById('site-nav-links');
    const dropdowns = document.querySelectorAll('.has-dropdown');
    let lastScrollY = window.scrollY;

    const updateHeader = () => {
        if (!header) return;
        const current = window.scrollY;
        header.classList.toggle('scrolled', current > 20);
        if (current < lastScrollY && current > 120) {
            header.classList.add('nav-hidden');
        } else {
            header.classList.remove('nav-hidden');
        }
        lastScrollY = current;
    };

    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();

    if (menuToggle && navLinks) {
        menuToggle.addEventListener('click', () => {
            const isOpen = navLinks.classList.toggle('active');
            menuToggle.classList.toggle('active', isOpen);
            menuToggle.setAttribute('aria-expanded', String(isOpen));
            document.body.classList.toggle('menu-open', isOpen);
        });

        navLinks.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                navLinks.classList.remove('active');
                menuToggle.classList.remove('active');
                menuToggle.setAttribute('aria-expanded', 'false');
                document.body.classList.remove('menu-open');
            });
        });
    }

    dropdowns.forEach((dropdown) => {
        const trigger = dropdown.querySelector('button');
        if (!trigger) return;
        trigger.addEventListener('click', () => {
            if (window.innerWidth > 920) return;
            const isOpen = dropdown.classList.toggle('open');
            trigger.setAttribute('aria-expanded', String(isOpen));
        });
    });

    const observer = new IntersectionObserver((entries, activeObserver) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                activeObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.14 });

    document.querySelectorAll('.animate-on-scroll').forEach((element) => observer.observe(element));

    const counters = document.querySelectorAll('[data-target]');
    const counterObserver = new IntersectionObserver((entries, activeObserver) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const counter = entry.target;
            const target = Number(counter.dataset.target || 0);
            const suffix = counter.dataset.suffix || '';
            const start = performance.now();
            const duration = 1400;

            const tick = (now) => {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                counter.textContent = Math.floor(target * eased) + suffix;
                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    counter.textContent = target + suffix;
                }
            };

            requestAnimationFrame(tick);
            activeObserver.unobserve(counter);
        });
    }, { threshold: 0.45 });
    counters.forEach((counter) => counterObserver.observe(counter));

    const lightbox = document.getElementById('race-lightbox');
    const lightboxImage = lightbox ? lightbox.querySelector('.lightbox__image') : null;
    const lightboxLinks = Array.from(document.querySelectorAll('[data-lightbox-group]'));
    let currentIndex = 0;
    let currentGroup = '';

    const getGroupLinks = () => lightboxLinks.filter((item) => item.dataset.lightboxGroup === currentGroup);
    const renderLightbox = (index) => {
        const groupLinks = getGroupLinks();
        if (!groupLinks.length || !lightboxImage) return;
        currentIndex = (index + groupLinks.length) % groupLinks.length;
        const currentItem = groupLinks[currentIndex];
        lightboxImage.src = currentItem.href;
        lightboxImage.alt = currentItem.querySelector('img')?.alt || 'Gallery image';
    };

    if (lightbox && lightboxImage) {
        lightboxLinks.forEach((link) => {
            link.addEventListener('click', (event) => {
                event.preventDefault();
                currentGroup = link.dataset.lightboxGroup;
                currentIndex = getGroupLinks().indexOf(link);
                renderLightbox(currentIndex);
                lightbox.classList.add('is-active');
                document.body.classList.add('menu-open');
            });
        });

        lightbox.querySelector('.lightbox__close').addEventListener('click', () => {
            lightbox.classList.remove('is-active');
            document.body.classList.remove('menu-open');
        });
        lightbox.querySelector('.lightbox__prev').addEventListener('click', () => renderLightbox(currentIndex - 1));
        lightbox.querySelector('.lightbox__next').addEventListener('click', () => renderLightbox(currentIndex + 1));
        lightbox.addEventListener('click', (event) => {
            if (event.target === lightbox) {
                lightbox.classList.remove('is-active');
                document.body.classList.remove('menu-open');
            }
        });
    }

    const videoModal = document.getElementById('race-video-modal');
    const modalVideo = videoModal ? videoModal.querySelector('video') : null;
    if (videoModal && modalVideo) {
        const closeVideo = () => {
            modalVideo.pause();
            modalVideo.removeAttribute('src');
            modalVideo.load();
            videoModal.classList.remove('is-active');
            document.body.classList.remove('menu-open');
        };

        document.querySelectorAll('[data-video-src]').forEach((card) => {
            card.addEventListener('click', () => {
                modalVideo.src = card.dataset.videoSrc;
                modalVideo.play().catch(() => {});
                videoModal.classList.add('is-active');
                document.body.classList.add('menu-open');
            });
        });

        videoModal.querySelector('.video-modal__close').addEventListener('click', closeVideo);
        videoModal.addEventListener('click', (event) => {
            if (event.target === videoModal) closeVideo();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                lightbox?.classList.remove('is-active');
                if (videoModal.classList.contains('is-active')) closeVideo();
                document.body.classList.remove('menu-open');
            }
            if (lightbox?.classList.contains('is-active')) {
                if (event.key === 'ArrowLeft') renderLightbox(currentIndex - 1);
                if (event.key === 'ArrowRight') renderLightbox(currentIndex + 1);
            }
        });
    }
});
</script>

<?php wp_footer(); ?>
</body>
</html>
