<?php
/**
 * Alters the social media menu to show font-awesome icons
 */
function mayhem_social_media_menu_alteration($items, $args) {
	// Only filters on social media menu
	if ($args->theme_location != 'social') {
		return $items;
	}

	foreach ($items as $item) {
		// Sets icon variable if 'font_awesome_icon' field exists
		$icon = get_field('font_awesome_icon', $item);

		if ($icon) {
			// Changes title to match font-awesome tag assigned in menu item list
			$item->title = "<i class=\"${icon}\"></i>";
		}
	}

	return $items;
}
add_filter( 'wp_nav_menu_objects', 'mayhem_social_media_menu_alteration', 10, 2 );

/**
 * Adds BEM element class (.nav-menu__list-item) to menu block
 * (.nav-menu);
 */
function mayhem_add_nav_menu_list_item_class($classes, $item, $args) {
	// nav-menu class was found on the parent ul element
	if (strpos($args->menu_class, 'nav-menu') !== false) {
		$classes[] .= 'nav-menu__list-item';
	}

	return $classes;
}
add_filter('nav_menu_css_class', 'mayhem_add_nav_menu_list_item_class', 10, 3);

/**
 * Adds BEM element class (.nav-menu__link) to menu block
 * (.nav-menu);
 */
function mayhem_add_nav_menu_link_class($atts, $item, $args) {
	$atts['class'] = 'nav-menu__link';
	// Add special no-border modifier class to social media links
	if ($args->theme_location === 'social') {
		$atts['class'] .= ' nav-menu__link--no-border';
	}

	return $atts;
}
add_filter('nav_menu_link_attributes', 'mayhem_add_nav_menu_link_class', 10, 3);

/**
 * Add BEM element classes (.site-branding__link & 
 * .site-branding__img) to logo block (.site-branding)
 */
function mayhem_add_custom_logo_class($html, $blog_id) {
	// Adds .site-branding__link class to the_custom_logo a tag
	$html = str_replace('"custom-logo-link"', '"custom-logo-link site-branding__link"', $html);
	// Adds .site-branding__img class to the_custom_logo img tag
	$html = str_replace('"custom-logo"', '"custom-logo site-branding__img"', $html);

	return $html;
}
add_filter('get_custom_logo', 'mayhem_add_custom_logo_class', 10, 2);