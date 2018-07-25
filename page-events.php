<?php
/**
 * The template for displaying events page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mayhem-theme
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main event-main">

			<?php 
			// Any flyers with event_date yet to pass (later than current
			// date/time)
			$args = array(
				'post_type' => 'flyer',
				'meta_key' => 'event_date',
				'meta_value'   => date( "Ymd" ),
				'meta_compare' => '>',
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

				<?php if (get_field('featured_flyer')) : ?>
					<p>Featured</p>
					<div><?php mayhem_post_thumbnail(); ?></div>
				<?php else : ?>
					<p>Not Featured</p>
					<div><?php mayhem_post_thumbnail(); ?></div>
				<?php endif; ?>

			<?php endwhile; endif;

			wp_reset_postdata();
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
