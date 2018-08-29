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
			// Any events with event_date that hasn't passed yet
			// Featured Events first, then non-featured
			// Events that are a later date are lower down.
			$args = array(
				'post_type' => 'event',
				'meta_query' => array(
					'date' => array(
						'key' => 'event_date',
						'value' => date("Ymd"),
						'compare' => '>=',
					),
					'featured' => array(
						'key' => 'featured_event',
						'compare' => 'EXISTS',
					),
				),
				'orderby' => array(
					'featured' => 'DESC',
					'date' => 'ASC',
				),
			);

			$query = new WP_Query($args);

			if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

				$featured = get_field('featured_event');
				$image = get_field('event_image');
				$size = 'full'; 
				?>

				<div class="event">

					<div class="event__name"><?php the_title(); ?></div>

					<div class="event__countdown"><?php time_until_event(get_field('event_date')); ?></div>

					<div class="event__flyer <?php if ($featured) {echo 'event__flyer--featured';} ?>">

						<?php if ($featured) : ?>
							<div class="featured-banner">
								<span>Featured!!!</span>
							</div>
						<?php endif; ?>

						<a href="<?php the_permalink(); ?>" class="event__link">
							<?php echo wp_get_attachment_image( $image, $size ); ?>		
						</a>

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


