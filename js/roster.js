/**
 * Shows and Hides the appropriate roster divs when toggle button
 * changes
 */
(function() {
	let choiceContainer = document.querySelector('.c-choice-toggle');
	let rosterContainers = document.querySelectorAll('.roster-container > div');

	choiceContainer.addEventListener('click', function(e) {
		let target = e.target;

		if (target.nodeName !== 'LABEL') return;

		let value = target.getAttribute('for');
		let neededClass = `roster-container__${value}`;

		for (let container of rosterContainers) {
			if (value === 'all') {
				container.classList.remove('hide');
			} else if (!container.classList.contains(`roster-container__${value}`)) {
				container.classList.add('hide');
			} else {
				container.classList.remove('hide');
			}
		}
	});

})();