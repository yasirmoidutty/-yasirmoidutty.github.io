<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Arouse
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="wrapper" class="arouse-boxed">
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#main"><?php esc_html_e( 'Skip to content', 'arouse' ); ?></a>

	<header id="masthead" class="site-header" role="banner">

		<div class="brand-container">
			<div class="site-branding">
				<div class="site-logo">
					<?php arouse_the_custom_logo(); ?>
				</div>

				<div class="site-title-text">
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
			</div><!-- .site-branding -->
		</div><!-- .brand-container -->
		<div class="mainnav-container">
			<nav id="site-navigation" class="main-navigation" role="navigation">				
				<?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_id' => 'primary-menu' ) ); ?>
			</nav><!-- #site-navigation -->
			<div class="arouse-search-button-icon"></div>
			<div class="arouse-search-box-container">
				<div class="arouse-search-box">
					<div class="arouse-search-form">
						<?php get_search_form(); ?>
					</div>
				</div><!-- th-search-box -->
			</div><!-- .th-search-box-container -->
		</div><!-- .mainnav-container -->
		<a id="arouse-nav-button" class="navbutton" ></a>

	</header><!-- #masthead -->
	<div class="responsive-mainnav-outer">
		<div class="arouse-responsive-mainnav"></div>
	</div>

	<div id="content" class="site-content">