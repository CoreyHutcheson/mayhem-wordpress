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
		<main id="main" class="site-main l-roster-main">

			<!-- Toggle Button Container -->
			<form action="" class="l-roster-main__form c-choice-toggle">
				<input type="radio" name="roster-choice" class="c-choice-toggle__input" id="all" checked>
				<label class="c-choice-toggle__label" for="all">All</label>
		  
	  			<input type="radio" name="roster-choice" class="c-choice-toggle__input" id="wrestlers">
	  			<label class="c-choice-toggle__label" for="wrestlers">Wrestlers</label>
		  
	  			<input type="radio" name="roster-choice" class="c-choice-toggle__input" id="managers">
	  			<label class="c-choice-toggle__label" for="managers">Managers</label>
	  		
	  			<input type="radio" name="roster-choice" class="c-choice-toggle__input" id="referees">
	  			<label class="c-choice-toggle__label" for="referees">Referees</label>
			</form>

			<!-- Roster Container -->
			<div class="l-roster-main__roster roster-container">
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

			<!-- Modal Container -->
			<div class="modal is-hidden">
				<div class="modal__wrapper">

					<span class="modal__close-btn modal__nav-btn">
						<i class="fas fa-times"></i>
					</span>

					<span class="modal__prev-btn modal__nav-btn">
						<i class="fas fa-arrow-left"></i>
					</span>

					<div class="modal__content">
						<div class="modal__img-container"></div>
						<div class="modal__info">
							<div class="modal__name"></div>
							<div class="modal__location"></div>
							<div class="modal__quick-fact"></div>
							<div class="modal__description"></div>
							<div class="modal__website"></div>
							<div class="modal__champion"></div>
						</div>
					</div>

					<span class="modal__next-btn modal__nav-btn">
						<i class="fas fa-arrow-right"></i>
					</span>

				</div>
			</div>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();