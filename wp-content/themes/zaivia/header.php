<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php /*<link rel="shortcut icon" type="image/png" href="<?php echo get_template_directory_uri(); ?>/images/favicon.png">*/ ?>
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="header">
    <div class="container">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="logo"><img src="<?php echo get_template_directory_uri();?>/images/logo.png" alt=""></a>
        <div class="right">
            <div class="free"><?php _e('It’s Free', 'am') ?></div>
            <a href="<?php if(!is_user_logged_in()):?>#login<?php else:?><?php the_field("page_postlisting", "option")?><?php endif;?>" class="btn btn-secondary br<?php if(!is_user_logged_in()):?> open-modal<?php endif;?>"><?php _e('List Your Property', 'am') ?></a>
            <a href="<?php if(!is_user_logged_in()):?>#login<?php else:?><?php the_field("page_postcard", "option")?><?php endif;?>" class="btn btn-primary bl<?php if(!is_user_logged_in()):?> open-modal<?php endif;?>"><?php _e('List Your Business', 'am') ?></a>
        </div>
        <div class="menu-trigger"><span></span><span></span><span></span></div>
	    <?php if ( has_nav_menu( 'mainmenu' ) ) : ?>
            <nav class="menu">
			    <?php wp_nav_menu( array( 'theme_location' => 'mainmenu', 'menu_class' => '', 'menu_id'=>'', 'container'=>'', 'depth'=>0) ); ?>
            </nav><!-- /mainmenu -->
	    <?php endif; ?>
    </div>
</header>

<div class="body <?php if(!is_front_page()):?>grey-bg<?php endif; ?>">