<?php
/*
  Template Name: VPS Price
 */
get_header();

$view_tab = get_query_var('view_tab');
$current_tab = get_term_by('slug', $view_tab, 'ds-cloud');
$list_terms = get_terms('ds-cloud', array('hide_empty' => 0));
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
    $term_post = get_field('chon_bai_viet_dich_vu', 'ds-cloud_' . $current_tab);
    $term_post = $term_post ? $term_post[0] : $post;
}

$list_vps = get_posts(array(
    'post_type' => 'vps-cloud',
    'order_by' => 'date',
    'order' => 'asc',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'ds-cloud',
            'field' => 'term_id',
            'terms' => $current_tab
        )
    )
));
?>
<div id="post-content">
    <div class="panel-bg">
        <div class="panel-content">
            <?php if (have_posts()): while (have_posts()): the_post(); ?>
            <h1 style="padding-left: 10px; padding-top: 10px; text-transform: uppercase; text-align: center; color: rgb(234, 108, 0); font-size: 24px;"><?php the_title(); ?></h1>
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
                        $cat_ins = get_term($cat, 'ds-cloud');
                        ?>
                        <li<?php if ($cat == $current_tab): ?> class="active-tg"<?php endif; ?>><a href="<?php bloginfo('url'); ?>/cloud/xem/<?php echo $cat_ins->slug; ?>"><?php echo $cat_ins->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <ul class="block-option clearfix">
                <?php
                if (!empty($list_vps)):
                    $count_break = 1;
                    $range_color = array('green', 'orange', 'pink', '');
                    foreach ($list_vps as $vps):
                        $data_ct = get_post_meta($vps->ID, 'datacenter', 'true');
                        $repeater_value = get_post_meta($vps->ID, 'them_lua_chon_thong_tin', true);
                        if ($repeater_value and $repeater_value !== 0) {
                            $attach_value = '';
                            for ($i = 0; $i < count($repeater_value); $i++) {
                                $meta_key = 'them_lua_chon_thong_tin_' . $i . '_loai_bo_xung';
                                $sub_field_value = get_post_meta($vps->ID, $meta_key, true);
                                $attach_value .= $sub_field_value . '-';
                            }
                            $attach_value = rtrim($attach_value, '-');
                        } else {
                            $attach_value = 'no_attach';
                        }
                        if ($count_break == 1): ?>
                            <div class="ops-item clearfix">
                            <?php endif; ?>
                            <li>
                                <div class="option-item <?php echo $range_color[array_rand($range_color)]; ?>">
                                    <div class="top-option">
                                        <span><?php echo $vps->post_title; ?></span>
                                    </div>
                                    <div class="main-option">
                                        <p>CPU: <?php echo get_post_meta($vps->ID, 'cpu_vps', 'true'); ?></p>
                                        <p>RAM: <?php echo get_post_meta($vps->ID, 'ram_vps', 'true'); ?></p>
                                        <p>HDD: <?php echo get_post_meta($vps->ID, 'hdd_vps', 'true'); ?></p>
                                        <p>Băng thông: <?php echo get_post_meta($vps->ID, 'bang_thong_vps', 'true'); ?></p>
                                        <p>IP Address: <?php echo get_post_meta($vps->ID, 'ip_address_vps', 'true'); ?></p>
                                        <p>
                                            Máy chủ đặt tại:
                                            <select name="data_center">
                                                <option value="vdc">VDC</option>
                                                <option value="fpt">FPT</option>
                                                <option value="cmc">CMC</option>
                                                <option value="viettel">Viettel</option>
                                                <option value="vtc">VTC</option>
                                            </select>
                                        </p>
                                        <p>Cổng trong nước/ quốc tế: <?php echo get_post_meta($vps->ID, 'cong_trong_nuoc_quoc_te_vps', 'true'); ?></p>
                                        <p>Phương thức quản trị: <?php echo get_post_meta($vps->ID, 'phuong_thuc_quan_tri_vps', 'true'); ?></p>
                                        <p>Cài đặt miễn phí: <?php echo get_post_meta($vps->ID, 'cai_dat_mien_phi_vps', 'true'); ?></p>
                                        <p class="no-row">
                                            <select id="item_os">
                                                <option value="win">Hệ điều hành Window</option>
                                                <option value="linux">Hệ điều hành Linux</option>
                                            </select>
                                        </p>
                                        <p class="no-row">
                                            <select class="get_field_price" id="time_item_<?php echo $vps->ID; ?>">
                                                <?php
                                                $list_gia_tien = get_field('gia_hang_thang', $vps->ID);
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
                                        $list_more_ops = get_post_meta($vps->ID, 'them_lua_chon_thong_tin', true);
                                        $list_more_ops = explode(',', $list_more_ops);
                                        if (($list_more_ops[0] !== '0') && ($list_more_ops[0] !== '')):
                                            ?>
                                            <form action="<?php bloginfo('url'); ?>/___order_add_more" method="POST">
                                            <?php else: ?>
                                                <form action="<?php bloginfo('url'); ?>/___order_add_to_cart" method="POST">
                                                <?php endif; ?>
                                                <input type="hidden" name="prod_id" value="<?php echo $vps->ID; ?>"/>
                                                <input type="hidden" name="prod_type" value="<?php echo get_post_type($vps->ID); ?>"/>
                                                <input type="hidden" name="prod_price" id="prod_price_time_item_<?php echo $vps->ID; ?>" value="<?php echo $prod_price; ?>"/>
                                                <input type="hidden" name="prod_amount" value="1"/>
                                                <input type="hidden" name="prod_name" value="<?php echo $vps->post_title; ?>"/>
                                                <input type="hidden" name="ref_url" value="<?php bloginfo('url'); ?>/gio-hang"/>
                                                <button type="submit" name="add_more">Đăng ký</button>
                                            </form>
                                    </div>
                                </div>
                            </li>
                            <?php if ($count_break == 4): $count_break = 1; ?>
                            </div>
                            <?php
                        else: 
                            $count_break++;
                        endif;
                    endforeach;
                else:
                    ?>
                    <p style="color: orangered">Chưa có dữ liệu!</p>
                <?php endif; ?>
            </ul>
            <div class="grid-items clearfix">
                <ul>
                    <?php
                    wp_reset_query();
                    query_posts(array(
                        'post_type' => 'sp-trang-chu',
                        'posts_per_page' => 3,
                        'post__not_in' => array(717),
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

<?php
get_footer();
