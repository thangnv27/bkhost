<?php

function find_all_domains() {
    $list_domain = get_posts(array(
        'post_type' => 'ten-mien',
        'posts_per_page' => '-1',
        'order_by' => 'date',
        'order' => 'asc'
    ));
    wp_reset_query();
    return $list_domain;
}

function domain_check_availability($domain, &$list) {
    $new_domain = $domain;
    $content = file_get_contents("http://www.whois.net.vn/whois.php?domain=" . $domain);
    $pos = strrpos($new_domain, '.');
    $new_domain = substr($new_domain, $pos, strlen($new_domain));
    $domain_post = get_page_by_title($new_domain, OBJECT, 'ten-mien');
    $list[] = array(
        'ID' => $domain_post->ID,
        'domain' => $domain,
        'status' => ($content === '0') ? true : false
    );
}

function domain_get_whois($domain) {
    $content = file_get_contents("http://whois.matbao.vn/rss/" . $domain . "/0");
    $xml = new SimpleXmlElement($content);
    if (isset($xml->channel->item) && !empty($xml->channel->item)) {
        $result_info = '';
        foreach ($xml->channel->item as $item_info) {
            $result_info .= '<p><strong>' . $item_info->title . ':</strong> ' . $item_info->description . '</p>';
        }

        $content = file_get_contents("http://whois.matbao.vn/rss/" . $domain . "/1");
        $xml = new SimpleXmlElement($content);

        if (isset($xml->channel->item[0]->description)) {
            $result_info .= '<p>' . $xml->channel->item[0]->description . '</p>';
        }

        return '<div class="result_whois">' . $result_info . '</div>';
    } else {
        return '';
    }
}

function domain_by_title($domain_type) {
    global $wpdb;
    $postid = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '" . $domain_type . "' AND post_status = 'publish' AND post_type = 'ten-mien'");
    return (bool) $postid;
}

function get_phi_ten_mien($name) {
    $pos = strpos($name, '.');
    $title = substr($name, $pos, strlen($name));
    global $wpdb;
    $postid = $wpdb->get_var("SELECT ID FROM $wpdb->posts WHERE post_title = '" . $title . "' AND post_status = 'publish' AND post_type = 'ten-mien'");

    if ($postid) {
        $price_domain = array(
//            get_post_meta($postid, 'phi_khoi_tao', true),
            get_field('phi_khoi_tao', $postid),
            get_post_meta($postid, 'phi_khoi_tao_giam_gia', true),
//            get_post_meta($postid, 'phi_duy_tri', true),
            get_field('phi_duy_tri', $postid),
            get_post_meta($postid, 'phi_duy_tri_giam_gia', true)
        );
        if ($price_domain[0] == 'Free') {
            $phi_khoi_tao = '<span class="domain-price free">Free</span>';
            $phi_kt = 0;
        } elseif (isset($price_domain[1]) && ($price_domain[1] !== '0')) {
            $phi_khoi_tao = '<span class="domain-price">' . number_format($price_domain[1]) . '</span><span class="domain-price del-line">' . number_format($price_domain[0]) . '</span>';
            $phi_kt = $price_domain[1];
        } else {
            $phi_khoi_tao = '<span class="domain-price">' . number_format($price_domain[0]) . '</span>';
            $phi_kt = $price_domain[0];
        }
        if (isset($price_domain[3]) && ($price_domain[3] !== '0')) {
            $phi_duy_tri = '<span class="domain-price">' . number_format($price_domain[3]) . '</span><span class="domain-price del-line">' . number_format_i18n($price_domain[2]) . '</span>';
            $phi_dt = $price_domain[3];
        } else {
            $phi_duy_tri = '<span class="domain-price">' . number_format($price_domain[2]) . '</span>';
            $phi_dt = $price_domain[2];
        }
        return array($phi_khoi_tao, $phi_duy_tri, 'json' => array($phi_kt, $phi_dt));
    } else {
        return array(0, 0, array());
    }
}

function get_top_search() {
    $domain_search = get_posts(array(
        'post_type' => 'ten-mien',
        'posts_per_page' => -1,
        'order_by' => 'date',
        'order' => 'asc',
        'meta_key' => 'popular_domain',
        'meta_value' => 'top'
    ));
    if (!empty($domain_search)) {
        $list_domain_search = array();
        foreach ($domain_search as $ds) {
            $list_domain_search[] = $ds->post_title;
        }
        return $list_domain_search;
    }
    return array();
}

function get_domain_vn() {
    $domain_search = get_posts(array(
        'post_type' => 'ten-mien',
        'posts_per_page' => -1,
        'order_by' => 'date',
        'order' => 'asc',
        'tax_query' => array(
            array(
                'taxonomy' => 'loai-ten-mien',
                'field' => 'term_id',
                'terms' => 431
            )
        )
    ));
    if (!empty($domain_search)) {
        $list_domain_search = array();
        foreach ($domain_search as $ds) {
            $list_domain_search[] = $ds->post_title;
        }
        return $list_domain_search;
    }
    return array();
}

function get_domain_global() {
    $domain_search = get_posts(array(
        'post_type' => 'ten-mien',
        'posts_per_page' => -1,
        'order_by' => 'date',
        'order' => 'asc',
        'tax_query' => array(
            array(
                'taxonomy' => 'loai-ten-mien',
                'field' => 'term_id',
                'terms' => 433
            )
        )
    ));
    if (!empty($domain_search)) {
        $list_domain_search = array();
        foreach ($domain_search as $ds) {
            $list_domain_search[] = $ds->post_title;
        }
        return $list_domain_search;
    }
    return array();
}

function get_domain_by_group($cat) {
    $domain_search = get_posts(array(
        'post_type' => 'ten-mien',
        'posts_per_page' => -1,
        'order_by' => 'date',
        'order' => 'asc',
        'tax_query' => array(
            array(
                'taxonomy' => 'loai-ten-mien',
                'field' => 'term_id',
                'terms' => $cat
            )
        )
    ));
    
    if (!empty($domain_search)) {
        $list_domain_search = array();
        foreach ($domain_search as $index => $ds) {
            $list_domain_search[$index]['name'] = $ds->post_title;
            $list_domain_search[$index]['group'] = get_post_meta($ds->ID, 'domain_group', true);
            $list_domain_search[$index]['phi_khoi_tao'] = get_post_meta($ds->ID, 'phi_khoi_tao', true);
            $list_domain_search[$index]['phi_khoi_tao_giam_gia'] = get_post_meta($ds->ID, 'phi_khoi_tao_giam_gia', true);
            $list_domain_search[$index]['phi_duy_tri'] = get_post_meta($ds->ID, 'phi_duy_tri', true);
            $list_domain_search[$index]['phi_duy_tri_giam_gia'] = get_post_meta($ds->ID, 'phi_duy_tri_giam_gia', true);
            $list_domain_search[$index]['phi_transfer_ve_vdo'] = get_post_meta($ds->ID, 'phi_transfer_ve_vdo', true);
            $list_domain_search[$index]['phi_transfer_ve_vdo_giam_gia'] = get_post_meta($ds->ID, 'phi_transfer_ve_vdo_giam_gia', true);
        }

        $list_result = array();

        foreach ($list_domain_search as $index => $domain) {
            if ($domain['group'] == '0') {
                $list_result[$index] = $domain;
            } elseif (!isset($list_result['gr-' . $domain['group']])) {
                $list_result['gr-' . $domain['group']] = $domain;
            } else {
                $list_result['gr-' . $domain['group']]['name'] = $list_result['gr-' . $domain['group']]['name'] . ', ' . $domain['name'];
            }
        }

        return $list_result;
    }
    return array();
}

function resolve_item_cart($item) {
    $id_item = $item['item']['id'];
    $type_item = get_post_type($id_item);
    $phi_bo_xung = 0;

    if ($type_item == 'tk-web') {
        $phi_duy_tri = 0;
        $phi_cai_dat = get_post_meta($id_item, 'gia_tien', true);
        $phi_cai_dat = (int) ensure_numb($phi_cai_dat);
        $phi_cai_dat = $phi_cai_dat * 1000000;
        $tong_tien = $item['item']['time'] * $phi_cai_dat * $item['item']['amount'] + $phi_duy_tri;
    } else {
        $phi_cai_dat = get_post_meta($id_item, 'phi_khoi_tao', true);
        $phi_cai_dat = $phi_cai_dat ? (int) ensure_numb($phi_cai_dat) : 0;
        $phi_duy_tri = get_phi_duy_tri($id_item, $item['item']['time']);

        if (!empty($item['attach'])) {
            foreach ($item['attach'] as $attach) {
                if ($attach['check'] !== 0) {
                    $phi_bo_xung += (int) $attach['price'];
                }
            }
        }

        $tong_tien = $item['item']['time'] * $phi_duy_tri * $item['item']['amount'] + $phi_cai_dat;
    }

    if ($item['item']['time'] < 0) {
        $tong_tien = $tong_tien * -1;
    }

    return array(
        'id' => $item['item']['id'],
        'name' => $item['item']['name'],
        'phi_khoi_tao' => $phi_cai_dat,
        'phi_duy_tri' => $phi_duy_tri,
        'thoi_han' => $item['item']['time'],
        'so_luong' => $item['item']['amount'],
        'phi_bo_xung' => $phi_bo_xung,
        'tong_tien' => $tong_tien
    );
}

function get_phi_duy_tri($id, $time) {
    $get_post_type = get_post_type($id);
    if ($get_post_type) {
        if ($get_post_type == 'ten-mien') {
//            return get_post_meta($id, 'phi_duy_tri', true);
            return get_field('phi_duy_tri', $id);
        } else {
            $list_gia_tien = get_field('gia_hang_thang', $id);
            if ($list_gia_tien && !empty($list_gia_tien)) {
                foreach ($list_gia_tien as $gia_tien) {
                    if (get_post_meta($gia_tien->ID, 'tinh_theo_thang', true) == $time) {
                        return ensure_numb(get_post_meta($gia_tien->ID, 'gia_tien_theo_thang', true));
                    }
                }
            }
        }
    }
    return 0;
}

function get_list_gia($id) {
    $result = array();
    $list_gia_tien = get_field('gia_hang_thang', $id);
    if ($list_gia_tien && !empty($list_gia_tien)) {
        foreach ($list_gia_tien as $gia_tien) {
            $time = get_post_meta($gia_tien->ID, 'tinh_theo_thang', true);
            $price = ensure_numb(get_post_meta($gia_tien->ID, 'gia_tien_theo_thang', true));
            $result[$time] = $price;
        }
    }
    return json_encode($result);
}

function get_list_time($id) {
    $result = array();
    $list_gia_tien = get_field('gia_hang_thang', $id);
    if ($list_gia_tien && !empty($list_gia_tien)) {
        foreach ($list_gia_tien as $gia_tien) {
            $result[$gia_tien->ID] = get_post_meta($gia_tien->ID, 'tinh_theo_thang', true);
//            $result[$gia_tien->ID] = get_post_meta($gia_tien->ID, 'thoi-han', true);
        }
    }
    return $result;
}

function get_list_gia_domain($id) {
    $result = array();
    $phi_dt = get_field('phi_duy_tri', $id);
    for($i = 1; $i <= 10; $i++){
        $result[$i] = $phi_dt * $i;
    }
    return json_encode($result);
}

function get_list_time_domain($id) {
    $result = array();
    $phi_dt = get_field('phi_duy_tri', $id);
    for($i = 1; $i <= 10; $i++){
        $result[$i] = $phi_dt * $i;
    }
    return $result;
}

function get_count_cart() {
    if (!isset($_SESSION['__dvmc_cart__']) || empty($_SESSION['__dvmc_cart__'])) {
        return 0;
    } else {
        $carts = $_SESSION['__dvmc_cart__'];
        $total = 0;
        foreach ($carts as $cart_item) {
            $total += count($cart_item);
        }
        return $total;
    }
}

function get_label_cart($key) {
    $label = array(
        'vps-cloud' => 'Cloud VPS',
        'cho-dat-data' => 'Chỗ đặt máy chủ',
        'server' => 'Thuê máy chủ',
        'may-chu-ao' => 'Máy chủ ảo',
        'hosting' => 'Hosting',
        'dich-vu-email' => 'Email',
        'tk-web' => 'Thiết kế Website',
        'phan-mem' => 'Phần mềm',
        'ten-mien' => 'Tên miền'
    );
    return isset($label[$key]) ? $label[$key] : '';
}

function render_cart_item($item) {
    $func = array(
        'vps-cloud' => '__render_item_cart_normal',
        'cho-dat-data' => '__render_item_cart_normal',
        'may-chu-ao' => '__render_item_cart_normal',
        'hosting' => '__render_item_cart_normal',
        'dich-vu-email' => '__render_item_cart_normal',
        'server' => '__render_item_cart_mn',
        'tk-web' => '__render_item_cart_web',
        'phan-mem' => '__render_item_cart_soft',
        'ten-mien' => '__render_item_cart_domain'
    );

    if (isset($func[$item['type']])) {
        return call_user_func($func[$item['type']], $item);
    }
}

function __render_item_cart_normal($item) {
    $ops = (isset($item['ops']) && !empty($item['ops'])) ? $item['ops'] : false;
    $phi_di_kem = 0;
    if ($ops) {
        foreach ($ops as $cop) {
            $phi_di_kem += get_post_meta($cop, 'gia_tien_thang', true);
        }
    }
    $list_time = get_list_time($item['id']);
    $phi_dt = ensure_numb(get_post_meta($item['price']['id'], 'gia_tien_theo_thang', true));
    $total = $item['amount'] * $item['price']['time'] * $phi_dt + $phi_di_kem;
    ?>
    <tr data-row="<?php echo $item['id']; ?>" data-type="<?php echo get_post_type($item['id']); ?>">
        <td><?php echo $item['name']; ?></td>
        <td>Miễn phí</td>
        <td><span id="result_phi_dt_<?php echo $item['id']; ?>"><?php echo number_format($phi_dt); ?></span> vnđ</td>
        <td>
            <select class="field_price_update" data-id='<?php echo $item['id']; ?>' data-pr-kt="0" data-price='<?php echo get_list_gia($item['id']); ?>' id="time_item_<?php echo $item['id']; ?>">
                <?php
                foreach ($list_time as $time_id => $current_time):
                    $selected = ($item['price']['time'] == $current_time) ? ' selected="selected"' : '';
                    ?>
                    <option name="item_cart_view" value="<?php echo $current_time; ?>" data-field-id="<?php echo $time_id; ?>"<?php echo $selected; ?>><?php echo $current_time; ?> tháng</option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <div class="amount_item">
                <span id="result_so_luong_<?php echo $item['id']; ?>"><?php echo $item['amount']; ?></span>
                <div class="amount_btn">
                    <a href="#" class="increase_item" data-id="<?php echo $item['id']; ?>" data-pr-kt="0">Thêm</a>
                    <a href="#" class="decrease_item" data-id="<?php echo $item['id']; ?>" data-pr-kt="0">Giảm</a>
                </div>
            </div>
        </td>
        <td><span id="tong_tien_<?php echo $item['id']; ?>"><?php echo number_format($total); ?></span> vnđ</td>
        <td>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" class="fr-update-item" id="fr_update_item_<?php echo $item['id']; ?>">
                <input type="hidden" name="cart_act" value="update_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_amount" id="ip_amount_<?php echo $item['id']; ?>" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Cập nhật">Update</button>
            </form>
        </td>
        <td>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" id="fr-delete-item">
                <input type="hidden" name="cart_act" value="delete_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="prod_amount" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Xóa">Delete</button>
            </form>
        </td>
    </tr>
    <?php if ($ops): ?>
        <tr class="group-name green">
            <td colspan="8">Dịch vụ đi kèm (<?php echo $item['name']; ?>)</td>
        </tr>
        <?php
        foreach ($ops as $current_op):
            $op_obj = get_post($current_op);
            if ($op_obj):
                $gia_tien_them = get_post_meta($op_obj->ID, 'gia_tien_thang', true);
                ?>

                <tr>
                    <td colspan="2"><?php echo $op_obj->post_title; ?></td>
                    <td colspan="3"><?php echo number_format($gia_tien_them); ?> vnđ</td>
                </tr>

                <?php
            endif;
        endforeach;
    endif;
    ?>

    <?php
    return $total;
}

function __render_item_cart_mn($item) {
    $ops = (isset($item['ops']) && !empty($item['ops'])) ? $item['ops'] : false;
    $phi_di_kem = 0;
    if ($ops) {
        foreach ($ops as $cop) {
            $phi_di_kem += get_post_meta($cop, 'gia_tien_thang', true);
        }
    }
    $list_time = get_list_time($item['id']);
    $phi_kt = ensure_numb(get_post_meta($item['id'], 'phi_khoi_tao', true));
    $phi_dt = ensure_numb(get_post_meta($item['price']['id'], 'gia_tien_theo_thang', true));
    $total = $item['amount'] * $item['price']['time'] * $phi_dt + $phi_kt + $phi_di_kem;
    ?>
    <tr>
        <td><?php echo $item['name']; ?></td>
        <td><?php echo number_format($phi_kt); ?> vnđ</td>
        <td><span id="result_phi_dt_<?php echo $item['id']; ?>"><?php echo number_format($phi_dt); ?></span> vnđ</td>
        <td>
            <select class="field_price_update" data-id='<?php echo $item['id']; ?>' data-pr-kt="<?php echo $phi_kt; ?>" data-price='<?php echo get_list_gia($item['id']); ?>' id="time_item_<?php echo $item['id']; ?>">
                <?php
                foreach ($list_time as $time_id => $current_time):
                    $selected = ($item['price']['time'] == $current_time) ? ' selected="selected"' : '';
                    ?>
                    <option name="item_cart_view" value="<?php echo $current_time; ?>" data-field-id="<?php echo $time_id; ?>"<?php echo $selected; ?>><?php echo $current_time; ?> tháng</option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <div class="amount_item">
                <span id="result_so_luong_<?php echo $item['id']; ?>"><?php echo $item['amount']; ?></span>
                <div class="amount_btn">
                    <a href="#" class="increase_item" data-id="<?php echo $item['id']; ?>" data-pr-kt="<?php echo $phi_kt; ?>">Thêm</a>
                    <a href="#" class="decrease_item" data-id="<?php echo $item['id']; ?>" data-pr-kt="<?php echo $phi_kt; ?>">Giảm</a>
                </div>
            </div>
        </td>
        <td><span id="tong_tien_<?php echo $item['id']; ?>"><?php echo number_format($total); ?></span> vnđ</td>
        <td>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" class="fr-update-item" id="fr_update_item_<?php echo $item['id']; ?>">
                <input type="hidden" name="cart_act" value="update_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_amount" id="ip_amount_<?php echo $item['id']; ?>" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Cập nhật">Update</button>
            </form>
        </td>
        <td>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" id="fr-delete-item">
                <input type="hidden" name="cart_act" value="delete_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="prod_amount" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Xóa">Delete</button>
            </form>
        </td>
    </tr>
    <?php if ($ops): ?>
        <tr class="group-name green">
            <td colspan="8">Dịch vụ đi kèm (<?php echo $item['name']; ?>)</td>
        </tr>
        <?php
        foreach ($ops as $current_op):
            $op_obj = get_post($current_op);
            if ($op_obj):
                $gia_tien_them = get_post_meta($op_obj->ID, 'gia_tien_thang', true);
                ?>

                <tr>
                    <td colspan="2"><?php echo $op_obj->post_title; ?></td>
                    <td colspan="3"><?php echo number_format($gia_tien_them); ?> vnđ</td>
                </tr>

                <?php
            endif;
        endforeach;
    endif;
    ?>
    <?php
    return $total;
}

function __render_item_cart_web($item) {
    $ops = (isset($item['ops']) && !empty($item['ops'])) ? $item['ops'] : false;
    $phi_di_kem = 0;
    if ($ops) {
        foreach ($ops as $cop) {
            $phi_di_kem += get_post_meta($cop, 'gia_tien_thang', true);
        }
    }
    $gia_tien = (int) ensure_numb(get_post_meta($item['id'], 'gia_tien', true));
    $can_set_amount = true;
    if (!is_numeric($gia_tien) || $gia_tien == 0) {
        $can_set_amount = false;
        $total = 'Thỏa thuận';
        $price_show = 0;
        $result = 0;
    } else {
        $price_show = $item['amount'] * $gia_tien;
        $total = number_format($price_show + $phi_di_kem) . ' vnđ';
        $result = $price_show + $phi_di_kem;
    }
    ?>
    <tr>
        <td><?php echo $item['name']; ?></td>
        <td>Miễn phí</td>
        <td>Miễn phí</td>
        <td>Vĩnh viễn</td>
        <td>
            <div class="amount_item">
                <span id="result_so_luong_<?php echo $item['id']; ?>"><?php echo $item['amount']; ?></span>

                <?php if ($can_set_amount): ?>

                    <div class="amount_btn">
                        <a href="#" class="increase_item_web" data-id="<?php echo $item['id']; ?>" data-price="<?php echo $price_show; ?>">Thêm</a>
                        <a href="#" style="background-position-y: 0px;" class="decrease_item_web" data-id="<?php echo $item['id']; ?>" data-price="<?php echo $price_show; ?>">Giảm</a>
                    </div>

                <?php endif; ?>

            </div>
        </td>
        <td><span id="tong_tien_<?php echo $item['id']; ?>"><?php echo $total; ?></span></td>
        <td>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" class="fr-update-item" id="fr_update_item_<?php echo $item['id']; ?>">
                <input type="hidden" name="cart_act" value="update_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_amount" id="ip_amount_<?php echo $item['id']; ?>" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Cập nhật">Update</button>
            </form>
        </td>
        <td>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" id="fr-delete-item">
                <input type="hidden" name="cart_act" value="delete_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="prod_amount" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Xóa">Delete</button>
            </form>
        </td>
    </tr>
    <?php if ($ops): ?>
        <tr class="group-name green">
            <td colspan="8">Dịch vụ đi kèm (<?php echo $item['name']; ?>)</td>
        </tr>
        <?php
        foreach ($ops as $current_op):
            $op_obj = get_post($current_op);
            if ($op_obj):
                $gia_tien_them = get_post_meta($op_obj->ID, 'gia_tien_thang', true);
                ?>

                <tr>
                    <td colspan="2"><?php echo $op_obj->post_title; ?></td>
                    <td colspan="3"><?php echo number_format($gia_tien_them); ?> vnđ</td>
                </tr>

                <?php
            endif;
        endforeach;
    endif;
    ?>
    <?php
    return $result;
}

function __render_item_cart_soft($item) {
    $loai_bang_gia = get_post_meta($item['id'], 'loai_bang_gia_sl', true);
    if ($loai_bang_gia == 'tuychon') {
        __render_cart_soft_adv($item);
    } elseif ($loai_bang_gia == 'thuong') {
        __render_cart_soft_normal($item);
    }
}

function __render_cart_soft_adv($item) {
    $ten_goi = get_post_meta($item['price']['id'], 'ten_gia_pm', true);
    $gia_goi = get_post_meta($item['price']['id'], $item['price']['type_gia'], true);
    ?>
    <tr>
        <td colspan="2"><?php echo $item['name']; ?></td>
        <td colspan="4"><?php echo $ten_goi ?> - <?php echo number_format(ensure_numb($gia_goi)); ?> vnđ</td>
        <td colspan="2">
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" id="fr-delete-item">
                <input type="hidden" name="cart_act" value="delete_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="prod_amount" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Xóa">Delete</button>
            </form>
        </td>
    </tr>
    <?php
}

function __render_cart_soft_normal($item) {
    $gia_tien = get_post_meta($item['id'], 'gia_thuong', true);
    $gia_tien = $gia_tien ? number_format($gia_tien) : 0;
    $ky_tu_kem_theo = get_post_meta($item['id'], 'ky_tu_kem_theo', true);
    $ky_tu_kem_theo = $ky_tu_kem_theo ? : 'vnđ';
    $thanh_tien = $gia_tien . ' ' . $ky_tu_kem_theo;
    ?>
    <tr>
        <td colspan="2"><?php echo $item['name']; ?></td>
        <td colspan="4"><?php echo $thanh_tien ?></td>
        <td colspan="2">
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" id="fr-delete-item">
                <input type="hidden" name="cart_act" value="delete_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="prod_amount" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Xóa">Delete</button>
            </form>
        </td>
    </tr>
    <?php
}

function __render_item_cart_domain($item) {
    $total = (int) ensure_numb($item['price']['kt']) + (int) ensure_numb($item['price']['dt']) * $item['price']['time'];
    $phi_kt = (int) $item['price']['kt'] == 0 ? 'Miễn phí' : number_format((int) $item['price']['kt']) . ' vnđ';
    $list_time = get_list_time_domain($item['id']);
    ?>
    <tr data-row="<?php echo $item['id']; ?>" data-type="ten-mien">
        <td><?php echo $item['name']; ?></td>
        <td><?php echo $phi_kt; ?></td>
        <td><span id="result_phi_dt_<?php echo $item['id']; ?>"><?php echo number_format($item['price']['dt']); ?></span> vnđ</td>
        <td>
            <select class="field_price_update" data-id='<?php echo $item['id']; ?>' data-pr-kt="0" data-price='<?php echo get_list_gia_domain($item['id']); ?>' id="time_item_<?php echo $item['id']; ?>">
                <?php
                foreach ($list_time as $time_id => $current_time):
                    $selected = ($item['price']['time'] == $time_id) ? ' selected="selected"' : '';
                    ?>
                    <option name="item_cart_view" value="<?php echo $time_id; ?>" data-field-id="<?php echo $item['id']; ?>"<?php echo $selected; ?>><?php echo $time_id; ?> năm</option>
                <?php endforeach; ?>
            </select>
        </td>
        <td>
            <div class="amount_item">
                <span id="result_so_luong_<?php echo $item['id']; ?>"><?php echo $item['amount']; ?></span>
            </div>
        </td>
        <td><span id="tong_tien_<?php echo $item['id']; ?>"><?php echo number_format(ensure_numb($total)); ?></span> vnđ</td>
        <td>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" class="fr-update-item" id="fr_update_item_<?php echo $item['id']; ?>">
                <input type="hidden" name="cart_act" value="update_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['id']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_amount" id="ip_amount_<?php echo $item['id']; ?>" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value='<?php echo json_encode($item['price']); ?>'/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Cập nhật">Update</button>
            </form>
        </td>
        <td>
            <form action="<?php bloginfo('url'); ?>/___order_cart_act" method="POST" id="fr-delete-item">
                <input type="hidden" name="cart_act" value="delete_item"/>
                <input type="hidden" name="prod_id" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="prod_type" value="<?php echo $item['type']; ?>"/>
                <input type="hidden" name="prod_price" id="ip_time_rs_<?php echo $item['id']; ?>" value="<?php echo json_encode($item['price']); ?>"/>
                <input type="hidden" name="prod_amount" value="<?php echo $item['amount']; ?>"/>
                <input type="hidden" name="prod_name" value="<?php echo $item['name']; ?>"/>
                <input type="hidden" name="ref_url" value="<?php echo get_bloginfo('url'); ?>/gio-hang"/>
                <button type="submit" title="Xóa">Delete</button>
            </form>
        </td>
    </tr>
    <?php
    return $total;
}

function get_gia_sp($id, $type) {
    if ($type == 'tk-web') {
        $price = (int) get_post_meta($id, 'gia_tien', true);
        return $price * 1000000;
    } elseif ($type == 'phan-mem') {
        
    } else {
        
    }
}
