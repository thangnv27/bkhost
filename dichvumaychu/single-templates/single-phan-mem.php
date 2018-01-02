<?php get_header(); ?>

<div id="post-content">
    <div class="panel-bg container">
        <div class="panel-content">
            
        <?php if (have_posts()): while (have_posts()): the_post(); ?>
            
            <div class="panel-text-content software-panel">
                <div class="top-content-panel clearfix">
                    <h1 class="h1_title"><?php the_post_thumbnail('smail_software');the_title(); ?></h1>
                    <div class="col-left excerpt-soft">
                        <?php the_excerpt(); ?>
                    </div>
                    <?php
                        $loai_bang_gia = get_post_meta(get_the_ID(), 'loai_bang_gia_sl', true);
                        if (($loai_bang_gia == 'tuychon') || ($loai_bang_gia == 'thuong')) {
                            if ($loai_bang_gia == 'tuychon') {
                    ?>
                    
                    <table class="tb-price-soft">
                        <thead>
                            <tr>
                                <th>Thanh toán</th>
                                <th>Internal</th>
                                <th>External</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                while (the_repeater_field('bang_gia_phan_mem', get_the_ID())) {
                                    $relationship_field = get_sub_field('bang_gia_pm');
                                    $ghi_chu_bang_gia = get_post_meta($relationship_field->ID, 'loai_bang_gia', true);
                                    if ($ghi_chu_bang_gia) {
                            ?>
                                <tr>
                                    <td class="sale-col" colspan="3"><?php echo $ghi_chu_bang_gia; ?></td>
                                </tr>
                            <?php       
                                    }
                                    $field_price_soft = get_field('gia_phan_mem', $relationship_field->ID);
                                    foreach ($field_price_soft as $price_software) {
                                        $gia_internal = get_post_meta($price_software->ID, 'gia_internal', true);
                                        $gia_external = get_post_meta($price_software->ID, 'gia_external', true);
                                        $ten_gia_pm = get_post_meta($price_software->ID, 'ten_gia_pm', true);
                            ?>
                                <tr>
                                    <td><?php echo $ten_gia_pm; ?></td>
                                    <td>
                                        <?php echo number_format($gia_internal); ?> vnđ
                                        <form action="<?php bloginfo('url'); ?>/___order_add_to_cart" method="POST">
                                            <input type="hidden" name="prod_id" value="<?php the_ID(); ?>"/>
                                            <input type="hidden" name="prod_type" value="<?php echo get_post_type(get_the_ID()); ?>"/>
                                            <input type="hidden" name="prod_price" value="<?php echo $price_software->ID; ?>"/>
                                            <input type="hidden" name="prod_amount" value="1"/>
                                            <input type="hidden" name="prod_name" value="<?php the_title(); ?> gói <?php echo $ten_gia_pm; ?>"/>
                                            <input type="hidden" name="prod_ext" value="gia_internal"/>
                                            <input type="hidden" name="ref_url" value="<?php bloginfo('url'); ?>/gio-hang"/>
                                            <button type="submit" name="add_more">Đăng ký</button>
                                        </form>
                                    </td>
                                    <td>
                                        <?php echo number_format($gia_external); ?> vnđ
                                        <form action="<?php bloginfo('url'); ?>/___order_add_to_cart" method="POST">
                                            <input type="hidden" name="prod_id" value="<?php the_ID(); ?>"/>
                                            <input type="hidden" name="prod_type" value="<?php echo get_post_type(get_the_ID()); ?>"/>
                                            <input type="hidden" name="prod_price" value="<?php echo $price_software->ID; ?>"/>
                                            <input type="hidden" name="prod_amount" value="1"/>
                                            <input type="hidden" name="prod_name" value="<?php the_title(); ?>"/>
                                            <input type="hidden" name="prod_ext" value="gia_external"/>
                                            <input type="hidden" name="ref_url" value="<?php bloginfo('url'); ?>/gio-hang"/>
                                            <button type="submit" name="add_more">Đăng ký</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php }} ?>
                        </tbody>
                    </table>
                    
                    <?php
                        } else {
                            $tieu_de_bang = get_post_meta(get_the_ID(), 'tieu_de_bang_gia', true);
                            $tieu_de_bang = $tieu_de_bang ?: 'Bảng giá';
                            $ghi_chu_bang = get_post_meta(get_the_ID(), 'ghi_chu_bang_gia', true);
                            $tieu_de_gia_tien = get_post_meta(get_the_ID(), 'tieu_de_gia_tien', true);
                            $tieu_de_gia_tien = $tieu_de_gia_tien ?: 'Giá';
                            $gia_tien = get_post_meta(get_the_ID(), 'gia_thuong', true);
                            $gia_tien = $gia_tien ? number_format($gia_tien) : 0;
                            $ky_tu_kem_theo = get_post_meta(get_the_ID(), 'ky_tu_kem_theo', true);
                            $ky_tu_kem_theo = $ky_tu_kem_theo ?: 'vnđ';
                            $thanh_tien = $gia_tien.' '.$ky_tu_kem_theo;
                    ?>
                       
                    <table class="tb-price-soft">
                        <thead>
                            <tr>
                                <th colspan="2"><?php echo $tieu_de_bang; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            
                            <?php if ($ghi_chu_bang): ?>
                            
                            <tr>
                                <td class="sale-col" colspan="2"><?php echo $ghi_chu_bang; ?></td>
                            </tr>
                            
                            <?php endif; ?>
                            
                            <tr>
                                <td><?php echo $tieu_de_gia_tien; ?></td>
                                <td>
                                    <?php echo $thanh_tien; ?>
                                    <form action="<?php bloginfo('url'); ?>/___order_add_to_cart" method="POST">
                                        <input type="hidden" name="prod_id" value="<?php the_ID(); ?>"/>
                                        <input type="hidden" name="prod_type" value="<?php echo get_post_type(get_the_ID()); ?>"/>
                                        <input type="hidden" name="prod_price" value="<?php echo the_ID(); ?>"/>
                                        <input type="hidden" name="prod_amount" value="1"/>
                                        <input type="hidden" name="prod_name" value="<?php echo $tieu_de_gia_tien; ?>"/>
                                        <input type="hidden" name="prod_ext" value="gia_internal"/>
                                        <input type="hidden" name="ref_url" value="<?php bloginfo('url'); ?>/gio-hang"/>
                                        <button type="submit" name="add_more">Đăng ký</button>
                                    </form>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <?php }} ?>
                    
                </div>
                <?php the_content(); ?>
            </div>
            
        <?php endwhile; endif; ?>
            
        </div>
    </div>
</div>

<?php get_footer();