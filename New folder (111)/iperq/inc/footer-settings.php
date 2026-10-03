<?php
/**
 * IPERQ footer settings.
 *
 * Provides a dedicated Settings > Footer screen while keeping the frontend
 * markup and styling controlled by the theme.
 *
 * @package Custom_Theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Default footer content.
 *
 * Defaults mirror the designed footer so the frontend remains unchanged until
 * an administrator explicitly edits the settings.
 *
 * @return array<string, mixed>
 */
function custom_theme_footer_settings_defaults() {
	$footer_assets = get_template_directory_uri() . '/assets/images/footer/';

	return array(
		'cta' => array(
			'title'           => 'Your next regular starts here.',
			'text'            => 'Set up your loyalty program or talk to our team about onboarding.',
			'primary_label'   => 'Get started',
			'primary_url'     => home_url( '/#get-started' ),
			'secondary_label' => 'Talk to us',
			'secondary_url'   => '#',
		),
		'brand' => array(
			'logo_id'  => 0,
			'logo_url' => $footer_assets . 'iperq-logo-white.svg',
			'text'     => 'IPERQ is the digital loyalty platform for businesses and their customers. It connects your loyalty program with a cashier app for your team and a customer app for collecting stamps, earning points and redeeming rewards.',
			'socials'  => array(
				array(
					'label'    => 'Facebook',
					'url'      => '#',
					'icon_id'  => 0,
					'icon_url' => $footer_assets . 'facebook.svg',
				),
				array(
					'label'    => 'LinkedIn',
					'url'      => '#',
					'icon_id'  => 0,
					'icon_url' => $footer_assets . 'linkedin.svg',
				),
				array(
					'label'    => 'Twitter',
					'url'      => '#',
					'icon_id'  => 0,
					'icon_url' => $footer_assets . 'twitter.svg',
				),
			),
		),
		'columns' => array(
			'business' => array(
				'title'     => 'For Businesses',
				'title_url' => '',
				'links'     => array(
					array( 'label' => 'How It Works', 'url' => home_url( '/#how' ) ),
					array( 'label' => 'Loyalty Programs', 'url' => home_url( '/#get-started' ) ),
					array( 'label' => 'Cashier App', 'url' => home_url( '/#walkthrough' ) ),
					array( 'label' => 'Business Analytics', 'url' => home_url( '/#analytics' ) ),
					array( 'label' => 'Customer Experience', 'url' => '#' ),
				),
			),
			'customers' => array(
				'title'     => 'For Customers',
				'title_url' => '',
				'links'     => array(
					array( 'label' => 'Section 1', 'url' => '#' ),
					array( 'label' => 'Section 2', 'url' => '#' ),
					array( 'label' => 'Section 3', 'url' => '#' ),
				),
			),
			'other' => array(
				'title'     => 'Other',
				'title_url' => '',
				'links'     => array(
					array( 'label' => 'Pricing', 'url' => home_url( '/pricing/' ) ),
					array( 'label' => 'Contact', 'url' => '#' ),
					array( 'label' => 'Terms of Service', 'url' => '#' ),
					array( 'label' => 'Privacy Policy & Cookies', 'url' => '#' ),
				),
			),
		),
		'newsletter' => array(
			'title'     => 'Newsletter',
			'title_url' => '',
			'text'      => 'Curious about new developments & updates? Sign up for our newsletter!',
			'shortcode' => '',
		),
	);
}

/**
 * Return saved footer settings merged with defaults.
 *
 * Repeater arrays are intentionally replaced (rather than recursively merged)
 * so removing rows in the admin does not re-introduce default rows.
 *
 * @return array<string, mixed>
 */
function custom_theme_get_footer_settings() {
	$defaults = custom_theme_footer_settings_defaults();
	$saved    = get_option( 'iperq_footer_settings', array() );

	if ( ! is_array( $saved ) || empty( $saved ) ) {
		return $defaults;
	}

	$settings = $defaults;

	if ( isset( $saved['cta'] ) && is_array( $saved['cta'] ) ) {
		$settings['cta'] = array_replace( $defaults['cta'], $saved['cta'] );
	}

	if ( isset( $saved['brand'] ) && is_array( $saved['brand'] ) ) {
		$settings['brand'] = array_replace( $defaults['brand'], $saved['brand'] );
		if ( array_key_exists( 'socials', $saved['brand'] ) ) {
			$settings['brand']['socials'] = is_array( $saved['brand']['socials'] ) ? $saved['brand']['socials'] : array();
		}
	}

	if ( isset( $saved['columns'] ) && is_array( $saved['columns'] ) ) {
		foreach ( array( 'business', 'customers', 'other' ) as $column_key ) {
			if ( ! isset( $saved['columns'][ $column_key ] ) || ! is_array( $saved['columns'][ $column_key ] ) ) {
				continue;
			}

			$settings['columns'][ $column_key ] = array_replace(
				$defaults['columns'][ $column_key ],
				$saved['columns'][ $column_key ]
			);

			if ( array_key_exists( 'links', $saved['columns'][ $column_key ] ) ) {
				$settings['columns'][ $column_key ]['links'] = is_array( $saved['columns'][ $column_key ]['links'] )
					? $saved['columns'][ $column_key ]['links']
					: array();
			}
		}
	}

	if ( isset( $saved['newsletter'] ) && is_array( $saved['newsletter'] ) ) {
		$settings['newsletter'] = array_replace( $defaults['newsletter'], $saved['newsletter'] );
	}

	return $settings;
}

/**
 * Resolve an image URL from a Media Library attachment with a fallback URL.
 *
 * @param int    $attachment_id Media attachment ID.
 * @param string $fallback_url  Stored/default URL.
 * @return string
 */
function custom_theme_footer_image_url( $attachment_id, $fallback_url ) {
	$attachment_id = absint( $attachment_id );

	if ( $attachment_id ) {
		$attachment_url = wp_get_attachment_image_url( $attachment_id, 'full' );
		if ( $attachment_url ) {
			return $attachment_url;
		}
	}

	return (string) $fallback_url;
}


/**
 * Sanitize a frontend URL while allowing local anchors used by the design.
 *
 * @param mixed $url Raw URL.
 * @return string
 */
function custom_theme_sanitize_footer_url( $url ) {
	$url = trim( (string) $url );

	if ( '' === $url ) {
		return '';
	}

	if ( 0 === strpos( $url, '#' ) ) {
		return sanitize_text_field( $url );
	}

	return esc_url_raw( $url );
}

/**
 * Sanitize a footer link repeater.
 *
 * @param mixed $rows Submitted rows.
 * @return array<int, array<string, string>>
 */
function custom_theme_sanitize_footer_links( $rows ) {
	$clean = array();

	if ( ! is_array( $rows ) ) {
		return $clean;
	}

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$label = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
		$url   = isset( $row['url'] ) ? custom_theme_sanitize_footer_url( $row['url'] ) : '';

		if ( '' === $label && '' === $url ) {
			continue;
		}

		$clean[] = array(
			'label' => $label,
			'url'   => $url,
		);
	}

	return $clean;
}

/**
 * Sanitize social icon repeater rows.
 *
 * @param mixed $rows Submitted rows.
 * @return array<int, array<string, mixed>>
 */
function custom_theme_sanitize_footer_socials( $rows ) {
	$clean = array();

	if ( ! is_array( $rows ) ) {
		return $clean;
	}

	foreach ( $rows as $row ) {
		if ( ! is_array( $row ) ) {
			continue;
		}

		$label    = isset( $row['label'] ) ? sanitize_text_field( $row['label'] ) : '';
		$url      = isset( $row['url'] ) ? custom_theme_sanitize_footer_url( $row['url'] ) : '';
		$icon_id  = isset( $row['icon_id'] ) ? absint( $row['icon_id'] ) : 0;
		$icon_url = isset( $row['icon_url'] ) ? esc_url_raw( trim( (string) $row['icon_url'] ) ) : '';

		if ( '' === $label && '' === $url && ! $icon_id && '' === $icon_url ) {
			continue;
		}

		$clean[] = array(
			'label'    => $label,
			'url'      => $url,
			'icon_id'  => $icon_id,
			'icon_url' => $icon_url,
		);
	}

	return $clean;
}

/**
 * Sanitize the complete footer settings option.
 *
 * @param mixed $input Submitted option value.
 * @return array<string, mixed>
 */
function custom_theme_sanitize_footer_settings( $input ) {
	$input = is_array( $input ) ? $input : array();

	$cta        = isset( $input['cta'] ) && is_array( $input['cta'] ) ? $input['cta'] : array();
	$brand      = isset( $input['brand'] ) && is_array( $input['brand'] ) ? $input['brand'] : array();
	$columns    = isset( $input['columns'] ) && is_array( $input['columns'] ) ? $input['columns'] : array();
	$newsletter = isset( $input['newsletter'] ) && is_array( $input['newsletter'] ) ? $input['newsletter'] : array();

	$clean = array(
		'cta' => array(
			'title'           => isset( $cta['title'] ) ? sanitize_text_field( $cta['title'] ) : '',
			'text'            => isset( $cta['text'] ) ? sanitize_textarea_field( $cta['text'] ) : '',
			'primary_label'   => isset( $cta['primary_label'] ) ? sanitize_text_field( $cta['primary_label'] ) : '',
			'primary_url'     => isset( $cta['primary_url'] ) ? custom_theme_sanitize_footer_url( $cta['primary_url'] ) : '',
			'secondary_label' => isset( $cta['secondary_label'] ) ? sanitize_text_field( $cta['secondary_label'] ) : '',
			'secondary_url'   => isset( $cta['secondary_url'] ) ? custom_theme_sanitize_footer_url( $cta['secondary_url'] ) : '',
		),
		'brand' => array(
			'logo_id'  => isset( $brand['logo_id'] ) ? absint( $brand['logo_id'] ) : 0,
			'logo_url' => isset( $brand['logo_url'] ) ? esc_url_raw( trim( (string) $brand['logo_url'] ) ) : '',
			'text'     => isset( $brand['text'] ) ? sanitize_textarea_field( $brand['text'] ) : '',
			'socials'  => custom_theme_sanitize_footer_socials( isset( $brand['socials'] ) ? $brand['socials'] : array() ),
		),
		'columns' => array(),
		'newsletter' => array(
			'title'     => isset( $newsletter['title'] ) ? sanitize_text_field( $newsletter['title'] ) : '',
			'title_url' => isset( $newsletter['title_url'] ) ? custom_theme_sanitize_footer_url( $newsletter['title_url'] ) : '',
			'text'      => isset( $newsletter['text'] ) ? sanitize_textarea_field( $newsletter['text'] ) : '',
			'shortcode' => isset( $newsletter['shortcode'] ) ? sanitize_textarea_field( $newsletter['shortcode'] ) : '',
		),
	);

	foreach ( array( 'business', 'customers', 'other' ) as $column_key ) {
		$column = isset( $columns[ $column_key ] ) && is_array( $columns[ $column_key ] )
			? $columns[ $column_key ]
			: array();

		$clean['columns'][ $column_key ] = array(
			'title'     => isset( $column['title'] ) ? sanitize_text_field( $column['title'] ) : '',
			'title_url' => isset( $column['title_url'] ) ? custom_theme_sanitize_footer_url( $column['title_url'] ) : '',
			'links'     => custom_theme_sanitize_footer_links( isset( $column['links'] ) ? $column['links'] : array() ),
		);
	}

	return $clean;
}

/**
 * Register the single structured footer option.
 */
function custom_theme_register_footer_settings() {
	register_setting(
		'iperq_footer_settings_group',
		'iperq_footer_settings',
		array(
			'type'              => 'array',
			'sanitize_callback' => 'custom_theme_sanitize_footer_settings',
			'default'           => custom_theme_footer_settings_defaults(),
		)
	);
}
add_action( 'admin_init', 'custom_theme_register_footer_settings' );

/**
 * Add Settings > Footer.
 */
function custom_theme_add_footer_settings_page() {
	add_options_page(
		__( 'Footer', 'custom-theme' ),
		__( 'Footer', 'custom-theme' ),
		'manage_options',
		'iperq-footer-settings',
		'custom_theme_render_footer_settings_page'
	);
}
add_action( 'admin_menu', 'custom_theme_add_footer_settings_page' );

/**
 * Load admin assets only on Settings > Footer.
 *
 * @param string $hook_suffix Current admin page hook.
 */
function custom_theme_footer_settings_admin_assets( $hook_suffix ) {
	if ( 'settings_page_iperq-footer-settings' !== $hook_suffix ) {
		return;
	}

	wp_enqueue_media();

	wp_enqueue_style(
		'custom-theme-footer-settings',
		get_template_directory_uri() . '/assets/css/admin-component-settings.css',
		array(),
		CUSTOM_THEME_VERSION
	);

	wp_enqueue_script(
		'custom-theme-footer-settings',
		get_template_directory_uri() . '/assets/js/admin-footer-settings.js',
		array( 'jquery', 'jquery-ui-sortable' ),
		CUSTOM_THEME_VERSION,
		true
	);
}
add_action( 'admin_enqueue_scripts', 'custom_theme_footer_settings_admin_assets' );

/**
 * Render a standard text field.
 *
 * @param string $label Field label.
 * @param string $name  Input name.
 * @param string $value Current value.
 * @param string $type  Input type.
 * @param string $help  Optional help text.
 */
function custom_theme_footer_admin_text_field( $label, $name, $value, $type = 'text', $help = '' ) {
	?>
	<label class="iperq-field">
		<span class="iperq-field__label"><?php echo esc_html( $label ); ?></span>
		<input class="regular-text" type="<?php echo esc_attr( $type ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $value ); ?>">
		<?php if ( $help ) : ?>
			<span class="iperq-field__help"><?php echo esc_html( $help ); ?></span>
		<?php endif; ?>
	</label>
	<?php
}

/**
 * Render a textarea field.
 *
 * @param string $label Field label.
 * @param string $name  Input name.
 * @param string $value Current value.
 * @param int    $rows  Rows.
 * @param string $help  Optional help text.
 */
function custom_theme_footer_admin_textarea( $label, $name, $value, $rows = 4, $help = '' ) {
	?>
	<label class="iperq-field">
		<span class="iperq-field__label"><?php echo esc_html( $label ); ?></span>
		<textarea class="large-text" rows="<?php echo esc_attr( $rows ); ?>" name="<?php echo esc_attr( $name ); ?>"><?php echo esc_textarea( $value ); ?></textarea>
		<?php if ( $help ) : ?>
			<span class="iperq-field__help"><?php echo esc_html( $help ); ?></span>
		<?php endif; ?>
	</label>
	<?php
}

/**
 * Render a reusable Media Library image field.
 *
 * @param string $label     Label.
 * @param string $id_name   Attachment ID field name.
 * @param string $url_name  Image URL field name.
 * @param int    $image_id  Attachment ID.
 * @param string $image_url Image URL.
 * @param string $variant   CSS variant.
 * @param string $help      Optional helper text.
 */
function custom_theme_footer_admin_media_field( $label, $id_name, $url_name, $image_id, $image_url, $variant = 'logo', $help = '' ) {
	?>
	<div class="iperq-field iperq-media-field" data-media-field>
		<span class="iperq-field__label"><?php echo esc_html( $label ); ?></span>
		<div class="iperq-media-field__control">
			<div class="iperq-media-preview iperq-media-preview--<?php echo esc_attr( $variant ); ?>" data-media-preview>
				<?php if ( $image_url ) : ?>
					<img src="<?php echo esc_url( $image_url ); ?>" alt="">
				<?php else : ?>
					<span><?php esc_html_e( 'No image selected', 'custom-theme' ); ?></span>
				<?php endif; ?>
			</div>
			<div class="iperq-media-field__actions">
				<input type="hidden" data-media-id name="<?php echo esc_attr( $id_name ); ?>" value="<?php echo esc_attr( $image_id ); ?>">
				<input type="hidden" data-media-url name="<?php echo esc_attr( $url_name ); ?>" value="<?php echo esc_attr( $image_url ); ?>">
				<button type="button" class="button iperq-media-select"><span class="dashicons dashicons-format-image" aria-hidden="true"></span><?php esc_html_e( 'Choose image', 'custom-theme' ); ?></button>
				<button type="button" class="button-link-delete iperq-media-remove"><?php esc_html_e( 'Remove', 'custom-theme' ); ?></button>
				<?php if ( $help ) : ?>
					<span class="iperq-field__help"><?php echo esc_html( $help ); ?></span>
				<?php endif; ?>
			</div>
		</div>
	</div>
	<?php
}

/**
 * Render a settings section header.
 *
 * @param string $number      Section number.
 * @param string $title       Section title.
 * @param string $description Short description.
 */
function custom_theme_footer_admin_section_header( $number, $title, $description ) {
	?>
	<div class="iperq-settings-card__header">
		<div class="iperq-settings-card__index"><?php echo esc_html( $number ); ?></div>
		<div>
			<h2><?php echo esc_html( $title ); ?></h2>
			<?php if ( $description ) : ?>
				<p><?php echo esc_html( $description ); ?></p>
			<?php endif; ?>
		</div>
	</div>
	<?php
}

/**
 * Render heading fields shared by footer columns.
 *
 * @param string $column_key Column key.
 * @param array  $column     Column values.
 */
function custom_theme_footer_admin_column_heading( $column_key, $column ) {
	?>
	<div class="iperq-settings-fields iperq-settings-fields--two">
		<?php
		custom_theme_footer_admin_text_field(
			'Title',
			'iperq_footer_settings[columns][' . $column_key . '][title]',
			isset( $column['title'] ) ? $column['title'] : ''
		);
		custom_theme_footer_admin_text_field(
			'Title link (optional)',
			'iperq_footer_settings[columns][' . $column_key . '][title_url]',
			isset( $column['title_url'] ) ? $column['title_url'] : '',
			'text',
			'Leave empty when the green column title should not be clickable.'
		);
		?>
	</div>
	<?php
}

/**
 * Render one footer links repeater.
 *
 * @param string $column_key Column key.
 * @param array  $links      Link rows.
 */
function custom_theme_footer_admin_links_repeater( $column_key, $links ) {
	$links         = is_array( $links ) ? array_values( $links ) : array();
	$name_template = 'iperq_footer_settings[columns][' . $column_key . '][links][__INDEX__]';
	?>
	<div class="iperq-repeater" data-repeater>
		<div class="iperq-repeater__header">
			<div>
				<span class="iperq-field__label">Footer links</span>
				<span class="iperq-repeater__meta"><span data-repeater-count><?php echo esc_html( count( $links ) ); ?></span> items · drag to reorder</span>
			</div>
			<button type="button" class="button iperq-action-button iperq-repeater-add"><span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span><?php esc_html_e( 'Add link', 'custom-theme' ); ?></button>
		</div>

		<div class="iperq-repeater-empty" data-repeater-empty <?php echo ! empty( $links ) ? 'hidden' : ''; ?>>
			<span class="dashicons dashicons-admin-links" aria-hidden="true"></span>
			<strong><?php esc_html_e( 'No links yet', 'custom-theme' ); ?></strong>
			<span><?php esc_html_e( 'Add the first link for this footer column.', 'custom-theme' ); ?></span>
		</div>

		<div class="iperq-repeater-list" data-repeater-list>
			<?php foreach ( $links as $index => $link ) : ?>
				<div class="iperq-repeater-row" data-repeater-row>
					<button type="button" class="iperq-repeater__handle" title="<?php esc_attr_e( 'Drag to reorder', 'custom-theme' ); ?>" aria-label="<?php esc_attr_e( 'Drag to reorder', 'custom-theme' ); ?>"><span class="dashicons dashicons-menu"></span></button>
					<span class="iperq-repeater__number" data-row-number><?php echo esc_html( $index + 1 ); ?></span>
					<label>
						<span>Label</span>
						<input type="text" data-name-template="<?php echo esc_attr( $name_template . '[label]' ); ?>" name="<?php echo esc_attr( str_replace( '__INDEX__', (string) $index, $name_template ) . '[label]' ); ?>" value="<?php echo esc_attr( isset( $link['label'] ) ? $link['label'] : '' ); ?>">
					</label>
					<label class="iperq-repeater-row__url">
						<span>URL</span>
						<input type="text" data-name-template="<?php echo esc_attr( $name_template . '[url]' ); ?>" name="<?php echo esc_attr( str_replace( '__INDEX__', (string) $index, $name_template ) . '[url]' ); ?>" value="<?php echo esc_attr( isset( $link['url'] ) ? $link['url'] : '' ); ?>">
					</label>
					<button type="button" class="iperq-icon-button iperq-repeater-remove" title="<?php esc_attr_e( 'Remove link', 'custom-theme' ); ?>" aria-label="<?php esc_attr_e( 'Remove link', 'custom-theme' ); ?>"><span class="dashicons dashicons-trash"></span></button>
				</div>
			<?php endforeach; ?>
		</div>

		<template data-repeater-template>
			<div class="iperq-repeater-row" data-repeater-row>
				<button type="button" class="iperq-repeater__handle" title="<?php esc_attr_e( 'Drag to reorder', 'custom-theme' ); ?>" aria-label="<?php esc_attr_e( 'Drag to reorder', 'custom-theme' ); ?>"><span class="dashicons dashicons-menu"></span></button>
				<span class="iperq-repeater__number" data-row-number>1</span>
				<label>
					<span>Label</span>
					<input type="text" data-name-template="<?php echo esc_attr( $name_template . '[label]' ); ?>" name="" value="">
				</label>
				<label class="iperq-repeater-row__url">
					<span>URL</span>
					<input type="text" data-name-template="<?php echo esc_attr( $name_template . '[url]' ); ?>" name="" value="">
				</label>
				<button type="button" class="iperq-icon-button iperq-repeater-remove" title="<?php esc_attr_e( 'Remove link', 'custom-theme' ); ?>" aria-label="<?php esc_attr_e( 'Remove link', 'custom-theme' ); ?>"><span class="dashicons dashicons-trash"></span></button>
			</div>
		</template>
	</div>
	<?php
}

/**
 * Render the social icons repeater.
 *
 * @param array $socials Social rows.
 */
function custom_theme_footer_admin_socials_repeater( $socials ) {
	$socials       = is_array( $socials ) ? array_values( $socials ) : array();
	$name_template = 'iperq_footer_settings[brand][socials][__INDEX__]';
	?>
	<div class="iperq-repeater iperq-repeater--socials" data-repeater>
		<div class="iperq-repeater__header">
			<div>
				<span class="iperq-field__label">Social links</span>
				<span class="iperq-repeater__meta"><span data-repeater-count><?php echo esc_html( count( $socials ) ); ?></span> items · drag to reorder</span>
			</div>
			<button type="button" class="button iperq-action-button iperq-repeater-add"><span class="dashicons dashicons-plus-alt2" aria-hidden="true"></span><?php esc_html_e( 'Add social link', 'custom-theme' ); ?></button>
		</div>

		<div class="iperq-repeater-empty" data-repeater-empty <?php echo ! empty( $socials ) ? 'hidden' : ''; ?>>
			<span class="dashicons dashicons-share" aria-hidden="true"></span>
			<strong><?php esc_html_e( 'No social links yet', 'custom-theme' ); ?></strong>
			<span><?php esc_html_e( 'Add an icon, accessible label and destination URL.', 'custom-theme' ); ?></span>
		</div>

		<div class="iperq-repeater-list" data-repeater-list>
			<?php foreach ( $socials as $index => $social ) : ?>
				<div class="iperq-repeater-row iperq-social-row" data-repeater-row>
					<button type="button" class="iperq-repeater__handle" title="<?php esc_attr_e( 'Drag to reorder', 'custom-theme' ); ?>" aria-label="<?php esc_attr_e( 'Drag to reorder', 'custom-theme' ); ?>"><span class="dashicons dashicons-menu"></span></button>
					<span class="iperq-repeater__number" data-row-number><?php echo esc_html( $index + 1 ); ?></span>
					<div class="iperq-social-row__icon iperq-media-field" data-media-field>
						<div class="iperq-media-preview iperq-media-preview--icon" data-media-preview>
							<?php if ( ! empty( $social['icon_url'] ) ) : ?>
								<img src="<?php echo esc_url( $social['icon_url'] ); ?>" alt="">
							<?php else : ?>
								<span>Icon</span>
							<?php endif; ?>
						</div>
						<input type="hidden" data-media-id data-name-template="<?php echo esc_attr( $name_template . '[icon_id]' ); ?>" name="<?php echo esc_attr( str_replace( '__INDEX__', (string) $index, $name_template ) . '[icon_id]' ); ?>" value="<?php echo esc_attr( isset( $social['icon_id'] ) ? $social['icon_id'] : 0 ); ?>">
						<input type="hidden" data-media-url data-name-template="<?php echo esc_attr( $name_template . '[icon_url]' ); ?>" name="<?php echo esc_attr( str_replace( '__INDEX__', (string) $index, $name_template ) . '[icon_url]' ); ?>" value="<?php echo esc_attr( isset( $social['icon_url'] ) ? $social['icon_url'] : '' ); ?>">
						<button type="button" class="button iperq-media-select"><?php esc_html_e( 'Change', 'custom-theme' ); ?></button>
					</div>
					<label>
						<span>Label</span>
						<input type="text" data-name-template="<?php echo esc_attr( $name_template . '[label]' ); ?>" name="<?php echo esc_attr( str_replace( '__INDEX__', (string) $index, $name_template ) . '[label]' ); ?>" value="<?php echo esc_attr( isset( $social['label'] ) ? $social['label'] : '' ); ?>">
					</label>
					<label class="iperq-repeater-row__url">
						<span>URL</span>
						<input type="text" data-name-template="<?php echo esc_attr( $name_template . '[url]' ); ?>" name="<?php echo esc_attr( str_replace( '__INDEX__', (string) $index, $name_template ) . '[url]' ); ?>" value="<?php echo esc_attr( isset( $social['url'] ) ? $social['url'] : '' ); ?>">
					</label>
					<button type="button" class="iperq-icon-button iperq-repeater-remove" title="<?php esc_attr_e( 'Remove social link', 'custom-theme' ); ?>" aria-label="<?php esc_attr_e( 'Remove social link', 'custom-theme' ); ?>"><span class="dashicons dashicons-trash"></span></button>
				</div>
			<?php endforeach; ?>
		</div>

		<template data-repeater-template>
			<div class="iperq-repeater-row iperq-social-row" data-repeater-row>
				<button type="button" class="iperq-repeater__handle" title="<?php esc_attr_e( 'Drag to reorder', 'custom-theme' ); ?>" aria-label="<?php esc_attr_e( 'Drag to reorder', 'custom-theme' ); ?>"><span class="dashicons dashicons-menu"></span></button>
				<span class="iperq-repeater__number" data-row-number>1</span>
				<div class="iperq-social-row__icon iperq-media-field" data-media-field>
					<div class="iperq-media-preview iperq-media-preview--icon" data-media-preview><span>Icon</span></div>
					<input type="hidden" data-media-id data-name-template="<?php echo esc_attr( $name_template . '[icon_id]' ); ?>" name="" value="0">
					<input type="hidden" data-media-url data-name-template="<?php echo esc_attr( $name_template . '[icon_url]' ); ?>" name="" value="">
					<button type="button" class="button iperq-media-select"><?php esc_html_e( 'Choose', 'custom-theme' ); ?></button>
				</div>
				<label>
					<span>Label</span>
					<input type="text" data-name-template="<?php echo esc_attr( $name_template . '[label]' ); ?>" name="" value="">
				</label>
				<label class="iperq-repeater-row__url">
					<span>URL</span>
					<input type="text" data-name-template="<?php echo esc_attr( $name_template . '[url]' ); ?>" name="" value="">
				</label>
				<button type="button" class="iperq-icon-button iperq-repeater-remove" title="<?php esc_attr_e( 'Remove social link', 'custom-theme' ); ?>" aria-label="<?php esc_attr_e( 'Remove social link', 'custom-theme' ); ?>"><span class="dashicons dashicons-trash"></span></button>
			</div>
		</template>
	</div>
	<?php
}

/**
 * Render Settings > Footer.
 */
function custom_theme_render_footer_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}

	$settings = custom_theme_get_footer_settings();
	$logo_url = custom_theme_footer_image_url( $settings['brand']['logo_id'], $settings['brand']['logo_url'] );
	?>
	<div class="wrap iperq-footer-settings">
		<div class="iperq-admin-hero">
			<div class="iperq-admin-hero__content">
				<div class="iperq-admin-hero__eyebrow"><span class="dashicons dashicons-admin-appearance" aria-hidden="true"></span><?php esc_html_e( 'Global site component', 'custom-theme' ); ?></div>
				<h1><?php esc_html_e( 'Footer', 'custom-theme' ); ?></h1>
				<p><?php esc_html_e( 'Manage footer content while the theme protects layout, spacing, typography and responsive behaviour.', 'custom-theme' ); ?></p>
			</div>
			<div class="iperq-admin-hero__actions">
				<span class="iperq-status-pill"><span class="iperq-status-pill__dot"></span><?php esc_html_e( 'Design locked', 'custom-theme' ); ?></span>
				<a class="button iperq-view-site" href="<?php echo esc_url( home_url( '/' ) ); ?>" target="_blank" rel="noopener noreferrer"><span class="dashicons dashicons-external" aria-hidden="true"></span><?php esc_html_e( 'View site', 'custom-theme' ); ?></a>
			</div>
		</div>

		<?php settings_errors(); ?>

		<form action="options.php" method="post" data-footer-settings-form>
			<?php settings_fields( 'iperq_footer_settings_group' ); ?>

			<div class="iperq-settings-shell">
				<aside class="iperq-settings-sidebar" aria-label="<?php esc_attr_e( 'Footer sections', 'custom-theme' ); ?>">
					<div class="iperq-settings-sidebar__inner">
						<span class="iperq-settings-sidebar__title"><?php esc_html_e( 'Footer sections', 'custom-theme' ); ?></span>
						<nav class="iperq-settings-nav">
							<a href="#footer-cta" class="is-active"><span>01</span><?php esc_html_e( 'CTA', 'custom-theme' ); ?></a>
							<a href="#footer-brand"><span>02</span><?php esc_html_e( 'Brand & socials', 'custom-theme' ); ?></a>
							<a href="#footer-business"><span>03</span><?php esc_html_e( 'For Businesses', 'custom-theme' ); ?></a>
							<a href="#footer-customers"><span>04</span><?php esc_html_e( 'For Customers', 'custom-theme' ); ?></a>
							<a href="#footer-other"><span>05</span><?php esc_html_e( 'Other', 'custom-theme' ); ?></a>
							<a href="#footer-newsletter"><span>06</span><?php esc_html_e( 'Newsletter', 'custom-theme' ); ?></a>
						</nav>
						<div class="iperq-settings-sidebar__note">
							<span class="dashicons dashicons-lock" aria-hidden="true"></span>
							<div>
								<strong><?php esc_html_e( 'Content only', 'custom-theme' ); ?></strong>
								<p><?php esc_html_e( 'Visual design stays controlled by the theme.', 'custom-theme' ); ?></p>
							</div>
						</div>
					</div>
				</aside>

				<main class="iperq-settings-content">
					<section id="footer-cta" class="iperq-settings-card" data-settings-section>
						<?php custom_theme_footer_admin_section_header( '01', 'Footer CTA', 'Edit the call-to-action card shown immediately above the footer.' ); ?>
						<div class="iperq-card-grid iperq-card-grid--cta">
							<div class="iperq-subcard">
								<div class="iperq-subcard__title"><span class="dashicons dashicons-edit" aria-hidden="true"></span>Content</div>
								<?php custom_theme_footer_admin_text_field( 'Heading', 'iperq_footer_settings[cta][title]', $settings['cta']['title'] ); ?>
								<?php custom_theme_footer_admin_textarea( 'Supporting text', 'iperq_footer_settings[cta][text]', $settings['cta']['text'], 4 ); ?>
							</div>
							<div class="iperq-subcard">
								<div class="iperq-subcard__title"><span class="dashicons dashicons-admin-links" aria-hidden="true"></span>Buttons</div>
								<div class="iperq-button-config">
									<span class="iperq-button-config__badge iperq-button-config__badge--primary">Primary</span>
									<div class="iperq-settings-fields iperq-settings-fields--two">
										<?php custom_theme_footer_admin_text_field( 'Label', 'iperq_footer_settings[cta][primary_label]', $settings['cta']['primary_label'] ); ?>
										<?php custom_theme_footer_admin_text_field( 'URL', 'iperq_footer_settings[cta][primary_url]', $settings['cta']['primary_url'], 'text' ); ?>
									</div>
								</div>
								<div class="iperq-button-config">
									<span class="iperq-button-config__badge">Secondary</span>
									<div class="iperq-settings-fields iperq-settings-fields--two">
										<?php custom_theme_footer_admin_text_field( 'Label', 'iperq_footer_settings[cta][secondary_label]', $settings['cta']['secondary_label'] ); ?>
										<?php custom_theme_footer_admin_text_field( 'URL', 'iperq_footer_settings[cta][secondary_url]', $settings['cta']['secondary_url'], 'text' ); ?>
									</div>
								</div>
							</div>
						</div>
					</section>

					<section id="footer-brand" class="iperq-settings-card" data-settings-section>
						<?php custom_theme_footer_admin_section_header( '02', 'Brand & socials', 'Manage the first footer column: logo, description and social profiles.' ); ?>
						<div class="iperq-card-grid iperq-card-grid--brand">
							<div class="iperq-subcard iperq-subcard--media">
								<?php
								custom_theme_footer_admin_media_field(
									'Logo',
									'iperq_footer_settings[brand][logo_id]',
									'iperq_footer_settings[brand][logo_url]',
									$settings['brand']['logo_id'],
									$logo_url,
									'logo',
									'Use a transparent logo for best results on the dark footer background.'
								);
								?>
							</div>
							<div class="iperq-subcard">
								<?php custom_theme_footer_admin_textarea( 'Brand description', 'iperq_footer_settings[brand][text]', $settings['brand']['text'], 7, 'Keep this concise; the frontend column has a fixed designed width.' ); ?>
							</div>
						</div>
						<?php custom_theme_footer_admin_socials_repeater( $settings['brand']['socials'] ); ?>
					</section>

					<?php
					$column_labels = array(
						'business'  => array( 'number' => '03', 'name' => 'For Businesses', 'description' => 'Manage the heading and navigation links in the business column.' ),
						'customers' => array( 'number' => '04', 'name' => 'For Customers', 'description' => 'Manage the heading and navigation links in the customer column.' ),
						'other'     => array( 'number' => '05', 'name' => 'Other', 'description' => 'Manage utility links such as pricing, contact and legal pages.' ),
					);
					foreach ( $column_labels as $column_key => $meta ) :
						$column = $settings['columns'][ $column_key ];
						?>
						<section id="footer-<?php echo esc_attr( $column_key ); ?>" class="iperq-settings-card" data-settings-section>
							<?php custom_theme_footer_admin_section_header( $meta['number'], $meta['name'], $meta['description'] ); ?>
							<?php custom_theme_footer_admin_column_heading( $column_key, $column ); ?>
							<?php custom_theme_footer_admin_links_repeater( $column_key, $column['links'] ); ?>
						</section>
					<?php endforeach; ?>

					<section id="footer-newsletter" class="iperq-settings-card" data-settings-section>
						<?php custom_theme_footer_admin_section_header( '06', 'Newsletter', 'Edit the final footer column and optionally render a form or integration via shortcode.' ); ?>
						<div class="iperq-settings-fields iperq-settings-fields--two">
							<?php custom_theme_footer_admin_text_field( 'Title', 'iperq_footer_settings[newsletter][title]', $settings['newsletter']['title'] ); ?>
							<?php custom_theme_footer_admin_text_field( 'Title link (optional)', 'iperq_footer_settings[newsletter][title_url]', $settings['newsletter']['title_url'], 'text', 'Leave empty when the green title should not be clickable.' ); ?>
						</div>
						<div class="iperq-card-grid iperq-card-grid--newsletter">
							<div class="iperq-subcard">
								<?php custom_theme_footer_admin_textarea( 'Newsletter text', 'iperq_footer_settings[newsletter][text]', $settings['newsletter']['text'], 5 ); ?>
							</div>
							<div class="iperq-subcard iperq-subcard--code">
								<?php custom_theme_footer_admin_textarea( 'Shortcode', 'iperq_footer_settings[newsletter][shortcode]', $settings['newsletter']['shortcode'], 5, 'Optional. Paste a form shortcode here; leave empty to show only the title and text.' ); ?>
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
						<span><?php esc_html_e( 'Frontend styling remains controlled by the theme.', 'custom-theme' ); ?></span>
					</div>
				</div>
				<?php submit_button( __( 'Save footer', 'custom-theme' ), 'primary', 'submit', false ); ?>
			</div>
		</form>
	</div>
	<?php
}
