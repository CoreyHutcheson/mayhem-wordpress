/**
 * Shows and Hides the appropriate roster divs when toggle button
 * changes
 */
(function() {
	let choiceContainer = document.querySelector('.c-choice-toggle');
	let rosterCards = document.querySelectorAll('.c-roster-card');

	choiceContainer.addEventListener('click', function(e) {
		let target = e.target;

		// Return if not the label that was clicked
		if (target.nodeName !== 'LABEL') return;

		let value = target.getAttribute('for');

		for (let card of rosterCards) {
			if (value === 'all') {
				card.classList.remove('hide');
			} else if (!card.classList.contains(`roster-list__${value}`)) {
				card.classList.add('hide');
			} else {
				card.classList.remove('hide');
			}
		}
	});

})();