<?php
/*
 * Description: Helper function to generate product articles in the Taste Delivery theme.
 */

/**
 * Generate HTML for product articles based on a WP_Query object.
 *
 * @param WP_Query $products The WP_Query object containing the products to display.
 * @return void
 */
function generate_article($products): void {
    // Check if there are posts to display
    if ($products->have_posts()) :
        while ($products->have_posts()) :
            $products->the_post();
            ?>
            <!-- Product Article -->
            <article class="product">
                <div class="card">
                    <?php if (has_post_thumbnail()) : ?>
                        <!-- Display the post thumbnail -->
                        <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'style' => 'width: 100%; height: auto;']); ?>
                    <?php endif; ?>
                    <div class="card-body">
                        <!-- Display the post title -->
                        <?php the_title('<h3 class="card-title">', '</h3>'); ?>
                        <!-- Display a trimmed excerpt -->
                        <p class="card-text"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                        <!-- Display the item description custom field -->
                        <p class="item-description"><?php echo esc_html(get_post_meta(get_the_ID(), 'item_description', true) ?: 'Delicious item!'); ?></p>
                        <div class="card-actions">
                            <!-- Read More link -->
                            <a href="<?php the_permalink(); ?>" class="read-more-link">Read More</a>
                            <?php if (is_user_logged_in()) : ?>
                                <?php
                                // Access the global database object
                                global $wpdb;
                                $user_id = get_current_user_id();
                                $post_id = get_the_ID();
                                $table = $wpdb->prefix . 'likes';

                                // Get the total number of likes for this post
                                $like_count = $wpdb->get_var($wpdb->prepare(
                                    "SELECT COUNT(*) FROM $table WHERE media_id = %d",
                                    $post_id
                                ));

                                // Check if the current user has liked this post
                                $user_liked = $wpdb->get_var($wpdb->prepare(
                                    "SELECT COUNT(*) FROM $table WHERE media_id = %d AND user_id = %d",
                                    $post_id,
                                    $user_id
                                ));
                                ?>
                                <!-- Like Button -->
                                <button class="like-button <?php echo $user_liked ? 'liked' : ''; ?>" data-post-id="<?php echo esc_attr($post_id); ?>" data-nonce="<?php echo wp_create_nonce('taste_delivery_nonce'); ?>">
                                    <span class="like-text"><?php echo $user_liked ? 'Liked' : 'Like'; ?></span>
                                    <span class="like-counter">(<?php echo esc_html($like_count); ?>)</span>
                                </button>
                            <?php else : ?>
                                <!-- Prompt to log in to like -->
                                <p><a href="<?php echo wp_login_url(get_permalink()); ?>">Log in to like</a></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </article>
        <?php
        endwhile;
    endif;
}