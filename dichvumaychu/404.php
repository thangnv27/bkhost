<!DOCTYPE html>
<html id="dp-theme" class="non-res" <?php language_attributes(); ?>>
    <head>
    	<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
        <title>
            <?php wp_title( '|', true, 'right' ); ?>
        </title>
        <base href="<?php bloginfo('url'); ?>" />
    	
        <?php if (is_search()): ?>
    	   <meta name="robots" content="noindex, nofollow" /> 
    	<?php endif; ?>
        
    	<link type="image/x-icon" rel="shortcut icon" href="/favicon.ico" />
    	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css"/>
        <link type="text/css" rel="stylesheet" href="http://yui.yahooapis.com/3.18.0/build/cssreset/cssreset-min.css" />
    	<link type="text/css" rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" />
    	<link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    	<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
    	<?php wp_head(); ?>
    </head>
    <body>
        <div class="container error-page">  
            <div class="logo logo-404 clearfix"><!-- logo -->
                <h1><a href="./"><img src="http://bkhost.vn/wp-content/uploads/2015/05/logo-bkhost-small.png"/></a></h1>
                <h2>CÔNG TY CỔ PHẦN GIẢI PHÁP MẠNG TRỰC TUYẾN VIỆT NAM</h2>
            </div><!-- end logo -->
            <div class="error-content">
                <img src="<?php echo get_template_directory_uri(); ?>/assets/img/error.png"/>
                <?php wp_footer(); ?>
            </div>
        </div>
    </body>
</html>