<?php

get_header();
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>Welcome to Taste Delivery</h1>
            <p>Discover delicious meals delivered to your door!</p>
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
                <h2>Featured Products</h2>
                <div class="products-single-row">
                    <?php
                    // Query arguments to fetch recent products
                    $args = [
                        'posts_per_page' => 4,         // Limit to 4 products for one row
                        'post_type' => 'post',         // Fetch posts
                        'post_status' => 'publish',    // Only published posts
                        'orderby' => 'date',           // Order by date
                        'order' => 'DESC',             // Newest first
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