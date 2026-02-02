<footer>
    <div class="container">
        <div class="footer-grid">
            <div class="footer-col">
                <div class="footer-logo">
                    <div class="logo">
                        <img src="<?php echo get_template_directory_uri(); ?>/images/logo.png" alt="Logo">
                    </div>
                </div>
                <p>Research Academy For Creative Excellence
                </p>
            </div>
            <div class="footer-col">
                <h4>Our Solutions</h4>
                <ul class="footer-links">
                    <li><a href="#">Power & Energy</a></li>
                    <li><a href="#">Petroleum & Gas</a></li>
                    <li><a href="#">Factory Engineering</a></li>
                    <li><a href="#">Quality Control</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="<?php $p = get_page_by_path('about');
                    echo $p ? get_permalink($p) : home_url('/about'); ?>">About
                            Us</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Latest News</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Get in Touch</h4>
                <p>123 Street Name, City Name,<br>United States</p>
                <p>+1 123 456 7890<br>info@example.com</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; <?php echo date('Y'); ?> Race. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Header Scroll Effect
        // Smart Scroll Header
        const header = document.getElementById('header');
        let lastScrollY = window.scrollY;

        window.addEventListener('scroll', () => {
            if (!header) return;

            const currentScrollY = window.scrollY;

            // Add/remove 'scrolled' class for background style
            if (currentScrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }

            // Hide/Show Logic
            if (currentScrollY > lastScrollY && currentScrollY > 100) {
                // Scrolling DOWN
                header.classList.add('nav-hidden');
            } else {
                // Scrolling UP
                header.classList.remove('nav-hidden');
            }

            lastScrollY = currentScrollY;
        });

        // Smooth Scrolling for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();

                const targetId = this.getAttribute('href');
                if (targetId === '#') return;

                const targetElement = document.querySelector(targetId);
                if (targetElement) {
                    targetElement.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Simple entrance animation for hero elements
        const heroContent = document.querySelector('.hero-content');
        if (heroContent) {
            heroContent.style.opacity = '0';
            heroContent.style.transform = 'translateY(20px)';
            heroContent.style.transition = 'opacity 1s ease-out, transform 1s ease-out';

            setTimeout(() => {
                heroContent.style.opacity = '1';
                heroContent.style.transform = 'translateY(0)';
            }, 100);
        }
    });
</script>

<!-- WhatsApp Floating Icon -->
<a href="https://wa.me/9645567295" target="_blank" class="whatsapp-float">
    <i class="fab fa-whatsapp"></i>
</a>

<?php wp_footer(); ?>
</body>

</html>