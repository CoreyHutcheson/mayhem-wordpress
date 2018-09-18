import navigation from './navigation';
import skipLinkFocusFix from './skip-link-focus-fix';
// import customizer from './customizer.js';
import roster from './roster';
import '../sass/style.scss';

navigation();
skipLinkFocusFix();
// customizer(jQuery);
if (window.location.pathname === '/roster/') {
	roster();	
}
