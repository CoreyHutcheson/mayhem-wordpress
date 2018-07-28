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