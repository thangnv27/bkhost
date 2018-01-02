<?php

# Theme base path
define('THEME_PATH', get_template_directory());
# Theme base uri
define('THEME_URI', get_template_directory_uri());
# Theme base css file
define('THEME_CSS_URI', THEME_URI . '/assets/css');
# Theme base js file
define('THEME_JS_URI', THEME_URI . '/assets/js');
# Theme img uri
define('THEME_IMG_URI', THEME_URI . '/assets/images');

if (is_admin()) {
    $basename_excludes = array('plugins.php', 'plugin-install.php', 'plugin-editor.php', 'themes.php', 'theme-editor.php', 'import.php', 'export.php');
    if (in_array(basename($_SERVER['PHP_SELF']), $basename_excludes)) {
//        wp_redirect(admin_url());
    }
    add_action('admin_menu', 'ppo_remove_menu_pages');
    add_action('admin_menu', 'ppo_remove_menu_editor', 102);
}

/**
 * Remove admin menu
 */
function ppo_remove_menu_pages() {
    remove_menu_page('edit-comments.php');
//    remove_menu_page('plugins.php');
//    remove_menu_page('tools.php');
}

function ppo_remove_menu_editor() {
    remove_submenu_page('themes.php', 'theme-editor.php');
    remove_submenu_page('plugins.php', 'plugin-editor.php');
    remove_submenu_page('options-general.php', 'options-writing.php');
    remove_submenu_page('options-general.php', 'options-discussion.php');
    remove_submenu_page('options-general.php', 'options-media.php');
}

// Require tools file.
require_once(get_template_directory() . '/protected/class-dp-theme.php');

// Require dp theme class.
$dp_theme = new DP_Theme(require_once(get_template_directory() . '/bootstrap.php'));

// Add RSS links to <head> section
global $wp_version;
if (version_compare($wp_version, '3.0', '>=')) {
    add_theme_support('automatic-feed-links');
} else {
    automatic_feed_links();
}

// Run admin theme init.
$dp_theme->theme_admin_init();

function begin_session() {
    if (!session_id()) {
        session_start();
    }
    session_regenerate_id(true);
}

function end_session() {
    session_destroy();
}

show_admin_bar(false);

function add_order_info() {
    if (isset($_POST['name_field'])) {
        $author_send = $_POST['name_field'];
        $order_title = 'Đơn hàng của ' . $author_send;
    } else {
        $author_send = 'Người lạ';
        $order_title = 'Đơn hàng mới';
    }
    $cmnd_send = isset($_POST['cmnd_field']) ? $_POST['cmnd_field'] : '';
    $email_send = isset($_POST['email_field']) ? $_POST['email_field'] : '';
    $so_dien_thoai_send = isset($_POST['phone_field']) ? $_POST['phone_field'] : '';
    $dia_chi_gui_send = isset($_POST['address_field']) ? $_POST['address_field'] : '';
    $yeucau_send = isset($_POST['more_require']) ? $_POST['more_require'] : '';

    $add_order = array(
        'post_title' => $order_title,
        'post_status' => 'publish',
        'post_type' => 'don-dat-hang'
    );

    $order_post = wp_insert_post($add_order);

    if ($order_post !== 0) {
        update_post_meta($order_post, 'nguoi_dat_hang', $author_send);
        update_post_meta($order_post, 'ma_so_thue_so_cmnd', $cmnd_send);
        update_post_meta($order_post, 'email_nguoi_dat_hang', $email_send);
        update_post_meta($order_post, 'so_dien_thoai', $so_dien_thoai_send);
        update_post_meta($order_post, 'dia_chi_gui', $dia_chi_gui_send);
        update_post_meta($order_post, 'yeu_cau_khac', $yeucau_send);

        $cart = $_SESSION['__dvmc_cart__'];
        $html_rs = '';
        $incr = 1;

        foreach ($cart as $id_item => $item_cart) {
            $html_rs .= $incr . ', Sản phẩm: ' . $item_cart['item']['name'] . '[' . $item_cart['item']['id'] . '] (Số lượng: ' . $item_cart['item']['amount'] . ')';
            if (!empty($item_cart['attach'])) {
                $attach_html = '';
                foreach ($item_cart['attach'] as $id_attach => $attach_item) {
                    if ($attach_item['check'] == 1) {
                        $attach_html .= 'Gói đính kèm: ' . $attach_item['name'] . ', ';
                    }
                }
                $attach_html = rtrim($attach_html, ', ');
                $html_rs .= ' - (' . $attach_html . ')';
            }
            $html_rs .= '. ';
        }

        update_post_meta($order_post, 'san_pham_dat_hang', $html_rs);

        unset($_SESSION['__dvmc_cart__']);

        wp_redirect(get_bloginfo('url') . '/gio-hang');
    }
}

function custom_single_template($single) {
    global $post;
    if (file_exists(get_template_directory() . '/single-templates/single-' . $post->post_type . '.php')) {
        return get_template_directory() . '/single-templates/single-' . $post->post_type . '.php';
    }
    return $single;
}

// Add action.
add_action('wpcf7_mail_sent', 'add_order_info');
add_action('admin_notices', array($dp_theme, 'require_plugins'));
add_action('wp_enqueue_scripts', array($dp_theme, 'theme_media'));
add_action('init', array($dp_theme, 'theme_init'));
add_action('init', 'begin_session', 1);
add_action('wp_logout', 'end_session');
add_action('wp_login', 'end_session');
// Add filter
add_filter('nav_menu_item_id', '__return_false');
add_filter('single_template', 'custom_single_template');
// Remove action
remove_action('wp_head', 'wp_generator');