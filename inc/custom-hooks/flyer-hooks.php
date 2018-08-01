<?php
/**
 * Used to alter post title and post name upon creating new post
 * @param  [int] $post_id - post's id
 * @param  [object] $post - post object
 * @return [undefined]
 */
function mayhem_save_post_callback($post_id, $post) {
  // verify post is not a revision
  if (wp_is_post_revision($post_id))
    return;

  // unhook this function to prevent infinite looping
  remove_action('save_post', 'mayhem_save_post_callback', 10);

  /**
   * Updates flyer post type with new title and slug/name
   */
  if ($post->post_type === 'flyer' && get_field('event_date')) {
    $date = get_field('event_date');
    $my_post = array(
      'ID' => $post_id,
      'post_title' => $date,
      'post_name' => date('F-j-Y', strtotime($date)),
    );

    wp_update_post($my_post);
  }

  // re-hook this function
  add_action('save_post', 'mayhem_save_post_callback', 10, 2);
}
add_action('save_post', 'mayhem_save_post_callback', 10, 2);

/**
 * Filters content for post type 'flyer' single.php pages
 * @param  [type] $content [description]
 * @return [type]          [description]
 */
function mayhem_filter_content_for_flyer_single_page($content) {
  // Returns content if not in loop of main query on singles flyer page
  if (!is_singular('flyer') || !is_main_query() || !in_the_loop()) {
    return $content;
  }

  // Splits the content into an array on newline and removes empty elements
  $contentArr = array_filter(preg_split('/\r\n|\r|\n/', $content));

  if (count($contentArr) === 0) {
    return $content;
  }

  foreach ($contentArr as &$str) {
    if (containsWord($str, '(vs|versus)')) {
      // Replace <p> tag with match class
      $str = str_replace('<p>', "<p class='flyer-entry__match'>", $str);
      // Replace 'vs.' with span match-divider
      $str = str_replace(' vs. ', ' <span class="flyer-entry__match-divider">vs.</span> ', $str);
      // Replace 'versus' with span match-divider
      $str = str_replace(' versus ', ' <span class="flyer-entry__match-divider">versus</span> ', $str);
    } else {
      $str = str_replace('<p>', "<p class='flyer-entry__match-details'>", $str);
    }
  }

  $content = implode("", $contentArr);

  return $content;
}
add_filter('the_content', 'mayhem_filter_content_for_flyer_single_page');

