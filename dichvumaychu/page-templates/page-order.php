<?php
/*
  Template Name: Order Page
 */

$view = 'form';
$ho_ten = '';
$ma_don_hang = '';

if (isset($_POST['process_order']) && isset($_SESSION['__dvmc_cart__']) && count($_SESSION['__dvmc_cart__']) > 0) {

    $view = 'ss';

    $total_price = $_POST['process_checkout_tong'];
    $vat_checkout = $_POST['process_checkout_vat'];
    $total_checkout = $_POST['process_checkout_tong_tien'];
    $san_pham_checkout = $_SESSION['__dvmc_cart__'];

    $ho_ten = isset($_POST['name_field']) ? $_POST['name_field'] : 'Khách hàng';
    $order_title = 'Đơn hàng của ' . $ho_ten;
    $cmnd = isset($_POST['cmnd_field']) ? $_POST['cmnd_field'] : 'Không có';
    $email = isset($_POST['email_field']) ? $_POST['email_field'] : 'Không có';
    $sdt = isset($_POST['phone_field']) ? $_POST['phone_field'] : 'Không có';
    $dc = isset($_POST['address_field']) ? $_POST['address_field'] : 'Không có';
    $yc = isset($_POST['more_require']) ? $_POST['more_require'] : 'Không có';

    $add_order = array(
        'post_title' => $order_title,
        'post_status' => 'publish',
        'post_type' => 'don-dat-hang'
    );

    $order_post = wp_insert_post($add_order);
    $ma_don_hang = str_random(4) . ($order_post * 7 + 4);

    if ($order_post !== 0) {
        update_post_meta($order_post, 'ma_don_hang', $ma_don_hang);
        update_post_meta($order_post, 'thanh_tien_sp', number_format($total_price) . 'đ');
        update_post_meta($order_post, 'vat_sp', number_format($vat_checkout) . 'đ');
        update_post_meta($order_post, 'tong_tien_sp', number_format($total_checkout) . 'đ');

        $html_spc = '';
        foreach ($san_pham_checkout as $type_sp => $info_sp) {
            $html_spc .= "- Loại sản phẩm: " . get_label_cart($type_sp) . "\n";
            $index_sp_c = 1;
            foreach ($info_sp as $info) {
                $html_spc .= $index_sp_c . ": " . $info['name'] . ".\n";
                if (!empty($info['ops'])) {
                    $html_spc .= "Dịch vụ kèm theo:\n";
                    $index_ops = 1;
                    foreach ($info['ops'] as $ips) {
                        $ops_obj = get_post($ips);
                        $html_spc .= "----" . $index_ops . ": " . $ops_obj->post_title . ", giá: " . number_format(get_post_meta($ips, 'gia_tien_thang', true)) . "vnđ.\n";
                        $index_ops++;
                    }
                }
                $index_sp_c++;
            }
        }
        update_post_meta($order_post, 'san_pham_dat_hang', $html_spc);

        update_post_meta($order_post, 'nguoi_dat_hang', $ho_ten);
        update_post_meta($order_post, 'ma_so_thue_so_cmnd', $cmnd);
        update_post_meta($order_post, 'email_nguoi_dat_hang', $email);
        update_post_meta($order_post, 'so_dien_thoai', $sdt);
        update_post_meta($order_post, 'dia_chi_gui', $dc);
        update_post_meta($order_post, 'yeu_cau_khac', $yc);

        $mail_content = '<p><strong>Sản phẩm đặt hàng:</strong></p>';
        $mail_content .= '<p>' . $html_spc . '</p>';
        $mail_content .= '<p><strong>Thông tin đơn hàng:</strong></p>';
        $mail_content .= '<ul>';
        $mail_content .= '<li><p>Mã đơn hàng: <strong>' . $ma_don_hang . '</strong></p></li>';
        $mail_content .= '<li><p>Thành tiền: ' . number_format($total_price) . 'đ</p></li>';
        $mail_content .= '<li><p>VAT: ' . number_format($vat_checkout) . 'đ</p></li>';
        $mail_content .= '<li><p>Tổng tiền: ' . number_format($total_checkout) . 'đ</p></li>';
        $mail_content .= '</ul>';
        $mail_content .= '<p><strong>Thông tin khách hàng hàng:</strong></p>';
        $mail_content .= '<ul>';
        $mail_content .= '<li><p>Họ tên: ' . $ho_ten . '</p></li>';
        $mail_content .= '<li><p>Email: ' . $email . '</p></li>';
        $mail_content .= '<li><p>SDT: ' . $sdt . '</p></li>';
        $mail_content .= '<li><p>Địa chỉ: ' . $dc . '</p></li>';
        $mail_content .= '</ul>';
        $mail_content .= 'Thư này được gửi đi từ bkhost.vn';
        $mail_content .= '<p>--------</p>';
        $mail_content .= '<p>Admin DichvuMayChu</p>';

        wp_mail(get_option('admin_email'), 'Đơn đặt hàng của ' . $ho_ten, $mail_content, array(
            'From: ' . $ho_ten . ' (Đặt hàng) <' . $email . '>',
            'Content-type: text/html'
        ));

        unset($_SESSION['__dvmc_cart__']);

        require_once(get_template_directory() . '/protected/views/ss-order.php');
    }
} elseif (isset($_POST['process_checkout']) && isset($_SESSION['__dvmc_cart__']) && count($_SESSION['__dvmc_cart__']) > 0 && isset($_POST['checkout_tong_tien'])) {
    $total_price = $_POST['checkout_tong_tien'];
    $vat_checkout = floor($total_price * 0.1);
    $total_checkout = $total_price + $vat_checkout;
    $san_pham_checkout = $_SESSION['__dvmc_cart__'];

    get_header();
    ?>

    <div class="order-content domain-content">

        <div class="col-left cart_list">
            <form id="fr-order-last-step" method="POST">
                <table>
                    <thead>
                        <tr>
                            <td colspan="2">Thông tin người đặt hàng</td>
                            <td></td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="w3">Họ tên:</td>
                            <td class="w7">
                                <input type="text" id="name_field" name="name_field" class="full_size" placeholder="Họ và tên"/>
                                <span class="sp-result-err" id="sp-name_field"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="w3">Mã số thuế hoặc số CMTND:</td>
                            <td class="w7">
                                <input type="text" id="cmnd_field" name="cmnd_field" class="full_size" placeholder="Mã số thuế hoặc số CMTND"/>
                                <span class="sp-result-err" id="sp-cmnd_field"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="w3">Email:</td>
                            <td class="w7">
                                <input type="text" id="email_field" name="email_field" class="full_size" placeholder="Email"/>
                                <span class="sp-result-err" id="sp-email_field"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="w3">Số điện thoại:</td>
                            <td class="w7">
                                <input type="text" id="phone_field" name="phone_field" class="full_size" placeholder="Số điện thoại"/>
                                <span class="sp-result-err" id="sp-phone_field"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="w3">Địa chỉ:</td>
                            <td class="w7">
                                <input type="text" id="address_field" name="address_field" class="full_size" placeholder="Địa chỉ"/>
                                <span class="sp-result-err" id="sp-address_field"></span>
                            </td>
                        </tr>
                        <tr>
                            <td class="w3">Yêu cầu khác:</td>
                            <td class="w7"><textarea id="more_require" name="more_require" class="full_size" placeholder="Yêu cầu khác"></textarea></td>
                        </tr>
                        <tr>
                            <td  class="w3"></td>
                            <td  class="w7">
                                <input type="hidden" name="process_checkout_tong" value="<?php echo $total_price; ?>"/>
                                <input type="hidden" name="process_checkout_vat" value="<?php echo $vat_checkout; ?>"/>
                                <input type="hidden" name="process_checkout_tong_tien" value="<?php echo $total_checkout; ?>"/>
                                <button type="submit" class="btn-submit" name="process_order">Gửi</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </div>

        <div class="col-right next_pay_cart">
            <h4 class="title" style="margin-top: 0">Thông tin đơn hàng</h4>
            <div class="total_cart_info">
                <p>Tổng tiền: <span id="result_count_total_price"><?php echo number_format($total_price); ?>đ</span></p>
                <p>Thuế VAT(10%): <span id="result_vat_price"><?php echo number_format($vat_checkout); ?>đ</span></p>
                <p class="last"><strong>Thành tiền: <span id="total_sum_price"><?php echo number_format($total_checkout); ?>đ</span></strong></p>
            </div>
        </div>

    </div>

    <?php
    get_footer();
} else {
    wp_redirect(get_bloginfo('url') . '/gio-hang');
    return;
}
?>