(function() {
	let choiceContainer = document.querySelector('.c-choice-toggle');
	let mainRosterContainer = document.querySelector('.roster-container');
	let rosterContainers = mainRosterContainer.children;

	/**
	 * Shows and Hides the appropriate roster divs when toggle button
	 * changes
	 */
	choiceContainer.addEventListener('click', function(e) {
		let target = e.target;

		if (target.nodeName !== 'LABEL') return;

		let value = target.getAttribute('for');
		let neededClass = `roster-container__${value}`;

		for (let container of rosterContainers) {
			if (value === 'all') {
				container.classList.remove('hide');
			} else if (!container.classList.contains(neededClass)) {
				container.classList.add('hide');
			} else {
				container.classList.remove('hide');
			}
		}
	});

	mainRosterContainer.addEventListener('click', function(e) {
		let target = e.target;

		// Return if not hover-element
		if (!target.classList.contains('c-roster-card__hover-element')) {
			return;
		}

		// Gets hover-elements parent card element
		let clickedCard = target.closest('.c-roster-card');
		

	})
})();

