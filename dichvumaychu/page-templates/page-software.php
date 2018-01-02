<?php

/*
  Template Name: Software
 */

get_header(); ?>

<div id="post-content">
    <div class="panel-bg">
        <div class="panel-content">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <h1 style="margin-top: 0; text-transform: uppercase; text-align: center; color: rgb(234, 108, 0); font-size: 24px;"><?php the_title(); ?></h1>
                    <div style="margin-bottom: 20px;text-align: center">
                        <?php the_content(); ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
            <div class="grid-items clearfix">
                <ul>
                    <?php
                        global $post;
                        $list_sofware = get_posts(array(
                            'post_type' => 'phan-mem',
                            'order_by' => 'date',
                            'order' => 'asc',
                            'posts_per_page' => -1,
                            'post_status' => 'publish'
                        ));
                        
                        foreach ($list_sofware as $post ):
                            setup_postdata($post);
                    ?>
                    
                    <li class="software">
                        <h3 id="icon-<?php echo get_the_ID(); ?>"><?php the_title(); ?></h3>
                        <?php the_excerpt(); ?>
                        <p class="view_more"><a href="<?php the_permalink(); ?>">Tìm hiểu thêm</a></p>
                    </li>
                    
                    <?php
                        endforeach;
                    ?>
                </ul>
            </div>
        </div>
        
        <?php get_template_part('template', 'support'); ?>
    </div>
</div>

<?php get_footer(); ?>