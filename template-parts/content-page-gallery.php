<?php
/**
 * Template part for displaying gallery content
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mayhem-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<?php mayhem_post_thumbnail(); ?>

	<div class="entry-content instagram-gallery">
		<?php
		the_content();

		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'mayhem' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->

	<?php mayhem_page_footer('gallery'); ?>
</article><!-- #post-<?php the_ID(); ?> -->
