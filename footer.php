<?php defined('ABSPATH') or die('No script kiddies please!'); ?>
<footer class="bg-dark text-white py-4">
    <div class="container">
        <!-- Navigation Menu -->
        <div class="footer-nav-wrapper">
            <?php
            wp_nav_menu([
                'theme_location' => 'footer-menu',
                'menu_class' => 'nav footer-nav',
                'container' => 'nav',
                'depth' => 1,
            ]);
            ?>
        </div>
        <!-- Copyright Notice -->
        <div class="footer-copyright-wrapper">
            <p class="footer-copyright">© <?php echo date('Y'); ?> This is a school project made by Hussain Kazemian.</p>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>