<?php

get_header();
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h1>Our Products</h1>
            <p>Browse our delicious food items!</p>
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
            <!-- Products Section -->
            <section class="products">
                <div class="category-row">
                    <?php
                    // Define the Products category ID
                    $products_cat_id = 1; // Confirmed Products category ID

                    // Query arguments to fetch subcategories
                    $args = [
                        'child_of' => $products_cat_id,
                        'parent' => $products_cat_id,
                        'hide_empty' => false,
                        'taxonomy' => 'category',
                    ];

                    // Get the subcategories
                    $subcategories = get_categories($args);

                    // Define category descriptions
                    $category_descriptions = [
                        'Cold products' => 'Refreshing Cold Products',
                        'Extra' => 'Tasty Extras to Complement Your Meal',
                        'Hot products' => 'Warm and Delicious Hot Products',
                    ];

                    // Define View All subtitles
                    $view_all_subtitles = [
                        'Cold products' => 'Explore more Cold products',
                        'Extra' => 'See all Extras',
                        'Hot products' => 'Discover more Hot products',
                    ];

                    // Loop through each subcategory
                    foreach ($subcategories as $subcategory) :
                        $cat_name = $subcategory->name;
                        ?>
                        <!-- Category Column -->
                        <div class="category-column">
                            <h2><?php echo esc_html($cat_name); ?></h2>
                            <p class="category-description"><?php echo esc_html($category_descriptions[$cat_name] ?? ''); ?></p>
                            <div class="row">
                                <?php
                                // Query arguments to fetch products for this subcategory
                                $args = [
                                    'cat' => $subcategory->term_id,
                                    'posts_per_page' => 3,
                                    'post_status' => 'publish',
                                    'post_type' => 'post',
                                    'orderby' => 'date',
                                    'order' => 'DESC',
                                ];

                                // Create a new WP_Query instance
                                $products = new WP_Query($args);

                                // Generate the product articles
                                generate_article($products);

                                // Reset post data
                                wp_reset_postdata();
                                ?>
                            </div>
                            <!-- View All Section -->
                            <div class="view-all-section">
                                <p class="view-all-subtitle"><?php echo esc_html($view_all_subtitles[$cat_name] ?? ''); ?></p>
                                <a href="<?php echo esc_url(get_category_link($subcategory->term_id)); ?>" class="btn btn-primary view-all-btn">View All</a>
                            </div>
                        </div>
                    <?php
                    endforeach;
                    ?>
                </div>
            </section>
        </main>
    </div>

<?php
// Include the footer
get_footer();
?>