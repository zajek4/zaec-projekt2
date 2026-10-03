/**
 * Live preview bindovi za WP Customizer.
 */
( function ( $ ) {

	// Naziv stranice.
	wp.customize( 'blogname', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );

	// Opis stranice.
	wp.customize( 'blogdescription', function ( value ) {
		value.bind( function ( to ) {
			$( '.site-description' ).text( to );
		} );
	} );

	// Boja isticanja - jednostavan live preview (osvježi CSS varijable po potrebi).
	wp.customize( 'custom_theme_accent_color', function ( value ) {
		value.bind( function ( to ) {
			$( 'a, .pagination .page-numbers.current, button, input[type="submit"]' ).css( 'color', to );
		} );
	} );

} )( jQuery );
