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

<?php // Query to create featured-notification divs
	$args = array(
		'post_type' => 'flyer',
		'order' => 'ASC',
		'orderby' => 'meta_value_num',
		'meta_key' => 'event_date',
		'meta_query' => array(
			array(
				'key' => 'featured_flyer',
				'value' => true,
			),
			array(
				'key' => 'event_date',
				'value' => date( 'Ymd' ),
				'compare' => '>=',
			),
		),
	);

	$query = new WP_Query($args);

	if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post(); ?>

		<div class="featured-notification">
			<i class="fas fa-star"></i>
			<span>Featured:</span>
			<span>
				<a href="<?php the_permalink(); ?>" class="featured-notification__link"><?php the_title(); ?></a>
			</span>
			<i class="fas fa-star"></i>
		</div>

	<?php endwhile; endif;
	wp_reset_postdata();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main events-container">

			<?php 
			// Any flyers with event_date that hasn't passed yet
			// Featured Flyers first, then non-featured
			// Events that are a later date are lower down.
			$args = array(
				'post_type' => 'flyer',
				'meta_query' => array(
					'date' => array(
						'key' => 'event_date',
						'value' => date("Ymd"),
						'compare' => '>=',
					),
					'featured' => array(
						'key' => 'featured_flyer',
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

				$featured = get_field('featured_flyer'); ?>

				<?php // Testing
				$dateOfEvent = strtotime(get_field('event_date'));
				$secs = $dateOfEvent - time();
				$days = ceil($secs / 86400);
				$str = '';
				if ($days == 1) {
					$str = $days . ' day until event';
				} else if ($days <= 0) {
					$str = 'Event happens today';
				} else {
					$str = $days . ' days until event';
				}
				?>

				<div class="event">
					<div class="event__date"><?php the_title(); ?></div>
					<div class="event__countdown"><?php echo $str; ?></div>
					<div class="event__flyer <?php if ($featured) {echo 'event__flyer--featured';} ?>">
						<?php if($featured) : ?>
							<div class="featured-banner">
								<span>Featured!!!</span>
							</div>
						<?php endif; ?>

						<a href="<?php the_permalink(); ?>" class="event__link"><?php mayhem_post_thumbnail(); ?></a>
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
