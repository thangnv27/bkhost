<?php

return array(
    'plugins' => array(
        array(
            'src' => 'dynamic-featured-image/dynamic-featured-image.php',
            'name' => 'Dynamic Featured Image',
            'link' => 'https://wordpress.org/plugins/dynamic-featured-image/'
        ),
        array(
            'src' => 'regenerate-thumbnails/regenerate-thumbnails.php',
            'name' => 'Regenerate Thumbnails',
            'link' => 'https://wordpress.org/plugins/regenerate-thumbnails/'
        )
    ),
    'theme_media' => array(
        'js' => array(
            array('all', '1.2.9')
        )
    ),
    'admin_media' => array(
        'css' => array(
            array('admin-main', 1.6)
        ),
        'js' => array(
            array('admin-all', 1.0)
        )
    ),
    'admin_options' => array(
        array(
            'name' => 'Header',
            'title' => 'Header Settings',
            'slug' => 'header_settings',
            'src' => 'header.php',
            'fnc' => 'dp_setup_theme_page_header'
        ),
        array(
            'name' => 'Header',
            'title' => 'Header Settings',
            'slug' => 'header_settings',
            'src' => 'header.php',
            'fnc' => 'dp_setup_theme_page_header'
        )
    ),
    'images_size' => array(
        array('thumb-cat', 222, 137, true),
        array('smail_software', 105, 44, true)
    )
        //'custom_posts' => array('hosting', 'domain', 'server')
);
