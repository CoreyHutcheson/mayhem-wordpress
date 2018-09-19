const choiceToggle = document.querySelector('.c-choice-toggle');
const mainRosterContainer = document.querySelector('.roster-container');
const rosterContainers = mainRosterContainer.children;
const modal = document.querySelector('.modal');

// Add click event to roster filter toggle
choiceToggle.addEventListener('click', (e) => {
  const { target } = e;
  if (target.nodeName.toLowerCase() !== 'label') {
    return;
  }

  toggleRosterContainers(target, rosterContainers);
});

// Add click event to more/details hover element
mainRosterContainer.addEventListener('click', (e) => {
  const { target } = e;
  if (!target.classList.contains('c-roster-card__hover-element')) {
    return;
  }

  displayModal(target);
});

// Add click event to modal buttons
modal.addEventListener('click', (e) => {
  const { target } = e;

  if (
    target.closest('.modal__close-btn')
    || target.classList.contains('modal')
  ) {
    // Close button or outside of modal-wrapper was clicked
    closeModal(modal);
  } else if (target.closest('.modal__prev-btn')) {
    assignNewModal(-1);
  } else if (target.closest('.modal__next-btn')) {
    assignNewModal(1);
  }
});


/**
 * Toggles display of appropriate roster divs
 * @param  {object - node} target : clicked toggle button
 * @param  {array - HTMLCollection} rosterContainers : children of mainRosterContainer
 * @return {undefined}
 */
function toggleRosterContainers(target, rosterContainers) {
  const value = target.getAttribute('for');
  const neededClass = `roster-container__${value}`;

  if (value === 'all') {
    // All toggle button was clicked.  Unhide all roster containers.
    Array.prototype.forEach.call(rosterContainers, rc => rc.classList.remove('is-hidden'));
    return;
  }

  // Loop through roster containers hiding all that don't have the needed class
  Array.prototype.forEach.call(rosterContainers, (rc) => {
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
function displayModal(target) {
  const clickedCard = target.closest('.c-roster-card');
  // Add overflow: hidden to body to stop scrolling
  document.body.classList.add('is-clipped');

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
}

/**
 * Removes 'js-is-modal' class from all cards
 * @return {undefined}
 */
function removeModalClassFromCards() {
  const allCards = document.querySelectorAll('.c-roster-card');
  Array.prototype.forEach.call(allCards, e => e.classList.remove('js-is-modal'));
}

/**
 * Adds 'js-is-modal' class to argument card
 * @param {object - node} card : Card to apply modal class to
 * @return {undefined}
 */
function addModalClassToCard(card) {
  card.classList.add('js-is-modal');
}

/**
 * Places created modal content into modal and displays the modal
 * @param  {object - node} cardToBeModal : the card to create the modal content from
 * @return {undefined}
 */
function populateModalContent(cardToBeModal) {
  /**
   * Clones card, and changes the classes from '.c-roster-card__' to '.modal__'
   * @param  {object - node} card : card to clone
   * @return {object - node} clone of card with changed classes
   */
  const getCardDetails = (card) => {
    const clone = card.cloneNode(true);
    const elements = clone.getElementsByTagName('*');

    Array.prototype.forEach.call(elements, (e) => {
      e.className = e.className.replace('c-roster-card__', 'modal__');
    });

    clone.className = 'modal__content';

    return clone;
  };

  const modalContentElement = document.querySelector('.js-modal-content');
  const newModalDetails = getCardDetails(cardToBeModal);

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
 * Closes the modal by adding 'is-hidden' class and removing all 'js-is-modal'
 * classes from cards
 * @param  {object - node} modal - document.querySelector('.modal');
 * @return {undefined}
 */
function closeModal(modal) {
  // Add hidden class to modal
  modal.classList.add('is-hidden');
  removeModalClassFromCards();
  // Remove overflow:hidden from body so scrolling is available again
  document.body.classList.remove('is-clipped');
}

/**
 * Changes current modal card
 * @param  {number} num : positive or negative value indicating whether
 *                        to increase or decrease the current modal index
 * @return {undefined}
 */
function assignNewModal(num) {
  /**
   * Gets newIndex by finding current card with 'js-is-modal' class and adding
   * the [pos/neg] num to it
   * @param  {array - nodeList} cards : list of all '.c-roster-card' cards
   * @param  {number} : number to add to oldIndex
   * @return {number} : new index value
   */
  const getNewIndex = (cards, num) => {
    const oldIndex = Array.prototype.findIndex.call(cards, x => x.classList.contains('js-is-modal'));
    const newIndex = oldIndex + num;
    return newIndex < 0 ? cards.length - 1 : newIndex % cards.length;
  };

  const allCards = document.querySelectorAll('.c-roster-card');
  const newIndex = getNewIndex(allCards, num);
  const newCard = allCards[newIndex];

  displayModal(newCard);
}
