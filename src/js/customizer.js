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
      $('.featured-notification').css('background', value);
      $('.current-menu-item a:before').css('background', value);
      $('.current-menu-item a:after').css('background', value);
      $('.c-choice-toggle__input:check + label').css('background', value);
      $('.c-roster-card__hover-element').css('background', value);

      $('.post-navigation__button').css('color', value);
      $('.modal__nav-btn:hover').css('color', value);
      
      $('.event__flyer--featured').css('box-shadow', `2px 2px 10px 2px #111, 0px 0px 30px 10px ${value}`);
    });
  });


});
