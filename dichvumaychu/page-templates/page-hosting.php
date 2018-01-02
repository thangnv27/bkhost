<?php
/*
  Template Name: Hosting Price
 */
get_header();

$view_tab = get_query_var('view_tab');
$current_tab = get_term_by('slug', $view_tab, 'ds-hosting');
$list_terms = get_terms('ds-hosting');
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
    $term_post = get_field('chon_bai_viet_dich_vu', 'ds-hosting_' . $current_tab);
    $term_post = $term_post ? $term_post[0] : $post;
}

$list_hosting = get_posts(array(
    'post_type' => 'hosting',
    'order_by' => 'date',
    'order' => 'desc',
    'posts_per_page' => -1,
    'post_status' => 'publish',
    'tax_query' => array(
        array(
            'taxonomy' => 'ds-hosting',
            'field' => 'term_id',
            'terms' => $current_tab
        )
        )));
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
                        $cat_ins = get_term($cat, 'ds-hosting');
                        ?>
                        <li<?php if ($cat == $current_tab): ?> class="active-tg"<?php endif; ?>><a href="<?php bloginfo('url'); ?>/hosting/hdh/<?php echo $cat_ins->slug; ?>"><?php echo $cat_ins->name; ?></a></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <ul class="block-option clearfix">

                <?php
                if (!empty($list_hosting)):
                    $count_break = 1;
                    $range_color = array('green', 'orange', 'pink', '');
                    foreach ($list_hosting as $h):
                        $plesk_control = get_post_meta($h->ID, 'Plesk-control', 'true') == 'yes' ? 'có' : 'không';
                        $khuyen_mai = get_field('khuyen_mai', $h->ID);
                        $repeater_value = get_post_meta($h->ID, 'them_lua_chon_thong_tin', true);
                        if (!is_array($repeater_value) and $repeater_value !== 0) {
                            $attach_value = '';
                            for ($i = 0; $i < $repeater_value; $i++) {
                                $meta_key = 'them_lua_chon_thong_tin_' . $i . '_loai_bo_xung';
                                $sub_field_value = get_post_meta($h->ID, $meta_key, true);
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
                                        <span><?php echo $h->post_title; ?></span>
                                    </div>
                                    <div class="main-option">
                                        <?php
                                        $disk_space = get_post_meta($h->ID, 'disk_space', 'true');
                                        $bandwidth = get_post_meta($h->ID, 'bandwidth', 'true');
                                        $addon_domain = get_post_meta($h->ID, 'Addon-Domain', 'true');
                                        $parked_domain = get_post_meta($h->ID, 'Parked-Domain', 'true');
                                        $sub_domain = get_post_meta($h->ID, 'Sub-domain', 'true');
                                        $mssql_account = get_post_meta($h->ID, 'MSSQL-Account', 'true');
                                        $email_account = get_post_meta($h->ID, 'Email-Account', 'true');
                                        $tai_khoan_host = get_post_meta($h->ID, 'tai-khoan-host', 'true');
                                        $he_dieu_hanh = get_post_meta($h->ID, 'he-dieu-hanh', 'true');
                                        $ram = get_post_meta($h->ID, 'ram', 'true');
                                        $backup = get_post_meta($h->ID, 'backup', 'true');
                                        
                                        echo (empty($disk_space)) ? "" : "<p style='font-weight: bold'>Disk space: $disk_space</p>";
                                        echo (empty($bandwidth)) ? "" : "<p>Bandwidth: $bandwidth</p>";
                                        echo (empty($addon_domain)) ? "" : "<p>Addon Domain: $addon_domain</p>";
                                        echo (empty($parked_domain)) ? "" : "<p>Parked Domain: $parked_domain</p>";
                                        echo (empty($sub_domain)) ? "" : "<p>Sub-domain: $sub_domain</p>";
                                        echo (empty($mssql_account)) ? "" : "<p>MSSQL Account: $mssql_account</p>";
                                        echo (empty($email_account)) ? "" : "<p>Email Account: $email_account</p>";
                                        echo "<p>Plesk control: $plesk_control</p>";
                                        echo (empty($tai_khoan_host)) ? "" : "<p>Tài khoản host: $tai_khoan_host</p>";
                                        echo (empty($he_dieu_hanh)) ? "" : "<p>Hệ điều hành: $he_dieu_hanh</p>";
                                        echo (empty($ram)) ? "" : "<p>RAM: $ram</p>"; 
                                        echo (empty($backup)) ? "" : "<p>Backup: $backup</p>"; 
                                        if( !empty($khuyen_mai) ): 
                                        ?>
                                        <p><span style="color: red;display: block;margin-bottom: 5px">Combo: Domain + Hosting</span>
                                            <img src="<?php echo $khuyen_mai['url']; ?>" alt="<?php echo $khuyen_mai['alt']; ?>" /></p>
                                        <?php endif; ?>
                                        <p class="no-row">
                                            <select class="get_field_price" id="time_item_<?php echo $h->ID; ?>">

                                                <?php
                                                $list_gia_tien = get_field('gia_hang_thang', $h->ID);
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
                                        $list_more_ops = get_post_meta($h->ID, 'them_lua_chon_thong_tin', true);
                                        $list_more_ops = explode(',', $list_more_ops);
                                        if (($list_more_ops[0] !== '0') && ($list_more_ops[0] !== '')):
                                            ?>

                                            <form action="<?php bloginfo('url'); ?>/___order_add_more" method="POST">

                                            <?php else: ?>

                                                <form action="<?php bloginfo('url'); ?>/___order_add_to_cart" method="POST">

                                                <?php endif; ?>

                                                <input type="hidden" name="prod_id" value="<?php echo $h->ID; ?>"/>
                                                <input type="hidden" name="prod_type" value="<?php echo get_post_type($h->ID); ?>"/>
                                                <input type="hidden" name="prod_price" id="prod_price_time_item_<?php echo $h->ID; ?>" value="<?php echo $prod_price; ?>"/>
                                                <input type="hidden" name="prod_amount" value="1"/>
                                                <input type="hidden" name="prod_name" value="<?php echo $h->post_title; ?>"/>
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
                        <span class="t_text_tit_thongso">Thông số kỹ thuật</span></button>
                </div>
                <span style="float:right;width: 295px;margin-left: 10px;margin-top: 20px;color: red;font-weight: bold;font-size: 14px"><i>Lưu ý: Giá trên chưa bao gồm VAT 10%</i></span>
            </div>

            <div class="t_noidungthongso">
                <div class="t_ndts_dong1">
                    <div class="t_ndts_cot1">Server DELL:</div>
                    <div class="t_ndts_cot2">CPU 2 x 24 Core</div>
                    <div class="t_ndts_cot3">SSD - Raid 10</div>
                    <div class="t_ndts_cot4">Đảm bảo sự an toàn của dữ liệu ngay cả trong trường hợp ổ cứng bị Hỏng
                        Tốc độ tăng gấp nhiều lần so với sử dụng ổ cứng SSD thông thường</div>
                </div>
                <div class="t_ndts_dong2">
                    <div class="t_ndts_cot1">Chip:</div>
                    <div class="t_ndts_cot2">Intel ® Xeon ® Processor X5675 (12M Cache, 3.06GHz, 6.40 GT/s Intel® QPI) HHD - Raid 10</div>
                    <div class="t_ndts_cot3">RAM ( Memory)<br>Đường truyển internet:</div>
                    <div class="t_ndts_cot4">128GB<br>1000Mbs</div>
                </div>
            </div>


            <div class="t_tit_dactrung">
                <div class="t_tit_bg_green">
                    <span class="t_icon_cloud"><img alt="ssd_hosting_32" src="<?php echo get_template_directory_uri(); ?>/assets/images/bkhost/t_icon_cl_ssd.png"></span>
                    <span class="t_text_tit_dactrung"> Đặc trưng của Cloud SSD <a href="hosting">Hosting</a> BKHOST</span>
                </div>
            </div>

            <div class="t_nd_dactrung">
                <div class="t_br_yl">
                    <div class="t_bg_num1">1</div>
                    <div class="t_br_nd_dactrung">Tốc độ đẳng cấp vượt trội với cấu hình server mạnh nhất Việt Nam </div>
                </div>
                <div class="t_br_yl">
                    <div class="t_bg_num1">2</div>
                    <div class="t_br_nd_dactrung">Đảm bảo an toàn dữ liệu với công nghệ HDD raid 10 và tốc độ cực khủng với ổ cứng SSD kết hợp công nghệ tăng tốc độ gấp nhiều lần so với SSD thông thường </div>
                </div>
                <div class="t_br_yl">
                    <div class="t_bg_num1">3</div>
                    <div class="t_br_nd_dactrung">Tốc độ đẳng cấp vượt trội với cấu hình server mạnh nhất Việt Nam  </div>
                </div>
                <div class="t_br_yl">
                    <div class="t_bg_num1">4</div>
                    <div class="t_br_nd_dactrung">Quản lý chuyên nghiệp với hệ điều hành Cpanel</div>
                </div>
                <div class="t_br_yl">
                    <div class="t_bg_num1">5</div>
                    <div class="t_br_nd_dactrung">Chương trình ưu đãi đặc biệt dành cho khách hàng khi đăng ký tên miền cùng <a href="hosting">hosting</a>: .COM, .NET, .INFO, .BIZ còn 1.000 VNĐ - Tên miền Việt Nam giảm 50% </div>
                </div>
                <div class="t_br_yl">
                    <div class="t_bg_num1">6</div>
                    <div class="t_br_nd_dactrung">Chính sách bảo vệ sự hài lòng của khách hàng: hoàn tiền 100% trong vòng 30 ngày nếu khách hàng không hài lòng về tốc độ hosting.</div>
                </div>
            </div>

            <div class="t_tit_dactrung">
                <div class="t_tit_bg_green2">
                    <span class="t_icon_cloud"><img alt="ssd_hosting_33" src="<?php echo get_template_directory_uri(); ?>/assets/images/bkhost/t_icon_cl_ssd.png"></span>
                    <span class="t_text_tit_dactrung"> Các tính năng hỗ trợ  </span>
                </div>
            </div>


            <div class="t_nd_tinhnanghotro">
                <div class="t_tinhnangcot1">
                    <div class="t_li_green">PHP (v5.x)</div>
                    <div class="t_li_green">MySQL</div>
                    <div class="t_li_green">PhpMyAdmin</div>
                    <div class="t_li_green">Redirects/ Password Protect Directories</div>
                    <div class="t_li_green"> Joomla</div>
                </div>
                <div class="t_tinhnangcot2">
                    <div class="t_li_green">File manager</div>
                    <div class="t_li_green">FTP/POP/SMTP Over SSL</div>
                    <div class="t_li_green">Web mail</div>
                    <div class="t_li_green">Spam Filter with SpamAssassin</div>
                    <div class="t_li_green">24/7/365 Email + Helpdesk support</div>
                </div>
                <div class="t_tinhnangcot3">
                    <div class="t_li_green">99.9% Server uptime</div>
                    <div class="t_li_green">Weekly Backup</div>
                    <div class="t_li_green">Schedule Task</div>
                </div>
            </div>
            
            <div class="grid-items clearfix">
                <ul>
                    <?php
                    wp_reset_query();
                    query_posts(array(
                        'post_type' => 'sp-trang-chu',
                        'posts_per_page' => 3,
                        'post__not_in' => array(721),
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