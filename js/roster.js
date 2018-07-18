(function() {
	const choiceContainer = document.querySelector('.c-choice-toggle');
	const mainRosterContainer = document.querySelector('.roster-container');
	const rosterContainers = mainRosterContainer.children;

	choiceContainer.addEventListener('click', function(e) {
		let target = e.target;

		// Toggle Label was clicked
		if (target.nodeName === 'LABEL') {
			clickedChoiceToggle(target, rosterContainers);
			return;
		}
	});

	mainRosterContainer.addEventListener('click', function(e) {
		let target = e.target;

		// Hover Element (More/Details Btn) was clicked
		if (target.classList.contains('c-roster-card__hover-element')) {
			clickedHoverElement(target);
			return;
		}
	})

})();

/**
 * Shows and Hides the appropriate roster divs when toggle button
 * changes
 */
function clickedChoiceToggle(target, rosterContainers) {
	let value = target.getAttribute('for');
	let neededClass = `roster-container__${value}`;

	for (let container of rosterContainers) {
		if (value === 'all') {
			container.classList.remove('is-hidden');
		} else if (!container.classList.contains(neededClass)) {
			container.classList.add('is-hidden');
		} else {
			container.classList.remove('is-hidden');
		}
	}
}

function clickedHoverElement(target) {
	let clickedCard = target.closest('.c-roster-card');

	// Add class to card to show in a modal view
	// Add left and right arrows that will cycle through siblings
			// Removing class from current and adding to siblings
	
	// Remove js-card-expanded from all cards except clickedCard
	allowOnlyOneModal(clickedCard);

	function allowOnlyOneModal(clickedCard) {
		let allCards = document.querySelectorAll('.c-roster-card');

		for (let card of allCards) {
			if (card !== clickedCard) {
				card.classList.remove('js-is-modal');
			} else {
				card.classList.add('js-is-modal');
			}
		}

		return;
	}
}