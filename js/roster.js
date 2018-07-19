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

	// Remove js-is-modal class from all cards except clickedCard
	allowOnlyOneModal(clickedCard);
	let modalContent = getModalDetails(clickedCard);

	// Place modalContent in appropriate place inside DOM
	document.querySelector('.js-modal-content').appendChild(modalContent);
	// Remove hidden class on modal
	document.querySelector('.modal').classList.remove('is-hidden');
}

/**
 * Apply js-is-modal class to appropraite card, removing it from all other cards
 */
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

function getModalDetails(card) {
	let cardClone = card.cloneNode(true);

	// Loop over all elements replacing c-roster-card__ class with
	// modal__ class
	Array.from(cardClone.getElementsByTagName('*')).forEach(e => {
	  e.className = e.className.replace('c-roster-card__', 'modal__');
	});

	// Change cardClone's className to .modal__content (removing js-is-modal)
	cardClone.className = 'modal__content';

	return cardClone;
}
