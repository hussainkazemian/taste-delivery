<?php
/*
 * Description: Template for displaying category archives in the Taste Delivery theme.
 */

// Access the global WP_Query object
global $wp_query;

// Include the header
get_header();
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <?php
            // Display the category title and description
            echo '<h1>' . single_cat_title('', false) . '</h1>';
            echo '<p>' . category_description() . '</p>';
            ?>
        </div>
        <!-- Display a random image from the category -->
        <img src="<?php echo get_random_post_image(get_queried_object_id()); ?>" alt="Random kuva" class="img-fluid">
    </section>

    <!-- Main Content Container -->
    <div class="container">
        <main>
            <!-- Products Section -->
            <section class="products">
                <h2><?php echo single_cat_title('', false); ?></h2>
                <div class="row">
                    <?php
                    // Query arguments to fetch products for this category
                    $args = [
                        'cat' => get_queried_object_id(),
                        'posts_per_page' => 3,
                        'post_status' => 'publish',
                    ];

                    // Create a new WP_Query instance
                    $products = new WP_Query($args);

                    // Generate the product articles
                    generate_article($products);

                    // Reset post data
                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        </main>

        <?php
        // Include the sidebar
        get_sidebar();
        ?>
    </div>

<?php
// Include the footer
get_footer();
?>