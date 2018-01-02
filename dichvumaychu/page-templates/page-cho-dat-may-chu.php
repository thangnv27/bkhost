<?php
/*
  Template Name: DataCenter Price
 */
get_header();

$view_tab = get_query_var('view_tab');
$current_tab = get_term_by('slug', str_replace('cho-dat-may-chu-', '', $view_tab), 'ds-cho-dat-may-chu');
$list_terms = get_terms('ds-cho-dat-may-chu');
$list_cat = array();

foreach ($list_terms as $tr) {
    $list_cat[] = $tr->term_id;
}

if (!$current_tab || !in_array($current_tab->term_id, $list_cat)) {
    $current_tab = $list_cat[0];
} else {
    $current_tab = $current_tab->term_id;
}

global $post;

if (empty($view_tab) || $view_tab == '') {
    $term_post = $post;
} else {
    $term_post = get_field('chon_bai_viet_dich_vu', 'ds-cho-dat-may-chu_' . $current_tab);
    $term_post = $term_post ? $term_post[0] : $post;
}

$list_data_center = get_posts(array(
    'post_type' => 'cho-dat-data',
    'order_by' => 'date',
    'order' => 'desc',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'ds-cho-dat-may-chu',
            'field' => 'term_id',
            'terms' => $current_tab
        )
        )));
?>
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
            <div class="top-toggle clearfix">
                <ul>
                    <?php
                    foreach ($list_cat as $cat):
                        $cat_ins = get_term($cat, 'ds-cho-dat-may-chu');
                        ?>
                        <li<?php if ($cat == $current_tab): ?> class="active-tg"<?php endif; ?>><a href="<?php bloginfo('url'); ?>/cho-dat-may-chu/xem/cho-dat-may-chu-<?php echo $cat_ins->slug; ?>"><?php echo $cat_ins->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <ul class="block-option clearfix">

                <?php
                if (!empty($list_data_center)):
                    $count_break = 1;
                    $range_color = array('green', 'orange', 'pink', '');
                    foreach ($list_data_center as $dc):
                        $ups = get_post_meta($dc->ID, 'dieu_hoa_may_no_ups', 'true') == 'yes' ? 'có' : 'không';
                        $repeater_value = get_post_meta($dc->ID, 'them_lua_chon_thong_tin', true);
                        if ($repeater_value !== 0) {
                            $attach_value = '';
                            for ($i = 0; $i < $repeater_value; $i++) {
                                $meta_key = 'them_lua_chon_thong_tin_' . $i . '_loai_bo_xung';
                                $sub_field_value = get_post_meta($dc->ID, $meta_key, true);
                                $attach_value .= $sub_field_value . '-';
                            }
                            $attach_value = rtrim($attach_value, '-');
                        } else {
                            $attach_value = 'no_attach';
                        }
                        ?>

                        <?php if ($count_break == 1): ?>

                            <div class="ops-item clearfix">

                            <?php endif; ?>

                            <li>
                                <div class="option-item <?php echo $range_color[array_rand($range_color)]; ?>">
                                    <div class="top-option">
                                        <span><?php echo $dc->post_title; ?></span>
                                    </div>
                                    <div class="main-option">
                                        <?php
                                        $anh_may_chu = get_field('anh_may_chu', $dc->ID);
                                        if( !empty($anh_may_chu) ): 
                                        ?>
                                        <p style="text-align: center"><img src="<?php echo $anh_may_chu['url']; ?>" alt="<?php echo $anh_may_chu['alt']; ?>" /></p>
                                        <?php endif; ?>
                                        <p>Không gian rack: <?php echo get_post_meta($dc->ID, 'khong_gian_rack', 'true'); ?></p>
                                        <p>Công suất điện: <?php echo get_post_meta($dc->ID, 'cong_suat_dien', 'true'); ?></p>
                                        <p>IP Address: <?php echo get_post_meta($dc->ID, 'ip_address', 'true'); ?></p>
                                        <p>Datatransfer: <?php echo get_post_meta($dc->ID, 'datatransfer', 'true'); ?></p>
                                        <p>Băng thông trong nước: <?php echo get_post_meta($dc->ID, 'bang_thong_trong_nuoc', 'true'); ?></p>
                                        <p>Băng thông quốc tế: <?php echo get_post_meta($dc->ID, 'bang_thong_quoc_te', 'true'); ?></p>
                                        <p class="no-row">
                                            <select class="get_field_price" id="time_item_<?php echo $dc->ID; ?>">

                                                <?php
                                                $list_gia_tien = get_field('gia_hang_thang', $dc->ID);
                                                $prod_price = $list_gia_tien[0]->ID;
                                                foreach ($list_gia_tien as $current_gia_tien):
                                                    ?>

                                                    <option value="<?php echo get_post_meta($current_gia_tien->ID, 'tinh_theo_thang', true); ?>" data-field-id="<?php echo $current_gia_tien->ID; ?>"><?php echo get_post_meta($current_gia_tien->ID, 'tieu_de', true); ?></option>

                                                <?php endforeach; ?>

                                            </select>
                                        </p>
                                    </div>
                                    <div class="bot-option">
                                        <?php
                                        $list_more_ops = get_post_meta($dc->ID, 'them_lua_chon_thong_tin', true);
                                        $list_more_ops = explode(',', $list_more_ops);

                                        if (($list_more_ops[0] !== '0') && ($list_more_ops[0] !== '')):
                                            ?>

                                            <form action="<?php bloginfo('url'); ?>/___order_add_more" method="POST">

                                            <?php else: ?>

                                                <form action="<?php bloginfo('url'); ?>/___order_add_to_cart" method="POST">

                                                <?php endif; ?>

                                                <input type="hidden" name="prod_id" value="<?php echo $dc->ID; ?>"/>
                                                <input type="hidden" name="prod_type" value="<?php echo get_post_type($dc->ID); ?>"/>
                                                <input type="hidden" name="prod_price" id="prod_price_time_item_<?php echo $dc->ID; ?>" value="<?php echo $prod_price; ?>"/>
                                                <input type="hidden" name="prod_amount" value="1"/>
                                                <input type="hidden" name="prod_name" value="<?php echo $dc->post_title; ?>"/>
                                                <input type="hidden" name="ref_url" value="<?php bloginfo('url'); ?>/gio-hang"/>
                                                <button type="submit" name="add_more">Đăng ký</button>
                                            </form>

                                    </div>
                                </div>
                            </li>

                            <?php if ($count_break == 4): $count_break = 1; ?>

                            </div>

                            <?php
                        else: $count_break++;
                        endif;
                        ?>

                        <?php
                    endforeach;
                else:
                    ?>

                    <p>Chưa có dữ liệu!</p>

                <?php endif; ?>

            </ul>
            
            <div class="t_thongsokythuat">
                <div class="t_tit_thongso">
                    <button><span class="t_icon_ssdhotting_thongso"><img alt="ssd_hosting_31" src="<?php echo get_template_directory_uri(); ?>/assets/images/bkhost/t_icon_ssdhotting_thongso.png"></span>
                        <span class="t_text_tit_thongso">Datacenter</span></button>
                </div>
            </div>

            <div class="t_noidungthongso">
                <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d15714849.97819861!2d107.797465!3d15.928271!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sus!4v1450624154655" width="50%" height="360" frameborder="0" style="border:0;float: left" allowfullscreen></iframe>
                <iframe style="float: left" width="50%" height="360px" src="https://www.youtube.com/embed/CeHBa-iTKxI" frameborder="0" allowfullscreen></iframe>
            </div>
            
            <!--
            <div class="panel-text-content">
                <?php
                    $content = $term_post->post_content;
                    $content = apply_filters('the_content', $content);
                    $content = str_replace(']]>', ']]&gt;', $content);
                    echo $content;
                ?>
            </div>
            -->
            
            <div class="grid-items clearfix">
                <ul>
                    <?php
                    wp_reset_query();
                    query_posts(array(
                        'post_type' => 'sp-trang-chu',
                        'posts_per_page' => 3,
                        'post__not_in' => array(719),
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