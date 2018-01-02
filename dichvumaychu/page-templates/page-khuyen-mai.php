<?php

/*
  Template Name: Sale Off
 */

get_header(); ?>

<div class="container domain-content">
    <div class="img-sale">
        <img src="http://bkhost.vn/wp-content/uploads/2014/11/khuyen-mai1.png" alt="Tin khuyến mại" width="1100px" height="497"/>
    </div>
    <div class="grid-view clearfix">
        <?php
            query_posts('post_type=post&post_status=publish&posts_per_page=4&cat=32');
            
            if(have_posts()):
                while (have_posts()):
                    the_post();
        ?>
        
        <div class="grid-item">
            <a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>">
                <?php the_post_thumbnail(); ?>
            </a>
        </div>
        
        <?php
                endwhile;
            endif;
        ?>
    </div>
</div>

<?php
get_footer();