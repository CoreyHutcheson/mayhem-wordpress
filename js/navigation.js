/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var menuContainer, openBtn, closeBtn, menus, links;

	menuContainer = document.querySelector( '.site-header__nav' );
	openBtn = document.querySelector('.site-header__open-btn');
	closeBtn = document.querySelector('.site-header__close-btn');
	// Gets HTMLCollection of all menus under '#site-navigation' container
	menus = menuContainer.getElementsByTagName( 'ul' );

	// Return early if either the container, open, or close button
	// isn't found
	if (!menuContainer || !openBtn || !closeBtn) {
		return;
	}

	// Hide menu toggle button if menu is empty and return early.
	if ( menus.length === 0 ) {
		openBtn.style.display = 'none';
		return;
	}

	// Loop through menus setting initial aria-expanded attribute and 
	// making sure '.nav-menu' class is present
	Array.from(menus).forEach(function(menu) {
		menu.setAttribute( 'aria-expanded', 'false' );
		menu.classList.add('nav-menu');
	});

	openBtn.onclick = function() {
		// Changes menuContainer width to 100%
		menuContainer.classList.add('is-toggled');
		// Sets aria-expanded attribute to true
		menuLoop('true');
	};

	closeBtn.onclick = function() {
		// Changes menuContainer width to 0%
		menuContainer.classList.remove('is-toggled');
		// Sets aria-expanded attribute to false
		menuLoop('false');
	}

	/**
	 * Loops through menus altering aria-expanded attribute
	 */
	function menuLoop(val) {
		for (let menu of menus) {
			menu.setAttribute( 'aria-expanded', `${val}` );
		}
		return;
	}

	// Get all the link elements within the container, excluding
	// the closeBtn link
	links = menuContainer.querySelectorAll('ul a');

	// Each time a menu link is focused or blurred, toggle focus.
	for ( let link of links) {
		link.addEventListener( 'focus', toggleFocus, true );
		link.addEventListener( 'blur', toggleFocus, true );
	}

	/**
	 * Sets or removes .focus class on an element.
	 */
	function toggleFocus() {
		var self = this;

		if (self.classList.contains('site-header__close-btn')) {
			return;
		}

		// Move up through the ancestors of the current link until we hit .nav-menu.
		while ( -1 === self.className.indexOf( 'nav-menu' ) ) {

			// On li elements toggle the class .focus.
			if ( 'li' === self.tagName.toLowerCase() ) {
				self.classList.toggle('focus');
			}

			self = self.parentElement;
		}
	}

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( menuContainer ) {
		var touchStartFn, i,
			parentLink = menuContainer.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

		if ( 'ontouchstart' in window ) {
			touchStartFn = function( e ) {
				var menuItem = this.parentNode, i;

				if ( ! menuItem.classList.contains( 'focus' ) ) {
					e.preventDefault();
					for ( i = 0; i < menuItem.parentNode.children.length; ++i ) {
						if ( menuItem === menuItem.parentNode.children[i] ) {
							continue;
						}
						menuItem.parentNode.children[i].classList.remove( 'focus' );
					}
					menuItem.classList.add( 'focus' );
				} else {
					menuItem.classList.remove( 'focus' );
				}
			};

			for ( i = 0; i < parentLink.length; ++i ) {
				parentLink[i].addEventListener( 'touchstart', touchStartFn, false );
			}
		}
	}( menuContainer ) );
} )();
