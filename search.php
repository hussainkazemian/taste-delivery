<?php
/*
 * Description: Template for displaying search results in the Taste Delivery theme.
 */

// Include the header (which contains the search form)
get_header();
?>

    <!-- Main Content Area -->
    <main>
        <!-- Search Results Section -->
        <section class="search-results">
            <h1>Search Results</h1>
            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post(); ?>
                    <!-- Individual Search Result Article -->
                    <article class="product">
                        <?php if (has_post_thumbnail()) : ?>
                            <?php the_post_thumbnail('medium', ['class' => 'card-img-top', 'style' => 'width: 100%; height: auto;']); ?>
                        <?php endif; ?>
                        <h2><?php the_title(); ?></h2>
                        <p><?php the_excerpt(); ?></p>
                        <a href="<?php the_permalink(); ?>" class="read-more-link">Read More</a>
                    </article>
                <?php endwhile; ?>
            <?php else : ?>
                <p>No results found.</p>
            <?php endif; ?>
        </section>
    </main>

<?php

// Include the footer
get_footer();
?>