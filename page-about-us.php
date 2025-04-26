<?php
/*
 * Template Name: About Us
 * Description: Custom template for the About Us page in the Taste Delivery theme.
 */

// Include the header (which contains the search form)
get_header();
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
        </div>
        <?php if (has_custom_header()) : ?>
            <?php the_custom_header_markup(); ?>
        <?php else : ?>
            <!-- Fallback hero image if no custom header is set -->
            <img src="<?php echo esc_url(get_template_directory_uri() . '/assets/images/hero.jpg'); ?>" alt="Hero" class="img-fluid">
        <?php endif; ?>
    </section>

    <!-- Main Content Container -->
    <div class="container">
        <main>
            <!-- About Us Section -->
            <section class="about">
                <h2>Our Story</h2>
                <p>TastyDelivery was founded with a passion for delivering high-quality, delicious and economic meals and products from warm to clod ones to our customers.  We partner with local restaurants to bring you a variety of products right to your doorstep.</p>
                <h2>Contact Us</h2>
                <!-- Contact Form -->
                <form class="contact-form" id="contact-form" method="post">
                    <!-- Hidden nonce field for security -->
                    <input type="hidden" name="nonce" value="<?php echo wp_create_nonce('contact_form_nonce'); ?>">
                    <div class="form-group">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <label for="message" class="form-label">Message</label>
                        <textarea class="form-control" id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Send Message</button>
                    <!-- Success/Error message area -->
                    <div class="form-message" style="display: none;"></div>
                </form>
            </section>
        </main>
    </div>

<?php
// Include the footer
get_footer();
?>