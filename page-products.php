<?php
/*
 * Template Name: Products
 * Description: Custom template for the Products page in the Taste Delivery theme.
 */

// Include the header
get_header();
?>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-text">
            <h2>Our Products</h2>
            <h3>Browse our delicious products and food items!</h3>
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
                        <!-- Category Box -->
                        <div class="category-box">
                            <h2><?php echo esc_html($cat_name); ?></h2>
                            <p class="category-description"><?php echo esc_html($category_descriptions[$cat_name] ?? ''); ?></p>
                            <div class="products-grid-two-rows">
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

                                // Counter to split products into two rows
                                $count = 0;

                                if ($products->have_posts()) :
                                    echo '<div class="products-row">';
                                    while ($products->have_posts()) :
                                        $products->the_post();
                                        // Start a new row after the second product
                                        if ($count == 2) {
                                            echo '</div><div class="products-row">';
                                        }
                                        ?>
                                        <!-- Individual Product Article -->
                                        <article class="product">
                                            <div class="card">
                                                <?php if (has_post_thumbnail()) : ?>
                                                    <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'style' => 'width: 100%; height: auto;']); ?>
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <?php the_title('<h3 class="card-title">', '</h3>'); ?>
                                                    <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                                    <p class="item-description"><?php echo esc_html(get_post_meta(get_the_ID(), 'item_description', true) ?: 'Delicious item!'); ?></p>
                                                    <div class="card-actions">
                                                        <a href="<?php the_permalink(); ?>" class="read-more-link">Read More</a>
                                                        <?php if (is_user_logged_in()) : ?>
                                                            <?php
                                                            global $wpdb;
                                                            $user_id = get_current_user_id();
                                                            $post_id = get_the_ID();
                                                            $table = $wpdb->prefix . 'likes';
                                                            $like_count = $wpdb->get_var($wpdb->prepare(
                                                                "SELECT COUNT(*) FROM $table WHERE media_id = %d",
                                                                $post_id
                                                            ));
                                                            $user_liked = $wpdb->get_var($wpdb->prepare(
                                                                "SELECT COUNT(*) FROM $table WHERE media_id = %d AND user_id = %d",
                                                                $post_id,
                                                                $user_id
                                                            ));
                                                            ?>
                                                            <button class="like-button <?php echo $user_liked ? 'liked' : ''; ?>" data-post-id="<?php echo esc_attr($post_id); ?>" data-nonce="<?php echo wp_create_nonce('taste_delivery_nonce'); ?>">
                                                                <span class="like-text"><?php echo $user_liked ? 'Liked' : 'Like'; ?></span>
                                                                <span class="like-counter">(<?php echo esc_html($like_count); ?>)</span>
                                                            </button>
                                                        <?php else : ?>
                                                            <p><a href="<?php echo wp_login_url(get_permalink()); ?>">Log in to like</a></p>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </article>
                                        <?php
                                        $count++;
                                    endwhile;
                                    echo '</div>';
                                endif;

                                // Reset post data
                                wp_reset_postdata();
                                ?>
                            </div>
                            <!-- View All Section -->
                            <div class="view-all-section">
                                <p class="view-all-subtitle"><?php echo esc_html($view_all_subtitles[$cat_name] ?? ''); ?></p>
                                <a href="<?php echo esc_url(get_category_link($subcategory->term_id)); ?>" class="view-all-link">View All</a>
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