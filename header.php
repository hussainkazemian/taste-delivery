<?php
/**
 * The header for our theme
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="page-header">
    <div class="header-top">
        <div class="header-top-left">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
<!--               <h1><a href="--><?php //echo esc_url(home_url('/')); ?><!--">--><?php //bloginfo('name'); ?><!--</a></h1>-->
            <?php endif; ?>
        </div>
        <div class="header-top-right">
            <?php
            wp_nav_menu([
                'theme_location' => 'main-menu',
                'menu_class' => 'main-menu',
                'container' => 'nav',
            ]);
            ?>
            <div class="header-search">
                <?php get_search_form(); ?>
            </div>
        </div>
    </div>
    <?php if (is_front_page()) : ?>
        <div class="breadcrumbs">
            <?php
            if (function_exists('bcn_display')) {
                bcn_display();
            }
            ?>
        </div>
    <?php endif; ?>
</header>