<?php
/**
 * Custom Starter Theme functions and definitions.
 *
 * @package Custom_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Izlaz ako se datoteci pristupa direktno.
}

define( 'CUSTOM_THEME_VERSION', '1.0.52' );

/**
 * Postavljanje teme (theme support, meniji, image sizes...)
 */
function custom_theme_setup() {
	// Prijevod teme.
	load_theme_textdomain( 'custom-theme', get_template_directory() . '/languages' );

	// Automatski <title> tag.
	add_theme_support( 'title-tag' );

	// Istaknuta slika (featured image).
	add_theme_support( 'post-thumbnails' );
	set_post_thumbnail_size( 1200, 675, true );
	add_image_size( 'custom-theme-thumb-small', 400, 250, true );

	// HTML5 markup podrška.
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
			'navigation-widgets',
		)
	);

	// Podrška za widgete u customizeru (logo).
	add_theme_support( 'custom-logo', array(
		'height'      => 100,
		'width'       => 300,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// RSS feed linkovi u <head>.
	add_theme_support( 'automatic-feed-links' );

	// Podrška za Gutenberg / block editor stilove.
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'assets/css/design-tokens.css', 'assets/css/fonts.css', 'assets/css/editor-style.css' ) );

	// Registracija navigacijskih menija.
	register_nav_menus(
		array(
			'primary'      => esc_html__( 'Glavni izbornik', 'custom-theme' ),
			'header_left'  => esc_html__( 'Header Menu 1 — lijevo', 'custom-theme' ),
			'header_right' => esc_html__( 'Header Menu 2 — desno', 'custom-theme' ),
		)
	);
}
add_action( 'after_setup_theme', 'custom_theme_setup' );

/**
 * Postavljanje širine sadržaja (za embedove, slike...).
 */
function custom_theme_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'custom_theme_content_width', 800 );
}
add_action( 'after_setup_theme', 'custom_theme_content_width', 0 );

/**
 * Registracija widget područja.
 *
 * Footer više ne koristi widgete; sadržaj se uređuje kroz Postavke > Footer.
 */
function custom_theme_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Bočna traka', 'custom-theme' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Dodajte widgete ovdje.', 'custom-theme' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'custom_theme_widgets_init' );


/**
 * Custom templates that manage their own full-width content area.
 * Header and footer remain global; only the generic .site-content/.container
 * wrapper is skipped so these layouts retain their designed width.
 */
function custom_theme_is_business_landing() {
	return is_page_template( 'naslovnica.php' );
}

/**
 * Pricing template helper.
 */
function custom_theme_is_pricing_page() {
	return is_page_template( 'template-parts/pricing-page.php' );
}

/**
 * Custom templates that manage their own full-width content area.
 */
function custom_theme_is_full_width_layout() {
	if ( custom_theme_is_business_landing() ) {
		return true;
	}

	return is_page_template(
		array(
			'naslovnica.php',
			'template-parts/pricing-page.php',
			'template-scroll-phone-demo.php',
		)
	);
}

/**
 * Učitavanje stilova i skripti.
 */
function custom_theme_scripts() {
	$is_business_landing = custom_theme_is_business_landing();
	$is_pricing_page     = custom_theme_is_pricing_page();
	$is_scroll_phone_demo = is_page_template( 'template-scroll-phone-demo.php' );
	$is_legacy_front      = is_page_template( 'naslovnica-v1.php' );

	/* Global IPERQ design tokens are loaded on every frontend template. */
	wp_enqueue_style(
		'custom-theme-design-tokens',
		get_template_directory_uri() . '/assets/css/design-tokens.css',
		array(),
		CUSTOM_THEME_VERSION
	);

	/*
	 * Naslovnica V1 remains an intentionally isolated full-screen experience.
	 * front-page.php is intentionally disabled as front-page-OFF.php so WordPress
 * respects the page/template selected under Settings -> Reading.
	 */
	if ( $is_legacy_front ) {
		wp_enqueue_style(
			'custom-theme-site-header',
			get_template_directory_uri() . '/assets/css/site-header.css',
			array( 'custom-theme-design-tokens' ),
			CUSTOM_THEME_VERSION
		);


		wp_enqueue_style(
			'custom-theme-fonts',
			get_template_directory_uri() . '/assets/css/fonts.css',
			array( 'custom-theme-design-tokens' ),
			CUSTOM_THEME_VERSION
		);

		wp_enqueue_script(
			'custom-theme-navigation',
			get_template_directory_uri() . '/js/navigation.js',
			array(),
			CUSTOM_THEME_VERSION,
			true
		);

		return;
	}


	wp_enqueue_style(
		'custom-theme-fonts',
		get_template_directory_uri() . '/assets/css/fonts.css',
		array( 'custom-theme-design-tokens' ),
		CUSTOM_THEME_VERSION
	);

	/*
	 * Global stylesheet contains the base theme styles plus the isolated
	 * .business-page section. Header and footer remain separate components.
	 */
	wp_enqueue_style(
		'custom-theme-style',
		get_stylesheet_uri(),
		array( 'custom-theme-fonts' ),
		CUSTOM_THEME_VERSION
	);

	wp_enqueue_style(
		'custom-theme-business-header',
		get_template_directory_uri() . '/assets/css/header.css',
		array( 'custom-theme-style' ),
		CUSTOM_THEME_VERSION
	);

	wp_enqueue_style(
		'custom-theme-business-footer',
		get_template_directory_uri() . '/assets/css/footer.css',
		array( 'custom-theme-style' ),
		CUSTOM_THEME_VERSION
	);

	if ( $is_pricing_page ) {
		wp_enqueue_style(
			'custom-theme-pricing',
			get_template_directory_uri() . '/assets/css/pricing.css',
			array( 'custom-theme-style', 'custom-theme-business-footer' ),
			CUSTOM_THEME_VERSION
		);
	}

	wp_enqueue_script(
		'custom-theme-business-header',
		get_template_directory_uri() . '/assets/js/header.js',
		array(),
		CUSTOM_THEME_VERSION,
		true
	);

	if ( $is_pricing_page ) {
		wp_enqueue_script(
			'custom-theme-pricing',
			get_template_directory_uri() . '/assets/js/pricing-page.js',
			array(),
			CUSTOM_THEME_VERSION,
			true
		);
	}

	if ( $is_business_landing ) {
		wp_enqueue_script(
			'custom-theme-business-page',
			get_template_directory_uri() . '/assets/js/business-page.js',
			array(),
			CUSTOM_THEME_VERSION,
			true
		);
	} elseif ( ! $is_scroll_phone_demo ) {
		wp_enqueue_script(
			'custom-theme-main',
			get_template_directory_uri() . '/js/main.js',
			array(),
			CUSTOM_THEME_VERSION,
			true
		);
	}

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'custom_theme_scripts' );

/**
 * Preload only the fonts that directly affect the first hero paint.
 *
 * The large hero heading uses Author Bold, the hero copy uses Satoshi Regular,
 * and the primary hero controls use Satoshi Bold. Other weights remain normal
 * on-demand WOFF2 requests so we do not compete with the hero visual for bandwidth.
 */
function custom_theme_preload_critical_fonts() {
	if ( ! custom_theme_is_business_landing() && ! custom_theme_is_pricing_page() ) {
		return;
	}

	$font_base = get_template_directory_uri() . '/assets/fonts/';
	$fonts     = array(
		$font_base . 'author/Author-Bold.woff2',
		$font_base . 'satoshi/Satoshi-Regular.woff2',
		$font_base . 'satoshi/Satoshi-Bold.woff2',
	);

	foreach ( $fonts as $font_url ) {
		echo '<link rel="preload" href="' . esc_url( $font_url ) . '" as="font" type="font/woff2" crossorigin>' . "\n";
	}
}
add_action( 'wp_head', 'custom_theme_preload_critical_fonts', 2 );

/**
 * Dodatne datoteke iz inc/ mape.
 */
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/template-functions.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/header-settings.php';
require get_template_directory() . '/inc/footer-settings.php';


/**
 * Preload the GLB model only on the 3D demo template.
 */
function custom_theme_scroll_phone_preload() {
	if ( ! is_page_template( 'template-scroll-phone-demo.php' ) ) {
		return;
	}

	$model_url = get_template_directory_uri() . '/assets/models/Mobitel-ekran_restorana.glb';
	echo '<link rel="preload" href="' . esc_url( $model_url ) . '" as="fetch" type="model/gltf-binary" crossorigin="anonymous" fetchpriority="high">' . "\n";
}
add_action( 'wp_head', 'custom_theme_scroll_phone_preload', 1 );

/**
 * Skini verzijski query string s CSS/JS-a produkcijski nije nužno,
 * ali evo primjera custom body_class filtera.
 */
function custom_theme_body_classes( $classes ) {
	if ( is_page_template( 'template-scroll-phone-demo.php' ) ) {
		$classes[] = 'scroll-phone-template';
	}

	if ( is_active_sidebar( 'sidebar-1' ) && ! is_page_template( 'template-full-width.php' ) ) {
		$classes[] = 'has-sidebar';
	}

	if ( ! is_active_sidebar( 'sidebar-1' ) ) {
		$classes[] = 'no-sidebar';
	}

	return $classes;
}
add_filter( 'body_class', 'custom_theme_body_classes' );

/**
 * Excerpt - duljina i "..." zamjena.
 */
function custom_theme_excerpt_length( $length ) {
	return 30;
}
add_filter( 'excerpt_length', 'custom_theme_excerpt_length' );

function custom_theme_excerpt_more( $more ) {
	return '&hellip;';
}
add_filter( 'excerpt_more', 'custom_theme_excerpt_more' );
