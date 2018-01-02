<?php get_header(); ?>

<div class="container">
    <div class="content-side">
    <div class="list-news">

        <?php
            if (have_posts()):
                while (have_posts()):
                    the_post();
        ?>

        <div <?php post_class() ?> id="post-<?php the_ID(); ?>">
            <h1 class="title_post"><?php the_title(); ?></h1>
            <div class="entry">

                <?php the_content(); ?>

            </div>
        </div>

        <?php 
                endwhile;
                wp_reset_query();
        ?>
        
        </div>
        
        <?php   
                $this_cat = get_the_category(get_the_ID());
                if (!empty($this_cat)) {
                    $cat_in = array();
                    foreach ($this_cat as $current_cat) {
                        $cat_in[] = $current_cat->term_id;
                    }
                    $list_recent = query_posts(array(
                        'post-type' => 'post',
                        'posts_per_page' => 5,
                        'orderby' => 'rand',
                        'category__and' => $cat_in,
                        'post__not_in' => array(get_the_ID())
                    ));
                    if (!empty($list_recent)) {
        ?>
        
        <div class="recent-post">
            <h2>Bài viết liên quan</h2>
            
            <ul class="list_recent_post">
                <?php
                    if (have_posts()):
                        while (have_posts()):
                            the_post();
                ?>
                
                <li>
                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                </li>
                
                <?php endwhile; endif; ?>
            </ul>
        </div>
        
        <?php }} endif; ?>
        
    </div>
    
    <?php get_sidebar(); ?>

</div>

<?php get_footer(); ?>