<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mayhem-theme
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

		<?php
		$args = array(
			'post_type' => 'roster'
		);

		$query = new WP_Query($args);

		if ( $query->have_posts() ) :
			while ( $query->have_posts() ) :
				$query->the_post(); ?>
				<!-- Loop content goes here! -->
				<h1>Title!</h1>


		<?php
			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();