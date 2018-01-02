<?php
/*
  Template Name: Hướng dẫn thanh toán
 */
get_header();

if (have_posts()):
    while (have_posts()):
        the_post();
        ?>

        <div style="background: #fff;padding: 10px 30px">
            <div class="entry">
                <h1><?php the_title(); ?></h1>
                <?php the_content(); ?>
            </div>
        </div>

        <?php
    endwhile;
endif;

get_footer();

?>