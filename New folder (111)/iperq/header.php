<?php
/**
 * Global IPERQ site header.
 *
 * @package Custom_Theme
 */

$is_business_landing = custom_theme_is_business_landing();
$is_full_width_layout = custom_theme_is_full_width_layout();
$header_logo_url      = custom_theme_get_header_logo_url();
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<style>
		html, body {
			background: #2d0048;
		}
		@media screen and (max-width: 600px){
			body {
			background: #1D0035;
			}
		}
	</style>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site iperq-site<?php echo $is_business_landing ? ' business-page' : ''; ?>">
	<header class="biz-header" aria-label="Primary navigation">
		<div class="container biz-header__container">
			<nav class="biz-nav" aria-label="Main navigation">
				<div class="biz-nav__group biz-nav__group--left" id="business-menu">
					<?php if ( has_nav_menu( 'header_left' ) ) : ?>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_left',
								'container'      => false,
								'menu_class'     => 'biz-nav__menu biz-nav__menu--left',
								'menu_id'        => 'header-menu-1',
								'depth'          => 2,
								'fallback_cb'    => false,
							)
						);
						?>
					<?php else : ?>
						<ul class="biz-nav__menu biz-nav__menu--left" id="header-menu-1">
							<li class="menu-item menu-item-has-children">
								<a href="<?php echo esc_url( home_url( '/#how' ) ); ?>">For Businesses</a>
								<ul class="sub-menu">
									<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#how' ) ); ?>">How It Works</a></li>
									<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#get-started' ) ); ?>">Loyalty Programs</a></li>
									<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#walkthrough' ) ); ?>">Cashier App</a></li>
									<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#analytics' ) ); ?>">Business Analytics</a></li>
									<li class="menu-item"><a href="#">Customer Experience</a></li>
								</ul>
							</li>
							<li class="menu-item"><a href="<?php echo esc_url( home_url( '/for-customers/' ) ); ?>">For Customers</a></li>
							<li class="menu-item"><a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">Pricing</a></li>
						</ul>
					<?php endif; ?>
				</div>

				<a class="biz-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="IPERQ home">
					<span class="biz-logo__mark" style="<?php echo esc_attr( '--iperq-header-logo: url(' . esc_url( $header_logo_url ) . ')' ); ?>" aria-hidden="true"></span>
				</a>

				<div class="biz-nav__group biz-nav__group--right">
					<?php if ( has_nav_menu( 'header_right' ) ) : ?>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_right',
								'container'      => false,
								'menu_class'     => 'biz-nav__menu biz-nav__menu--right',
								'menu_id'        => 'header-menu-2',
								'depth'          => 2,
								'fallback_cb'    => false,
							)
						);
						?>
					<?php endif; ?>

					<div class="biz-nav__actions">
						<a class="biz-nav__action biz-nav__login" href="#">Log in</a>
						<a class="biz-nav__action biz-nav__started" href="<?php echo esc_url( home_url( '/#get-started' ) ); ?>">
							<span>Get Started</span>
							<img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/footer/arrow-right.svg' ); ?>" alt="">
						</a>
					</div>
				</div>

				<button class="biz-menu-toggle" type="button" aria-expanded="false" aria-controls="business-mobile-menu" aria-label="Open navigation">
					<svg class="biz-menu-icon" width="36" height="36" viewBox="0 0 36 36" fill="none" aria-hidden="true" focusable="false">
						<path class="biz-menu-icon__line biz-menu-icon__line--top" d="M15 9H30" />
						<path class="biz-menu-icon__line biz-menu-icon__line--middle" d="M6 18H30" />
						<path class="biz-menu-icon__line biz-menu-icon__line--bottom" d="M6 27H21" />
					</svg>
					<span class="biz-menu-toggle__label" aria-hidden="true">MENU</span>
				</button>
			</nav>

			<div class="biz-mobile-panel" id="business-mobile-menu" aria-hidden="true">
			<div class="biz-mobile-panel__inner">
				<nav class="biz-mobile-nav" aria-label="Mobile navigation">
					<?php if ( has_nav_menu( 'header_left' ) ) : ?>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_left',
								'container'      => false,
								'menu_class'     => 'biz-mobile-nav__menu biz-mobile-nav__menu--primary',
								'menu_id'        => 'mobile-header-menu-1',
								'depth'          => 2,
								'fallback_cb'    => false,
							)
						);
						?>
					<?php else : ?>
						<ul class="biz-mobile-nav__menu biz-mobile-nav__menu--primary" id="mobile-header-menu-1">
							<li class="menu-item menu-item-has-children">
								<a href="<?php echo esc_url( home_url( '/#how' ) ); ?>">For Businesses</a>
								<ul class="sub-menu">
									<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#how' ) ); ?>">How It Works</a></li>
									<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#get-started' ) ); ?>">Loyalty Programs</a></li>
									<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#walkthrough' ) ); ?>">Cashier App</a></li>
									<li class="menu-item"><a href="<?php echo esc_url( home_url( '/#analytics' ) ); ?>">Business Analytics</a></li>
									<li class="menu-item"><a href="#">Customer Experience</a></li>
								</ul>
							</li>
							<li class="menu-item"><a href="<?php echo esc_url( home_url( '/for-customers/' ) ); ?>">For Customers</a></li>
							<li class="menu-item"><a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>">Pricing</a></li>
						</ul>
					<?php endif; ?>

					<?php if ( has_nav_menu( 'header_right' ) ) : ?>
						<?php
						wp_nav_menu(
							array(
								'theme_location' => 'header_right',
								'container'      => false,
								'menu_class'     => 'biz-mobile-nav__menu biz-mobile-nav__menu--secondary',
								'menu_id'        => 'mobile-header-menu-2',
								'depth'          => 2,
								'fallback_cb'    => false,
							)
						);
						?>
					<?php endif; ?>

					<a class="biz-mobile-nav__login" href="#">Log in</a>
				</nav>
			</div>
		</div>
		</div>
	</header>

	<div class="biz-header-spacer" aria-hidden="true"></div>

	<?php if ( ! $is_full_width_layout ) : ?>
		<div id="content" class="site-content">
			<div class="container">
	<?php endif; ?>
