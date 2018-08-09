<?php
/**
 * Template part for displaying content for roster single.php pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mayhem-theme
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('entry'); ?>>
	<header class="entry__header">
		<?php the_title( '<h1 class="entry__title">', '</h1>' ); ?>
	</header><!-- .entry__header -->

	<div class="entry__content">
		<?php 
		$images = get_field('gallery');
		$size = 'full';

		if ($images) : ?>
			<ul class="entry__gallery">
				<?php foreach ($images as $image) : ?>
					<li class="entry__picture">
						<?php echo wp_get_attachment_image($image['ID'], $size); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>

	</div><!-- .entry__gallery -->

	<?php if ( get_edit_post_link() ) : ?>
		<footer class="entry-footer">
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