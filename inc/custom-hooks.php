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