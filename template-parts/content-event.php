<?php
/**
 * Template part for displaying event page content in page.php
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mayhem-theme
 */

?>

<?php 
// Conditionally get the classes to add to the article used for positioning
$articleClasses = get_field('card_details') ? 
	array('flyer-entry', 'flyer-entry--content') : 'flyer-entry';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($articleClasses); ?>>

	<header class="flyer-entry__header">
		<?php the_title( '<h1 class="flyer-entry__title">', '</h1>' ); ?>
	</header>

	<div class="post-thumbnail flyer-entry__thumbnail">
		<?php echo wp_get_attachment_image( get_field('event_image'), 'full' ); ?>
	</div>

	<div class="flyer-entry__content">
		<?php 

		if (have_rows('card_details')) :
			while (have_rows('card_details')) : the_row();

				$description = get_sub_field('match_description');
				$match = get_sub_field('match');

			endwhile;
		endif;
		?>
	</div>

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="flyer-entry__footer">
			<?php
			edit_post_link(
				sprintf(
					wp_kses(
						/* translators: %s: Name of current post. Only visible to screen readers */
						__( 'Edit <span class="screen-reader-text">%s</span>', 'mayhem' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				),
				'<span class="edit-link">',
				'</span>'
			);
			?>
		</footer><!-- .entry-footer -->
	<?php endif; ?>
</article><!-- #post-<?php the_ID(); ?> -->
