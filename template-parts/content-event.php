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
	array('event', 'event--content') : 'event';
?>

<article id="post-<?php the_ID(); ?>" <?php post_class($articleClasses); ?>>

	<header class="event__header">
		<?php the_title( '<h1 class="event__title">', '</h1>' ); ?>
	</header>

	<div class="post-thumbnail event__thumbnail">
		<?php echo wp_get_attachment_image( get_field('event_image'), 'full' ); ?>
	</div>

	<div class="event__content">

		<?php // Output all match descriptions and matches
		if (have_rows('card_details')) :
			while (have_rows('card_details')) : the_row();

				$description = get_sub_field('match_description');
				$match = get_sub_field('match');
				$match_details = "";

				if ($description) :
					$match_details .= 
						"<div class='event__match-description'>
							${description}
						</div>";
				endif;

				$match_details .= "<div class='event__match'>${match}</div>";
			
				echo $match_details;
			endwhile;
		endif;

		// Outputs extra details if available
		if (get_field('extra_card_details')) :
			$extra = 
				"<div class='event__extra-card-details'>"
				 . get_field('extra_card_details') .
				"</div>";
			echo $extra;
		endif;

		// Outputs the my-tickets order form if applicable
		the_content( sprintf(
			wp_kses(
				/* translators: %s: Name of current post. Only visible to screen readers */
				__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'mayhem' ),
				array(
					'span' => array(
						'class' => array(),
					),
				)
			),
			get_the_title()
		) );
		?>

	</div>

	<?php mayhem_page_footer('event'); ?>

</article><!-- #post-<?php the_ID(); ?> -->
