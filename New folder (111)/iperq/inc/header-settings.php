<?php
/**
 * IPERQ Header settings.
 *
 * Settings > Header controls the shared site logo. Header positioning and
 * responsive behaviour are part of the theme and are intentionally not
 * configurable: the header is always fixed, with the desktop scroll morph
 * handled by the frontend component.
 *
 * The logo is synchronized with WordPress' native custom_logo theme mod so
 * Header settings and Appearance > Customize > Site Identity stay in sync.
 *
 * @package Custom_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Header settings defaults.
 *
 * @return array<string, mixed>
 */
function custom_theme_header_settings_defaults() {
	return array(
		'logo_id' => absint( get_theme_mod( 'custom_logo', 0 ) ),
	);
}

/**
 * Get header settings while treating the native custom logo as source of truth.
 *
 * @return array<string, mixed>
 */
function custom_theme_get_header_settings() {
	return array(
		'logo_id' => absint( get_theme_mod( 'custom_logo', 0 ) ),
	);
}

/**
 * Return the theme's designed fallback logo URL.
 *
 * @return string
 */
function custom_theme_get_header_default_logo_url() {
	return get_template_directory_uri() . '/assets/images/header/iperq-logo-white.png';
}

/**
 * Return the logo URL used by the header.
 *
 * When no WordPress custom logo is selected, the theme's designed IPERQ logo
 * remains the fallback so installing/updating the theme never breaks the header.
 *
 * @return string
 */
function custom_theme_get_header_logo_url() {
	$logo_id = absint( get_theme_mod( 'custom_logo', 0 ) );

	if ( $logo_id ) {
		$url = wp_get_attachment_image_url( $logo_id, 'full' );
		if ( $url ) {
			return $url;
		}
	}

	return custom_theme_get_header_default_logo_url();
}

/**
 * Sanitize Header settings and synchronize logo with WordPress Custom Logo.
 *
 * Returning only logo_id intentionally drops legacy fixed/fixed_mode values
 * the next time the settings page is saved.
 *
 * @param mixed $input Submitted option.
 * @return array<string, mixed>
 */
function custom_theme_sanitize_header_settings( $input ) {
	$input   = is_array( $input ) ? $input : array();
	$logo_id = isset( $input['logo_id'] ) ? absint( $input['logo_id'] ) : 0;

	if ( $logo_id && 'attachment' === get_post_type( $logo_id ) ) {
		set_theme_mod( 'custom_logo', $logo_id );
	} else {
		$logo_id = 0;
		remove_theme_mod( 'custom_logo' );
	}

	return array(
		'logo_id' => $logo_id,
	);
}

/**
 * Register Header settings.
 */
function custom_theme_register_header_settings() {
	register_setting(
		'iperq_header_settings_group',
		'iperq_header_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'custom_theme_sanitize_header_settings',
			'default'           => custom_theme_header_settings_defaults(),
		)
	);
}
add_action( 'admin_init', 'custom_theme_register_header_settings' );

/**
 * Keep the Header option mirror synchronized when the logo is changed through
 * Appearance > Customize > Site Identity. Rewriting the option here also cleans
 * up legacy fixed-header settings that are no longer used by the theme.
 */
function custom_theme_sync_header_logo_from_customizer() {
	update_option(
		'iperq_header_settings',
		array(
			'logo_id' => absint( get_theme_mod( 'custom_logo', 0 ) ),
		)
	);
}
add_action( 'customize_save_after', 'custom_theme_sync_header_logo_from_customizer' );

/**
 * Add Settings > Header.
 */
function custom_theme_add_header_settings_page() {
	add_options_page(
		__( 'Header', 'custom-theme' ),
		__( 'Header', 'custom-theme' ),
		'manage_options',
		'iperq-header-settings',
		'custom_theme_render_header_settings_page'
	);
}
add_action( 'admin_menu', 'custom_theme_add_header_settings_page' );

/**
 * Load Header settings admin assets only where needed.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function custom_theme_header_settings_admin_assets( $hook_suffix ) {
	if ( 'settings_page_iperq-header-settings' !== $hook_suffix ) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_style(
		'custom-theme-component-settings',
		get_template_directory_uri() . '/assets/css/admin-component-settings.css',
		array(),
		CUSTOM_THEME_VERSION
	);

	wp_enqueue_style(
		'custom-theme-header-settings',
		get_template_directory_uri() . '/assets/css/admin-header-settings.css',
		array( 'custom-theme-component-settings' ),
		CUSTOM_THEME_VERSION
	);

	wp_enqueue_script(
		'custom-theme-header-settings',
		get_template_directory_uri() . '/assets/js/admin-header-settings.js',
		array( 'jquery' ),
		CUSTOM_THEME_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'custom_theme_header_settings_admin_assets' );

/**
 * Render Settings > Header.
 */
function custom_theme_render_header_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings         = custom_theme_get_header_settings();
	$logo_id          = absint( $settings['logo_id'] );
	$logo_url         = custom_theme_get_header_logo_url();
	$default_logo_url = custom_theme_get_header_default_logo_url();
	?>
	<div class="wrap iperq-header-settings">
		<div class="iperq-admin-hero">
			<div class="iperq-admin-hero__content">
				<div class="iperq-admin-hero__eyebrow"><span class="dashicons dashicons-menu" aria-hidden="true"></span><?php esc_html_e( 'Global site component', 'custom-theme' ); ?></div>
				<h1><?php esc_html_e( 'Header', 'custom-theme' ); ?></h1>
				<p><?php esc_html_e( 'Manage the shared site logo. Navigation remains managed through WordPress menus; fixed and responsive behaviour is controlled by the theme.', 'custom-theme' ); ?></p>
			</div>
			<div class="iperq-admin-hero__actions">
				<span class="iperq-status-pill"><span class="iperq-status-pill__dot"></span><?php esc_html_e( 'Customizer synced', 'custom-theme' ); ?></span>
				<a class="button iperq-view-site" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-external" aria-hidden="true"></span><?php esc_html_e( 'View site', 'custom-theme' ); ?></a>
			</div>
		</div>

		<?php settings_errors(); ?>

		<form action="options.php" method="post" data-header-settings-form>
			<?php settings_fields( 'iperq_header_settings_group' ); ?>

			<div class="iperq-settings-shell">
				<aside class="iperq-settings-sidebar" aria-label="<?php esc_attr_e( 'Header sections', 'custom-theme' ); ?>">
					<div class="iperq-settings-sidebar__inner">
						<span class="iperq-settings-sidebar__title"><?php esc_html_e( 'Header sections', 'custom-theme' ); ?></span>
						<nav class="iperq-settings-nav">
							<a href="#header-brand" class="is-active"><span>01</span><?php esc_html_e( 'Branding', 'custom-theme' ); ?></a>
						</nav>
						<div class="iperq-settings-sidebar__note">
							<span class="dashicons dashicons-admin-customizer" aria-hidden="true"></span>
							<div>
								<strong><?php esc_html_e( 'One shared logo', 'custom-theme' ); ?></strong>
								<p><?php esc_html_e( 'Changing it here also updates Customize > Site Identity, and vice versa.', 'custom-theme' ); ?></p>
							</div>
						</div>
					</div>
				</aside>

				<main class="iperq-settings-content">
					<section id="header-brand" class="iperq-settings-card" data-settings-section>
						<div class="iperq-settings-card__header">
							<div class="iperq-settings-card__index">01</div>
							<div>
								<h2><?php esc_html_e( 'Logo', 'custom-theme' ); ?></h2>
								<p><?php esc_html_e( 'The header logo is synchronized with WordPress Custom Logo. The theme automatically applies the designed white full-header and purple compact treatment.', 'custom-theme' ); ?></p>
							</div>
						</div>

						<div class="iperq-header-logo-card" data-media-field data-default-logo="<?php echo esc_url( $default_logo_url ); ?>">
							<div class="iperq-header-logo-preview" data-media-preview>
								<?php if ( $logo_url ) : ?>
									<img src="<?php echo esc_url( $logo_url ); ?>" alt="">
								<?php endif; ?>
							</div>
							<div class="iperq-header-logo-card__content">
								<span class="iperq-field__label"><?php esc_html_e( 'Site logo', 'custom-theme' ); ?></span>
								<p><?php esc_html_e( 'Use a transparent SVG or PNG for the cleanest result. The same asset is used throughout the header and stays linked to Site Identity.', 'custom-theme' ); ?></p>
								<input type="hidden" data-media-id name="iperq_header_settings[logo_id]" value="<?php echo esc_attr( $logo_id ); ?>">
								<div class="iperq-header-logo-card__actions">
									<button type="button" class="button button-secondary iperq-header-logo-select"><span class="dashicons dashicons-format-image" aria-hidden="true"></span><?php esc_html_e( 'Choose logo', 'custom-theme' ); ?></button>
									<button type="button" class="button-link-delete iperq-header-logo-remove"><?php esc_html_e( 'Remove custom logo', 'custom-theme' ); ?></button>
								</div>
								<div class="iperq-sync-note"><span class="dashicons dashicons-update" aria-hidden="true"></span><?php esc_html_e( 'Automatically synchronized with Appearance > Customize > Site Identity.', 'custom-theme' ); ?></div>
							</div>
						</div>
					</section>
				</main>
			</div>

			<div class="iperq-settings-save" data-save-bar>
				<div class="iperq-save-status">
					<span class="iperq-save-status__dot" aria-hidden="true"></span>
					<div>
						<strong data-save-state><?php esc_html_e( 'All changes saved', 'custom-theme' ); ?></strong>
						<span><?php esc_html_e( 'Header layout, fixed positioning and responsive behaviour are controlled by the theme.', 'custom-theme' ); ?></span>
					</div>
				</div>
				<?php submit_button( __( 'Save header', 'custom-theme' ), 'primary', 'submit', false ); ?>
			</div>
		</form>
	</div>
	<?php
}
