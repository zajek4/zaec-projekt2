<?php
/**
 * Funkcije koje poboljšavaju / mijenjaju markup teme.
 *
 * @package Custom_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Dodaj klasu 'no-js' na <html> koja se skida JS-om (za progresivno poboljšanje).
 */
function custom_theme_html_class_script() {
	echo "<script>document.documentElement.classList.remove('no-js');document.documentElement.classList.add('js');</script>\n";
}
add_action( 'wp_head', 'custom_theme_html_class_script', 0 );

/**
 * Ukloni verzijski query string s CSS i JS datoteka (opcionalno, za bolji cache).
 */
function custom_theme_remove_script_version( $src ) {
	if ( strpos( $src, 'ver=' ) ) {
		$src = remove_query_arg( 'ver', $src );
	}
	return $src;
}
// Otkomentirajte sljedeće dvije linije ako želite ukloniti ?ver= iz assets URL-ova:
// add_filter( 'script_loader_src', 'custom_theme_remove_script_version' );
// add_filter( 'style_loader_src', 'custom_theme_remove_script_version' );

/**
 * Dodaj responsive wrapper oko embed videa (YouTube i sl.).
 */
function custom_theme_embed_wrap( $html ) {
	return '<div class="responsive-embed">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'custom_theme_embed_wrap', 10, 1 );

/**
 * Ukloni WP verziju iz <head> radi sigurnosti.
 */
function custom_theme_remove_version() {
	return '';
}
add_filter( 'the_generator', 'custom_theme_remove_version' );
