<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package mayhem-theme
 */

if ( ! function_exists( 'mayhem_posted_on' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function mayhem_posted_on() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			esc_html_x( 'Posted on %s', 'post date', 'mayhem' ),
			'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'mayhem_posted_by' ) ) :
	/**
	 * Prints HTML with meta information for the current author.
	 */
	function mayhem_posted_by() {
		$byline = sprintf(
			/* translators: %s: post author. */
			esc_html_x( 'by %s', 'post author', 'mayhem' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;

if ( ! function_exists( 'mayhem_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function mayhem_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'mayhem' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'mayhem' ) . '</span>', $categories_list ); // WPCS: XSS OK.
			}

			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', esc_html_x( ', ', 'list item separator', 'mayhem' ) );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'mayhem' ) . '</span>', $tags_list ); // WPCS: XSS OK.
			}
		}

		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo '<span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment<span class="screen-reader-text"> on %s</span>', 'mayhem' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

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
	}
endif;

if ( ! function_exists( 'mayhem_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function mayhem_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail(); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;

/**
 * Queries roster post type using category name
 * Loops through query result creating cards for each gimmick in category
 */
if ( ! function_exists( 'mayhem_roster_query' ) ) :

	function mayhem_roster_query($cat_name) {
		$args = array(
			'post_type' => 'roster',
			'orderby' => 'title',
			'order' => 'ASC',
			'category_name' => lcfirst($cat_name)
		);

		$header = $cat_name . 's';
		$roster_query = new WP_Query($args);

		if ( $roster_query->have_posts() ) : ?>

			<h1 class="roster-container__header">
				<?php echo $header ?>
			</h1>

			<div class="roster-container__content">
			
				<?php while ( $roster_query->have_posts() ) :
					$roster_query->the_post(); ?>

					<?php mayhem_create_roster_card(); ?>

				<?php endwhile; ?>

				<?php wp_reset_postdata(); ?>
			
			</div> <!-- /.roster__content -->
		
		<?php endif;
	}
endif;

/**
 * Creates html roster card for each gimmick
 */
if ( ! function_exists( 'mayhem_create_roster_card' ) ) :

	function mayhem_create_roster_card() { ?>

		<div class="c-roster-card">

			<div class="c-roster-card__image-container">
				<?php the_post_thumbnail( null, array("class" => "c-roster-card__img") ); ?>
			</div>

			<div class="c-roster-card__info">

				<?php if (get_the_title()) : ?>
					<div class="c-roster-card__name">
						<?php the_title(); ?>
					</div>
				<?php endif; ?>

				<?php // Loops through array creating a div if the custom field exists
					$arr = array('nickname', 'location', 'quick-fact', 'description');
					foreach ($arr as $value) :
						if (get_field($value)) : ?>
							<div class="c-roster-card__<?php echo $value ?>">
								<?php the_field($value); ?>
							</div>
						<?php endif;
					endforeach;
				?>

				<?php // Creates markup for gallery & website if applicable
					$gallery = get_field('gallery');
					$website = get_field('website');
				
					if ($gallery || $website) : ?>
						<div class="c-roster-card__links">
							
							<?php if ($gallery) : ?>
								<div class="c-roster-card__gallery-link">
									<a href="<?php the_permalink(); ?>">
										<i class="fas fa-images"></i>
									</a>
								</div>
							<?php endif; ?>

							<?php if ($website) : ?>
								<div class="c-roster-card__website">
									<a href="<?php echo $website['url']; ?>" 
										 target="<?php echo $website['target']; ?>">
										<i class="fas fa-globe"></i>
									</a>
								</div>
							<?php endif; ?>

						</div>
					<?php	
					endif; 
				?>

				<?php if (get_field('champion')) :
					$belt = wp_get_attachment_by_file_name('belt-icon');
					if ($belt) : ?>
						<div class="c-roster-card__champion">
							<?php echo wp_get_attachment_image($belt->ID, null, null, array('class' => 'c-roster-card__belt')); ?>
						</div>
					<?php endif; ?>
				<?php endif; ?>

			</div> <!-- /.c-roster-card__info -->

			<div class="c-roster-card__hover-element">More</div>

		</div>

		<?php
		return;
	}
endif;

/**
 * Queries attachments by file name
 */
if ( ! function_exists( 'wp_get_attachment_by_file_name' ) ) :

	function wp_get_attachment_by_file_name($file_name) {
		$args = array(
            'posts_per_page' => 1,
            'post_type'      => 'attachment',
            'name'           => trim ( $file_name ),
        );

        $get_attachment = new WP_Query( $args );

        if ( $get_attachment->posts[0] )
            return $get_attachment->posts[0];
        else
          return false;
	}
endif;

/**
 * Custom pagination by event date for Flyer/Event single page
 */
if ( ! function_exists( 'mayhem_custom_flyer_pagination' ) ) : 

	function mayhem_custom_flyer_pagination() {
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
endif;

/**
 * Creates featured event banners that appear underneath the header
 */
if ( ! function_exists( 'mayhem_create_featured_event_banners' ) ) :

	function mayhem_create_featured_event_banners() {
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
	}
endif;