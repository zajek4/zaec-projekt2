<?php
/**
 * Zajednički markup zaglavlja.
 *
 * @package Custom_Theme
 */
?>
<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Preskoči na sadržaj', 'custom-theme' ); ?></a>

<header id="masthead" class="site-header">
	<div class="container">
		<div class="site-branding">
			<?php if ( has_custom_logo() ) : ?>
				<?php the_custom_logo(); ?>
			<?php else : ?>
				<?php if ( is_front_page() && is_home() ) : ?>
					<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
				<?php else : ?>
					<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
				<?php endif; ?>

				<?php
				$custom_theme_description = get_bloginfo( 'description', 'display' );
				if ( $custom_theme_description || is_customize_preview() ) :
					?>
					<p class="site-description"><?php echo esc_html( $custom_theme_description ); ?></p>
				<?php endif; ?>
			<?php endif; ?>
		</div>

		<nav id="site-navigation" class="main-navigation" aria-label="<?php esc_attr_e( 'Glavni izbornik', 'custom-theme' ); ?>">
			<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php esc_html_e( 'Izbornik', 'custom-theme' ); ?></button>
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
					'fallback_cb'    => false,
				)
			);
			?>
		</nav>
	</div>
</header>
