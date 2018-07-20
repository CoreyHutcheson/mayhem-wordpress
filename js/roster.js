(function() {
	const choiceContainer = document.querySelector('.c-choice-toggle');
	const mainRosterContainer = document.querySelector('.roster-container');
	const rosterContainers = mainRosterContainer.children;
	const modal = document.querySelector('.modal');

	// Add click event to roster filter toggle
	choiceContainer.addEventListener('click', function(e) {
		let target = e.target;
		if (target.nodeName.toLowerCase() !== 'label') 
			return;

		clickedChoiceToggle(target, rosterContainers);
		return;
	});

	// Add click event to more/details hover element
	mainRosterContainer.addEventListener('click', function(e) {
		let target = e.target;
		if (!target.classList.contains('c-roster-card__hover-element')) 
			return;

		clickedHoverElement(target);
		return;
	})

	// Add click event to modal buttons
	modal.addEventListener('click', function(e) {
		let target = e.target;

		if (target.closest('.modal__close-btn') || target.classList.contains('modal')) {
			// Close button or outside of modal-wrapper was clicked
			closeModal(modal);
		} else if (target.closest('.modal__prev-btn')) {
			assignNewModal(-1);
		} else if (target.closest('.modal__next-btn')) {
			assignNewModal(1);
		}
	})

})();

/**
 * Toggles display of appropriate roster divs
 * @param  {object - node} target : clicked hover element
 * @param  {array - HTMLCollection} rosterContainers : children of mainRosterContainer
 * @return {undefined}
 */
function clickedChoiceToggle(target, rosterContainers) {
	let value = target.getAttribute('for');
	let neededClass = `roster-container__${value}`;

	if (value === 'all') {
		// All toggle button was clicked.  Unhide all roster containers.
		Array.prototype.forEach.call(rosterContainers, rc => rc.classList.remove('is-hidden'));
		return;
	}

	// Loop through roster containers hiding all that don't have the needed class
	Array.prototype.forEach.call(rosterContainers, rc => {
		if (!rc.classList.contains(neededClass)) {
			rc.classList.add('is-hidden');
		} else {
			rc.classList.remove('is-hidden');
		}
	});
}

/**
 * Expands clicked card to modal
 * @param  {object - node} target : clicked details hover element
 * @return {undefined}
 */
function clickedHoverElement(target) {
	let clickedCard = target.closest('.c-roster-card');

	applyCardModalClass(clickedCard);
	populateModalContent(clickedCard);
}

/**
 * Applies 'js-is-modal' class to appropriate card, removing all other instances of the class
 * @param  {object - node} card : The card that should have 'js-is-modal' class added to it
 * @return {undefined}
 */
function applyCardModalClass(card) {
	removeModalClassFromCards();
	addModalClassToCard(card);
	return;
}

/**
 * Removes 'js-is-modal' class from all cards
 * @return {undefined}
 */
function removeModalClassFromCards() {
	let allCards = document.querySelectorAll('.c-roster-card');
	Array.prototype.forEach.call(allCards, e => e.classList.remove('js-is-modal'));
	return;
}

/**
 * Adds 'js-is-modal' class to argument card
 * @param {object - node} card [description]
 * @return {undefined}
 */
function addModalClassToCard(card) {
	card.classList.add('js-is-modal');
	return;
}

/**
 * [populateModalContent description]
 * @param  {[type]} cardToBeModal [description]
 * @return {[type]}               [description]
 */
function populateModalContent(cardToBeModal) {
	/**
	 * Clones card, and changes the classes from '.c-roster-card__' to '.modal__'
	 * @param  {object - node} card : card to clone
	 * @return {object - node} clone of card with changed classes
	 */
	const getCardDetails = (card) => {
		let clone = card.cloneNode(true);
		let elements = clone.getElementsByTagName('*');

		Array.prototype.forEach.call(elements, e => {
			e.className = e.className.replace('c-roster-card__', 'modal__');
		});

		clone.className = 'modal__content';

		return clone;
	};

	let modalContentElement = document.querySelector('.js-modal-content');
	let newModalDetails = getCardDetails(cardToBeModal);

	cleanNode(modalContentElement);
	modalContentElement.appendChild(newModalDetails);
	// Remove the modal .is-hidden class if applicable
	document.querySelector('.modal').classList.remove('is-hidden');
}

/**
 * Removes all child elements from a given node
 * @param  {object - node} node : the node that is to be cleaned
 * @return {undefined}
 */
function cleanNode(node) {
	while (node.firstChild) {
		node.removeChild(node.firstChild);
	}
}

/**
 * Closes the modal by adding 'is-hidden' class and removing all 'js-is-modal' classes from cards
 * @param  {object - node} modal - document.querySelector('.modal');
 * @return {undefined}
 */
function closeModal(modal) {
	// Add hidden class to modal
	modal.classList.add('is-hidden');
	removeModalClassFromCards();
}

/**
 * Changes current modal card
 * @param  {number} num : positive or negative value indicating whether to increase or decrease the current modal index
 * @return {undefined}
 */
function assignNewModal(num) {
	/**
	 * Gets newIndex by finding current card with 'js-is-modal' class and adding the [pos/neg] num to it
	 * @param  {array - nodeList} cards : list of all '.c-roster-card' cards
	 * @param  {number} : number to add to oldIndex
	 * @return {number} : new index value
	 */
	const getNewIndex = (cards, num) => {
		let oldIndex = Array.prototype.findIndex.call(cards, x => x.classList.contains('js-is-modal'));
		let newIndex = oldIndex + num;
		return (newIndex < 0) ? (cards.length - 1) : (newIndex % cards.length);
	};

	let allCards = document.querySelectorAll('.c-roster-card');
	let newIndex = getNewIndex(allCards, num);
	let newCard = allCards[newIndex];

	applyCardModalClass(newCard);
	populateModalContent(newCard);
}