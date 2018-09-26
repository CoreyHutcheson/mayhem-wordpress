/**
 * File customizer.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */
jQuery(document).ready(function($) {
  /** Site Title */
  wp.customize('blogname', control => {
    control.bind(value => {
      $('.site-title a').text(value);
    });
  });

  /** Site Description */
  wp.customize('blogdescription', control => {
    control.bind(value => {
      $('.site-description').text(value);
    });
  });

  /** Brand Color */
  wp.customize('brand_color', control => {
    control.bind(value => {
      $('.menu-toggle-btn span').css('background', value);
    });
  });


});
