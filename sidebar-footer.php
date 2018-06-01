<?php
/**
 * The sidebar containing the footer widget area
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package mayhem-theme
 */

/** No footer widgets active */
if ( ! is_active_sidebar( 'footer-widget' ) ) { 
	?>

	<p>
		There are no footer widgets currently.  Go to customize area and add some information about your site to the footer widget area.

		For instance, add text for location, contact information, hours of operation, etc.
	</p>

	<?php
	return;
}
?>

<aside id="footer-widget" class="widget-area">
	<?php dynamic_sidebar( 'footer-widget' ); ?>
</aside><!-- #secondary -->