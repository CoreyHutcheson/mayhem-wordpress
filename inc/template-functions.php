<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package mayhem-theme
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function mayhem_body_classes( $classes ) {
	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds a class of no-sidebar when there is no sidebar present.
	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'mayhem_body_classes' );

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function mayhem_pingback_header() {
	if ( is_singular() && pings_open() ) {
		echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
	}
}
add_action( 'wp_head', 'mayhem_pingback_header' );

/**
 * Alters the social media menu to show font-awesome icons
 */
function mayhem_social_media_menu_alteration($items, $args) {
	if ($args->theme_location != 'social') {
		return $items;
	}

	foreach ($items as $item) {
		$icon = get_field('font_awesome_icon', $item);

		if ($icon) {
			$item->title = "<i class='${icon}'></i>";
		}
	}
	return $items;
}
add_filter( 'wp_nav_menu_objects', 'mayhem_social_media_menu_alteration', 10, 2 );