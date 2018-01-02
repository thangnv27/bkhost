<?php

/*
  Template Name: Add to Cart Page
 */

$check = false;

if (isset($_POST['prod_id']) && isset($_POST['prod_type']) && isset($_POST['prod_price']) && isset($_POST['prod_amount']) && isset($_POST['prod_name']) && isset($_POST['ref_url'])) {

    $prod_id = (int) $_POST['prod_id'];
    $post_type = $_POST['prod_type'];
    $prod_price = $_POST['prod_price'];
    $ref_url = $_POST['ref_url'];
    $prod_amount = $_POST['prod_amount'];
    $prod_name = $_POST['prod_name'];

    $prod = get_post($prod_id);
    $price = ($post_type == 'tk-web') ? ensure_numb(get_post_meta($prod_id, 'gia_tien', 'true')) : get_post($prod_price);
    if ($prod && $price) {
        if ($prod->post_type == $post_type) {
            $check = true;
            $list_more = isset($_POST['list_ops']) ? (array) $_POST['list_ops'] : array();
        }
    }
}

if (!$check) {
    wp_redirect(get_bloginfo('url'));
    return;
}

if (!isset($_SESSION['__dvmc_cart__'][$post_type][$prod_id])) {
    if (!isset($_SESSION['__dvmc_cart__'])) {
        $_SESSION['__dvmc_cart__'] = array();
    }
    $price_save = array();
    if($post_type == "ten-mien"){
        $price_save['kt'] = intval(get_field('phi_khoi_tao', $prod_id));
        $price_save['dt'] = intval(get_field('phi_duy_tri', $prod_id));
        $price_save['id'] = $prod_id;
        $price_save['time'] = 1;
    } elseif($post_type == "tk-web"){
        $price_save['id'] = $prod_id;
        $price_save['time'] = 'Vĩnh viễn';
    } else {
        $price_save['id'] = $prod_price;
        $price_save['time'] = get_post_meta($prod_price, 'tinh_theo_thang', true);
    }

    if (isset($_POST['prod_ext']) && ($post_type == 'phan-mem')) {
        if (($_POST['prod_ext'] == 'gia_internal') || ($_POST['prod_ext'] == 'gia_external')) {
            $price_save['type_gia'] = $_POST['prod_ext'];
        }
    }
    
    $ops = (isset($_POST['list_ops']) && is_array($_POST['list_ops'])) ? $_POST['list_ops'] : array();

    $_SESSION['__dvmc_cart__'][$post_type][$prod_id] = array(
        'id' => $prod_id,
        'name' => $prod_name,
        'type' => $post_type,
        'amount' => $prod_amount,
        'price' => $price_save,
        'ops' => $ops
    );
}

wp_redirect($ref_url);
return;
