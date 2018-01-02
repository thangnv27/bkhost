<?php

    function dp_setup_theme_options() {
        
        $theme_config = DP_Theme::get_config();
        
        if (isset($theme_config['admin_media']) && !empty($theme_config['admin_media'])) {
            if (isset($theme_config['admin_media']['css']) && !empty($theme_config['admin_media']['css'])) {
                foreach ($theme_config['admin_media']['css'] as $media_key => $media_value) {
                    wp_enqueue_style('dp-theme-'.$media_key, get_template_directory_uri() . '/assets/css/'.$media_value[0].'.css', array(), $media_value[1]);
                }
            }
            if (isset($theme_config['admin_media']['js']) && !empty($theme_config['admin_media']['js'])) {
                foreach ($theme_config['admin_media']['js'] as $media_key => $media_value) {
                    wp_enqueue_script('dp-theme-'.$media_key, get_template_directory_uri() . '/assets/js/'.$media_value[0].'.js', array(), $media_value[1]);
                }
            }
        }
        
        add_menu_page('General Theme Settings', 'Theme Settings', 'manage_options', 'theme_settings', 'dp_setup_theme_page');
        add_submenu_page('theme_settings', 'Header Settings', 'Header', 'manage_options', 'header_settings', 'dp_setup_theme_page_header');
        add_submenu_page('theme_settings', 'Colors & Fonts Settings', 'Colors & Fonts', 'manage_options', 'colors_fonts_settings', 'dp_setup_theme_page_color_font');
        add_submenu_page('theme_settings', 'Footer Settings', 'Footer', 'manage_options', 'footer_settings', 'dp_setup_theme_page_footer');
        add_submenu_page('theme_settings', 'Custom CSS & Javascript', 'Custom', 'manage_options', 'custom_settings', 'dp_setup_theme_page_custom');
        add_submenu_page('theme_settings', 'Supports', 'Supports', 'manage_options', 'supports_settings', 'dp_setup_theme_page_supports');
    }
    
    add_action("admin_menu", "dp_setup_theme_options");
    
    function dp_setup_theme_page() {
        require_once(get_template_directory().'/protected/options/general.php');
        echo dp_option_submit();
    }
    
    function dp_setup_theme_page_header() {
        require_once(get_template_directory().'/protected/options/header.php');
        echo dp_option_submit();
    }
    
    function dp_setup_theme_page_color_font() {
        require_once(get_template_directory().'/protected/options/colors-fonts.php');
        echo dp_option_submit();
    }
    
    function dp_setup_theme_page_footer() {
        require_once(get_template_directory().'/protected/options/footer.php');
        echo dp_option_submit();
    }
    
    function dp_setup_theme_page_custom() {
        require_once(get_template_directory().'/protected/options/custom.php');
        echo dp_option_submit();
    }
    
    function dp_setup_theme_page_supports() {
        require_once(get_template_directory().'/protected/options/supports.php');
        echo dp_option_submit();
    }
    
?>