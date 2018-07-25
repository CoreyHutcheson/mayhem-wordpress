<?php

function mayhem_title_filter( $title, $post_id ) {
	// Return event_date as title if post type is 'flyer'
	if ('flyer' === get_post_type($post_id)) :
		$date = get_field('event_date', $post_id);
		if ($date) :
			return $date;
		endif;
	endif;

	return $title;
}
add_filter( 'the_title', 'mayhem_title_filter', 10, 2 );