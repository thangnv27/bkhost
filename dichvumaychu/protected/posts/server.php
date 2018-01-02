<?php

function server_post_type() {
    
    $label = array(
        'name' => 'Máy chủ',
        'singular_name' => 'Máy chủ'
    );
    
    $args = array(
        'labels' => $label,
        'description' => 'Thêm/Sửa/Xóa/Cập nhật Máy chủ',
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'taxonomies' => array(),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'show_in_nav_menus' => true,
        'show_in_admin_bar' => true,
        'menu_position' => 5,
        'menu_icon' => '',
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post'
    );
    
    register_post_type('server' , $args);
}

function add_server_metabox() {
    add_meta_box("credits_meta_server", "Thông tin Máy chủ", "credits_meta_server", "server", "normal", "low");
}

function credits_meta_server() {
    require_once(get_template_directory() . '/protected/views/server.php');
}

function process_server() {
    if (isset($_POST['process_server'])) {
        global $post;
        
        $save_cpu = (isset($_POST['cpu'])) ? $_POST['cpu'] : '';
        $save_ram = (isset($_POST['ram'])) ? $_POST['ram'] : '';
        $save_hdd = (isset($_POST['hdd'])) ? $_POST['hdd'] : '';
        $save_port = (isset($_POST['port'])) ? $_POST['port'] : '';
        $save_bang_thong = (isset($_POST['bang_thong'])) ? $_POST['bang_thong'] : '';
        $save_phi_khoi_tao = (isset($_POST['phi_khoi_tao'])) ? $_POST['phi_khoi_tao'] : '';
        $save_data_center = (isset($_POST['data_center'])) ? $_POST['data_center'] : '';
        $save_server_price = (isset($_POST['server_price'])) ? (int)$_POST['server_price'] : '';
        
        update_post_meta($post->ID, "cpu", $save_cpu);
        update_post_meta($post->ID, "ram", $save_ram);
        update_post_meta($post->ID, "hdd", $save_hdd);
        update_post_meta($post->ID, "port", $save_port);
        update_post_meta($post->ID, "bang_thong", $save_bang_thong);
        update_post_meta($post->ID, "phi_khoi_tao", $save_phi_khoi_tao);
        update_post_meta($post->ID, "data_center", $save_data_center);
        update_post_meta($post->ID, "server_price", $save_server_price);
    }
}

add_action('init', 'server_post_type');
add_action('admin_init', 'add_server_metabox');
add_action('save_post', 'process_server', 1, 2);