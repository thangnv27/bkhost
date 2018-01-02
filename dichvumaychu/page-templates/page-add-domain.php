<?php

/*
 * Template Name: Add Domain
 */

if (!isset($_POST['prod_has_choice']) && (!is_array($_POST['prod_has_choice']))) {
    wp_redirect(get_bloginfo('url') . '/gio-hang');
    return;
} else {
    if (!isset($_POST['save_domain']) && (!is_array($_POST['save_domain']))) {
        wp_redirect(get_bloginfo('url') . '/gio-hang');
        return;
    } else {
        $list_domain_all = $_POST['save_domain'];
        $list_domain_choice = $_POST['prod_has_choice'];
        foreach ($list_domain_all as $domain_name => $domain_info) {
            if (in_array($domain_name, $list_domain_choice)) {
                __add_domain_to_cart($domain_name, $domain_info);
            }
        }
    }
}

wp_redirect(get_bloginfo('url') . '/gio-hang');
return;

function __add_domain_to_cart($name, $info) {
    $post_type = 'ten-mien';
    $prod_amount = 1;
    $ref_url = get_bloginfo('url') . '/gio-hang';

    if (isset($info['prod_id']) && isset($info['prod_price'])) {
        $prod_id = (int) $info['prod_id'];
        $prod = get_post($prod_id);
        if ($prod->post_type == $post_type) {
            if (!isset($_SESSION['__dvmc_cart__'][$post_type][$name])) {
                if (!isset($_SESSION['__dvmc_cart__'])) {
                    $_SESSION['__dvmc_cart__'] = array();
                }

                $prod_price = $info['prod_price'];
                $price_save = array();
                $tmp_price = json_decode(str_replace("\\", "", $prod_price), true);
                $price_save['kt'] = $tmp_price[0];
                $price_save['dt'] = $tmp_price[1];

                $_SESSION['__dvmc_cart__'][$post_type][$name] = array(
                    'id' => $prod_id,
                    'name' => $name,
                    'type' => $post_type,
                    'amount' => $prod_amount,
                    'price' => $price_save
                );
            }
        }
    }
}
