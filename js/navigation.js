/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
( function() {
	var header, container, button, menus, links, i, len;

	header = document.getElementById( 'masthead' );
	header.setAttribute( 'data-expanded', 'false' );

	container = document.getElementById( 'site-navigation' );
	if ( ! container ) {
		return;
	}

	button = document.getElementsByClassName( 'menu-toggle' )[0];
	if ( 'undefined' === typeof button ) {
		return;
	}

	// Gets HTMLCollection of all menus under '.site-navigation' container
	menus = container.getElementsByTagName( 'ul' );

	// Hide menu toggle button if menu is empty and return early.
	if ( menus.length === 0 ) {
		button.style.display = 'none';
		return;
	}

	// Loop through menus setting initial aria-expanded attribute and 
	// making sure '.nav-menu' class is present
	for ( let menu of menus ) {
		// Add aria-expanded attribute and set to false
		menu.setAttribute( 'aria-expanded', 'false' );

		// Add '.nav-menu' class if menu element doesn't already have that class
		if ( -1 === menu.className.indexOf( 'nav-menu' ) ) {
			menu.className += ' nav-menu';
		}
	}

	button.onclick = function() {
		// If container has '.toggled' class
		if ( -1 !== container.className.indexOf( 'toggled' ) ) {
			container.className = container.className.replace( ' toggled', '' );
			button.setAttribute( 'aria-expanded', 'false' );
			// Set menus aria-expanded attribute to false
			menuLoop('false');
			button.innerHTML = '<i class="fas fa-bars fa-2x"></i>';
		} else {
			container.className += ' toggled';
			container.style.width = "100%";
			button.setAttribute( 'aria-expanded', 'true' );
			// Set menus aria-expanded attribute to true
			menuLoop('true');
			button.innerHTML = '<i class="fas fa-times fa-2x"></i>';
		}
	};

	// Get all the link elements within the container.
	links    = container.getElementsByTagName( 'a' );

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
				if ( -1 !== self.className.indexOf( 'focus' ) ) {
					self.className = self.className.replace( ' focus', '' );
				} else {
					self.className += ' focus';
				}
			}

			self = self.parentElement;
		}
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

	/**
	 * Toggles `focus` class to allow submenu access on tablets.
	 */
	( function( container ) {
		var touchStartFn, i,
			parentLink = container.querySelectorAll( '.menu-item-has-children > a, .page_item_has_children > a' );

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
	}( container ) );
} )();

function closeNav() {
	let container = document.querySelector('.site-header__nav');
	container.style.width = "0";
	
}