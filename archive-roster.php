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

			<form action="" class="site-main__form c-choice-toggle">
				<input type="radio" name="roster-choice" class="c-choice-toggle__input" id="all" checked>
				<label class="c-choice-toggle__label" for="all">All</label>
			  
		  		<input type="radio" name="roster-choice" class="c-choice-toggle__input" id="wrestlers">
		  		<label class="c-choice-toggle__label" for="wrestlers">Wrestlers</label>
			  
		  		<input type="radio" name="roster-choice" class="c-choice-toggle__input" id="managers">
		  		<label class="c-choice-toggle__label" for="managers">Managers</label>
		  		
		  		<input type="radio" name="roster-choice" class="c-choice-toggle__input" id="referees">
		  		<label class="c-choice-toggle__label" for="referees">Referees</label>
			</form>

			<div class="site-main__roster roster-container">
				<div class="roster-container__wrestlers">
					<?php mayhem_roster_query('Wrestler'); ?>
				</div>

				<div class="roster-container__managers">
					<?php mayhem_roster_query('Manager'); ?>
				</div>

				<div class="roster-container__referees">
					<?php mayhem_roster_query('Referee'); ?>
				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();