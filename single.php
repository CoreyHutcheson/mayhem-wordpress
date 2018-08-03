<?php
/**
 * The template for displaying all single posts
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

			// Custom Pagination
			getPrevNext();

			// If comments are open or we have at least one comment, load up the comment template.
			if ( comments_open() || get_comments_number() ) :
				comments_template();
			endif;

		endwhile; // End of the loop.
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();

function getPrevNext(){
	$eventList = get_posts(array(
		'post_type' => 'flyer',
		'numberposts' => -1,
	));

	$events = array();

	foreach ($eventList as $event) {
	   $events[] += $event->ID;
	}

	$current = array_search(get_the_ID(), $events);
	$prevID = $events[$current - 1];
	$nextID = $events[$current + 1];
	
	echo '<div class="navigation">';
	
	if (!empty($prevID)) {
		echo '<div class="alignleft">';
		echo '<a href="';
		echo get_permalink($prevID);
		echo '"';
		echo 'title="';
		echo get_the_title($prevID); 
		echo'">Previous</a>';
		echo "</div>";
	}
	if (!empty($nextID)) {
		echo '<div class="alignright">';
		echo '<a href="';
		echo get_permalink($nextID);
		echo '"';
		echo 'title="';
		echo get_the_title($nextID); 
		echo'">Next</a>';
		echo "</div>";		
	}
}	
?>
