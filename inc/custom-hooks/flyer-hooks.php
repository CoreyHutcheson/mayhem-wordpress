<?php

/**
 * Modifies post data upon submitting a post
 * @param  [array] $data : the slashed post data
 * @return [array] : modified post data
 */
function mayhem_modify_post($data) {
	/* Changes flyer post type title and slug
	 * Title Format = October 27, 2018
	 * Slug/Name Format = October-27-2018 
	 */
  if ($data['post_type'] === 'flyer' && get_field('event_date')) {
    $date = get_field('event_date');
  	$nameDate = date('F-j-Y', strtotime($date));
  	$data['post_title'] = $date;
  	$data['post_name'] = $nameDate;
  }
  return $data; // Returns the modified data.
}
add_filter('wp_insert_post_data', 'mayhem_modify_post', '10', 1);