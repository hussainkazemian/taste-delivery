<?php


// Prevent direct access
defined('ABSPATH') or die('No script kiddies please!');

// Include helper files
require_once __DIR__ . '/inc/article-function.php';
require_once __DIR__ . '/inc/random-image.php';
require_once __DIR__ . '/inc/ajax-handlers.php';

/**
 * Set up theme support and features.
 */
function taste_delivery_setup(): void {
    // Add support for document title tag
    add_theme_support('title-tag');

    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    // Add support for custom header
    add_theme_support('custom-header', [
        'width' => 1200,
        'height' => 400,
        'default-image' => get_template_directory_uri() . '/assets/images/hero.jpg',
    ]);

    // Add support for custom logo
    add_theme_support('custom-logo', [
        'height' => 300,
        'width' => 300,
        'flex-height' => true,
    ]);

    // Define custom image size for product thumbnails
    add_image_size('medium', 300, 200, true);

    // Add support for HTML5 markup
    add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);

    // Register navigation menus
    register_nav_menus([
        'main-menu' => __('Main Menu', 'taste-delivery'),
        'footer-menu' => __('Footer Menu', 'taste-delivery'),
    ]);
}
add_action('after_setup_theme', 'taste_delivery_setup');


/**
 * Enqueue styles and scripts.
 */
function taste_delivery_scripts(): void {
    // Enqueue Bootstrap CSS
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', [], '5.3.0');

    // Enqueue theme styles
    wp_enqueue_style('taste-delivery-style', get_stylesheet_uri(), ['bootstrap'], '1.0');

    // Enqueue Bootstrap JS (depends on jQuery)
    wp_enqueue_script('bootstrap', get_template_directory_uri() . '/assets/js/bootstrap.min.js', ['jquery'], '5.3.0', true);

    // Enqueue custom JS (depends on jQuery)
    wp_enqueue_script('taste-delivery-custom', get_template_directory_uri() . '/assets/js/custom.js', ['jquery'], '1.0', true);

    // Localize script with AJAX URL
    wp_localize_script('taste-delivery-custom', 'tasteDelivery', [
        'ajaxurl' => admin_url('admin-ajax.php'),
    ]);
}
add_action('wp_enqueue_scripts', 'taste_delivery_scripts');

/**
 * Filter search queries to only include the Products category.
 *
 * @param WP_Query $query The current query object.
 * @return WP_Query The modified query object.
 */
function taste_delivery_search_filter($query) {
    if ($query->is_search && !is_admin()) {
        $query->set('category_name', 'products');
    }
    return $query;
}
add_filter('pre_get_posts', 'taste_delivery_search_filter');

/**
 * Customize breadcrumb titles.
 *
 * @param string $title The breadcrumb title.
 * @param array $type The breadcrumb type.
 * @return string The modified breadcrumb title.
 */
function taste_delivery_breadcrumb_title($title, $type) {
    if (in_array('home', $type)) {
        $title = __('', '');
    }
    return $title;
}
add_filter('bcn_breadcrumb_title', 'taste_delivery_breadcrumb_title', 10, 2);
