<?php

function domain_post_type() {
    
    $label = array(
        'name' => 'Tên miền',
        'singular_name' => 'Tên miền'
    );
    
    $args = array(
        'labels' => $label,
        'description' => 'Thêm/Sửa/Xóa/Cập nhật Tên miền',
        'supports' => array(
            'title',
            'editor',
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
    
    register_post_type('ten-mien' , $args);
}

function add_domain_metabox() {
    add_meta_box("credits_meta_domain", "Thông tin Tên miền", "credits_meta_domain", "ten-mien", "normal", "low");
}

function credits_meta_domain() {
    require_once(get_template_directory() . '/protected/views/domain.php');
}

add_action('init', 'domain_post_type');
add_action('admin_init', 'add_domain_metabox');