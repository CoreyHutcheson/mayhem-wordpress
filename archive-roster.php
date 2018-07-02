<?php
/**
 * The template for displaying the roster archive page
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package mayhem-theme
 */

get_header();
?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main">

			<form action="" class="site-main__form choices-container">
				<label class="choices-container__label" for="all">All
			    <input type="radio" name="roster-choice" class="choices-container__input" id="all">
			  </label>
			  
			  <label class="choices-container__label" for="wrestlers">Wrestlers
			    <input type="radio" name="roster-choice" class="choices-container__input" id="wrestlers">
			  </label>
			  
			  <label class="choices-container__label" for="managers">Managers
			    <input type="radio" name="roster-choice" class="choices-container__input" id="managers">
			  </label>
			  
			  <label class="choices-container__label" for="referees">Referees
			    <input type="radio" name="roster-choice" class="choices-container__input" id="referees">
			  </label>
			</form>

			<div class="site-main__roster roster-container">
				<div class="roster-container__wrestlers roster">
					<?php mayhem_roster_query('Wrestler'); ?>
				</div>

				<div class="roster-container__managers roster">
					<?php mayhem_roster_query('Manager'); ?>
				</div>

				<div class="roster-container__referees roster">
					<?php mayhem_roster_query('Referee'); ?>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();