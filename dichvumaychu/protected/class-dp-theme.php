<?php

class DP_Theme
{
    private $theme_config;
    private static $theme_config_stt;
    
    public function __construct(array $config = array())
    {
        $this->theme_config = $config;
        self::$theme_config_stt = $config;
        require_once(get_template_directory().'/protected/theme-functions.php');
        require_once(get_template_directory().'/protected/tools.php');
    }
    
    public function theme_init()
    {
        remove_action('wp_head', 'rsd_link');
    	remove_action('wp_head', 'wlwmanifest_link');
        add_rewrite_rule('^cho-dat-may-chu/xem/([^/]*)/?', 'index.php?pagename=cho-dat-may-chu&view_tab=$matches[1]', 'top');
        add_rewrite_rule('^cloud/xem/([^/]*)/?', 'index.php?pagename=cloud&view_tab=$matches[1]', 'top');
        add_rewrite_rule('^thue-may-chu/hang/([^/]*)/?', 'index.php?pagename=thue-may-chu&view_tab=$matches[1]', 'top');
        add_rewrite_rule('^hosting/hdh/([^/]*)/?', 'index.php?pagename=hosting&view_tab=$matches[1]', 'top');
        add_rewrite_rule('^may-chu-ao-vps/may-chu/([^/]*)/?', 'index.php?pagename=may-chu-ao-vps&view_tab=$matches[1]', 'top');
//        add_rewrite_rule('^dich-vu-email/dich-vu/([^/]*)/?', 'index.php?pagename=dich-vu-email&view_tab=$matches[1]', 'top');
        add_rewrite_rule('^email/([^/]*).html/?', 'index.php?pagename=dich-vu-email&view_tab=$matches[1]', 'top');
        add_rewrite_tag('%view_tab%', '([^&]+)');
        
        register_nav_menus(array(
            'main-nav' => __('Menu Chính'),
            'menu-footer' => __('Menu Footer'),
            'menu-top' => __('Menu Top'),
            'menu-bottom' => __('Menu Bottom'),
    	));
        
        register_sidebar( array(
            'name'          => 'Sidebar Left',
            'id'            => 'sidebar-left',
            'description'   => 'Main sidebar that appears on the left.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
	) );
        
        register_sidebar( array(
            'name'          => 'Ads Footer',
            'id'            => 'ads-footer',
            'description'   => 'Main ads that appears on the footer.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
	) );
        
        register_sidebar( array(
            'name'          => 'Pop-up',
            'id'            => 'pop-up',
            'description'   => 'Main Pop-up that appears on the site.',
            'before_widget' => '<aside id="%1$s" class="widget %2$s">',
            'after_widget'  => '</aside>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
	) );
        
        if (function_exists('add_image_size')) {
            add_theme_support('post-thumbnails');
            
            if (isset($this->theme_config['images_size']) && !empty($this->theme_config['images_size'])) {
                foreach ($this->theme_config['images_size'] as $image_size) {
                    add_image_size($image_size[0], $image_size[1], $image_size[2], true);
                }
            }
        }
    }
    
    public function get_config()
    {
        return self::$theme_config_stt;
    }
    
    public function theme_media()
    {
        if (isset($this->theme_config['theme_media']) && !empty($this->theme_config['theme_media'])) {
            if (isset($this->theme_config['theme_media']['css']) && !empty($this->theme_config['theme_media']['css'])) {
                foreach ($this->theme_config['theme_media']['css'] as $media_key => $media_value) {
                    wp_enqueue_style('dp-theme-'.$media_key, get_template_directory_uri() . '/assets/css/'.$media_value[0].'.css', array(), $media_value[1]);
                }
            }
            if (isset($this->theme_config['theme_media']['js']) && !empty($this->theme_config['theme_media']['js'])) {
                foreach ($this->theme_config['theme_media']['js'] as $media_key => $media_value) {
                    wp_enqueue_script('dp-theme-'.$media_key, get_template_directory_uri() . '/assets/js/'.$media_value[0].'.js', array(), $media_value[1]);
                }
            }
        }
    }
    
    public function theme_admin_init()
    {
        if (is_admin()) {
            if (isset($this->theme_config['custom_posts']) && !empty($this->theme_config['custom_posts'])) {
                foreach ($this->theme_config['custom_posts'] as $custom_post) {
                    require_once(get_template_directory().'/protected/posts/'.$custom_post.'.php');
                }
            }
        }
    }
    
    public function require_plugins()
    {
        $plugin_messages = array();
        
        include_once(ABSPATH . 'wp-admin/includes/plugin.php');
        
        if (isset($this->theme_config['plugins']) && !empty($this->theme_config['plugins'])) {
            foreach ($this->theme_config['plugins'] as $plugin) {
                if(!is_plugin_active($plugin['src'])) {
                    $plugin_messages[] = '<p>This theme requires you to install the <strong>'.$plugin['name'].'</strong> plugin, <a href="'.$plugin['link'].'">Download it from here</a>.</p>'; 
                }   
            }
            
            if (!empty($plugin_messages)) {
                echo '<div class="update-nag">'.implode($plugin_messages,'').'</div>';
            }   
        }
    }
}