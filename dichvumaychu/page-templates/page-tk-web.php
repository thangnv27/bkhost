<?php
/*
  Template Name: Web Design Price
 */
get_header();

$list_baogia = get_posts(array(
    'post_type' => 'tk-web',
    'order_by' => 'date',
    'order' => 'desc',
    'posts_per_page' => -1,
    'post_status' => 'publish'
));

?>

<div id="post-content">
    <div class="panel-bg">
        <div class="panel-content">
            
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <h1 style="padding-top: 10px; text-transform: uppercase; text-align: center; color: rgb(234, 108, 0); font-size: 24px;"><?php the_title(); ?></h1>
                    <div style="margin-bottom: 20px;text-align: center">
                        <?php the_content(); ?>
                    </div>
                    <?php
                endwhile;
            endif;
            ?>
            
            <ul class="block-option clearfix">

            <?php
            if (!empty($list_baogia)):
                $count_break = 1;
                $range_color = array('green', 'orange', 'pink', '');

                foreach ($list_baogia as $gia):
                    $tinh_nang = get_post_meta($gia->ID, 'tinh_nang_uu_viet', 'true') == 'yes_c' ? 'có' : 'không';
                    $marketing = get_post_meta($gia->ID, 'marketing_hieu_qua', 'true') == 'yes' ? 'có' : 'không';
                    $repeater_value = get_post_meta($gia->ID, 'them_lua_chon_thong_tin', true);

                    if (!is_array($repeater_value) and $repeater_value !== 0) {
                        $attach_value = '';

                        for ($i = 0; $i < $repeater_value; $i++) {
                            $meta_key = 'them_lua_chon_thong_tin_' . $i . '_loai_bo_xung';
                            $sub_field_value = get_post_meta($gia->ID, $meta_key, true);
                            $attach_value .= $sub_field_value . '-';
                        }

                        $attach_value = rtrim($attach_value, '-');
                    } else {
                        $attach_value = 'no_attach';
                    }
                    if ($count_break == 1):
            ?>
                
                <div class="ops-item clearfix">

            <?php endif; ?>

                    <li>
                        <div class="option-item <?php echo $range_color[array_rand($range_color)]; ?>">
                            <div class="top-option">
                                <span><?php echo $gia->post_title; ?></span>
                            </div>
                            <div class="main-option">
                                <?php
                                $anh_demo = get_field('image', $gia->ID);
                                $responsive = get_post_meta($gia->ID, 'responsive', 'true');
                                $ngon_ngu = get_post_meta($gia->ID, 'da_ngon_ngu', 'true');
                                $toi_uu_seo = get_post_meta($gia->ID, 'toi_uu_seo', 'true');
                                if( !empty($anh_demo) ): 
                                ?>
                                <p style="text-align: center">
                                    <a href="<?php echo get_post_meta($gia->ID, 'link_demo', 'true'); ?>" title="<?php echo $gia->post_title; ?>" target="_blank">
                                        <img src="<?php echo $anh_demo['url']; ?>" alt="<?php echo $anh_demo['alt']; ?>" style="max-width: 100%" />
                                    </a>
                                </p>
                                <?php endif; ?>
                                <p style="font-weight: bold"><?php echo get_post_meta($gia->ID, 'gia_tien', 'true'); ?> <small> VNĐ</small></p>
                                <p>Responsive: <?php echo ($responsive == "yes") ? "Có" : "Không"; ?></p>
                                <p>Hỗ trợ đa ngôn ngữ: <?php echo ($ngon_ngu == "yes") ? "Có" : "Không"; ?></p>
                                <p>Tối ưu SEO: <?php echo ($toi_uu_seo == "yes") ? "Có" : "Không"; ?></p>
                                <input type="hidden" name="time_hidden" id="time_item_<?php echo $gia->ID; ?>" value="-1"/>
                            </div>
                            <div class="bot-option">
                                <?php
                                $list_more_ops = get_post_meta($gia->ID, 'them_lua_chon_thong_tin', true);
                                $list_more_ops = explode(',', $list_more_ops);

                                if (($list_more_ops[0] !== '0') && ($list_more_ops[0] !== '')):
                                ?>
                                <form action="<?php bloginfo('url'); ?>/___order_add_more" method="POST">
                                <?php else: ?>
                                    <form action="<?php bloginfo('url'); ?>/___order_add_to_cart" method="POST">
                                    <?php endif; ?>
                                    <input type="hidden" name="prod_id" value="<?php echo $gia->ID; ?>"/>
                                    <input type="hidden" name="prod_type" value="<?php echo get_post_type($gia->ID); ?>"/>
                                    <input type="hidden" name="prod_price" value="<?php echo ensure_numb(get_post_meta($gia->ID, 'gia_tien', 'true')); ?>"/>
                                    <input type="hidden" name="prod_amount" value="1"/>
                                    <input type="hidden" name="prod_name" value="<?php echo $gia->post_title; ?>"/>
                                    <input type="hidden" name="ref_url" value="<?php bloginfo('url'); ?>/gio-hang"/>
                                    <button type="submit">Đăng ký</button>
                                </form>
                            </div>
                        </div>
                    </li>

                <?php
                    if ($count_break == 4):
                        $count_break = 1;
                ?>

                </div>

                <?php
                    else:
                        $count_break++;
                endif;
                ?>

                    <?php endforeach;
                endif;
                ?>

            </ul>
            
            <div class="grid-items clearfix">
                <ul>
                    <?php
                        wp_reset_query();
                        query_posts(array(
                            'post_type' => 'sp-trang-chu',
                            'posts_per_page' => 3,
                            'post__not_in' => array(309),
                            'orderby' => 'rand',
                            'post_status' => 'publish'
                        ));
                        if (have_posts()):
                            $count_prod = 1;
                            while (have_posts()):
                                the_post();
                                $href = get_post_meta(get_the_ID(), 'duong_dan', true);
                                if (has_post_thumbnail(get_the_ID())) {
                                    $src_img = wp_get_attachment_url(get_post_thumbnail_id(get_the_ID()));
                                } else {
                                    $src_img = get_template_directory_uri() . '/assets/img/blank.png';
                                }
                                $img_hover = get_post_meta(get_the_ID(), 'anh_hover', true);
                                $img_hover = $img_hover ? 'data-hover="' . wp_get_attachment_url($img_hover) . '"' : '';
                    ?>
                    
                    <li>
                        <div class="item<?php if (($count_prod % 3) === 1): ?> lt<?php elseif (($count_prod % 3) === 2): ?> md<?php else: ?> rt<?php endif; ?>">
                            <a href="#" class="thumb-sv"><img src="<?php echo $src_img; ?>" <?php echo $img_hover; ?> width="129" height="129"/></a>
                            <h3><a href="<?php echo $href; ?>"><?php the_title(); ?></a></h3>
                            <p><?php echo get_post_meta(get_the_ID(), 'gioi_thieu_ngan', true); ?></p>
                            <a href="<?php echo $href; ?>" class="item-order">Bảng giá</a>
                        </div>
                    </li>
                    
                    <?php
                            $count_prod++;
                            endwhile;
                        endif;
                    ?>
                </ul>
            </div>
        </div>
        
        <?php get_template_part('template', 'support'); ?>
    </div>
</div>

<?php get_footer(); ?>