<?php
/*
 * Description: AJAX handlers for the Taste Delivery theme.
 */

// Prevent direct access
defined('ABSPATH') or die('No script kiddies please!');

/**
 * Handle contact form submission via AJAX.
 */
function taste_delivery_contact_form() {
    // Verify the nonce for security
    check_ajax_referer('contact_form_nonce', 'nonce');

    // Sanitize form inputs
    $name = sanitize_text_field($_POST['name']);
    $email = sanitize_email($_POST['email']);
    $message = sanitize_textarea_field($_POST['message']);

    // Prepare email details
    $to = get_option('admin_email');
    $subject = 'New Contact Form Submission';
    $body = "Name: $name\nEmail: $email\nMessage: $message";

    // Send the email
    wp_mail($to, $subject, $body);

    // Send success response
    wp_send_json_success('Message sent successfully!');
    wp_die();
}
// Register the AJAX action for both logged-in and non-logged-in users
add_action('wp_ajax_contact_form_submit', 'taste_delivery_contact_form');
add_action('wp_ajax_nopriv_contact_form_submit', 'taste_delivery_contact_form');

/**
 * Handle user login via AJAX.
 */
function taste_delivery_login() {
    // Verify the nonce for security
    check_ajax_referer('taste_delivery_login_nonce', 'nonce');

    // Sanitize login inputs
    $username = sanitize_text_field($_POST['username']);
    $password = $_POST['password'];

    // Access the global database object
    global $wpdb;

    // Query the user by username
    $user = $wpdb->get_row($wpdb->prepare(
        "SELECT * FROM {$wpdb->prefix}users WHERE user_login = %s",
        $username
    ));

    // Verify user credentials and log in
    if ($user && wp_check_password($password, $user->user_pass, $user->ID)) {
        wp_set_auth_cookie($user->ID);
        wp_send_json_success('Login successful!');
    } else {
        wp_send_json_error('Invalid credentials.');
    }
    wp_die();
}
// Register the AJAX action for both logged-in and non-logged-in users
add_action('wp_ajax_taste_delivery_login', 'taste_delivery_login');
add_action('wp_ajax_nopriv_taste_delivery_login', 'taste_delivery_login');

/**
 * Handle liking a post via AJAX.
 */
function taste_delivery_like_post() {
    // Verify the nonce for security
    check_ajax_referer('taste_delivery_nonce', 'nonce');

    $post_id = intval($_POST['post_id']);
    $user_id = get_current_user_id();

    // Check if user is logged in
    if (!$user_id) {
        error_log('Like failed: User not logged in');
        wp_send_json_error('User not logged in.');
        wp_die();
    }

    // Validate post ID
    if (!$post_id) {
        error_log('Like failed: Invalid post ID');
        wp_send_json_error('Invalid post ID.');
        wp_die();
    }

    // Access the global database object
    global $wpdb;
    $table = $wpdb->prefix . 'likes';

    // Check if the user has already liked this post
    $exists = $wpdb->get_var($wpdb->prepare(
        "SELECT COUNT(*) FROM $table WHERE media_id = %d AND user_id = %d",
        $post_id,
        $user_id
    ));

    if ($exists) {
        error_log('Like failed: Post already liked by user ' . $user_id);
        wp_send_json_error('You already liked this post.');
    } else {
        // Insert the like into the database
        $result = $wpdb->insert($table, [
            'media_id' => $post_id,
            'user_id' => $user_id,
            'created_at' => current_time('mysql'),
        ]);

        if ($result === false) {
            error_log('Like failed: Database insert error - ' . $wpdb->last_error);
            wp_send_json_error('Failed to like post.');
        } else {
            wp_send_json_success('Post liked!');
        }
    }
    wp_die();
}
// Register the AJAX action for logged-in users
add_action('wp_ajax_taste_delivery_like_post', 'taste_delivery_like_post');

/**
 * Handle filtering products via AJAX.
 */
function taste_delivery_filter_products() {
    // Verify the nonce for security
    check_ajax_referer('taste_delivery_nonce', 'nonce');

    $cat_id = intval($_POST['category_id']);

    // Query arguments to fetch products
    $args = [
        'posts_per_page' => 3,
    ];
    if ($cat_id) {
        $args['cat'] = $cat_id;
    }

    // Create a new WP_Query instance
    $products = new WP_Query($args);

    // Capture the output
    ob_start();
    generate_article($products);
    $output = ob_get_clean();

    // Send the output as a success response
    wp_send_json_success($output);
    wp_die();
}
// Register the AJAX action for both logged-in and non-logged-in users
add_action('wp_ajax_taste_delivery_filter_products', 'taste_delivery_filter_products');
add_action('wp_ajax_nopriv_taste_delivery_filter_products', 'taste_delivery_filter_products');