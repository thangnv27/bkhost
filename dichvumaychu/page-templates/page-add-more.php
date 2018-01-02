<?php
/*
  Template Name: Order Add More Page
 */

$check = false;

if (isset($_POST['prod_id']) && isset($_POST['prod_type']) 
    && isset($_POST['prod_price']) && isset($_POST['prod_name'])) {
    
    $prod_id = (int) $_POST['prod_id'];
    $post_type = $_POST['prod_type'];
    $prod_price = $_POST['prod_price'];
    $prod_name = $_POST['prod_name'];
    $prod = get_post($prod_id);
    $price = ($post_type == 'tk-web') ? ensure_numb(get_post_meta($gia->ID, 'gia_tien', 'true')) : get_post($prod_price);
    if ($prod && $price) {
        if ($prod->post_type == $post_type) {
            $check = true;
            $list_more_ops = get_post_meta($prod->ID, 'them_lua_chon_thong_tin', true);
//            $list_more_ops = explode(',', $list_more_ops);
        }
    }
}

if (!$check) {
    wp_redirect(get_bloginfo('url') . '/gio-hang');
    return;
}

get_header();
?>

<div style="margin-top: 30px;margin-bottom: 30px;">
    <form action="<?php bloginfo('url'); ?>/___order_add_to_cart" method="POST" id="fr_add_more">
        <input type="hidden" name="prod_amount" value="1"/>
        <input type="hidden" name="prod_id" value="<?php echo $prod_id; ?>"/>
        <input type="hidden" name="prod_name" value="<?php echo $prod_name; ?>"/>
        <input type="hidden" name="prod_type" value="<?php echo $post_type; ?>"/>
        <input type="hidden" name="prod_price" value="<?php echo $prod_price; ?>"/>
        <input type="hidden" name="ref_url" value="<?php bloginfo('url'); ?>/gio-hang"/>
        <div class="cart_list">
            <table>
                <thead>
                    <tr>
                        <td>Dịch vụ bổ xung</td>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($list_more_ops as $ops):
                        $ops = get_post($ops);
                        ?>
                        <tr>
                            <td>
                                <label for="checkbox_<?php echo $ops->ID; ?>">
                                    <input type="checkbox" id="checkbox_<?php echo $ops->ID; ?>" value="<?php echo $ops->ID; ?>" name="list_ops[]"/>
                                    <?php echo $ops->post_title; ?>
                                </label>
                            </td>
                        </tr>

                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <button type="submit">Thêm vào giỏ hàng</button>
    </form>
</div>

<?php
get_footer();