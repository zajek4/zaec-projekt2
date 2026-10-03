<?php
/**
 * Custom Theme Customizer postavke.
 *
 * @package Custom_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registracija postavki i kontrola u Customizeru.
 *
 * @param WP_Customize_Manager $wp_customize Customizer objekt.
 */
function custom_theme_customize_register( $wp_customize ) {

	// Promijeni tekst za "Naziv stranice" sekciju (opcionalno).
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	// Sekcija: Boje teme.
	$wp_customize->add_section(
		'custom_theme_colors',
		array(
			'title'    => esc_html__( 'Boje teme', 'custom-theme' ),
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'custom_theme_accent_color',
		array(
			'default'           => '#0073aa',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'postMessage',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'custom_theme_accent_color',
			array(
				'label'   => esc_html__( 'Boja isticanja (linkovi, gumbi)', 'custom-theme' ),
				'section' => 'custom_theme_colors',
			)
		)
	);
}
add_action( 'customize_register', 'custom_theme_customize_register' );

/**
 * Ispis inline stilova iz Customizer postavki u <head>.
 */
function custom_theme_customize_css() {
	$accent = get_theme_mod( 'custom_theme_accent_color', '#0073aa' );
	?>
	<style type="text/css">
		a,
		.pagination .page-numbers.current,
		button,
		input[type="submit"] {
			color: <?php echo esc_html( $accent ); ?>;
		}
		.pagination .page-numbers.current,
		button,
		input[type="submit"] {
			background: <?php echo esc_html( $accent ); ?>;
			color: #fff;
			border-color: <?php echo esc_html( $accent ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'custom_theme_customize_css' );

/**
 * Live preview binds (JS) za Customizer - opcionalno, potrebna datoteka js/customizer.js.
 */
function custom_theme_customize_preview_js() {
	wp_enqueue_script(
		'custom-theme-customizer',
		get_template_directory_uri() . '/js/customizer.js',
		array( 'customize-preview' ),
		CUSTOM_THEME_VERSION,
		true
	);
}
add_action( 'customize_preview_init', 'custom_theme_customize_preview_js' );
