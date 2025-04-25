<?php
/*
 * Description: Helper function to fetch a random post image for a given category.
 */

/**
 * Get a random post image URL from a specified category.
 *
 * @param int $category_id The ID of the category to fetch the image from.
 * @return string The URL of the random image, or an empty string if none found.
 */
function get_random_post_image($category_id): string {
    // Query arguments to fetch a random post from the category
    $args = [
        'post_type' => 'post',
        'cat' => $category_id,
        'posts_per_page' => 1,
        'orderby' => 'rand'
    ];

    // Create a new WP_Query instance
    $random_post = new WP_Query($args);

    // Check if there are posts
    if ($random_post->have_posts()):
        while ($random_post->have_posts()):
            $random_post->the_post();
            // Get the URL of the post's featured image
            $image_url = wp_get_attachment_url(get_post_thumbnail_id());
            if ($image_url):
                return $image_url;
            endif;
        endwhile;
    endif;

    // Reset post data
    wp_reset_postdata();

    // Return empty string if no image is found
    return '';
}