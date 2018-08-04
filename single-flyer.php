<?php
/**
 * The template for displaying all single flyer posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package mayhem-theme
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		while ( have_posts() ) :
			the_post();

			get_template_part( 'template-parts/content', get_post_type() );

			getPrevNext();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.

		wp_reset_postdata();
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

function getPrevNext(){
	// Gets all flyer posts that haven't occurred yet
	// ordering by event_date (next event first)
	$eventList = get_posts(array(
		'post_type' => 'flyer',
		'numberposts' => -1,
		'meta_query' => array(
			'date' => array(
				'key' => 'event_date',
				'value' => date("Ymd"),
				'compare' => '>=',
			),
		),
		'orderby' => array(
			'date' => 'ASC',
		),
	));

	// Creates array of sorted event IDs (by date of event)
	$orderedIDs = array_map(function($event) {
		return $event->ID;
	}, $eventList);

	// Returns index of current event in $eventList
	$current = array_search(get_the_ID(), $orderedIDs);

	// Sets Prev and Next Event IDs
	$prevID = ($current > 0) ? $eventList[$current - 1] : NULL;
	$nextID = ($current < count($orderedIDs) - 1) ? $eventList[$current + 1] : NULL;
	?>

	<div class="navigation">

		<?php if (!empty($prevID)) : ?>
			<div class="alignleft">
				<a href="<?php the_permalink($prevID); ?>" title="<?php echo get_the_title($prevID); ?>">
					Previous Event
				</a>
			</div>
		<?php endif; ?>

		<?php if (!empty($nextID)) : ?>
			<div class="alignright">
				<a href="<?php the_permalink($nextID); ?>" title="<?php echo get_the_title($nextID); ?>">
					Next Event
				</a>
			</div>
		<?php endif; ?>

	</div> <!-- /.navigation -->

<?php
}
