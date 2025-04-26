<?php
get_header();
?>
    <section class="hero" style="background-image: url('<?php echo get_random_post_image(get_queried_object_id()); ?>');">
        <div class="hero-text">
            <h1><?php echo single_cat_title('', false); ?></h1>
            <p><?php echo category_description(); ?></p>
        </div>
    </section>
    <div class="container">
        <main>
            <section class="products">
                <h2><?php echo single_cat_title('', false); ?></h2>
                <div class="products-grid">
                    <?php
                    // Get the current category ID
                    $category_id = get_queried_object_id();

                    // Custom query to fetch all products in this category
                    $args = [
                        'cat' => $category_id,
                        'posts_per_page' => -1, // Fetch all posts
                        'post_status' => 'publish',
                        'post_type' => 'post',
                    ];

                    $products = new WP_Query($args);

                    // Track displayed post IDs to prevent duplicates
                    $displayed_posts = [];

                    if ($products->have_posts()) :
                        // Temporarily store posts to filter duplicates
                        $unique_posts = [];
                        while ($products->have_posts()) : $products->the_post();
                            $post_id = get_the_ID();
                            if (!in_array($post_id, $displayed_posts)) :
                                $unique_posts[] = $post_id;
                                $displayed_posts[] = $post_id;
                            endif;
                        endwhile;

                        // Reset the query to the beginning
                        $products->rewind_posts();

                        // Create a new query with unique posts
                        $args['post__in'] = $unique_posts ?: [0]; // Fallback to avoid empty query
                        $args['orderby'] = 'post__in'; // Preserve the order of unique posts
                        $unique_products = new WP_Query($args);

                        // Pass the unique query to generate_article
                        generate_article($unique_products);
                    else :
                        echo '<p>No products found in this category.</p>';
                    endif;

                    wp_reset_postdata();
                    ?>
                </div>
            </section>
        </main>
    </div>
<?php get_footer(); ?>