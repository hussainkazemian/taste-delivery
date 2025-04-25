<?php get_header(); ?>
<main class="full-width">
    <section class="single">
        <?php
        if (have_posts()) :
            while (have_posts()) :
                the_post();
                ?>
                <article>
                    <?php
                    the_title('<h2>', '</h2>');
                    the_content();
                    ?>
                </article>
            <?php
            endwhile;
        endif;
        ?>
    </section>
</main>
<?php get_footer(); ?>
