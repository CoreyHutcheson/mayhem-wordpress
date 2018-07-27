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
		<main id="main" class="site-main events-container">

			<?php 
			// Any flyers with event_date yet to pass (later than current
			// date/time)
			$args = array(
				'post_type' => 'flyer',
				'meta_key' => 'event_date',
				'meta_value'   => date( "Ymd" ),
				'meta_compare' => '>=',
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

				$featured = get_field('featured_flyer') ?>

				<div class="event">
					<div class="event__flyer <?php if ($featured) {echo 'event__flyer--featured';} ?>">
						<?php if($featured) : ?>
							<div class="featured-banner">
								<span>Featured!!!</span>
							</div>
						<?php endif; ?>

						<?php mayhem_post_thumbnail(); ?>
					</div>
				</div>

			<?php endwhile; endif;

			wp_reset_postdata();
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
