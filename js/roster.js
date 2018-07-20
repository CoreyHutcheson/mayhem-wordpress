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

		if (target.closest('.modal__close-btn') || 
			target.classList.contains('modal')) {
			closeModal();
		} else if (target.closest('.modal__prev-btn')) {
			clickedPrevButton();
		} else if (target.closest('.modal__next-btn')) {
			clickedNextButton();
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
	populateModalContent(clickedCard);
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
function populateModalContent(cardToBeModal) {

	let modalContentElement = document.querySelector('.js-modal-content');
	let newModalDetails = getCardDetails(cardToBeModal);

	// Clear current modal content
	while (modalContentElement.firstChild) {
		modalContentElement.removeChild(modalContentElement.firstChild);
	}

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

function closeModal() {
	// Add hidden class to modal
	let modal = document.querySelector('.modal');
	modal.classList.add('is-hidden');

	// Remove js-is-modal class from all cards
	let allCards = document.querySelectorAll('.c-roster-card');
	Array.from(allCards).forEach(e => e.classList.remove('js-is-modal'));
}

function clickedPrevButton() {
	assignNewModal(-1);
}

function clickedNextButton() {
	assignNewModal(1);
}

function assignNewModal(num) {
	let allCards = Array.from(document.querySelectorAll('.c-roster-card'));
	let currentIndex = allCards.findIndex(x => x.classList.contains('js-is-modal'));
	let newIndex = currentIndex + num;
	newIndex = (newIndex < 0) ? (allCards.length - 1) : (newIndex % allCards.length);

	// Remove js-is-modal class from current card
	allCards[currentIndex].classList.remove('js-is-modal');
	// Assign js-is-modal class to new card to become modal
	allCards[newIndex].classList.add('js-is-modal');

	populateModalContent(allCards[newIndex]);
}