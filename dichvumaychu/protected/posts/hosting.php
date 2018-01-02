<?php

function hosting_post_type() {
    
    $label = array(
        'name' => 'Hosting',
        'singular_name' => 'Hosting'
    );
    
    $args = array(
        'labels' => $label,
        'description' => 'Thêm/Sửa/Xóa/Cập nhật Hosting',
        'supports' => array(
            'title',
            'thumbnail'
        ),
        'taxonomies' => array('category'),
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
    
    register_post_type('hosting' , $args);
}

function add_hosting_metabox() {
    add_meta_box("credits_meta_hosting", "Thông tin Hosting", "credits_meta_hosting", "hosting", "normal", "low");
}

function credits_meta_hosting() {
    require_once(get_template_directory() . '/protected/views/hosting.php');
}

function process_hosting() {
    if (isset($_POST['process_hosting'])) {
        global $post;
        
        $save_disk_space = (isset($_POST['disk_space'])) ? $_POST['disk_space'] : '';
        $save_bandwidth = (isset($_POST['bandwidth'])) ? $_POST['bandwidth'] : '';
        $save_addon_domain = (isset($_POST['addon_domain'])) ? $_POST['addon_domain'] : '';
        $save_parked_domain = (isset($_POST['parked_domain'])) ? $_POST['parked_domain'] : '';
        $save_sub_domain = (isset($_POST['sub_domain'])) ? $_POST['sub_domain'] : '';
        $save_mssql_account = (isset($_POST['mssql_account'])) ? $_POST['mssql_account'] : '';
        $save_plesk_control = (isset($_POST['plesk_control'])) ? (bool)$_POST['plesk_control'] : '';
        $save_hosting_price = (isset($_POST['hosting_price'])) ? (int)$_POST['hosting_price'] : '';
        
        update_post_meta($post->ID, "disk_space", $save_disk_space);
        update_post_meta($post->ID, "bandwidth", $save_bandwidth);
        update_post_meta($post->ID, "addon_domain", $save_addon_domain);
        update_post_meta($post->ID, "parked_domain", $save_parked_domain);
        update_post_meta($post->ID, "sub_domain", $save_sub_domain);
        update_post_meta($post->ID, "mssql_account", $save_mssql_account);
        update_post_meta($post->ID, "plesk_control", $save_plesk_control);
        update_post_meta($post->ID, "hosting_price", $save_hosting_price);
    }
}

add_action('init', 'hosting_post_type');
add_action('admin_init', 'add_hosting_metabox');
add_action('save_post', 'process_hosting', 1, 2);