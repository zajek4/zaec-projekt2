/**
 * Toggle mobilnog izbornika.
 */
( function () {
	var siteNavigation = document.getElementById( 'site-navigation' );

	if ( ! siteNavigation ) {
		return;
	}

	var button = siteNavigation.querySelector( '.menu-toggle' );

	if ( 'undefined' === typeof button ) {
		return;
	}

	button.addEventListener( 'click', function () {
		siteNavigation.classList.toggle( 'toggled' );

		if ( siteNavigation.classList.contains( 'toggled' ) ) {
			button.setAttribute( 'aria-expanded', 'true' );
		} else {
			button.setAttribute( 'aria-expanded', 'false' );
		}
	} );
} )();
