<?php
get_header();

$list_posts = get_posts(array(
    'post_type' => 'post',
    'category' => 3,
    'order_by' => 'date',
    'order' => 'desc'
));

?>

<div class="container">
    <div class="list-news content-side">

    <?php if (have_posts()): ?>
        <ul class="clearfix">

        <?php while (have_posts()): the_post(); ?>

            <li class="col-xs-12">
                <div class="item-news">
                    
                    <?php if (has_post_thumbnail()): ?>
                    
                        <a href="<?php the_permalink(); ?>" class="thumb-item">
                            <?php the_post_thumbnail('thumb-cat'); ?>
                        </a>
                    
                    <?php endif; ?>
                    
                    <div class="item-content">
                        <h1 class="title_news" style="line-height: 20px;margin-top:0">
                            <a href="<?php the_permalink(); ?>" style="font-size: 18px"><?php the_title(); ?></a>
                        </h1>
                        
                        <?php echo dp_excerpt(250); ?>
                        
                    </div>
                </div>
            </li>

        <?php endwhile; ?>

        </ul>
        <div class="page-nav">
            <?php wp_pagenavi(); ?>
        </div>
    </div>

    <?php get_sidebar(); ?>

</div>

    <?php else: ?>

    <p>Không có bài viết!</p>
</div>

    <?php
        endif;
        wp_reset_query();
        get_footer();
    ?>