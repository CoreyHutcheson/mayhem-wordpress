(function() {
	const choiceContainer = document.querySelector('.c-choice-toggle');
	const mainRosterContainer = document.querySelector('.roster-container');
	const rosterContainers = mainRosterContainer.children;
	const modal = document.querySelector('.modal');

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

	// Add click event to modal buttons
	modal.addEventListener('click', function(e) {
		let target = e.target;

		if (target.closest('.modal__close-btn')) {
			clickedCloseButton();
		} else if (target.closest('.modal__prev-btn')) {
			clickedPrevButton();
		} else if (target.closest('.modal__next-btn')) {
			clickedNextButton();
		} else if (target.classList.contains('modal')) {
			clickedOutsideModalWrapper();
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
	populateModalContent();
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

/**
 * Populates the .modal__content container with the correct card
 * details.
 */
function populateModalContent() {
	let cardToBeModal = document.querySelector('.js-is-modal');
	let modalContentElement = document.querySelector('.js-modal-content');
	let newModalDetails = getCardDetails(cardToBeModal);

	// Insert the new modal details into the modal content container
	modalContentElement.appendChild(newModalDetails);
	// Remove the modal .is-hidden class if applicable
	document.querySelector('.modal').classList.remove('is-hidden');
}

/**
 * Takes card and returns a clone with '.modal__' class names
 */
function getCardDetails(clickedCard) {
	let cardClone = clickedCard.cloneNode(true);

	// Loop over all elements replacing c-roster-card__ class with
	// modal__ class
	Array.from(cardClone.getElementsByTagName('*')).forEach(e => {
	  e.className = e.className.replace('c-roster-card__', 'modal__');
	});

	// Change cardClone's className to .modal__content (removing js-is-modal)
	cardClone.className = 'modal__content';

	return cardClone;
}

function clickedCloseButton() {
	console.log('close');
}

function clickedPrevButton() {
	console.log('prev');
}

function clickedNextButton() {
	console.log('next');
}

function clickedOutsideModalWrapper() {
	console.log('outside');
}