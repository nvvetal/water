<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up until id="main-core".
 *
 * @package ThinkUpThemes
 */
?><!DOCTYPE html>

<html <?php language_attributes(); ?>>
<head>
<?php thinkup_hook_header(); ?>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/lib/scripts/html5.js" type="text/javascript"></script>
<![endif]-->

<?php wp_head(); ?>

</head>

<div id="static_header">
    <div class="order" href="#">
        <a>
            Закажи воду
            <span>В пару кликов</span>
        </a>
    </div>
    <div class="phone">
        <span>(044) 531-45-45</span>
        <br/>
        <a href="#">Перезвоните мне</a>
    </div>
    <div class="social">
        <a href="https://www.facebook.com/kodackavoda" target="_blank" class="fb span1"></a>
        <a href="http://vk.com/club49587500" target="_blank" class="vk span1"></a>
    </div>
    <div class="basket">
        <a>
            Корзина пуста <br />
            <small>Чего же Вы ждете? :)</small>
        </a>
    </div>
</div>

<body <?php body_class(); ?><?php thinkup_bodystyle(); ?>>
<div id="body-core" class="hfeed site">

	<header>

	<div id="site-header">
		<div id="header">

		<?php if ( get_header_image() ) : ?>
			<div class="custom-header"><img src="<?php header_image(); ?>" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt=""></div>
		<?php endif; // End header image check. ?>

		<div id="header-core">

			<div id="logo">
			<a rel="home" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php /* Custom Logo */ thinkup_custom_logo(); ?></a>
			</div>

			<div id="header-links" class="main-navigation">
			<div id="header-links-inner" class="header-links">
				<?php wp_nav_menu(array('container' => false, 'menu' => 'TopMenu' ) ); ?>
			</div>
			</div>
			<!-- #header-links .main-navigation -->

			<?php /* Add responsive header menu */ thinkup_input_responsivehtml(); ?>

		</div>
		</div>
		<!-- #header -->

		<div id="pre-header">
		<div class="wrap-safari">
	    	<div id="pre-header-core" class="main-navigation">
			<?php if ( has_nav_menu( 'pre_header_menu' ) ) : ?>
<!--			--><?php //wp_nav_menu( array( 'container_class' => 'header-links', 'container_id' => 'pre-header-links-inner', 'theme_location' => 'pre_header_menu' ) ); ?>
			<?php endif; ?>

			<?php /* Social Media Icons */ thinkup_input_socialmedia(); ?>

			<?php /* Header Search */ thinkup_input_headersearch(); ?>

		</div>
		</div>
		</div>
		<!-- #pre-header -->

	</div>

	<?php /* Custom Slider */ thinkup_input_sliderhome(); ?>
	</header>
	<!-- header -->
	<?php /*  Call To Action - Intro */ thinkup_input_ctaintro(); ?>
	<?php /*  Pre-Designed HomePage Content */ thinkup_input_homepagesection(); ?>

	<?php /* Custom Intro */ thinkup_custom_intro(); ?>

	<div id="content">
	<div id="content-core">

		<div id="main">
		<div id="main-core">