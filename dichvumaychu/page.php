<?php
get_header();

if (have_posts()):
    while (have_posts()):
        the_post();
        ?>

        <div class="container">

            <div class="list-news content-side">
                <div class="entry">
                    <h1><?php the_title(); ?></h1>
                    <?php the_content(); ?>
                </div>
            </div>
            <?php get_sidebar(); ?>
        </div>

        <?php
    endwhile;
endif;

get_footer();

?>