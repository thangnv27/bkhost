<?php get_header(); ?>

<div class="main-slider"><!-- main slider -->
    <?php echo do_shortcode('[rev_slider home-slider]'); ?>
</div><!-- end main slider -->
<div class="choice-domain clearfix"><!-- choice domain -->
    <div class="container">
        <p>Đăng ký tên miền ngay bây giờ để bảo vệ thương hiệu của bạn</p>
        <form action="<?php bloginfo('url'); ?>/kiem-tra-ten-mien" method="post">
            <input type="text" name="d_text" placeholder="Tìm kiếm tên miền..."/>
            <input type="hidden" name="d_p" value="h"/>
            <button type="submit">Tìm</button>
        </form>
    </div>
</div><!-- end choice domain -->
<div class="slide-content">
    <?php echo do_shortcode('[rev_slider services-slide]'); ?>
</div>
<div class="main-content container"><!-- content -->
    <div class="grid-items clearfix"><!-- grid items -->
        <?php
        
        wp_reset_query();
        
        $list_prod_index = get_posts(array(
            'post_type' => 'sp-trang-chu',
            'posts_per_page' => 3,
            'order_by' => 'date',
            'order' => 'asc'
        ));
        
        ?>
        <ul>
            <div class="row">
                
            <?php
                if (!empty($list_prod_index)):
                    $count_prod = 1;
                    foreach ($list_prod_index as $prod_index):
                        $href = get_post_meta($prod_index->ID, 'duong_dan', true);
                        if (has_post_thumbnail($prod_index->ID)) {
                            $src_img = wp_get_attachment_url(get_post_thumbnail_id($prod_index->ID));
                        } else {
                            $src_img = get_template_directory_uri() . '/assets/img/blank.png';
                        }

                        $img_hover = get_post_meta($prod_index->ID, 'anh_hover', true);
                        $img_hover = $img_hover ? 'data-hover="' . wp_get_attachment_url($img_hover) . '"' : '';
            ?>
                
                <li>
                    <div class="item<?php if (($count_prod % 3) === 1): ?> lt<?php elseif (($count_prod % 3) === 2): ?> md<?php else: ?> rt<?php endif; ?>">
                        <a href="#" class="thumb-sv"><img src="<?php echo $src_img; ?>" <?php echo $img_hover; ?> width="129" height="129"/></a>
                        <h3><a href="<?php echo $href; ?>"><?php echo $prod_index->post_title; ?></a></h3>
                        <p><?php echo get_post_meta($prod_index->ID, 'gioi_thieu_ngan', true); ?></p>
                        <a href="<?php echo $href; ?>" class="item-order">Bảng giá</a>
                    </div>
                </li>
                
            <?php
                        $count_prod++;
                    endforeach;
                endif;
            ?>
                
            </div>
        </ul>
    </div><!-- end gird items -->
</div><!-- content -->

<?php get_footer(); ?>
