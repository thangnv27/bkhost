<?php

/*
  Template Name: API Process
 */

header('Content-Type: application/json');

if (!is_ajax() || !isset($_POST['controller'])) {
    wp_redirect(get_bloginfo('url'));
    return;
}

if (function_exists($process = 'process_' . $_POST['controller'])) {
    return call_user_func_array($process, array());
}

function process_view_whois() {
    if (!isset($_POST['data_domain'])) {
        echo json_encode(array('status' => false));
    } else {
        echo json_encode(array(
            'status' => true,
            'whois' => domain_get_whois($_POST['data_domain'])
        ));
    }
}

//3: Them sp lan dau thanh cong
//2: Cap nhat thong tin da co o gio hang
//1: Hien len bang cap nhat

function process_add_cart() {
    $result_json = array('status' => false);
    if (isset($_POST['data_id'])) {
        $data_id = (int) $_POST['data_id'];
        if (isset($_POST['data_id'])) {
            $data_time = (int) $_POST['data_time'];
            if ($data_id < 0) {
                $data_time = false;
            }
        } else {
            $data_time = false;
        }
        $current_item = get_posts(array(
            'post_type' => array('tk-web', 'server', 'cho-dat-data', 'hosting', 'ten-mien', 'vps-cloud', 'may-chu-ao', 'dich-vu-email'),
            'posts_per_page' => 1,
            'post__in' => array($data_id)
        ));

        if (!empty($current_item)) {
            $current_item = $current_item[0];

            if (isset($_SESSION['__dvmc_cart__'][$current_item->ID])) {
                $data_save = $_SESSION['__dvmc_cart__'][$current_item->ID];
                $type_result = empty($data_save['attach']) ? 2 : 1;
                $data_save['item']['time'] = $data_time;
                $result_json = array(
                    'status' => true,
                    'type' => $type_result,
                    'data' => $data_save
                );
                $_SESSION['__dvmc_cart__'][$current_item->ID] = $result_json['data'];
            } else {
                if (!isset($_SESSION['__dvmc_cart__'])) {
                    $_SESSION['__dvmc_cart__'] = array();
                }
                if (isset($_POST['content_type'])) {
                    if ($_POST['content_type'] == 'cart_only') {
                        $content_type = 3;
                    } elseif ($_POST['content_type'] == 'update_cart') {
                        $content_type = 1;
                    } else {
                        $content_type = 2;
                    }
                } else {
                    $content_type = 2;
                }

                $data_attach = (isset($_POST['data_attach']) && ($_POST['data_attach'] !== 'no_attach')) ? $_POST['data_attach'] : 'no_attach';
                $data_attach = explode('-', $data_attach);

                if (empty($data_attach) || $data_attach[0] == 'no_attach') {
                    if ($content_type == 'cart_only') {
                        echo json_encode(array('status' => false));
                    } else {
                        $result_json = array(
                            'status' => true,
                            'type' => $content_type,
                            'data' => array(
                                'item' => array(
                                    'id' => $current_item->ID,
                                    'name' => $current_item->post_title,
                                    'time' => $data_time,
                                    'amount' => 1,
                                    'has_attach' => 0,
                                    'has_amount' => 1
                                ),
                                'attach' => array()
                            )
                        );
                        $_SESSION['__dvmc_cart__'][$current_item->ID] = $result_json['data'];
                    }
                } else {
                    $list_attach = get_posts(array(
                        'post_type' => 'thong-tin-bo-xung',
                        'posts_per_page' => -1,
                        'post__in' => $data_attach
                    ));

                    if (!empty($list_attach)) {

                        $result_attach = array();

                        foreach ($list_attach as $attach_item) {
                            $result_attach[$attach_item->ID] = array(
                                'name' => $attach_item->post_title,
                                'price' => get_post_meta($attach_item->ID, 'gia_tien_thang', true),
                                'check' => 0
                            );
                        }

                        $result_json = array(
                            'status' => true,
                            'type' => $content_type,
                            'data' => array(
                                'item' => array(
                                    'id' => $current_item->ID,
                                    'name' => $current_item->post_title,
                                    'time' => $data_time,
                                    'amount' => 1,
                                    'has_attach' => 1,
                                    'has_amount' => 1
                                ),
                                'attach' => $result_attach
                            )
                        );
                        $_SESSION['__dvmc_cart__'][$current_item->ID] = $result_json['data'];
                    } else {
                        $result_json = array(
                            'status' => true,
                            'type' => 2,
                            'data' => array(
                                'item' => array(
                                    'id' => $current_item->ID,
                                    'name' => $current_item->post_title,
                                    'time' => $data_time,
                                    'amount' => 1,
                                    'has_attach' => 1,
                                    'has_amount' => 1
                                ),
                                'attach' => array()
                            )
                        );
                        $_SESSION['__dvmc_cart__'][$current_item->ID] = $result_json['data'];
                    }
                }
            }
        }
    }
    $result_json['count_total'] = is_array($_SESSION['__dvmc_cart__']) ? count($_SESSION['__dvmc_cart__']) : 0;
    echo json_encode($result_json);
    die();
}

function process_update_opt_cart() {
    $result_json = array('status' => false);
    $cart = $_SESSION['__dvmc_cart__'];

    if (isset($_POST['data_id']) && isset($cart[$_POST['data_id']]) && isset($_POST['data_update'])) {
        $data_id = $_POST['data_id'];
        $data_update = explode(',', $_POST['data_update']);

        foreach ($data_update as $update_str) {
            $tmp_arr = explode('-', $update_str);
            $cart[$data_id]['attach'][$tmp_arr[0]]['check'] = (int) $tmp_arr[1];
        }

        $_SESSION['__dvmc_cart__'] = $cart;

        $result_json = array(
            'status' => true,
            'type' => 2,
            'data' => $cart[$data_id]
        );
    }

    echo json_encode($result_json);
    die();
}

function process_remove_item_cart() {
    $result_json = array('status' => false);
    $data_type = (isset($_POST['data_type']) && ($_POST['data_type'] == 'single')) ? 'single' : 'all';

    if ($data_type == 'all') {
        unset($_SESSION['__dvmc_cart__']);
        $result_json['status'] = true;
        $result_json['count_total'] = 0;
    } else {
        if (isset($_POST['data_id'])) {
            $data_id = (int) $_POST['data_id'];
            $cart = $_SESSION['__dvmc_cart__'];
            if (isset($_SESSION['__dvmc_cart__'][$data_id])) {
                unset($_SESSION['__dvmc_cart__'][$data_id]);
                $result_json['status'] = true;
                $result_json['count_total'] = is_array($_SESSION['__dvmc_cart__']) ? count($_SESSION['__dvmc_cart__']) : 0;
            }
        }
    }

    echo json_encode($result_json);
    die();
}

function process_refresh_cart() {
    $result_json = array('status' => false);
    $data_update = (isset($_POST['data_rf'])) ? $_POST['data_rf'] : 0;
    if ($data_update !== 0) {
        $data_update = str_replace('\\', '', $data_update);
        $data_update = json_decode($data_update, true);

        if (count($data_update) > 0) {
            $cart = $_SESSION['__dvmc_cart__'];
            foreach ($data_update as $id_data => $data) {
                if (isset($cart[$id_data])) {
                    $cart[$id_data]['item'] = array_merge($cart[$id_data]['item'], $data['item']);
                }
            }
            $_SESSION['__dvmc_cart__'] = $cart;
        }
        $result_json['status'] = true;
    }


    echo json_encode($result_json);
    die();
}

function process_add_list_cart() {
    $result_json = array('status' => false);
    if (isset($_POST['data_add'])) {
        $data_add = str_replace('\\', '', $_POST['data_add']);
        $data_add = json_decode($data_add, true);

        if (count($data_add) > 0) {
            if (!isset($_SESSION['__dvmc_cart__'])) {
                $_SESSION['__dvmc_cart__'] = array();
            }

            foreach ($data_add as $id_data => $data) {
                $result_json = array(
                    'status' => true,
                    'type' => 2,
                    'data' => array(
                        'item' => array(
                            'id' => $id_data,
                            'name' => $data['name'],
                            'time' => $data['time'],
                            'amount' => 1,
                            'has_attach' => 0,
                            'has_amount' => 0
                        ),
                        'attach' => array()
                    )
                );
                $_SESSION['__dvmc_cart__'][$id_data] = $result_json['data'];
            }
        }
    }
    $result_json['count_total'] = is_array($_SESSION['__dvmc_cart__']) ? count($_SESSION['__dvmc_cart__']) : 0;
    echo json_encode($result_json);
    die();
}

?>