<?php
/*
  Template Name: Cart Template
 */

get_header();
?>

<div class="domain-content cart-content">

    <?php if (get_count_cart() == 0): ?>

        <div class="cart_list">
            <table>
                <thead>
                    <tr>
                        <td>Tên dịch vụ</td>
                        <td>Phí cài đặt</td>
                        <td>Phí duy trì</td>
                        <td>Thời hạn</td>
                        <td>Số lượng</td>
                        <td>Thành tiền</td>
                        <td></td>
                    </tr>
                </thead>
            </table>
            <p class="empty_cart">Bạn phải thêm vào giỏ hàng một hoặc nhiều dịch vụ trước khi đăng ký dịch vụ!</p>
        </div>

        <?php
    else:
        $cart_items = $_SESSION['__dvmc_cart__'];
        $tong_tien_base = 0;
        ?>

        <div class="cart_list">
            <table>
                <thead>
                    <tr>
                        <td>Tên dịch vụ</td>
                        <td>Phí khởi tạo</td>
                        <td>Phí duy trì</td>
                        <td>Thời hạn</td>
                        <td>Số lượng</td>
                        <td>Thành tiền</td>
                        <td colspan="2">Thao tác</td>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    foreach ($cart_items as $item_type => $item_c):
                        if (!empty($item_c)):
                            ?>

                            <tr class="group-name">
                                <td colspan="8"><?php echo get_label_cart($item_type); ?></td>
                            </tr>
                            <?php
                            foreach ($item_c as $ic) {
                                $tong_tien_base += render_cart_item($ic);
                            }
                        endif;
                    endforeach;
                    ?>

                </tbody>
            </table>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" class="bot-fr" id="fr-remove-all-item">
                <input type="hidden" name="cart_act" value="remove_all"/>
                <input type="hidden" name="prod_id" value="1"/>
                <input type="hidden" name="prod_name" value="1"/>
                <input type="hidden" name="prod_type" value="1"/>
                <input type="hidden" name="prod_amount" value="1"/>
                <input type="hidden" name="prod_price" value='1'/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Cập nhật">Làm trống</button>
            </form>
            <form action="<?php bloginfo('url'); ?>/___order" method="POST" class="bot-fr" id="fr_checkout">
                <input type="hidden" name="checkout_tong_tien" value="<?php echo $tong_tien_base; ?>"/>
                <button type="submit" title="Cập nhật" name="process_checkout">Thanh toán</button>
            </form>
        </div>

    <?php endif; ?>

</div>

<?php
get_footer();
