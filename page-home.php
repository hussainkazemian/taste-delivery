<?php

// Include the header
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
            <!-- Featured Products Section -->
            <section class="products">
                <p>Welcome to Tasty Food Delivery Company</p>

                <h2>Sample of Products</h2>

                <div class="products-single-row">
                    <?php
                    // Query arguments to fetch featured products
                    $args = [
                        'tag' => 'featured',           // Fetch posts with the 'featured' tag
                        'posts_per_page' => 4,         // Limit to 4 products for one row
                        'post_status' => 'publish',    // Only published posts
                        'orderby' => 'rand',           // Randomize the order
                    ];

                    // Create a new WP_Query instance
                    $products = new WP_Query($args);

                    // Generate the product articles using the shared function
                    generate_article($products);

                    // Reset post data to prevent conflicts
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        </main>
    </div>

<?php
// Include the footer
get_footer();
?>