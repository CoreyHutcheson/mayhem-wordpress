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
	getCardDetails();




}

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

function getCardDetails() {
	let cardToBeModal = document.querySelector('.js-is-modal');
	let cardObject = {};
	traverseNode(cardObject, cardToBeModal);

	function traverseNode(obj, node) {
		let children = node.children;
		if(children.length > 0 ) {
			for(let child of children) {
				traverseNode(obj, child);
			}
		} else {
			let str = node.className.split('c-roster-card__');
			let keyName = str[1] ? str[1].split(' ')[0] : null;
			console.log(keyName);
			// obj[node.className] = node.textContent;
		}
	}

	console.log(cardObject);

}