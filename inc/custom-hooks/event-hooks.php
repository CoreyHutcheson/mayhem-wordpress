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
   * Updates event post type with new title and slug/name
   */
  if ( $post->post_type === 'event' ) {

    if ( ! function_exists('set_post_details') ) {
      /**
       * Sets the post id, title, and name
       * @param [string] $title
       * @param [string] $name
       */
      function set_post_details($title, $name) {
        global $post_id;

        return array(
          'ID' => $post_id,
          'post_title' => $title,
          'post_name' => seoURL($name),
        );
      }
    }

    $name = get_field('event_name');
    $date = get_field('event_date');
    $post_details = ($name) ? 
      set_post_details( $name, $name ) : 
      set_post_details( $date, date('F-j-Y', strtotime($date)) );

    wp_update_post($post_details);
  }

  // re-hook this function
  add_action('save_post', 'mayhem_save_post_callback', 10, 2);
}
add_action('save_post', 'mayhem_save_post_callback', 10, 2);

