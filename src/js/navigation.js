/**
 * File navigation.js.
 *
 * Handles toggling the navigation menu for small screens and enables TAB key
 * navigation support for dropdown menus.
 */
export default function navigation() {
  const header = document.querySelector('.site-header');
  const menuContainer = document.querySelector('.site-header__nav');
  const menuBtn = document.querySelector('.site-header__menu-toggle-btn');
  const menus = menuContainer.getElementsByTagName('ul');

  // Return early if either the container, open, or close button
  // isn't found
  if (!menuContainer || !menuBtn) {
    return;
  }

  // Hide menu toggle button if menu is empty and return early.
  if (menus.length === 0) {
    menuBtn.style.display = 'none';
    return;
  }

  // Loop through menus setting initial aria-expanded attribute and
  // making sure '.nav-menu' class is present
  Array.from(menus).forEach((menu) => {
    menu.setAttribute('aria-expanded', 'false');
    menu.classList.add('nav-menu');
  });

  menuBtn.onclick = function () {
    // Positions nav container to be below header
    menuContainer.style.top = `${findTopCoord(header)}px`;
    // Sets menu nav container width to 100% when toggled
    menuContainer.classList.toggle('is-toggled');
    // Performs toggle btn transform animation
    menuBtn.classList.toggle('js-menu-is-open');
    // Toggles menu's aria-expanded attribute
    toggleMenuAria();
  };

  /**
   * Loops through menus altering aria-expanded attribute
   */
  function toggleMenuAria() {
    // Checks if menu container is toggled or not
    const val = menuContainer.classList.contains('is-toggled')
      ? 'true'
      : 'false';

    Array.from(menus).forEach((menu) => {
      menu.setAttribute('aria-expanded', `${val}`);
    });
  }

  /**
   * Returns elements needed top coordinate position
   */
  function findTopCoord(element) {
    const elementRect = element.getBoundingClientRect();
    const { scrollTop } = document.documentElement;
    const top = scrollTop + elementRect.top + elementRect.height;

    return top;
  }

  // Get all the link elements within the container
  const links = menuContainer.querySelectorAll('ul a');

  // Each time a menu link is focused or blurred, toggle focus.
  Array.from(links).forEach((link) => {
    link.addEventListener('focus', toggleFocus, true);
    link.addEventListener('blur', toggleFocus, true);
  });

  /**
   * Sets or removes .focus class on an element.
   */
  function toggleFocus() {
    let self = this;

    if (self.classList.contains('site-header__close-btn')) {
      return;
    }

    // Move up through the ancestors of the current link until we hit .nav-menu.
    while (self.className.indexOf('nav-menu') === -1) {
      // On li elements toggle the class .focus.
      if (self.tagName.toLowerCase() === 'li') {
        self.classList.toggle('focus');
      }

      self = self.parentElement;
    }
  }

  /**
   * Toggles `focus` class to allow submenu access on tablets.
   */
  (function (menuCon) {
    let touchStartFn;

    const parentLink = menuCon.querySelectorAll(
      '.menu-item-has-children > a, .page_item_has_children > a',
    );

    if ('ontouchstart' in window) {
      touchStartFn = function (e) {
        const menuItem = this.parentNode;
        let i;

        if (!menuItem.classList.contains('focus')) {
          e.preventDefault();
          for (i = 0; i < menuItem.parentNode.children.length; ++i) {
            if (menuItem !== menuItem.parentNode.children[i]) {
              menuItem.parentNode.children[i].classList.remove('focus');
            }
          }
          menuItem.classList.add('focus');
        } else {
          menuItem.classList.remove('focus');
        }
      };

      for (let i = 0; i < parentLink.length; ++i) {
        parentLink[i].addEventListener('touchstart', touchStartFn, false);
      }
    }
  }(menuContainer));
}
