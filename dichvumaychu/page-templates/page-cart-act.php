<?php

/*
 * Template Name: Act Cart
 */

$check = false;

if (isset($_POST['prod_id']) && isset($_POST['cart_act']) && isset($_POST['prod_type']) && isset($_POST['prod_price']) && isset($_POST['prod_amount']) && isset($_POST['prod_name']) && isset($_POST['ref_url'])) {

    $cart_act = $_POST['cart_act'];
    $list_act = array('update_item', 'delete_item', 'remove_all');

    if (in_array($cart_act, $list_act)) {
        $post_type = $_POST['prod_type'];
        $prod_id = ($post_type !== 'ten-mien') ? (int) $_POST['prod_id'] : $_POST['prod_id'];
        $prod_price = $_POST['prod_price'];
        $ref_url = $_POST['ref_url'];
        $prod_amount = $_POST['prod_amount'];
        $prod_name = $_POST['prod_name'];

        if ($cart_act == 'remove_all') {
            $check = true;
            $_SESSION['__dvmc_cart__'] = array();
            wp_redirect($ref_url);
            return;
        } elseif ($cart_act == 'update_item') {
            if (isset($_SESSION['__dvmc_cart__'][$post_type][$prod_id])) {
                $check = true;
                $prod_price = str_replace('\\', '', $prod_price);
                $_SESSION['__dvmc_cart__'][$post_type][$prod_id] = array(
                    'id' => $prod_id,
                    'name' => $prod_name,
                    'type' => $post_type,
                    'amount' => $prod_amount,
                    'price' => json_decode($prod_price, true)
                );
                wp_redirect($ref_url);
                return;
            }
        } elseif ($cart_act == 'delete_item') {
            if (isset($_SESSION['__dvmc_cart__'][$post_type][$prod_id])) {
                $check = true;
                unset($_SESSION['__dvmc_cart__'][$post_type][$prod_id]);
                wp_redirect($ref_url);
                return;
            }
        }
    }
}

if (!$check) {
    wp_redirect(get_bloginfo('url'));
    return;
}
