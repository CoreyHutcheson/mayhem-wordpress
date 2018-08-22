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

			if (is_singular('flyer')) :
				// Gets all flyer posts that haven't occurred yet
				// ordering by event_date (next event first)
				$args = array(
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
				);
				// Located in inc/template-tags.php
				mayhem_custom_single_pagination($args, 'Event');
			elseif (is_singular('roster')) :
				// Gets all roster posts that have a gallery
				$args = array(
					'post_type' => 'roster',
					'numberposts' => -1,
					'meta_query' => array(
						'gallery' => array(
							'key' => 'gallery',
							'value' => false,
							'compare' => '!=',
						),
					),
					'order' => 'ASC',
					'orderby' => 'title',
				);
				// Located in inc/template-tags.php
				mayhem_custom_single_pagination($args, 'Gallery');
			else : 
				the_post_navigation();
			endif;

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