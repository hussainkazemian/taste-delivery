<?php
function generate_article($query) {
    while ($query->have_posts()) : $query->the_post(); ?>
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
    <?php endwhile;
}