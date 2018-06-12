<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mayhem-theme
 */

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="site">

	<!-- Useful for screen reader -->
	<a class="skip-link screen-reader-text" href="#content"><?php esc_html_e( 'Skip to content', 'mayhem' ); ?></a>

	<!-- .site-header -->
	<header id="masthead" class="site-header">

		<!-- .site-branding -->
		<div class="site-branding site-header__branding">
			<?php
			the_custom_logo();

			/** Display site title + description if there is no custom logo */
			if (!has_custom_logo()) :
				if ( is_front_page() && is_home() ) :
					?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
					<?php
				else :
					?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
					<?php
				endif;
				$mayhem_description = get_bloginfo( 'description', 'display' );
				if ( $mayhem_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo $mayhem_description; /* WPCS: xss ok. */ ?></p>
				<?php endif; 
			endif; ?>
		</div><!-- /.site-branding -->

		<!-- .menu-toggle -->
		<button class="menu-toggle site-header__open-btn" aria-controls="site-navigation" aria-expanded="false">
			<i class="fas fa-bars fa-2x"></i>
		</button> <!-- /.menu-toggle -->

		<!-- .main-navigation -->
		<nav id="site-navigation" class="main-navigation site-header__nav">
			<h1 class="main-navigation__site-name">
				<a href="<?php echo home_url(); ?>">
					<?php bloginfo('name'); ?>
				</a>
			</h1>

      <a href="javascript:void(0)" class="site-header__close-btn">&times;</a>

			<?php
			wp_nav_menu( array(
				'theme_location' => 'primary',
				'menu_class' => 'nav-menu main-navigation__menu',
				'container' => '',
			) );
			?>

			<?php 
			wp_nav_menu( array(
				'theme_location' => 'social',
				'menu_class' => 'nav-menu main-navigation__menu',
				'container' => '',
			) );
			?>
		</nav><!-- /.main-navigation -->

	</header><!-- /.site-header -->

	<div id="content" class="site-content">
