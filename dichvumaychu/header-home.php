<!DOCTYPE html>
<html id="dp-theme" class="non-res" <?php language_attributes(); ?>>
    <head>
        <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <title>
            <?php wp_title('|', true, 'right'); ?>
        </title>
        <base href="<?php bloginfo('url'); ?>" />
        <?php if (is_search()): ?>
            <meta name="robots" content="noindex, nofollow" /> 
        <?php endif; ?>
        <link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/assets/img/favicon.ico" type="image/x-icon">
        <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/assets/images/favicon.ico" type="image/x-icon">
        <link type="text/css" rel="stylesheet" href="http://yui.yahooapis.com/3.18.0/build/cssreset/cssreset-min.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/style.css" />
        <link type="text/css" rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css" />
        <link href="<?php echo get_template_directory_uri(); ?>/assets/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
        <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/owl-carousel/owl-carousel/owl.carousel.css" rel="stylesheet"/>
        <link type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/vendor/owl-carousel/owl-carousel/owl.theme.css" rel="stylesheet"/>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <script src="<?php echo get_template_directory_uri(); ?>/assets/vendor/owl-carousel/owl-carousel/owl.carousel.min.js"></script>
        <script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/assets/js/jquery-ui.js'></script>
        <script type='text/javascript' src='<?php echo get_template_directory_uri(); ?>/assets/js/jquery-ui-slider-pips.js'></script>
        <link rel="stylesheet" id="lightslider-css" href="<?php echo get_template_directory_uri(); ?>/assets/css/lightslider.min.css" type="text/css" media="all">
        <script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/lightslider.min.js"></script>
        <script type="text/javascript">
            var base_uri = "<?php bloginfo('url'); ?>";
        </script>
        <style>.breadcrumb-container{display:none;}</style>
        <?php wp_head(); ?>
        <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)

            })(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');
            ga('create', 'UA-57344837-13', 'auto');
            ga('send', 'pageview');
        </script> 
    </head>
    <body <?php body_class(); ?>>
        <h1 class="home"><?php wp_title('|', true, 'right'); ?></h1>
        <header class="header-container"><!-- header -->
            <div class="top-header"><!-- top header -->
                <div class="top-header-content container clearfix"><!-- top header content -->
                    <div class="col-left menu-top">
                        <?php
                        wp_nav_menu(array('theme_location' => 'menu-top', 'container' => ''));
                        $cart_nof = get_count_cart() == 0 ? '(trống rỗng)' : get_count_cart() . ' sản phẩm';
                        ?>
                    </div>
                    <div class="col-right menu-top">
                        <ul>
                            <li><a href="#" class="register" onclick="return false;">Đăng ký</a></li>
                            <li><a href="#" class="login" onclick="return false;">Đăng nhập</a></li>
                            <li><a href="<?php bloginfo('url'); ?>/gio-hang" class="top-cart">Giỏ hàng: <?php echo $cart_nof; ?></a></li>
                        </ul>
                    </div>
                </div><!-- end top header content -->
            </div><!-- end top header -->
            <div class="container primary-header"><!-- mid header -->
                <div class="logo col-left">
                    <a href="<?php bloginfo('url'); ?>" title="Hosting, Máy chủ ảo, Cloud VPS, Tên miền, Thiết kế Website">
                        <img src="http://bkhost.vn/wp-content/uploads/2015/12/logo-bkhost-giangsinh.png" alt="Hosting, Máy chủ ảo, Cloud VPS, Tên miền, Thiết kế Website" style="transform: scale(1);">		
                    </a>
                </div>
                <div class="contact-numb">
                    <ul class="clearfix">
                        <li>
                            <span class="name">KD Hà Nội</span>
                            <span class="number">(04) 6259 1442</span>
                        </li>
                        <li>
                            <span class="name">KD Hồ Chí Minh</span>
                            <span class="number">0984 131 161</span>
                        </li>
                        <li>
                            <span class="name">Support Kỹ Thuật</span>
                            <span class="number">(04) 6259 1445</span>
                        </li>
                    </ul>
                </div>
            </div><!-- end mid header -->
            <div class="main-menu"><!-- main menu -->
                <div class="container">
                    <?php
                    ubermenu('main');
                    //wp_nav_menu(array('theme_location' => 'main-nav', 'container' => ''));
                    ?>
                </div>
            </div><!-- end main menu -->
        </header><!-- end header -->
