<?php
/*
  Template Name: Email Services
 */
get_header();

$view_tab = get_query_var('view_tab');
$current_tab = get_term_by('slug', $view_tab, 'ds-email');
$list_terms = get_terms('ds-email', array('hide_empty' => 0));
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
    $term_post = get_field('chon_bai_viet_dich_vu', 'ds-email_' . $current_tab);
    $term_post = $term_post ? $term_post[0] : $post;
}

$list_data_center = get_posts(array(
    'post_type' => 'dich-vu-email',
    'order_by' => 'date',
    'order' => 'desc',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'ds-email',
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
                            $cat_ins = get_term($cat, 'ds-email');
                    ?>
                        <li<?php if ($cat == $current_tab): ?> class="active-tg"<?php endif; ?>><a href="<?php bloginfo('url'); ?>/email/<?php echo $cat_ins->slug; ?>.html"><?php echo $cat_ins->name; ?></a></li>
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
                                        $dung_luong_luu_tru = get_post_meta($dc->ID, 'dung_luong_luu_tru', 'true');
                                        $email_pop3_webmail = get_post_meta($dc->ID, 'email_pop3_webmail', 'true');
                                        $email_forwarders = get_post_meta($dc->ID, 'email_forwarders', 'true');
                                        $so_tai_khoan = get_post_meta($dc->ID, 'so-tai-khoan', 'true');
                                        $so_luong_thu_gui = get_post_meta($dc->ID, 'so-luong-thu-gui', 'true');
                                        $bao_mat_2lop = get_post_meta($dc->ID, 'bao-mat-2-lop', 'true');
                                        $group_mail = get_post_meta($dc->ID, 'group_mail', 'true');
                                        $cpanel_quan_ly = get_post_meta($dc->ID, 'cpanel-quan-ly', 'true');
                                        $ho_tro = get_post_meta($dc->ID, 'ho-tro', 'true');
                                        $server_dat_tai = get_post_meta($dc->ID, 'server_dat_tai', 'true');
                                        $quan_ly_email_vao = get_post_meta($dc->ID, 'quan-ly-email-vao', 'true');
                                        $quan_ly_email_gui_ra = get_post_meta($dc->ID, 'quan-ly-email-gui-ra', 'true');
                                        $check_mail = get_post_meta($dc->ID, 'check_mail', 'true');
                                        $backup = get_post_meta($dc->ID, 'backup', 'true');
                                        
                                        echo (empty($server_dat_tai)) ? "" : "<p>Server đặt tại: $server_dat_tai</p>";
                                        echo (empty($so_tai_khoan)) ? "" : "<p>Số tài khoản: $so_tai_khoan</p>"; 
                                        echo (empty($dung_luong_luu_tru)) ? "" : "<p>Dung lượng lưu trữ: $dung_luong_luu_tru</p>"; 
                                        echo (empty($so_luong_thu_gui)) ? "" : "<p>Số lượng thư gửi/ngày: $so_luong_thu_gui</p>"; 
                                        echo (empty($email_pop3_webmail)) ? "" : "<p>Email POP3/Webmail: $email_pop3_webmail</p>"; 
                                        echo (empty($email_forwarders)) ? "" : "<p>Email Forwarders: $email_forwarders</p>"; 
                                        echo (empty($bao_mat_2lop)) ? "" : "<p>Bảo mật 2 lớp: $bao_mat_2lop</p>"; 
                                        echo (empty($group_mail)) ? "" : "<p>Group mail: $group_mail</p>"; 
                                        echo (empty($cpanel_quan_ly)) ? "" : "<p>Cpanel quản lý: $cpanel_quan_ly</p>"; 
                                        echo (empty($quan_ly_email_vao)) ? "" : "<p>Quản lý email vào: $quan_ly_email_vao</p>"; 
                                        echo (empty($quan_ly_email_gui_ra)) ? "" : "<p>Quản lý email gửi ra: $quan_ly_email_gui_ra</p>"; 
                                        echo (empty($check_mail)) ? "" : "<p>Check email: $check_mail</p>"; 
                                        echo (empty($backup)) ? "" : "<p>Backup: $backup</p>"; 
                                        echo (empty($ho_tro)) ? "" : "<p>Hỗ trợ: $ho_tro</p>"; 
                                        ?>
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

                        <?php else: $count_break++;
                        endif; ?>

                        <?php
                    endforeach;
                else:
                    ?>

                    <p>Chưa có dữ liệu!</p>

<?php endif; ?>

            </ul>
            
            <div class="grid-items clearfix">
                <ul>
                    <?php
                        wp_reset_query();
                        query_posts(array(
                            'post_type' => 'sp-trang-chu',
                            'posts_per_page' => 3,
                            'post__not_in' => array(733),
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